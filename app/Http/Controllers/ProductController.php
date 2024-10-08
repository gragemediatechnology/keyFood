<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\Product;
use App\Models\Category;
use App\Models\Orders;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->can('productCRUD')) {
            // Mengambil produk milik penjual yang login
            $products = Product::where('creator_id', Auth::id())->paginate(5);

            // Mengirim data produk ke view dengan pagination
            return view('seller./seller/seller-edit', compact('products'));
        }

        return abort(403);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $storeId = Auth::id(); // Ambil ID seller yang sedang login
        $stores = Toko::where('id_seller', $storeId)->get(); // Ambil toko yang sesuai dengan ID seller

        return view('seller.products.create', [
            'categories' => $categories,
            'stores' => $stores, // Kirim data stores ke view
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['required', 'image', 'mimes:png,jpg,jpeg'],
            'slug' => ['required', 'string', 'max:65535'],
            'category_id' => ['required', 'integer'],
            'price' => ['required', 'integer', 'min:0'],
            'quantity' => ['required', 'integer'],
            'store_id' => ['required', 'integer', 'exists:toko,id_toko'], // Validasi store_id
        ]);

        $store = Toko::find($validate['store_id']);

        // Pastikan toko yang dipilih milik seller yang sedang login
        if ($store->id_seller !== Auth::id()) {
            return redirect()->back()->with('error', 'You can only add products to your own store.');
        }

        DB::beginTransaction();
        try {
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->move(public_path('products_photo'), $request->file('photo')->getClientOriginalName());
                $validate['photo'] = 'products_photo/' . $request->file('photo')->getClientOriginalName();
            }
            $validate['slug'] = Str::slug($request->name);
            $validate['creator_id'] = Auth::id();
            $newProduct = Product::create($validate);
            DB::commit();
            return redirect()->route('seller-edit')->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            $error = ValidationException::withMessages([
                'system_error' => ['System error! ' . $e->getMessage()],
            ]);

            throw $error;
        }
    }

    /**
     * Display the specified resource.
     */
    public function showProductSlider()
    {
        $products = Product::inRandomOrder()->paginate(5);
        return view('product-slider', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // Pastikan produk milik penjual yang login
        if ($product->creator_id !== Auth::id()) {
            return abort(403);
        }

        $categories = Category::all();
        $storeId = Auth::id(); // Ambil ID seller yang sedang login
        $stores = Toko::where('id_seller', $storeId)->get(); // Ambil toko yang sesuai dengan ID seller

        return view('seller.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'stores' => $stores, // Sertakan stores di sini
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Pastikan produk milik penjual yang login
        if ($product->creator_id !== Auth::id()) {
            return abort(403);
        }

        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['sometimes', 'image', 'mimes:png,jpg,jpeg'],
            'category_id' => ['required', 'integer'],
            'price' => ['required', 'integer', 'min:0'],
            'quantity' => ['required', 'integer', 'min:0'],
            'slug' => ['required', 'string', 'max:65535'],
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->move(public_path('products_photo'), $request->file('photo')->getClientOriginalName());
                $validate['photo'] = 'products_photo/' . $request->file('photo')->getClientOriginalName();
            }
            $validate['slug'] = Str::slug($request->name);
            $product->update($validate);
            DB::commit();
            return redirect()->route('seller-edit')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            $error = ValidationException::withMessages([
                'system_error' => ['System error! ' . $e->getMessage()],
            ]);

            throw $error;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Pastikan produk milik penjual yang login
        if ($product->creator_id !== Auth::id()) {
            return abort(403);
        }

        DB::beginTransaction();
        try {
            // Hapus file gambar dari direktori
            $photoPath = public_path($product->photo);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }

            // Hapus produk dari database
            $product->delete();

            DB::commit();
            return redirect()->route('seller-edit')->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            $error = ValidationException::withMessages([
                'system_error' => ['System error! ' . $e->getMessage()],
            ]);

            throw $error;
        }
    }

    public function destroyOrder($id)
    {
        try {
            // Cari order berdasarkan ID dan hapus
            $order = Orders::where('id', $id)->where('id_user', auth()->id())->firstOrFail();
            $order->delete();

            return redirect()->back()->with('success', 'Order berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus order: ' . $e->getMessage());
            return redirect()->back()->withErrors(['order' => 'Gagal menghapus order.']);
        }
    }

    public function cart()
    {
        return view('partials.cart');
    }

    public function addToCart($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $cart = Session::get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'photo' => $product->photo,
            ];
        }
        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function showProducts()
    {
        // Ambil produk dengan paginasi (atau sesuai kebutuhan)
        $products = Product::paginate(10);

        // Kirim data produk ke view
        return view('categories', compact('products'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $categoryName = $request->input('category');

        // Mulai query builder
        $productQuery = Product::with(['category', 'toko']);

        // Filter berdasarkan query pencarian (nama produk)
        if ($query) {
            $productQuery->where('name', 'LIKE', "%{$query}%");
        }

        // Filter berdasarkan kategori jika disediakan
        if ($categoryName) {
            // Menggunakan `whereHas` untuk filter berdasarkan nama kategori
            $productQuery->whereHas('category', function ($q) use ($categoryName) {
                $q->where('name', $categoryName);
            });
        }

        // Ambil data produk dengan pagination
        $products = $productQuery->paginate(10);

        // Manipulasi data produk untuk menambahkan perhitungan rating
        $products->getCollection()->transform(function ($product) {
            // Ambil nilai rating dan rated_by
            $rating = $product->rating ?? 0;

            // Jika rated_by adalah JSON, decode jadi array dan hitung elemennya
            if (is_string($product->rated_by)) {
                $rated_by = json_decode($product->rated_by, true);
                $rated_by = is_array($rated_by) ? count($rated_by) : 1; // Hitung jumlah elemen jika array, gunakan default 1
            } else {
                $rated_by = $product->rated_by ?? 1; // Default ke 1 jika tidak ada rated_by
            }

            // Hitung rata-rata rating
            $average_rating = $rated_by > 0 ? $rating / $rated_by : 0;

            // Batasi hingga satu angka di belakang koma
            $product->average_rating = number_format($average_rating, 1);

            return $product;
        });

        // Kembalikan produk dengan informasi pagination
        return response()->json($products);
    }


    // public function rateProduct(Request $request, $id)
    // {
    //     $user = Auth::user();
    //     $product = Product::findOrFail($id);

    //     // Validasi rating
    //     $request->validate([
    //         'rating' => 'required|numeric|min:1|max:100',
    //     ]);

    //     // Ambil list user yang sudah memberikan rating
    //     $ratedBy = $product->rated_by ? json_decode($product->rated_by, true) : [];
    //     dd($request);
    //     // Cek apakah user sudah memberi rating
    //     if (in_array($user->id, $ratedBy)) {
    //         return redirect()->back()->with('error', 'Anda sudah memberikan rating untuk produk ini.');
    //     }

    //     // Tambah user ID ke list yang sudah memberi rating
    //     $ratedBy[] = $user->id;

    //     // Hitung rating baru dengan rata-rata berdasarkan jumlah user yang memberi rating
    //     $totalRated = count($ratedBy); // Hitung jumlah user yang sudah memberi rating
    //     $existingRating = $product->rating ?? 0; // Ambil rating yang ada
    //     $newRating = (($existingRating * ($totalRated - 1)) + $request->rating) / $totalRated; // Hitung rating rata-rata

    //     // Update rating produk
    //     $product->update([
    //         'rating' => $newRating,
    //         'rated_by' => json_encode($ratedBy),
    //     ]);

    //     return redirect()->back()->with('success', 'Terima kasih sudah memberikan rating!');
    // }    

    public function rateProduct(Request $request, $id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($id);

        // Validasi rating
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        // Cari order detail terbaru untuk produk ini yang belum diberi rating
        $latestOrderDetail = Orders::where('id_user', $user->id)
            ->where('product_id', $product->id)
            ->whereNull('rating')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$latestOrderDetail) {
            return redirect()->back()->with('error', 'Anda tidak memiliki pembelian yang belum diberi rating untuk produk ini.');
        }

        // Simpan rating ke order detail
        $latestOrderDetail->update([
            'rating' => $request->rating
        ]);

        // Hitung ulang rata-rata rating produk
        $averageRating = Orders::where('product_id', $product->id)
            ->whereNotNull('rating')
            ->avg('rating');

        // Update rating produk
        $product->update([
            'rating' => $averageRating
        ]);

        return redirect()->back()->with('success', 'Terima kasih sudah memberikan rating!');
    }

}
