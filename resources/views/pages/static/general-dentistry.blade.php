@extends('layouts.base')

@section('title', 'Preventive Denstitry &sdots; ')

@section('content')
<main class="flex-1 border-t border-slate-200 dark:border-slate-800">
    <!-- Hero Section -->
    <div class="px-6 md:px-20 py-8">
        <div class="max-w-6xl mx-auto">
            <div class="relative overflow-hidden rounded-xl bg-slate-900 aspect-[21/9] flex items-end">
            <div class="absolute inset-0 bg-cover bg-center" data-alt="Modern bright dental clinic examination room" style="background-image: linear-gradient(0deg, rgba(17, 21, 33, 0.8) 0%, rgba(17, 21, 33, 0.2) 60%), url('https://lh3.googleusercontent.com/aida-public/AB6AXuAXLiaQ0J_qSwHrw6yLZFJRGqpJ2EUjhTOEPwpZEJK17oEY9Hj7vrjD595M1Q8PaT2VKWqjgOhVaGI9gwyUd2rtj-etZuC1r_7f57WRld26BStNXbF3VW5RUN57LUdOUIYiz8q_XrPUd1ecaOQRq-Pjy-V4qEh3kqX3LKdRuQioCXsAPaQlL8FPdJ2Wv3Kc7EMrW1vI75EUlDh7jo5UHMWJadgEBGxy0Idtfw3QJ6caSm5ZKIW2ki0JZeOznBhZjI82MHnkT8qsuqjM');"></div>
            <div class="relative p-8 md:p-12 z-10">
                <span class="inline-block px-3 py-1 rounded-full bg-primary/20 text-primary text-xs font-bold uppercase tracking-wider mb-4 border border-primary/30 backdrop-blur-md">Core Services</span>
                <h1 class="text-white text-4xl md:text-6xl font-black leading-tight tracking-tight">General Dentistry</h1>
                <p class="text-slate-300 text-lg md:text-xl mt-4 max-w-2xl">Comprehensive dental care designed for a lifetime of healthy, beautiful smiles. From routine cleanings to essential restorations, we prioritize your long-term oral health using the latest clinical technology.</p>
            </div>
            </div>
        </div>
    </div>
    <!-- Stats & Overview -->
    <div class="px-6 md:px-20 py-10">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex flex-col gap-3 rounded-xl p-8 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="size-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-2">
                    <span class="material-symbols-outlined">sentiment_satisfied</span>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium uppercase tracking-wide">Happy patients</p>
                    <p class="text-slate-900 dark:text-slate-100 text-3xl font-bold">15k+</p>
                </div>
                <div class="flex flex-col gap-3 rounded-xl p-8 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="size-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-2">
                        <span class="material-symbols-outlined">acute</span>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium uppercase tracking-wide">Online Booking</p>
                    <p class="text-slate-900 dark:text-slate-100 text-3xl font-bold">24/7</p>
                </div>
                <div class="flex flex-col gap-3 rounded-xl p-8 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="size-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-2">
                        <span class="material-symbols-outlined">sentiment_very_satisfied</span>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium uppercase tracking-wide">Patient Rating</p>
                    <p class="text-slate-900 dark:text-slate-100 text-3xl font-bold">4.9/5.0</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content: Services & Education -->
    <div class="px-6 md:px-20 py-12 bg-white dark:bg-slate-900/50">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row gap-16">
            <!-- Left Column: Detailed Services -->
            <div class="flex-1">
                <h2 class="text-slate-900 dark:text-slate-100 text-3xl font-bold mb-8">Why Choose Our General Dentistry?</h2>
                <div class="space-y-10">
                    <div class="flex gap-6">
                        <div class="flex-shrink-0 size-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">check_circle</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-2">Patient-Centered Comfort</h3>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Our clinic is designed to reduce anxiety with warm environments and painless anesthesia techniques.</p>
                        </div>
                    </div>
                    <div class="flex gap-6">
                        <div class="flex-shrink-0 size-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">check_circle</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-2">State-of-the-Art Tech</h3>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">We utilize AI-assisted diagnosis and laser dentistry to provide faster, more accurate results.</p>
                        </div>
                    </div>
                    <div class="flex gap-6">
                        <div class="flex-shrink-0 size-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">check_circle</span>
                        </div>
                        <div>
                        <h3 class="text-xl font-bold mb-2">Preventative Philosophy</h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">We believe in proactive care to save you time, money, and discomfort in the long run.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right Column: Education & Sidebar -->
            @include('shared.partials.static.appointment-card')
        </div>
    </div>
    <!-- Call to Action Section -->
    @include('shared.partials.static.appointment-hero')
</main>

<!-- Appointment Modal -->
@include('shared.components.modals.create-patient-alt')
@include('shared.components.modals.appointment')
@endsection