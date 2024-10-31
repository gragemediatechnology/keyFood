<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Toko;
use Illuminate\Http\Request;

class SellerEditController extends Controller
{
    /*public function index()
    {
        $toko = Toko::where('id_seller', auth()->id())->get()->first();
        $product = Product::where('store_id', $toko->id_toko)->get();
        return view('seller.seller-edit', ['toko' => $toko, 'product' => $product]);
    } 
    */

    public function index()
    {
        // Cari toko berdasarkan id_seller (user yang sedang login)
        $toko = Toko::where('id_seller', auth()->id())->first();

        // Pengecekan jika toko ditemukan
        if (!$toko) {
            // Jika toko tidak ditemukan (misalnya sudah dihapus), redirect dengan pesan error
            return redirect()->route('home')->with('error', 'Toko Anda tidak ditemukan atau sudah dihapus.');
        }

        // Jika toko ditemukan, ambil produk berdasarkan id toko
        $product = Product::where('store_id', $toko->id_toko)->get();

        // Tampilkan view seller edit dengan data toko dan produk
        return view('seller.seller-edit', ['toko' => $toko, 'product' => $product]);
    }

}
