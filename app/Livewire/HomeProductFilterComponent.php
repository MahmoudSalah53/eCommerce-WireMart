<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Models\Product;

class HomeProductFilterComponent extends Component
{
    public $selectedCategory = null;
    public $categories = [];
    public $products = [];
    public $renderKey = 0;
    public $selectedCategoryObject = null;

    protected $listeners = ['refreshProducts' => 'refreshProducts'];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->categories = Category::all();
        $this->products = Product::with('category', 'images')
            ->when($this->selectedCategory, fn($q) => $q->where('category_id', $this->selectedCategory))
            ->where('status', 'Published')
            ->latest()
            ->take(4)
            ->get();
    }

    public function filterByCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->selectedCategoryObject = $categoryId ? Category::findorfail($categoryId) : null ;
        $this->renderKey = now()->timestamp;
        $this->loadData();
        $this->dispatch('productsUpdated');
    }

    public function refreshProducts()
    {
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.home-product-filter-component');
    }
}