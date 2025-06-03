<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class MasterSubCategoryController extends Controller
{
    public function store(Request $request){
        $validate_data = $request->validate([
            'subcategory_name' => 'required|string|unique:subcategories|max:100|min:2|regex:/^[a-zA-Z\s]+$/',
            'category_id' => 'required|exists:categories,id',
        ]);

        Subcategory::create($validate_data);

        return redirect('admin/subcategory/manage')->with('success', 'SubCategory Added Successfully!');
    }

    public function show($id){
        $subcategory_info = Subcategory::findorfail($id);
        $categories = Category::all();
        return view('admin.sub_category.edit', compact('subcategory_info', 'categories'));
    }

    public function update(Request $request, Subcategory $id){
        $rules = [
            'subcategory_name' => 'required|string|max:100|min:2|regex:/^[a-zA-Z\s]+$/',
            'category_id' => 'required|exists:categories,id',
        ];

        
        if ($request->has('subcategory_name') && $request->subcategory_name != $id->subcategory_name) {
            $rules['subcategory_name'] = 'required|string|unique:subcategories,subcategory_name,' . $id->id . '|max:100|min:2|regex:/^[a-zA-Z\s]+$/';
        }


        $validate_data = $request->validate($rules);


        $id->update($validate_data);

        return redirect('admin/subcategory/manage')->with('success', 'SubCategory Updated Successfully!');
    }

    public function destroy(Subcategory $id){
        $id->delete();

        return redirect('admin/subcategory/manage')->with('success', 'SubCategory Deleted Successfully!');
    }
}
