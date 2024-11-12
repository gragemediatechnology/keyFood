@extends('admin.layouts.main-admin')
@section('container-admin')
@if (Auth::check())

    @if(session('info'))
        <script>
            Swal.fire({
                icon: 'info',
                title: 'info',
                text: '{{ session('info') }}',
                timer: 2000, // 3000 ms = 3 detik
                showConfirmButton: false,
            });
        </script>
    @endif

    <main class="h-screen pb-16 overflow-y-auto">
        <div class="container grid px-6 mx-auto py-4 mb-8 dark:bg-gray-900">

            <div class="lg:w-[80%] md:w-[90%] xs:w-[96%] mx-auto flex gap-4">
                <div
                    class="lg:w-[88%] md:w-[80%] sm:w-[88%] xs:w-full mx-auto shadow-2xl p-4 rounded-xl h-fit self-center dark:bg-gray-800/40">
                    <!--  -->
                    <div class="">
                        <h1
                            class=" ml-4 lg:text-3xl md:text-2xl sm:text-xl xs:text-xl font-serif font-extrabold mb-2 dark:text-white">
                            Edit Profile
                        </h1>
                        <form action="/admin/profile/edit" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="flex items-center justify-center flex-col">
                                @if(Auth::user()->img)
                                    <img src="https://teraskabeka.com/{{ Auth::user()->img }}" alt="Current profile picture"
                                        style="max-width: 100px; margin-bottom: 10px;">
                                @endif

                                <!-- Input untuk upload image -->
                                <input type="file" id="file" name="img" hidden>

                                <!-- Drag and drop area -->
                                <div id="drop-zone"
                                    class="w-full h-48 bg-gray-100 border-2 border-dashed border-gray-300 flex flex-col items-center justify-center relative cursor-pointer transition-all hover:bg-gray-200"
                                    data-img="">
                                    <i class='bx bxs-cloud-upload icon text-6xl mb-2'></i>
                                    <h3 class="font-bold text-lg">Seret & letakan Gambar Disini</h3>
                                    <p class="text-sm text-gray-500">Gambar harus berukuran dibawah <span>2MB</span></p>
                                    <p class="text-sm text-gray-500">Atau pilih gambar</p>
                                </div>

                                <!-- Button untuk memilih gambar dari file explorer -->
                                <button type="button" id="select-image"
                                    class="mt-4 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none mb-2">Pilih
                                    Gambar</button>
                            </div>
                            <div class="flex lg:flex-row md:flex-col sm:flex-col xs:flex-col gap-4 justify-between w-full">
                                <div class="w-full mb-4 px-2">
                                    <label for="username" class="block  dark:text-gray-300">Nama Pengguna</label>
                                    <input type="text" id="username"
                                        class="mt-2 p-2 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                        placeholder="username" name="name" value=" {{ Auth::user()->name }}">
                                </div>
                                <div class="w-full mb-4 px-2">
                                    <label for="email" class="block  dark:text-gray-300">Email</label>
                                    <input type="email" id="email"
                                        class="mt-2 p-2 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                        placeholder="email" name="email" value=" {{ Auth::user()->email }}">
                                </div>
                            </div>

                            <div class="flex lg:flex-row md:flex-col sm:flex-col xs:flex-col gap-4 justify-center w-full">
                                <div class="w-full mb-4 px-2">
                                    <label for="first_name" class="block  dark:text-gray-300">Nama Depan</label>
                                    <input type="text" id="first_name"
                                        class="mt-2 p-2 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                        placeholder="first_name" name="first_name" value=" {{ Auth::user()->first_name }}">
                                </div>
                                <div class="w-full lg:w-1/2 md:w-full px-2">
                                    <h3 class="dark:text-gray-300 ">Nama Belakang</h3>
                                    <input type="text"
                                        class="text-grey p-2 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800 mt-2"
                                        name="last_name" value=" {{ Auth::user()->last_name}}">
                                </div>
                            </div>
                            <div class="flex lg:flex-row md:flex-col sm:flex-col xs:flex-col gap-4 justify-center w-full">
                                <div class="w-full mb-4 px-2">
                                    <label for="phone" class="block  dark:text-gray-300">Nomor Hp</label>
                                    <input type="text" id="phone"
                                        class="mt-2 p-2 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                        placeholder="phone" name="phone" value=" {{ Auth::user()->phone }}">
                                </div>
                                <div class="w-full lg:w-1/2 md:w-full px-2">
                                    <h3 class="dark:text-gray-300 ">Lokasi</h3>
                                    <input type="text"
                                        class="text-grey p-2 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800 mt-2"
                                        name="location" value=" {{ Auth::user()->location}}">
                                </div>
                            </div>
                            <div class="flex lg:flex-row md:flex-col sm:flex-col xs:flex-col gap-4 justify-center w-full">
                                <div class="w-full mb-4 px-2">
                                    <label for="password" class="block  dark:text-gray-300">Password</label>
                                    <input type="password" id="password"
                                        class="mt-2 p-2 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                        placeholder="password" name="password">
                                </div>
                                <div class="w-full lg:w-1/2 md:w-full px-2">
                                    <h3 class="dark:text-gray-300 ">Confirm Password</h3>
                                    <input type="password"
                                        class="text-grey p-2 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800 mt-2"
                                        name="password_confirmation" placeholder="Confirm Password">
                                </div>
                            </div>

                            <div class=" mt-4 text-white text-lg font-semibold">
                                <button type="submit"
                                    class="w-full p-2 bg-purple-600 hover:bg-purple-700 rounded-lg">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endif
@endsection

<script>


    document.addEventListener("DOMContentLoaded", function () {
        const dropZone = document.getElementById("drop-zone");
        const fileInput = document.getElementById("file");
        const selectImageBtn = document.getElementById("select-image");

        // Klik tombol untuk membuka file explorer
        selectImageBtn.addEventListener("click", function () {
            fileInput.click();
        });

        // Saat file dipilih dari file explorer
        fileInput.addEventListener("change", function (event) {
            handleFileUpload(event.target.files);
        });

        // Prevent default behavior for drag and drop events
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        // Menambahkan event untuk drag & drop
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('bg-gray-200', 'border-purple-500');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('bg-gray-200', 'border-purple-500');
            });
        });

        // Tangkap file saat di-drop
        dropZone.addEventListener('drop', (event) => {
            let dt = event.dataTransfer;
            let files = dt.files;
            handleFileUpload(files);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function handleFileUpload(files) {
            if (files.length > 0) {
                const file = files[0];

                // Validasi ukuran file
                if (file.size > 2 * 1024 * 1024) {
                    alert("Image size must be less than 2MB");
                    return;
                }

                // Tampilkan preview gambar
                const reader = new FileReader();
                reader.onload = function (e) {
                    dropZone.innerHTML = `<img src="${e.target.result}" alt="Uploaded image" class="w-full h-full object-cover rounded-lg"/>`;
                };
                reader.readAsDataURL(file);

                // Set the file in the hidden input for form submission
                fileInput.files = files;
            }
        }
    });
</script>