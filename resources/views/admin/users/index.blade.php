@extends('admin.layouts.main-admin')
@section('container-admin')
    <main class="h-screen overflow-y-auto">
        <div class="container px-6 mx-auto grid py-4 mb-8">
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

            <div class="flex justify-between items-center mb-4">
                <button type="button" class="px-2 py-1 bg-blue-500 text-white rounded-lg" style="width: 150px;">
                    <a href="{{ route('admin.users.create') }}"
                    class="inline-block px-2 py-1 bg-indigo-600 text-black rounded-lg dark:text-white w-full">
                    Add New User
                    </a>
                </button>

                <div class="relative inline-block text-left">
                    <div>
                      <button type="button" class="inline-flex justify-center gap-x-1.5 rounded-md bg-white px-2 py-1 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" id="menu-button" aria-expanded="false" aria-haspopup="true" onclick="toggleDropdown()">
                        Roles
                        <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                          <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                      </button>
                    </div>

                    <div id="dropdown-menu" class="hidden absolute right-0 z-10 mt-2 w-32 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                      <div class="py-1" role="none">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" data-roles="1" id="menu-item-0">Admin</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" data-roles="2" id="menu-item-1">Buyer</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" data-roles="3" id="menu-item-2">Seller</a>
                      </div>
                    </div>
                </div>
            </div>


            {{-- ini cards --}}
            <div class="container-profile">
                @forelse($users as $user)
                    <div class="card-profile"  data-roles="{{ $user->roles->pluck('id')->implode(', ') }}">
                        <p><strong>ID:</strong> {{ $user->id }}</p>
                        <img src="{{ asset($user->img) }}" alt="Profile Picture">
                        <h2>{{ $user->name }}</h2>
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
                        <div class="info">
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                        </div>
                    </div>
                        <button id="dropdownButton1" class="dropdown-button dark:text-gray-200">
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 8.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8 4.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8 12.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                            </svg>
                        </button>
                        <div id="dropdown1" class="dropdown-menu">
                            <ul>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @empty
                        <p>No users found.</p>
                    @endforelse

                </div>

                <!-- Users Table -->
                <div class="user-table w-full overflow-hidden rounded-lg shadow-xs">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr
                                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Email</th>
                                    <th class="px-4 py-3">Role</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @forelse($users as $user)
                                @foreach ($user->roles as $role)

                                    <tr class="text-gray-700 dark:text-gray-400" data-roles="{{ $role->name }}>
                                        @endforeach
                                        <td class="px-4 py-3">
                                            <div class="flex items-center text-sm">
                                                <!-- Avatar with inset shadow -->
                                                <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                                    <img class="object-cover w-full h-full rounded-full"
                                                        src="{{ asset($user->img) }}" alt="" loading="lazy" />
                                                    <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true">
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="font-semibold dark:text-gray-400"> {{ $user->name }}</p>
                                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                                        ID: {{ $user->id }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-sm dark:text-gray-400">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-4 py-3 text-sm dark:text-gray-400">
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
                                                <a href="{{ route('admin.users.edit', $user) }}"
                                                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray">
                                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                        </path>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                    onsubmit="return confirmDelete()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray">
                                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8a1 1 0 00-1-1z"
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
                                            <td colspan="3" class="px-4 py-3 text-center text-gray-600 dark:text-gray-400">
                                                No users available
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>

            <script>
                function confirmDelete() {
                    return confirm('Are you sure you want to delete this user?');
                }
            </script>
        @endsection
