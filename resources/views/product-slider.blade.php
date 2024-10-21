@extends('layouts.main')
@section('container')
    <section id="home">
        <!-- Popular Bundle Pack Section -->
        <section id="popular-bundle-pack">
            @if (session('status') == 'TokoTutup')
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Checkout Gagal',
                        text: '{{ session('checkout') }}',
                    });
                </script>
            @endif

            <div class="product-heading">
                <h3>Daftar Produk</h3>
            </div>

            <div class="product-container" id="product-container">
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
                                class="w-full h-[40px] bg-red-100 text-red-600 flex justify-center items-center mt-[20px] transition-all duration-300 ease-linear">
                                <i class="fas fa-ban"></i> Toko Tutup
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Pagination data --}}
            <input type="hidden" id="current-page" value="{{ $products->currentPage() }}">
            <input type="hidden" id="last-page" value="{{ $products->lastPage() }}">

            {{-- Loader untuk menampilkan saat produk sedang dimuat --}}
            <div id="loader" style="display: none;">
                <p>Loading more products...</p>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    var currentPage = $('#current-page').val();
    var lastPage = $('#last-page').val();

    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
            // Cek apakah ada halaman berikutnya
            if (currentPage < lastPage) {
                loadMoreProducts();
            }
        }
    });

    function loadMoreProducts() {
        $('#loader').show(); // Tampilkan loader saat memuat

        currentPage++;

        $.ajax({
            url: '/product-slider?page=' + currentPage, // Meminta halaman selanjutnya
            type: 'GET',
            success: function(data) {
                $('#loader').hide(); // Sembunyikan loader setelah memuat

                // Append produk baru ke container produk
                $.each(data.data, function(index, product) {
                    $('#product-container').append(`
                        <div class="product-box ${product.isTokoOnline ? '' : 'toko-tutup'}">
                            <span hidden>${product.id}</span>
                            <span hidden>${product.store_id}</span>
                            <span hidden>${product.slug}</span>
                            <img alt="${product.name}" src="${product.photo}">
                            <strong>${product.name}</strong>
                            <span class="quantity">Kategori: ${product.category ? product.category.name : 'Unknown'}</span>
                            <span class="quantity">Toko: ${product.toko ? product.toko.nama_toko : 'Unknown'}</span>
                            ${product.isTokoOnline ? '<span class="text-green-500">(Toko Buka)</span>' : '<span class="text-red-500">(Toko Tutup)</span>'}
                            <div class="flex">
                                ${getStarsHtml(product)}
                                <span class="price">Rp ${parseInt(product.price).toLocaleString()}</span>
                                ${product.isTokoOnline ? `<a href="javascript:void(0)" data-product-id="${product.id}" data-store-id="${product.store_id}" data-category-id="${product.category_id}" data-slug="${product.slug}" class="cart-btn"><i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang</a>` :
                                `<a href="javascript:void(0)" data-product-id="${product.id}" data-store-id="${product.store_id}" data-category-id="${product.category_id}" data-slug="${product.slug}" class="w-full h-[40px] bg-red-100 text-red-600 flex justify-center items-center mt-[20px] transition-all duration-300 ease-linear"><i class="fas fa-ban"></i> Toko Tutup</a>`}
                        </div>
                    `);
                });

                // Update current page
                $('#current-page').val(currentPage);
            },
            error: function(xhr) {
                console.error('Error loading products:', xhr);
                $('#loader').hide();
            }
        });
    }

    function getStarsHtml(product) {
        let starsHtml = '';
        const fullStars = Math.floor(product.average_rating);
        const halfStar = product.average_rating % 1 !== 0;
        const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);

        // Full stars
        for (let i = 0; i < fullStars; i++) {
            starsHtml += `<svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" /></svg>`;
        }

        // Half star
        if (halfStar) {
            starsHtml += `<svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M8 12.545L3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 12.545V0z" /></svg>`;
        }

        // Empty stars
        for (let i = 0; i < emptyStars; i++) {
            starsHtml += `<svg xmlns="http://www.w3.org/2000/svg" class="text-gray-300 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" /></svg>`;
        }

        return starsHtml;
    }
});
</script>




            @include('partials.cart')
        </section>
    </section>
@endsection
