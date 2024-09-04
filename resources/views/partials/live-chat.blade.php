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

    body.dark .modal-closed{
        color: white;
    }

    body.dark .modal-content{
        background-color: #111111;
    }

    body.dark .title-section{
        color: white;
    }
    body.dark .identity p{
        color: lightgray;
    }

    body.dark .list-users:hover{
        background-color: #3333;
    }
</style>

@if (Auth::check())
    <button
        class="modal-open bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-2 px-4 rounded-full fixed bottom-4 right-4 mb-4 mr-4 max-sm:mb-20">
        <i class='bx bxs-conversation text-2xl sm:text-3xl'></i> <!-- Use 'bxs-conversation' for a solid style -->
    </button>


    <!-- Modal -->
    <div class="modal opacity-0 pointer-events-none fixed inset-0 flex items-end justify-end">
        <div class="modal-overlay absolute inset-0 bg-black bg-opacity-50"></div>

        <div
            class="modal-container fixed z-50 bottom-0 mb-4 w-full max-w-lg md:max-w-md lg:max-w-sm h-3/4 md:h-2/3 lg:h-3/4 overflow-y-auto right-0 rounded-lg bg-white shadow-lg">
            <div
                class="modal-close absolute top-2 right-2 mr-3 cursor-pointer flex flex-col items-center text-black text-sm z-50">
                <svg class="modal-closed fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                    viewBox="0 0 18 18">
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
                                <li class="py-3 sm:py-4">
                                    <a href="/live-chat/{{ $admin->id }}" class="block">
                                        <div class="list-users flex items-center gap-4 py-2 hover:bg-gray-50 hover:rounded-md">
                                            <img class="w-10 h-10 rounded-full" src="{{ $admin->profile_picture_url ?? 'img/client-1.jpg' }}" alt="{{ $admin->name }} image">
                                            <div class="flex-1 min-w-0 identity">
                                                <p class="text-sm md:text-base font-medium text-gray-900 truncate">
                                                    {{ $admin->name }}
                                                </p>
                                                <p class="text-xs md:text-sm text-gray-500 truncate">
                                                    {{ $admin->email }}
                                                </p>
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
    @else
    <a href="https://wa.me/6289661110584?text=Saya%20ingin%20bertanya%20tentang%20produk%20di%20website%20keyFood">
        <button
            class="bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-2 px-4 rounded-full fixed bottom-4 right-4 mb-4 mr-4 max-sm:mb-20">
            <i class='bx bxs-conversation text-2xl sm:text-3xl'></i> <!-- Use 'bxs-conversation' for a solid style -->
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
