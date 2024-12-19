@extends('admin.layouts.main-admin')
@section('container-admin')
    <main class="h-screen overflow-y-auto">
        <div class="container px-6 mx-auto grid overflow-y-hidden py-4 mb-8">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Users
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




            <div class="flex justify-between mb-10">
                {{-- <form action="{{ route('clear.chats') }}" method="POST"> --}}
                <form action="/clear-chats" method="POST">
                    @csrf
                    <button type="submit"
                        class="inline-block px-4 py-2 bg-orange-500 text-black rounded-lg hover:bg-orange-600">Clear
                        Chats</button>
                </form>

                <!-- Add New User Button -->
                {{-- <a href="{{ route('admin.users.create') }}" --}}
                {{-- <a href="/admin/users/create"
                    class="inline-block px-4 py-2 bg-blue-600 text-black rounded-lg hover:bg-blue-700">
                    Add New User
                </a> --}}

                <!-- Dropdown Menu Button -->
                <div class="relative inline-flex justify-end mb-4">
                    <div>
                        <button type="button"
                            class="btn inline-flex justify-center gap-x-1.5 rounded-md bg-white px-2 py-1 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            id="menu-button" aria-expanded="false" aria-haspopup="true">
                            Roles
                            <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div id="dropdown-menu"
                        class="hidden absolute right-0 z-10 mt-8 w-32 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                        role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <div class="py-1" role="none">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                data-roles="admin">Admin</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                data-roles="">Buyer</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                data-roles="seller">Seller</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                data-roles="all">All</a> <!-- Option to show all -->
                        </div>
                    </div>
                </div>
            </div>

           
               {{-- SEARCH --}}
                <div class="flex items-center justify-center mb-4">
                    <div class="relative">
                        <input type="text" id="searchUser" placeholder="Search users..." class="border rounded-md py-2 px-4 pl-10 focus:outline-none focus:ring focus:ring-blue-300" />
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <!-- Icon Search -->
                            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 12a4 4 0 100-8 4 4 0 000 8zM2 8a6 6 0 1110.49 3.51l4.15 4.15a1 1 0 01-1.42 1.42l-4.15-4.15A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

            {{-- ini cards --}}
            <div id="user-list" class="container-profile">
                @forelse($users as $user)
                    <div class="card-profile card-table" data-roles="{{ $user->roles->pluck('name')->join(', ') }}">
                        <p><strong>ID:</strong> {{ $user->id }}</p>
                        {{-- <a href="{{ route('live-chat', $user) }}"> --}}
                        {{-- <a href="/live-chat/{{ $user->id }}"> --}}
                        <a>
                            <img src="https://teraskabeka.com/{{ $user->img ?? 'img/client-1.jpg' }}" alt="Profile Picture" loading="lazy">
                        </a>
                        <h2>{{ $user->name }}456</h2>
                        <p><strong>Role:</strong>
                            @if ($user->roles->isEmpty())
                                buyer
                            @else
                                @foreach ($user->roles as $role)
                                    {{ $role->name }}@if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            @endif
                        </p>
                        <div class="info text-sm text-gray-700 dark:text-gray-300 mt-2 break-words">
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Phone:</strong> {{ $user->phone }}</p>
                        </div>
                        @if ($user->is_online)
                            <span
                                class="inline-flex items-center bg-green-100 text-green-500 text-xs font-medium ml-1 px-2 py-0.5 rounded-full">

                                • Online
                            </span>
                        @else
                            <span
                                class="inline-flex items-center bg-gray-100 text-gray-500 text-xs font-medium ml-1 px-2 py-0.5 rounded-full">

                                • Offline
                            </span>
                        @endif

                        <button id="dropdownButton1" class="dropdown-button dark:text-gray-200">
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 8.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8 4.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8 12.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                            </svg>
                        </button>
                        <div id="dropdown1" class="dropdown-menu">
                            <ul>
                                {{-- <li>
                                    <a href="/admin/users/edit/{{ $user->id }}"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                </li> --}}
                                <li>
                                    {{-- <form method="POST" action="{{ route('admin.users.destroy', $user) }}" --}}
                                    <form method="POST" action="/admin/users/destroy/{{ $user->id }}"
                                        onsubmit="return confirmDelete()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @empty
                        <p>No users found.</p>
                @endforelse

            </div>

                <!-- Users Table -->
                <div class="user-table w-full overflow-hidden rounded-lg shadow-xs mb-8">
                    <div class="w-full overflow-x-auto">
                           {{-- SEARCH --}}
                            {{-- <div class="flex items-center max-sm:hidden justify-end mb-4">
                                <div class="relative">
                                    <input type="text" id="searchUser" placeholder="Search Users..." class="border rounded-md py-2 px-4 pl-10 focus:outline-none focus:ring focus:ring-blue-300" />
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <!-- Icon Search -->
                                        <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8 12a4 4 0 100-8 4 4 0 000 8zM2 8a6 6 0 1110.49 3.51l4.15 4.15a1 1 0 01-1.42 1.42l-4.15-4.15A6 6 0 012 8z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>   --}}
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr
                                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">Name123</th>
                                    <th class="px-4 py-3">Email</th>
                                    <th class="px-4 py-3">No. HP</th>
                                    <th class="px-4 py-3">Role</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="user-list" class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @forelse($users as $user)
                                    <tr class="text-gray-700 dark:text-gray-400 card-table"
                                        data-role s="{{ $user->roles->pluck('name')->join(', ') }}">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center text-sm">
                                                <!-- Avatar with inset shadow -->
                                                <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                                    <img class="object-cover w-full h-full rounded-full"
                                                        src="https://teraskabeka.com/{{ ($user->img ?? 'img/client-1.jpg') }}" alt="user" loading="lazy">

                                                </div>
                                                <div>
                                                    {{-- <a href="{{ route('live-chat', $user) }}"> --}}
                                                    {{-- <a href="/live-chat/{{ $user->id }}"> --}}
                                                    <a>
                                                        <p class="font-semibold">{{ $user->name }}</p>
                                                        <p class="text-xs text-gray-600 dark:text-gray-400">ID:
                                                            {{ $user->id }}
                                                        </p>
                                                        @if ($user->is_online)
                                                            <span
                                                                class="inline-flex items-center bg-green-100 text-green-500 text-xs font-medium ml-1 px-2 py-0.5 rounded-full">
                                                                • Online
                                                            </span>
                                                        @else
                                                            <span
                                                                class="inline-flex items-center bg-gray-100 text-gray-500 text-xs font-medium ml-1 px-2 py-0.5 rounded-full">
                                                                • Offline
                                                            </span>
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-sm">{{ $user->email }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $user->phone }}</td>



                                        <td class="px-4 py-3 text-sm">
                                            @if ($user->roles->isEmpty())
                                                buyer
                                            @else
                                                @foreach ($user->roles as $role)
                                                    {{ $role->name }}@if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <div class="flex gap-2">
                                                {{-- <a href="{{ route('admin.users.edit', $user) }}" --}}
                                                {{-- <a href="/admin/users/edit/{{ $user->id }}"
                                                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray">
                                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                        </path>
                                                    </svg>
                                                    Edit
                                                </a> --}}
                                                {{-- <form method="POST" action="{{ route('admin.users.destroy', $user) }}" --}}
                                                <form method="POST" action="/admin/users/destroy/{{ $user->id }}"
                                                    onsubmit="return confirmDelete()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray">
                                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-3 text-center text-gray-600 dark:text-gray-400">No
                                                users available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>

            
    {{-- SEARCH --}}

    {{-- <script>
        document.getElementById('searchUser').addEventListener('input', function () {
            let query = this.value;
        
            if (query.length > 0) {
                $.ajax({
                url: '/admin/users/search',
                type: 'GET',
                data: { query: query },
                success: function (response) {
                    let resultsContainer = $('#user-list');
                    resultsContainer.empty();

                    if (response.data.length > 0) {
                        response.data.forEach(function (user) {
                            resultsContainer.append(`
                                <tr>
                                    <td class="px-4 py-3">${user.name}</td>
                                    <td class="px-4 py-3">${user.email}</td>
                                    <td class="px-4 py-3">Rp. ${user.phone}</td>
                                </tr>
                            `);
                        });
                    } else {
                        resultsContainer.append(`
                            <tr>
                                <td colspan="5" class="text-center p-4">User tidak ditemukan</td>
                            </tr>
                        `);
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    $('#user-list').html('<tr><td colspan="5" class="text-center p-4">Terjadi kesalahan pada server</td></tr>');
                }
            });

            } else {
                location.reload(); // Refresh halaman jika input kosong
            }
        });
    </script> --}}
    <script>
        $(document).ready(function () {
    $('#searchUser').on('input', function () {
        let query = $(this).val();

        $.ajax({
            url: '/admin/users/search',
            type: 'GET',
            data: { query: query },
            success: function (response) {
                let userList = $('#user-list');
                userList.empty(); // Kosongkan daftar user sebelum menambahkan hasil baru

                if (response.data.length > 0) {
                    response.data.forEach(user => {
                        // Tambahkan elemen user ke dalam userList
                        userList.append(`
                            <tr>
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>${user.phone}</td>
                                <td>${user.roles.map(role => role.name).join(', ')}</td>
                            </tr>
                        `);
                    });
                } else {
                location.reload(); // Refresh halaman jika input kosong
                }else {
                    userList.append('<p>No users found.</p>');
                }
            },
            error: function (xhr) {
                console.error('Error during search:', xhr.responseText);
            }
        });
    });
});
    </script>

            <script>
                function confirmDelete() {
                    return confirm('Are you sure you want to delete this user?');
                }
                document.addEventListener('DOMContentLoaded', function() {
                    // Function to toggle the dropdown menu visibility
                    function toggleDropdown() {
                        const dropdownMenu = document.getElementById('dropdown-menu');
                        dropdownMenu.classList.toggle('hidden');
                    }

                    // Add click event listener to each dropdown item
                    document.querySelectorAll('#dropdown-menu a').forEach(function(item) {
                        item.addEventListener('click', function(e) {
                            e.preventDefault();

                            // Get the selected role from the clicked dropdown item
                            const selectedRole = this.getAttribute('data-roles');

                            // document.querySelector('.btn').textContent = selectedRole; //untuk mengubah text pada btn dropdown

                            // Get all the user profile rows
                            const userProfiles = document.querySelectorAll('.card-table');

                            // Loop through each user profile
                            userProfiles.forEach(function(profile) {
                                // Get the roles from the data-roles attribute
                                const profileRoles = profile.getAttribute('data-roles').split(', ')
                                    .map(role => role.trim());

                                // Check if the selected role is in the user's roles
                                if (profileRoles.includes(selectedRole) || selectedRole === 'all') {
                                    profile.style.display = ''; // Show the profile
                                } else {
                                    profile.style.display = 'none'; // Hide the profile
                                }
                            });

                            // Close the dropdown menu after selection
                            toggleDropdown();
                        });
                    });

                    // Add click event listener to the document to close the dropdown when clicking outside
                    document.addEventListener('click', function(e) {
                        const dropdownMenu = document.getElementById('dropdown-menu');
                        const menuButton = document.getElementById('menu-button');

                        if (!dropdownMenu.contains(e.target) && !menuButton.contains(e.target)) {
                            dropdownMenu.classList.add('hidden');
                        }
                    });

                    // Add click event listener to the dropdown button
                    document.getElementById('menu-button').addEventListener('click', function() {
                        toggleDropdown();
                    });
                });
            </script>
        @endsection
