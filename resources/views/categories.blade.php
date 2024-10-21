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
                            // Hitung rata-rata rating
                            $rating = $product->rating ?? 0;
                            $rated_by = is_string($product->rated_by) ? json_decode($product->rated_by, true) : $product->rated_by ?? 1;
                            $average_rating = $rated_by > 0 ? $rating / $rated_by : 0;
                            $average_rating = number_format($average_rating, 1);

                            // Hitung bintang
                            $fullStars = floor($average_rating);
                            $halfStar = $average_rating - $fullStars >= 0.5 ? 1 : 0;
                            $emptyStars = 5 - ($fullStars + $halfStar);

                            // Cek status toko
                            $toko = $product->toko;
                            $isTokoOnline = $toko ? $toko->isOpen() : false;
                        @endphp

                        <div class="product-box {{ $isTokoOnline ? '' : 'toko-tutup' }}">
                            <img alt="{{ $product->name }}" src="{{ $product->photo }}">
                            <strong>{{ $product->name }}</strong>
                            <span class="quantity">Kategori: {{ $product->category ? $product->category->name : 'Unknown' }}</span>
                            <span class="quantity">Toko: {{ $product->toko ? $product->toko->nama_toko : 'Unknown' }}
                                @if (!$isTokoOnline)
                                    <span class="text-red-500">(Toko Tutup)</span>
                                @endif
                            </span>
                            <div class="flex">
                                @for ($i = 1; $i <= $fullStars; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                    </svg>
                                @endfor
                                @if ($halfStar)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M8 12.545L3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 12.545V0z" />
                                    </svg>
                                @endif
                                @for ($i = 1; $i <= $emptyStars; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-300 w-5 h-auto fill-current"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                    </svg>
                                @endfor
                                <p class="mx-2">({{ $average_rating }} / 5)</p>
                            </div>
                            <span class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @if ($isTokoOnline)
                                <a href="javascript:void(0)" data-product-id="{{ $product->id }}"
                                    data-store-id="{{ $product->store_id }}" class="cart-btn">
                                    <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                                </a>
                            @else
                                <a href="javascript:void(0)" onclick="showTokoTutupAlert('{{ $toko->nama_toko }}')" style="color: red;">
                                    <i class="fas fa-shopping-bag" style="color: red;"></i> Toko Tutup
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

                // Fungsi performSearch
                function performSearch(query = '', category = '') {
                    $.ajax({
                        url: "{{ route('products.search') }}", // Sesuaikan endpoint dengan route pencarian Anda
                        method: 'GET',
                        data: {
                            search: query,
                            category: category
                        },
                        success: function (response) {
                            $('#product-list').html(''); // Kosongkan list produk

                            if (response.data && response.data.length > 0) {
                                // Ulangi produk menggunakan struktur yang sama seperti di Blade
                                response.data.forEach(function (product) {
                                    let rating = product.rating ?? 0;
                                    let ratedBy = product.rated_by ?? 1;
                                    let averageRating = ratedBy > 0 ? (rating / ratedBy).toFixed(1) : 0;

                                    var fullStars = Math.floor(averageRating);
                                    var halfStar = averageRating - fullStars >= 0.5 ? 1 : 0;
                                    var emptyStars = 5 - (fullStars + halfStar);

                                    var isTokoOnline = product.toko ? product.toko.is_open : false;
                                    var tokoTutupMessage = isTokoOnline ? '' : ' (Toko Tutup)';

                                    var productHtml = `
                                            <div class="product-box ${isTokoOnline ? '' : 'toko-tutup'}">
                                                <img alt="${product.name}" src="${product.photo}">
                                                <strong>${product.name}</strong>
                                                <span class="quantity">Kategori: ${product.category?.name ?? 'Unknown'}</span>
                                                <span class="quantity">Toko: ${product.toko?.nama_toko ?? 'Unknown'}
                                                    <span class="text-red-500">${tokoTutupMessage}</span>
                                                </span>
                                                <div class="flex">
                                                    ${'★'.repeat(fullStars)}
                                                    ${halfStar ? '☆' : ''}
                                                    ${'☆'.repeat(emptyStars)}
                                                    <p class="mx-2">(${averageRating} / 5)</p>
                                                </div>
                                                <span class="price">Rp ${new Intl.NumberFormat('id-ID').format(product.price)}</span>
                                                ${isTokoOnline ? `
                                                    <a href="javascript:void(0)" data-product-id="${product.id}" data-store-id="${product.store_id}" class="cart-btn">
                                                        <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                                                    </a>
                                                ` : `
                                                    <a href="javascript:void(0)" onclick="showTokoTutupAlert('${product.toko?.nama_toko}')" style="color: red;">
                                                        <i class="fas fa-shopping-bag" style="color: red;"></i> Toko Tutup
                                                    </a>
                                                `}
                                            </div>`;
                                    $('#product-list').append(productHtml);
                                });
                            } else {
                                $('#product-list').html('<p class="text-center">Produk tidak ditemukan.</p>');
                            }
                        }
                    });
                }
            });
        </script>
    </section>
</section>
@endsection