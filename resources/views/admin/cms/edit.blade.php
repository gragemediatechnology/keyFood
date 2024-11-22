@extends('admin.layouts.main-admin')
@section('container-admin')

@if (session('info'))
    <script>
        Swal.fire({
            icon: 'info',
            title: 'info!',
            text: '{{ session('info') }}',
            timer: 2000, // Durasi tampilan alert dalam milidetik
            showConfirmButton: false
        });
    </script>
@endif
<main class="h-screen overflow-y-auto">
    <div class="container px-6 mx-auto grid py-4 mb-8 max-w-4xl">
        <!-- Judul Form -->
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6 text-center">Edit Company</h2>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <!-- Notifikasi Error -->

            <!-- Form Edit Perusahaan -->
            {{-- <form action="{{ route('admin.company.update', $data->id) }}" method="POST" enctype="multipart/form-data"> --}}
            
            <form action="/admin/company/update/{{ $data->id }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Field Logo -->
                <div class="mt-5">
                    <div class="form">
                        <div class="md:space-y-2 mb-3">
                            <label class="text-sm font-semibold text-gray-700 dark:text-white py-2">Logo<abbr
                                    class="hidden" title="required">*</abbr></label>
                            <div class="flex items-center justify-center flex-row gap-4">

                                <!-- Upload Logo -->
                                <label class="cursor-pointer">
                                    <div class="w-12 h-12 flex-none rounded-xl border overflow-hidden mb-2">
                                        <img id="logo" class="w-full h-full object-cover" src="https://teraskabeka.com/{{ $data->logo }}"
                                            alt="Avatar Upload" loading="lazy">
                                    </div>
                                    <span
                                        class="focus:outline-none text-black px-2 py-1 text-xs font-medium leading-5 bg-purple-600 rounded-lg hover:bg-green-500 hover:shadow-lg dark:text-white">Browse</span>
                                    <input type="file" name="logo" class="hidden" accept="image/*"
                                        onchange="previewImage(event, document.getElementById('logo'))">
                                </label>

                                <!-- Upload Gambar Home 1 -->
                                <label class="cursor-pointer ml-4">
                                    <div class="w-12 h-12 flex-none rounded-xl border overflow-hidden mb-2">
                                        <img id="gambar_home_1" class="w-full h-full object-cover" src="https://teraskabeka.com/{{ $data->gambar_home_1 }}"
                                            alt="Avatar Upload" loading="lazy">
                                    </div>
                                    <span
                                        class="focus:outline-none text-black px-2 py-1 text-xs font-medium leading-5 bg-purple-600 rounded-lg hover:bg-green-500 hover:shadow-lg dark:text-white">Browse</span>
                                    <input type="file" name="gambar_home_1" class="hidden" accept="image/*"
                                    onchange="previewImage(event, document.getElementById('gambar_home_1'))">
                                </label>

                                <!-- Upload Gambar Home 2 -->
                                <label class="cursor-pointer ml-4">
                                    <div class="w-12 h-12 flex-none rounded-xl border overflow-hidden mb-2">
                                        <img id="gambar_home_2" class="w-full h-full object-cover" src="https://teraskabeka.com/{{ $data->gambar_home_2 }}"
                                            alt="Avatar Upload" loading="lazy">
                                    </div>
                                    <span
                                        class="focus:outline-none text-black px-2 py-1 text-xs font-medium leading-5 bg-purple-600 rounded-lg hover:bg-green-500 hover:shadow-lg dark:text-white">Browse</span>
                                    <input type="file" name="gambar_home_2" class="hidden" accept="image/*"
                                    onchange="previewImage(event, document.getElementById('gambar_home_2'))">
                                </label>

                                <!-- Upload Gambar Home 3 -->
                                <label class="cursor-pointer ml-4">
                                    <div class="w-12 h-12 flex-none rounded-xl border overflow-hidden mb-2">
                                        <img id="gambar_home_3" class="w-full h-full object-cover" src="https://teraskabeka.com/{{ $data->gambar_home_3 }}"
                                            alt="Avatar Upload" loading="lazy">
                                    </div>
                                    <span
                                        class="focus:outline-none text-black px-2 py-1 text-xs font-medium leading-5 bg-purple-600 rounded-lg hover:bg-green-500 hover:shadow-lg dark:text-white">Browse</span>
                                    <input type="file" name="gambar_home_3" class="hidden" accept="image/*"
                                    onchange="previewImage(event, document.getElementById('gambar_home_3'))">
                                </label>
                            </div>
                        </div>

                        <!-- Field Nama Perusahaan -->
                        <div>
                            <label for="company_name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                                Perusahaan</label>
                            <input type="text" name="company_name" id="company_name" placeholder="tulis nama perusahaan..."
                                class="mt-1 block w-full sm:w-10/12 md:w-9/12 lg:w-8/12 mx-auto border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                value="{{ $data->company_name}}">
                        </div>

                        <!-- Field Nomor Telepon -->
                        <div class="mt-2">
                            <label for="phone"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telepon</label>
                            <input type="text" name="phone" id="phone" placeholder="tulis nomor telepon..."
                                class="mt-1 block w-full sm:w-10/12 md:w-9/12 lg:w-8/12 mx-auto border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                value="{{$data->phone}}">
                        </div>

                        <!-- Field Email -->
                        <div>
                            <label for="email"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" name="email" id="email" placeholder="tulis email..."
                                class="mt-1 block w-full sm:w-10/12 md:w-9/12 lg:w-8/12 mx-auto border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                value="{{ $data->email}}">
                        </div>

                        <!-- Field Lokasi -->
                        <div class="mt-2">
                            <label for="lokasi"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi</label>
                            <input type="text" name="lokasi" id="lokasi" placeholder="tulis lokasi..."
                                class="mt-1 block w-full sm:w-10/12 md:w-9/12 lg:w-8/12 mx-auto border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                value="{{ $data->lokasi}}">
                        </div>

                        <!-- Tombol Submit -->
                        <div class="text-center mt-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-black bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

@endsection

<script>
    // Fungsi untuk menampilkan pratayang gambar saat diupload
    function previewImage(event, imgElement) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imgElement.src = e.target.result; // Mengatur src img ke hasil pratayang
            }
            reader.readAsDataURL(file); // Membaca file sebagai URL data
        }
    }
</script>
