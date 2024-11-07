

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="../img/logos.svg">
    <title>Teras KBK || {{ Route::currentRouteName() }} </title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/x-icon" href="../img/whatsapp.png">

    <style>
        /* Hide spinner for Chrome, Safari, and newer versions of Edge */
        .no-spinner::-webkit-inner-spin-button,
        .no-spinner::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>

</head>

<body class="bg-cover bg-center bg-no-repeat w-full h-screen" style="background-image: url('../img/otp-bg-2.jpg');">
    <section class="max-sm:py-64 md:py-24">
        <div
            class="max-w-md max-sm:max-w-sm max-h-lg mx-auto my-auto text-center bg-white bg-opacity-30 backdrop-blur-lg px-4 sm:px-8 py-10 rounded-xl shadow-lg">
            <header class="mb-8">
                <h1 class="text-2xl font-bold mb-1">Mobile Phone Verification</h1>
                <p class="text-[15px] text-slate-100">Enter the 6-digit verification code that was sent to your phone
                    number.</p>
            </header>
            {{-- <form id="otp-form" method="POST" action="{{ route('verify.forgot.otp') }}"> --}}
                <form id="otp-form" method="POST" action="/verify-forgot-otp">
                @csrf
                <div class="flex items-center justify-center gap-3">
                    @for ($i = 0; $i < 6; $i++)
                        <input type="number"
                            class="no-spinner w-14 h-14 text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-4 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 max-sm:w-12 max-sm:h-12 max-sm:text-xl max-sm:p-2"
                            pattern="\d*" maxlength="1" name="otp[]" required autofocus />
                    @endfor
                </div>


                @error('otp')
                    <span>{{ $message }}</span>
                @enderror
                <div class="max-w-[260px] mx-auto mt-4">
                    <button type="submit"
                        class="w-full inline-flex justify-center whitespace-nowrap rounded-lg bg-indigo-500 px-3.5 py-2.5 text-sm font-medium text-white shadow-sm shadow-indigo-950/10 hover:bg-indigo-600 focus:outline-none focus:ring focus:ring-indigo-300 focus-visible:outline-none focus-visible:ring focus-visible:ring-indigo-300 transition-colors duration-150">
                        Verify Account
                    </button>
                </div>
            </form>

            <div class="text-sm text-slate-500 mt-4">
                Didn't receive code?
                <span id="countdown"></span>
                <a id="resend-link" class="font-medium text-indigo-500 hover:text-indigo-600 hidden"
                    {{-- href="{{ route('resend.otp.forgot') }}">Resend</a> --}}
                    href="/resend-otp-forgot">Resend</a>
            </div>

        </div>
    </section>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var countdownElement = document.getElementById('countdown');
            var resendLink = document.getElementById('resend-link');
            var countdownTime = 120; // 2 menit dalam detik
        
            function updateCountdown() {
                var minutes = Math.floor(countdownTime / 60);
                var seconds = countdownTime % 60;
        
                countdownElement.innerHTML = `Kirim ulang tersedia dalam ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        
                if (countdownTime > 0) {
                    countdownTime--;
                } else {
                    resendLink.classList.remove('hidden');
                    countdownElement.innerHTML = '';
                    clearInterval(countdownInterval);
                }
            }
        
            var countdownInterval = setInterval(updateCountdown, 1000);
        
            const form = document.getElementById('otp-form');
            const inputs = [...form.querySelectorAll('input[type=number]')];
            const submit = form.querySelector('button[type=submit]');
        
            const handleKeyDown = (e) => {
                if (!/^[0-9]{1}$/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Delete' && e.key !== 'Tab' && !e.metaKey) {
                    e.preventDefault();
                }
        
                if (e.key === 'Delete' || e.key === 'Backspace') {
                    const index = inputs.indexOf(e.target);
                    if (index > 0) {
                        inputs[index - 1].value = '';
                        inputs[index - 1].focus();
                    }
                }
            };
        
            const handleInput = (e) => {
                const { target } = e;
                const index = inputs.indexOf(target);
                if (target.value) {
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    } else {
                        submit.focus();
                    }
                }
            };
        
            const handleFocus = (e) => {
                e.target.select();
            };
        
            const handlePaste = (e) => {
                e.preventDefault();
                const text = e.clipboardData.getData('text');
                if (!new RegExp(`^[0-9]{${inputs.length}}$`).test(text)) {
                    return;
                }
                const digits = text.split('');
                inputs.forEach((input, index) => input.value = digits[index]);
                submit.focus();
            };
        
            inputs.forEach((input) => {
                input.addEventListener('input', handleInput);
                input.addEventListener('keydown', handleKeyDown);
                input.addEventListener('focus', handleFocus);
                input.addEventListener('paste', handlePaste);
            });
        
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(form);
                const otp = inputs.map(input => input.value).join('');
                if (otp.length !== inputs.length) {
                    Swal.fire({
                        icon: 'error',
                        title: 'OTP Tidak Lengkap',
                        text: 'Mohon masukkan OTP lengkap 6 digit.',
                    });
                    return;
                }
                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    if (response.ok) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Verifikasi Berhasil',
                            text: 'OTP telah diverifikasi. Anda akan dialihkan ke halaman reset password, tekan OK untuk melanjutkan.',
                            confirmButtonColor: '#3085d6', // Mengubah warna tombol menjadi biru
                        }).then(() => {
                            // window.location.href = "{{ route('home') }}";//sementara
                            window.location.href = "/reset-password-forgot"; // Pastikan nama route sesuai

                        });
                    } else {
                        const errorData = await response.json();
                        Swal.fire({
                            icon: 'error',
                            title: 'Verifikasi Gagal',
                            text: errorData.message || 'Terjadi kesalahan. Silakan coba lagi.',
                            confirmButtonColor: '#3085d6', // Mengubah warna tombol menjadi biru
                        });
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan. Silakan coba lagi.',
                    });
                }
            });
        });
        </script>

    
</body>

</html>

