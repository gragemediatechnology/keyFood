@extends('layouts.main')
@section('container')
<section id="home">
    <div class="store-header">
        @foreach ($storeDetails as $detail)
                <div class="store-info">
                    <img src="{{ $detail->foto_profile_toko ? 'https://lapakkbk.online/store_image/' . $detail->foto_profile_toko : 'https://lapakkbk.online/img/markets.webp' }}"
                        alt="logo toko" class="store-logo">
                    <div class="store-text">
                        <h1>{{ $detail->nama_toko }}</h1>
                        <h2>Alamat : {{ $detail->alamat_toko }}</h2>
                    </div>
                </div>
                <div class="store-description">
                    <p>Deskripsi Toko : {{ $detail->deskripsi_toko }}</p>
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


                        @if (Auth::user()->hasRole('admin'))
                            <div class="product-box">
                                <span hidden>{{ $product->id }}</span>
                                <span hidden>{{ $product->store_id }}</span>
                                <span hidden>{{ $product->slug }}</span>
                                <img alt="{{ $product->name }}" src="https://lapakkbk.online/{{ $product->photo }}">
                                <strong>{{ $product->name }}</strong>
                                <span class="quantity">Kategori:
                                    {{ $product->category ? $product->category->name : 'Unknown' }}</span>
                                <span class="quantity">Toko: {{ $product->toko ? $product->toko->nama_toko : 'Unknown' }}</span>
                                <div class="flex justify-center">
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
                                <span class="quantity"></span>
                                <br>
                                <span class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <a href="javascript:void(0)" data-product-id="{{ $product->id }}"
                                    data-store-id="{{ $product->store_id }}" data-category-id="{{ $product->category_id }}"
                                    data-slug="{{ $product->slug }}" class="cart-btn">
                                    <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                                </a>
                                <form action="admin/vip-product" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="store_id" value="{{ $product->store_id }}">
                                    @if ($product->is_vip == 0 && $product->toko->products()->where('is_vip', true)->count() <= 3)
                                        <button type="submit" class="">
                                            <i class="fa-solid fa-star"></i> Jadikan Teratas
                                        </button>
                                    @else
                                        <button type="submit" class="hidden">
                                            <i class="fa-solid fa-star"></i> Jadikan Teratas
                                        </button>
                                        <button type="submit" class="" name="action" value="cancel">
                                            <i class="fa-solid fa-star"></i> Batalkan Teratas
                                        </button>
                                    @endif
                                </form>
                            </div>
                        @else
                            <div class="product-box">
                                <span hidden>{{ $product->id }}</span>
                                <span hidden>{{ $product->store_id }}</span>
                                <span hidden>{{ $product->slug }}</span>
                                <img alt="{{ $product->name }}" src="{{ $product->photo }}">
                                <strong>{{ $product->name }}</strong>
                                {{-- <strong>{{ $product->toko->nama_toko }}</strong> --}}
                                <span class="quantity">Kategori:
                                    {{ $product->category ? $product->category->name : 'Unknown' }}</span>
                                <span class="quantity">Toko: {{ $product->toko ? $product->toko->nama_toko : 'Unknown' }}</span>
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
                                <span class="quantity"></span>
                                <span class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <a href="javascript:void(0)" data-product-id="{{ $product->id }}"
                                    data-store-id="{{ $product->store_id }}" data-category-id="{{ $product->category_id }}"
                                    data-slug="{{ $product->slug }}" class="cart-btn">
                                    <i class="fas fa-shopping-bag"></i> Tambah Ke Keranjang
                                </a>
                            </div>
                        @endif
            @endforeach
        </div>
        @include('partials.cart')
    </section>

</section>
@endsection