@extends('layouts.main')

@section('container')
    <section class="max-w-4xl p-6 mx-auto bg-indigo-600 rounded-md shadow-md dark:bg-gray-800 mt-20">
        <h1 class="text-2xl font-bold text-white capitalize dark:text-white mb-10">Edit Toko</h1>

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

        {{-- Toko update form --}}
        <form action="/seller/edit_toko/update/{{ $toko->id_toko }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                
                {{-- Foto yang Ada --}}
                <div>
                    <label class="text-white dark:text-gray-200" for="foto_profile_toko">Foto yang Ada</label>
                    <img src="{{ asset('store_image/' . $toko->foto_profile_toko) }}" class="h-[100px] w-auto mt-2" alt="{{ $toko->nama_toko }}">
                    <input id="foto_profile_toko" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" type="file" name="foto_profile_toko" />
                    @error('foto_profile_toko')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nama Toko --}}
                <div>
                    <label class="text-white dark:text-gray-200" for="nama_toko">Nama Toko</label>
                    <input value="{{ old('nama_toko', $toko->nama_toko) }}" id="nama_toko" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" type="text" name="nama_toko" required autofocus />
                    @error('nama_toko')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat Toko --}}
                <div>
                    <label class="text-white dark:text-gray-200" for="alamat_toko">Alamat Toko</label>
                    <input value="{{ old('alamat_toko', $toko->alamat_toko) }}" id="alamat_toko" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" type="text" name="alamat_toko" required autofocus />
                    @error('alamat_toko')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deskripsi Toko --}}
                <div>
                    <label class="text-white dark:text-gray-200" for="deskripsi_toko">Deskripsi Toko</label>
                    <input value="{{ old('deskripsi_toko', $toko->deskripsi_toko) }}" id="deskripsi_toko" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" type="text" name="deskripsi_toko" required autofocus />
                    @error('deskripsi_toko')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end mt-6">
                <button type="submit" class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-blue-500 rounded-md hover:bg-blue-700 focus:outline-none focus:bg-gray-600">
                    {{ __('Perbarui Toko') }}
                </button>
            </div>
        </form>
    </section>
@endsection
