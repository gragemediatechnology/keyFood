@extends('layouts.main')
@section('container')
<body class="bg-gray-900 text-white text-center">
    <h1 class="text-white mt-5">Buat Produk</h1>
    <div class="container mx-auto max-w-md mt-5 p-5 bg-gray-800 shadow-lg rounded-lg text-left">
        <form>
            <div class="form-group mb-5">
                <label for="nama-produk" class="block mb-1 text-gray-400">Nama Produk</label>
                <input type="text" id="nama-produk" name="nama-produk" placeholder="Masukkan nama produk" required class="w-full p-2 border border-gray-700 rounded bg-gray-700 text-white">
            </div>
            <div class="form-group mb-5">
                <label for="harga-produk" class="block mb-1 text-gray-400">Harga Produk</label>
                <input type="number" id="harga-produk" name="harga-produk" placeholder="Masukkan harga produk" required class="w-full p-2 border border-gray-700 rounded bg-gray-700 text-white">
            </div>
            <div class="form-group mb-5">
                <label for="deskripsi-produk" class="block mb-1 text-gray-400">Deskripsi Produk</label>
                <textarea id="deskripsi-produk" name="deskripsi-produk" rows="4" placeholder="Masukkan deskripsi produk" required class="w-full p-2 border border-gray-700 rounded bg-gray-700 text-white resize-none"></textarea>
            </div>
            <div class="form-group mb-5">
                <label for="kategori-produk" class="block mb-1 text-gray-400">Kategori Produk</label>
                <div class="relative">
                    <select id="kategori-produk" name="kategori-produk" class="w-full p-2 border border-gray-700 rounded bg-gray-700 text-white appearance-none" required>
                        <option value="makanan-manis">Makanan Manis</option>
                        <option value="makanan-asin">Makanan Asin</option>
                        <option value="buah-buahan">Buah-buahan</option>
                        <option value="sayuran">Sayuran</option>
                        <option value="minuman">Minuman</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7 10l5 5 5-5H7z"/></svg>
                    </div>
                </div>
            </div>
            <div class="form-group mb-5">
                <label for="upload-img" class="block mb-1 text-gray-400">Unggah Gambar</label>
                <input type="file" id="upload-img" name="upload-img" accept="image/*" onchange="previewImage(event)" class="w-full p-2 border border-gray-700 rounded bg-gray-700 text-white" loading="lazy">
            </div>
            <div class="image-preview flex flex-wrap gap-2 mt-2 mb-5 justify-center" id="image-preview"></div>
            <button type="submit" class="w-full p-2 bg-blue-500 text-white rounded hover:bg-gray-600">Tambah Produk</button>
        </form>
    </div>
    <script>
        function previewImage(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('image-preview');
            previewContainer.innerHTML = '';
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    imgElement.classList.add('w-24', 'h-24', 'object-cover', 'border', 'border-gray-700', 'rounded');
                    previewContainer.appendChild(imgElement);
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
@endsection
