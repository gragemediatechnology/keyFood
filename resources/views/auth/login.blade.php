<style>
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


<form method="POST" action="/login" class="sign-in-form">
    @csrf
    <h2 class="title">
        <img src="img/login.svg" style="width: 150px; align-items: center;" alt="">
    </h2>

    <div class="input-field">
        <i class="fas fa-phone"></i>
        <input type="number" id="phone" placeholder="No. HP" name="phone" value="{{ old('phone') }}"
            style="background: transparent" required />
    </div>
    <div class="input-field">
        <i class="fas fa-lock"></i>
    
        <input type="password" id="password-login" placeholder="Password" name="password" required />
    
        <!-- Icon show/hide password berada di dalam input -->
        <ion-icon id="show-eye-password-login" name="eye-outline" style="display: inline;"></ion-icon>
        <ion-icon id="show-eye-password-login" name="eye-off-outline" style="display: none;"></ion-icon>
    </div>    
    <input type="submit" value="Login" class="btn solid" />
    <a href="/forgot-password" style="text-decoration: none;"
        class="inline-flex items-center px-4 py-2  bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
        <p class="social-text">Lupa Password</p>
    </a>
    <p class="social-text">Atau Login Dengan Google</p>
    <div class="social-media">
        <a href="/auth/google" class="social-icon">
            <i class="fab fa-google"></i>
        </a>
    </div>
</form>



<!-- SweetAlert Integration -->
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: @json($errors->first()),
                    timer: 3000, // Durasi tampilan alert dalam milidetik
                    showConfirmButton: false
                });
            }, 1000); // Penundaan dalam milidetik (1 detik)
        });
    </script>
@endif
