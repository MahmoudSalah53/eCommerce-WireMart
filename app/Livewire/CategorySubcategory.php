<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Subcategory;
use Livewire\Component;

class CategorySubcategory extends Component
{
    public $categories = [];
    public $selectedCategory;
    public $selectedSubcategory;
    public $subcategories = [];

    public function mount($selectedCategory = null, $selectedSubcategory = null)
    {
        $this->categories = Category::all();
        $this->selectedCategory = $selectedCategory;
        $this->selectedSubcategory = $selectedSubcategory;

        if ($this->selectedCategory) {
            $this->subcategories = Subcategory::where('category_id', $this->selectedCategory)->get();
        }
    }

    public function updatedselectedCategory($categoryId)
    {
        $this->subcategories = Subcategory::where('category_id', $categoryId)->get();
    }

    public function render()
    {
        return view('livewire.category-subcategory');
    }
}
