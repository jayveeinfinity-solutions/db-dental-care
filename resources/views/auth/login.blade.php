<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
        
        <p class="relative my-3 before:absolute before:top-1/2 before:left-0 before:right-0 before:border text-center">
            <span class="relative px-3 z-10 bg-white text-gray-400 text-xs">OR</span>
        </p>

        <div class="mt-4">
            <a href="{{ route('google.redirect') }}"
            class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" vi ewBox="0 0 48 48">
                <path fill="#EA4335" d="M24 9.5c3.9 0 7.4 1.5 10 4l7-7C36.7 2.6 30.7 0 24 0 14.6 0 6.3 5.4 2.5 13.3l8.2 6.4C12.3 13.2 17.6 9.5 24 9.5z"/>
                <path fill="#34A853" d="M46.1 24.6c0-1.6-.1-3.1-.4-4.6H24v9h12.4c-.5 2.5-2 4.6-4.2 6l6.5 5.1c3.8-3.5 6-8.6 6-14.5z"/>
                <path fill="#4A90E2" d="M24 48c6.5 0 12-2.1 16-5.7l-6.5-5.1c-1.8 1.2-4.2 2-6.9 2-5.3 0-9.8-3.6-11.4-8.5l-8.2 6.4C7.4 43 15 48 24 48z"/>
                <path fill="#FBBC05" d="M2.5 13.3C.9 16.7 0 20.3 0 24s.9 7.3 2.5 10.7l8.2-6.4C9.9 25.6 9.9 22.4 10.7 20l-8.2-6.7z"/>
            </svg>
            Sign in with Google
            </a>
        </div>
    </form>
</x-guest-layout>
