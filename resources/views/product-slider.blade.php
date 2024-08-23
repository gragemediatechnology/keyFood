@extends('layouts.main')
@section('container')
    <section id="home" class="">
        <!-- Popular Bundle Pack Section -->
        <section id="popular-bundle-pack">
            <div class="product-heading">
                <h3>Daftar Product</h3>
            </div>
            <div class="product-container">
                @foreach ($products as $product)
                    <div class="product-box">
                        <span hidden>{{ $product->id }}</span>
                        <span hidden>{{ $product->store_id }}</span>
                        <img alt="{{ $product->name }}" src="{{ asset($product->photo) }}">
                        <strong>{{ $product->name }}</strong>
                        <span class="quantity"></span>
                        <span class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <a href="javascript:void(0)" 
                           data-product-id="{{ $product->id }}" 
                           data-store-id="{{ $product->store_id }}" 
                           data-category-id="{{ $product->category_id }}" 
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
    </section>
@endsection
