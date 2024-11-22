@extends('admin.layouts.main-admin')

@section('container-admin')
<main class="h-screen overflow-y-auto bg-white dark:bg-gray-900">
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Form Edit Kategori -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-12">
            @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                    <li class="py-2 bg-red-500 dark:bg-red-700 text-white font-bold">
                        {{ $error }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <form method="POST" action="/admin/categories/update/{{ $category->id }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="mb-4">
                    <label for="slug" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Slug</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Description</label>
                    <textarea id="description" name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $category->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="icon" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Icon</label>
                    <input type="file" id="icon" name="icon" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline">
                    @if($category->icon)
                        <img src="{{ url($category->icon) }}" style="width: 100px" class="h-10 mt-2" alt="Category Icon" loading="lazy">
                    @endif
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</main>
@endsection
