@extends('layouts.base')

@section('title', 'Services &sdots; ')

@section('content')
<section
    class="relative w-full flex justify-center p-6 lg:p-8 bg-center bg-cover bg-no-repeat"
    style="background-image: url('{{ config('r2.endpoint') }}/images/bg/1.jpg');"
>
    <div class="absolute inset-0 bg-gradient-to-r from-black/90 to-transparent"></div>
    <article class="relative z-5 w-full lg:max-w-4xl max-w-[335px] flex justify-between">
        <div class="w-[60%]">
            <h1 class="mb-4 lg:mb-6 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl dark:text-white">
                Services
            </h1>
        </div>
    </article>
</section>
<section class="w-full p-6 lg:p-8">
    <div class="flex justify-center">
        <div class="w-full max-w-[335px] sm:max-w-md md:max-w-2xl lg:max-w-4xl">
            <form class="max-w-[170px]">
                <label for="categories" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category filter</label>
                <select id="categories" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="" selected>All</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    <div class="mt-5 flex justify-center">
        <article class="w-full max-w-[335px] sm:max-w-md md:max-w-2xl lg:max-w-4xl grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 sm:gap-3 md:gap-4">
            @forelse ($services as $service)
                <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ $service->name }} 
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-blue-900 dark:text-blue-300">{{ $service->category->name }}</span>
                    </h5>
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

@push('scripts')
<script>
    const categoryFilter = document.getElementById('categories');

    document.addEventListener('change', (e) => {
        const value = categoryFilter.options[categoryFilter.selectedIndex].value;
        window.location.href = `/services?category=${value}`;
    });
</script>
@endpush