<?php

namespace App\Livewire;

use Livewire\Component;

class Checkout extends Component
{
    public $cartItems = [];
    public $total = 0;
    public $address = ''; // الحقل الخاص بالعنوان
    public $payment_method = ''; // الحقل الخاص بطريقة الدفع

    protected $listeners = ['productAdded' => 'handleProductAdded'];

    public function handleProductAdded($cart)
    {
        $this->cartItems = $cart;
        $this->calculateTotal();
    }

    public function mount()
    {
        if (!auth()->check()) {
            return redirect()->route('login'); // تحويل المستخدم إلى صفحة الدخول إذا لم يكن مسجلًا
        }
        // استرجاع سلة التسوق من session أو من مكان آخر
        $this->cartItems = session()->get('cart', []); // أو من localStorage إذا كنت بتستخدمه
        $this->total = array_sum(array_column($this->cartItems, 'price')); // حساب المجموع
    }

    // دالة لحساب المجموع الإجمالي للسلة
    public function calculateTotal()
    {
        $this->total = array_sum(array_column($this->cartItems, 'price'));
    }

    public function proceedToCheckout()
{
    if (empty($this->cartItems)) {
        session()->flash('message', 'سلة التسوق فارغة!');
        return;
    }

    if (auth()->check()) {
        // إنشاء الطلب
        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'address' => $this->address,
            'payment_method' => $this->payment_method,
            'total_price' => $this->total,
        ]);

        // حفظ كل منتج في order_items
        foreach ($this->cartItems as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return redirect()->route('order.confirm', ['order' => $order->id]);
    }

    return redirect()->route('login');
}






    public function render()
    {
        return view('livewire.checkout');
    }
}
