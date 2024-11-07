<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        // Validasi nomor telepon
        $request->validate([
            'phone' => 'required|string|exists:users,phone',
        ]);


        // Simpan data sementara ke session
        Session::put('temp_user', [
            'phone' => $request->phone,
        ]);

        // Cari user berdasarkan nomor telepon
        $user = User::where('phone', $request->phone)->first();

        if ($user) {
            // Generate OTP
            $otp = mt_rand(100000, 999999);
            Session::put('otp', $otp);

            // Set waktu kadaluarsa OTP 2 menit
            Session::put('otp_expiration', Carbon::now()->addMinutes(2));

            // Kirim OTP melalui WhatsApp
            $this->sendWhatsAppOTP($user->phone, $otp);

            // Arahkan ke halaman input OTP
            return redirect('/otp-forgot');
        }

            return back()->withErrors(['phone' => 'Nomor WhatsApp tidak ditemukan.']);
    }

    public function sendWhatsAppOTP($phone, $otp)
    {
        $url = "https://wakbk.grageweb.online/send-message";
        $data = [
            'number' => $phone,
            'message' => " *TerasKBK - Kode Verifikasi Anda* \n\nKode verifikasi untuk melanjutkan proses reset password di TerasKBK telah dikirimkan.\n\nKode OTP: * $otp * \nMasa Berlaku: 2 Menit \n\nSilakan masukkan kode ini dalam waktu 2 menit untuk menyelesaikan proses reset password.\nDemi keamanan akun Anda, mohon untuk tidak membagikan kode ini kepada siapa pun.\nTerasKBK tidak akan pernah meminta Anda untuk mengungkapkan kode verifikasi ini.\nTerima kasih telah menggunakan layanan TerasKBK!\n\n\n>_Mohon Jangan Membalas Pesan Otomatis Dari Kami._"
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        curl_close($ch);
    }

    public function verify(Request $request)
{
    $otp = implode('', $request->otp);
    $request->merge(['otp' => $otp]);

    $request->validate([
        'otp' => 'required|string|size:6',
    ]);

    $otpExpiration = Session::get('otp_expiration');

    // Cek apakah OTP sudah kedaluwarsa
    if ($otpExpiration && Carbon::now()->greaterThan($otpExpiration)) {
        return response()->json(['status' => 'error', 'message' => 'OTP telah kadaluarsa. Silakan minta OTP baru.'], 400);
    }

    // Cek apakah OTP valid
    if ($otp == Session::get('otp')) {
        // Jika OTP valid, set session untuk izin reset password
        Session::put('can_reset_password', true);

        // Hapus OTP dan waktu kadaluarsa dari session
        Session::forget(['otp', 'otp_expiration']);

        // Redirect ke halaman reset password
        return response()->json(['status' => 'success', 'message' => 'OTP valid. Anda akan diarahkan ke halaman reset password.', 'redirect' => route('reset-password-forgot')], 200);
    } else {
        return response()->json(['status' => 'error', 'message' => 'OTP salah. Silakan coba lagi.'], 400);
    }
}


    public function resendOtp()
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

    public function resetPassword(Request $request)
    {
        // Validasi password baru
        $request->validate([
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Dapatkan user dari sesi lupa password
        $user = User::where('phone', Session::get('temp_user'))->first();

        if (!$user) {
            return back()->withErrors(['phone' => 'Pengguna tidak ditemukan.']);
        }

        // Update password user
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

         // Hapus informasi reset dari session
         Session::forget(['temp_user']);

        $user->save();



        // return redirect('/login')->with('status', 'Password berhasil direset.');

        return redirect('/login')->with('sweet_alert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Password Anda berhasil diubah.'
        ]);

    }

}
