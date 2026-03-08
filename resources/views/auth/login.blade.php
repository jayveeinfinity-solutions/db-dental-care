<x-auth-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <div class="layout-container flex h-full grow flex-col items-center justify-center py-10 px-4" x-data="signin()">
        <a class="flex flex-row items-center gap-1 py-3.5" href="{{ route('home') }}">
            <span class="material-symbols-outlined text-xl">home</span>
            <span class="text-slate-700 dark:text-slate-200 text-base font-semibold">Back to home page</span>
        </a>
        <div class="layout-content-container flex flex-col max-w-[960px] w-full bg-white dark:bg-slate-900 rounded-xl shadow-xl overflow-hidden md:flex-row">
            <div class="hidden md:flex md:w-1/2 lg:w-3/5 relative bg-slate-100 dark:bg-slate-800">
                <div class="absolute inset-0 bg-cover bg-center" data-alt="Modern clean bright dental office waiting area" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCQEgJo4KP2ZS6BxazzjRbuxVFEV_CJZ8-9Q8O7hxgmNe2_3RVErAvjMFR7cM61_9yOiY-7IL6GwSjFkT7Bx5BbjIl7ZvY037ycP-gf1jiXcY5mwk3LWcjPNcXKeNVZRX8nFZTOoLY_KjplbXtNhhkexbI1tvd7M2C94DSW6EeV72Wkv5YMg9B7Ngjzs4P5CmA7kxCcJ0H0wZemQnr-kX1P6ZBpx_P07UOWRWckYGCuVpkyz1BPtFZZik_cBdqNWU-aI_hAUCwGdfq4');"></div>
                <div class="absolute inset-0 bg-primary/20 mix-blend-multiply"></div>
                <div class="relative z-10 flex flex-col justify-end p-12 text-white">
                    <h2 class="text-4xl font-black mb-4 leading-tight">Advanced dental care <br/>for a brighter smile.</h2>
                    <p class="text-lg opacity-90 max-w-md">Join thousands of patients who trust DentalCare Pro for their complete oral health journey.</p>
                </div>
            </div>
            <div class="flex flex-col w-full md:w-1/2 p-8 lg:p-12">
                <div class="mb-8">
                    <h1 class="text-3xl font-black leading-tight tracking-tight text-slate-900 dark:text-white mb-2">Welcome Back</h1>
                    <p class="text-slate-500 dark:text-slate-400 text-base font-normal">Log in to manage your dental health and appointments.</p>
                </div>
                <form class="flex flex-col gap-4" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="flex flex-col gap-1.5">
                        <x-input-label class="text-slate-700 dark:text-slate-200 text-sm font-semibold" for="email" :value="__('Email')" />

                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">mail</span>
                            <x-text-input
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition-all"
                                placeholder="john@example.com"
                                type="email" id="email" name="email" :value="old('email')"
                                required autofocus autocomplete="email"/>
                        </div>

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="flex flex-col gap-1.5">                        
                        <x-input-label class="text-slate-700 dark:text-slate-200 text-sm font-semibold" for="password" :value="__('Password')" />

                        <div class="relative flex items-center">
                            <span class="material-symbols-outlined absolute left-3 text-slate-400 text-xl">lock</span>
                            <input id="password"
                                class="w-full pl-10 pr-12 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition-all"
                                :type="showPassword ? 'text' : 'password'" id="password" name="password" placeholder="••••••••"
                                required autocomplete="current-password"/>
                            <button class="absolute right-3 text-slate-400 hover:text-primary transition-colors" type="button">
                                <span x-show="showPassword" x-on:click="showPassword = !showPassword" class="material-symbols-outlined text-xl">visibility</span>
                                <span x-show="!showPassword" x-on:click="showPassword = !showPassword" class="material-symbols-outlined text-xl">visibility_off</span>
                            </button>
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <button class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-lg transition-colors shadow-lg shadow-primary/20 flex items-center justify-center gap-2"
                        type="submit">
                        <span>Log In</span>
                        <span class="material-symbols-outlined text-lg">login</span>
                    </button>
                    <div class="relative my-6 flex items-center">
                        <div class="flex-grow border-t border-slate-200 dark:border-slate-700"></div>
                        <span class="mx-4 flex-shrink text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">OR CONTINUE WITH</span>
                        <div class="flex-grow border-t border-slate-200 dark:border-slate-700"></div>
                    </div>
                    <div>
                        <a href="{{ route('google.redirect') }}"
                        class="w-full inline-flex items-center justify-center px-4 py-3.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 48 48">
                                <path fill="#EA4335" d="M24 9.5c3.9 0 7.4 1.5 10 4l7-7C36.7 2.6 30.7 0 24 0 14.6 0 6.3 5.4 2.5 13.3l8.2 6.4C12.3 13.2 17.6 9.5 24 9.5z"/>
                                <path fill="#34A853" d="M46.1 24.6c0-1.6-.1-3.1-.4-4.6H24v9h12.4c-.5 2.5-2 4.6-4.2 6l6.5 5.1c3.8-3.5 6-8.6 6-14.5z"/>
                                <path fill="#4A90E2" d="M24 48c6.5 0 12-2.1 16-5.7l-6.5-5.1c-1.8 1.2-4.2 2-6.9 2-5.3 0-9.8-3.6-11.4-8.5l-8.2 6.4C7.4 43 15 48 24 48z"/>
                                <path fill="#FBBC05" d="M2.5 13.3C.9 16.7 0 20.3 0 24s.9 7.3 2.5 10.7l8.2-6.4C9.9 25.6 9.9 22.4 10.7 20l-8.2-6.7z"/>
                            </svg>
                            Sign in with Google
                        </a>
                    </div>
                </form>
                <!-- Sign Up Link -->
                <div class="mt-10 text-center">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        Don't have an account yet? 
                        <a class="font-bold text-primary hover:underline" href="{{ route('register') }}">Sign up for free</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('signin', () => ({
                showPassword: false
            }));
        });
    </script>
    @endpush
</x-auth-layout>
