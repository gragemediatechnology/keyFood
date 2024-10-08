@extends('layouts.main')

@section('container')
    <section id="home">
        <!-- Flash message untuk success -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4 mt-12">
                {{ session('success') }}
            </div>
            <script>
                // Menghapus data cart dari localStorage setelah redirect jika ada pesan success
                localStorage.removeItem('cart');
            </script>
        @endif

        <!-- Flash message untuk error -->
        @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4 mt-12">
                {{ session('error') }}
            </div>
        @endif

        <!-- Cek apakah ada pesanan -->
        @if ($orders->isEmpty())
            <!-- Section ketika tidak ada order -->
            <section class="bg-transparent min-h-screen flex items-center justify-center p-4">
                <div class="bg-white rounded-2xl shadow-xl p-8 max-w-md w-full">
                    <div class="relative mb-8">
                        <img src="../img/no-order.png" alt="Empty box" class="w-40 h-40 mx-auto" />
                    </div>
                    <h2 class="text-3xl font-bold mb-4 text-gray-800">Pesanan Masih Kosong:(</h2>
                    <p class="text-gray-600 mb-8">Anda belum memesan apa pun. Temukan produk-produk menarik kami dan
                        tambahkan ke keranjang belanja Anda!</p>
                    <a href="/categories">
                        <button
                            class="w-full bg-gradient-to-r from-pink-500 to-purple-600 text-white font-semibold py-3 px-6 rounded-full hover:from-pink-600 hover:to-purple-700 transition duration-300 transform hover:scale-105">
                            Ayo Beli Sesuatu!
                        </button>
                    </a>
                    <div class="mt-6 text-center">
                        <a href="/faq"
                            class="text-sm text-purple-600 hover:text-purple-800 transition duration-300">Butuh Bantuan?
                            Chat Kami</a>
                    </div>
                </div>
            </section>
        @else
            <section class="my-20 mx-5" id="history">
                @foreach ($orders as $order)
                    <div class="history-container my-7 border border-gray-300 pt-9 rounded-lg">
                        <div class="flex flex-col sm:flex-row items-center justify-between px-3 md:px-11">
                            <div class="data p-4 max-w-full overflow-hidden">
                                <p class="font-medium text-lg leading-8 text-black whitespace-normal break-words">
                                    Order: {{ $order->no_order }}
                                </p>
                                <p class="font-medium text-lg leading-8 text-black whitespace-normal break-words">
                                    Order Selesai: {{ \Carbon\Carbon::parse($order->tanggal_order)->format('d F Y') }}
                                </p>
                                <p class="font-medium text-lg leading-8 text-black whitespace-normal break-words">
                                    Alamat: {{ $order->location }}
                                </p>
                            </div>

                            <div class="flex items-center gap-3 mt-2">
                                <button
                                    class="rounded-full px-7 py-3 bg-indigo-600 shadow-sm shadow-transparent text-white font-semibold text-sm transition-all duration-500 hover:shadow-indigo-400 hover:bg-indigo-700">
                                    Beli Lagi
                                </button>
                            </div>
                        </div>
                        <svg class="my-9 w-full" xmlns="http://www.w3.org/2000/svg" width="1216" height="2"
                            viewBox="0 0 1216 2" fill="none">
                            <path d="M0 1H1216" stroke="#D1D5DB" />
                        </svg>

                        @if ($order->orderDetails && $order->orderDetails->isNotEmpty())
                            @foreach ($order->orderDetails as $orderDetail)
                                <div class="flex flex-col sm:flex-row items-center gap-8 lg:gap-24 px-3 md:px-11">
                                    <div class="grid grid-cols-4 w-full">
                                        <div class="col-span-4 sm:col-span-1 flex justify-center">
                                            <img class="w-24 h-24 max-md:w-20 max-md:h-20 max-sm:mx-auto"
                                                src="{{ $orderDetail->products->photo ?? '' }}" alt="">
                                        </div>
                                        <div
                                            class="col-span-4 sm:col-span-3 mt-4 sm:pl-8 flex flex-col justify-center max-sm:items-center">
                                            <h6
                                                class="font-manrope font-semibold text-2xl leading-9 text-black mb-3 whitespace-nowrap">
                                                {{ $orderDetail->products->name ?? 'Product not found' }}
                                            </h6>
                                            <p
                                                class="font-normal text-lg leading-8 text-gray-500 mb-8 max-md:mb-2 whitespace-nowrap">
                                                Toko: {{ $orderDetail->products->toko->nama_toko ?? 'Kosong' }}
                                            </p>
                                            <div class="flex items-center gap-x-10 gap-y-3">
                                                <span
                                                    class="font-normal text-lg leading-8 text-gray-500 dark:text-gray-300 whitespace-nowrap">Kategori:
                                                    {{ $orderDetail->products->category->name ?? 'kosong' }}</span>
                                                <span
                                                    class="font-normal text-lg leading-8 text-gray-500 dark:text-gray-300 whitespace-nowrap">Qty:
                                                    {{ $orderDetail->quantity }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-around w-full sm:pl-28 lg:pl-0">
                                        <div class="flex flex-col justify-center items-start max-sm:items-center">
                                            <p class="font-semibold text-xl leading-8 text-black whitespace-nowrap">
                                                Harga/pcs:
                                                Rp. {{ number_format($orderDetail->unit_price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- @include('partials.star-ratings') --}}
                                <!-- Form untuk memberikan rating -->
                                <div class="flex justify-center my-4">
                                    <div class="flex justify-end gap-4">
                                        <!-- Star rating form -->

                                        <!-- {{-- <form action="{{ route('rate.product', $orderDetail->product_id) }}" method="POST" -->
                                        {{-- <form action="/rate-product/{{$orderDetail->product_id }}" method="POST"
                                            id="ratingForm">
                                            @csrf
                                            <input type="hidden" name="rating" id="ratingInput">
                                            <div class="flex">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="text-yellow-500 w-5 h-auto fill-current cursor-pointer"
                                                        data-rating="{{ $i }}"
                                                        onclick="submitRating({{ $i }})" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>
                                                @endfor
                                            </div>
                                        </form> --}}

                                            @if ($orderDetail->rating === null)
    <!-- <form action="{{ route('rate.product', $orderDetail->product_id) }}" method="POST" id="ratingForm"> -->
                                        <form action="/rate-product/{{ $orderDetail->product_id }}" method="POST"
                                            id="ratingForm">
                                            @csrf
                                            <input type="hidden" name="rating" id="ratingInput">
                                            <div class="flex">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="text-yellow-500 w-5 h-auto fill-current cursor-pointer"
                                                        data-rating="{{ $i }}"
                                                        onclick="submitRating({{ $i }})" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>
                                                @endfor
                                            </div>
                                        </form>
                                    @else
                                        <p>Anda sudah memberikan rating {{ $orderDetail->rating }} untuk pembelian ini.</p>
                            @endif

                            <!-- Display average rating -->
                            <span class="text-slate-400 font-medium">
                                {{ isset($orderDetail->products) ? number_format($orderDetail->products->rating / max(count(json_decode($orderDetail->products->rated_by ?? '[]')), 1), 1) : 'N/A' }}
                                out of 5 stars
                            </span>
                    </div>
                    </div>
                    <svg class="mt-9 w-full" xmlns="http://www.w3.org/2000/svg" width="1216" height="2"
                        viewBox="0 0 1216 2" fill="none">
                        <path d="M0 1H1216" stroke="#D1D5DB" />
                    </svg>
                @endforeach
        @endif

        <div class="px-3 md:px-11 flex items-center justify-between flex-col-reverse sm:flex-row">
            <div class="flex flex-col sm:flex-row items-center">
                <!-- <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Kamu yakin menghapus orderan ini?');"> -->
                <form action="/orders/{{ $order->id }}" method="POST"
                    onsubmit="return confirm('Kamu yakin menghapus orderan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="flex items-center gap-3 py-10 pr-8 sm:border-r border-gray-300 font-normal text-xl leading-8 text-gray-500 dark:text-gray-300 group transition-all duration-500 hover:text-red-600">
                        <svg width="40" height="41" viewBox="0 0 40 41" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                class="stroke-gray-600 dark:stroke-gray-300 transition-all duration-500 group-hover:stroke-red-600"
                                d="M14.0261 14.7259L25.5755 26.2753M14.0261 26.2753L25.5755 14.7259" stroke=""
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Hapus Riwayat
                    </button>
                </form>

                <p class="complete font-normal text-xl leading-8 text-gray-500 sm:pl-8">Pembelian Berhasil!
                </p>
            </div>
            <p class="font-medium text-xl leading-8 text-black">
                <span class="text-gray-500">Total Harga: </span> &nbsp;Rp.
                {{ number_format($order->orderDetails->sum(function ($detail) {return $detail->unit_price * $detail->quantity;}),0,',','.') }}
            </p>
        </div>
        </div>
        @endforeach
    </section>
    @endif
    </section>

    <script>
        function submitRating(rating) {
            // Set the rating value to the hidden input field
            document.getElementById('ratingInput').value = rating;
            // Submit the form
            document.getElementById('ratingForm').submit();
        }
    </script>
@endsection
