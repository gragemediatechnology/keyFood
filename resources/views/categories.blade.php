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
                    <input type="text" id="search" class="search-inputs rounded-full"
                        placeholder="Cari makanan yang anda mau" name="search">
                    {{-- <input type="submit" class="search-btns" value="Search"> --}}
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
            <div id="product-list" class="product-container">
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
                        $toko = $product->toko;
                        $isTokoOnline = $toko ? $toko->isOpen() : false; // Cek apakah toko buka
                    @endphp

                    <div class="product-box {{ $isTokoOnline ? '' : 'toko-tutup' }}">
                        <span hidden>{{ $product->id }}</span>
                        <span hidden>{{ $product->store_id }}</span>
                        <span hidden>{{ $product->slug }}</span>
                        <img alt="{{ $product->name }}" src="{{ $product->photo }}">
                        <strong>{{ $product->name }}</strong>
                        <span class="quantity">Kategori:
                            {{ $product->category ? $product->category->name : 'Unknown' }}</span>
                        <span class="quantity">Toko: {{ $product->toko ? $product->toko->nama_toko : 'Unknown' }}
                        </span>
                        @if (!$isTokoOnline)
                            <span class="text-red-500">(Toko Tutup)</span>
                        @else
                            <span class="text-green-500">(Toko Buka)</span>
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
                        <span class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>

                        @if ($isTokoOnline)
                            <a href="javascript:void(0)" data-product-id="{{ $product->id }}"
                                data-store-id="{{ $product->store_id }}" data-category-id="{{ $product->category_id }}"
                                data-slug="{{ $product->slug }}" class="cart-btn">
                                <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                            </a>
                        @else
                            <a href="javascript:void(0)" data-product-id="{{ $product->id }}"
                                data-store-id="{{ $product->store_id }}" data-category-id="{{ $product->category_id }}"
                                data-slug="{{ $product->slug }}"
                                class="w-full h-[40px] bg-red-100 text-red-600 flex justify-center items-center mt-[20px] transition-all duration-300 ease-linear"
                                disabled>
                                <i class="fas fa-ban"></i> Toko Tutup
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>

            <script>
                function showTokoTutupAlert(namaToko) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Toko Sedang Tutup',
                        text: 'Maaf, toko ' + namaToko + ' sedang tutup. Anda tidak bisa melakukan checkout.',
                    });
                }
            </script>

            @include('partials.cart')
            <div class="pagination">
                {{ $products->links() }}
            </div>
        </section>
    @endsection
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        let selectedCategory = ''; // Variabel untuk menyimpan kategori yang dipilih

        // Live Search
        $('#search').on('keyup', function() {
            var query = $(this).val();
            performSearch(query, selectedCategory); // Pencarian dilakukan dalam kategori yang dipilih
        });

        // Category Selection
        $('.category-box').on('click', function(e) {
            e.preventDefault();
            selectedCategory = $(this).data('category'); // Ambil kategori dari elemen yang diklik
            $('#search').val(''); // Kosongkan input pencarian
            $('.category-box').removeClass('active');
            $(this).addClass('active');
            performSearch('', selectedCategory); // Pencarian dilakukan hanya dalam kategori yang dipilih
        });

        // Show All Products
        $('.showall').on('click', function(e) {
            e.preventDefault();
            selectedCategory = ''; // Reset kategori yang dipilih
            $('#search').val(''); // Kosongkan input pencarian
            $('.category-box').removeClass('active');
            performSearch(); // Menampilkan semua produk
        });

        // Fungsi performSearch
        function performSearch(query = '', category = '') {
            $.ajax({
                url: "/categories/search",
                type: "GET",
                data: {
                    'query': query,
                    'category': category
                },
                success: function(data) {
                    $('#product-list').empty(); // Kosongkan daftar produk sebelumnya

                    const products = data.data || []; // Pastikan data yang diterima adalah array produk
                    if (Array.isArray(products) && products.length > 0) {
                        $.each(products, function(index, product) {
                            // Ambil nilai rating dan rated_by
                            var rating = product.rating || 0;

                            var rated_by;
                            if (typeof product.rated_by === 'string') {
                                try {
                                    rated_by = JSON.parse(product.rated_by);
                                    rated_by = Array.isArray(rated_by) ? rated_by.length : rated_by;
                                } catch (e) {
                                    rated_by = 1; // Default jika parsing gagal
                                }
                            } else {
                                rated_by = product.rated_by || 1;
                            }

                            var average_rating = rated_by > 0 ? rating / rated_by : 0;
                            average_rating = parseFloat(average_rating.toFixed(1));

                            var fullStars = Math.floor(average_rating);
                            var halfStar = average_rating - fullStars >= 0.5 ? 1 : 0;
                            var emptyStars = 5 - (fullStars + halfStar);

                            // Cek status toko
                            var toko = product.toko;
                            var isTokoOnline = toko ? toko.is_online : false; // Cek apakah toko buka

                            var starsHtml = '';

                            // Bintang penuh
                            for (let i = 0; i < fullStars; i++) {
                                starsHtml += `<svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>`;
                            }

                            // Bintang setengah
                            if (halfStar) {
                                starsHtml += `<svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M8 12.545L3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 12.545V0z"/></svg>`;
                            }

                            // Bintang kosong
                            for (let i = 0; i < emptyStars; i++) {
                                starsHtml += `<svg xmlns="http://www.w3.org/2000/svg" class="text-gray-300 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>`;
                            }

                            // Buat elemen HTML produk
                            var productHtml = `
                                <div class="product-box ${isTokoOnline ? '' : 'toko-tutup'}">
                                    <span hidden>${product.id}</span>
                                    <span hidden>${product.store_id}</span>
                                    <span hidden>${product.slug}</span>
                                    <img alt="${product.name}" src="${product.photo}">
                                    <strong>${product.name}</strong>
                                    <span class="quantity">Kategori: ${product.category ? product.category.name : 'Unknown'}</span>
                                    <span class="quantity">Toko: ${product.toko ? product.toko.nama_toko : 'Unknown'}
                                        ${!isTokoOnline ? '<span class="text-red-500">(Toko Tutup)</span>' : ''}
                                    </span>
                                    <div class="flex">
                                        ${starsHtml}
                                        <p>(${average_rating.toFixed(1)} / 5)</p>
                                    </div>
                                    <span class="price">Rp ${new Intl.NumberFormat('id-ID').format(product.price)}</span>
                                    <a href="javascript:void(0)" data-product-id="${product.id}" class="cart-btn">
                                        <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                                    </a>
                                </div>`;
                            $('#product-list').append(productHtml); // Tambahkan produk ke daftar
                        });
                    } else {
                        $('#product-list').append('<p class="text-gray-500">Produk Kosong</p>'); // Tampilkan pesan jika tidak ada produk
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error: " + error); // Debugging jika terjadi kesalahan
                }
            });
        }
    });
</script>

