@extends('layouts.base')

@section('title', 'My Medical & Treatment History &sdots; ')

@section('content')
<section
    class="relative w-full flex justify-center p-6 lg:p-8 bg-center bg-cover bg-no-repeat"
    style="background-image: url('{{ config('r2.endpoint') }}/images/bg/1.jpg');"
>
    <div class="absolute inset-0 bg-gradient-to-r from-black/90 to-transparent"></div>
    <article class="relative z-5 w-full max-w-[335px] sm:max-w-md md:max-w-2xl lg:max-w-4xl flex justify-between">
        <div class="w-[70%]">
            <h1 class="mb-2 lg:mb-4 text-3xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl dark:text-white">
                Medical & Procedure History
            </h1>
            <p class="text-sm text-gray-300">
                Detailed records of your consultations, dental treatments, and medical certificates.
            </p>
        </div>
    </article>
</section>

<section class="w-full p-6 lg:p-8" x-data="patientHistory()">
    <article class="w-full max-w-[335px] sm:max-w-md md:max-w-2xl lg:max-w-4xl mx-auto space-y-6">

        <!-- Patient Header Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Patient Record (PX)</span>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mt-0.5">
                    {{ $user->patient?->full_name ?? $user->name }}
                </h3>
                <div class="flex items-center gap-3 mt-1 text-xs text-gray-500 dark:text-gray-400">
                    <span class="px-2 py-0.5 bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300 font-mono font-bold rounded">
                        {{ $user->patient?->code ?? 'PX-Pending' }}
                    </span>
                    <span>&bull;</span>
                    <span>Contact: {{ $user->patient?->contact_number ?? 'N/A' }}</span>
                </div>
            </div>
            <div>
                <a href="{{ route('services') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition-colors shadow-sm inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-calendar-plus"></i>
                    Book Next Treatment
                </a>
            </div>
        </div>

        <!-- Procedures Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                <h4 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-file-medical text-blue-600"></i>
                    Completed Procedures & Treatments
                </h4>
            </div>

            @php
                $patient = $user->patient;
                $procedures = $patient ? $patient->procedures()->orderBy('procedure_date', 'desc')->get() : collect();
                $histories = $patient ? $patient->histories()->with('transaction')->latest()->get() : collect();
            @endphp

            @if($procedures->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600 dark:text-gray-300">
                        <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-700 dark:text-gray-200 uppercase font-semibold text-xs border-b border-gray-200 dark:border-gray-700">
                            <tr>
                                <th class="px-6 py-3.5">Date</th>
                                <th class="px-6 py-3.5">Procedure</th>
                                <th class="px-6 py-3.5">Target / Tooth</th>
                                <th class="px-6 py-3.5 text-right">Cost</th>
                                <th class="px-6 py-3.5">Clinical Notes</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($procedures as $proc)
                                <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $proc->formatted_date }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-blue-600 dark:text-blue-400">{{ $proc->procedure_name }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-200">
                                            {{ $proc->target_specifics }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-mono font-bold text-gray-900 dark:text-white whitespace-nowrap">
                                        PHP {{ number_format($proc->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-500 dark:text-gray-400 max-w-xs">
                                        {{ $proc->medical_history ?: 'None recorded' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center text-gray-500 dark:text-gray-400">
                    <i class="fa-solid fa-tooth text-4xl text-gray-300 dark:text-gray-600 mb-3 block"></i>
                    <p class="font-medium text-base text-gray-700 dark:text-gray-200">No procedure records found yet.</p>
                    <p class="text-xs mt-1">Once you complete treatments at DB Dental Care, your procedure history will be archived here.</p>
                </div>
            @endif
        </div>

        <!-- Dental Certificates (PDF Documents) Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <h4 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-file-pdf text-red-500"></i>
                    Issued Dental Certificates (PDF)
                </h4>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Official medical certificates issued by DB Dental Care for work, school, or personal requirements.
                </p>
            </div>

            @if($histories->count() > 0)
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($histories as $history)
                        <div class="p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 flex items-center justify-center text-lg">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </div>
                                <div>
                                    <h5 class="font-bold text-gray-900 dark:text-white text-sm">Dental Certificate</h5>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Issued on: {{ $history->created_at->format('F j, Y \a\t g:i A') }}
                                        @if($history->description) &bull; {{ $history->description }} @endif
                                    </p>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('patient.history.view', $history->id) }}" 
                                    target="_blank" 
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-bold transition-colors shadow-xs">
                                    <i class="fa-solid fa-download"></i>
                                    View / Download PDF
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                    <p class="text-sm">No dental certificates on record.</p>
                </div>
            @endif
        </div>

    </article>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('patientHistory', () => ({
        init() {}
    }));
});
</script>
@endpush
