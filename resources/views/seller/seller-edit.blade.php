@extends('layouts.main')
@section('container')
    <section id="home" style="margin-top: -35px">
        @if (Auth::check())
            @if (Auth::user()->hasRole('seller'))
                <div class="store-header">
                    <div class="store-info">
                        <img src="https://lapakkbk.online/{{ $toko->foto_profile_toko ? 'store_image/' . $toko->foto_profile_toko : 'https://lapakkbk.online/img/markets.webp' }} "
                            alt="logo toko" class="store-logo">
                        <div class="store-text">
                            <h1>{{ $toko->nama_toko }}</h1>
                            <h2>{{ $toko->alamat_toko }}</h2>
                            <h2 class="px-1">
                                {{ $toko->waktu_buka && $toko->waktu_tutup ? Waktu Buka : $toko->waktu_buka . ' - ' . Waktu Tutup : $toko->waktu_tutup : 'belum menyetting waktu buka - tutup' }}
                                @if ($toko->is_online)
                                    <p class="text-green-500 text-sm">Buka</p>
                                @else
                                    <p class="text-red-500 text-sm">Tutup</p>
                                @endif
                            </h2>
                        </div>
                        <div class="edit-button-container">
                            <a href="/seller/edit_toko/{{ $toko->id_toko }}">
                                <button type="button"
                                    class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Edit
                                    Toko
                                </button>
                            </a>
                            @if ($toko->is_online)
                                <form action="/seller/set_status/{{ $toko->id_toko }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                        Tutup toko
                                    </button>
                                </form>
                            @else
                                <form action="/seller/set_status/{{ $toko->id_toko }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                        Buka toko
                                    </button>
                                </form>
                            @endif

                        </div>
                    </div>

                    <div class="store-description">
                        <p>{{ $toko->deskripsi_toko }}</p>
                    </div>
                </div>
                <!-- produk produk -->
                <section id="popular-bundle-pack">
                    {{-- <a href="{{ route('seller.products.create') }}"> --}}
                    <a href="/seller/products/create">
                        <button type="button"
                            class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Tambah
                            Produk</button>
                    </a>
                    <!--heading-------------->
                    <div class="product-heading">
                        <h3>Daftar Produk</h3>
                    </div>
                    <!--box-container------>
                    <div class="product-container">
                        <!--box---------->

                        @if ($product->isEmpty())
                            <p class="text-center text-gray-500">Belum ada produk</p>
                        @else
                            @foreach ($product as $p)
                                @php
                                    // Ambil nilai rating dan rated_by
                                    $rating = $p->rating ?? 0;

                                    // Jika rated_by adalah JSON, decode jadi array dan hitung elemennya, jika tidak, gunakan langsung
                                    if (is_string($p->rated_by)) {
                                        $rated_by = json_decode($p->rated_by, true);
                                        $rated_by = is_array($rated_by) ? count($rated_by) : $rated_by; // Jika array, hitung jumlahnya
                                    } else {
                                        $rated_by = $p->rated_by ?? 1; // Gunakan 1 sebagai default jika kosong
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
                                    <a class="">
                                        <div class="flex justify-end">
                                            <button id="deleteButton{{ $p->id }}"
                                                data-modal-target="deleteModal{{ $p->id }}"
                                                data-modal-toggle="deleteModal{{ $p->id }}"
                                                class="rounded-full group flex items-center justify-center focus-within:outline-red-500">
                                                <svg width="34" height="34" viewBox="0 0 34 34" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle
                                                        class="fill-red-50 transition-all duration-500 group-hover:fill-red-400"
                                                        cx="17" cy="17" r="17" />
                                                    <path
                                                        class="stroke-red-500 transition-all duration-500 group-hover:stroke-white"
                                                        d="M14.1673 13.5997V12.5923C14.1673 11.8968 14.7311 11.333 15.4266 11.333H18.5747C19.2702 11.333 19.834 11.8968 19.834 12.5923V13.5997M19.834 13.5997C19.834 13.5997 14.6534 13.5997 11.334 13.5997C6.90804 13.5998 27.0933 13.5998 22.6673 13.5997C21.5608 13.5997 19.834 13.5997 19.834 13.5997ZM12.4673 13.5997H21.534V18.8886C21.534 20.6695 21.534 21.5599 20.9807 22.1131C20.4275 22.6664 19.5371 22.6664 17.7562 22.6664H16.2451C14.4642 22.6664 13.5738 22.6664 13.0206 22.1131C12.4673 21.5599 12.4673 20.6695 12.4673 18.8886V13.5997Z"
                                                        stroke="#EF4444" stroke-width="1.6" stroke-linecap="round" />
                                                </svg>
                                            </button>
                                        </div>



                                        <!-- Main modal -->
                                        <div id="deleteModal{{ $p->id }}" tabindex="-1" aria-hidden="true"
                                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                                            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                                <!-- Modal content -->
                                                <div
                                                    class="relative p-4 text-center bg-white dark:bg-dark rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                                    <button type="button"
                                                        class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                        data-modal-toggle="deleteModal{{ $p->id }}">
                                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                    <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto"
                                                        aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <p class="mb-4 text-gray-500 dark:text-gray-300">Apakah kamu yakin ingin
                                                        menghapus produk ini?</p>
                                                    <div class="flex justify-center items-center space-x-4">
                                                        <button data-modal-toggle="deleteModal{{ $p->id }}" type="button"
                                                            class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                            Batal
                                                        </button>
                                                        <form method="POST" {{-- action="{{ route('seller.toko.delete', ['product' => $p]) }}"> --}}
                                                            action="/seller/products/destroy/{{ $p->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <img alt="pack" src="https://lapakkbk.online/{{ $p->photo }}">
                                    <strong>{{ $p->name }}</strong>
                                    <span class="category">Kategori: {{ $p->category->name }}</span>
                                    <span class="quantity">Jumlah: {{ $p->quantity }}</span>
                                    <span class="price">Harga: Rp.{{ $p->price }}</span>
                                    <div class="flex">
                                        {{-- Tampilkan bintang penuh --}}
                                        @for ($i = 1; $i <= $fullStars; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                        @endfor

                                        {{-- Tampilkan setengah bintang jika ada --}}
                                        @if ($halfStar)
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="text-yellow-500 w-5 h-auto fill-current" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 12.545L3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 12.545V0z" />
                                            </svg>
                                        @endif

                                        {{-- Tampilkan bintang kosong --}}
                                        @for ($i = 1; $i <= $emptyStars; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="text-gray-300 w-5 h-auto fill-current" viewBox="0 0 16 16">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                        @endfor

                                        @if ($average_rating >= 1)
                                            <p class="mx-2">( {{ $average_rating }} / 5 ) {{ $rated_by }}</p>
                                        @else
                                            <p class="mx-2">( 0 / 0 )</p>
                                        @endif
                                    </div>
                                    <!--cart-btn------->
                                    {{-- <a href="{{ route('seller.products.edit', $p) }}" class="cart-btn"> --}}
                                    <a href="/seller/products/edit/{{ $p->id }}" class="cart-btn">
                                        <i class="fas fa-edit"></i> Edit Produk
                                    </a>


                                </div>
                            @endforeach
                        @endif
                    </div>
                </section>
            @else
                <div
                    class="bg-gradient-to-r from-blue-100 to-blue-200 border border-blue-400 shadow-lg rounded-lg py-6 px-8 mx-4 md:mx-16 lg:mx-24 my-12 text-center">
                    <div class="flex items-center justify-center space-x-4">
                        <!-- Icon -->
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 17v5H8v-5m4-5v6m-6-4h12M5 12l7-7 7 7"></path>
                        </svg>
                        <!-- Text -->
                        <p class="text-xl font-bold text-blue-800">Anda Bukan Seller, daftar sebagai seller sekarang!</p>
                    </div>

                    <!-- Call to action button -->
                    <div class="mt-6">
                        <form action="/role-request/store" class="mb-5" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <input type="hidden" name="requested_role" value="seller">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">Mengajukan
                                Permintaan Menjadi
                                Penjual</button>
                        </form>
                    </div>
                </div>
            @endif
        @endif
    </section>
@endsection
