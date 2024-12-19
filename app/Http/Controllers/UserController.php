<?php

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File; // Tambahkan ini jika Anda perlu menggunakan File

class UserController extends Controller
{
    public function home()
    {
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();

        return view('home', compact('admins'));
    }


    public function index()
    {

        $users = User::all(); // Mengambil semua user tanpa soft delete

        $users = User::with('roles')->get();

        // Return view with users data
        return view('admin.users.index', compact('users'));

        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function search(Request $request)
    {
        try {
            $query = $request->input('query');
    
            // Validasi jika query kosong
            if (empty($query)) {
                return response()->json(['data' => []]);
            }
    
            // Query dengan group
            $users = User::with('user') // Eager loading relasi
                ->where(function ($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%")
                        ->orWhere('email', 'LIKE', "%{$query}%")
                        ->orWhere('phone', 'LIKE', "%{$query}%");
                })
                ->get();
            
    
            return response()->json([
                'data' => $users
            ]);
        } catch (\Exception $e) {
            Log::error('Error during user search:', [
                'error' => $e->getMessage(),
            ]);
            return response()->json(['message' => 'Terjadi kesalahan saat mencari data'], 500);
        }
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
            'phone' => 'required|unique:users,phone,' . $user->id,
            'password' => 'nullable|min:6',
            'img' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $data = $request->only(['name',  'phone']);

        if (!preg_match('/^[0-9]{10,15}$/', $request->phone)) {
            return back()->withErrors(['phone' => 'Nomor telepon harus 10-15 digit.']);
        }

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

    // public function destroy2(User $user)
    // {

    //     // Hapus gambar jika ada
    //     if ($user->img && File::exists(public_path('images/users/' . $user->img))) {
    //         File::delete(public_path('images/users/' . $user->img));
    //     }

    //     $user->delete();
    //     return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    // }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Hapus gambar jika ada
        if ($user->img && File::exists(public_path('images/users/' . $user->img))) {
            File::delete(public_path('images/users/' . $user->img));
        }

        // Check if the user has the 'seller' role
        if ($user->hasRole('seller')) {
            // Reset roles to no roles or a default role
            $user->syncRoles([]); // Atur ke kosong atau bisa assign role default jika ada

            // Optionally, delete the user's related products and store (handled in the model)
            $user->products()->delete();
            $user->store()->delete();
        }

        // Delete the user
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
