@extends('layouts.base')

@section('title', 'Services &sdots; ')

@section('content')
<section class="w-full p-6 lg:p-8">
    <h1 class="p-3 text-4xl font-extrabold text-center uppercase text-blue-600">Services</h1>
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
                <p>No service yet.</p>
            @endforelse
        </article>
    </div>
</section>
@endsection