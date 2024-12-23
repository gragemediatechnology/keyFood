@extends('layouts.main')

@section('link')
    <link rel="stylesheet" href="https://rawcdn.githack.com/gragemediatechnology/keyFood/5ac470d94f12d3fd869f505c958e4f359dbde479/public_html/css/stores.css">
@endsection

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
                        placeholder="Cari Toko..." />

                    <button onclick="clearSearch()"
                        class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Semua Toko</button>
                </div>
            </form>
        </div>

        <!-- content asli -->
        <div id="store-list">
            @foreach ($stores as $store)
                <form action="/detailed-store/" method="GET">
                    <input type="hidden" value="{{ $store->id_toko }}" name="id">
                    <button type="submit">
                        <div class="container-s" id="visit">
                            <div class="user-s">
                                <img class="user-icon-s "
                                    src="https://teraskabeka.com/store_image/{{ $store->foto_profile_toko ?  $store->foto_profile_toko : 'markets.png' }}" loading="lazy"/>
                                <div class="user-info-s">
                                    <div class="user-name-s">{{ $store->nama_toko }}</div>
                                    <div class="user-description-s">Alamat : {{ $store->alamat_toko }}</div>
                                    <div class="user-description-s">Waktu Oprasional Toko : {{ $store->waktu_buka }} - {{ $store->waktu_tutup }}</div>
                                    @if ($store->is_online)
                                        <p class="text-green-500">Buka</p>
                                    @else
                                        <p class="text-red-500">Tutup</p>
                                    @endif
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
            let page = 1; // Halaman awal
            let loading = false; // Status permintaan AJAX
        
            function loadMoreStores() {
                if (loading) return; // Jangan lanjut jika sedang memuat
                loading = true;
        
                const loadingIndicator = document.createElement('div');
                loadingIndicator.classList.add('loading');
                loadingIndicator.style.display = 'block';
                document.getElementById('store-list').appendChild(loadingIndicator);
        
                fetch(`/stores?page=${page + 1}&itemsPerPage=6&ajax=true`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    loading = false;
                    loadingIndicator.remove();
        
                    // Jika tidak ada data lagi, hentikan event scroll
                    if (data.data.length === 0) {
                        window.removeEventListener('scroll', scrollHandler);
                        return;
                    }
        
                    // const container = document.getElementById('store-list');
        
                    // // Tambahkan toko ke dalam container
                    // data.data.forEach(store => {
                    //     const storeElement = `
                    //     <form action="/detailed-store/" method="GET">
                    //         <input type="hidden" value="${store.id_toko}" name="id">
                    //         <button type="submit">
                    //             <div class="container-s" id="visit">
                    //                 <div class="user-s">
                    //                     <img class="user-icon-s"
                    //                         src="https://teraskabeka.com/store_image/${store.foto_profile_toko ? store.foto_profile_toko : 'markets.png'} " loading="lazy"/>
                    //                     <div class="user-info-s">
                    //                         <div class="user-name-s">${store.nama_toko}</div>
                    //                         <div class="user-description-s">Alamat : ${store.alamat_toko}</div>
                    //                         <div class="user-description-s">Waktu Oprasional Toko : ${store.waktu_buka ? store.waktu_buka : ''} - ${store.waktu_tutup ? store.waktu_tutup : ''}</div>
                    //                         ${store.is_online 
                    //                             ? '<p class="text-green-500">Buka</p>' 
                    //                             : '<p class="text-red-500">Tutup</p>'}
                    //                     </div>
                    //                 </div>
                    //             </div>
                    //         </button>
                    //     </form>`;
        
                    //     container.insertAdjacentHTML('beforeend', storeElement);
                    // });
        
                    // page++; // Tingkatkan nomor halaman untuk permintaan berikutnya
                })
                .catch(error => {
                    console.error('Error loading stores:', error);
                    loading = false;
                });
            }
        
            const scrollHandler = () => {
                // Muat lebih banyak toko ketika mendekati bagian bawah halaman
                if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
                    loadMoreStores();
                }
            };
        
            // Tambahkan event scroll
            window.addEventListener('scroll', scrollHandler);
        </script>
        <script>
            function clearSearch() {
                document.getElementById("default-search").value = "";
            }


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
            document.getElementById('default-search').addEventListener('input', function() {
                let query = this.value;

                if (query.length > 0) {
                    $.ajax({
                        url: '/search-toko', // Ganti dengan URL untuk pencarian
                        type: 'GET',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            let resultsContainer = $('#store-list'); // sesuai ID 'store-list'
                            resultsContainer.empty(); // Kosongkan hasil sebelumnya

                            if (response.data.length > 0) {
                                response.data.forEach(function(store) {
                                    resultsContainer.append(`
                                    <form action="/detailed-store" method="GET">
                                    <input type="hidden" value="${store.id_toko}" name="id">
                                        <button type="submit">
                                            <div class="container-s" id="visit">
                                                <div class="user-s">
                                                 <img class="user-icon-s"
                                                    src="https://teraskabeka.com/store_image/${store.foto_profile_toko ? store.foto_profile_toko : 'markets.png'}" loading="lazy"/>

                                                    <div class="user-info-s">
                                                        <div class="user-name-s">${store.nama_toko}</div>
                                                        <div class="user-description-s">${store.alamat_toko}</div>
                                                        <div class="user-description-s">Waktu Oprasional Toko : ${store.waktu_buka  -  store.waktu_tutup ? store.waktu_buka  -  store.waktu_tutup : '-'}</div>
                                                        ${store.is_online ? '<p class="text-green-500">Buka</p>' : '<p class="text-red-500">Tutup</p>' }
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                    </form>
                                `);
                                });
                            } else {
                                resultsContainer.append(
                                    '<div class="h-screen flex justify-center mt-8"><div class="p-2 text-center">Toko tidak ditemukan</div></div>'
                                );
                            }
                        },
                        error: function() {
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

@section('script')
    <script defer src="https://raw.githack.com/gragemediatechnology/keyFood/main/public/js/stores.js"></script>
@endsection
