@extends('admin.layouts.main-admin')
@section('container-admin')
<main class="h-screen flex flex-col">
    <div class="container px-6 mx-auto py-4 mb-8 flex-1 flex flex-col">
        <section class="live-chat flex flex-col flex-1 sm:mx-10 sm:my-5">
            <!-- Chat area -->
            <div class="flex-1 overflow-y-auto p-3 sm:p-4 space-y-3 sm:space-y-4">
                <!-- Messages from first user -->
                <div class="space-y-2">
                    <div class="flex items-start space-x-2">
                        <img src="{{ Auth::user()->img ?? './img/client-1.jpg' }}" alt="User avatar" loading="lazy"
                            class="w-6 h-6 sm:w-8 sm:h-8 rounded-full flex-shrink-0">
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-2 sm:p-3 max-w-[75%] sm:max-w-md">
                            <p class="font-semibold dark:text-white text-sm sm:text-base">Shanay Cruz</p>
                            <p class="dark:text-gray-300 text-sm">Guts, I need a review of work. Are you ready?</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">05:14 PM</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-2">
                        <div class="w-6 sm:w-8 flex-shrink-0"></div> <!-- Spacer to align with avatar -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-2 sm:p-3 max-w-[75%] sm:max-w-md">
                            <p class="dark:text-gray-300 text-sm">Let me know</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">05:14 PM</p>
                        </div>
                    </div>
                </div>

                <!-- Messages from second user -->
                <div class="space-y-2 mt-4">
                    <div class="flex items-start justify-end space-x-2">
                        <div class="bg-blue-500 text-white rounded-lg p-2 sm:p-3 max-w-[75%] sm:max-w-md">
                            <p class="text-sm">Yes, let's see, send your work here</p>
                            <p class="text-xs text-blue-200 mt-1">05:14 PM</p>
                        </div>
                        <img src="{{ Auth::user()->img ?? './img/client-1.jpg' }}" alt="Your avatar"
                            class="w-6 h-6 sm:w-8 sm:h-8 rounded-full flex-shrink-0" loading="lazy">
                    </div>

                    <div class="flex items-start justify-end space-x-2">
                        <div class="bg-blue-500 text-white rounded-lg p-2 sm:p-3 max-w-[75%] sm:max-w-md">
                            <p class="text-sm">Anyone on for lunch today</p>
                            <p class="text-xs text-blue-200 mt-1">You</p>
                        </div>
                        <div class="w-6 sm:w-8 flex-shrink-0"></div> <!-- Spacer to align with avatar -->
                    </div>
                </div>
            </div>

            <!-- Input area -->
            <div class="mb-8">
            <div
                class="sticky bottom-8 mb-8 bg-white dark:bg-gray-800 border-t-2 border-2 rounded-full dark:border-gray-700 p-2">
                <div class="flex items-center space-x-2 dark:bg-gray-700 rounded-full">
                    <div class="pl-2 sm:pl-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-gray-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="text" placeholder="Type here..."
                        class="flex-1 bg-transparent border-none rounded-full px-3 sm:px-4 py-1 sm:py-2 focus:outline-none dark:text-white placeholder-gray-400 text-sm sm:text-base">
                    <div class="flex items-center pr-2 sm:pr-2 space-x-2">
                        <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                        </button>
                        <button
                            class="bg-blue-600 text-white rounded-full px-3 py-1 sm:px-4 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 flex items-center text-sm sm:text-base">
                            <span class="mr-2">Send</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </section>
    </div>
</main>

@endsection
