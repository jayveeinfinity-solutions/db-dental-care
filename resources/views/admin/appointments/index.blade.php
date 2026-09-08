@extends('layouts.argon')

@section('title', 'Appointments &sdots; ')

@section('content')
<div class="w-full px-6 py-6 mx-auto" x-data="appointments">
    <!-- Filters row -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-5">
        <!-- Date Filters -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
            <span class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400">Date:</span>
            <div class="inline-flex rounded-md shadow-xs">
                @php
                    $currentDateFilter = request('date', 'all');
                    $currentStatus = request('status', 'all');
                @endphp
                <a href="{{ route('admin.appointments.index', ['status' => $currentStatus, 'date' => 'all']) }}" 
                    class="px-3 py-1.5 text-xs font-medium border border-gray-200 rounded-s-lg transition-colors {{ $currentDateFilter === 'all' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    All Dates
                </a>
                <a href="{{ route('admin.appointments.index', ['status' => $currentStatus, 'date' => 'today']) }}" 
                    class="px-3 py-1.5 text-xs font-medium border-t border-b border-r border-gray-200 transition-colors {{ $currentDateFilter === 'today' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    Today
                </a>
                <a href="{{ route('admin.appointments.index', ['status' => $currentStatus, 'date' => 'this_week']) }}" 
                    class="px-3 py-1.5 text-xs font-medium border-t border-b border-r border-gray-200 transition-colors {{ $currentDateFilter === 'this_week' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    This Week
                </a>
                <a href="{{ route('admin.appointments.index', ['status' => $currentStatus, 'date' => 'this_month']) }}" 
                    class="px-3 py-1.5 text-xs font-medium border-t border-b border-r border-gray-200 rounded-e-lg transition-colors {{ $currentDateFilter === 'this_month' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    This Month
                </a>
            </div>
        </div>

        <!-- Status Filters -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
            <span class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400">Status:</span>
            <div class="inline-flex rounded-md shadow-xs">
                <a href="{{ route('admin.appointments.index', ['status' => 'all', 'date' => $currentDateFilter]) }}" 
                    class="px-3 py-1.5 text-xs font-medium border border-gray-200 rounded-s-lg transition-colors {{ $currentStatus === 'all' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    All
                </a>
                <a href="{{ route('admin.appointments.index', ['status' => 'pending', 'date' => $currentDateFilter]) }}" 
                    class="px-3 py-1.5 text-xs font-medium border-t border-b border-r border-gray-200 transition-colors {{ $currentStatus === 'pending' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    Pending
                </a>
                <a href="{{ route('admin.appointments.index', ['status' => 'approved', 'date' => $currentDateFilter]) }}" 
                    class="px-3 py-1.5 text-xs font-medium border-t border-b border-r border-gray-200 transition-colors {{ $currentStatus === 'approved' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    Approved
                </a>
                <a href="{{ route('admin.appointments.index', ['status' => 'completed', 'date' => $currentDateFilter]) }}" 
                    class="px-3 py-1.5 text-xs font-medium border-t border-b border-r border-gray-200 transition-colors {{ $currentStatus === 'completed' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    Completed
                </a>
                <a href="{{ route('admin.appointments.index', ['status' => 'cancelled', 'date' => $currentDateFilter]) }}" 
                    class="px-3 py-1.5 text-xs font-medium border-t border-b border-r border-gray-200 rounded-e-lg transition-colors {{ $currentStatus === 'cancelled' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    Cancelled
                </a>
            </div>
        </div>
    </div>

    <!-- Table container -->
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent flex justify-between items-center">
                    <h6 class="dark:text-white font-bold">{{ str()->plural('Appointment', $appointments->count()) }} ({{ $appointments->count() }})</h6>
                    <span class="text-xs font-medium text-slate-400">
                        Showing results for: <strong class="text-slate-700 dark:text-slate-200">{{ ucfirst(str_replace('_', ' ', $currentDateFilter)) }}</strong> | <strong class="text-slate-700 dark:text-slate-200">{{ ucfirst($currentStatus) }}</strong>
                    </span>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-0 overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                            @if($appointments->count())
                                <thead class="align-bottom">
                                    <tr>
                                        <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Patient (PX)</th>
                                        <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Services</th>
                                        <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Date & Duration</th>
                                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
                                        <th class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none dark:border-white/40 dark:text-white tracking-none whitespace-nowrap text-slate-400 opacity-70"></th>
                                    </tr>
                                </thead>
                            @endif
                            <tbody>
                                @forelse($appointments as $appointment)
                                    @php
                                        $statuses = ['pending', 'approved', 'completed', 'cancelled'];
                                        switch ($appointment->status) {
                                            case 'pending':
                                                $statusClass = 'from-blue-700 to-cyan-500';
                                                break;
                                            case 'approved':
                                                $statusClass = 'from-slate-600 to-slate-300';
                                                break;
                                            case 'cancelled':
                                                $statusClass = 'from-red-600 to-orange-600';
                                                break;
                                            case 'completed':
                                            default:
                                                $statusClass = 'from-emerald-500 to-teal-400';
                                                break;
                                        }

                                        // Form service display
                                        $servicesDisplay = $appointment->services_summary ?? ($appointment->service->name ?? 'Dental Service');
                                    @endphp
                                <tr>
                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <div class="flex px-4 py-1">
                                            <div class="flex flex-col justify-center">
                                                <h6 class="mb-0 text-sm font-semibold leading-normal dark:text-white">{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</h6>
                                                <div class="flex items-center gap-2 mt-0.5">
                                                    <span class="px-1.5 py-0.5 bg-blue-100 text-blue-800 text-[10px] font-bold rounded">
                                                        {{ $appointment->patient->code }}
                                                    </span>
                                                    <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $appointment->bookedBy->email ?? '' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 text-left align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <span class="text-xs font-semibold leading-tight text-gray-800 dark:text-white">
                                            {{ $servicesDisplay }}
                                        </span>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">{{ $appointment->formatted_date }}</p>
                                        <p class="mb-0 text-[11px] text-slate-400">
                                            Duration: <span class="font-bold text-blue-600">{{ $appointment->duration_minutes ?? 30 }} mins</span>
                                        </p>
                                    </td>
                                    @if($appointment->status === 'cancelled' || $appointment->status === 'completed')
                                    <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <span class="bg-gradient-to-tl px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white {{ $statusClass }}">{{ $appointment->status }}</span>
                                    </td>
                                    @else
                                    <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <select name="status" data-id="{{ $appointment->id }}"
                                            class="status-select bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            style="width: 100px;">
                                            @foreach($statuses as $statusOption)
                                                <option value="{{ $statusOption }}" 
                                                    {{ $statusOption === $appointment->status ? 'selected disabled' : '' }}>
                                                    {{ ucfirst($statusOption) }}   
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    @endif
                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent text-center">
                                        <a href="javascript:;" @click="openViewModal({{ json_encode($appointment) }})" class="text-xs font-semibold leading-tight text-blue-600 hover:underline"> View </a>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-sm text-slate-400">
                                            <i class="fa-regular fa-calendar-xmark text-2xl mb-2 block"></i>
                                            No appointments found matching the selected filter criteria.
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
    @include('shared.components.modals.create-transaction')
    @include('shared.components.modals.appointment-cancellation-admin')
    @include('shared.components.modals.view-appointment')
    @include('shared.argon.partials.footer')
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('appointments', () => ({
        
        init() {
            const selects = document.querySelectorAll('.status-select');

            selects.forEach(select => {
                select.addEventListener('change', async (e) => {
                    const appointmentId = e.target.dataset.id;
                    const newStatus = e.target.value;

                    switch(newStatus) {
                        case 'completed':
                            window.dispatchEvent(new CustomEvent('open-create-transaction', {
                                detail: { id: appointmentId }
                            }));
                            return;
                            break;
                        case 'cancelled':
                            window.dispatchEvent(new CustomEvent('open-appointment-cancellation-admin', {
                                detail: { id: appointmentId }
                            }));
                            return;
                            break;
                    }

                    try {
                        const response = await axios.put(`/api/v1/appointments/${appointmentId}/status`, {
                            status: newStatus
                        });

                        Swal.fire({
                            icon: 'success',
                            title: 'Status Updated',
                            text: response.data.message || 'Appointment status has been updated.',
                            allowOutsideClick: false,
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });

                    } catch (error) {
                        console.error(error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed',
                            text: error.response?.data?.message || 'Something went wrong.',
                        });
                    }
                });
            });
        },

        openViewModal(appointment) {
            window.dispatchEvent(new CustomEvent('open-view-appointment', { detail: appointment }));
        },
    }))
});
</script>
@endpush