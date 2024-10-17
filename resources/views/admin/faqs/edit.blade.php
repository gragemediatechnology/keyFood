@extends('admin.layouts.main-admin')
@section('container-admin')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">{{ isset($faq) ? 'Edit FAQ' : 'Create FAQ' }}</h1>

        <form action="/admin/faqs/update/{{ $faq->id ?? '' }}" method="POST"
            class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 dark:bg-gray-800 dark:text-white">
            @csrf
            @if (isset($faq))
                @method('PUT')
            @endif

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-300">Title</label>
                <input type="text" name="title" id="title"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                    value="{{ old('title', $faq->title ?? '') }}" required>
            </div>

            <div class="mb-6">
                <label for="content" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-300">Content</label>
                <textarea name="content" id="content" rows="5"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                    required>{!! nl2br(e(old('content', $faq->content ?? ''))) !!}</textarea>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Save
                </button>
            </div>
        </form>
    </div>
@endsection
