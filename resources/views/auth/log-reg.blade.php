<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/css/style-login.css">

    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css">
    <link rel="icon" type="image/x-icon" href="../img/logos.svg">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <title>Sign in / Sign up</title>
    <style>
        /* Hide the number input spinners */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        input[type=number]:focus {
            outline: none;
        }

        .input-field {
            position: relative;
            width: 100%;
        }

        /* Style untuk input password */
        .input-field input {
            width: 100%;
            padding: 10px 40px 10px 10px;
            /* Tambahkan padding untuk memberi ruang pada ikon */
            font-size: 16px;
            border: 1px solid transparent;
            border-radius: 5px;
            background: transparent;
        }

        /* Style untuk ikon */
        .input-field ion-icon {
            position: absolute;
            right: 10px;
            /* Posisi di sebelah kanan input field */
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 20px;
        }
    </style>

</head>

<body>
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.js"></script>
    <div id="preloader">
        <dotlottie-player src="https://lottie.host/cfd42497-424b-4328-8abd-fddc7a43046c/RORTJFVPEA.json"
            background="transparent" speed="1" style="width: 300px; height: 300px;" loop
            autoplay></dotlottie-player>
    </div>

    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                @include('auth.login')

                @include('auth.register')
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Pendatang Baru?</h3>
                    <p>
                        Baru di sini? Selamat datang! Mari buat akun dan mulai perjalanan kuliner Anda.
                    </p>
                    <button class="btn transparent" id="sign-up-btn">
                        Register
                    </button>
                </div>
                <img src="img/log.svg" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Sudah punya akun?</h3>
                    <p>
                        Sedang ingin sesuatu yang spesial? Login dan mari kita puaskan selera Anda!
                    </p>
                    <button class="btn transparent" id="sign-in-btn">
                        Sign in
                    </button>
                </div>
                <img src="img/register.svg" class="image" alt="" />
            </div>
        </div>
    </div>

    <script defer
        src="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/js/login.js"></script>

    <!-- SweetAlert untuk notifikasi sukses mengubah password -->
    @if (session('sweet_alert'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: '{{ session('sweet_alert.icon') }}',
                    title: '{{ session('sweet_alert.title') }}',
                    text: '{{ session('sweet_alert.text') }}',
                    timer: 8000,
                    showConfirmButton: true
                });
            });
        </script>
    @endif

    <script>
        // Fungsi untuk toggle password visibility
        function togglePassword(inputId, showEyeId, hideEyeId) {
            const passwordField = document.getElementById(inputId);
            const showEye = document.getElementById(showEyeId);
            const hideEye = document.getElementById(hideEyeId);

            if (passwordField.type === 'password') {
                passwordField.type = 'text'; // Ubah menjadi teks (password terlihat)
                showEye.style.display = 'none'; // Sembunyikan ikon mata terbuka
                hideEye.style.display = 'inline'; // Tampilkan ikon mata tertutup
            } else {
                passwordField.type = 'password'; // Ubah kembali menjadi password (tersembunyi)
                showEye.style.display = 'inline'; // Tampilkan ikon mata terbuka
                hideEye.style.display = 'none'; // Sembunyikan ikon mata tertutup
            }
        }

        // Event listener untuk password login
        document.getElementById('show-eye-password-login').addEventListener('click', function() {
            togglePassword('password-login', 'show-eye-password-login', 'hide-eye-password-login');
        });
        document.getElementById('hide-eye-password-login').addEventListener('click', function() {
            togglePassword('password-login', 'show-eye-password-login', 'hide-eye-password-login');
        });

        // Event listener untuk password register
        document.getElementById('show-eye-password-register').addEventListener('click', function() {
            togglePassword('password-register', 'show-eye-password-register', 'hide-eye-password-register');
        });
        document.getElementById('hide-eye-password-register').addEventListener('click', function() {
            togglePassword('password-register', 'show-eye-password-register', 'hide-eye-password-register');
        });

        // Event listener untuk password confirmation
        document.getElementById('show-eye-password-confirmation').addEventListener('click', function() {
            togglePassword('password_confirmation', 'show-eye-password-confirmation',
                'hide-eye-password-confirmation');
        });
        document.getElementById('hide-eye-password-confirmation').addEventListener('click', function() {
            togglePassword('password_confirmation', 'show-eye-password-confirmation',
                'hide-eye-password-confirmation');
        });
    </script>
</body>

</html>
