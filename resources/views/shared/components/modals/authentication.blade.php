<x-modal name="authentication-modal" :show="false" :maxWidth="'md'">
    <div class="relative p-4 w-full max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Sign in to our platform
                </h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" x-on:click="$dispatch('close-modal', 'authentication-modal')">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form class="space-y-4" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="example@gmail.com" required />
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Password') }}</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                    </div>
                    <div class="flex justify-between">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />
                            </div>
                            <label for="remember_me" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Remember me') }}</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-blue-700 hover:underline dark:text-blue-500">{{ __('Forgot your password?') }}</a>
                        @endif
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('Log in') }}</button>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
                        {{ __('Not registered') }}? <a href="{{ route('register') }}" class="text-blue-700 hover:underline dark:text-blue-500">{{ __('Create account') }}</a>
                    </div>
                </form>

                <p class="relative my-3 before:absolute before:top-1/2 before:left-0 before:right-0 before:border text-center">
                    <span class="relative px-3 z-10 bg-white text-gray-400 text-xs">OR</span>
                </p>

                <div class="mt-4">
                    <a href="{{ route('google.redirect') }}"
                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 48 48">
                        <path fill="#EA4335" d="M24 9.5c3.9 0 7.4 1.5 10 4l7-7C36.7 2.6 30.7 0 24 0 14.6 0 6.3 5.4 2.5 13.3l8.2 6.4C12.3 13.2 17.6 9.5 24 9.5z"/>
                        <path fill="#34A853" d="M46.1 24.6c0-1.6-.1-3.1-.4-4.6H24v9h12.4c-.5 2.5-2 4.6-4.2 6l6.5 5.1c3.8-3.5 6-8.6 6-14.5z"/>
                        <path fill="#4A90E2" d="M24 48c6.5 0 12-2.1 16-5.7l-6.5-5.1c-1.8 1.2-4.2 2-6.9 2-5.3 0-9.8-3.6-11.4-8.5l-8.2 6.4C7.4 43 15 48 24 48z"/>
                        <path fill="#FBBC05" d="M2.5 13.3C.9 16.7 0 20.3 0 24s.9 7.3 2.5 10.7l8.2-6.4C9.9 25.6 9.9 22.4 10.7 20l-8.2-6.7z"/>
                    </svg>
                    Sign in with Google
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-modal>