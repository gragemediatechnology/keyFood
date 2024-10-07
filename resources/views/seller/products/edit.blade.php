<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm p-10 sm:rounded-lg">
                @if($errors->any())
                <div class="alert-alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li class="py-5 bg-red-500 text-white font-bold">
                            {{ $error }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- <form method="POST" action="{{ route('seller.products.update', $product) }}" enctype="multipart/form-data"> --}}
                <form method="POST" action="/seller/products/update/{{ $product -> id }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <h1 class="text-indigo-950 text-3xl font-bold">Edit Product</h1>

                    <div class="mt-4">
                        <x-input-label for="photo" :value="__('Existing Photo')" />
                        <img src="{{ asset($product->photo) }}" class="h-[100px] w-auto" alt="{{ $product->name }}">
                        <x-text-input id="photo" class="block mt-1 w-full" type="file" name="photo" />
                        <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                    </div>

                    <!-- Name -->
                    <div class="mt-4">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input value="{{ $product->name }}" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="price" :value="__('Price')" />
                        <x-text-input value="{{ $product->price }}" id="price" class="block mt-1 w-full" type="number" name="price" required autofocus autocomplete="price" />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="quantity" :value="__('Quantity')" />
                        <x-text-input value="{{ $product->quantity }}" id="quantity" class="block mt-1 w-full" type="number" name="quantity" required autofocus autocomplete="quantity" />
                        <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                    </div>

                    <!-- Category -->
                    <div class="mt-4">
                        <x-input-label for="category" :value="__('Category')" />
                        <select name="category_id" id="category" class="w-full py-3 pl-5 border">
                            <option value="{{ $product->category->id }}" selected>{{ $product->category->name }}</option>
                            @forelse($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @empty
                            <option value="">No Categories Available</option>
                            @endforelse
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <!-- Store -->
                    <div class="mt-4">
                        <x-input-label for="store" :value="__('Store')" />
                        <select name="store_id" id="store" class="w-full py-3 pl-5 border">
                            <!-- Display the currently selected store -->
                            <option value="{{ $product->store_id }}" selected>
                                {{ $product->toko->nama_toko }}
                            </option>
                    
                            <!-- Display other stores available -->
                            @forelse($stores as $store)
                                <option value="{{ $store->id_toko }}">
                                    {{ $store->nama_toko }}
                                </option>
                            @empty
                                <option value="">No Stores Available</option>
                            @endforelse
                        </select>
                        <x-input-error :messages="$errors->get('store_id')" class="mt-2" />
                    </div>                    

                    <div class="mt-4">
                        <x-input-label for="slug" :value="__('Slug')" />
                        <textarea name="slug" id="slug" class="w-full py-3 pl-5 border">{{ $product->slug }}</textarea>
                        <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4">
                            {{ __('Update Product') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
