@extends('layouts.main')

@section('link')
    <link rel="stylesheet" href="https://rawcdn.githack.com/gragemediatechnology/keyFood/699e918c4e888784bef08b8ffce0004d019c29f0/public_html/css/product-slider.css">
    <link rel="stylesheet" href="https://rawcdn.githack.com/gragemediatechnology/keyFood/27db7ba39c81dbdafd840f462048a50468a23550/public_html/css/categories.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

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
                <div class="loading" style="display: none;">

                    <p>Loading more posts...</p>

                </div>
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

            {{-- <script>
                let currentPage = 1; // Halaman saat ini
                let loading = false; // Tampung status loading
                let hasMoreProducts = true; // Menandakan apakah masih ada produk untuk dimuat
                const loadedProducts = new Set(); // Menyimpan ID produk yang telah dimuat

                function loadMoreProducts() {
                    if (loading || !hasMoreProducts) return; // Cegah permintaan tambahan jika sedang memuat atau tidak ada produk lagi
                    loading = true; // Set status loading menjadi true

                    const loadingIndicator = document.querySelector('.loading');
                    loadingIndicator.style.display = 'block'; // Tampilkan indikator loading

                    fetch(`/product-slider?page=${currentPage}`)
                        .then(response => response.json())
                        .then(data => {
                            loadingIndicator.style.display = 'none'; // Sembunyikan indikator loading
                            loading = false; // Reset status loading

                            if (data.data.length === 0) {
                                hasMoreProducts = false; // Set ke false jika tidak ada produk untuk dimuat
                                return;
                            }

                            const container = document.getElementById('product-container');

                            // Tambahkan produk baru ke kontainer
                            data.data.forEach(product => {
                                // Cek apakah produk sudah dimuat
                                if (!loadedProducts.has(product.id)) {
                                    loadedProducts.add(product.id); // Tambahkan ID produk ke set
                                    const productBox = `
                                        <div class="product-box ${product.toko && product.toko.isOpen ? '' : 'toko-tutup'}">
                                            <img alt="${product.name}" src="${product.photo}">
                                            <strong>${product.name}</strong>
                                            <span class="quantity">Kategori: ${product.category ? product.category.name : 'Unknown'}</span>
                                            <span class="quantity">Toko: ${product.toko ? product.toko.nama_toko : 'Unknown'}</span>
                                            ${product.toko && product.toko.isOpen ? '<span class="text-green-500">(Toko Buka)</span>' : '<span class="text-red-500">(Toko Tutup)</span>'}
                                            <span class="price">Rp ${new Intl.NumberFormat('id-ID').format(product.price)}</span>
                                            <a href="javascript:void(0)" data-product-id="${product.id}" class="cart-btn">
                                                <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                                            </a>
                                        </div>
                                    `;
                                    container.insertAdjacentHTML('beforeend', productBox); // Tambahkan ke DOM
                                }
                            });

                            // Increment halaman untuk permintaan berikutnya
                            currentPage++;
                        })
                        .catch(error => {
                            console.error('Error loading products:', error);
                            loading = false; // Reset status loading
                            loadingIndicator.style.display = 'none'; // Sembunyikan indikator loading
                        });
                }

                // Event listener untuk scroll
                window.addEventListener('scroll', () => {
                    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
                        loadMoreProducts(); // Panggil fungsi load lebih banyak produk ketika mendekati bawah halaman
                    }
                });

                // Pada awal halaman, panggil fungsi untuk memuat produk pertama
                loadMoreProducts();

            </script> --}}

            <script>
                let page = 1; // Start from the first page
                let loading = false; // Prevent multiple AJAX requests

                function loadMoreProducts() {
                    if (loading) return; // Prevent multiple requests
                    loading = true; // Set loading to true

                    const loadingIndicator = document.querySelector('.loading');
                    loadingIndicator.style.display = 'block'; // Show loading indicator

                    fetch(`/product-slider?page=${page + 1}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest', // Ensure AJAX request is sent
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        loadingIndicator.style.display = 'none'; // Hide loading indicator
                        loading = false; // Reset loading state

                        // Check if there are products returned
                        if (data.data.length === 0) {
                            window.removeEventListener('scroll', scrollHandler); // Remove scroll listener if no more products
                            return; // Exit if no products to load
                        }

                        const container = document.getElementById('product-container');

                        // Append new products to the container
                        data.data.forEach(product => {
                            const productBox = `
                                <div class="product-box ${product.toko && product.toko.isOpen ? '' : 'toko-tutup'}">
                                    <img alt="${product.name}" src="${product.photo}">
                                    <strong>${product.name}</strong>
                                    <span class="quantity">Kategori: ${product.category ? product.category.name : 'Unknown'}</span>
                                    <span class="quantity">Toko: ${product.toko ? product.toko.nama_toko : 'Unknown'}</span>
                                    ${product.toko && product.toko.isOpen ? '<span class="text-green-500">(Toko Buka)</span>' : '<span class="text-red-500">(Toko Tutup)</span>'}
                                    <span class="price">Rp ${new Intl.NumberFormat('id-ID').format(product.price)}</span>
                                    <a href="javascript:void(0)" data-product-id="${product.id}" class="cart-btn">
                                        <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                                    </a>
                                </div>
                            `;
                            container.insertAdjacentHTML('beforeend', productBox);
                        });

                        // Increment the page number for the next request
                        page++;
                    })
                    .catch(error => {
                        console.error('Error loading products:', error);
                        loading = false; // Reset loading state
                        loadingIndicator.style.display = 'none'; // Hide loading indicator
                    });
                }

                // Scroll event listener
                const scrollHandler = () => {
                    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
                        loadMoreProducts(); // Load more products when reaching near the bottom
                    }
                };

                window.addEventListener('scroll', scrollHandler);
            </script>




            @include('partials.cart')
        </section>
    </section>
@endsection


@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="https://rawcdn.githack.com/gragemediatechnology/keyFood/64887d1180dabea3764552a01facbfafcff0560c/public_html/js/product.js"></script>
    <script defer src="https://rawcdn.githack.com/gragemediatechnology/keyFood/64887d1180dabea3764552a01facbfafcff0560c/public_html/js/categories.js"></script>
@endsection
