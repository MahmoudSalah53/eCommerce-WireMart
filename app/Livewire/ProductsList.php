<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;

class ProductsList extends Component
{
    use WithPagination;
    
    public $search = '';
    public $category_id = '';
    public $sortBy = 'newest';
    public $perPage = 12;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'category_id' => ['except' => ''],
        'sortBy' => ['except' => 'newest'],
        'page' => ['except' => 1],
    ];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingCategoryId()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $query = Product::query()->with('images', 'category');
        
        // تطبيق البحث
        if ($this->search) {
            $query->where('product_name', 'like', '%'.$this->search.'%');
        }
        
        // تطبيق تصفية الفئة
        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }
        
        // تطبيق الترتيب
        switch ($this->sortBy) {
            case 'price_asc':
                $query->orderBy('regular_price');
                break;
            case 'price_desc':
                $query->orderByDesc('regular_price');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'popular':
                $query->withCount('orders')->orderByDesc('orders_count');
                break;
        }
        
        $products = $query->paginate($this->perPage);
        $categories = Category::all();
        
        return view('livewire.products-list', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}