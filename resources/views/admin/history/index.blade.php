@extends('admin.layouts.main-admin')
@section('container-admin')
    <main class="h-screen overflow-y-auto">
        <div class="container px-6 mx-auto grid overflow-y-hidden py-4 mb-8">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Admin History
            </h2>

            <!-- Notifications -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        {{-- SEARCH --}}
        <div class="flex max-sm:items-center md:items-end max-sm:justify-center md:justify-end mb-4">
            <div class="relative">
                <input type="text" id="searchHistory" placeholder="Search History..."
                    class="border rounded-md py-2 px-4 pl-10 focus:outline-none focus:ring focus:ring-blue-300" />
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <!-- Icon Search -->
                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8 12a4 4 0 100-8 4 4 0 000 8zM2 8a6 6 0 1110.49 3.51l4.15 4.15a1 1 0 01-1.42 1.42l-4.15-4.15A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs mb-8">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Action</th>
                                <th class="px-4 py-3">Model</th>
                                <th class="px-4 py-3">Role</th>
                                <th class="px-4 py-3">Date</th>
                            </tr>
                        </thead>
                        <tbody id="history-list" class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800" >
                            @foreach ($histories as $history)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3 text-sm"> {{ $history->admin->name }}</td>
                                    <td class="px-4 py-3 text-sm"> {{ $history->admin->email }}</td>
                                    <td class="px-4 py-3 text-sm"> {{ $history->action }}</td>  
                                    <td class="px-4 py-3 text-sm"> {{ $history->affected_model }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        @if ($history->admin->hasRole('seller'))
                                            seller
                                        @elseif ($history->admin->hasRole('admin'))
                                            admin
                                        @else
                                            buyer
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm"> {{ $history->created_at->format('Y-m-d H:i:s') }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <div class="mt-4">
        {{ $histories->links('pagination::tailwind') }}
    </div>

    <script>
        document.getElementById('searchHistory').addEventListener('input', function () {
    let query = this.value;

    if (query.length > 0) {
        $.ajax({
            url: '/admin/history/search',
            type: 'GET',
            data: { query: query },
            success: function (response) {
                let resultsContainer = $('#history-list');
                resultsContainer.empty();

                if (response.data.length > 0) {
                    response.data.forEach(function (history) {
                        resultsContainer.append(`
                            <tr>
                                <td class="px-4 py-3">${history.admin ? history.admin.name : '-'}</td>
                                <td class="px-4 py-3">${history.admin ? history.admin.email : '-'}</td>
                                <td class="px-4 py-3">${history.action}</td>
                                <td class="px-4 py-3">${history.affected_model}</td>
                                <td class="px-4 py-3">${history.created_at}</td>
                            </tr>
                        `);
                    });
                } else {
                    resultsContainer.append(`
                        <tr>
                            <td colspan="5" class="text-center p-4">History tidak ditemukan</td>
                        </tr>
                    `);
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                $('#history-list').html('<tr><td colspan="5" class="text-center p-4">Terjadi kesalahan pada server</td></tr>');
            }
        });
    } else {
        location.reload(); // Refresh halaman jika input kosong
    }
   });

    </script>
@endsection
