<x-auth-layout>
    <div class="layout-container flex h-full grow flex-col items-center justify-center py-10 px-4" x-data="register()">
        <a class="flex flex-row items-center gap-1 py-3.5" href="{{ route('home') }}">
            <span class="material-symbols-outlined text-xl">home</span>
            <span class="text-slate-700 dark:text-slate-200 text-base font-semibold">Back to home page</span>
        </a>
        <div class="layout-content-container flex flex-col max-w-[960px] w-full bg-white dark:bg-slate-900 rounded-xl shadow-xl overflow-hidden md:flex-row">
            <div class="hidden md:flex md:w-1/2 relative bg-primary/10 items-center justify-center p-8">
                <div class="absolute inset-0 z-0 opacity-40 bg-center bg-no-repeat bg-cover" data-alt="Modern bright dental office with professional equipment" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAE3_oTtJjnUnSsR15E2WOB0wss_tElNgW0-NMy9EtRJWX8hmuIf1ZNX3g_5ErccSDKao3Xdw9WOK9Q8ez5ohTS1jveeeN-MSq6JtY66RDqyn9c-FXog2USmzU4wpEnPPcbW59wxNiwEqq8S88wCVNhOrHJz1f95vxCsig9XOjEMZzqcNCXzrDefDlqaZdMo8-nfvJKNyNCrnwcGbp4xE-jQ1luT8jEigPVHBsuqya2F0cxO4nJS3c3vFoNLdDYUKqCZMplsGTw-DMm");'>
                </div>
                <div class="relative z-10 flex flex-col gap-6 text-white bg-primary/60 p-8 rounded-xl backdrop-blur-sm">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-4xl">dentistry</span>
                        <h2 class="text-2xl font-bold">DB Dental Care</h2>
                    </div>
                    <p class="text-lg font-medium">Join our community of over 10,000 patients receiving top-tier dental care.</p>
                    <ul class="flex flex-col gap-3">
                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-blue-200">check_circle</span> Easy appointment scheduling</li>
                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-blue-200">check_circle</span> Access to digital health records</li>
                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-blue-200">check_circle</span> Direct communication with specialists</li>
                    </ul>
                </div>
            </div>
            <div class="flex flex-col w-full md:w-1/2 p-8 lg:p-12">
                <div class="mb-8">
                    <h1 class="text-3xl font-black leading-tight tracking-tight text-slate-900 dark:text-white mb-2">Create Your Account</h1>
                    <p class="text-slate-500 dark:text-slate-400 text-base font-normal">Start your journey to a healthier, brighter smile today.</p>
                </div>
                <form class="flex flex-col gap-4" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="flex flex-col gap-1.5">
                        <x-input-label class="text-slate-700 dark:text-slate-200 text-sm font-semibold" for="name" :value="__('Name')" />
                        
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">person</span>
                            <x-text-input
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition-all"
                                placeholder="John Doe"
                                type="text" id="name" name="name" :value="old('name')"
                                required autofocus />
                        </div>

                         <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <x-input-label class="text-slate-700 dark:text-slate-200 text-sm font-semibold" for="email" :value="__('Email')" />

                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">mail</span>
                            <x-text-input
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition-all"
                                placeholder="john@example.com"
                                type="email" id="email" name="email" :value="old('email')"
                                required autocomplete="username"/>
                        </div>

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="flex flex-col gap-1.5">                        
                        <x-input-label class="text-slate-700 dark:text-slate-200 text-sm font-semibold" for="password" :value="__('Password')" />

                        <div class="relative flex items-center">
                            <span class="material-symbols-outlined absolute left-3 text-slate-400 text-xl">lock</span>
                            <input id="password"
                                class="w-full pl-10 pr-12 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition-all"
                                :type="showPassword ? 'text' : 'password'" name="password" placeholder="••••••••"
                                required autocomplete="new-password" />
                            <button class="absolute right-3 text-slate-400 hover:text-primary transition-colors" type="button">
                                <span x-show="showPassword" x-on:click="showPassword = !showPassword" class="material-symbols-outlined text-xl">visibility</span>
                                <span x-show="!showPassword" x-on:click="showPassword = !showPassword" class="material-symbols-outlined text-xl">visibility_off</span>
                            </button>
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <x-input-label class="text-slate-700 dark:text-slate-200 text-sm font-semibold" for="password_confirmation" :value="__('Confirm Password')" />
                        
                        <div class="relative flex items-center">
                            <span class="material-symbols-outlined absolute left-3 text-slate-400 text-xl">lock_reset</span>
                            <input
                                id="password_confirmation"
                                class="w-full pl-10 pr-12 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition-all" 
                                :type="showConfirm ? 'text' : 'password'" placeholder="••••••••" name="password_confirmation"
                                required autocomplete="new-password" />
                            <button class="absolute right-3 text-slate-400 hover:text-primary transition-colors" type="button">
                                <span x-show="showConfirm" x-on:click="showConfirm = !showConfirm" class="material-symbols-outlined text-xl">visibility</span>
                                <span x-show="!showConfirm" x-on:click="showConfirm = !showConfirm" class="material-symbols-outlined text-xl">visibility_off</span>
                            </button>
                        </div>

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                    <div class="flex items-start gap-3 py-2">
                        <input class="mt-1 rounded border-slate-300 text-primary focus:ring-primary"
                            id="terms"
                            name="terms"
                            type="checkbox"
                            value="1"
                            x-model="termsAccepted"
                        />
                        <label class="text-sm text-slate-500 dark:text-slate-400" for="terms">
                            I agree to the <a class="text-primary hover:underline font-medium" href="#">Terms of Service</a> and <a class="text-primary hover:underline font-medium" href="#">Privacy Policy</a>.
                        </label>
                    </div>
                    <button class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-3.5 rounded-lg shadow-lg shadow-primary/30 transition-all active:scale-[0.98] mt-2"
                        :class="{ 'opacity-50 cursor-not-allowed': !termsAccepted }"
                        type="submit"
                        :disabled="!termsAccepted">
                        Create Account
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
                <div class="mt-8 text-center">
                    <p class="text-slate-600 dark:text-slate-400">
                        {{ __('Already have an account?') }}
                        <a class="text-primary font-bold hover:underline" href="{{ route('login') }}">Log in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('register', () => ({
                showPassword: false,
                showConfirm: false,
                termsAccepted: false
            }));
        });
    </script>
    @endpush
</x-auth-layout>