@extends('layouts.main')
@section('container')
    <section id="home" style="margin-top: -35px">
        @if (Auth::check())
            @if (Auth::user()->hasRole('seller'))
                <div class="store-header">
                    <div class="store-info">
                        <img src="https://lapakkbk.online/store_image/{{ $toko->foto_profile_toko }}" alt="logo toko" class="store-logo">
                        <div class="store-text">
                            <h1>{{ $toko->nama_toko }}</h1>
                            <h2>{{ $toko->alamat_toko }}</h2>
                        </div>
                        <div class="edit-button-container">
                            <a href="/seller/edit_toko/{{ $toko->id_toko }}">
                                <button type="button"
                                    class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Edit
                                    Toko
                                </button>
                            </a>
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
                                <div class="product-box">
                                    <img alt="pack" src="{{ asset($p->photo) }}">
                                    <strong>{{ $p->name }}</strong>
                                    <span class="category">{{ $p->category->name }}</span>
                                    <span class="quantity">Jumlah: {{ $p->quantity }}</span>
                                    <span class="price">Harga: Rp.{{ $p->price }}</span>
                                    <!--cart-btn------->
                                    {{-- <a href="{{ route('seller.products.edit', $p) }}" class="cart-btn"> --}}
                                    <a href="/seller/products/edit/{{ $p -> id}}" class="cart-btn">
                                        <i class="fas fa-edit"></i> Edit Produk
                                    </a>
                                    {{-- trigger delete --}}
                                    {{-- <a class="view-btn"> --}}
                                    <a class="">
                                        <button id="deleteButton{{ $p->id }}" data-modal-target="deleteModal{{ $p->id }}"
                                            data-modal-toggle="deleteModal{{ $p->id }}"
                                            class="rounded-full group flex items-center justify-center focus-within:outline-red-500">
                                            <svg width="34" height="34" viewBox="0 0 34 34" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <circle
                                                    class="fill-red-50 transition-all duration-500 group-hover:fill-red-400"
                                                    cx="17" cy="17" r="17" fill="" />
                                                <path
                                                    class="stroke-red-500 transition-all duration-500 group-hover:stroke-white"
                                                    d="M14.1673 13.5997V12.5923C14.1673 11.8968 14.7311 11.333 15.4266 11.333H18.5747C19.2702 11.333 19.834 11.8968 19.834 12.5923V13.5997M19.834 13.5997C19.834 13.5997 14.6534 13.5997 11.334 13.5997C6.90804 13.5998 27.0933 13.5998 22.6673 13.5997C21.5608 13.5997 19.834 13.5997 19.834 13.5997ZM12.4673 13.5997H21.534V18.8886C21.534 20.6695 21.534 21.5599 20.9807 22.1131C20.4275 22.6664 19.5371 22.6664 17.7562 22.6664H16.2451C14.4642 22.6664 13.5738 22.6664 13.0206 22.1131C12.4673 21.5599 12.4673 20.6695 12.4673 18.8886V13.5997Z"
                                                    stroke="#EF4444" stroke-width="1.6" stroke-linecap="round" />
                                            </svg>
                                        </button>


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
                                                    <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want
                                                        to
                                                        delete
                                                        this
                                                        item?</p>
                                                    <div class="flex justify-center items-center space-x-4">
                                                        <button data-modal-toggle="deleteModal" type="button"
                                                            class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                            No, cancel
                                                        </button>
                                                        <form method="POST"
                                                            {{-- action="{{ route('seller.toko.delete', ['product' => $p]) }}"> --}}
                                                            action="/seller/products/destroy/{{ $p -> product }}">
                                                            @csrf
                                                            @method('DELETE')
                                                                <button type="submit"
                                                                        class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                                    Submit
                                                                </button>
                                                                Yes, I'm sure
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </section>
            @else
                <p class="my-24 mx-24">Anda Bukan Seller, daftar sebagai seller sekarang!</p>
            @endif
        @endif
    </section>
@endsection
