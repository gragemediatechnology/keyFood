@extends('layouts.main')
@section('container')
    <section class="max-w-4xl p-6 mx-auto bg-indigo-600 rounded-md shadow-md dark:bg-gray-800 mt-20">
        <h1 class="text-2xl font-bold text-white capitalize dark:text-white mb-10">Tambah Produk</h1>

        {{-- Display errors if any --}}
        @if ($errors->any())
            <div class="alert-alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="py-5 bg-red-500 text-white font-bold">
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Product creation form --}}
        {{-- <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data"> --}}
        <form method="POST" action="/seller/products/store" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                {{-- Product Name --}}
                <div>
                    <label class="text-white dark:text-gray-200" for="name">Nama Produk</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                        class="block w-full px-4 py-2 lg:mt-12 sm:mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                        required>
                    @error('name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Category --}}
                <div>
                    <label class="text-white dark:text-gray-200" for="category">Kategori Produk</label>
                    <select name="category_id" id="category"
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                        required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Price --}}
                <div>
                    <label class="text-white dark:text-gray-200" for="price">Harga Produk</label>
                    <input id="price" type="number" name="price" value="{{ old('price') }}"
                        class="no-spinner block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                        required>
                    @error('price')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Quantity --}}
                <div>
                    <label class="text-white dark:text-gray-200" for="quantity">Jumlah Produk</label>
                    <input id="quantity" type="number" name="quantity" value="{{ old('quantity') }}"
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                        required>
                    @error('quantity')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="text-white dark:text-gray-200" for="slug">Deskripsi Produk</label>
                    <textarea id="slug" name="slug"
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring resize-none">{{ old('slug') }}</textarea>
                    @error('slug')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Store --}}
                <div class="hidden">
                    <label class="text-white dark:text-gray-200" for="store_id">Toko</label>
                    <select name="store_id" id="store_id"
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                        required hidden>
                        @foreach ($stores as $store)
                            <option value="{{ $store->id_toko }}"
                                {{ old('store_id') == $store->id_toko ? 'selected' : '' }}>
                                {{ $store->nama_toko }}
                            </option>
                        @endforeach
                    </select>
                    @error('store_id')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Photo --}}
            <div class="flex justify-center mt-6">
                <div class="lg:w-1/2 w-full">
                    <label class="block text-sm font-medium text-white">Image</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                        onclick="document.getElementById('photo').click()">
                        <div class="space-y-1 text-center">
                            <svg id="default-icon" class="mx-auto h-12 w-12 text-white" stroke="currentColor" fill="none"
                                viewBox="0 0 48 48" aria-hidden="true">
                                <path
                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div id="upload-text" class="flex text-sm text-gray-600">
                                <label for="photo"
                                    class="relative cursor-pointer bg-hideung rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span class="text-white">Upload an image here</span>
                                    <input id="photo" name="photo" type="file" class="sr-only"
                                        onchange="validateFile(event)">
                                    <p id="file-types" class="text-xs text-white">PNG, JPG, GIF up to 10MB</p>
                                </label>
                            </div>
                            <img id="image-preview" class="mt-2 hidden w-full h-48 object-cover rounded-md"
                                loading="lazy" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-blue-500 rounded-md hover:bg-blue-700 focus:outline-none focus:bg-gray-600">
                    {{ __('Add Product') }}</button>
            </div>
        </form>
    </section>

    <script>
        function previewImage(event) {
            const input = event.target;
            const reader = new FileReader();
            reader.onload = function() {
                const dataURL = reader.result;
                const imagePreview = document.getElementById('image-preview');
                const defaultIcon = document.getElementById('default-icon');
                const uploadText = document.getElementById('upload-text');
                const fileTypes = document.getElementById('file-types');

                imagePreview.src = dataURL;
                imagePreview.classList.remove('hidden');
                defaultIcon.classList.add('hidden');
                uploadText.classList.add('hidden');
                fileTypes.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>

    <script>
        function validateFile(event) {
            const input = event.target;
            const file = input.files[0];

            // Jika tidak ada file, keluar dari fungsi
            if (!file) return;

            // Batas ukuran file 10MB
            const maxSize = 10 * 1024 * 1024;

            if (file.size > maxSize) {
                // Tampilkan Swal jika file terlalu besar
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran File Terlalu Besar!',
                    text: 'Ukuran File Tidak Boleh Melebihi 10MB.',
                    confirmButtonText: 'Okay'
                });

                // Reset input file
                input.value = "";
            } else {
                // Panggil fungsi previewImage jika ukuran valid
                previewImage(event);
            }
        }

        function previewImage(event) {
            const input = event.target;
            const reader = new FileReader();
            reader.onload = function() {
                const dataURL = reader.result;
                const imagePreview = document.getElementById('image-preview');
                const defaultIcon = document.getElementById('default-icon');
                const uploadText = document.getElementById('upload-text');
                const fileTypes = document.getElementById('file-types');

                imagePreview.src = dataURL;
                imagePreview.classList.remove('hidden');
                if (defaultIcon) defaultIcon.classList.add('hidden');
                if (uploadText) uploadText.classList.add('hidden');
                if (fileTypes) fileTypes.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection
