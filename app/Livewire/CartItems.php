<?php

namespace App\Livewire;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartItems extends Component
{

    protected $listeners = ['cartUpdated' => '$refresh'];

    public function increment($cartId)
    {
        $cart = Cart::find($cartId);

        $product = $cart->product;

        if ($cart->quantity < $product->stock_quantity) {
        $cart->update(['quantity' => $cart->quantity + 1]);
        }
        $this->dispatch('cartUpdated');
    }

    public function decrement($cartId)
    {
        $cart = Cart::find($cartId);

        $product = $cart->product;

        if ($cart->quantity > 1) {
            $cart->update(['quantity' => $cart->quantity - 1]);
        } else {
            $cart->delete();
        }
        $this->dispatch('cartUpdated');
    }

    public function removeItem($cartId)
    {
        Cart::find($cartId)->delete();
        $this->dispatch('cartUpdated'); // لتحديث العدادات
    }

    public function render()
    {
        return view('livewire.cart-items', [
            'cartItems' => Auth::check() ? Cart::where('user_id', Auth::id())->with('product')->get() : []
        ]);
    }
}
