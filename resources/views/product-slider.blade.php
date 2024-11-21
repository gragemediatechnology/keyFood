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

            {{-- <script>
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
                        console.log('123', data);

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
            </script> --}}






            @include('partials.cart')
        </section>
    </section>
@endsection


@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="https://rawcdn.githack.com/gragemediatechnology/keyFood/64887d1180dabea3764552a01facbfafcff0560c/public_html/js/product.js"></script>
    <script defer src="https://rawcdn.githack.com/gragemediatechnology/keyFood/64887d1180dabea3764552a01facbfafcff0560c/public_html/js/categories.js"></script>

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

            fetch(`/product-slider?page=${page + 1}&itemsPerPage=${isMobile() ? 1 : 3}`, {
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

                    const container = document.getElementById('product-container');
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

                        var isTokoOnline = product.toko ? product.toko.isOpen : false; // Status toko

                        var starIcons = `
                            ${'<svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>'.repeat(fullStars)}
                            ${halfStar ? '<svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M8 12.545L3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 12.545V0z"/></svg>' : ''}
                            ${'<svg xmlns="http://www.w3.org/2000/svg" class="text-gray-300 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>'.repeat(emptyStars)}
                        `;

                        var productBox = `
                            <div class="product-box ${isTokoOnline ? '' : 'toko-tutup'}">
                                <img alt="${product.name}" src="${product.photo}">
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
                                    ? `<a href="javascript:void(0)" data-product-id="${product.id}" data-store-id="${product.store_id}" data-category-id="${product.category_id}" data-slug="${product.slug}" class="cart-btn">
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
            // const itemsPerPage = isMobile() ? 1 : 3;
            const itemsPerPage = 1;

            // Muat halaman pertama dengan jumlah produk sesuai perangkat
            fetch(`/product-slider?page=${page}&itemsPerPage=${itemsPerPage}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('product-container');
                    data.data.forEach(product => {
                        console.log(data);
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

                        var isTokoOnline = product.toko ? product.toko.isOpen : false; // Status toko

                        var starIcons = `
                            ${'<svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>'.repeat(fullStars)}
                            ${halfStar ? '<svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M8 12.545L3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 12.545V0z"/></svg>' : ''}
                            ${'<svg xmlns="http://www.w3.org/2000/svg" class="text-gray-300 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>'.repeat(emptyStars)}
                        `;

                        const productBox = `
                            <div class="product-box ${isTokoOnline ? '' : 'toko-tutup'}">
                                <img alt="${product.name}" src="${product.photo}">
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
                                    ? `<a href="javascript:void(0)" data-product-id="${product.id}" data-store-id="${product.store_id}" data-category-id="${product.category_id}" data-slug="${product.slug}" class="cart-btn">
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
@endsection
