<?php

namespace App\Livewire;

use Livewire\Component;

class ActivateProducts extends Component
{
    public $products;

    public function mount($product)
    {
        $this->products = $product;
    }

    public function updateStatus()
    {
        if($this->products->status === 'Draft'){
            $this->products->status = 'Published';
            $this->products->save();
        }

        $this->dispatch('productActivated');
    }

    public function render()
    {
        return view('livewire.activate-products');
    }
}
