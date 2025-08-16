<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerMainController extends Controller
{

    public function index()
    {
        return view('customer.profile');
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

        return redirect('user/profile')->with('success', 'Profile Updated Successfully!');
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
        return view('customer.profile');
    }

    public function history()
    {
        return view('customer.history');
    }

    public function payment()
    {
        return view('customer.payment');
    }
}
