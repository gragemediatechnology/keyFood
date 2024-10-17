@extends('admin.layouts.main-admin')
@section('container-admin')
    <main class="h-screen overflow-y-auto dark:bg-gray-900 dark:text-white">
        <div class="container px-6 mx-auto py-4 mb-8">
            <div class="container mx-auto px-4 py-6">
                <h1 class="text-2xl font-bold mb-6">FAQs</h1>
                <a href="/admin/faqs/create"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block dark:bg-blue-700 dark:hover:bg-blue-500">
                    Create New FAQ
                </a>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 dark:bg-gray-800 dark:border-gray-700">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 border-b-2 border-gray-300 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:bg-gray-700 dark:text-gray-300">
                                    Title
                                </th>
                                <th
                                    class="px-6 py-3 border-b-2 border-gray-300 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:bg-gray-700 dark:text-gray-300">
                                    Content
                                </th>
                                <th
                                    class="px-6 py-3 border-b-2 border-gray-300 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:bg-gray-700 dark:text-gray-300">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faqs as $faq)
                                <tr>
                                    <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-700 whitespace-nowrap">
                                        {{ $faq->title }}
                                    </td>
                                    <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-700">
                                        <p class="whitespace-pre-line break-words">
                                            {!! nl2br(e($faq->content)) !!}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-700 whitespace-nowrap">
                                        <a href="/admin/faqs/edit/{{ $faq->id }}"
                                            class="bg-yellow-500 hover:bg-yellow-700 text-gray-900 font-bold py-1 px-3 rounded dark:bg-yellow-600 dark:hover:bg-yellow-400 dark:text-gray-100">
                                            Edit
                                        </a>
                                        <form action="/admin/faqs/destroy/{{ $faq->id }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-700 text-gray-900 font-bold py-1 px-3 rounded dark:bg-red-600 dark:hover:bg-red-400 dark:text-gray-100">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
