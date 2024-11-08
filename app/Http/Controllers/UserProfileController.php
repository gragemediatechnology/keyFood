<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserProfileController extends Controller
{
    public function edit()
    {
        // dd('dftyuheth');
        return view('edit-profile', [
            'user' => Auth::user()
        ]);
    }

    // public function update(Request $request)
    // {
    //     // dd($request);
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
    //         'password' => 'nullable|string|min:8|confirmed',
    //         'first_name' => 'nullable|string|max:255',
    //         'last_name' => 'nullable|string|max:255',
    //         'phone' => 'nullable|string|max:255',
    //         'location' => 'nullable|string|max:255',
    //     ], [
    //         'password.confirmed' => 'Password dan konfirmasi password harus sama.'
    //     ]);

    //     $user = Auth::user();
    //     $user->name = $request->input('name');
    //     $user->email = $request->input('email');
    //     $user->first_name = $request->input('first_name');
    //     $user->last_name = $request->input('last_name');
    //     $user->phone = $request->input('phone');
    //     $user->location = $request->input('location');

    //     if ($request->filled('password')) {
    //         $user->password = Hash::make($request->input('password'));
    //     }

    //     if ($request->hasFile('img')) {
    //         $file = $request->file('img');
    //         $filename = time() . '_' . $file->getClientOriginalName();
    //         $file->move(base_path('public_html/img'), $filename);
    //         $user->img = 'img/' . $filename;
    //     } elseif (!$request->hasFile('img') && $user->img) {
    //         $user->img = $user->img;
    //     } else {
    //         $user->img = null;
    //     }

    //     $user->save();

    //     return redirect('/home')->with('success', 'Profil berhasil diperbarui.');
    // }

    public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'phone' => 'nullable|string|max:255',
        'password' => 'nullable|string|min:8|confirmed',
        'first_name' => 'nullable|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'location' => 'nullable|string|max:255',
    ], [
        'password.confirmed' => 'Password dan konfirmasi password harus sama.'
    ]);

    // Cek apakah email atau nomor telepon sudah digunakan oleh user lain
    $existingUser = \App\Models\User::where(function ($query) use ($request) {
        $query->where('email', $request->email)
              ->orWhere('phone', $request->phone);
    })->where('id', '!=', Auth::id())->first();

    if ($existingUser) {
        // Kembalikan dengan SweetAlert jika email atau nomor telepon sudah digunakan
        return redirect()->back()->with([
            'alert' => [
                'type' => 'error',
                'title' => 'Perhatian!',
                'message' => 'Email atau nomor telepon telah digunakan. Silakan gunakan yang lain.'
            ]
        ]);
    }

    // Update user
    $user = Auth::user();
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->phone = $request->input('phone');
    $user->first_name = $request->input('first_name');
    $user->last_name = $request->input('last_name');
    $user->location = $request->input('location');

    if ($request->filled('password')) {
        $user->password = Hash::make($request->input('password'));
    }

    if ($request->hasFile('img')) {
        $file = $request->file('img');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('img'), $filename);
        $user->img = 'img/' . $filename;
    }

    $user->save();

    return redirect('/home')->with([
        'alert' => [
            'type' => 'success',
            'title' => 'Berhasil!',
            'message' => 'Profil berhasil diperbarui.'
        ]
    ]);
}


    // public function destroy2()
    // {
    //     $user = Auth::user();
    //     Auth::logout();
    //     $user->delete();

    //     return redirect('/')->with('success', 'Account deleted successfully.');
    // }
    
    // public function destroy($id)
    // {
    //     $user = User::findOrFail($id);

    //     // Check if the user has the 'seller' role
    //     if ($user->hasRole('seller')) {
    //         // Reset roles to no roles or a default role
    //         $user->syncRoles([]); // Atur ke kosong atau bisa assign role default jika ada

    //         // Optionally, delete the user's related products and store (handled in the model)
    //         $user->products()->delete();
    //         $user->store()->delete();
    //     }

    //     // Delete the user
    //     $user = Auth::user();
    //     Auth::logout();
    //     $user->delete();

    //     return redirect('/')->with('success', 'Account deleted successfully.');
    // }

    public function destroy()
{
    $user = Auth::user();

    // Check if the user has the 'seller' role
    if ($user->hasRole('seller')) {
        // Reset roles to no roles or a default role
        $user->syncRoles([]); // Atur ke kosong atau bisa assign role default jika ada

        // Optionally, delete the user's related products and store (handled in the model)
        $user->products()->delete();
        $user->store()->delete();
    }

    // Logout and delete the user
    Auth::logout();
    $user->delete();

    return redirect('/')->with('success', 'Account deleted successfully.');
}

}
