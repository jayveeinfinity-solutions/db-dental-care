@extends('layouts.argon')

@section('title', 'Dashboard &sdots; ')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <!-- Stat Cards Row -->
    <div class="flex flex-wrap -mx-3">
        <!-- card1: Today's Appointments -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-xs font-bold leading-normal uppercase dark:text-white dark:opacity-60 text-slate-500">Today's Appointments</p>
                                <h5 class="mb-0 font-bold dark:text-white text-2xl mt-1">{{ $todaysAppointments }}</h5>
                                <p class="mb-0 text-xs text-slate-400 mt-1">Scheduled for {{ now()->format('M j') }}</p>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-blue-500 to-violet-500 shadow-md">
                                <i class="fa-solid fa-calendar-day leading-none text-lg relative !top-[14px] text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card2: Pending Appointments -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-xs font-bold leading-normal uppercase dark:text-white dark:opacity-60 text-slate-500">Pending Review</p>
                                <h5 class="mb-0 font-bold dark:text-white text-2xl mt-1">{{ $pendingAppointments }}</h5>
                                <p class="mb-0 text-xs text-slate-400 mt-1">Awaiting approval</p>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-red-600 to-orange-600 shadow-md">
                                <i class="fa-solid fa-clock leading-none text-lg relative !top-[14px] text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card3: Upcoming Approved Appointments -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-xs font-bold leading-normal uppercase dark:text-white dark:opacity-60 text-slate-500">Upcoming Approved</p>
                                <h5 class="mb-0 font-bold dark:text-white text-2xl mt-1">{{ $upcomingAppointments }}</h5>
                                <p class="mb-0 text-xs text-slate-400 mt-1">Future confirmed</p>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-orange-500 to-yellow-500 shadow-md">
                                <i class="fa-solid fa-calendar-check leading-none text-lg relative !top-[14px] text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card4: Total Patients -->
        <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-xs font-bold leading-normal uppercase dark:text-white dark:opacity-60 text-slate-500">Total Patients (PX)</p>
                                <h5 class="mb-0 font-bold dark:text-white text-2xl mt-1">{{ $patientCount }}</h5>
                                <p class="mb-0 text-xs text-slate-400 mt-1">Registered in clinic</p>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-emerald-500 to-teal-400 shadow-md">
                                <i class="fa-solid fa-hospital-user leading-none text-lg relative !top-[14px] text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION: Capacity Planning & Schedule Density Widget -->
    <div class="flex flex-wrap mt-6 -mx-3">
        <div class="w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-gray-100 dark:border-slate-700">
                    <div>
                        <div class="flex items-center gap-2">
                            <h5 class="font-bold dark:text-white text-lg">Clinic Capacity & Schedule Density</h5>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider
                                @if($capacityPlanning['density_color'] === 'red') bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300
                                @elseif($capacityPlanning['density_color'] === 'orange') bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-300
                                @elseif($capacityPlanning['density_color'] === 'blue') bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300
                                @else bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300
                                @endif">
                                {{ $capacityPlanning['density_level'] }} Density ({{ $capacityPlanning['density_percentage'] }}%)
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Real-time capacity analysis for today, {{ now()->format('l, F j, Y') }} (Operating Hours: 8:00 AM - 5:00 PM)
                        </p>
                    </div>

                    <!-- Walk-in Capacity Callout -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-slate-800 dark:to-slate-700 border border-blue-200 dark:border-slate-600 rounded-xl px-4 py-3 flex items-center gap-3 shadow-xs">
                        <div class="w-10 h-10 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold text-lg">
                            {{ $capacityPlanning['estimated_walk_in_capacity'] }}
                        </div>
                        <div>
                            <div class="text-xs font-bold uppercase tracking-wider text-blue-900 dark:text-blue-300">
                                Walk-in Patients Accommodated
                            </div>
                            <div class="text-[11px] text-slate-500 dark:text-slate-300">
                                ~{{ $capacityPlanning['available_hours'] }} hrs free &bull; Can take approx. <strong class="text-blue-700 dark:text-blue-300">{{ $capacityPlanning['estimated_walk_in_capacity'] }} walk-ins</strong> today
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Density Progress Bar -->
                <div class="mt-4">
                    <div class="flex justify-between text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1">
                        <span>Booked Time: <strong class="text-slate-800 dark:text-white">{{ $capacityPlanning['booked_hours'] }} hrs</strong> ({{ $capacityPlanning['booked_minutes'] }} mins)</span>
                        <span>Available Open Time: <strong class="text-emerald-600 dark:text-emerald-400">{{ $capacityPlanning['available_hours'] }} hrs</strong> ({{ $capacityPlanning['available_minutes'] }} mins)</span>
                    </div>
                    <div class="w-full bg-gray-100 dark:bg-slate-700 rounded-full h-3 overflow-hidden">
                        <div class="h-3 rounded-full transition-all duration-500
                            @if($capacityPlanning['density_color'] === 'red') bg-red-500
                            @elseif($capacityPlanning['density_color'] === 'orange') bg-orange-500
                            @elseif($capacityPlanning['density_color'] === 'blue') bg-blue-500
                            @else bg-emerald-500
                            @endif" 
                            style="width: {{ $capacityPlanning['density_percentage'] }}%">
                        </div>
                    </div>
                </div>

                <!-- Timeline Ribbon: Visual Hours 8:00 AM - 5:00 PM -->
                <div class="mt-6">
                    <h6 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Hourly Schedule Ribbon (8 AM &ndash; 5 PM)</h6>
                    <div class="grid grid-cols-3 sm:grid-cols-5 md:grid-cols-9 gap-2">
                        @foreach($capacityPlanning['hourly_slots'] as $slot)
                            <div class="p-2 rounded-lg border text-center transition-all flex flex-col justify-between min-h-[64px]
                                @if($slot['is_occupied'])
                                    bg-blue-50 border-blue-200 text-blue-900 dark:bg-blue-950/40 dark:border-blue-800 dark:text-blue-300
                                @elseif($slot['is_past'])
                                    bg-gray-50 border-gray-200 text-gray-400 dark:bg-slate-800 dark:border-slate-700
                                @else
                                    bg-emerald-50/70 border-emerald-200 text-emerald-800 dark:bg-emerald-950/30 dark:border-emerald-800 dark:text-emerald-300
                                @endif">
                                <span class="text-[11px] font-bold block">{{ $slot['time'] }}</span>
                                <div>
                                    @if($slot['is_occupied'])
                                        <span class="inline-block px-1.5 py-0.5 rounded text-[10px] font-semibold bg-blue-200/80 text-blue-900 dark:bg-blue-900 dark:text-blue-100">
                                            Booked
                                        </span>
                                    @elseif($slot['is_past'])
                                        <span class="inline-block px-1.5 py-0.5 rounded text-[10px] text-gray-400">
                                            Passed
                                        </span>
                                    @else
                                        <span class="inline-block px-1.5 py-0.5 rounded text-[10px] font-semibold bg-emerald-200/80 text-emerald-900 dark:bg-emerald-900 dark:text-emerald-100">
                                            Walk-in Open
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION: Today's Appointments Chronological Sequence -->
    <div class="flex flex-wrap mt-6 -mx-3">
        <div class="w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-2 border-b-0 flex justify-between items-center">
                    <div>
                        <h5 class="font-bold dark:text-white text-lg flex items-center gap-2">
                            <i class="fa-solid fa-list-ol text-blue-600"></i>
                            Today's Appointment Sequence
                        </h5>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Chronological timeline of scheduled consultations and treatments for today ({{ $todaysScheduleSequence->count() }} total)
                        </p>
                    </div>
                    <a href="{{ route('admin.appointments.index', ['date' => 'today']) }}" class="text-xs font-bold text-blue-600 hover:underline">
                        Manage All &rarr;
                    </a>
                </div>

                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-0 overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                            @if($todaysScheduleSequence->count() > 0)
                                <thead class="align-bottom">
                                    <tr class="border-b border-gray-100 dark:border-slate-700">
                                        <th class="px-6 py-3 font-bold text-left uppercase text-xxs tracking-none text-slate-400 opacity-70">Seq &bull; Time</th>
                                        <th class="px-6 py-3 font-bold text-left uppercase text-xxs tracking-none text-slate-400 opacity-70">Patient (PX)</th>
                                        <th class="px-6 py-3 pl-2 font-bold text-left uppercase text-xxs tracking-none text-slate-400 opacity-70">Service(s)</th>
                                        <th class="px-6 py-3 pl-2 font-bold text-left uppercase text-xxs tracking-none text-slate-400 opacity-70">Duration</th>
                                        <th class="px-6 py-3 font-bold text-center uppercase text-xxs tracking-none text-slate-400 opacity-70">Status</th>
                                        <th class="px-6 py-3 font-bold text-center uppercase text-xxs tracking-none text-slate-400 opacity-70">Contact</th>
                                    </tr>
                                </thead>
                            @endif
                            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                                @forelse($todaysScheduleSequence as $index => $app)
                                    @php
                                        switch ($app->status) {
                                            case 'pending':
                                                $badgeClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300';
                                                break;
                                            case 'approved':
                                                $badgeClass = 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300';
                                                break;
                                            case 'cancelled':
                                                $badgeClass = 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300';
                                                break;
                                            case 'completed':
                                            default:
                                                $badgeClass = 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300';
                                                break;
                                        }
                                        $startTime = \Carbon\Carbon::parse($app->scheduled_at)->format('g:i A');
                                        $endTime = \Carbon\Carbon::parse($app->scheduled_at)->addMinutes($app->duration_minutes ?: 30)->format('g:i A');
                                        $serviceNames = $app->services_summary ?? ($app->service?->name ?? 'Dental Service');
                                    @endphp
                                    <tr class="hover:bg-gray-50/60 dark:hover:bg-slate-800/50 transition-colors">
                                        <td class="p-3 px-6 align-middle whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs font-bold flex items-center justify-center">
                                                    {{ $index + 1 }}
                                                </span>
                                                <div>
                                                    <span class="font-bold text-sm text-slate-800 dark:text-white">{{ $startTime }}</span>
                                                    <span class="text-xs text-slate-400"> &ndash; {{ $endTime }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-3 px-6 align-middle whitespace-nowrap">
                                            <div class="font-semibold text-sm text-slate-800 dark:text-white">
                                                {{ $app->patient->full_name ?? $app->patient->name }}
                                            </div>
                                            <span class="text-xs font-mono font-bold text-blue-600 dark:text-blue-400">
                                                {{ $app->patient->code }}
                                            </span>
                                        </td>
                                        <td class="p-3 pl-2 align-middle">
                                            <span class="text-xs font-medium text-slate-700 dark:text-slate-200">
                                                {{ $serviceNames }}
                                            </span>
                                        </td>
                                        <td class="p-3 pl-2 align-middle whitespace-nowrap">
                                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-slate-600 dark:text-slate-300">
                                                <i class="fa-regular fa-clock text-slate-400"></i>
                                                {{ $app->duration_minutes ?: 30 }}m
                                            </span>
                                        </td>
                                        <td class="p-3 text-center align-middle whitespace-nowrap">
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-md uppercase tracking-wider {{ $badgeClass }}">
                                                {{ $app->status }}
                                            </span>
                                        </td>
                                        <td class="p-3 text-center align-middle whitespace-nowrap">
                                            <span class="text-xs text-slate-500 dark:text-slate-400 font-mono">
                                                {{ $app->patient->contact_number ?? 'N/A' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-12 text-center text-slate-400">
                                            <div class="max-w-sm mx-auto">
                                                <i class="fa-regular fa-calendar-check text-4xl text-emerald-400 mb-3 block"></i>
                                                <h6 class="font-bold text-slate-700 dark:text-slate-200">No scheduled appointments for today</h6>
                                                <p class="text-xs text-slate-400 mt-1">
                                                    The clinic's schedule is completely open. You can comfortably accommodate walk-in patients throughout the day.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('shared.argon.partials.footer')
</div>
@endsection