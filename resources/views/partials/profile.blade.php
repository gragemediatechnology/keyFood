<div x-data="{ isOpen: false }" @click.away="isOpen = false" class="relative inline-block" id="dropdown">
    <!-- Dropdown Button -->
    <button
        class="fixed-button flex h-12 w-12 items-center justify-center rounded-lg bg-slate-900 text-slate-100 ring-slate-100 transition hover:shadow-md hover:ring-2 overflow-hidden"
        @click="isOpen = !isOpen">
        <img class="w-full object-cover" src="{{ (Auth::user()->img ?? 'https://lapakkbk.online/img/client-1.png') }}" alt="Profile">
    </button>

    <!-- Dropdown Menu -->
    <div x-show="isOpen" id="opened"
        class="absolute right-0 mt-3 flex w-60 flex-col gap-3 rounded-xl bg-slate-900 p-4 text-slate-100 shadow-lg">

        @if (Auth::check())
            <div class="dropdown-profile">
                <div class="flex gap-3 items-center">
                    <div
                        class="flex items-center justify-center rounded-lg h-12 w-12 overflow-hidden border-2 border-slate-600">
                        <img class="w-full object-cover" src="{{ (Auth::user()->img ?? './img/client-1.png') }}"
                            alt="Profile">
                    </div>
                    <div style="width: 100%">
                        <div class="flex gap-1 text-sm font-semibold">
                            <span>
                                {{ strlen(Auth::user()->name) > 16 ? substr(Auth::user()->name, 0, 16) . '...' : Auth::user()->name }}
                            </span>
                            <span class="text-sky-400" style="color: aqua;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z">
                                    </path>
                                </svg>
                            </span>
                        </div>
                        <div class="text-xs text-slate-400">
                            {{ strlen(Auth::user()->email) > 16 ? substr(Auth::user()->email, 0, 16) . '...' : Auth::user()->email }}
                            {{ Auth::user()->phone === '0000000000' ? '' : (strlen(Auth::user()->phone) > 16 ? substr(Auth::user()->phone, 0, 16) . '...' : Auth::user()->phone) }}
                            <br>
                            @if (Auth::check() && Auth::user()->is_online)
                                <span class="text-green-500">Online</span>
                            @else
                                <span class="text-gray-500">Offline</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="border-t border-slate-500/30"></div>

                <div class="flex flex-col lg:my-4">
                    <button onclick="openProfile()" class="flex items-center gap-3 rounded-md py-2 px-3 but-prof">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd"
                                d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span style="body.dark{color:white}">Profile</span>
                    </button>

                    @if (Auth::user()->hasRole('seller'))
                        <a href="/seller/seller-edit" class="flex items-center gap-3 rounded-md py-2 px-3 but-sel">
                            <i class='bx bxs-store'></i>
                            <span class="body.dark{color:white}">Seller Page</span>
                        </a>
                    @else
                        <a href="/history" class="lg:hidden flex items-center gap-3 rounded-md py-2 px-3 mb-2 but-his">
                            <?xml version="1.0" ?><svg height="21px" version="1.1" viewBox="0 0 20 21" width="20px"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"
                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title />
                                <desc />
                                <defs />
                                <g fill="none" fill-rule="evenodd" id="Page-1" stroke="none" stroke-width="1">
                                    <g fill="currentColor" id="Core" opacity="0.9"
                                        transform="translate(-464.000000, -254.000000)">
                                        <g id="history" transform="translate(464.000000, 254.500000)">
                                            <path
                                                d="M10.5,0 C7,0 3.9,1.9 2.3,4.8 L0,2.5 L0,9 L6.5,9 L3.7,6.2 C5,3.7 7.5,2 10.5,2 C14.6,2 18,5.4 18,9.5 C18,13.6 14.6,17 10.5,17 C7.2,17 4.5,14.9 3.4,12 L1.3,12 C2.4,16 6.1,19 10.5,19 C15.8,19 20,14.7 20,9.5 C20,4.3 15.7,0 10.5,0 L10.5,0 Z M9,5 L9,10.1 L13.7,12.9 L14.5,11.6 L10.5,9.2 L10.5,5 L9,5 L9,5 Z"
                                                id="Shape" />
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <span>Riwayat Belanja</span>
                        </a>
                    @endif
            </div>
                <form method="POST" action="/logout" style="display: flex">
                    @csrf
                    <button id="logout"
                        class="flex justify-center gap-3 rounded-md bg-red-600 py-2 px-3 font-semibold hover:bg-red-500 focus:ring-2 focus:ring-red-400"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                            <path fill-rule="evenodd"
                                d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6zm10.72 4.72a.75.75 0 011.06 0l3 3a.75.75 0 010 1.06l-3 3a.75.75 0 11-1.06-1.06l1.72-1.72H9a.75.75 0 010-1.5h10.94l-1.72-1.72a.75.75 0 010-1.06z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        @else
            <p>Anda Belum Login,</p>
            <p>Tolong Login Terlebih Dahulu.</p>
            <a href="/log-reg">
                <button type="button"
                    class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Login</button>
            </a>
        @endif
    </div>
</div>

<div class="container-profile" id="profileCard">
    <div class="profile-card">
        <button onclick="hideProfile()">
            <i class="fa-solid fa-arrow-left back"></i>
        </button>
        <div class="profile-pic">
        <img src="https://lapakkbk.online/{{ (Auth::user()->img ?? '/img/client-1.png') }}" alt="user avatar">
        </div>
        <div class="profile-details">
            <div class="intro">
                @if (Auth::check())
                    <h2>{{ Auth::user()->name }}</h2>
                    @if (Auth::user()->hasRole('admin'))
                        <h4>Admin</h4>
                    @elseif (Auth::user()->hasRole('seller'))
                        <h4>Seller</h4>
                    @else
                        <h4>Buyer</h4>
                        @if (Auth::check())
                            <form action="/role-request/store" class="mb-5" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <input type="hidden" name="requested_role" value="seller">
                                <button type="submit" class="btn btn-primary">Mengajukan Permintaan Menjadi Penjual</button>
                            </form>
                        @else
                            <p>User is not authenticated.</p>
                        @endif
                    @endif
                @endif
            </div>
            
        
            
            <div class="contact-info">
                <div class="row">
                    <div class="icon">
                        <i class="fa fa-phone" style="color:var(--dark-magenta)"></i>
                    </div>
                    <div class="content">
                        <span>Phone</span>
                        <h5>{{ Auth::check() && (Auth::user()->phone === '0000000000' || Auth::user()->phone === null) ? 'Guest' : (Auth::check() ? Auth::user()->phone : 'Guest') }}

                        </h5>
                        <!-- Assuming there is a phone attribute -->
                    </div>
                </div>
                <div class="row">
                    <div class="icon">
                        <i class="fa fa-envelope-open" style="color:var(--light-green)"></i>
                    </div>
                    <div class="content">
                        <span>Email</span>
                        <h5>{{ Auth::user()->email ?? 'Guest' }}</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="icon">
                        <i class="fa fa-map-marker" style="color:var(--light-purple)"></i>
                    </div>
                    <div class="content">
                        <span>Location</span>
                        <h5>{{ Auth::user()->location ?? 'Guest' }}</h5>
                        <!-- Assuming there is a location attribute -->
                    </div>
                </div>
            </div>
            {{-- <a href="{{ route('profile.edit') }}"> --}}
            <a href="/edit-profile">
                <button class="download-btn"><i class="fa fa-edit"></i> Edit Profile</button>
            </a>
            <button type="button" data-modal-target="popup-modal" data-modal-toggle="popup-modal"
                class="text-white mt-3 bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                <i class='bx bx-trash'></i> Delete Account
            </button>
            <div id="popup-modal" tabindex="-1"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button type="button"
                            class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="popup-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-4 md:p-5 text-center">
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want
                                to delete your account?</h3>
                            <form action="{{ route('profile.destroy') }}" method="POST" class="mt-6">
                                @csrf
                                @method('DELETE')
                                <button data-modal-hide="popup-modal" type="submit"
                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                    Yes, I'm sure
                                </button>
                            </form>
                            <button data-modal-hide="popup-modal" type="button"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                                cancel</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

