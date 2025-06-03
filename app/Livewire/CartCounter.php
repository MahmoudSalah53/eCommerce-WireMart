<?php

namespace App\Livewire;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartCounter extends Component
{
    protected $listeners = ['cartUpdated' => '$refresh'];
    
    public function render()
    {
        return view('livewire.cart-counter', [
            'cartCount' => Cart::where('user_id', Auth::id())->count()
        ]);
    }
}
