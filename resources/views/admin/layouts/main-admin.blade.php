<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" class="overflow-hidden" x-data="data()" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}

    <title>Admin Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/gragemediatechnology/keyFood/e1b4f808733bdee8140603f23dc03bb63a0901dd/public/assets/css/tailwind.output.css">
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/gragemediatechnology/keyFood/e1b4f808733bdee8140603f23dc03bb63a0901dd/public/assets/css/card.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
    <link rel="icon" type="image/x-icon" href="../img/logos.svg" loading="lazy">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}



</head>

<body>
    @if (Auth::check())
        @include('admin.partials.sidebar-admin')
        <div class="container-admin" id="container-admin">
            @yield('container-admin')
        </div>
    @else
        <section class="bg-white dark:bg-gray-900 ">
            <div class="container flex items-center min-h-screen px-6 py-12 mx-auto">
                <div class="flex flex-col items-center max-w-sm mx-auto text-center">
                    <p class="p-3 text-sm font-medium text-blue-500 rounded-full bg-blue-50 dark:bg-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                    </p>
                    <h1 class="mt-3 text-2xl font-semibold text-gray-800 dark:text-white md:text-3xl">Page not found
                    </h1>
                    <p class="mt-4 text-gray-500 dark:text-gray-400">The page you are looking for doesn't exist. Here
                        are some helpful links:</p>

                    <div class="flex items-center justify-center w-full mt-6 gap-x-3 shrink-0 sm:w-auto">
                        <button onclick="history.back()"
                            class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg gap-x-2 sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 rtl:rotate-180">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                            </svg>


                            <span>Go back</span>
                        </button>

                        <a href="/home">
                            <button
                                class="w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                                Take me home
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
    <script defer
        src="https://rawcdn.githack.com/gragemediatechnology/keyFood/e1b4f808733bdee8140603f23dc03bb63a0901dd/public/assets/js/charts-lines.js">
    </script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script async
        src="https://rawcdn.githack.com/gragemediatechnology/keyFood/e1b4f808733bdee8140603f23dc03bb63a0901dd/public/assets/js/init-alpine.js">
    </script>
    <script defer
        src="https://rawcdn.githack.com/gragemediatechnology/keyFood/e1b4f808733bdee8140603f23dc03bb63a0901dd/public/assets/js/charts-pie.js">
    </script>

    <script defer
        src="https://rawcdn.githack.com/gragemediatechnology/keyFood/e1b4f808733bdee8140603f23dc03bb63a0901dd/public/assets/js/card.js">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function toggleDropdown() {
            var menu = document.getElementById('dropdown-menu');
            var button = document.getElementById('menu-button');
            var expanded = button.getAttribute('aria-expanded') === 'true' || false;
            button.setAttribute('aria-expanded', !expanded);
            menu.classList.toggle('hidden');
        }
    </script>

</body>

</html>
