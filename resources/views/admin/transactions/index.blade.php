@extends('layouts.argon')

@section('title', 'Transactions &sdots; ')

@section('content')
<div class="w-full px-6 py-6 mx-auto" x-data="transactions">
    <!-- table 1 -->
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="inline-flex rounded-md shadow-xs mb-5">
                <a href="{{ route('admin.appointments.index') }}" aria-current="page" class="px-4 py-2 text-sm font-medium text-blue-700 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700">
                    All
                </a>
                <a href="{{ route('admin.appointments.index', ['status' => 'approved']) }}" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700">
                    Approved
                </a>
                <a href="{{ route('admin.appointments.index', ['status' => 'pending']) }}" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700">
                    Pending
                </a>
                <a href="{{ route('admin.appointments.index', ['status' => 'completed']) }}" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700">
                    Completed
                </a>
                <a href="{{ route('admin.appointments.index', ['status' => 'cancelled']) }}" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700">
                    Cancelled
                </a>
            </div>
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent flex justify-between items-center">
                    <h6 class="dark:text-white">{{ str()->plural('Transaction', $transactions->count()) }} ({{ $transactions->count() }})</h6>
                    <button type="button" class="inline-block px-6 py-3 mr-3 font-bold text-center text-white uppercase align-middle transition-all bg-blue-500 rounded-lg cursor-pointer leading-normal text-xs ease-in tracking-tight-rem shadow-xs bg-150 bg-x-25 hover:-translate-y-px active:opacity-85 hover:shadow-md" x-on:click="openCreateModal">Create transaction</button>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-0 overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                            @if($transactions->count())
                                <thead class="align-bottom">
                                    <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Name</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Total</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Date</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
                                    <th class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none dark:border-white/40 dark:text-white tracking-none whitespace-nowrap text-slate-400 opacity-70"></th>
                                    </tr>
                                </thead>
                            @endif
                            <tbody>
                                @forelse($transactions as $transaction)
                                <tr>
                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <div class="flex px-2 py-1">
                                        <div>
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png" class="inline-flex items-center justify-center mr-4 text-sm text-white transition-all duration-200 ease-in-out h-9 w-9 rounded-xl" alt="user1" />
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <h6 class="mb-0 text-sm leading-normal dark:text-white">{{ $transaction->patient->first_name }}</h6>
                                            <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $transaction->patient->last_name }}</p>
                                        </div>
                                        </div>
                                    </td>
                                    <td class="p-2 text-left align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <span class="text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">PHP {{ $transaction->total_amount }}</span>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">{{ $transaction->created_at }}</p>
                                        <!-- <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">Organization</p> -->
                                    </td>
                                    <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <span class="bg-gradient-to-tl px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white from-emerald-500 to-teal-400">{{ $transaction->amount }}</span>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <a href="javascript:;" class="text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400"> View </a>
                                    </td>
                                </tr>
                                @empty
                                    <p class="px-6">No transactions yet.</p>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('shared.components.modals.create-transaction')
    @include('shared.argon.partials.footer')
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('transactions', () => ({
        init() {},

        openCreateModal() {
            window.dispatchEvent(new CustomEvent('open-create-transaction'));
        },
    }));
});
</script>
@endpush