<style>
    .modal {
        transition: opacity 0.25s ease;
    }

    body.modal-active {
        overflow-x: hidden;
        overflow-y: visible !important;
    }

    .opacity-95 {
        opacity: 1;
        /* Ubah transparansi menjadi solid */
    }

    body.dark .modal-closed {
        color: white;
    }

    body.dark .modal-content {
        background-color: #111111;
    }

    body.dark .title-section {
        color: white;
    }

    body.dark .identity p {
        color: lightgray;
    }

    body.dark .list-users:hover {
        background-color: #3333;
    }
</style>

@if (Auth::check())
    @if (Auth::user()->hasRole('admin'))
        <?php
        // Hanya ambil pengguna yang mengirim pesan ke auth()->user()
        $users = \App\Models\LiveChat::where('to_user_id', auth()->id())->distinct()->get('from_user_id');
        
        // Ambil objek pengguna yang sesuai dengan ID yang telah diambil
        $users = \App\Models\User::whereIn('id', $users->pluck('from_user_id'))->get();
        
        // Hitung total pesan yang belum dibaca dari pengguna-pengguna ini
        $totalUnreadMessages = \App\Models\LiveChat::whereIn('from_user_id', $users->pluck('id'))->where('to_user_id', auth()->id())->where('is_read', false)->count();
        ?>

        {{-- <button
            class="modal-open bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-2 px-4 rounded-full fixed bottom-4 right-4 mb-4 mr-4 max-sm:mb-20">
            <i class='bx bxs-bell text-2xl sm:text-3xl'></i>
            @if ($totalUnreadMessages > 0)
                <span
                    class="absolute top-0 right-0 w-5 h-5 rounded-full bg-red-500 text-white text-xs font-bold flex items-center justify-center">
                    {{ $totalUnreadMessages }}
                </span>
            @endif
        </button> --}}
        <a href="https://wa.me/6285182629897?text=Saya%20ingin%20bertanya%20tentang%20produk%20di%20website%20Teras KBK">
            <button
                class="bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-2 px-4 rounded-full fixed bottom-4 right-4 mb-4 mr-4 max-sm:mb-20">
                <i class='bx bxs-conversation text-2xl sm:text-3xl'></i>
                <!-- Use 'bxs-conversation' for a solid style -->
            </button>
        </a>




        <!-- Modal -->
        <div class="modal opacity-0 pointer-events-none fixed inset-0 flex items-end justify-end">
           
            <div class="modal-overlay absolute inset-0 bg-black bg-opacity-50"></div>

            <div
                class="modal-container fixed z-50 bottom-0 mb-4 w-full max-w-lg md:max-w-md lg:max-w-sm h-3/4 md:h-2/3 lg:h-3/4 overflow-y-auto right-0 rounded-lg bg-white shadow-lg">
                <div
                    class="modal-close absolute top-2 right-2 mr-3 cursor-pointer flex flex-col items-center text-black text-sm z-50">
                    <svg class="modal-closed fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18"
                        height="18" viewBox="0 0 18 18">
                        <path
                            d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                        </path>
                    </svg>
                </div>

                <!-- Modal Content -->
                <div class="modal-content h-full bg-white rounded-lg w-full text-left p-4 md:p-6 lg:p-8 overflow-auto">
                    <!-- Title -->
                    <div class="flex flex-col pb-4 gap-4">
                        <!-- Title Section -->
                        <div class="title-section flex justify-between items-center">
                            <ion-icon name="people-outline" class="text-2xl"></ion-icon>
                            <span class="text-lg md:text-xl mr-12 max-sm:mr-24 font-semibold">Chat dengan Users</span>
                        </div>

                        <!-- User List Section -->
                        <div class="flow-root w-full user-list">
                            <ul>
                                @forelse($users as $user)
                                    <?php
                                    // Hitung jumlah pesan yang belum dibaca dari pengguna
                                    $unreadMessagesCount = \App\Models\LiveChat::where('from_user_id', $user->id)
                                        ->where('to_user_id', auth()->id())
                                        ->where('is_read', false)
                                        ->count();
                                    ?>
                                    <li class="py-3 sm:py-4">
                                        <a href="/live-chat/{{ $user->id }}" class="block">
                                            <div
                                                class="list-users flex items-center gap-4 py-2 hover:bg-gray-50 hover:rounded-md relative">
                                                <img class="w-10 h-10 mx-2 rounded-full"
                                                    src="{{ $user->profile_picture_url ?? 'img/client-1.jpg' }}"
                                                    alt="{{ $user->name }} image">
                                                <div class="flex-1 min-w-0 identity">
                                                    <p class="text-sm md:text-base font-medium text-gray-900 truncate">
                                                        {{ $user->name }}</p>
                                                    <p class="text-xs md:text-sm text-gray-500 truncate">
                                                        {{ $user->email }}
                                                    </p>
                                                    @if ($user->is_online)
                                                        <span class="text-green-500 text-sm">Online</span>
                                                    @else
                                                        <span class="text-gray-500">Offline</span>
                                                    @endif
                                                    @if ($unreadMessagesCount > 0)
                                                        <span
                                                            class="absolute top-0 right-0 w-5 h-5 rounded-full bg-red-500 text-white text-xs font-bold flex items-center justify-center">
                                                            {{ $unreadMessagesCount }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @empty
                                    <li>Tidak ada pesan dari pengguna lain.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <?php
        // Calculate the total unread message count from all admins for the authenticated user
        $totalUnreadMessages = \App\Models\LiveChat::where('to_user_id', auth()->id())->where('is_read', false)->count();
        ?>
        {{-- <button
            class="modal-open bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-2 px-4 rounded-full fixed bottom-4 right-4 mb-4 mr-4 max-sm:mb-20">
            <i class='bx bxs-conversation text-2xl sm:text-3xl'></i>
            @if ($totalUnreadMessages > 0)
                <span
                    class="absolute top-0 right-0 w-5 h-5 rounded-full bg-red-500 text-white text-xs font-bold flex items-center justify-center">
                    {{ $totalUnreadMessages }}
                </span>
            @endif
        </button> --}}
        <a href="https://wa.me/6285182629897?text=Saya%20ingin%20bertanya%20tentang%20produk%20di%20website%20Teras KBK">
            <button
                class="bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-2 px-4 rounded-full fixed bottom-4 right-4 mb-4 mr-4 max-sm:mb-20">
                <i class='bx bxs-conversation text-2xl sm:text-3xl'></i>
                <!-- Use 'bxs-conversation' for a solid style -->
            </button>
        </a>



        <!-- Modal -->
        <div class="modal opacity-0 pointer-events-none fixed inset-0 flex items-end justify-end">
            <div class="modal-overlay absolute inset-0 bg-black bg-opacity-50"></div>

            <div
                class="modal-container fixed z-50 bottom-0 mb-4 w-full max-w-lg md:max-w-md lg:max-w-sm h-3/4 md:h-2/3 lg:h-3/4 overflow-y-auto right-0 rounded-lg bg-white shadow-lg">
                <div
                    class="modal-close absolute top-2 right-2 mr-3 cursor-pointer flex flex-col items-center text-black text-sm z-50">
                    <svg class="modal-closed fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18"
                        height="18" viewBox="0 0 18 18">
                        <path
                            d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                        </path>
                    </svg>
                </div>

                <!-- Modal Content -->
                <div class="modal-content h-full bg-white rounded-lg w-full text-left p-4 md:p-6 lg:p-8 overflow-auto">
                    <!-- Title -->
                    <div class="flex flex-col pb-4 gap-4">
                        <!-- Title Section -->
                        <div class="title-section flex justify-between items-center">
                            <ion-icon name="people-outline" class="text-2xl"></ion-icon>
                            <span class="text-lg md:text-xl mr-12 max-sm:mr-24 font-semibold">Chat dengan admin</span>
                        </div>

                        <!-- User List Section -->
                        <div class="flow-root w-full user-list">
                            <ul>
                                @foreach ($admins as $admin)
                                    <?php
                                    // Calculate unread message count for the current admin
                                    $unreadMessagesCount = \App\Models\LiveChat::where('from_user_id', $admin->id)
                                        ->where('to_user_id', auth()->id())
                                        ->where('is_read', false)
                                        ->count();
                                    ?>
                                    <li class="py-3 sm:py-4">
                                        <a href="/live-chat/{{ $admin->id }}" class="block">
                                            <div
                                                class="list-users flex items-center gap-4 py-2 hover:bg-gray-50 hover:rounded-md relative">
                                                <img class="w-10 h-10 mx-2 rounded-full"
                                                    src="{{ $admin->profile_picture_url ?? 'img/client-1.jpg' }}"
                                                    alt="{{ $admin->name }} image">
                                                <div class="flex-1 min-w-0 identity">
                                                    <p class="text-sm md:text-base font-medium text-gray-900 truncate">
                                                        {{ $admin->name }}</p>
                                                    <p class="text-xs md:text-sm text-gray-500 truncate">
                                                        {{ $admin->email }}
                                                    </p>
                                                    @if ($admin->is_online)
                                                        <span class="text-green-500 text-sm">Online</span>
                                                    @else
                                                        <span class="text-gray-500">Offline</span>
                                                    @endif
                                                    @if ($unreadMessagesCount > 0)
                                                        <span
                                                            class="absolute top-0 right-0 w-5 h-5 rounded-full bg-red-500 text-white text-xs font-bold flex items-center justify-center">
                                                            {{ $unreadMessagesCount }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@else
    <a href="https://wa.me/6285182629897?text=Saya%20ingin%20bertanya%20tentang%20produk%20di%20website%20Teras KBK">
        <button
            class="bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-2 px-4 rounded-full fixed bottom-4 right-4 mb-4 mr-4 max-sm:mb-20">
            <i class='bx bxs-conversation text-2xl sm:text-3xl'></i>
            <!-- Use 'bxs-conversation' for a solid style -->
        </button>
    </a>
@endif

<script>
    // Add event listener to open modal button
    var openmodal = document.querySelectorAll('.modal-open');
    for (var i = 0; i < openmodal.length; i++) {
        openmodal[i].addEventListener('click', function(event) {
            event.preventDefault();
            toggleModal();
        });
    }

    // Add event listener to overlay to close the modal
    const overlay = document.querySelector('.modal-overlay');
    overlay.addEventListener('click', toggleModal);

    // Add event listener to close modal button
    var closemodal = document.querySelectorAll('.modal-close');
    for (var i = 0; i < closemodal.length; i++) {
        closemodal[i].addEventListener('click', toggleModal);
    }

    // Close modal on Escape key press
    document.onkeydown = function(evt) {
        evt = evt || window.event;
        var isEscape = false;
        if ("key" in evt) {
            isEscape = (evt.key === "Escape" || evt.key === "Esc");
        } else {
            isEscape = (evt.keyCode === 27);
        }
        if (isEscape && document.body.classList.contains('modal-active')) {
            toggleModal();
        }
    };

    // Toggle modal visibility and body class
    function toggleModal() {
        const body = document.querySelector('body');
        const modal = document.querySelector('.modal');
        modal.classList.toggle('opacity-0');
        modal.classList.toggle('pointer-events-none');
        body.classList.toggle('modal-active');
    }
</script>
