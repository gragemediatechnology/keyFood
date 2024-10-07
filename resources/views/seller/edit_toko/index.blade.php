<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Toko') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm p-10 sm:rounded-lg">
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

                <form action="/seller/edit_toko/update/{{ $toko->id_toko }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <h1 class="text-indigo-950 text-3xl font-bold">Edit Toko</h1>
                
                    <!-- Foto yang Ada -->
                    <div class="mt-4">
                        <x-input-label for="foto_profile_toko" :value="__('Foto yang Ada')" />
                        <img src="{{ asset('storage/' . $toko->foto_profile_toko) }}" class="h-[100px] w-auto" alt="{{ $toko->nama_toko }}">
                        <x-text-input id="foto_profile_toko" class="block mt-1 w-full" type="file" name="foto_profile_toko" />
                        <x-input-error :messages="$errors->get('foto_profile_toko')" class="mt-2" />
                    </div>
                
                    <!-- Nama Toko -->
                    <div class="mt-4">
                        <x-input-label for="nama_toko" :value="__('Nama Toko')" />
                        <x-text-input value="{{ old('nama_toko', $toko->nama_toko) }}" id="nama_toko" class="block mt-1 w-full" 
                            type="text" name="nama_toko" required autofocus autocomplete="nama_toko" />
                        <x-input-error :messages="$errors->get('nama_toko')" class="mt-2" />
                    </div>
                
                    <!-- Alamat Toko -->
                    <div class="mt-4">
                        <x-input-label for="alamat_toko" :value="__('Alamat Toko')" />
                        <x-text-input value="{{ old('alamat_toko', $toko->alamat_toko) }}" id="alamat_toko" class="block mt-1 w-full"
                            type="text" name="alamat_toko" required autofocus autocomplete="alamat_toko" />
                        <x-input-error :messages="$errors->get('alamat_toko')" class="mt-2" />
                    </div>

                    <!-- Deskripsi Toko -->
                    <div class="mt-4">
                        <x-input-label for="deskripsi_toko" :value="__('Deskripsi Toko')" />
                        <x-text-input value="{{ old('deskripsi_toko', $toko->deskripsi_toko) }}" id="deskripsi_toko" class="block mt-1 w-full"
                            type="text" name="deskripsi_toko" required autofocus autocomplete="deskripsi_toko" />
                        <x-input-error :messages="$errors->get('deskripsi_toko')" class="mt-2" />
                    </div>
                
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4">
                            {{ __('Perbarui Toko') }}
                        </x-primary-button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</x-app-layout>
