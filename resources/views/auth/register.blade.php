<form method="POST" action="/register" class="sign-up-form">
    @csrf
    <h2 class="title">
        <img src="img/regis.svg" style="max-width: 150px; align-items: center;" alt="">
    </h2>
    <div class="input-field">
        <i class="fas fa-user"></i>
        <input type="text" id="name" placeholder="Username" name="name" value="{{ old('name') }}"
            style="background: transparent" required />
        {{-- <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" /> --}}
    </div>

    {{-- email --}}

    {{-- <div class="input-field">
      <i class="fas fa-envelope"></i>
      <input type="email" id="email" placeholder="Email" name="email" value="{{ old('email') }}" style="background: transparent" required />
      <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
    </div> --}}


    <div class="input-field">
        <i class="fas fa-phone"></i>
        <input type="number" id="phone" placeholder="No. HP" name="phone" value="{{ old('phone') }}"
            style="background: transparent" required />

    </div>

    <div class="input-field">
        <i class="fas fa-lock"></i>
    
        <input type="password" id="password" placeholder="Password" name="password" style="background: transparent" required />
    
        <!-- Icon show/hide password berada di dalam input -->
        <ion-icon id="show-eye-password" name="eye-outline" style="display: inline;"></ion-icon>
        <ion-icon id="hide-eye-password" name="eye-off-outline" style="display: none;"></ion-icon>
    </div>
    
    <div class="input-field">
        <i class="fas fa-lock"></i>
    
        <input id="password_confirmation" type="password" placeholder="Konfirmasi Password" name="password_confirmation"
            style="background: transparent" required />
    
        <!-- Icon show/hide password berada di dalam input -->
        <ion-icon id="show-eye-password-confirmation" name="eye-outline" style="display: inline;"></ion-icon>
        <ion-icon id="hide-eye-password-confirmation" name="eye-off-outline" style="display: none;"></ion-icon>
    </div>
    
    <input type="submit" class="btn" value="Sign up" />
    <p class="social-text">Atau Daftar Dengan Google</p>
    <div class="social-media">

        {{-- <a href="{{ url('auth/google') }}" class="social-icon"> --}}
        <a href="auth/google" class="social-icon">
            <i class="fab fa-google"></i>
        </a>

    </div>
</form>



{{-- Ini adalah form bawaan laravel breeze --}}

{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
          </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
