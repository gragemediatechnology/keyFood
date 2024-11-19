@extends('layouts.main')

@section('link')
    <link rel="stylesheet" href="https://rawcdn.githack.com/gragemediatechnology/keyFood/699e918c4e888784bef08b8ffce0004d019c29f0/public_html/css/product-slider.css">
    <link rel="stylesheet" href="https://rawcdn.githack.com/gragemediatechnology/keyFood/27db7ba39c81dbdafd840f462048a50468a23550/public_html/css/categories.css">
    <style>
        #loading {
            font-size: 16px;
            color: #555;
        }
    </style>
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

            <div id="product-container">
                @foreach ($products as $product)
                    <div class="product-box">
                        <img alt="{{ $product->name }}" src="{{ $product->photo }}">
                        <strong>{{ $product->name }}</strong>
                        <span class="quantity">Kategori: {{ $product->category ? $product->category->name : 'Unknown' }}</span>
                        <span class="quantity">Toko: {{ $product->toko ? $product->toko->nama_toko : 'Unknown' }}</span>
                        <span class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
            
            <div id="loading" class="hidden text-center py-4">
                <p>Loading...</p>
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

            <script>
                $(document).ready(function() {
                    var currentPage = $('#current-page').val();
                    var lastPage = $('#last-page').val();



                    function getStarsHtml(product) {
                        let starsHtml = '';
                        const average_rating = product.average_rating || 0;
                        const fullStars = Math.floor(average_rating);
                        const halfStar = average_rating % 1 !== 0;
                        const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);

                        // Full stars
                        for (let i = 1; i <= fullStars; i++) {
                            starsHtml +=
                                `<svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" /></svg>`;
                        }

                        // Half star
                        if (halfStar) {
                            starsHtml +=
                                `<svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M8 12.545L3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 12.545V0z" /></svg>`;
                        }

                        // Empty stars
                        for (let i = 1; i <= emptyStars; i++) {
                            starsHtml +=
                                `<svg xmlns="http://www.w3.org/2000/svg" class="text-gray-300 w-5 h-auto fill-current" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" /></svg>`;
                        }

                        return starsHtml;
                    }


                });
            </script>

            <script>
                let nextPageUrl = "{{ $products->nextPageUrl() }}";
                let isLoading = false;

                window.addEventListener('scroll', () => {
                    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100 && !isLoading && nextPageUrl) {
                        isLoading = true;
                        document.getElementById('loading').classList.remove('hidden'); // Tampilkan loading

                        fetch(nextPageUrl, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('product-container').innerHTML += data.html; // Tambahkan produk baru
                            nextPageUrl = data.next_page; // Perbarui URL halaman berikutnya
                            isLoading = false;
                            document.getElementById('loading').classList.add('hidden'); // Sembunyikan loading
                        })
                        .catch(() => {
                            alert('Gagal memuat data, silakan coba lagi.');
                            isLoading = false;
                            document.getElementById('loading').classList.add('hidden'); // Sembunyikan loading
                        });
                    }
                });
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
