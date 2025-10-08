@extends('layouts.base')

@section('title', 'Welcome &sdots; ')

@section('content')
<section
    class="relative w-full flex justify-center p-6 lg:p-8 bg-center bg-cover bg-no-repeat"
    style="background-image: url('/storage/images/bg/1.jpg');"
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
            @forelse ($services as $service)
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
@include('shared.components.modals.appointment')
@endsection