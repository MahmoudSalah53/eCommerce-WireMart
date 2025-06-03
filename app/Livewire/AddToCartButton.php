<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddToCartButton extends Component
{
    public $productId;

    public function addToCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $product = Product::find($this->productId);

        if (!$product) {
            session()->flash('error', 'المنتج غير موجود');
            return;
        }

        $cartItem = Cart::where([
            'user_id' => Auth::id(),
            'product_id' => $this->productId
        ])->first();

        if ($cartItem) {
            if ($cartItem->quantity < $product->stock_quantity) {
                $cartItem->increment('quantity');
            }
        } else {
            if ($product->stock_quantity > 0) {
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $this->productId,
                    'quantity' => 1
                ]);
            } else {
                session()->flash('error', 'المنتج غير متوفر حالياً');
            }
        }

        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        return view('livewire.add-to-cart-button');
    }
}
