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


                       
            @endforeach
        </div>
        @include('partials.cart')
    </section>

</section>
@endsection