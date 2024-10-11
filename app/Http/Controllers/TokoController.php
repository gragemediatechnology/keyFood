<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TokoController extends Controller
{
    public function index()
    {
        $stores = Toko::all();
        return view('admin.stores.index', compact('stores'));
    }

    public function create()
    {
        return view('admin.stores.create');  // Pastikan view ini ada di resources/views/admin/stores/create.blade.php
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat_toko' => 'required|string|max:255',
            'foto_profile_toko' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $store = new Toko();
        $store->nama_toko = $request->input('nama_toko');
        $store->alamat_toko = $request->input('alamat_toko');

        // if ($request->hasFile('foto_profile_toko')) {
        //     $image = $request->file('foto_profile_toko');
        //     $imagePath = $image->store('public/store_images');
        //     $store->foto_profile_toko = basename($imagePath);
        // }
        if ($request->hasFile('foto_profile_toko')) {
            $image = $request->file('foto_profile_toko');

            // Simpan gambar di folder 'public/img' dalam storage
            $imagePath = $image->store('public/products_photo');

            // Simpan hanya nama file, bukan seluruh path
            $store->foto_profile_toko = basename($imagePath);
        }


        $store->save();

        return redirect()->route('admin.stores.index')->with('success', 'Toko created successfully');
    }

    public function edit($id)
    {
        // Cari toko berdasarkan ID
        $toko = Toko::findOrFail($id);

        // Pastikan toko milik seller yang login
        if ($toko->id_seller !== Auth::id()) {
            return abort(403);
        }

        // Tidak perlu mengambil toko lagi karena sudah ada di $toko
        return view('seller.edit_toko.index', compact('toko'));
    }


    public function update(Request $request, $id)
    {
        // dd($request);
// Cari toko berdasarkan ID
        $toko = Toko::findOrFail($id);

        // Pastikan toko milik seller yang login
        if ($toko->id_seller !== Auth::id()) {
            return abort(403);
        }

        // Validasi input
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat_toko' => 'required|string|max:255',
            'deskripsi_toko' => 'required|string|max:255',
            'foto_profile_toko' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update informasi toko
        $toko->nama_toko = $request->input('nama_toko');
        $toko->alamat_toko = $request->input('alamat_toko');
        $toko->deskripsi_toko = $request->input('deskripsi_toko');

        // Jika ada file foto yang di-upload, proses penyimpanan
        if ($request->hasFile('foto_profile_toko')) {
            // Hapus gambar lama jika ada
            if ($toko->foto_profile_toko) {
                // Hapus gambar lama dari public/store_image
                $oldImagePath = public_path('store_image/' . $toko->foto_profile_toko);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Hapus file jika ada
                }
            }

            // Simpan gambar baru di public/store_image
            $image = $request->file('foto_profile_toko');
            $imagePath = $image->move(public_path('store_image'), $image->getClientOriginalName());
            $toko->foto_profile_toko = $image->getClientOriginalName();
        }

        // Simpan perubahan
        $toko->save();

        // Redirect kembali ke dashboard seller dengan pesan sukses
        return redirect()->route('seller-edit')->with('success', 'Toko berhasil diperbarui.');

    }




    public function destroy($id)
    {
        $store = Toko::findOrFail($id);
        $store->delete();

        return redirect()->route('admin.stores.index')->with('success', 'Toko deleted successfully');
    }

    public function showStores()
    {
        $stores = Toko::all();
        return view('stores', compact('stores'));
    }

    public function detailStore(Request $request)
    {
        // dd($request->id);

        // // Ambil nama toko dari input form
        // $namaToko = $request->input('nama_toko');

        // // Cari toko berdasarkan id
        $storeDetails = Toko::where('id_toko', $request->id)->get();


        // // Ambil ID toko dari input
        // $storeId = $store->id_toko;
        // // ambil id seller dari toko
        // // $sellerId = $store->id_seller;

        // // gunakan ID untuk mengambil detail toko
        // $storeDetails = Toko::where('id_toko', $storeId)->get();

        $products = Product::where('store_id', $request->id)->get();
        // dd($request->all());


        // dd($storeDetails, $products);
        // Tampilkan detail toko di view
        return view('halaman-toko', compact('storeDetails', 'products'));
    }


    public function search(Request $request)
    {
        $query = $request->input('query');

        // Lakukan pencarian toko
        $stores = Toko::where('nama_toko', 'LIKE', "%{$query}%")->get();

        return response()->json([
            'data' => $stores
        ]);
    }
}
