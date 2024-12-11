@extends('layouts.main')

@section('link')
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/gragemediatechnology/keyFood/14fea551a368621e3fd2012fa820cfd33852ee5c/public/css/halaman-toko.css">
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/gragemediatechnology/keyFood/699e918c4e888784bef08b8ffce0004d019c29f0/public/css/product-slider.css">
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/gragemediatechnology/keyFood/27db7ba39c81dbdafd840f462048a50468a23550/public/css/categories.css">
@endsection

@section('container')
    <section id="home">
        <div class="store-header">
            @foreach ($storeDetails as $detail)
                <div class="store-info">
                    <img src="{{ $detail->foto_profile_toko ? 'https://teraskabeka.com/store_image/' . $detail->foto_profile_toko : 'https://teraskabeka.com/img/markets.webp' }} "
                        loading="lazy" alt="logo toko" class="store-logo">
                    <div class="store-text">
                        <h1>{{ $detail->nama_toko }}</h1>
                        <h2>Alamat : {{ $detail->alamat_toko }}</h2>
                        <h2>Jam Oprasional Toko : {{ $detail->waktu_buka }} - {{ $detail->waktu_tutup }}</h2>
                        @if ($detail->is_online == true)
                            <p class="text-green-500">Buka</p>
                        @else
                            <p class="text-red-500">Tutup</p>
                        @endif
                    </div>
                </div>
                <div class="store-description">
                    <p>Deskripsi Toko : {{ $detail->deskripsi_toko }}</p>
                </div>
            @endforeach
            <div class="flex gap-4">
                <!-- Button Copy Link -->
                <button id="copy-link-btn" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Copy Link
                </button>

                <!-- Button Share -->
                <button id="share-link-btn" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Share Link
                </button>
            </div>
        </div>

        <!-- produk produk -->
        <section id="popular-bundle-pack">
            <!--heading-------------->
            <div class="product-heading">
                <h3>Products List</h3>
            </div>
            <!--box-container------>
            <div class="product-container">

                @foreach ($products as $product)
                    @php
                        // Ambil nilai rating dan rated_by
                        $rating = $product->rating ?? 0;

                        // Jika rated_by adalah JSON, decode jadi array dan hitung elemennya, jika tidak, gunakan langsung
                        if (is_string($product->rated_by)) {
                            $rated_by = json_decode($product->rated_by, true);
                            $rated_by = is_array($rated_by) ? count($rated_by) : $rated_by; // Jika array, hitung jumlahnya
                        } else {
                            $rated_by = $product->rated_by ?? 1; // Gunakan 1 sebagai default jika kosong
                        }

                        // Hitung rata-rata rating jika rated_by lebih dari 0
                        $average_rating = $rated_by > 0 ? $rating / $rated_by : 0;

                        // Batasi rata-rata rating menjadi satu angka di belakang koma
                        $average_rating = number_format($average_rating, 1);

                        $fullStars = floor($average_rating); // Bintang penuh
                        $halfStar = $average_rating - $fullStars >= 0.5 ? 1 : 0; // Setengah bintang jika rating memiliki desimal > 0.5
                        $emptyStars = 5 - ($fullStars + $halfStar); // Bintang kosong

                        // Cek status toko
                        $isTokoOnline = false;
                        foreach ($storeDetails as $detail) {
                            if ($detail->is_online) {
                                $isTokoOnline = true;
                                break;
                            }
                        }

                        // dd($isTokoOnline);

                    @endphp


                    @if (Auth::check() && Auth::user()->hasRole('admin'))
                        {{-- Jika user adalah admin --}}
                        <div class="product-box {{ $isTokoOnline ? '' : 'toko-tutup' }}">
                            <input type="hidden" value="{{ $product->store_id }}" name="id">
                            <span hidden>{{ $product->id }}</span>
                            <span hidden>{{ $product->store_id }}</span>
                            <span hidden>{{ $product->slug }}</span>
                            <img alt="{{ $product->name }}" src="https://teraskabeka.com/{{ $product->photo }}"
                                loading="lazy">
                            <strong>{{ $product->name }}</strong>
                            {{-- <strong>{{ $product->toko->nama_toko }}</strong> --}}
                            <span class="quantity">Kategori:
                                {{ $product->category ? $product->category->name : 'Unknown' }}</span>
                            <span class="quantity">Toko:
                                {{ $product->toko ? $product->toko->nama_toko : 'Unknown' }}</span>
                            @if ($isTokoOnline == true)
                                <span class="text-green-500">(Toko Buka)</span>
                            @else
                                <span class="text-red-500">(Toko Tutup)</span>
                            @endif
                            <div class="flex">
                                {{-- Tampilkan bintang penuh --}}
                                @for ($i = 1; $i <= $fullStars; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                    </svg>
                                @endfor

                                {{-- Tampilkan setengah bintang jika ada --}}
                                @if ($halfStar)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M8 12.545L3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 12.545V0z" />
                                    </svg>
                                @endif

                                {{-- Tampilkan bintang kosong --}}
                                @for ($i = 1; $i <= $emptyStars; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-300 w-5 h-auto fill-current"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                    </svg>
                                @endfor

                                @if ($average_rating >= 1)
                                    <p class="mx-2">( {{ $average_rating }} / 5 )</p>
                                @else
                                    <p class="mx-2">( 0 / 0 )</p>
                                @endif
                            </div>
                            <span class="quantity"></span>
                            <span class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @if ($isTokoOnline == true)
                                <a href="javascript:void(0)" data-product-id="{{ $product->id }}"
                                    data-store-id="{{ $product->store_id }}"
                                    data-category-id="{{ $product->category_id }}" data-slug="{{ $product->slug }}"
                                    class="cart-btn">
                                    <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                                </a>
                            @else
                                <a href="javascript:void(0)" data-product-id="{{ $product->id }}"
                                    data-store-id="{{ $product->store_id }}"
                                    data-category-id="{{ $product->category_id }}" data-slug="{{ $product->slug }}"
                                    class="w-full h-[40px] bg-red-100 text-red-600 flex justify-center items-center mt-[20px] transition-all duration-300 ease-linear"
                                    disabled>
                                    <i class="fas fa-ban"></i> Toko Tutup
                                </a>
                            @endif
                            {{-- Tambahkan menu khusus admin --}}
                            <form action="{{ config('app_url') . '/admin/vip-product' }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="store_id" value="{{ $product->store_id }}">

                                <!-- Option to set the product as VIP -->
                                @if ($product->is_vip === 0 && $products->where('is_vip', true)->count() < 3)
                                    <button type="submit" class="" name="action" value="set_vip">
                                        <i class="fa-solid fa-star"></i> Jadikan Teratas
                                    </button>
                                @else
                                    <button type="submit" class="hidden">
                                        <i class="fa-solid fa-star"></i> Jadikan Teratas
                                    </button>
                                    <button type="submit" class="" name="action" value="cancel">
                                        <i class="fa-solid fa-star"></i> Batalkan Teratas
                                    </button>
                                @endif
                            </form>
                        </div>
                    @elseif (!Auth::check())
                        {{-- Jika user belum login, tampilkan detail toko --}}
                        <div class="product-box {{ $isTokoOnline ? '' : 'toko-tutup' }}">
                            <input type="hidden" value="{{ $product->store_id }}" name="id">
                            <span hidden>{{ $product->id }}</span>
                            <span hidden>{{ $product->store_id }}</span>
                            <span hidden>{{ $product->slug }}</span>
                            <img alt="{{ $product->name }}" src="https://teraskabeka.com/{{ $product->photo }}"
                                loading="lazy">
                            <strong>{{ $product->name }}</strong>
                            {{-- <strong>{{ $product->toko->nama_toko }}</strong> --}}
                            <span class="quantity">Kategori:
                                {{ $product->category ? $product->category->name : 'Unknown' }}</span>
                            <span class="quantity">Toko:
                                {{ $product->toko ? $product->toko->nama_toko : 'Unknown' }}</span>
                            <div class="flex">
                                {{-- Tampilkan bintang penuh --}}
                                @for ($i = 1; $i <= $fullStars; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                    </svg>
                                @endfor

                                {{-- Tampilkan setengah bintang jika ada --}}
                                @if ($halfStar)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M8 12.545L3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 12.545V0z" />
                                    </svg>
                                @endif

                                {{-- Tampilkan bintang kosong --}}
                                @for ($i = 1; $i <= $emptyStars; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-300 w-5 h-auto fill-current"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                    </svg>
                                @endfor

                                @if ($average_rating >= 1)
                                    <p class="mx-2">( {{ $average_rating }} / 5 )</p>
                                @else
                                    <p class="mx-2">( 0 / 0 )</p>
                                @endif
                            </div>

                            <span class="quantity"></span>
                            @if ($isTokoOnline == true)
                                <span class="text-green-500">(Toko Buka)</span>
                            @else
                                <span class="text-red-500">(Toko Tutup)</span>
                            @endif

                            <span class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @if ($isTokoOnline == true)
                                <a href="javascript:void(0)" data-product-id="{{ $product->id }}"
                                    data-store-id="{{ $product->store_id }}"
                                    data-category-id="{{ $product->category_id }}" data-slug="{{ $product->slug }}"
                                    class="cart-btn">
                                    <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                                </a>
                            @else
                                <a href="javascript:void(0)" data-product-id="{{ $product->id }}"
                                    data-store-id="{{ $product->store_id }}"
                                    data-category-id="{{ $product->category_id }}" data-slug="{{ $product->slug }}"
                                    class="w-full h-[40px] bg-red-100 text-red-600 flex justify-center items-center mt-[20px] transition-all duration-300 ease-linear"
                                    disabled>
                                    <i class="fas fa-ban"></i> Toko Tutup
                                </a>
                            @endif
                        </div>
                    @else
                        {{-- Tampilan default jika user sudah login tapi bukan admin --}}
                        <div class="product-box">
                            <input type="hidden" value="{{ $product->store_id }}" name="id">
                            <span hidden>{{ $product->id }}</span>
                            <span hidden>{{ $product->store_id }}</span>
                            <span hidden>{{ $product->slug }}</span>
                            <img alt="{{ $product->name }}" src="https://teraskabeka.com/{{ $product->photo }}"
                                loading="lazy">
                            <strong>{{ $product->name }}</strong>
                            {{-- <strong>{{ $product->toko->nama_toko }}</strong> --}}
                            <span class="quantity">Kategori:
                                {{ $product->category ? $product->category->name : 'Unknown' }}</span>
                            <span class="quantity">Toko:
                                {{ $product->toko ? $product->toko->nama_toko : 'Unknown' }}</span>
                            @if ($isTokoOnline == true)
                                <span class="text-green-500">(Toko Buka)</span>
                            @else
                                <span class="text-red-500">(Toko Tutup)</span>
                            @endif
                            <div class="flex">
                                {{-- Tampilkan bintang penuh --}}
                                @for ($i = 1; $i <= $fullStars; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16">
                                        <path
                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                    </svg>
                                @endfor

                                {{-- Tampilkan setengah bintang jika ada --}}
                                @if ($halfStar)
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16">
                                        <path
                                            d="M8 12.545L3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 12.545V0z" />
                                    </svg>
                                @endif

                                {{-- Tampilkan bintang kosong --}}
                                @for ($i = 1; $i <= $emptyStars; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-300 w-5 h-auto fill-current"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                    </svg>
                                @endfor

                                @if ($average_rating >= 1)
                                    <p class="mx-2">( {{ $average_rating }} / 5 )</p>
                                @else
                                    <p class="mx-2">( 0 / 0 )</p>
                                @endif
                            </div>
                            <span class="quantity"></span>
                            <span class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @if ($isTokoOnline == true)
                                <a href="javascript:void(0)" data-product-id="{{ $product->id }}"
                                    data-store-id="{{ $product->store_id }}"
                                    data-category-id="{{ $product->category_id }}" data-slug="{{ $product->slug }}"
                                    class="cart-btn">
                                    <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                                </a>
                            @else
                                <a href="javascript:void(0)" data-product-id="{{ $product->id }}"
                                    data-store-id="{{ $product->store_id }}"
                                    data-category-id="{{ $product->category_id }}" data-slug="{{ $product->slug }}"
                                    class="w-full h-[40px] bg-red-100 text-red-600 flex justify-center items-center mt-[20px] transition-all duration-300 ease-linear"
                                    disabled>
                                    <i class="fas fa-ban"></i> Toko Tutup
                                </a>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
            @include('partials.cart')
        </section>

    </section>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const copyButton = document.getElementById("copy-link-btn");
            const shareButton = document.getElementById("share-link-btn");

            // Copy Link to Clipboard
            copyButton.addEventListener("click", async () => {
                const link = window.location.href; // URL saat ini
                try {
                    await navigator.clipboard.writeText(link);
                    alert("Link copied to clipboard!");
                } catch (err) {
                    console.error("Failed to copy link: ", err);
                    alert("Failed to copy the link. Please try again.");
                }
            });

            // Share Link
            shareButton.addEventListener("click", async () => {
                const link = window.location.href; // URL saat ini
                const title = document.title; // Judul halaman
                const text = "Ayo Lihat Toko Ini!";

                // Periksa apakah browser mendukung Web Share API
                if (navigator.share) {
                    try {
                        await navigator.share({
                            title: title,
                            text: text,
                            url: link,
                        });
                        console.log("Shared successfully!");
                    } catch (err) {
                        console.error("Error sharing: ", err);
                        alert("Failed to share the link. Please try again.");
                    }
                } else {
                    alert("Sharing not supported on this browser. Please copy the link manually.");
                }
            });
        });
    </script>
    
    <script defer
        src="https://rawcdn.githack.com/gragemediatechnology/keyFood/64887d1180dabea3764552a01facbfafcff0560c/public/js/product.js">
    </script>
    <script defer
        src="https://rawcdn.githack.com/gragemediatechnology/keyFood/64887d1180dabea3764552a01facbfafcff0560c/public/js/categories.js">
    </script>
@endsection
