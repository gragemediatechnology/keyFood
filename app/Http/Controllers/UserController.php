<?php

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File; // Tambahkan ini jika Anda perlu menggunakan File

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();

        // Return view with users data
        return view('admin.users.index', compact('users'));
        
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            // 'email' => 'required|email|unique:users',
            'phone' => 'required|phone|unique:users',
            'password' => 'required|min:6',
            'img' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $imgPath = null;
        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $imgPath = 'images/users/' . time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('images/users'), $imgPath);
        }

        User::create([
            'name' => $request->name,
            // 'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'img' => $imgPath,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            // 'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|phone|unique:users,phone,' . $user->id,
            'password' => 'nullable|min:6',
            'img' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $data = $request->only(['name',  'phone']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('img')) {
            // Hapus gambar lama jika ada
            if ($user->img && File::exists(public_path('images/users/' . $user->img))) {
                File::delete(public_path('images/users/' . $user->img));
            }
            // Simpan gambar baru
            $img = $request->file('img');
            $data['img'] = 'images/users/' . time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('images/users'), $data['img']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Hapus gambar jika ada
        if ($user->img && File::exists(public_path('images/users/' . $user->img))) {
            File::delete(public_path('images/users/' . $user->img));
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
