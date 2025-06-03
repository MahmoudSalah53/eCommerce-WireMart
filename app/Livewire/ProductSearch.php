<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductSearch extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $perPage = 12;
    public $page = 1;

    protected $paginationTheme = 'bootstrap';

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->searchTerm = '';
        $this->resetPage();
    }

    public function updatedPage()
    {
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        $products = Product::query()
            ->when($this->searchTerm, function ($query) {
                $query->where(function($q) {
                    $q->where('product_name', 'like', '%'.$this->searchTerm.'%')
                      ->orWhere('description', 'like', '%'.$this->searchTerm.'%');
                });
            })->where('status', 'Published')
            ->with(['category', 'images'])
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
            
        return view('livewire.product-search', compact('products'));
    }
}