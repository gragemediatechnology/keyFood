<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthenticatedSessionController extends Controller
{

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.log-reg');
    }

    /**
     * Handle an incoming authentication request.
     */


    // public function store2(LoginRequest $request): RedirectResponse
    // {
    //     $credentials = $request->only('phone', 'password');

    //     // Validasi Phone dan Password
    //     $validator = Validator::make($credentials, [
    //         'phone' => 'required|numeric',
    //         'password' => 'required',
    //     ]);

    //     // Cek apakah ada redirect URL setelah login
    //     if ($request->has('redirect')) {
    //         return redirect()->intended($request->input('redirect'));
    //     }

    //     // Jika tidak ada redirect URL, arahkan ke halaman dashboard (atau halaman default lainnya)
    //     return redirect()->route('Detail.Toko');

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $user = User::where('phone', $credentials['phone'])->first();

    //     if (!$user) {
    //         return redirect()->back()->withErrors([
    //             'phone' => 'Phone tidak ditemukan.',
    //         ])->withInput();
    //     }

    //     if (!Auth::attempt($credentials)) {
    //         return redirect()->back()->withErrors([
    //             'password' => 'Password salah.',
    //         ])->withInput();
    //     }

    //     // Jika login berhasil, ubah status is_online menjadi true
    //     $user->update(['is_online' => true]);

    //     $request->session()->regenerate();

    //     // Redirect based on user role
    //     if (Auth::user()->hasRole('admin')) {
    //         return redirect()->intended(route('admin.dashboard-main'));
    //     }

    //     if (Auth::user()->hasRole('seller')) {
    //         return redirect()->intended(route('seller-edit'));
    //     }

    //     return redirect()->intended(route('home'));
    // }
    // tes  

    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('phone', 'password');

        // Validasi Phone dan Password
        $validator = Validator::make($credentials, [
            'phone' => 'required|numeric',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('phone', $credentials['phone'])->first();

        if (!$user) {
            return redirect()->back()->withErrors([
                'phone' => 'Phone tidak ditemukan.',
            ])->withInput();
        }

        if (!Auth::attempt($credentials)) {
            return redirect()->back()->withErrors([
                'password' => 'Password salah.',
            ])->withInput();
        }

        // Jika login berhasil, ubah status is_online menjadi true
        $user->update(['is_online' => true]);

        $request->session()->regenerate();

        // Manual redirect berdasarkan input 'redirect' di URL
        if ($request->has('redirect')) {
            return redirect($request->input('redirect'));
        }

        // Redirect berdasarkan role
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard-main');
        }

        if (Auth::user()->hasRole('seller')) {
            return redirect()->route('seller-edit');
        }

        // Jika tidak ada redirect URL, arahkan ke halaman default
        return redirect('https://lapakkbk.online');
    }




    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {

        $user = Auth::user();

        Auth::guard('web')->logout();

        // Ubah status is_online menjadi false saat logout
        $user->update(['is_online' => false]);

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('https://lapakkbk.online');

        // return redirect('/');
    }


    // public function redirectToGoogle()
    // {
    //     return Socialite::driver('google')->redirect();
    // }

    // public function handleGoogleCallback()
    // {
    //     try {
    //         $user = Socialite::driver('google')->stateless()->user();
    //         // Mencari pengguna berdasarkan google_id
    //         $existingUser = User::where('google_id', $user->id)->first();

    //         if ($existingUser) {
    //             // Jika pengguna ada, login
    //             Auth::login($existingUser);
    //             return redirect()->intended('/home');
    //         } else {
    //             // Jika pengguna tidak ada, buat pengguna baru
    //             $newUser = User::create([
    //                 'name' => $user->name,
    //                 // 'email' => $user->email,
    //                 'phone' => $user->phone,
    //                 'google_id' => $user->id,
    //                 'password' => bcrypt('default_password'), // Atau bisa generate password random
    //                 // 'email_verified_at' => now(),
    //                 'phone_verified_at' => now(),
    //                 // Tambahkan kolom lain yang diperlukan
    //             ]);

    //             Auth::login($newUser);

    //             // Arahkan pengguna ke halaman yang diinginkan setelah login
    //             return redirect()->intended('/home');
    //         }
    //     } catch (\Exception $e) {
    //         // Tangani kesalahan dengan mengarahkan kembali ke halaman login dan menampilkan pesan error
    //         return redirect('/log-reg')->withErrors('Error: ' . $e->getMessage());
    //     }
    // }
}
