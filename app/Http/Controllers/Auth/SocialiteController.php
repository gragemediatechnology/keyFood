<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();
            // Mencari pengguna berdasarkan google_id
            $existingUser = User::where('google_id', $user->id)->first();

            if ($existingUser) {
                // Jika pengguna ada, login
                if ($existingUser->hasRole('admin')) {
                    Auth::login($existingUser);
                    $existingUser->update(['is_online' => true]);

                    return redirect()->intended('/admin/main-admin');
                } else {
                    Auth::login($existingUser);
                    $existingUser->update(['is_online' => true]);

                    return redirect()->intended('/home');
                }

            } else {

                // Jika pengguna tidak ada, buat pengguna baru
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    // 'phone' => $user->phone,
                    'google_id' => $user->id,
                    'password' => bcrypt('default_password'), // Atau bisa generate password random
                    'email_verified_at' => now(),
                    // 'phone_verified_at' => now(),
                    // Tambahkan kolom lain yang diperlukan
                ]);

                $newUser->update(['is_online' => true]);

                Auth::login($newUser);

                // Arahkan pengguna ke halaman yang diinginkan setelah login
                return redirect()->intended('/home');
            }
        } catch (\Exception $e) {
            // dd($e);
            // Tangani kesalahan dengan mengarahkan kembali ke halaman login dan menampilkan pesan error
            return redirect('/log-reg');
        }

    }
}
