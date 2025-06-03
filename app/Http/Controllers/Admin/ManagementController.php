<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    public function productIndex(){
        return view('admin.management.product-manage');
    }

    public function userIndex(){
        return view('admin.management.user-manage');
    }

    public function destroyProduct(Product $id)
    {
        $id->delete();

        return redirect()->back()->with('success', 'The Product has been Successfully Deleted');
    }
}
