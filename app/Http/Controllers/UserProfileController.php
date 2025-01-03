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



public function update(Request $request)
{
    try {
        // Validasi email dan phone yang unik
        $user = Auth::user();
        
        // Cek email
        $existingEmail = User::where('email', $request->email)
            ->where('id', '!=', $user->id)
            ->first();
            
        if ($existingEmail) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email sudah digunakan. Silakan gunakan email lain.',
                'field' => 'email'
            ], 422);
        }
        
        // Cek nomor telepon
        if ($request->phone) {
            $existingPhone = User::where('phone', $request->phone)
                ->where('id', '!=', $user->id)
                ->first();
                
            if ($existingPhone) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Nomor telepon sudah digunakan atau masih memakai nomor default 0000000000. Silakan gunakan nomor lain.',
                    'field' => 'phone'
                ], 422);
            }
        }

        // Sisa kode validasi yang sudah ada
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:8|confirmed',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ], [
            'password.confirmed' => 'Password dan konfirmasi password harus sama.'
        ]);

        // Sisa kode update yang sudah ada
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->phone = $request->input('phone');
        $user->location = $request->input('location');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(base_path('public/img'), $filename);
            $user->img = 'img/' . $filename;
        } elseif (!$request->hasFile('img') && $user->img) {
            $user->img = $user->img;
        } else {
            $user->img = null;
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Profil berhasil diperbarui'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat memperbarui profil'
        ], 500);
    }
}
    

public function destroy()
{ 
$user = Auth::user();
// dd($user);

   
    if ($user->hasRole('seller')) {
        // Hapus produk terkait berdasarkan creator_id
        $user->products()->delete();
    
        // Hapus toko terkait
        $user->store()->delete();
    
        // Reset role
        $user->syncRoles([]);
    }
    
    

    // // Logout and delete the user
    Auth::logout();
    $user->delete();

    return redirect('/home')->with('Berhasil', 'Akun anda berhasil di hapus.');
}



}
