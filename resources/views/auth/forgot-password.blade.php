<x-auth-layout>
    <main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl w-full bg-white dark:bg-slate-900 rounded-xl shadow-xl overflow-hidden flex flex-col md:flex-row">
            <!-- Side Image -->
            <div class="md:w-1/2 relative min-h-[300px]">
                <div class="absolute inset-0 bg-cover bg-center" data-alt="Modern clean dental clinic treatment room" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuC_g59-kh-E29Tb6UUWS4t5cLdDTVQzYh94_qE4kaIkT3pOdL9ER4Ys9_QdTwmGQMQwnkajeUmnPDxYUHyvxHNloEJLEbkkJxA8MFgXFr_vo9aU4DbwmMwcaIr4VhoUWaASdTfdgLPSpPjAOR5RCmIzla7O-tLOO2MRMSMOtAMHcc-aJhIuvzFvqheNV-063_DbVKWFPdYjVkX5vAibMZOmFGxlwT-fxcsyjZ5TXb43KysujsC_AMVpEc9m7rN9rb3pw6ZLF0Ku384j')"></div>
                <div class="absolute inset-0 bg-primary/20 mix-blend-multiply"></div>
                <div class="absolute bottom-0 left-0 p-8 text-white hidden md:block">
                    <h3 class="text-2xl font-bold mb-2">Expert Dental Care</h3>
                    <p class="text-sm opacity-90">Helping you regain your smile with professional and compassionate dental services.</p>
                </div>
            </div>
            <!-- Forgot Password Form -->
            <div class="md:w-1/2 p-8 sm:p-12 lg:p-16 flex flex-col justify-center">
                <div class="mb-8">
                    <h1 class="text-3xl font-black text-slate-900 dark:text-white mb-4 tracking-tight">Forgot Password?</h1>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                        Enter the email address associated with your account and we'll send you a link to reset your password.
                    </p>
                </div>
                <form class="space-y-6" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="group">
                        <x-input-label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2" for="email" :value="__('Email')" />
                        <div class="relative flex items-center">
                            <span class="material-symbols-outlined absolute left-3 text-slate-400 group-focus-within:text-primary transition-colors">mail</span>
                            <input class="w-full pl-10 pr-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-lg focus:ring-2 focus:ring-primary focus:bg-white dark:focus:bg-slate-700 text-slate-900 dark:text-white transition-all placeholder:text-slate-400" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="name@example.com" autofocus required/>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <button class="w-full bg-primary text-white py-3 px-6 rounded-lg font-bold text-base hover:shadow-lg hover:shadow-primary/30 transition-all flex items-center justify-center gap-2" type="submit">
                        Send Reset Link
                        <span class="material-symbols-outlined text-[20px]">send</span>
                    </button>
                    
                    <!-- Session Status -->
                    <x-auth-session-status class="my-4 text-center" :status="session('status')" />
                </form>
                <div class="mt-8 text-center">
                    <a class="inline-flex items-center gap-2 text-primary hover:text-primary/80 font-bold text-sm transition-colors group"
                        href="{{ route('login') }}">
                        <span class="material-symbols-outlined text-[18px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
                        Back to Login
                    </a>
                </div>
            </div>
        </div>
    </main>
</x-auth-layout>
