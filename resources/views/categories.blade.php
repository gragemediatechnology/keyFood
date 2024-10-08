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
                    <div class="product-box" data-category="{{ $product->category->name }}">
                        <img alt="{{ $product->name }}" src="{{ $product->photo }}">
                        <strong>{{ $product->name }}</strong>
                        <span class="quantity">Store: {{ $product->toko ? $product->toko->nama_toko : 'Unknown' }}</span>
                        <span class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <a href="javascript:void(0)" data-product-id="{{ $product->id }}"
                            data-store-id="{{ $product->store_id }}" data-category-id="{{ $product->category_id }}"
                            class="cart-btn">
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
                    // url: "{{ route('search') }}",
                    url: "/categories/search",
                    type: "GET",
                    data: {
                        'query': query,
                        'category': category
                    },
                    success: function(data) {
                        $('#product-list').empty(); // Kosongkan daftar produk sebelumnya

                        const products = data.data ||
                    []; // Pastikan data yang diterima adalah array produk
                        console.log(products);
                        if (Array.isArray(products) && products.length > 0) {
                            $.each(products, function(index, product) {
                                console.log(product.category_id);
                                var productHtml = `
                                    <div class="product-box" data-category="${product.category_id ? product.category.name : 'gaada id'}">
                                        <img alt="${product.name}" src="{{ '' }}${product.photo}">
                                        <strong>${product.name}</strong>
                                        <span class="quantity">Store: ${product.toko ? product.toko.nama_toko : 'Unknown'}</span>
                                        <span class="price">Rp ${new Intl.NumberFormat('id-ID').format(product.price)}</span>
                                        <a href="javascript:void(0)" data-product-id="${product.id}" data-store-id="${product.store_id}" data-category-id="${product.category_id}" class="cart-btn">
                                            <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                                        </a>
                                    
                                    </div>`;
                                $('#product-list').append(
                                productHtml); // Tambahkan produk ke daftar
                            });
                        } else {
                            $('#product-list').append(
                            '<p class="text-gray-500">Produk Kosong</p>'); // Tampilkan pesan jika tidak ada produk
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error: " + error); // Debugging jika terjadi kesalahan
                    }
                });
            }
        });
    </script>
