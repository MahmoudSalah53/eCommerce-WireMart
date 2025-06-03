<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePageSetting;
use App\Models\Product;
use App\Models\User;
use App\Models\UserImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminMainController extends Controller
{
    public function index()
    {
        $products = Product::orderByRaw("status = 'Draft' DESC")->get();
        $users = User::orderByRaw("id DESC")->get();

        $now = Carbon::now();

        $weekAgo = $now->copy()->subWeek();
        $monthAgo = $now->copy()->subMonth();

        $lastWeekUsers = User::whereBetween('created_at', [$weekAgo, $now])->count();
        $lastMonthUsers = User::whereBetween('created_at', [$monthAgo, $now])->count();

        $weekPercentageUsers = 0;
        if ($lastMonthUsers > 0) {
            $weekPercentageUsers = ($lastWeekUsers / $lastMonthUsers) * 100;
        }

        $formattedWeekPercentageUsers = number_format($weekPercentageUsers, 1) . '%';

        $lastWeekProducts = Product::whereBetween('created_at', [$weekAgo, $now])->count();
        $lastMonthProducts = Product::whereBetween('created_at', [$monthAgo, $now])->count();

        $weekPercentageProducts = 0;
        if ($lastMonthProducts > 0) {
            $weekPercentageProducts = ($lastWeekProducts / $lastMonthProducts) * 100;
        }

        $formattedWeekPercentageProducts = number_format($weekPercentageProducts, 1) . '%';

        return view('admin.dashboard', [
            'products' => $products,
            'users' => $users,
            'weekPercentageUsers' => $formattedWeekPercentageUsers,
            'weekPercentageProducts' => $formattedWeekPercentageProducts,
        ]);
    }

    
    public function destroyProduct(Product $id)
    {
        $id->delete();
        return redirect(route('admin'))->with('success', 'Product Deleted Successfully.');
    }

    public function destroyUser(User $id)
    {
        $id->delete();
        return redirect(route('admin'))->with('success', 'User Deleted Successfully.');
    }

    public function changeRole(User $id){
        $newRole = $id->role == 1 ? 2 : 1;
        $id->update([
        'role' => $newRole,
    ]);

    $newStatus = $newRole == 1 ? 'Published' : 'Draft';

    $products = Product::where('seller_id', $id->id)->get();

    foreach ($products as $product) {
        $product->update([
            'status' => $newStatus
        ]);
    }

    return redirect()->back()->with('success', 'User Role Updated Successfully.');
    }


    public function setting()
    {
        $products = Product::all();
        $homepagesetting = HomePageSetting::first() ?? new HomePageSetting();
        return view('admin.settings', compact('products', 'homepagesetting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'discounted_product_id' => 'required|exists:products,id',
            'discount_percent' => 'required|numeric|min:0',
            'discount_heading' => 'required|string|max:255',
            'discount_subheading' => 'required|string|max:255',
            'featured_product_1_id' => 'nullable|exists:products,id',
            'featured_product_2_id' => 'nullable|exists:products,id',
        ]);

        $homepagesetting = HomePageSetting::first() ?? new HomePageSetting();
        $homepagesetting->fill($request->all());
        $homepagesetting->save();

        return redirect()->route('admin.settings')->with('success', 'Homepage Setting Updated Successfully.');
    }

    public function profile()
    {
        $user = User::with('images')->findOrFail(Auth::id());
        return view('admin.profile', compact('user'));
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

        return redirect('admin/profile')->with('success', 'Profile Updated Successfully!');
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
        return view('/');
    }

    public function manage_user()
    {
        return view('admin.manage.user');
    }

    public function manage_stores()
    {
        return view('admin.manage.store');
    }

    public function cart_history()
    {
        return view('admin.cart.history');
    }

    public function order_history()
    {
        return view('admin.order.history');
    }
}
