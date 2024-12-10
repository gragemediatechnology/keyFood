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
                <h1>Pesan Apa Saja dan Kapan Saja!</h1>
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
                <div class="loading" style="display: none;">

                    {{-- <p>Loading more posts...</p> --}}

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

            @include('partials.cart')
            {{-- <div class="pagination">
                {{ $products->links() }}
            </div> --}}
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
                performSearch('',
                    selectedCategory); // Pencarian dilakukan hanya dalam kategori yang dipilih
            });

            // Show All Products
            $('.showall').on('click', function(e) {
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
                    success: function(data) {
                        $('#product-list').empty(); // Kosongkan daftar produk sebelumnya

                        const products = data.data || [];
                        if (Array.isArray(products) && products.length > 0) {
                            $.each(products, function(index, product) {
                                // Ambil nilai rating dan rated_by
                                var rating = product.rating || 0;
                                var rated_by = Array.isArray(product.rated_by) ? product
                                    .rated_by.length : product.rated_by || 1;
                                var average_rating = rated_by > 0 ? rating / rated_by : 0;
                                average_rating = parseFloat(average_rating.toFixed(1));

                                var fullStars = Math.floor(average_rating);
                                var halfStar = average_rating - fullStars >= 0.5 ? 1 : 0;
                                var emptyStars = 5 - (fullStars + halfStar);

                                // Cek status toko
                                var toko = product.toko;
                                var isTokoOnline = toko ? toko.is_online : false;

                                var starsHtml = '';
                                for (let i = 0; i < fullStars; i++) {
                                    starsHtml +=
                                        `<svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>`;
                                }
                                if (halfStar) {
                                    starsHtml +=
                                        ` <svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M8 12.545L3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 12.545V0z"/></svg>`;
                                }
                                for (let i = 0; i < emptyStars; i++) {
                                    starsHtml +=
                                        ` <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-300 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>`;
                                }

                                // Buat elemen HTML produk
                                let productHtml = `
                    <div class="product-box ${isTokoOnline ? '' : 'toko-tutup'}">
                        <img alt="${product.name}" src="${product.photo}" loading="lazy">
                        <strong>${product.name}</strong>
                        <span>Kategori: ${product.category ? product.category.name : 'Unknown'}</span>
                        <span>Toko: ${product.toko ? product.toko.nama_toko : 'Unknown'}</span>
                        ${!isTokoOnline ?
                         '<span class="text-red-500">(Toko Tutup)</span>'
                          :
                        '<span class="text-green-500">(Toko Buka)</span>'}

                        <div class="flex">
                                        ${starsHtml}
                                        <p>(${average_rating.toFixed(1)} / 5)</p>
                                    </div>

                        <span class="price">Rp ${new Intl.NumberFormat('id-ID').format(product.price)}</span>
                        <a href="javascript:void(0)" class="${isTokoOnline ? 'cart-btn' : 'w-full h-[40px] bg-red-100 text-red-600 flex justify-center items-center mt-[20px] transition-all duration-300 ease-linear'}"
                        data-product-id="${product.id}" data-store-id="${product.store_id}" data-category-id="${product.category_id}" data-slug="${product.slug}" ${!isTokoOnline ? 'disabled' : ''}>
                            <i class="fas fa-${isTokoOnline ? 'shopping-bag' : 'ban'}"></i> ${isTokoOnline ? 'Tambah Ke Keranjang' : 'Toko Tutup'}
                        </a>


                    </div>`;
                                $('#product-list').append(
                                    productHtml); // Tambahkan produk ke daftar
                            });

                            // // Event listener untuk tombol "Tambah ke Keranjang"
                            // $(document).on('click', '.cart-btn', function(e) {
                            //     e.preventDefault();
                            //     if ($(this).is('[disabled]')) return; // Cek jika tombol dalam kondisi disable

                            //     const productId = $(this).data('product-id');
                            //     const storeId = $(this).data('store-id');
                            //     const categoryId = $(this).data('category-id');
                            //     const slug = $(this).data('slug');

                            //     // Debugging: Tampilkan data produk yang akan ditambahkan ke keranjang
                            //     console.log('Produk Ditambahkan ke Keranjang:', {
                            //         productId,
                            //         storeId,
                            //         categoryId,
                            //         slug
                            //     });

                            //     // Lakukan operasi untuk menambahkan ke keranjang
                            //     // Contoh: $.post('/cart/add', { productId, storeId, categoryId, slug });
                            // });
                        } else {
                            $('#product-list').append('<p class="text-gray-500">Produk Tidak Ada</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error: " + error); // Debugging jika terjadi kesalahan
                    }
                });
            }

        });
    </script>

    <script>
        let page = 1; // Halaman awal
        let loading = false; // Status permintaan AJAX

        function isMobile() {
            return window.innerWidth <= 768; // Deteksi perangkat mobile
        }

        function loadMoreProducts() {
            if (loading) return; // Jangan lanjut jika sedang memuat
            loading = true;

            const loadingIndicator = document.querySelector('.loading');
            if (loadingIndicator) {
                loadingIndicator.style.display = 'block'; // Tampilkan indikator loading
            }

            fetch(`/categories?page=${page + 1}&itemsPerPage=${isMobile() ? 1 : 3}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest', // Tandai sebagai permintaan AJAX
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (loadingIndicator) {
                        loadingIndicator.style.display = 'none'; // Sembunyikan indikator loading
                    }
                    loading = false; // Reset status loading

                    // Jika tidak ada data lagi, hentikan event scroll
                    if (data.data.length === 0) {
                        window.removeEventListener('scroll', scrollHandler);
                        return;
                    }

                    const container = document.getElementById('product-list');
                    if (!container) return;

                    // Tambahkan produk ke dalam container
                    data.data.forEach(product => {
                        var rating = product.rating ?? 0;

                        // Proses `rated_by`
                        let ratedBy = 1; // Default
                        if (typeof product.rated_by === 'string') {
                            var ratedByArray = JSON.parse(product.rated_by);
                            ratedBy = Array.isArray(ratedByArray) ? ratedByArray.length : ratedByArray;
                        } else {
                            ratedBy = product.rated_by ?? 1;
                        }

                        var averageRating = ratedBy > 0 ? (rating / ratedBy).toFixed(1) : 0;
                        var fullStars = Math.floor(averageRating);
                        var halfStar = averageRating - fullStars >= 0.5 ? 1 : 0;
                        var emptyStars = 5 - (fullStars + halfStar);

                        var isTokoOnline = product.toko ? product.toko.is_online : false; // Status toko

                        var starIcons = `
                    ${'<svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>'.repeat(fullStars)}
                    ${halfStar ? '<svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M8 12.545L3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 12.545V0z"/></svg>' : ''}
                    ${'<svg xmlns="http://www.w3.org/2000/svg" class="text-gray-300 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>'.repeat(emptyStars)}
                `;

                        var productBox = `
                    <div class="product-box ${isTokoOnline ? '' : 'toko-tutup'}">
                        <img alt="${product.name}" src="${product.photo}" loading="lazy">
                        <strong>${product.name}</strong>
                        <span class="quantity">Kategori: ${product.category ? product.category.name : 'Unknown'}</span>
                        <span class="quantity">Toko: ${product.toko ? product.toko.nama_toko : 'Unknown'}</span>
                        ${isTokoOnline ? '<span class="text-green-500">(Toko Buka)</span>' : '<span class="text-red-500">(Toko Tutup)</span>'}
                        <div class="flex">
                            ${starIcons}
                            <p class="mx-2">(${averageRating} / 5)</p>
                        </div>
                        <span class="price">Rp ${new Intl.NumberFormat('id-ID').format(product.price)}</span>
                        ${isTokoOnline
                            ? `<a href="javascript:void(0)" data-product-id="${product.id}" data-alamat-toko="${product.toko.alamat_toko}" data-store-id="${product.store_id}" data-category-id="${product.category_id}" data-slug="${product.slug}" class="cart-btn">
                                            <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                                        </a>`
                            : `<a href="javascript:void(0)" class="w-full h-[40px] bg-red-100 text-red-600 flex justify-center items-center mt-[20px] transition-all duration-300 ease-linear">
                                            <i class="fas fa-ban"></i> Toko Tutup
                                        </a>`}
                    </div>
                `;

                        container.insertAdjacentHTML('beforeend', productBox);
                    });


                    page++; // Tingkatkan nomor halaman untuk permintaan berikutnya
                })
                .catch(error => {
                    console.error('Error loading products:', error);
                    loading = false; // Reset status loading
                    if (loadingIndicator) {
                        loadingIndicator.style.display = 'none';
                    }
                });
        }

        const scrollHandler = () => {
            // Muat lebih banyak produk ketika mendekati bagian bawah halaman
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
                loadMoreProducts();
            }
        };

        // Tambahkan event scroll
        window.addEventListener('scroll', scrollHandler);

        // Muat produk pertama kali ketika halaman selesai dimuat
        document.addEventListener('DOMContentLoaded', () => {
            // Set jumlah produk awal berdasarkan perangkat
            // const itemsPerPage = isMobile() ? 1 : 3;
            const itemsPerPage = isMobile() ? 1 : 3;

            // Muat halaman pertama dengan jumlah produk sesuai perangkat
            fetch(`/categories?page=${page}&itemsPerPage=${itemsPerPage}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('product-list');
                    data.data.forEach(product => {
                        console.log('coba', data);
                        var rating = product.rating ?? 0;

                        // Proses `rated_by`
                        let ratedBy = 1; // Default
                        if (typeof product.rated_by === 'string') {
                            var ratedByArray = JSON.parse(product.rated_by);
                            ratedBy = Array.isArray(ratedByArray) ? ratedByArray.length : ratedByArray;
                        } else {
                            ratedBy = product.rated_by ?? 1;
                        }

                        var averageRating = ratedBy > 0 ? (rating / ratedBy).toFixed(1) : 0;
                        var fullStars = Math.floor(averageRating);
                        var halfStar = averageRating - fullStars >= 0.5 ? 1 : 0;
                        var emptyStars = 5 - (fullStars + halfStar);

                        var isTokoOnline = product.toko ? product.toko.is_online : false; // Status toko

                        var starIcons = `
                    ${'<svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>'.repeat(fullStars)}
                    ${halfStar ? '<svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M8 12.545L3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 12.545V0z"/></svg>' : ''}
                    ${'<svg xmlns="http://www.w3.org/2000/svg" class="text-gray-300 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>'.repeat(emptyStars)}
                `;

                        const productBox = `
                    <div class="product-box ${isTokoOnline ? '' : 'toko-tutup'}">
                        <img alt="${product.name}" src="${product.photo}" loading="lazy">
                        <strong>${product.name}</strong>
                        <span class="quantity">Kategori: ${product.category ? product.category.name : 'Unknown'}</span>
                        <span class="quantity">Toko: ${product.toko ? product.toko.nama_toko : 'Unknown'}</span>
                        ${isTokoOnline ? '<span class="text-green-500">(Toko Buka)</span>' : '<span class="text-red-500">(Toko Tutup)</span>'}
                        <div class="flex">
                            ${starIcons}
                            <p class="mx-2">(${averageRating} / 5)</p>
                        </div>
                        <span class="price">Rp ${new Intl.NumberFormat('id-ID').format(product.price)}</span>
                        ${isTokoOnline
                            ? `<a href="javascript:void(0)" data-product-id="${product.id}" data-store-id="${product.store_id}" data-alamat-toko="${product.toko.alamat_toko}" data-category-id="${product.category_id}" data-slug="${product.slug}" class="cart-btn">
                                            <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                                        </a>`
                            : `<a href="javascript:void(0)" class="w-full h-[40px] bg-red-100 text-red-600 flex justify-center items-center mt-[20px] transition-all duration-300 ease-linear">
                                            <i class="fas fa-ban"></i> Toko Tutup
                                        </a>`}
                    </div>
                `;

                        container.insertAdjacentHTML('beforeend', productBox);
                    });
                })
                .catch(error => console.error('Error loading initial products:', error));
        });
    </script>

    @section('script')
        <script defer
            src="https://rawcdn.githack.com/gragemediatechnology/keyFood/64887d1180dabea3764552a01facbfafcff0560c/public_html/js/categories.js">
        </script>
    @endsection
