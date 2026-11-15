@extends('layouts.argon')

@section('title', 'Dashboard &sdots; ')

@section('content')
<div class="w-full px-6 py-6 mx-auto" x-data="adminDashboard()">
    <!-- row 1: Statistics Cards -->
    <div class="flex flex-wrap -mx-3">
        <!-- card1 -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Today's Appointment</p>
                                <h5 class="mb-2 font-bold dark:text-white">{{ $todaysAppointments }}</h5>
                                <p class="mb-0 text-xs text-slate-400">
                                    {{ $timetableData['available_count'] }} walk-in slots available
                                </p>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-blue-500 to-violet-500">
                                <i class="ni leading-none ni-calendar-grid-58 text-lg relative !top-[10px] text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card2 -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Pending Appointments</p>
                                <h5 class="mb-2 font-bold dark:text-white">{{ $pendingAppointments }}</h5>
                                <p class="mb-0 text-xs text-slate-400">Awaiting approval</p>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-red-600 to-orange-600">
                                <i class="fa-solid fa-clock leading-none text-lg relative !top-[10px] text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card3 -->
        <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Upcoming appointments</p>
                                <h5 class="mb-2 font-bold dark:text-white">{{ $upcomingAppointments }}</h5>
                                <p class="mb-0 text-xs text-slate-400">Scheduled for future dates</p>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-orange-500 to-yellow-500">
                                <i class="fa-solid fa-calendar-check leading-none text-lg relative !top-[10px] text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card4 -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">{{ Str::plural('patient', $patientCount) }}</p>
                                <h5 class="mb-2 font-bold dark:text-white">{{ $patientCount }}</h5>
                                <p class="mb-0 text-xs text-slate-400">Registered in clinic</p>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-emerald-500 to-teal-400">
                                <i class="fa-solid fa-users leading-none text-lg relative !top-[10px] text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- row 2: Today's Schedule & Walk-in Timetable (Divisible per 30 minutes) -->
    <div class="flex flex-wrap mt-6 -mx-3">
        <div class="w-full max-w-full px-3 flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <!-- Header -->
                <div class="p-6 pb-4 border-b border-gray-200 dark:border-slate-700 flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <div class="flex items-center">
                            <div class="p-2.5 mr-3 bg-blue-100 dark:bg-blue-900/30 text-blue-600 rounded-xl">
                                <i class="fa-solid fa-calendar-day text-xl"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 text-slate-800 dark:text-white font-bold text-lg">Today's Timetable &amp; Walk-in Schedule</h5>
                                <p class="text-xs text-slate-400 mb-0 font-normal">
                                    {{ now()->format('l, F j, Y') }} &bull; Ordered schedule divisible by 30-minute intervals (8:00 AM - 5:00 PM)
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center">
                        <!-- Filter Tabs -->
                        <div class="inline-flex rounded-lg border border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-800 p-1 mr-3 shadow-xs">
                            <button 
                                type="button" 
                                @click="filter = 'all'" 
                                :class="filter === 'all' ? 'bg-white text-blue-600 shadow-xs font-bold' : 'text-slate-600 hover:text-blue-600 font-semibold'"
                                class="px-3 py-1.5 rounded-md text-xs transition-all cursor-pointer"
                            >
                                All Slots ({{ $timetableData['total_slots'] }})
                            </button>
                            <button 
                                type="button" 
                                @click="filter = 'booked'" 
                                :class="filter === 'booked' ? 'bg-white text-blue-600 shadow-xs font-bold' : 'text-slate-600 hover:text-blue-600 font-semibold'"
                                class="px-3 py-1.5 rounded-md text-xs transition-all cursor-pointer ml-1"
                            >
                                Booked ({{ $timetableData['booked_count'] }})
                            </button>
                            <button 
                                type="button" 
                                @click="filter = 'available'" 
                                :class="filter === 'available' ? 'bg-white text-emerald-600 shadow-xs font-bold' : 'text-slate-600 hover:text-emerald-600 font-semibold'"
                                class="px-3 py-1.5 rounded-md text-xs transition-all cursor-pointer ml-1"
                            >
                                Available Walk-ins ({{ $timetableData['available_count'] }})
                            </button>
                        </div>

                        <!-- Direct Walk-in Action -->
                        <button 
                            type="button" 
                            @click="openWalkInModal()" 
                            class="inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all bg-gradient-to-tl from-emerald-500 to-teal-400 rounded-lg cursor-pointer text-xs leading-normal tracking-tight-rem shadow-xs hover:-translate-y-px active:opacity-85 hover:shadow-md"
                        >
                            <i class="fa-solid fa-user-plus mr-1 text-xs"></i>
                            <span>Start Walk-in</span>
                        </button>
                    </div>
                </div>

                <!-- Sub-bar Summary Badges -->
                <div class="px-6 py-3.5 bg-slate-50 dark:bg-slate-800/40 border-b border-gray-200 dark:border-slate-700 flex flex-wrap items-center">
                    <div class="inline-flex items-center px-3.5 py-1.5 mr-3 rounded-full text-xs font-bold text-white bg-gradient-to-tl from-emerald-500 to-teal-400 shadow-xs">
                        <span class="w-2 h-2 mr-2 rounded-full bg-white animate-pulse"></span>
                        <span>{{ $timetableData['available_count'] }} Slots Open for Walk-ins</span>
                    </div>
                    <div class="inline-flex items-center px-3.5 py-1.5 mr-3 rounded-full text-xs font-bold text-white bg-gradient-to-tl from-blue-700 to-cyan-500 shadow-xs">
                        <span class="w-2 h-2 mr-2 rounded-full bg-white"></span>
                        <span>{{ $timetableData['booked_count'] }} Scheduled Appointments</span>
                    </div>
                    <div class="inline-flex items-center text-xs font-semibold text-slate-500 dark:text-slate-400 my-1">
                        <i class="fa-regular fa-clock mr-1.5 text-slate-400"></i>
                        <span>Time slots: 30 minutes each (8:00 AM &ndash; 5:00 PM)</span>
                    </div>
                </div>

                <!-- Timetable Table -->
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-0 overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3.5 font-bold text-left uppercase align-middle bg-gray-50/50 dark:bg-slate-800/20 border-b border-gray-200 dark:border-white/40 dark:text-white text-xxs tracking-wider whitespace-nowrap text-slate-500 w-52">Time Slot</th>
                                    <th class="px-6 py-3.5 font-bold text-left uppercase align-middle bg-gray-50/50 dark:bg-slate-800/20 border-b border-gray-200 dark:border-white/40 dark:text-white text-xxs tracking-wider whitespace-nowrap text-slate-500 w-44">Status</th>
                                    <th class="px-6 py-3.5 font-bold text-left uppercase align-middle bg-gray-50/50 dark:bg-slate-800/20 border-b border-gray-200 dark:border-white/40 dark:text-white text-xxs tracking-wider whitespace-nowrap text-slate-500">Patient Details</th>
                                    <th class="px-6 py-3.5 font-bold text-left uppercase align-middle bg-gray-50/50 dark:bg-slate-800/20 border-b border-gray-200 dark:border-white/40 dark:text-white text-xxs tracking-wider whitespace-nowrap text-slate-500">Service(s)</th>
                                    <th class="px-6 py-3.5 font-bold text-right uppercase align-middle bg-gray-50/50 dark:bg-slate-800/20 border-b border-gray-200 dark:border-white/40 dark:text-white text-xxs tracking-wider whitespace-nowrap text-slate-500 pr-6 w-48">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($timetableData['slots'] as $slot)
                                    @php
                                        $isAvailable = $slot['is_available'];
                                        $appointment = $slot['appointment'];
                                        $transaction = $appointment?->transaction;
                                        $hasActiveTimer = $transaction && $transaction->status === 'in_progress';
                                        
                                        $rowStatusClass = '';
                                        if ($isAvailable) {
                                            $rowStatusClass = 'hover:bg-emerald-50/30';
                                        } else {
                                            $rowStatusClass = 'hover:bg-blue-50/30';
                                        }
                                    @endphp
                                    <tr 
                                        class="transition-colors border-b border-gray-100 dark:border-white/10 {{ $rowStatusClass }}"
                                        x-show="filter === 'all' || (filter === 'booked' && !{{ $isAvailable ? 'true' : 'false' }}) || (filter === 'available' && {{ $isAvailable ? 'true' : 'false' }})"
                                    >
                                        <!-- Time Slot (30 mins) -->
                                        <td class="p-3.5 pl-6 align-middle bg-transparent whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span class="inline-flex items-center justify-center w-7 h-7 mr-2.5 rounded-lg {{ $isAvailable ? 'bg-emerald-50 text-emerald-600' : 'bg-blue-50 text-blue-600' }}">
                                                    <i class="fa-regular fa-clock text-xs"></i>
                                                </span>
                                                <div class="flex flex-col">
                                                    <span class="font-bold text-sm text-slate-800 dark:text-white tracking-tight">
                                                        {{ $slot['time_formatted'] }}
                                                    </span>
                                                    <span class="text-xs font-semibold text-slate-400">
                                                        to {{ $slot['end_time_formatted'] }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Availability / Status Badge -->
                                        <td class="p-3.5 align-middle bg-transparent whitespace-nowrap">
                                            @if($isAvailable)
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold text-emerald-800 bg-emerald-100 border border-emerald-200">
                                                    <span class="w-2 h-2 mr-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                    Open for Walk-in
                                                </span>
                                            @else
                                                @php
                                                    $status = $appointment->status;
                                                    $badgeGradient = match($status) {
                                                        'pending' => 'from-blue-700 to-cyan-500',
                                                        'approved' => 'from-slate-600 to-slate-400',
                                                        'checked_in' => 'from-emerald-500 to-teal-400',
                                                        'completed' => 'from-emerald-500 to-teal-400',
                                                        default => 'from-gray-500 to-gray-400'
                                                    };
                                                @endphp
                                                <span class="bg-gradient-to-tl px-3 text-xs rounded-1.8 py-1.5 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white {{ $badgeGradient }}">
                                                    {{ $status === 'checked_in' ? 'in progress' : $status }}
                                                </span>
                                                @if($hasActiveTimer || $status === 'checked_in')
                                                    <span 
                                                        class="inline-flex items-center ml-2 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200 shadow-xs"
                                                        data-dashboard-timer="{{ $transaction?->id ?? $appointment->id }}"
                                                        data-start="{{ $transaction?->checked_in_at ?? $appointment->updated_at }}"
                                                    >
                                                        <i class="fa-solid fa-stopwatch mr-1 text-xs text-amber-700"></i>
                                                        <span x-text="activeTimers[{{ $transaction?->id ?? $appointment->id }}] || '00:00'"></span>
                                                    </span>
                                                @endif
                                            @endif
                                        </td>

                                        <!-- Patient Details -->
                                        <td class="p-3.5 align-middle bg-transparent whitespace-nowrap">
                                            @if(!$isAvailable && $appointment)
                                                <div class="flex items-center">
                                                    <div class="flex flex-col">
                                                        <h6 class="mb-0 text-sm font-bold dark:text-white text-slate-800">
                                                            {{ $appointment->patient->full_name ?? ($appointment->patient->first_name . ' ' . $appointment->patient->last_name) }}
                                                        </h6>
                                                        <p class="mb-0 text-xs text-slate-400 font-medium">
                                                            Code: {{ $appointment->patient->code ?? 'N/A' }} 
                                                            @if($appointment->bookedBy)
                                                                &bull; {{ $appointment->bookedBy->email }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-xs text-slate-400 font-medium italic">
                                                    <i class="fa-solid fa-user-check mr-1 text-slate-300"></i> Available for walk-in patient
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Services -->
                                        <td class="p-3.5 align-middle bg-transparent whitespace-nowrap">
                                            @if(!$isAvailable && $appointment)
                                                @if(!empty($appointment->services) && count($appointment->services) > 0)
                                                    <div class="flex flex-col">
                                                        <span class="text-xs font-bold dark:text-white text-slate-700">
                                                            {{ $appointment->services_names ?? collect($appointment->services)->pluck('name')->join(', ') }}
                                                        </span>
                                                        <span class="text-[11px] text-slate-400 font-medium">
                                                            {{ count($appointment->services) }} {{ str()->plural('service', count($appointment->services)) }}
                                                        </span>
                                                    </div>
                                                @elseif(!empty($appointment->service))
                                                    <span class="text-xs font-bold dark:text-white text-slate-700">
                                                        {{ $appointment->service->name }}
                                                    </span>
                                                @else
                                                    <span class="text-xs text-slate-400 font-medium">-</span>
                                                @endif
                                            @else
                                                <span class="text-xs text-slate-300 font-medium">-</span>
                                            @endif
                                        </td>

                                        <!-- Action -->
                                        <td class="p-3.5 align-middle bg-transparent whitespace-nowrap text-right pr-6">
                                            @if($isAvailable)
                                                <button 
                                                    type="button" 
                                                    class="inline-block px-3.5 py-2 font-bold text-center text-white uppercase align-middle transition-all bg-gradient-to-tl from-emerald-500 to-teal-400 rounded-lg cursor-pointer text-xs leading-normal tracking-tight-rem shadow-xs hover:-translate-y-px active:opacity-85 hover:shadow-md"
                                                    @click="openWalkInModal()"
                                                >
                                                    <i class="fa-solid fa-plus mr-1 text-xs"></i>
                                                    Accommodate Walk-in
                                                </button>
                                            @else
                                                <div class="inline-flex items-center">
                                                    @if($appointment->status === 'approved' && !$hasActiveTimer)
                                                        <button 
                                                            type="button" 
                                                            class="inline-block px-3.5 py-2 mr-2 font-bold text-center text-white uppercase align-middle transition-all bg-blue-500 hover:bg-blue-600 rounded-lg cursor-pointer text-xs leading-normal tracking-tight-rem shadow-xs hover:-translate-y-px active:opacity-85 hover:shadow-md"
                                                            @click="checkInPatient({{ $appointment->id }})"
                                                        >
                                                            <i class="fa-solid fa-stopwatch mr-1 text-xs"></i>
                                                            Check In
                                                        </button>
                                                    @endif

                                                    @if($hasActiveTimer || $appointment->status === 'checked_in')
                                                        <button 
                                                            type="button" 
                                                            class="inline-block px-3.5 py-2 mr-2 font-bold text-center text-white uppercase align-middle transition-all bg-gradient-to-tl from-emerald-500 to-teal-400 rounded-lg cursor-pointer text-xs leading-normal tracking-tight-rem shadow-xs hover:-translate-y-px active:opacity-85 hover:shadow-md"
                                                            @click="checkoutAppointmentTransaction({{ $transaction ? $transaction->id : $appointment->id }})"
                                                        >
                                                            <i class="fa-solid fa-check mr-1 text-xs"></i>
                                                            Check Out
                                                        </button>
                                                    @endif

                                                    <button 
                                                        type="button" 
                                                        class="inline-block px-3 py-1.5 font-bold text-center uppercase align-middle transition-all border border-blue-500 text-blue-500 rounded-lg cursor-pointer text-xs leading-normal hover:bg-blue-500 hover:text-white"
                                                        @click="openViewAppointmentModal({{ json_encode($appointment) }})"
                                                    >
                                                        View
                                                    </button>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    @include('shared.components.modals.create-transaction')
    @include('shared.components.modals.view-appointment')
    @include('shared.components.modals.view-transaction')
    @include('shared.components.modals.appointment-cancellation-admin')
    @include('shared.argon.partials.footer')
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('adminDashboard', () => ({
        filter: 'all',
        activeTimers: {},
        interval: null,

        init() {
            this.initTimers();
        },

        initTimers() {
            const elements = document.querySelectorAll('[data-dashboard-timer]');
            const items = [];

            elements.forEach(el => {
                const id = el.dataset.dashboardTimer;
                const startTimeStr = el.dataset.start;
                if (id && startTimeStr) {
                    items.push({ id, startTime: new Date(startTimeStr).getTime() });
                }
            });

            if (items.length === 0) return;

            const update = () => {
                const now = Date.now();
                items.forEach(item => {
                    const elapsed = Math.max(0, Math.floor((now - item.startTime) / 1000));
                    const hours = Math.floor(elapsed / 3600);
                    const minutes = Math.floor((elapsed % 3600) / 60);
                    const seconds = elapsed % 60;

                    let display = '';
                    if (hours > 0) {
                        display = `${hours}h ${minutes}m ${seconds}s`;
                    } else if (minutes > 0) {
                        display = `${minutes}m ${seconds}s`;
                    } else {
                        display = `${seconds}s`;
                    }
                    this.activeTimers[item.id] = display;
                });
            };

            update();
            this.interval = setInterval(update, 1000);
        },

        openWalkInModal() {
            window.dispatchEvent(new CustomEvent('open-create-transaction'));
        },

        openViewAppointmentModal(appointment) {
            window.dispatchEvent(new CustomEvent('open-view-appointment', { detail: appointment }));
        },

        async checkInPatient(appointmentId) {
            const result = await Swal.fire({
                title: 'Check In Patient?',
                text: 'This will begin the procedure and start the duration timer immediately.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Check In Now',
                cancelButtonText: 'Cancel'
            });

            if (!result.isConfirmed) return;

            try {
                const response = await axios.post(`/api/v1/appointments/${appointmentId}/check-in`);
                Swal.fire({
                    icon: 'success',
                    title: 'Patient Checked In!',
                    text: 'Procedure timer is now running. Click Check Out when completed.',
                    allowOutsideClick: false,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload();
                });
            } catch (err) {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Check-in Failed',
                    text: err.response?.data?.message || 'Something went wrong.'
                });
            }
        },

        async checkoutAppointmentTransaction(transactionId) {
            const result = await Swal.fire({
                title: 'Check Out Patient?',
                text: 'Stop procedure timer and finalize transaction?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Check Out',
                cancelButtonText: 'Cancel'
            });

            if (!result.isConfirmed) return;

            try {
                const response = await axios.post(`/api/v1/transactions/${transactionId}/checkout`);
                const data = response.data;

                await Swal.fire({
                    icon: 'success',
                    title: 'Transaction Completed!',
                    html: `
                        <div class="text-left p-3 bg-emerald-50 rounded-lg text-emerald-900 border border-emerald-200">
                            <p class="mb-1 text-sm font-semibold">Patient checked out successfully!</p>
                            <p class="text-sm font-bold">Total Duration: <span class="text-emerald-600 font-mono">${data.duration_formatted || '0m'}</span></p>
                        </div>
                    `,
                    confirmButtonText: 'OK'
                });

                window.location.reload();
            } catch (err) {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Check-out Failed',
                    text: err.response?.data?.message || 'Something went wrong.'
                });
            }
        }
    }));
});
</script>
@endpush