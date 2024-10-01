@extends('admin.layouts.main-admin')
@section('container-admin')
@if (Auth::check())
<main class="h-screen pb-16 overflow-y-auto flex items-center justify-center">
    <div class="container grid px-6 mx-auto py-4 mb-8">
        <div class="h-full flex items-center justify-center ">
            <div class="rounded-lg  px-4 pt-6 pb-8 w-full max-w-lg shadow-lg dark:bg-gray-800">
                <div class="mx-auto rounded-full overflow-hidden" style="width: 100px; height:auto;">
                    <!-- <img src="{{ Auth::user()->img ?? './img/client-1.jpg' }}" alt="User Image"
                         style="width: 100px; height:auto;" /> -->
                         <img src="/{{ Auth::user()->img ? asset(Auth::user()->img) : asset('img/client-1.jpg') }}" alt="User Image">
                         />
                </div>

                <h1 class="my-2 text-center text-xl font-bold leading-8 text-gray-900 dark:text-gray-100">
                    {{ Auth::user()->name }}
                </h1>

                <div class="flex justify-center">
                    <span class="inline-flex items-center text-center rounded-md bg-gray-100 px-3 py-1 text-sm font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 dark:bg-gray-600">
                        @if (Auth::user()->hasRole('admin'))
                            Admin
                        @endif
                    </span>
                </div>

                <h3 class="mt-2 text-center text-sm font-semibold leading-6 text-gray-600 dark:text-gray-300">
                    Marketing Exec. at Denva Corp
                </h3>

                <p class="mt-2 text-center text-sm leading-6 text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Architecto, placeat!
                </p>

                <div class="flex justify-center mt-4">
                    <a href="/admin-profile">
                        <button type="button" class="text-white bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-4 py-2">
                            Edit Profile
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
@endif
@endsection
