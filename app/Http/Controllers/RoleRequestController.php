<?php

namespace App\Http\Controllers;

use App\Models\RoleRequest;
use App\Models\Store;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleRequestController extends Controller
{
    public function index()
    {
        $roleRequests = DB::table('role_change_requests')
            ->join('users', 'role_change_requests.user_id', '=', 'users.id')
            ->select('role_change_requests.*', 'users.*')
            ->get();

        return view('admin.role-requests.index', compact('roleRequests'));
    }

     /* public function approve($id)
    {
        // Temukan request berdasarkan ID
        $roleRequest = DB::table('role_change_requests')->where('user_id', $id)->first();

        if ($roleRequest) {
            // Hapus request yang ada
            DB::table('role_change_requests')->where('user_id', $id)->delete();

            // Temukan pengguna berdasarkan ID
            $user = User::find($id);

            if ($user) {
                // Tambahkan role seller ke pengguna
                $user->assignRole('seller');

                // Buat akun toko untuk pengguna
                $store = new Toko();
                $store->id_seller = $user->id;
                $store->nama_toko = 'Nama Toko Baru'; // Ganti sesuai kebutuhan
                $store->alamat_toko = 'Alamat Toko'; // Ganti sesuai kebutuhan
                $store->foto_profile_toko = 'default.png'; // Ganti sesuai kebutuhan
                $store->save();

                // Redirect dengan pesan sukses
                return redirect()->back()->with('success', 'Role seller telah diterima dan akun toko telah dibuat.');
            } else {
                return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
            }
        }

        return redirect()->back()->with('error', 'Permintaan tidak ditemukan.');
    } */

    public function approve($id)
{
    // Temukan request berdasarkan ID
    $roleRequest = DB::table('role_change_requests')->where('user_id', $id)->first();

    if ($roleRequest) {
        // Hapus request yang ada
        DB::table('role_change_requests')->where('user_id', $id)->delete();

        // Temukan pengguna berdasarkan ID
        $user = User::find($id);

        if ($user) {
            // Tambahkan role seller ke pengguna
            $user->assignRole('seller');

            // Cek apakah toko sudah ada, jika belum buat toko baru
            $store = Toko::where('id_seller', $user->id)->first();
            
            // if (!$store) {
            //     // Buat toko baru
            //     $store = new Toko();
            //     $store->id_seller = $user->id;
            //     $store->nama_toko = 'Nama Toko Baru'; // Ganti sesuai kebutuhan
            //     $store->alamat_toko = 'Alamat Toko'; // Ganti sesuai kebutuhan
            //     $store->foto_profile_toko = 'markets.png'; // Ganti sesuai kebutuhan
            //     $store->is_online = 0; // Set default offline
            //     $store->save();
            // }

            if (!$store) {
                // Buat toko baru
                $store = new Toko();
                $store->id_seller = $user->id;
                $store->nama_toko = 'Nama Toko Baru'; // Ganti sesuai kebutuhan
                $store->alamat_toko = 'Alamat Toko'; // Ganti sesuai kebutuhan
            
                // Set nama file untuk gambar profil toko dan direktori tujuan
                $defaultImage = 'markets.webp';
                $targetDirectory = 'store_image'; // Direktori untuk menyimpan gambar profil toko
            
                // Cek apakah direktori target ada, jika tidak, buat direktori
                if (!file_exists(public_path($targetDirectory))) {
                    mkdir(public_path($targetDirectory), 0755, true);
                }
            
                // Buat nama file unik dengan menambahkan timestamp atau random string
                $uniqueSuffix = time() . '_' . uniqid(); // Bisa gunakan uniqid() atau Str::random(10)
                $newFileName = pathinfo($defaultImage, PATHINFO_FILENAME) . "_{$uniqueSuffix}." . pathinfo($defaultImage, PATHINFO_EXTENSION);
            
                // Salin file default ke direktori target dengan nama unik
                copy(public_path("img/{$defaultImage}"), public_path("{$targetDirectory}{$newFileName}"));
            
                // Set path gambar profil toko di database
                $store->foto_profile_toko = "{$targetDirectory}{$newFileName}";
            
                // Set status toko offline secara default
                $store->is_online = 0;
                $store->save();
            }
            

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Role seller telah diterima dan akun toko telah dibuat.');
        } else {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }
    }

    return redirect()->back()->with('error', 'Permintaan tidak ditemukan.');
}


    public function cancel($id)
    {
        // Hapus request yang ada
        DB::table('role_change_requests')->where('user_id', $id)->delete();

        // Redirect dengan pesan info
        return redirect()->back()->with('info', 'Permintaan perubahan role dibatalkan.');
    }

    public function store(Request $request)
    {
        // Validasi input jika diperlukan
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'requested_role' => 'required',
        ]);

        // Cek apakah user_id sudah ada di tabel role_change_requests
        $existingRequest = DB::table('role_change_requests')
            ->where('user_id', $request->user_id)
            ->first();

        if ($existingRequest) {
            return redirect()->back()->with('error', 'Anda telah menggajukan permintaan sebagai penjual.');
        }

        // Simpan data ke database
        DB::table('role_change_requests')->insert([
            'user_id' => $request->user_id,
            'requested_role' => $request->requested_role,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Permintaan pengajuan menjadi penjual telah di kirim.');
    }
}
