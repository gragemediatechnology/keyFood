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
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
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
@endsection
