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
                <span class="inline-block px-3 py-1 rounded-full bg-primary/20 text-primary text-xs font-bold uppercase tracking-wider mb-4 border border-primary/30 backdrop-blur-md">Primary Care</span>
                <h1 class="text-white text-4xl md:text-6xl font-black leading-tight tracking-tight">Preventive Dentistry</h1>
                <p class="text-slate-300 text-lg md:text-xl mt-4 max-w-2xl">The foundation of a lifetime of healthy smiles starts with proactive care and regular maintenance.</p>
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
                    <span class="material-symbols-outlined">verified</span>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium uppercase tracking-wide">Prevention Success</p>
                    <p class="text-slate-900 dark:text-slate-100 text-3xl font-bold">99%</p>
                    <p class="text-slate-600 dark:text-slate-400 text-sm">Of cavities are preventable with proper routine maintenance.</p>
                </div>
                <div class="flex flex-col gap-3 rounded-xl p-8 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="size-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-2">
                        <span class="material-symbols-outlined">calendar_today</span>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium uppercase tracking-wide">Annual Checkups</p>
                    <p class="text-slate-900 dark:text-slate-100 text-3xl font-bold">5,000+</p>
                    <p class="text-slate-600 dark:text-slate-400 text-sm">Conducted annually to ensure long-term oral health.</p>
                </div>
                <div class="flex flex-col gap-3 rounded-xl p-8 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="size-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-2">
                        <span class="material-symbols-outlined">sentiment_very_satisfied</span>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium uppercase tracking-wide">Patient Rating</p>
                    <p class="text-slate-900 dark:text-slate-100 text-3xl font-bold">4.9/5.0</p>
                    <p class="text-slate-600 dark:text-slate-400 text-sm">Based on over 2,000 patient satisfaction surveys.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content: Services & Education -->
    <div class="px-6 md:px-20 py-12 bg-white dark:bg-slate-900/50">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row gap-16">
            <!-- Left Column: Detailed Services -->
            <div class="flex-1">
                <h2 class="text-slate-900 dark:text-slate-100 text-3xl font-bold mb-8">Our Preventive Services</h2>
                <div class="space-y-10">
                    <div class="flex gap-6">
                        <div class="flex-shrink-0 size-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">clinical_notes</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-2">Comprehensive Exams</h3>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Regular examinations allow us to detect potential issues before they become painful or expensive. We check for tooth decay, gum disease, and oral cancer during every visit.</p>
                        </div>
                    </div>
                    <div class="flex gap-6">
                        <div class="flex-shrink-0 size-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">cleaning_services</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-2">Professional Cleanings</h3>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Our hygienists remove plaque and tartar that regular brushing can't reach, preventing the buildup that leads to periodontal disease.</p>
                        </div>
                    </div>
                    <div class="flex gap-6">
                        <div class="flex-shrink-0 size-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">radiology</span>
                        </div>
                        <div>
                        <h3 class="text-xl font-bold mb-2">Digital X-Rays</h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Low-radiation digital imaging helps us see between teeth and beneath the gum line to identify hidden issues with precision.</p>
                        </div>
                    </div>
                    <div class="flex gap-6">
                        <div class="flex-shrink-0 size-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">shield</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-2">Fluoride &amp; Sealants</h3>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Protective treatments that strengthen enamel and seal deep grooves in teeth where bacteria often hide.</p>
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