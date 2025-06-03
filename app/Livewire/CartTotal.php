<?php

namespace App\Livewire;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartTotal extends Component
{
    protected $listeners = ['cartUpdated' => '$refresh'];

    public function checkout()
    {
        // تحويل المستخدم إلى صفحة الدفع
        return redirect()->route('checkout');
    }

    public function render()
    {
        $total = Auth::check() ? Cart::with('product')->where('user_id', Auth::id())->get()
            ->sum(function($item) {
                return $item->product->regular_price * $item->quantity;
            }) : 0 ;
            
        return view('livewire.cart-total', ['total' => $total]);
    }
}
