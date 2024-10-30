<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http; //new
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */



    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => 'required|string|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Simpan data sementara ke session
        Session::put('temp_user', [
            'name' => $request->name,
            'phone' => $request->phone,
            'is_online' =>  true,
            'password' => Hash::make($request->password),
        ]);

        // Generate OTP
        $otp = mt_rand(100000, 999999);
        Session::put('otp', $otp);

        // Set waktu kadaluarsa OTP 2 menit
        Session::put('otp_expiration', Carbon::now()->addMinutes(2));//ini jadi null, pernaik


        // Kirim OTP melalui WhatsApp
        $this->sendWhatsAppOTP($request->phone, $otp);

        return redirect('/otp');
    }

    private function sendWhatsAppOTP($phone, $otp)
    {
        $url = "https://wakbk.grageweb.online/send-message";
        $data = [
            'number' => $phone,
            'message' => "Kode OTP telah dikirimkan ke nomor ponsel Anda. \n\nKode: $otp  \n\nKode ini berlaku selama 2 menit. Mohon masukkan kode ini untuk Proses Registrasi. \n\nJangan bagikan kode ini kepada siapa pun."
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        curl_close($ch);

        // Handle response if needed
    }
}
