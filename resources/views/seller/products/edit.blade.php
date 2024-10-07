@extends('layouts.main')

@section('content')
    <div class="container py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm p-10 sm:rounded-lg">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('My Product') }}
                </h2>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li class="py-5 bg-red-500 text-white font-bold">
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="/seller/products/update/{{ $product -> id }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <h1 class="text-indigo-950 text-3xl font-bold">Edit Product</h1>

                    <div class="mt-4">
                        <label for="photo" class="block font-medium text-sm text-gray-700">{{ __('Existing Photo') }}</label>
                        <img src="{{ asset($product->photo) }}" class="h-[100px] w-auto" alt="{{ $product->name }}">
                        <input id="photo" class="block mt-1 w-full" type="file" name="photo">
                        @error('photo')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Name') }}</label>
                        <input value="{{ $product->name }}" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus>
                        @error('name')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="price" class="block font-medium text-sm text-gray-700">{{ __('Price') }}</label>
                        <input value="{{ $product->price }}" id="price" class="block mt-1 w-full" type="number" name="price" required>
                        @error('price')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="quantity" class="block font-medium text-sm text-gray-700">{{ __('Quantity') }}</label>
                        <input value="{{ $product->quantity }}" id="quantity" class="block mt-1 w-full" type="number" name="quantity" required>
                        @error('quantity')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="category" class="block font-medium text-sm text-gray-700">{{ __('Category') }}</label>
                        <select name="category_id" id="category" class="w-full py-3 pl-5 border">
                            <option value="{{ $product->category->id }}" selected>{{ $product->category->name }}</option>
                            @forelse($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @empty
                                <option value="">No Categories Available</option>
                            @endforelse
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="store" class="block font-medium text-sm text-gray-700">{{ __('Store') }}</label>
                        <select name="store_id" id="store" class="w-full py-3 pl-5 border">
                            <option value="{{ $product->store_id }}" selected>{{ $product->toko->nama_toko }}</option>
                            @forelse($stores as $store)
                                <option value="{{ $store->id_toko }}">{{ $store->nama_toko }}</option>
                            @empty
                                <option value="">No Stores Available</option>
                            @endforelse
                        </select>
                        @error('store_id')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="slug" class="block font-medium text-sm text-gray-700">{{ __('Slug') }}</label>
                        <textarea name="slug" id="slug" class="w-full py-3 pl-5 border">{{ $product->slug }}</textarea>
                        @error('slug')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Update Product') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
