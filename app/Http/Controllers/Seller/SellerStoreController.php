<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerStoreController extends Controller
{
    public function index(){
        return view('seller.store.create');
    }

    public function manage(){
        $stores = Store::where('user_id', Auth::id())->get();
        return view('seller.store.manage', compact('stores'));
    }

    public function store(Request $request){
        $request->validate([
            'store_name' => 'required|string|unique:stores|max:100|min:3',
            'slug' => 'required|string|max:100|min:2',
            'details' => 'required|string|max:100|min:5',
        ]);

        Store::create([
            'store_name' => $request->store_name,
            'slug' => $request->slug,
            'details' => $request->details,
            'user_id' => Auth::user()->id,
        ]);

        return redirect('vendor/store/manage')->with('success' , 'Store Added Successfully!');
    }

    public function edit($id){
        $store_info = Store::findorfail($id);
        return view('seller.store.edit', compact('store_info'));
    }

    public function update(Request $request, Store $id){
        $request->validate([
            'store_name' => 'required|string|max:100|min:3|unique:stores,store_name,'. $id->id,
            'slug' => 'required|string|max:100|min:2',
            'details' => 'required|string|max:100|min:5',
        ]);

        $id->update([
            'store_name' => $request->store_name,
            'slug' => $request->slug,
            'details' => $request->details,
            'user_id' => Auth::user()->id,
        ]);

        return redirect('vendor/store/manage')->with('success' , 'Store Updated Successfully!');
    }

    public function destroy(Store $id){
        $id->delete();

        return redirect('vendor/store/manage')->with('success' , 'Store Deleted Successfully!');
    }
}
