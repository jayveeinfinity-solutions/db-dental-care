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
                About
            </h1>
        </div>
    </article>
</section>
<section class="w-full p-6 lg:p-8">
    <div class="mt-5 flex justify-center">
        <article class="w-full max-w-[335px] sm:max-w-md md:max-w-2xl lg:max-w-4xl">
            DB Dental Care Dental Clinic provides quality and affordable dental services for patients of all ages. With a team of skilled dentists and modern equipment, the clinic offers comprehensive oral care—from routine check-ups and cleanings to advanced restorative and cosmetic treatments—ensuring every patient leaves with a healthy and confident smile.</p>
        </article>
    </div>
</section>
@endsection