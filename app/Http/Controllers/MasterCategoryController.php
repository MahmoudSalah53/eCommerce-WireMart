<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class MasterCategoryController extends Controller
{
    public function storecat(Request $request){
        $validate_data = $request->validate([
            'category_name' => 'required|string|unique:categories|max:100|min:2|regex:/^[a-zA-Z\s]+$/',
        ]);

        Category::create($validate_data);

        return redirect('admin/category/manage')->with('success' , 'Category Added Successfully!');
    }

    public function showcat($id){
        $category_info = Category::findorfail($id);
        return view('admin.category.edit', compact('category_info'));
    }

    public function update(Request $request, Category $id){
        $validate_data = $request->validate([
            'category_name' => 'required|string|unique:categories|max:100|min:2|regex:/^[a-zA-Z\s]+$/',
        ]);

        $id->update($validate_data);

        return redirect('admin/category/manage')->with('success', 'Category Updated Successfully!');
    }

    public function destroy(Category $id){
        $id->delete();

        return redirect('admin/category/manage')->with('success', 'Category Deleted Successfully!');
    }
}
