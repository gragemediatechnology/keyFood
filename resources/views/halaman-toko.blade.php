@extends('layouts.main')
@section('container')
    <section id="home">
        <div class="store-header">
            @foreach ($storeDetails as $detail)
                <div class="store-info">
                    <img src="{{ 'store_image/' . $detail->foto_profile_toko }}" alt="logo toko" class="store-logo">
                    <div class="store-text">
                        <h1>{{ $detail->nama_toko }}</h1>
                        <h2>{{ $detail->alamat_toko }}</h2>
                    </div>
                </div>
                <div class="store-description">
                    <p>{{ $detail->deskripsi_toko }}</p>
                </div>
        </div>
        @endforeach

        <!-- produk produk -->
        <section id="popular-bundle-pack">
            <!--heading-------------->
            <div class="product-heading">
                <h3>Products List</h3>
            </div>
            <!--box-container------>
            <div class="product-container">
                <!--box---------->
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
                    @endphp


                    <div class="product-box">
                        <img alt="pack" src="{{ $product->photo }}">
                        <strong>{{ $product->name }}</strong>
                        <strong>{{ $product->toko->nama_toko }}</strong>
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

                            @if ($average_rating < 1)
                                <p>( {{ $average_rating }} / 5)</p>
                            @else
                                <p>Belum Ada Rating</p>
                            @endif
                        </div>
                        <span class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <!--cart-btn------->
                        <a href="#" class="cart-btn">
                            <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                        </a>

                    </div>
                @endforeach
                {{-- <!--box---------->
                <div class="product-box">
                    <img alt="apple" src="{{ 'img/pack2.jpg') }}">
                    <strong>Large Pack</strong>
                    <span class="quantity">Lemone, Tamato, Patato,+2</span>
                    <span class="price">5$</span>
                    <!--cart-btn------->
                    <a href="#" class="cart-btn">
                        <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                    </a>
                    <!--view-btn------->
                    <a href="#" class="view-btn">
                        <i class="far fa-eye"></i>
                    </a>
                </div>
                <!--box---------->
                <div class="product-box">
                    <img alt="apple" src="{{ 'img/pack3.png') }}">
                    <strong>Small Pack</strong>
                    <span class="quantity">Lemone, Tamato, Patato</span>
                    <span class="price">3$</span>
                    <!--cart-btn------->
                    <a href="#" class="cart-btn">
                        <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                    </a>
                    <!--view-btn------->
                    <a href="#" class="view-btn">
                        <i class="far fa-eye"></i>
                    </a>
                </div>
                <!--box---------->
                <div class="product-box">
                    <img alt="pack" src="{{ 'img/pack1.png') }}">
                    <strong>Big Pack</strong>
                    <span class="quantity">Lemone, Tamato, Patato,+4</span>
                    <span class="price">9$</span>
                    <!--cart-btn------->
                    <a href="#" class="cart-btn">
                        <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                    </a>
                    <!--view-btn------->
                    <a href="#" class="view-btn">
                        <i class="far fa-eye"></i>
                    </a>
                </div>
                <!--box---------->
                <div class="product-box">
                    <img alt="apple" src="{{ 'img/pack2.jpg') }}">
                    <strong>Large Pack</strong>
                    <span class="quantity">Lemone, Tamato, Patato,+2</span>
                    <span class="price">5$</span>
                    <!--cart-btn------->
                    <a href="#" class="cart-btn">
                        <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                    </a>
                    <!--view-btn------->
                    <a href="#" class="view-btn">
                        <i class="far fa-eye"></i>
                    </a>
                </div>
                <!--box---------->
                <div class="product-box">
                    <img alt="apple" src="{{ 'img/pack3.png') }}">
                    <strong>Small Pack</strong>
                    <span class="quantity">Lemone, Tamato, Patato</span>
                    <span class="price">3$</span>
                    <!--cart-btn------->
                    <a href="#" class="cart-btn">
                        <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                    </a>
                    <!--view-btn------->
                    <a href="#" class="view-btn">
                        <i class="far fa-eye"></i>
                    </a>
                </div> --}}
            </div>
        </section>

    </section>
@endsection
