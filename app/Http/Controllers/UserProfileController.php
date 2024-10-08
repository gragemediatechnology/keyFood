<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function edit()
    {
        // dd('dftyuheth');
        return view('edit-profile', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        dd($request);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:8|confirmed',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->phone = $request->input('phone');
        $user->location = $request->input('location');
        $user->img = $request->input('img');

    
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

    

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img'), $filename);
            $user->img = 'img/' . $filename;
        } elseif (!$request->hasFile('img') && $user->img) {
            // Jika tidak ada file baru diupload dan user sudah memiliki gambar, pertahankan gambar yang ada
            $user->img = $user->img;
        } else {
            // Jika tidak ada file baru diupload dan user tidak memiliki gambar, set img menjadi null
            $user->img = null;
        }

        $user->save();

        return redirect('/home')->with('success', 'Profile updated successfully.');
    }

    public function destroy()
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();

        return redirect('/')->with('success', 'Account deleted successfully.');
    }
}
