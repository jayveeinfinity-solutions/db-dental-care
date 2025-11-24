@extends('layouts.base')

@section('title', 'Patient Information &sdots; ')

@section('content')
<section
    class="relative w-full flex justify-center p-6 lg:p-8 bg-center bg-cover bg-no-repeat"
    style="background-image: url('{{ config('r2.endpoint') }}/images/bg/1.jpg');"
>
    <div class="absolute inset-0 bg-gradient-to-r from-black/90 to-transparent"></div>
    <article class="relative z-5 w-full max-w-[335px] sm:max-w-md md:max-w-2xl lg:max-w-4xl flex justify-between">
        <div class="w-full text-start">
            <h1 class="mb-4 lg:mb-6 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl dark:text-white">
                Account Settings
            </h1>
        </div>
    </article>
</section>
<section class="w-full p-6 lg:p-8" x-data="user()">
    <article class="w-full max-w-[335px] sm:max-w-md md:max-w-2xl lg:max-w-4xl mx-auto">
        <div class="sm:hidden">
            <label for="tabs" class="sr-only">Status</label>
            <select id="tabs" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Patient Information</option>
                <option>Account Settings</option>
                <option>Appointments</option>
                <option>Transactions</option>
                <option>Patient History</option>
                <option>Account Settings</option>
            </select>
        </div>
        <ul class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow-sm sm:flex dark:divide-gray-700 dark:text-gray-400">
            <li class="w-full focus-within:z-10">
                <a href="{{ route('profile.edit') }}"
                    class="inline-block w-full p-4 border-r border-gray-200 dark:border-gray-700 rounded-s-lg hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:bg-gray-800 dark:hover:bg-gray-700 bg-white hover:bg-gray-50"
                >Patient Information</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="{{ route('appointments') }}" class="inline-block w-full p-4 border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700 bg-white hover:bg-gray-50"
                >Appointments</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="javascript:void(0)" class="inline-block w-full p-4 border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700 bg-white hover:bg-gray-50"
                >Transactions</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="javascript:void(0)" class="inline-block w-full p-4 border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700 bg-white hover:bg-gray-50"
                >Patient History</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="javascript:void(0)" class="inline-block w-full p-4 border-s-0 border-gray-200 dark:border-gray-700 rounded-e-lg hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:hover:text-white dark:bg-gray-800 text-gray-900 bg-gray-100 active dark:bg-gray-700 dark:text-white"
                >Account Settings</a>
            </li>
        </ul>
    </article>
    <div class="flex justify-center mt-5">
        <article class="w-full max-w-[335px] sm:max-w-md md:max-w-2xl lg:max-w-4xl flex flex-col gap-2 sm:gap-3 md:gap-4">
            <div class="flex items-start gap-5">
                <!-- Icon -->
                <div class="flex-shrink-0 place-self-center">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-300 to-blue-700 flex items-center justify-center shadow-sm">
                        <!-- user icon -->
                        <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 12c2.761 0 5-2.462 5-5.5S14.761 1 12 1 7 3.462 7 6.5 9.239 12 12 12zm0 2c-4.418 0-8 3.134-8 7v1h16v-1c0-3.866-3.582-7-8-7z" fill="currentColor"/>
                        </svg>
                    </div>
                </div>

                <!-- Content -->
                <div class="flex-1">
                    <h2 class="text-2xl sm:text-3xl font-semibold text-slate-900 leading-tight">
                        Account details
                    </h2>
                    <p class="text-sm sm:text-base text-slate-600">
                        Below are the account information binded to this account.
                    </p>
                </div>
            </div>

            <form class="space-y-4" @submit.prevent="updatePatientInfo">

                <div class="flex items-start gap-10">
                    <div class="flex-shrink-0 place-self-center">
                        <div class="w-32 h-32 border border-[5px] border-gray-300 rounded-full shadow-sm overflow-hidden">
                            <img class="w-full" src="{{ auth()->user()->googleInfo->avatar }}" alt="avatar">
                        </div>
                    </div>

                    <div class="flex-1">
                        <!-- Email -->
                        <div>
                            <div>
                                <label class="block text-sm font-medium mb-1" for="email">Email</label>
                                <input type="email" name="email" id="email" class="w-full px-3 py-2 border rounded" value="{{ auth()->user()->email }}" placeholder="Email..." readonly>
                            </div>
                        </div>

                        <!-- Name -->
                        <div>
                            <div>
                                <label class="block text-sm font-medium mb-1" for="name">Name</label>
                                <input type="name" name="name" id="name" class="w-full px-3 py-2 border rounded" value="{{ auth()->user()->name }}" placeholder="Name...">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded hover:bg-blue-700 transition">
                        Update user information
                    </button>
                </div>
            </form>

            <hr class="my-4 border-gray-300">

            <div class="flex items-start gap-5">
                <!-- Icon -->
                <div class="flex-shrink-0 place-self-center">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-300 to-blue-700 flex items-center justify-center shadow-sm">
                        <!-- user icon -->
                        <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 12c2.761 0 5-2.462 5-5.5S14.761 1 12 1 7 3.462 7 6.5 9.239 12 12 12zm0 2c-4.418 0-8 3.134-8 7v1h16v-1c0-3.866-3.582-7-8-7z" fill="currentColor"/>
                        </svg>
                    </div>
                </div>

                <!-- Content -->
                <div class="flex-1">
                    <h2 class="text-2xl sm:text-3xl font-semibold text-slate-900 leading-tight">
                        @if($user->isPasswordDefault)
                            Create password
                        @else
                            Change password
                        @endif
                    </h2>
                    <p class="text-sm sm:text-base text-slate-600">
                        Below are the account information binded to this account.
                    </p>
                </div>
            </div>

            <form class="space-y-4" @submit.prevent="updatePassword">

                <div class="flex items-start gap-10">
                    <div class="flex-1">

                        <!-- Current Password -->
                        @if(!$user->isPasswordDefault)
                            <div x-data="{ showCurrent: false }" class="relative">
                                <label for="current_password" class="block text-sm font-medium mb-1">
                                    Current Password
                                </label>

                                <input
                                    :type="showCurrent ? 'text' : 'password'"
                                    name="current_password"
                                    id="current_password"
                                    class="w-full px-3 py-2 border rounded pr-10 focus:ring-2 focus:ring-blue-500"
                                    placeholder="Enter current password"
                                    required
                                >

                                <!-- Toggle -->
                                <button type="button"
                                    x-on:click="showCurrent = !showCurrent"
                                    class="absolute inset-y-0 right-2 flex items-center text-slate-500 hover:text-slate-700 transform translate-y-[10px]">

                                    <!-- Eye -->
                                    <svg x-show="!showCurrent" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7S3.732 16.057 2.458 12z" />
                                    </svg>

                                    <!-- Eye Off -->
                                    <svg x-show="showCurrent" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3l18 18M9.88 9.88a3 3 0 104.243 4.243M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-0.397 1.27-1.026 2.467-1.855 3.532M15 12a3 3 0 01-3 3" />
                                    </svg>
                                </button>
                            </div>
                        @endif

                        <!-- New Password -->
                        <div x-data="{ showNew: false }" class="relative mt-4">
                            <label for="password" class="block text-sm font-medium mb-1">
                                New Password
                            </label>

                            <input
                                :type="showNew ? 'text' : 'password'"
                                name="password"
                                id="password"
                                class="w-full px-3 py-2 border rounded pr-10 focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter new password"
                                required
                            >

                            <button type="button"
                                x-on:click="showNew = !showNew"
                                class="absolute inset-y-0 right-2 flex items-center text-slate-500 hover:text-slate-700 transform translate-y-[10px]">

                                <svg x-show="!showNew" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7S3.732 16.057 2.458 12z" />
                                </svg>

                                <svg x-show="showNew" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3l18 18M9.88 9.88a3 3 0 104.243 4.243M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-0.397 1.27-1.026 2.467-1.855 3.532M15 12a3 3 0 01-3 3" />
                                </svg>
                            </button>
                        </div>


                        <!-- Confirm Password -->
                        <div x-data="{ showConfirm: false }" class="relative mt-4">
                            <label for="password_confirmation" class="block text-sm font-medium mb-1">
                                Confirm New Password
                            </label>

                            <input
                                :type="showConfirm ? 'text' : 'password'"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="w-full px-3 py-2 border rounded pr-10 focus:ring-2 focus:ring-blue-500"
                                placeholder="Confirm new password"
                                required
                            >

                            <button type="button"
                                x-on:click="showConfirm = !showConfirm"
                                class="absolute inset-y-0 right-2 flex items-center text-slate-500 hover:text-slate-700 transform translate-y-[10px]">

                                <svg x-show="!showConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7S3.732 16.057 2.458 12z" />
                                </svg>

                                <svg x-show="showConfirm" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3l18 18M9.88 9.88a3 3 0 104.243 4.243M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-0.397 1.27-1.026 2.467-1.855 3.532M15 12a3 3 0 01-3 3" />
                                </svg>

                            </button>
                        </div>

                    </div>
                </div>

                <!-- Submit -->
                <div class="pt-4">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white font-medium rounded hover:bg-blue-700 transition">
                        @if($user->isPasswordDefault)
                            Create password
                        @else
                            Update password
                        @endif
                    </button>
                </div>

            </form>

        </article>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('user', () => ({
            user: [],
            form: {
                name: '',

                current_password: '',
                new_password: '',
                confirm_password: ''
            },
            init() {
                this.fetchUser();
            },
            fetchUser() {
                let url = '/api/v1/user';

                axios.get(url)
                    .then(response => {
                        this.user = response.data;
                    });
            },
            updatePatientInfo() {
                let url = `/api/v1/patients/${this.patient.id}`;

                axios.put(url, this.patientForm)
                    .then(response => {
                        Swal.fire({
                            title: "Success!",
                            text: "Patient information updated successfully.",
                            icon: "success",
                            allowOutsideClick: false,
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        }).then(() => {
                            this.fetchPatient();
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            title: "Error!",
                            text: "There was an error updating patient information.",
                            icon: "error",
                            allowOutsideClick: false,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    });
            }
        }));
    });
</script>
@endpush