<?php

namespace App\Livewire;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartManager extends Component
{

    public $cartItems;
    public $total = 0;

    protected $listeners = ['cartUpdated' => 'loadCartItems'];

    public function mount()
    {
        $this->loadCartItems();
    }

    public function loadCartItems()
    {
        if (Auth::check()) {
            $this->cartItems = Cart::with('product')
                ->where('user_id', Auth::id())
                ->get();
            
            $this->calculateTotal();
        }
    }

    public function calculateTotal()
    {
        $this->total = $this->cartItems->sum(function ($item) {
            return $item->product->regular_price * $item->quantity;
        });
    }

    public function increaseQuantity($cartId)
    {
        $cart = Cart::find($cartId);
        $cart->increment('quantity');
        $this->emit('cartUpdated');
    }

    public function decreaseQuantity($cartId)
    {
        $cart = Cart::find($cartId);
        if ($cart->quantity > 1) {
            $cart->decrement('quantity');
        } else {
            $cart->delete();
        }
        $this->emit('cartUpdated');
    }

    public function removeItem($cartId)
    {
        Cart::destroy($cartId);
        $this->emit('cartUpdated');
    }

    public function render()
    {
        return view('livewire.cart-manager');
    }
}
