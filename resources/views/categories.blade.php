@extends('layouts.main')

@section('container')
<section id="home" class="mt-11">
    <section id="search-banner">
        {{-- bg --}}
        <img alt="bg" class="bg-1" src="img/bg-1.png">
        <img alt="bg-2" class="bg-2" src="img/topping.png">
        {{-- text --}}
        <div class="search-banner-text">
            <h1>Pesan Makananmu Sekarang!</h1>
            <strong>#GratisOngkir</strong>
            {{-- search --}}
            <form action="" class="search-boxs" onsubmit="return false;">
                <i class="fas fa-search"></i>
                <input type="text" id="search" class="search-inputs" placeholder="Cari makanan yang anda mau"
                    name="search">
                <input type="submit" class="search-btns" value="Search">
            </form>
        </div>
    </section>

    <section id="category">
        <div class="category-heading">
            <h2>Kategori</h2>
            <a href="#" class="showall active"><span>Semua</span></a>
        </div>
        <div class="category-container">
            @foreach ($categories as $category)
                <a href="#" class="category-box" data-category="{{ $category->name }}">
                    <img alt="Product" src="{{ $category->icon }}">
                    <span>{{ $category->name }}</span>
                </a>
            @endforeach
        </div>
    </section>

    <section id="popular-bundle-pack">
        <div class="product-heading">
            <h3>Daftar Produk</h3>
        </div>
        <div class="product-container" id="product-list">
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
                        @endphp



                        <div class="product-box">
                            <span hidden>{{ $product->id }}</span>
                            <span hidden>{{ $product->store_id }}</span>
                            <span hidden>{{ $product->slug }}</span>
                            <img alt="{{ $product->name }}" src="{{ $product->photo }}">
                            <strong>{{ $product->name }}</strong>
                            <strong>{{ $product->toko->nama_toko }}</strong>
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

                                @if ($average_rating > 1)
                                    <p>( {{ $average_rating }} / 5)</p>
                                @else
                                    <p>Belum Ada Rating</p>
                                @endif
                            </div>
                            <span class="quantity"></span>
                            <span class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <a href="javascript:void(0)" data-product-id="{{ $product->id }}"
                                data-store-id="{{ $product->store_id }}" data-category-id="{{ $product->category_id }}"
                                data-slug="{{ $product->slug }}" class="cart-btn">
                                <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                            </a>
                        </div>
            @endforeach
        </div>

        @include('partials.cart')
        <div class="pagination">
            {{ $products->links() }}
        </div>
    </section>
    @endsection
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            let selectedCategory = ''; // Variabel untuk menyimpan kategori yang dipilih

            // Live Search
            $('#search').on('keyup', function () {
                var query = $(this).val();
                performSearch(query, selectedCategory); // Pencarian dilakukan dalam kategori yang dipilih
            });

            // Category Selection
            $('.category-box').on('click', function (e) {
                e.preventDefault();
                selectedCategory = $(this).data('category'); // Ambil kategori dari elemen yang diklik
                $('#search').val(''); // Kosongkan input pencarian
                $('.category-box').removeClass('active');
                $(this).addClass('active');
                performSearch('', selectedCategory); // Pencarian dilakukan hanya dalam kategori yang dipilih
            });

            // Show All Products
            $('.showall').on('click', function (e) {
                e.preventDefault();
                selectedCategory = ''; // Reset kategori yang dipilih
                $('#search').val(''); // Kosongkan input pencarian
                $('.category-box').removeClass('active');
                performSearch(); // Menampilkan semua produk
            });

            function performSearch(query = '', category = '') {
                $.ajax({
                    url: "/categories/search",
                    type: "GET",
                    data: {
                        'query': query,
                        'category': category
                    },
                    success: function (data) {
                        $('#product-list').empty(); // Kosongkan daftar produk sebelumnya

                        const products = data.data || []; // Pastikan data yang diterima adalah array produk
                        console.log(products);
                        if (Array.isArray(products) && products.length > 0) {
                            $.each(products, function (index, product) {
                                // Logika perhitungan rating
                                let rating = product.rating || 0;
                                let ratedBy = product.rated_by || 1;

                                if (typeof ratedBy === 'string') {
                                    try {
                                        ratedBy = JSON.parse(ratedBy);
                                        ratedBy = Array.isArray(ratedBy) ? ratedBy.length : ratedBy;
                                    } catch (e) {
                                        console.error("Error parsing rated_by:", e);
                                    }
                                }

                                let averageRating = ratedBy > 0 ? rating / ratedBy : 0;
                                averageRating = parseFloat(averageRating.toFixed(1));

                                let fullStars = Math.floor(averageRating); // Bintang penuh
                                let halfStar = averageRating - fullStars >= 0.5 ? 1 : 0; // Setengah bintang jika rating memiliki desimal >= 0.5
                                let emptyStars = 5 - (fullStars + halfStar); // Bintang kosong

                                let starsHtml = '';

                                // Render bintang penuh
                                for (let i = 0; i < fullStars; i++) {
                                    starsHtml += `<svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                        </svg>`;
                                }

                                // Render setengah bintang
                                if (halfStar) {
                                    starsHtml += `<svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16">
                            <path d="M8 12.545L3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 12.545V0z" />
                        </svg>`;
                                }

                                // Render bintang kosong
                                for (let i = 0; i < emptyStars; i++) {
                                    starsHtml += `<svg xmlns="http://www.w3.org/2000/svg" class="text-gray-300 w-5 h-auto fill-current" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                        </svg>`;
                                }

                                var productHtml = `
                        <div class="product-box" data-category="${product.category_id ? product.category.name : 'gaada id'}">
                            <img alt="${product.name}" src="{{ ('') }}${product.photo}">
                            <strong>${product.name}</strong>
                            <span class="quantity">Store: ${product.toko ? product.toko.nama_toko : 'Unknown'}</span>
                            <div class="flex">
                                ${starsHtml}
                                ${averageRating > 1 ? `<p>( ${averageRating} / 5)</p>` : `<p>Belum Ada Rating</p>`}
                            </div>
                            <span class="price">Rp ${new Intl.NumberFormat('id-ID').format(product.price)}</span>
                            <a href="javascript:void(0)" data-product-id="${product.id}" data-store-id="${product.store_id}" data-category-id="${product.category_id}" class="cart-btn">
                                <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                            </a>
                        </div>`;

                                $('#product-list').append(productHtml); // Tambahkan produk ke daftar
                            });
                        } else {
                            $('#product-list').append('<p class="text-gray-500">Produk Kosong</p>'); // Tampilkan pesan jika tidak ada produk
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log("Error: " + error); // Debugging jika terjadi kesalahan
                    }
                });
            }

    </script>