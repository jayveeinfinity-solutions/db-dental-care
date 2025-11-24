@extends('layouts.argon')

@section('title', 'Patients &sdots; ')

@section('content')
<div class="w-full px-6 py-6 mx-auto" x-data="patients">
    <!-- table 1 -->
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent flex justify-between items-center">
                    <h6 class="dark:text-white">{{ str()->plural('Patient', $patients->count()) }} ({{ $patients->count() }})</h6>
                    <button type="button" class="inline-block px-6 py-3 mr-3 font-bold text-center text-white uppercase align-middle transition-all bg-blue-500 rounded-lg cursor-pointer leading-normal text-xs ease-in tracking-tight-rem shadow-xs bg-150 bg-x-25 hover:-translate-y-px active:opacity-85 hover:shadow-md" x-on:click="openCreateModal">Add new patient</button>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-0 overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                            @if($patients->count())
                                <thead class="align-bottom">
                                    <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Name / Code</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Birthdate / Age</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Contact Number</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Address</th>
                                    <th class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none dark:border-white/40 dark:text-white tracking-none whitespace-nowrap text-slate-400 opacity-70"></th>
                                    </tr>
                                </thead>
                            @endif
                            <tbody>
                                @forelse($patients as $patient)
                                <tr>
                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <div class="flex px-2 py-1">
                                            <div class="inline-flex items-center justify-center mr-4 text-sm text-white transition-all duration-200 ease-in-out h-9 w-9 rounded-xl bg-{{ $patient->sex }}">
                                                @if($patient->sex === 'male')
                                                    <i class="fa-solid fa-mars"></i>
                                                @else
                                                    <i class="fa-solid fa-venus"></i>
                                                @endif
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <h6 class="mb-0 text-sm leading-normal dark:text-white">{{ $patient->name }}</h6>
                                                <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $patient->code }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 text-sm leading-normal align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $patient->birthdate }} ({{ $patient->age }})</p>
                                    </td>
                                    <td class="p-2 text-sm leading-normal align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <span class="bg-gradient-to-tl px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white from-blue-700 to-cyan-500">{{ $patient->contact_number }}</span>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">{{ $patient->address }}</p>
                                        <!-- <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">Organization</p> -->
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <a href="javascript:;" class="text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400"> Edit </a>
                                    </td>
                                </tr>
                                @empty
                                    <p class="px-6">No patients yet.</p>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('shared.components.modals.create-patient')
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