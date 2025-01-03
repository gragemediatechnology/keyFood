<section class="max-w-4xl p-6 mx-auto bg-indigo-600 rounded-md shadow-md dark:bg-gray-800 mt-20">
    <h1 class="text-xl font-bold text-white capitalize dark:text-white">Tambah Produk</h1>
    <form>
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <div>
                <label class="text-white dark:text-gray-200" for="emailAddress">Nama Produk</label>
                <input id="emailAddress" type="email" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="passwordConfirmation">kategori produk</label>
                <select class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    <option>Makanan Manis</option>
                    <option>Makanan Asin</option>
                    <option>Buah-Buahan</option>
                    <option>Sayuran</option>
                    <option>Minuman</option>
                </select>
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="price">Harga Produk</label>
                <input id="price" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="passwordConfirmation">deskripsi produk</label>
                <textarea id="textarea" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring resize-none"></textarea>
            </div>

        </div>
        <div class="flex justify-center">
            <div class="lg:w-1/2 w-full">
                <label class="block text-sm font-medium text-white">Image</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md" onclick="document.getElementById('file-upload').click()">
                    <div class="space-y-1 text-center">
                        <svg id="default-icon" class="mx-auto h-12 w-12 text-white" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div id="upload-text" class="flex text-sm text-gray-600">
                            <label for="file-upload" class="relative cursor-pointer bg-hideung rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span class="text-white">Upload an image here</span>
                                <input id="file-upload" name="file-upload" type="file" class="sr-only" onchange="previewImage(event)">
                                <p id="file-types" class="text-xs text-white">PNG, JPG, GIF up to 10MB</p>
                            </label>
                        </div>
                        <img id="image-preview" class="mt-2 hidden w-full h-48 object-cover rounded-md" loading="lazy"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-blue-500 rounded-md hover:bg-blue-700 focus:outline-none focus:bg-gray-600">Create</button>
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
