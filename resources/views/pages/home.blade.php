@extends('layouts.base')

@section('title', 'Welcome &sdots; ')

@section('content')
@if($userPendingAppointments->count() > 0)
<section class="w-full flex justify-center">
    <article class="w-full lg:max-w-4xl max-w-[335px]">
        <div id="alert-1" class="flex items-center p-4 m-6 lg:m-8 text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
            <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
                <span class="font-medium">You have pending appointment!</span> Click <a class="underline" href="{{ route('appointments') }}">view appointment</a> to view.
            </div>
                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-1" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    </article>
</section>
@endif
@auth
    @if(!auth()->user()->patient)
    <section class="w-full flex justify-center">
        <article class="w-full lg:max-w-4xl max-w-[335px]">
            <div id="alert-1" class="flex items-center p-4 m-6 lg:m-8 text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium">
                    <span class="font-medium">This account has no patient record!</span> Click
                    <a class="underline" href="javascript:void(0)" 
                        x-data
                        x-on:click.prevent="$dispatch('open-modal', 'create-patient-alt-modal')">
                        create patient record
                    </a> to create one.
                </div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-1" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        </article>
    </section>
    @endif
@endauth
<section
    class="relative w-full flex justify-center p-6 lg:p-8 bg-center bg-cover bg-no-repeat"
    style="background-image: url('{{ config('r2.endpoint') }}/images/bg/1.jpg');"
>
    <div class="absolute inset-0 bg-gradient-to-r from-black/90 to-transparent"></div>
    <article class="relative z-5 w-full lg:max-w-4xl max-w-[335px] flex justify-between">
        <div class="w-[60%]">
            <h1 class="mb-4 lg:mb-6 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl dark:text-white">
                Elevating Smiles with Expert Care and a Gentle Touch
            </h1>
            <button
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" type="button" role="button"
                x-data
                x-on:click.prevent="
                    @auth
                        $dispatch('open-modal', 'appointment-modal')
                    @else
                        $dispatch('open-modal', 'authentication-modal')
                    @endauth
                ">
                Book appointment
            </button>
        </div>
    </article>
</section>

<section class="w-full p-6 lg:p-8">
    <h1 class="p-3 text-4xl font-extrabold text-center uppercase text-blue-600">Featured Services</h1>
    <div class="mt-5 flex justify-center">
        <article class="w-full max-w-[335px] sm:max-w-md md:max-w-2xl lg:max-w-4xl grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 sm:gap-3 md:gap-4">
            @forelse ($featuredServices as $service)
                <div class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $service->name }}</h5>
                    <p class="font-normal text-gray-700 dark:text-gray-400">
                        PHP {{ $service->price_min }}
                        @if($service->price_min !== $service->price_max)
                            - {{ $service->price_max }}
                        @endif
                    </p>
                </div>
            @empty
                <p>No featured service.</p>
            @endforelse
        </article>
    </div>
</section>

<!-- Appointment Modal -->
@include('shared.components.modals.create-patient-alt')
@include('shared.components.modals.appointment')
@endsection