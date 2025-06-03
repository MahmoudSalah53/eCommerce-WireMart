<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ManageProduct extends Component
{
    use WithPagination;

    public $searchTerm = '';

    protected $paginationTheme = 'bootstrap';

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }


    public function render()
    {
        $products = Product::where('product_name', 'like', '%' . $this->searchTerm . '%')
        ->orWhere('description', 'like', '%' . $this->searchTerm . '%')->orderByRaw("status = 'Draft' DESC")
        ->paginate(5);
        return view('livewire.manage-product', compact('products'));
    }
}
