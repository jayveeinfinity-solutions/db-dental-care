@extends('layouts.argon')

@section('title', 'Patients &sdots; ')

@section('content')
<div class="w-full px-6 py-6 mx-auto" x-data="patients">
    <!-- Filter bar -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-5">
        <div class="flex items-center gap-2">
            <span class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400">Filter Patients:</span>
            @php
                $currentFilter = request('filter', 'all');
            @endphp
            <div class="inline-flex rounded-md shadow-xs">
                <a href="{{ route('admin.patients.index', ['filter' => 'all']) }}" 
                    class="px-3 py-1.5 text-xs font-medium border border-gray-200 rounded-s-lg transition-colors {{ $currentFilter === 'all' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    All Patients
                </a>
                <a href="{{ route('admin.patients.index', ['filter' => 'today']) }}" 
                    class="px-3 py-1.5 text-xs font-medium border-t border-b border-r border-gray-200 transition-colors {{ $currentFilter === 'today' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    Today
                </a>
                <a href="{{ route('admin.patients.index', ['filter' => 'this_week']) }}" 
                    class="px-3 py-1.5 text-xs font-medium border-t border-b border-r border-gray-200 transition-colors {{ $currentFilter === 'this_week' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    This Week
                </a>
                <a href="{{ route('admin.patients.index', ['filter' => 'this_month']) }}" 
                    class="px-3 py-1.5 text-xs font-medium border-t border-b border-r border-gray-200 rounded-e-lg transition-colors {{ $currentFilter === 'this_month' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    This Month
                </a>
            </div>
        </div>

        <div>
            <button type="button" class="inline-block px-5 py-2.5 font-bold text-center text-white uppercase align-middle transition-all bg-blue-600 hover:bg-blue-700 rounded-lg cursor-pointer leading-normal text-xs ease-in tracking-tight shadow-md hover:-translate-y-px active:opacity-85" x-on:click="openCreateModal">
                <i class="fa-solid fa-user-plus mr-1"></i> Add new patient
            </button>
        </div>
    </div>

    <!-- table 1 -->
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent flex justify-between items-center">
                    <h6 class="dark:text-white font-bold">{{ str()->plural('Patient', $patients->count()) }} ({{ $patients->count() }})</h6>
                    <span class="text-xs text-slate-400">Filter: <strong class="text-slate-700 dark:text-slate-200">{{ ucfirst(str_replace('_', ' ', $currentFilter)) }}</strong></span>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-0 overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                            @if($patients->count())
                                <thead class="align-bottom">
                                    <tr>
                                        <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">PX ID & Code</th>
                                        <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Patient Name</th>
                                        <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Birthdate / Age</th>
                                        <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Contact Number</th>
                                        <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Address</th>
                                        <th class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none dark:border-white/40 dark:text-white tracking-none whitespace-nowrap text-slate-400 opacity-70 text-center">Actions</th>
                                    </tr>
                                </thead>
                            @endif
                            <tbody>
                                @forelse($patients as $patient)
                                <tr>
                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <div class="px-4 py-1">
                                            <span class="px-2 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-mono font-bold rounded text-xs border border-blue-200 dark:border-blue-800">
                                                {{ $patient->code }}
                                            </span>
                                            <span class="text-[11px] text-slate-400 ml-1">#{{ $patient->id }}</span>
                                        </div>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <div class="flex px-2 py-1 items-center">
                                            <div class="inline-flex items-center justify-center mr-3 text-xs text-white transition-all duration-200 ease-in-out h-8 w-8 rounded-full bg-{{ $patient->sex }}">
                                                @if($patient->sex === 'male')
                                                    <i class="fa-solid fa-mars"></i>
                                                @else
                                                    <i class="fa-solid fa-venus"></i>
                                                @endif
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <h6 class="mb-0 text-sm font-semibold leading-normal dark:text-white">{{ $patient->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 text-sm leading-normal align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-600">{{ $patient->birthdate }} ({{ $patient->age }} y/o)</p>
                                    </td>
                                    <td class="p-2 text-sm leading-normal align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <span class="bg-gradient-to-tl px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white from-blue-700 to-cyan-500">{{ $patient->contact_number }}</span>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80 truncate max-w-xs" title="{{ $patient->address }}">{{ $patient->address }}</p>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent text-center">
                                        <button type="button" @click="openProceduresModal({{ json_encode($patient) }})" class="mr-3 px-2.5 py-1 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-md transition-colors dark:bg-blue-900/40 dark:text-blue-300">
                                            <i class="fa-solid fa-tooth mr-1"></i> Procedures
                                        </button>
                                        <a href="javascript:;" @click="openEditModal({{ json_encode($patient) }})" class="text-xs font-semibold leading-tight text-slate-500 hover:text-slate-800 dark:text-white dark:opacity-80">
                                            <i class="fa-solid fa-pen-to-square mr-0.5"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-sm text-slate-400">
                                            <i class="fa-solid fa-users text-2xl mb-2 block text-slate-300"></i>
                                            No patients found matching the selected filter criteria.
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
    @include('shared.components.modals.create-patient')
    @include('shared.components.modals.edit-patient')
    @include('shared.components.modals.patient-procedures-modal')
    @include('shared.argon.partials.footer')
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('patients', () => ({
        init() {},

        openCreateModal() {
            window.dispatchEvent(new CustomEvent('open-create-patient'));
        },

        openEditModal(patient) {
            window.dispatchEvent(new CustomEvent('open-edit-patient', { detail: patient }));
        },

        openProceduresModal(patient) {
            window.dispatchEvent(new CustomEvent('open-patient-procedures', { detail: patient }));
        }
    }));
});
</script>
@endpush

<style>
    .bg-male {
        background-color: #1171ef;
    }
    .bg-female {
        background-color: #be185d;
    }
</style>