@extends('layouts.main')

@section('link')
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/gragemediatechnology/keyFood/27db7ba39c81dbdafd840f462048a50468a23550/public_html/css/categories.css">
@endsection

@section('container')
    <section id="home" class="mt-11">
        <section id="search-banner">
            {{-- bg --}}
            <img alt="bg" class="bg-1" src="img/bg-1.png" loading="lazy">
            <img alt="bg-2" class="bg-2" src="img/topping.png" loading="lazy">
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
                        <img alt="Product" src="{{ $category->icon }}" loading="lazy">
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
                        <img alt="{{ $product->name }}" src="{{ $product->photo }}" loading="lazy">
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
            let selectedCategory = ''; // Kategori terpilih
            let query = ''; // Query pencarian
            let page = 1; // Halaman awal
            let loading = false; // Status permintaan AJAX

            function isMobile() {
                return window.innerWidth <= 768; // Deteksi perangkat mobile
            }

            function performSearch(query, category, resetPage = false) {
                if (resetPage) {
                    page = 1; // Reset ke halaman awal
                    $('#product-container').empty(); // Bersihkan kontainer produk
                }
                loadMoreProducts(query, category); // Muat data dengan pencarian atau kategori
            }

            function loadMoreProducts(query = '', category = '') {
                if (loading) return; // Cegah permintaan baru saat masih loading
                loading = true;

                const loadingIndicator = $('.loading');
                loadingIndicator.show(); // Tampilkan indikator loading

                const itemsPerPage = isMobile() ? 1 : 3;

                fetch(`/product-slider?page=${page}&itemsPerPage=${itemsPerPage}&query=${query}&category=${category}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    loadingIndicator.hide(); // Sembunyikan indikator loading
                    loading = false;

                    if (data.data.length === 0) {
                        window.removeEventListener('scroll', scrollHandler); // Hentikan pagination jika data habis
                        return;
                    }

                    const container = $('#product-container');
                    data.data.forEach(product => {
                        var rating = product.rating ?? 0;
                        let ratedBy = Array.isArray(product.rated_by) ? product.rated_by.length : (product.rated_by ?? 1);
                        var averageRating = ratedBy > 0 ? (rating / ratedBy).toFixed(1) : 0;
                        var fullStars = Math.floor(averageRating);
                        var halfStar = averageRating - fullStars >= 0.5 ? 1 : 0;
                        var emptyStars = 5 - (fullStars + halfStar);

                        const starIcons = `
                            ${'<i class="fas fa-star text-yellow-500"></i>'.repeat(fullStars)}
                            ${halfStar ? '<i class="fas fa-star-half-alt text-yellow-500"></i>' : ''}
                            ${'<i class="far fa-star text-gray-300"></i>'.repeat(emptyStars)}
                        `;

                        const productBox = `
                            <div class="product-box">
                                <img alt="${product.name}" src="${product.photo}" loading="lazy">
                                <strong>${product.name}</strong>
                                <span class="quantity">Kategori: ${product.category?.name || 'Unknown'}</span>
                                <div class="rating">${starIcons}</div>
                                <span class="price">Rp ${new Intl.NumberFormat('id-ID').format(product.price)}</span>
                            </div>
                        `;
                        container.append(productBox);
                    });

                    page++; // Tingkatkan halaman untuk permintaan berikutnya
                })
                .catch(error => {
                    console.error('Error loading products:', error);
                    loadingIndicator.hide();
                    loading = false;
                });
            }

            const scrollHandler = () => {
                if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
                    loadMoreProducts(query, selectedCategory);
                }
            };

            // Tambahkan event scroll
            window.addEventListener('scroll', scrollHandler);

            // Live Search
            $('#search').on('keyup', function() {
                query = $(this).val();
                performSearch(query, selectedCategory, true); // Reset halaman saat pencarian
            });

            // Pilihan Kategori
            $('.category-box').on('click', function(e) {
                e.preventDefault();
                selectedCategory = $(this).data('category') || '';
                query = ''; // Reset pencarian
                $('#search').val(''); // Kosongkan input pencarian
                $('.category-box').removeClass('active');
                $(this).addClass('active');
                performSearch(query, selectedCategory, true);
            });

            // Inisialisasi data awal
            performSearch(query, selectedCategory, true);
        });
    </script>


    @section('script')
        <script defer
            src="https://rawcdn.githack.com/gragemediatechnology/keyFood/64887d1180dabea3764552a01facbfafcff0560c/public_html/js/categories.js">
        </script>
    @endsection
