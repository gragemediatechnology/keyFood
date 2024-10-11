@extends('layouts.main')
@section('container')
<section id="home">

    <div class="contain">
        <form class="search-bar">
            <label for="default-search"
                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="default-search"
                    class="block w-full p-4 ps-10 text-sm text-black border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-100 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Cari Toko..." required />
                {{-- <button type="submit"
                    class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                --}}
            </div>
        </form>
    </div>

    <!-- content asli -->
    <div id="store-list">
        @foreach ($stores as $store)
            <form action="/detailed-store/{{$store->id_toko}}" method="GET" class="form-inline">
                <!-- <input type="hidden" value="{{ $store->nama_toko }}" name="nama_toko"> -->
                <!-- <input type="hidden" value="{{ $store->id_toko }}" name="id"> -->
                <button type="submit">
                    <div class="container-s" id="visit">
                        <div class="user-s">
                            <img src="{{ $store->foto_profile_toko ? 'store_image/' . $store->foto_profile_toko : 'img/markets.webp' }}"
                                class="user-icon-s">
                            <div class="user-info-s">
                                <div class="user-name-s">{{ $store->nama_toko }}</div>
                                <div class="user-description-s">Alamat : {{ $store->alamat_toko }}</div>
                            </div>
                        </div>
                    </div>
                </button>
            </form>
        @endforeach
    </div>

    <!-- hasil pencarian -->
    <div id="search-result"></div>

    <!-- Custom CSS for Animations -->
    <style>
        .fade-in {
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeIn 0.5s forwards;
        }

        .fade-out {
            animation: fadeOut 0.5s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }
    </style>
    <script>
        const toggleButton = document.getElementById('toggleButton');
        const formSection = document.getElementById('formSection');
        const cancelButton = document.getElementById('cancelButton');

        toggleButton.addEventListener('click', () => {
            formSection.classList.remove('hidden', 'fade-out');
            formSection.classList.add('fade-in');
        });

        cancelButton.addEventListener('click', () => {
            formSection.classList.add('fade-out');
            formSection.addEventListener('animationend', () => {
                formSection.classList.add('hidden');
            }, {
                once: true
            });
        });
    </script>
    <!-- Script -->
    <script>


        document.getElementById('default-search').addEventListener('input', function () {
            let query = this.value;

            if (query.length > 0) {
                $.ajax({
                    url: '/search-toko', // Ganti dengan URL untuk pencarian
                    type: 'GET',
                    data: { query: query },
                    success: function (response) {
                        let resultsContainer = $('#store-list'); // sesuai ID 'store-list'
                        resultsContainer.empty(); // Kosongkan hasil sebelumnya

                        if (response.data.length > 0) {
                            response.data.forEach(function (store) {
                                resultsContainer.append(`
                                    <form action="/detailed-store" method="POST">
                                        @csrf
                                        <input type="hidden" value="${store.nama_toko}" name="nama_toko">
                                        <button type="submit">
                                            <div class="container-s" id="visit">
                                                <div class="user-s">
                                                    <img src="store_image/${store.foto_profile_toko}" class="user-icon-s">
                                                    <div class="user-info-s">
                                                        <div class="user-name-s">${store.nama_toko}</div>
                                                        <div class="user-description-s">${store.alamat_toko}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                    </form>
                                `);
                            });
                        } else {
                            resultsContainer.append('<div class="h-screen flex justify-center mt-8"><div class="p-2 text-center">Toko tidak ditemukan</div></div>');
                        }
                    },
                    error: function () {
                        $('#store-list').html('<div class="p-2">Server tidak merespon</div>');
                    }
                });
            } else {
                $('#store-list').empty(); // Kosongkan jika tidak ada input
            }
        });
    </script>

</section>
@endsection