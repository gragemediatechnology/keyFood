<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class OtpWaVerificationController extends Controller
{

    public function verify(Request $request)
    {


        $otp = implode('', $request->otp);
        $request->merge(['otp' => $otp]);

        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $otpExpiration = Session::get('otp_expiration');
        $kondisi = Session::get('otp_expiration') == null ? true : false;
        $kondisi2 = true;

        if ($otpExpiration && Carbon::now()->greaterThan($otpExpiration)) {
            // OTP kadaluarsa
            return response()->json(['status' => 'error', 'message' => 'OTP telah kadaluarsa. Silakan minta OTP baru.'], 400);
        }

        if ($otp == Session::get('otp')) {

            // OTP valid, buat user baru
            $userData = Session::get('temp_user');
            $user = User::create($userData);

            event(new Registered($user));

            Auth::login($user);

            // Hapus data sementara dari session
            Session::forget(['temp_user', 'otp', 'otp_expiration']);

            return response()->json(200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'OTP anda salah. Silakan minta OTP baru.'], 400);
        }
    }

    public function resendOtp(Request $request)
    {
        // Cek apakah session masih menyimpan data user sementara
        if (!Session::has('temp_user')) {
            return back()->with('status', 'Session telah habis, silakan ulangi registrasi.');
        }

        // Generate OTP baru
        $otp = mt_rand(100000, 999999);
        Session::put('otp', $otp);

        // Set ulang waktu kadaluarsa OTP 2 menit
        Session::put('otp_expiration', Carbon::now()->addMinutes(2));

        // Kirim OTP melalui WhatsApp
        $this->sendWhatsAppOTP(Session::get('temp_user')['phone'], $otp);

        return back()->with('status', 'OTP baru telah dikirimkan');
    }


    private function sendWhatsAppOTP($phone, $otp)
    {
        $url = "https://wakbk.grageweb.online/send-message";
        $data = [
            'number' => $phone,
            'message' => "*TerasKBK - Kode Verifikasi Anda* \n\nKode verifikasi untuk melanjutkan proses registrasi di TerasKBK telah dikirimkan.\n\nKode OTP: * $otp * \nMasa Berlaku: 2 Menit \n\nSilakan masukkan kode ini dalam waktu 2 menit untuk menyelesaikan proses registrasi.\nDemi keamanan akun Anda, mohon untuk tidak membagikan kode ini kepada siapa pun.\nTerasKBK tidak akan pernah meminta Anda untuk mengungkapkan kode verifikasi ini.\nTerima kasih telah menggunakan layanan TerasKBK!\n\n\n_Mohon Jangan Membalas Pesan Otomatis Dari Kami._"
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        curl_close($ch);

        // Handle response if needed
    }
}
