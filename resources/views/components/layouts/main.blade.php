<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"
        integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous">
    </script>
    {{-- <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script> --}}
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>




    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>

    <link rel="stylesheet"
        href="https://raw.githack.com/gragemediatechnology/keyFood/main/public/css/clock.css">
    <link rel="stylesheet"
        href="https://raw.githack.com/gragemediatechnology/keyFood/main/public/css/profile.css">
    <link rel="stylesheet"
        href="https://raw.githack.com/gragemediatechnology/keyFood/main/public/css/style.css">
    <link rel="stylesheet"
        href="https://raw.githack.com/gragemediatechnology/keyFood/main/public/css/home.css">
    <link rel="stylesheet"
        href="https://raw.githack.com/gragemediatechnology/keyFood/main/public/css/load.css">
    <link rel="stylesheet"
        href="https://raw.githack.com/gragemediatechnology/keyFood/main/public/css/app.css">
    <link rel="stylesheet"
        href="https://raw.githack.com/gragemediatechnology/keyFood/main/public/css/halaman-toko.css">
    <link rel="stylesheet"
        href="https://raw.githack.com/gragemediatechnology/keyFood/main/public/css/product-slider.css">
    <link rel="stylesheet"
        href="https://raw.githack.com/gragemediatechnology/keyFood/main/public/css/stores.css">
    <link rel="stylesheet"
        href="https://raw.githack.com/gragemediatechnology/keyFood/main/public/css/home-container.css">
    <link rel="stylesheet"
        href="https://raw.githack.com/gragemediatechnology/keyFood/main/public/css/categories.css">
    <link rel="stylesheet"
        href="https://raw.githack.com/gragemediatechnology/keyFood/main/public/css/checkout.css">
    <link rel="stylesheet"
        href="https://raw.githack.com/gragemediatechnology/keyFood/main/public/css/cart.css">
    <link rel="stylesheet"
        href="https://raw.githack.com/gragemediatechnology/keyFood/main/public/css/history.css">
    <link rel="stylesheet"
        href="https://raw.githack.com/gragemediatechnology/keyFood/main/public/css/nav.css">

    <!-- <link rel="stylesheet"
        href="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/css/profile.css">
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/css/style.css">
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/css/home.css">
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/css/load.css">
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/css/app.css">
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/css/clock.css">
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/css/halaman-toko.css">
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/css/product-slider.css">
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/css/stores.css">
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/css/home-container.css">
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/css/categories.css">
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/css/checkout.css">
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/css/cart.css">
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/css/history.css">
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/css/nav.css"> -->


    <link rel="icon" type="image/x-icon" href="../img/logos.svg">
    {{-- <title>KeyFood | {{ $title }} </title> --}}
    {{-- ini diatas, disebelah dikasih title statis --}}
    @livewireStyles
</head>

<body>
    <!-- <div id="preloader">
        <dotlottie-player src="https://lottie.host/cfd42497-424b-4328-8abd-fddc7a43046c/RORTJFVPEA.json"
            background="transparent" speed="1" style="width: 300px; height: 300px;" loop
            autoplay></dotlottie-player>
    </div> -->
    @include('partials.navbar')

    <div class="container md:my-10" id="container">
        @include('partials.profile')
        {{-- @include('partials.live-chat') --}}
        @yield('container')
    </div>
    @include('partials.footer')
    @include('partials.bot-bar')
</body>
<script src="https://cdn.jsdelivr.net/npm/livewire@0.6.1/lib/compiler.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/alpine.min.js" defer></script>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
<script src="https://unpkg.com/scrollreveal"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script defer src="https://raw.githack.com/gragemediatechnology/keyFood/main/public/js/clock.js"></script>
<script defer src="https://raw.githack.com/gragemediatechnology/keyFood/main/public/js/cart.js"></script>
<script defer src="https://raw.githack.com/gragemediatechnology/keyFood/main/public/js/checkout.js"></script>
<script defer src="https://raw.githack.com/gragemediatechnology/keyFood/main/public/js/stores.js"></script>
<script defer src="https://raw.githack.com/gragemediatechnology/keyFood/main/public/js/categories.js"></script>
<script defer src="https://raw.githack.com/gragemediatechnology/keyFood/main/public/js/home.js"></script>
<script defer src="https://raw.githack.com/gragemediatechnology/keyFood/main/public/js/load.js"></script>
<script defer src="https://raw.githack.com/gragemediatechnology/keyFood/main/public/js/product.js"></script>
<script defer src="https://raw.githack.com/gragemediatechnology/keyFood/main/public/js/home-container.js"></script>
<script defer src="https://raw.githack.com/gragemediatechnology/keyFood/main/public/js/nav.js"></script>

<!-- <script defer src="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/js/cart.js"></script>
<script defer src="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/js/checkout.js"></script>
<script defer src="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/js/stores.js"></script>
<script defer src="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/js/categories.js"></script>
<script defer src="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/js/home.js"></script>
<script defer src="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/js/load.js"></script>
<script defer src="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/js/product.js"></script>
<script defer src="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/js/home-container.js"></script>
<script defer src="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/js/nav.js"></script> -->
</html>
