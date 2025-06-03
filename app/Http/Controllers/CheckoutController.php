<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;

class CheckoutController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                config('paypal.client_id'),
                config('paypal.secret')
            )
        );
        
        $this->apiContext->setConfig(config('paypal.settings'));
    }

    public function index()
    {
        $cartItems = Cart::with('product')
                   ->where('user_id', Auth::id())
                   ->get();

        if($cartItems->isEmpty()){
            return redirect()->route('home')->with('error', 'There are no Products to be purchased.');
        }
    
        return view('checkout', compact('cartItems'));
    }

    public function confirmation(Order $order)
    {
        return view('home', compact('order'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:credit_card,mada,paypal',
        ]);

        if ($request->payment_method === 'paypal') {
            return $this->processPaypalPayment($request);
        }

        // Process credit card or mada payment (original code)
        return DB::transaction(function () use ($request) {
            $user = Auth::user();
            $cartItems =  Cart::with('product')
                ->where('user_id', Auth::id())
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Your shopping cart is empty!');
            }

            if (!is_countable($cartItems)) {
                return redirect()->back()->with('error', 'Invalid cart data.');
            }

            foreach ($cartItems as $item) {
                $product = $item->product;
            
                if (!$product) {
                    return redirect()->back()->with('error', 'An error occurred: The product is not in the cart!');
                }
                
                if ($product->stock_quantity == 0) {
                    return redirect()->back()
                        ->with('error', "This product has already expired.");
                }elseif($product->stock_quantity < $item->quantity){
                    return redirect()->back()
                        ->with('error', "Only {$product->stock_quantity} {$product->product_name} available");
                }
            }

            $order = Order::create([
                'user_id' => $user->id,
                'total' => $cartItems->sum(function ($item) {
                    return $item->product->regular_price * $item->quantity;
                }),
                'payment_method' => $request->payment_method,
                'payment_status' => 'completed'
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->regular_price
                ]);

                $item->product->decrement('stock_quantity', $item->quantity);
            }

            Cart::where('user_id', Auth::id())->delete();

            session()->flash('success', 'Your purchase was successful');

            return redirect()->route('home');
        });
    }

    protected function processPaypalPayment(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $user = Auth::user();
            $cartItems = Cart::with('product')
                ->where('user_id', Auth::id())
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Your shopping cart is empty!');
            }

            foreach ($cartItems as $item) {
                $product = $item->product;
            
                if (!$product) {
                    return redirect()->back()->with('error', 'An error occurred: The product is not in the cart!');
                }
                
                if ($product->stock_quantity == 0) {
                    return redirect()->back()
                        ->with('error', "This product has already expired.");
                } elseif ($product->stock_quantity < $item->quantity) {
                    return redirect()->back()
                        ->with('error', "Only {$product->stock_quantity} {$product->product_name} available");
                }
            }

            $total = $cartItems->sum(function ($item) {
                return $item->product->regular_price * $item->quantity;
            });

            // Create PayPal payment
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $amount = new Amount();
            $amount->setCurrency('USD')
            ->setTotal(number_format($total, 2, '.', ''));

            $transaction = new Transaction();
            $transaction->setAmount($amount)
                       ->setDescription('Payment for order');

            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl(route('paypal.success'))
                         ->setCancelUrl(route('paypal.cancel'));

            $payment = new Payment();
            $payment->setIntent('sale')
                   ->setPayer($payer)
                   ->setTransactions([$transaction])
                   ->setRedirectUrls($redirectUrls);

            try {
                $payment->create($this->apiContext);
                
                // Store order data temporarily before payment completion
                $orderData = [
                    'user_id' => $user->id,
                    'total' => $total,
                    'payment_method' => 'paypal',
                    'payment_status' => 'pending',
                    'paypal_payment_id' => $payment->getId()
                ];
                
                session()->put('pending_order', $orderData);
                session()->put('cart_items', $cartItems);

                return redirect($payment->getApprovalLink());
            } catch (PayPalConnectionException $ex) {
                return redirect()->back()->with('error', 'Connection error with PayPal: ' . $ex->getMessage());
            } catch (\Exception $ex) {
                return redirect()->back()->with('error', 'Error processing PayPal payment: ' . $ex->getMessage());
            }
        });
    }

    public function paypalSuccess(Request $request)
    {
        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');
        
        if (empty($paymentId) || empty($payerId)) {
            return redirect()->route('checkout')->with('error', 'Payment failed.');
        }

        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            $result = $payment->execute($execution, $this->apiContext);
            
            if ($result->getState() === 'approved') {
                $orderData = session()->get('pending_order');
                $cartItems = session()->get('cart_items');
                
                $order = Order::create([
                    'user_id' => $orderData['user_id'],
                    'total' => $orderData['total'],
                    'payment_method' => 'paypal',
                    'payment_status' => 'completed',
                    'paypal_payment_id' => $orderData['paypal_payment_id']
                ]);
                
                foreach ($cartItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->product->regular_price
                    ]);

                    $item->product->decrement('stock_quantity', $item->quantity);
                }

                Cart::where('user_id', Auth::id())->delete();
                
                session()->forget(['pending_order', 'cart_items']);
                
                return redirect()->route('home')->with('success', 'Payment completed successfully!');
            }
        } catch (\Exception $ex) {
            return redirect()->route('checkout')->with('error', 'Error executing PayPal payment: ' . $ex->getMessage());
        }
    }

    public function paypalCancel()
    {
        session()->forget(['pending_order', 'cart_items']);
        return redirect()->route('checkout')->with('error', 'You have canceled the payment.');
    }
}