<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\UserImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SellerMainController extends Controller
{
    public function index()
    {

        $productsCount = Product::count();

        $lastMonthCount = Product::where('created_at', '>=', now()->subMonth())->count();

        $annualIncome = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')  
            ->join('products', 'order_items.product_id', '=', 'products.id')  
            ->where('products.seller_id', Auth::id())  
            ->whereYear('orders.created_at', now()->year)  
            ->where('products.status', 'Published')  
            ->sum('orders.total');  

        $lastYearIncome = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')  
            ->join('products', 'order_items.product_id', '=', 'products.id')  
            ->where('products.seller_id', Auth::id()) 
            ->whereYear('orders.created_at', now()->subYear()->year) 
            ->where('products.status', 'Published') 
            ->sum('orders.total');

        $incomePercentageChange = $lastYearIncome > 0
            ? (($annualIncome - $lastYearIncome) / $lastYearIncome) * 100
            : ($annualIncome > 0 ? 100 : 0);

        $percentageChange = 0;
        if ($lastMonthCount > 0) {
            $percentageChange = (($productsCount - $lastMonthCount) / $lastMonthCount) * 100;
        }

        $orders = OrderItem::with('product')
        ->with('order.user')
        ->whereHas('product', function ($query) {
            $query->where('seller_id', Auth::id());
        })
        ->latest()
        ->take(10)
        ->get();

        return view('seller.dashboard', compact(
            'productsCount',
            'percentageChange',
            'annualIncome',
            'incomePercentageChange',
            'orders'
        ));
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|unique:users,name,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->hasFile('images')) {

            UserImage::where('user_id', $user->id)->delete();

            foreach ($request->file('images') as $file) {
                $path = $file->store('user_image', 'public');
                UserImage::create([
                    'user_id' => $user->id,
                    'img_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        return redirect('vendor/profile')->with('success', 'Profile Updated Successfully!');
    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate inputs
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Check if current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }

    public function destroyAccount(Request $request)
    {
        $userId = Auth::id();
        Auth::logout();
        User::where('id', $userId)->delete();
        return redirect(route('home'));
    }

    public function profile()
    {
        return view('seller.profile');
    }

    public function orderhistory()
    {
        return view('seller.orderhistory');
    }
}
