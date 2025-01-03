@extends('admin.layouts.main-admin')
@section('container-admin')
    <main class="h-screen pb-16 overflow-y-auto">
        <div class="container grid px-6 mx-auto py-4 mb-8">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Toko
            </h2>

            {{-- ini cards --}}
            <div class="container-profile" id="storesContainer">
    @foreach($stores as $store)
        <div class="card-profile">
            <p><strong>ID:</strong> {{ $store->id_toko }}</p>
            <form action="/detailed-store" method="GET">
                <input type="hidden" value="{{ $store->id_toko }}" name="id">
                <img src="https://teraskabeka.com/store_image/{{ $store->foto_profile_toko ? $store->foto_profile_toko : 'markets.png' }}" alt="Profile Picture" loading="lazy">
                <div class="flex items-center text-sm">
                    <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                        <img class="object-cover w-full h-full rounded-full" src="https://teraskabeka.com/store_image/{{ $store->foto_profile_toko ? $store->foto_profile_toko : 'markets.png' }}" alt="{{ $store->nama_toko }}" loading="lazy" />
                    </div>
                    <div>
                        <button type="submit">
                            <p class="font-semibold">{{ $store->nama_toko }}</p>
                        </button>
                    </div>
                </form>
            </div>
            <div class="info">
                <strong>Seller_id:</strong> {{ $store->id_seller }}
            </div>
            <div class="info">
                {{ $store->created_at->format('d/m/Y') }}
            </div>
            <div class="info">
                {{ $store->alamat_toko }}
            </div>
        </div>
    @endforeach
</div>

<!-- Empty div to trigger scroll event -->
<div id="loadingIndicator" class="text-center py-4" style="display: none;">
    <span>Loading...</span>
</div>



        <div class="user-table w-full overflow-hidden rounded-lg shadow-xs">
            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">ID Toko</th>
                                <th class="px-4 py-3">Nama Toko</th>
                                {{-- <th class="px-4 py-3">Id Seller</th> --}}
                                <th class="px-4 py-3">Alamat Toko</th>
                                <th class="px-4 py-3">Tanggal Join</th>
                                <th class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @foreach ($stores as $store)
                                <form action="/detailed-store" method="GET">
                                    <input type="hidden" value="{{ $store->id_toko }}" name="id">


                                    <tr class="text-gray-700 dark:text-gray-400">
                                        {{-- ID Toko --}}
                                        <td class="px-4 py-3">
                                            <div class="flex items-center text-sm">
                                                <div>
                                                    <p class="font-semibold">{{ $store->id_toko }}</p>
                                                </div>
                                            </div>
                                        </td>


                                        {{-- Nama Toko --}}
                                        <td class="px-4 py-3">
                                            <div class="flex items-center text-sm">
                                                <!-- Avatar with inset shadow -->
                                                <div class="relative w-8 h-8 mr-3 rounded-full md:block">
                                                    <img class="object-cover w-full h-full rounded-full"
                                                        src="https://teraskabeka.com/store_image/{{ $store->foto_profile_toko ? $store->foto_profile_toko : 'markets.png' }}"
                                                        alt="{{ $store->nama_toko }}" loading="lazy" />
                                                    <div class="absolute inset-0 rounded-full shadow-inner"
                                                        aria-hidden="true">
                                                    </div>
                                                </div>
                                                <div>
                                                    <button type="submit">
                                                        <p class="font-semibold">{{ $store->nama_toko }}</p>
                                                    </button>
                                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                                        {{ $store->id_seller }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                </form>
                                {{-- Alamat Toko --}}
                                <td class="px-4 py-3 text-sm">
                                    {{ $store->alamat_toko }}
                                </td>

                                {{-- Tanggal Join --}}
                                <td class="px-4 py-3 text-sm">
                                    {{ $store->created_at->format('d/m/Y') }}
                                </td>

                                {{-- Actions --}}
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-4 text-sm">
                                        {{-- INI DI HAPUS KARENA ADMIN TIDAK PUNYA AKSES UNTUK MENGEDIT TOKO --}}
                                        {{-- <a href="{{ route('admin.stores.edit', $store) }}" --}} {{-- <a
                                            href="/admin/stores/edit/{{ $store->id_toko }}"
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Edit">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                </path>
                                            </svg>
                                        </a> --}}
                                        <form method="POST" action="/admin/stores/destroy/{{ $store->id_toko }}"
                                            onsubmit="return confirmDelete()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                aria-label="Delete">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                </tr>
                            @endforeach
                        </tbody>
                </div>
                <script>
                    function confirmDelete() {
                        return confirm('Are you sure you want to delete this item?');
                    }
                </script>
            </div>
    </main>
@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    var loading = false;  // Flag to prevent multiple AJAX calls
    var nextPage = {{ $stores->currentPage() }} + 1;  // Start with the next page after the initial load
    var itemsPerPage = 5;  // Adjust this based on your pagination settings
    

    // Scroll event listener
    $(window).on('scroll', function() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100 && !loading) {
            loading = true;
            $('#loadingIndicator').show();  // Show the loading indicator
            
            // Make an AJAX request to load the next page of stores
            $.ajax({
                url: "/stores?page=" + nextPage + "&itemsPerPage=" + itemsPerPage,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.stores.length > 0) {
                        // Append the new stores to the container
                        var storesContainer = $('#storesContainer');
                        response.stores.forEach(function(store) {
                            var storeHtml = `
                                <div class="card-profile">
                                    <p><strong>ID:</strong> ${store.id_toko}</p>
                                    <form action="/detailed-store" method="GET">
                                        <input type="hidden" value="${store.id_toko}" name="id">
                                        <img src="https://teraskabeka.com/store_image/${store.foto_profile_toko ? store.foto_profile_toko : 'markets.png'}" alt="Profile Picture" loading="lazy">
                                        <div class="flex items-center text-sm">
                                            <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                                <img class="object-cover w-full h-full rounded-full" src="https://teraskabeka.com/store_image/${store.foto_profile_toko ? store.foto_profile_toko : 'markets.png'}" alt="${store.nama_toko}" loading="lazy" />
                                            </div>
                                            <div>
                                                <button type="submit">
                                                    <p class="font-semibold">${store.nama_toko}</p>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="info">
                                        <strong>Seller_id:</strong> ${store.id_seller}
                                    </div>
                                    <div class="info">
                                        ${store.created_at}
                                    </div>
                                    <div class="info">
                                        ${store.alamat_toko}
                                    </div>
                                </div>
                            `;
                            storesContainer.append(storeHtml);
                        });

                        // Update the next page number
                        nextPage = response.current_page + 1;
                    }

                    // Hide the loading indicator
                    $('#loadingIndicator').hide();
                    loading = false;

                    // If there are no more pages, hide the loading indicator permanently
                    if (!response.next_page) {
                        $(window).off('scroll');  // Stop the scroll event listener
                    }
                }
            });
        }
    });
});

</script>
