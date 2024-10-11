<div id="messageContainer" class="overflow-y-auto h-screen">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    @php
                        // Find the second user and unread message count
                        $secondUser = null;
                        $unreadCount = 0;
                        foreach ($messages as $message) {
                            if ($message->from_user_id != auth()->id()) {
                                $secondUser = $message->fromUser;
                                if (!$message->is_read) {
                                    $unreadCount++;
                                }
                            }
                        }
                    @endphp

                    @if ($secondUser)
                        <!-- Profile Box for the Second User -->
                        <div
                            class="fixed top-4 left-0 px-10 right-0 mx-auto flex items-center p-2 mb-4 border rounded-lg shadow-md bg-gray-100 z-50 w-[90%] max-w-sm md:max-w-md lg:max-w-lg">
                            <div class="w-12 h-12 mr-4">
                                <img src="{{ $secondUser->img ?? 'img/client-1.jpg' }}" alt="User Avatar"
                                    class="w-full h-full rounded-full">
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-950">{{ $secondUser->name }}</h3>
                                <span class="text-sm text-gray-600">
                                    @if ($secondUser->is_online)
                                        <p class="text-sm text-green-600">• Online</p>
                                    @else
                                        <p class="text-sm text-gray-600">• Offline</p>
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endif


                    <div wire:poll>
                        @if (isset($messages) && $messages->isNotEmpty())
                            @foreach ($messages as $message)
                                <div class="chat @if ($message->from_user_id == auth()->id()) chat-end @else chat-start @endif">
                                    <div class="chat-image avatar">
                                        <div class="w-10 rounded-full">
                                            <img alt="User Avatar"
                                                src="{{ $message->fromUser->img ?? 'img/client-1.jpg' }}" />
                                        </div>
                                    </div>
                                    <div class="chat-header text-gray-950">
                                        {{ $message->fromUser->name }}
                                        <time
                                            class="text-xs opacity-50 text-gray">{{ $message->created_at->diffForHumans() }}</time>
                                    </div>
                                    <div class="chat-bubble sm:max-w-xs lg:max-w-lg p-2 break-words shadow-md">
                                        @if ($message->image)
                                            <img src="{{ 'storage/' . $message->image }}" alt="Image"
                                                class="max-w-24 h-auto rounded-lg mt-2 cursor-pointer" id="chatImage"
                                                onclick="openModal('{{ ('storage/' . $message->image) }}')">
                                        @endif

                                        @if ($message->message)
                                            <p class="mb-2">{{ $message->message }}</p>
                                        @endif

                                    </div>
                                    <div class="chat-footer opacity-50 text-gray-900">Delivered</div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div id="imageModal"
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-70 hidden" wire:ignore
                        onclick="closeModal(event)">
                        <div class="relative bg-white p-4 rounded-lg max-w-sm mx-4 cursor-default"
                            onclick="event.stopPropagation()">
                            <button onclick="closeModal()"
                                class="absolute top-2 right-2 px-3 text-white bg-black rounded-full p-1">
                                <span class="text-2xl">×</span>
                            </button>
                            <img id="modalImage" src="" alt="Large Image"
                                class="w-full h-auto max-h-80 rounded-lg">
                        </div>
                    </div>

                    <div id="imagePreview" class="mt-2 max-w-20 mb-4 mx-9 rounded-lg relative" wire:ignore></div>


                    <div class="form-control">
                        <form method="POST" id="messageForm" wire:submit.prevent="SendMessage"
                            enctype="multipart/form-data">
                            <textarea id="messageTextarea" class="textarea textarea-bordered text-green-500 w-full" wire:model="message"
                                placeholder="Kirim pesan bang..." required></textarea>
                            <input type="file" wire:model="images" id="imageInput" />
                            <button type="button" id="chooseFileButton" class="btn btn-primary">Choose File</button>
                            <button type="submit" id="submitButton" class="btn btn-primary">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function openModal(imageSrc) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageSrc;
        modal.classList.remove('hidden');
    }

    function closeModal(event) {
        if (event) {
            // Prevent closing the modal if the click was inside the modal content
            if (event.target.id === 'imageModal') {
                const modal = document.getElementById('imageModal');
                modal.classList.add('hidden');
            }
        } else {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const chooseFileButton = document.getElementById('chooseFileButton');
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        const messageForm = document.getElementById('messageForm');
        const messageTextarea = document.getElementById('messageTextarea');

        // Scroll ke bawah saat halaman dimuat
        const messageContainer = document.getElementById('messageContainer');
        if (messageContainer) {
            messageContainer.scrollTop = messageContainer.scrollHeight;
        }

        // Menggulir ke bawah saat pesan dikirim oleh Livewire
        Livewire.on('messageSent', () => {
            if (messageContainer) {
                messageContainer.scrollTop = messageContainer.scrollHeight;
            }
            messageTextarea.value = ''; // Kosongkan textarea setelah pesan terkirim
            imageInput.value = ''; // Kosongkan input file setelah pesan terkirim
            isSubmitting = false; // Pastikan flag isSubmitting di-reset
        });

        Livewire.on('messageAdded', () => {
            const chatContainer = document.getElementById('chat-container');
            if (chatContainer) {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        });

        // Buka dialog file saat tombol "Choose File" diklik
        chooseFileButton.addEventListener('click', function() {
            imageInput.click();
        });

        // Tangani pemilihan file dan pratinjau
        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            console.log(file);
            if (file) {
                const reader = new FileReader();
                console.log(reader);

                reader.onload = function(e) {
                    // Buat elemen img untuk menampilkan pratinjau
                    console.log(e);
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className =
                        'max-w-[80px] h-[80px] rounded-lg'; // Atur ukuran gambar menjadi 80px dengan sudut melengkung

                    // Buat tombol close (X) untuk menghapus gambar
                    const closeButton = document.createElement('button');
                    closeButton.innerHTML = '&times;'; // Simbol X
                    closeButton.className =
                        'absolute top-0 right-0 text-white bg-red-500 rounded-full w-6 h-6 flex items-center justify-center';
                    closeButton.style.cursor = 'pointer';

                    // Event listener untuk menghapus gambar dan mereset input saat X diklik
                    closeButton.addEventListener('click', function() {
                        // Hapus elemen gambar dan tombol
                        imagePreview.innerHTML = '';
                        chooseFileButton.style.display = 'inline-block';

                        // Reset input file agar data benar-benar dihapus
                        imageInput.value = '';
                        if (imageInput.files && imageInput.files.length > 0) {
                            imageInput.files = new DataTransfer()
                                .files; // Menghapus data file yang disimpan
                        }
                    });

                    // Hapus pratinjau sebelumnya, tambahkan gambar dan tombol close
                    imagePreview.innerHTML = '';
                    imagePreview.appendChild(img);
                    imagePreview.appendChild(closeButton);

                    // Sembunyikan tombol pilih file
                    chooseFileButton.style.display = 'none';
                };

                reader.readAsDataURL(file);
            } else {
                imagePreview.innerHTML = '';
                chooseFileButton.style.display = 'inline-block';
            }
        });

        // Hapus pratinjau gambar saat formulir disubmit
        messageForm.addEventListener('submit', function() {
            imagePreview.innerHTML = '';
            chooseFileButton.style.display = 'inline-block';
            imageInput.value = ''; // Hapus input file
        });

        // Flag untuk menghindari pengiriman pesan kosong saat delay
        let isSubmitting = false;

        // Fungsi untuk memeriksa apakah textarea memiliki konten yang valid
        function isMessageValid() {
            const value = messageTextarea.value.trim();
            console.log(`Pesan yang dicek: "${value}"`); // Log isi pesan untuk debugging
            return value.length > 0 || imageInput.files.length > 0;
        }

        // Tambahkan event listener untuk menangani tombol yang ditekan
        messageTextarea.addEventListener('keydown', function(event) {
            // Cek apakah tombol Enter ditekan
            if (event.key === 'Enter') {
                // Cek apakah Shift juga ditekan
                if (event.shiftKey) {
                    // Jika Shift + Enter ditekan, biarkan menambah baris baru
                    return; // Biarkan default behavior (tambahkan newline)
                } else {
                    // Jika hanya Enter, cegah default behavior dan cek isian
                    event.preventDefault();

                    // Pastikan textarea tidak kosong atau ada file yang diupload dan belum dalam proses submit
                    if (isMessageValid() && !isSubmitting) {
                        // Set flag submitting
                        isSubmitting = true;
                        // Tambahkan delay sebelum submit form
                        setTimeout(() => {
                            messageForm.requestSubmit(); // Submit form setelah delay
                            isSubmitting = false; // Reset flag setelah submit
                        }, 1); // 1 milidetik
                    } else {
                        alert(
                            'Pesan tidak boleh kosong atau file belum dipilih!'
                        ); // Pesan peringatan jika textarea kosong
                    }
                }
            }
        });

        // Tambahkan event listener untuk mengosongkan textarea dan input file setelah submit
        messageForm.addEventListener('submit', function(event) {
            setTimeout(() => {
                // Kosongkan textarea dan input file setelah pesan terkirim
                messageTextarea.value = '';
                imageInput.value = '';
            }, 100); // Tambahkan sedikit delay agar pesan terkirim lebih dulu
        });
    });
</script>
