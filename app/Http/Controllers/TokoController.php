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

            // Simpan gambar di folder 'public/store_image' menggunakan base_path
            $imageName = time() . '_' . $image->getClientOriginalName(); // Buat nama file unik
            $image->move(base_path('public_html/store_image'), $imageName);

            // Simpan hanya nama file, bukan seluruh path
            $store->foto_profile_toko = $imageName;
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
        //  dd($request);
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
            'waktu_buka' => 'nullable|date_format:H:i',
            'waktu_tutup' => 'nullable|date_format:H:i',
            'foto_profile_toko' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update informasi toko
        $toko->nama_toko = $request->input('nama_toko');
        $toko->waktu_buka = $request->input('waktu_buka');
        $toko->waktu_tutup = $request->input('waktu_tutup');
        $toko->alamat_toko = $request->input('alamat_toko');
        $toko->deskripsi_toko = $request->input('deskripsi_toko');

        if ($request->hasFile('foto_profile_toko')) {
            // Hapus gambar lama jika ada
            if ($toko->foto_profile_toko) {
                $oldImagePath = base_path('public_html/store_image/' . $toko->foto_profile_toko);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Hapus file jika ada
                }
            }
        
            // Simpan gambar baru di public/store_image
            $image = $request->file('foto_profile_toko');
            $imageName = time() . '_' . $image->getClientOriginalName(); // Buat nama file unik
            $image->move(base_path('public_html/store_image'), $imageName);
            $toko->foto_profile_toko = $imageName;
        }
        

        // Simpan perubahan
        $toko->save();

        // Redirect kembali ke dashboard seller dengan pesan sukses
        return redirect()->route('seller-edit')->with('success', 'Toko berhasil diperbarui.');
    }




    // public function destroy2($id)
    // {
    //     $store = Toko::findOrFail($id);
    //     $store->delete();

    //     return redirect()->route('admin.stores.index')->with('success', 'Toko deleted successfully');
    // }

    public function destroy($id)
    {
        $store = Toko::findOrFail($id);

        // Hapus semua produk yang diunggah oleh toko ini
        $store->products()->delete(); // Ini akan menghapus semua produk yang terhubung dengan creator_id

        // Ambil user yang memiliki toko ini
        $user = $store->user;

        if ($user) {
            // Jika user memiliki role seller, reset role-nya
            if ($user->hasRole('seller')) {
                $user->syncRoles([]); // Menghapus semua role
            }
        }

        // Hapus toko
        $store->delete();

        return redirect()->route('admin.stores.index')->with('success', 'Toko dan produk terkait berhasil dihapus, role pengguna direset.');
    }


    public function showStores(Request $request)
    {
        $itemsPerPage = $request->input('itemsPerPage', 6); // Default 6 item per halaman
        $page = $request->input('page', 1);
    
        // Jika ini permintaan AJAX
        if ($request->ajax()) {
            $stores = Toko::paginate($itemsPerPage, ['*'], 'page', $page);
            return response()->json($stores);
        }
    
        // Untuk halaman pertama kali dimuat
        $stores = Toko::paginate($itemsPerPage);
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

    public function toggleOnlineStatus($id)
    {
        // Temukan toko berdasarkan ID
        $toko = Toko::findOrFail($id);

        // Toggle status is_online
        $toko->is_online = !$toko->is_online; // Jika is_online true, jadi false dan sebaliknya
        $toko->save();

        // Tentukan teks status untuk pesan sukses
        $statusText = $toko->is_online ? 'Buka' : 'Tutup';
        return redirect()->to('/seller/seller-edit')->with('success', 'Status toko berhasil diubah menjadi ' . $statusText);
    }
}
