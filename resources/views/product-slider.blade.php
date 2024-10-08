@extends('layouts.main')
@section('container')
    <section id="home">
        <!-- Popular Bundle Pack Section -->
        <section id="popular-bundle-pack">
            <div class="product-heading">
                <h3>Daftar Produk</h3>
            </div>
            <div class="product-container">
                @foreach ($products as $product)
                    @php
                        // Ambil nilai rating dan rated_by, lakukan decode jika perlu
                        $rating = $product->rating ?? 0;
                        $rated_by = json_decode($product->rated_by, true) ?? 1;

                        // Hitung rata-rata rating jika rated_by lebih dari 0
                        $average_rating = $rated_by > 0 ? $rating / $rated_by : 'Belum ada rating';
                    @endphp
                    <div class="product-box">
                        <span hidden>{{ $product->id }}</span>
                        <span hidden>{{ $product->store_id }}</span>
                        <span hidden>{{ $product->slug }}</span>
                        <img alt="{{ $product->name }}" src="{{ $product->photo }}">
                        <strong>{{ $product->name }}</strong>
                        <p>Rating: {{ is_numeric($average_rating) ? number_format($average_rating, 2) : $average_rating }}
                        </p>
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
    </section>
@endsection
