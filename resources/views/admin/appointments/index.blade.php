@extends('layouts.argon')

@section('title', 'Services &sdots; ')

@section('content')
<div class="w-full px-6 py-6 mx-auto" x-data="appointments">
    <!-- table 1 -->
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            @php $currentStatus = request()->query('status', 'all'); @endphp
            <div class="inline-flex rounded-lg shadow-xs mb-5 border border-gray-200 bg-white p-1">
                <a href="{{ route('admin.appointments.index') }}" class="px-3.5 py-1.5 text-xs font-bold rounded-md transition-all {{ $currentStatus === 'all' ? 'bg-blue-500 text-white shadow-xs' : 'text-slate-600 hover:text-blue-600' }}">
                    All
                </a>
                <a href="{{ route('admin.appointments.index', ['status' => 'pending']) }}" class="px-3.5 py-1.5 text-xs font-bold rounded-md transition-all {{ $currentStatus === 'pending' ? 'bg-blue-500 text-white shadow-xs' : 'text-slate-600 hover:text-blue-600' }}">
                    Pending
                </a>
                <a href="{{ route('admin.appointments.index', ['status' => 'approved']) }}" class="px-3.5 py-1.5 text-xs font-bold rounded-md transition-all {{ $currentStatus === 'approved' ? 'bg-blue-500 text-white shadow-xs' : 'text-slate-600 hover:text-blue-600' }}">
                    Approved
                </a>
                <a href="{{ route('admin.appointments.index', ['status' => 'checked_in']) }}" class="px-3.5 py-1.5 text-xs font-bold rounded-md transition-all {{ $currentStatus === 'checked_in' ? 'bg-gradient-to-tl from-emerald-500 to-teal-400 text-white shadow-xs' : 'text-slate-600 hover:text-emerald-600' }}">
                    Checked In
                </a>
                <a href="{{ route('admin.appointments.index', ['status' => 'completed']) }}" class="px-3.5 py-1.5 text-xs font-bold rounded-md transition-all {{ $currentStatus === 'completed' ? 'bg-blue-500 text-white shadow-xs' : 'text-slate-600 hover:text-blue-600' }}">
                    Completed
                </a>
                <a href="{{ route('admin.appointments.index', ['status' => 'cancelled']) }}" class="px-3.5 py-1.5 text-xs font-bold rounded-md transition-all {{ $currentStatus === 'cancelled' ? 'bg-red-500 text-white shadow-xs' : 'text-slate-600 hover:text-red-600' }}">
                    Cancelled
                </a>
            </div>
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="dark:text-white">{{ str()->plural('Appointment', $appointments->count()) }} ({{ $appointments->count() }})</h6>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-0 overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                            @if($appointments->count())
                                <thead class="align-bottom">
                                    <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Name</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Service</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Date</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
                                    <th class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none dark:border-white/40 dark:text-white tracking-none whitespace-nowrap text-slate-400 opacity-70"></th>
                                    </tr>
                                </thead>
                            @endif
                            <tbody>
                                @forelse($appointments as $appointment)
                                    @php
                                        $statuses = ['pending', 'approved', 'checked_in', 'completed', 'cancelled'];
                                        switch ($appointment->status) {
                                            case 'pending':
                                                $statusClass = 'from-blue-700 to-cyan-500';
                                                break;
                                            case 'approved':
                                                $statusClass = 'from-slate-600 to-slate-400';
                                                break;
                                            case 'checked_in':
                                                $statusClass = 'from-emerald-500 to-teal-400';
                                                break;
                                            case 'cancelled':
                                                $statusClass = 'from-red-600 to-orange-600';
                                                break;
                                            case 'completed':
                                            default:
                                                $statusClass = 'from-emerald-500 to-teal-400';
                                                break;
                                        }
                                    @endphp
                                <tr>
                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <div class="flex px-2 py-1">
                                        <div>
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png" class="inline-flex items-center justify-center mr-4 text-sm text-white transition-all duration-200 ease-in-out h-9 w-9 rounded-xl" alt="user1" />
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <h6 class="mb-0 text-sm leading-normal dark:text-white">{{ $appointment->patient->first_name }}</h6>
                                            <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $appointment->bookedBy->email }}</p>
                                        </div>
                                        </div>
                                    </td>
                                    <td class="p-2 text-left align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        @if(!empty($appointment->services) && count($appointment->services) > 0)
                                            <div class="flex flex-col">
                                                <span class="text-xs font-semibold leading-tight dark:text-white text-slate-700">
                                                    {{ $appointment->services_names ?? collect($appointment->services)->pluck('name')->join(', ') }}
                                                </span>
                                                <span class="text-[11px] text-slate-400">
                                                    {{ count($appointment->services) }} {{ str()->plural('service', count($appointment->services)) }}
                                                </span>
                                            </div>
                                        @elseif(!empty($appointment->service))
                                            <span class="text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $appointment->service->name }}</span>
                                        @else
                                            <span class="text-xs text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">{{ $appointment->formatted_date }}</p>
                                    </td>
                                    @if($appointment->status === 'cancelled' || $appointment->status === 'completed')
                                    <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <span class="bg-gradient-to-tl px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white {{ $statusClass }}">{{ $appointment->status }}</span>
                                    </td>
                                    @else
                                    <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <div class="inline-flex items-center">
                                            @if($appointment->status === 'checked_in')
                                                <span class="w-2 h-2 mr-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            @endif
                                            <select name="status" data-id="{{ $appointment->id }}"
                                                class="status-select bg-gray-50 border border-gray-300 text-gray-900 text-xs font-semibold rounded-lg focus:ring-blue-500 focus:border-blue-500 p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                style="min-width: 110px;"
                                                {{ ($appointment->status === 'cancelled' || $appointment->status === 'completed') ? 'disabled' : '' }}>
                                                @foreach($statuses as $status)
                                                    <option value="{{ $status }}" 
                                                        {{ $status === $appointment->status ? 'selected disabled' : '' }}>
                                                        {{ $status === 'checked_in' ? 'check in' : $status }}   
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    @endif
                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent text-center">
                                        <button type="button" @click="openViewModal({{ json_encode($appointment) }})" class="inline-block px-3 py-1 font-bold text-center uppercase align-middle transition-all border border-blue-500 text-blue-500 rounded-lg cursor-pointer text-xs leading-normal hover:bg-blue-500 hover:text-white">
                                            View
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                    <p class="px-6 py-4">No appointments found.</p>
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
                        case 'checked_in':
                            const checkInResult = await Swal.fire({
                                title: 'Check In Patient?',
                                text: 'This will begin the appointment procedure and start the duration timer immediately.',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#10b981',
                                cancelButtonColor: '#6b7280',
                                confirmButtonText: 'Yes, Check In Now',
                                cancelButtonText: 'Cancel'
                            });

                            if (!checkInResult.isConfirmed) {
                                window.location.reload();
                                return;
                            }

                            try {
                                const response = await axios.post(`/api/v1/appointments/${appointmentId}/check-in`);
                                await Swal.fire({
                                    icon: 'success',
                                    title: 'Patient Checked In!',
                                    text: 'Procedure timer is now running. Click View Details to monitor duration.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                window.location.reload();
                            } catch (err) {
                                console.error(err);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Check-in Failed',
                                    text: err.response?.data?.message || 'Something went wrong.'
                                });
                                window.location.reload();
                            }
                            return;

                        case 'completed':
                            window.dispatchEvent(new CustomEvent('open-create-transaction', {
                                detail: { id: appointmentId }
                            }));
                            return;

                        case 'cancelled':
                            window.dispatchEvent(new CustomEvent('open-appointment-cancellation-admin', {
                                detail: { id: appointmentId }
                            }));
                            return;
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