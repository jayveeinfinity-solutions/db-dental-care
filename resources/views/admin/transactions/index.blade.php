@extends('layouts.argon')

@section('title', 'Transactions &sdots; ')

@section('content')
<div class="w-full px-6 py-6 mx-auto" x-data="transactions">
    <!-- table 1 -->
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h6 class="dark:text-white font-bold">{{ str()->plural('Transaction', $transactions->count()) }} ({{ $transactions->count() }})</h6>
                        <p class="text-xs text-slate-400 mb-0">Track patient procedures, check-in duration, and billing</p>
                    </div>
                    <button type="button" class="inline-flex items-center gap-2 px-5 py-2.5 font-bold text-center text-white uppercase align-middle transition-all bg-blue-600 hover:bg-blue-700 rounded-lg cursor-pointer leading-normal text-xs shadow-md hover:shadow-lg" x-on:click="openCreateModal">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Start Walk-in / Transaction</span>
                    </button>
                </div>

                <!-- Date Range Filter -->
                <div class="px-6 pt-4 pb-2">
                    <form method="GET" action="{{ route('admin.transactions.index') }}" class="flex flex-wrap items-center gap-3 p-3 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-700">
                        <div class="flex items-center gap-2 text-slate-700 dark:text-slate-200 text-xs font-bold">
                            <i class="fa-regular fa-calendar-days text-blue-500 text-sm"></i>
                            <span>Date Range:</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <label for="filter_from" class="text-xs font-semibold text-slate-500 dark:text-slate-400">From</label>
                            <input 
                                type="date" 
                                id="filter_from" 
                                name="from" 
                                value="{{ request('from') }}"
                                class="px-3 py-1.5 text-xs bg-white dark:bg-slate-700 text-slate-800 dark:text-white border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            >
                        </div>
                        <div class="flex items-center gap-2">
                            <label for="filter_to" class="text-xs font-semibold text-slate-500 dark:text-slate-400">To</label>
                            <input 
                                type="date" 
                                id="filter_to" 
                                name="to" 
                                value="{{ request('to') }}"
                                class="px-3 py-1.5 text-xs bg-white dark:bg-slate-700 text-slate-800 dark:text-white border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            >
                        </div>
                        <div class="flex items-center gap-2">
                            <button 
                                type="submit" 
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-lg transition-all shadow-xs cursor-pointer"
                            >
                                <i class="fa-solid fa-filter text-xxs"></i>
                                <span>Filter</span>
                            </button>
                            @if(request('from') || request('to'))
                                <a 
                                    href="{{ route('admin.transactions.index') }}" 
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold text-xs rounded-lg transition-all cursor-pointer"
                                >
                                    <i class="fa-solid fa-xmark text-xxs"></i>
                                    <span>Reset</span>
                                </a>
                            @endif
                        </div>
                        @if(request('from') || request('to'))
                            <div class="ml-auto text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                                <span>
                                    Filtered:
                                    @if(request('from') && request('to'))
                                        <strong>{{ \Carbon\Carbon::parse(request('from'))->format('M d, Y') }}</strong> to <strong>{{ \Carbon\Carbon::parse(request('to'))->format('M d, Y') }}</strong>
                                    @elseif(request('from'))
                                        from <strong>{{ \Carbon\Carbon::parse(request('from'))->format('M d, Y') }}</strong> onwards
                                    @elseif(request('to'))
                                        up to <strong>{{ \Carbon\Carbon::parse(request('to'))->format('M d, Y') }}</strong>
                                    @endif
                                </span>
                            </div>
                        @endif
                    </form>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-0 overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                            @if($transactions->count())
                                <thead class="align-bottom">
                                    <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Patient</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status / Timer</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Total Amount</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Services</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Check-in Date</th>
                                    <th class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none dark:border-white/40 dark:text-white tracking-none whitespace-nowrap text-slate-400 opacity-70 text-right pr-6">Action</th>
                                    </tr>
                                </thead>
                            @endif
                            <tbody>
                                @forelse($transactions as $transaction)
                                @php
                                    $isCompleted = ($transaction->status ?? '') === 'completed';
                                    $checkInIso = $transaction->checked_in_at ?? null;
                                @endphp
                                <tr>
                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <div class="flex px-4 py-1">
                                            <div>
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png" class="inline-flex items-center justify-center mr-4 text-sm text-white transition-all duration-200 ease-in-out h-9 w-9 rounded-xl" alt="user1" />
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <h6 class="mb-0 text-sm leading-normal dark:text-white font-bold">{{ $transaction->patient->full_name ?? ($transaction->patient->first_name . ' ' . $transaction->patient->last_name) }}</h6>
                                                <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $transaction->patient->code ?? '' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- Status / Timer Column -->
                                    <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        @if(!$isCompleted)
                                            <span 
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300"
                                                data-id="{{ $transaction->id }}"
                                                data-checkin="{{ $checkInIso }}"
                                            >
                                                <i class="fa-solid fa-stopwatch animate-pulse"></i>
                                                <span>In Progress: <strong class="font-mono" x-text="timers[{{ $transaction->id }}] || '00:00'"></strong></span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300">
                                                <i class="fa-solid fa-check text-xs"></i>
                                                <span>Completed {{ !empty($transaction->formatted_duration) ? '(' . $transaction->formatted_duration . ')' : '' }}</span>
                                            </span>
                                        @endif
                                    </td>

                                    <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <span class="font-bold text-slate-800 dark:text-white font-mono">PHP {{ number_format($transaction->total_amount, 2) }}</span>
                                    </td>

                                    <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <span class="text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-500">{{ count($transaction->services) . ' ' . str()->plural('service', count($transaction->services)) }}</span>
                                    </td>

                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent text-center">
                                        <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">{{ $transaction->formatted_check_in ?? $transaction->formatted_date }}</p>
                                    </td>

                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent text-right pr-6">
                                        <div class="inline-flex items-center gap-2">
                                            @if(!$isCompleted)
                                                <button 
                                                    type="button" 
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-md shadow-sm transition-all"
                                                    x-on:click="checkoutTransaction({{ $transaction->id }})"
                                                >
                                                    <i class="fa-solid fa-check text-xs"></i>
                                                    Check Out
                                                </button>
                                            @endif
                                            <button 
                                                type="button" 
                                                @click="openViewModal({{ json_encode($transaction) }})" 
                                                class="text-xs font-semibold px-3 py-1.5 border border-slate-300 dark:border-slate-600 rounded-md hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-200"
                                            >
                                                View
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-6 text-center text-slate-400">
                                            @if(request('from') || request('to'))
                                                <div class="py-4">
                                                    <i class="fa-solid fa-calendar-xmark text-slate-300 dark:text-slate-600 text-3xl mb-2"></i>
                                                    <p class="text-sm font-semibold text-slate-600 dark:text-slate-300 mb-1">No transactions found for the selected date range.</p>
                                                    <a href="{{ route('admin.transactions.index') }}" class="text-xs text-blue-600 hover:underline font-bold">Clear date filter</a>
                                                </div>
                                            @else
                                                No transactions yet. Click <strong>Start Walk-in / Transaction</strong> above to begin!
                                            @endif
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
    @include('shared.components.modals.view-transaction')
    @include('shared.argon.partials.footer')
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('transactions', () => ({
        timers: {},
        interval: null,

        init() {
            this.initTimers();
        },

        initTimers() {
            // Find all active timer badges
            const elements = document.querySelectorAll('[data-checkin]');
            const items = [];

            elements.forEach(el => {
                const id = el.dataset.id;
                const checkIn = el.dataset.checkin;
                if (id && checkIn) {
                    items.push({ id, startTime: new Date(checkIn).getTime() });
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
                    this.timers[item.id] = display;
                });
            };

            update();
            this.interval = setInterval(update, 1000);
        },

        async checkoutTransaction(id) {
            const result = await Swal.fire({
                title: 'Check Out Patient?',
                text: 'This will stop the procedure timer, finalize the transaction, and record the total duration.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Check Out Now',
                cancelButtonText: 'Cancel'
            });

            if (!result.isConfirmed) return;

            try {
                const response = await axios.post(`/api/v1/transactions/${id}/checkout`);
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
                    text: err.response?.data?.message || 'Something went wrong while completing the transaction.'
                });
            }
        },

        openCreateModal() {
            window.dispatchEvent(new CustomEvent('open-create-transaction'));
        },

        openViewModal(transaction) {
            window.dispatchEvent(new CustomEvent('open-view-transaction', { detail: transaction }));
        },
    }));
});
</script>
@endpush