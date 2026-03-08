@extends('layouts.base')

@section('title', 'Services &sdots; ')

@section('content')
<main class="flex flex-1 justify-center py-5 md:px-20 lg:px-40 border-t border-slate-200 dark:border-slate-800" x-data="services()">
    <div class="layout-content-container flex flex-col max-w-[1200px] flex-1 px-4">
        <!-- Hero Section -->
        <div class="@container">
            <div class="flex flex-col gap-8 py-12 lg:flex-row items-center lg:items-stretch">
                <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl shadow-2xl lg:w-1/2" data-alt="Modern dental clinic treatment room interior" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCU1aeoouSD5ZmVfcYo6OogyMb3NG5kC_ztIyvgy7GsR5AtvbeUUaOZ6yeE2n_sU_wBpFDAwg72U465Hkg4Vq-cN9LPCN0WR3gSNsIHTrZtXyIjVAo2b35URoGJC_KRROZdYR14Wk7Ks9wweuCNs5VseWRAL4sRDQGXP7AY7pID8gFG209CIymwWEQJ19GJMZex5w38zHjN9jgPT4VY2NKRGoY9SQKSRJTyPwJ__KA4luf6_2FLo28CyupyDolW8IaU5mwbv2dbUjH2");'></div>
                <div class="flex flex-col gap-6 lg:w-1/2 lg:justify-center">
                    <div class="flex flex-col gap-4 text-left">
                        <h1 class="text-slate-900 dark:text-white text-4xl font-extrabold leading-tight tracking-[-0.033em] md:text-5xl lg:text-6xl">
                            Our Services &amp; <span class="text-primary">Pricing</span>
                        </h1>
                        <p class="text-slate-600 dark:text-slate-400 text-lg font-normal leading-relaxed max-w-xl">
                            Experience premium dental care tailored to your unique smile. From routine maintenance to advanced aesthetic transformations, we provide transparent pricing and expert care.
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <a class="flex min-w-[160px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-14 px-6 bg-primary text-white text-lg font-bold leading-normal tracking-[0.015em] hover:scale-[1.02] active:scale-[0.98] transition-all" href="#services">
                            <span class="truncate">View Pricing Below</span>
                        </a>
                        <!-- <button class="flex min-w-[160px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-14 px-6 border-2 border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-lg font-bold leading-normal tracking-[0.015em] hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                            <span class="truncate">Contact Support</span>
                        </button> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Category Navigation -->
        <div class="pb-8 sticky top-0 bg-background-light/90 dark:bg-background-dark/90 backdrop-blur-md z-40" id="services">
            <div class="flex border-b border-slate-200 dark:border-slate-800 px-2 gap-4 md:gap-8 overflow-x-auto no-scrollbar">
            <a class="flex flex-col items-center justify-center border-b-[3px] border-b-primary text-slate-900 dark:text-white pb-4 pt-4 whitespace-nowrap
                {{ !request('category')
                        ? 'border-b-primary text-slate-900 dark:text-white'
                        : 'border-b-transparent text-slate-500 dark:text-slate-400 hover:text-primary' }}"
                href="/services">
                <p class="text-sm font-bold leading-normal tracking-[0.015em]">All Services</p>
            </a>
            @foreach($categories as $category)
                <a
                    class="flex flex-col items-center justify-center border-b-[3px] pb-4 pt-4 transition-colors whitespace-nowrap
                    {{ request('category') == $category->id
                        ? 'border-b-primary text-slate-900 dark:text-white'
                        : 'border-b-transparent text-slate-500 dark:text-slate-400 hover:text-primary' }}"
                    href="{{ route('services', ['category' => $category->id]) }}"
                >
                    <p class="text-sm font-bold leading-normal tracking-[0.015em]">
                        {{ $category->name }}
                    </p>
                </a>
            @endforeach
            </div>
        </div>
        <!-- Services Table -->
        <div class="py-3 @container">
            <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                            <th class="px-6 py-4 text-slate-600 dark:text-slate-300 text-sm font-bold uppercase tracking-wider">Service Name</th>
                            <th class="px-6 py-4 text-slate-600 dark:text-slate-300 text-sm font-bold uppercase tracking-wider">Category</th>
                            <th class="px-6 py-4 text-slate-600 dark:text-slate-300 text-sm font-bold uppercase tracking-wider">Starting Price</th>
                            <th class="px-6 py-4 text-right text-slate-600 dark:text-slate-300 text-sm font-bold uppercase tracking-wider">Action</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @php
                                $categoryColors = [
                                    1 => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
                                    2 => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
                                    3 => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300',
                                    4 => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                                    5 => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
                                    6 => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300',
                                    7 => 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-300',
                                    8 => 'bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-300',
                                    9 => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300',
                                    10 => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-300',
                                    11 => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
                                    12 => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300',
                                ];
                            @endphp
                            @forelse ($services as $service)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="px-6 py-5 text-slate-900 dark:text-white font-semibold">{{ $service->name }} </td>
                                    <td class="px-6 py-5">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold uppercase tracking-tighter {{ $categoryColors[$service->category->id] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-300' }}">{{ $service->category->name }}</span>
                                    </td>
                                    <td class="px-6 py-5 text-primary font-bold">
                                        PHP {{ $service->price_min }}
                                        @if($service->price_min !== $service->price_max)
                                            - {{ $service->price_max }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <button class="text-primary hover:text-primary/80 font-bold flex items-center gap-1 justify-end ml-auto"
                                            x-on:click="bookService({{ $service->id }})">
                                            Book <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-5 text-center font-bold" colspan="4">No service yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Final CTA Section -->
        <div class="my-16 p-8 md:p-12 rounded-2xl bg-primary text-white flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden shadow-2xl shadow-primary/30">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.1),transparent)] opacity-50"></div>
            <div class="flex flex-col gap-4 relative z-10 text-center md:text-left">
                <h2 class="text-3xl font-extrabold md:text-4xl">Ready to start your journey?</h2>
                <p class="text-primary-foreground/80 text-lg opacity-90">Schedule your consultation today and experience the DentalCare Pro difference.</p>
            </div>
            <button
                class="flex min-w-[200px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-16 px-8 bg-white text-primary text-xl font-bold leading-normal tracking-[0.015em] hover:bg-slate-50 hover:scale-[1.05] transition-all relative z-10 shadow-xl"
                x-data
                x-on:click.prevent="
                    @auth
                        @haspatient
                            $dispatch('open-modal', 'appointment-modal')
                        @else
                            $dispatch('open-modal', 'create-patient-alt-modal')
                        @endhaspatient
                    @else
                        $dispatch('open-modal', 'authentication-modal')
                    @endauth
                ">
                <span class="truncate">Book Appointment</span>
            </button>
        </div>
    </div>
</main>

<!-- Appointment Modal -->
@include('shared.components.modals.create-patient-alt')
@include('shared.components.modals.appointment')
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('services', () => ({
            bookService(id) {
                this.$dispatch('open-modal', {
                    name: 'appointment-modal',
                    serviceId: id
                });
            }
        }));
    });
</script>
@endpush