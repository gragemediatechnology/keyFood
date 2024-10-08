<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/css/app.css">
    
    <link rel="icon" type="image/x-icon" href="../img/logos.svg">
    <title>KeyFood || {{ Route::currentRouteName() }}</title>

    <style>
        /* Hide spinner for Chrome, Safari, and Edge */
        .no-spinner::-webkit-inner-spin-button,
        .no-spinner::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body>
    @php
        $admins = App\Models\User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();
    @endphp

    <div id="preloader">
        <dotlottie-player src="https://lottie.host/cfd42497-424b-4328-8abd-fddc7a43046c/RORTJFVPEA.json"
            background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay></dotlottie-player>
    </div>

    @include('partials.navbar')

    <div class="container md:mt-10" id="container">
        @include('partials.profile')
        @yield('container')
        @include('partials.live-chat')
    </div>

    @include('partials.footer')
    @include('partials.bot-bar')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>

    <script defer src="https://rawcdn.githack.com/jipyy/keyFood/.../public/js/cart.js"></script>
    <script defer src="https://rawcdn.githack.com/jipyy/keyFood/.../public/js/checkout.js"></script>
    <!-- Add other script imports as needed -->

    <script>
        let timer;
        const countdown = 10 * 60 * 1000; // 10 minutes in milliseconds

        function resetTimer() {
            clearTimeout(timer);
            timer = setTimeout(logoutUser, countdown);
        }

        function logoutUser() {
            fetch('{{ route('logout') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ _method: 'POST' })
            }).then(response => {
                if (response.ok) {
                    window.location.href = '/'; // Redirect to homepage
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        }

        window.onload = resetTimer;
        window.onmousemove = resetTimer;
        window.onmousedown = resetTimer;
        window.ontouchstart = resetTimer;
    </script>
<!-- SweetAlert Integration -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if ($errors->any())
            setTimeout(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: @json($errors->first()),
                    timer: 5000, // Durasi tampilan alert dalam milidetik
                    showConfirmButton: true
                });
            }, 5000); // Penundaan dalam milidetik (1 detik)
        @endif

        @if (session('success'))
            setTimeout(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    timer: 500000, // Durasi tampilan alert dalam milidetik
                    showConfirmButton: true
                });
            }, 500000); // Penundaan dalam milidetik (1 detik)
        @endif
    });
</script>

     <!-- Sweet Alert Script -->
     <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 300000,
                showConfirmButton: true,
            });
        @endif
    
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                timer: 300000,
                showConfirmButton: true,
            });
        @endif
    </script>


</html>
