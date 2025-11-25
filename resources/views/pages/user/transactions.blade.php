@extends('layouts.base')

@section('title', 'My Transactions &sdots; ')

@section('content')
<section
    class="relative w-full flex justify-center p-6 lg:p-8 bg-center bg-cover bg-no-repeat"
    style="background-image: url('{{ config('r2.endpoint') }}/images/bg/1.jpg');"
>
    <div class="absolute inset-0 bg-gradient-to-r from-black/90 to-transparent"></div>
    <article class="relative z-5 w-full max-w-[335px] sm:max-w-md md:max-w-2xl lg:max-w-4xl flex justify-between">
        <div class="w-[60%]">
            <h1 class="mb-4 lg:mb-6 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl dark:text-white">
                My Transactions
            </h1>
        </div>
    </article>
</section>
<section class="w-full p-6 lg:p-8" x-data="transactions()">
    <article class="w-full max-w-[335px] sm:max-w-md md:max-w-2xl lg:max-w-4xl mx-auto">
        <!-- <div class="sm:hidden">
            <label for="tabs" class="sr-only">Status</label>
            <select id="tabs" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>All</option>
                <option>Approved</option>
                <option>Pending</option>
                <option>Completed</option>
                <option>Cancelled</option>
            </select>
        </div>
        <ul class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow-sm sm:flex dark:divide-gray-700 dark:text-gray-400">
            <li class="w-full focus-within:z-10">
                <a href="#"
                    class="inline-block w-full p-4 border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 rounded-s-lg focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                    :class="active === 'all'
                        ? 'text-gray-900 bg-gray-100 active dark:bg-gray-700 dark:text-white'
                        : 'bg-white hover:bg-gray-50'"
                    x-on:click="setActive('all')"
                >All</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="#" class="inline-block w-full p-4 border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                    :class="active === 'pending'
                        ? 'text-gray-900 bg-gray-100 active dark:bg-gray-700 dark:text-white'
                        : 'bg-white hover:bg-gray-50'"
                    x-on:click="setActive('pending')"
                >Pending</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="#" class="inline-block w-full p-4 border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                    :class="active === 'approved'
                        ? 'text-gray-900 bg-gray-100 active dark:bg-gray-700 dark:text-white'
                        : 'bg-white hover:bg-gray-50'"
                    x-on:click="setActive('approved')"
                >Approved</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="#" class="inline-block w-full p-4 border-s-0 border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                    :class="active === 'completed'
                        ? 'text-gray-900 bg-gray-100 active dark:bg-gray-700 dark:text-white'
                        : 'bg-white hover:bg-gray-50'"
                    x-on:click="setActive('completed')"
                >Completed</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="#" class="inline-block w-full p-4 border-s-0 border-gray-200 dark:border-gray-700 rounded-e-lg hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                    :class="active === 'cancelled'
                        ? 'text-gray-900 bg-gray-100 active dark:bg-gray-700 dark:text-white'
                        : 'bg-white hover:bg-gray-50'"
                    x-on:click="setActive('cancelled')"
                >Cancelled</a>
            </li>
        </ul> -->
    </article>
    <div class="flex justify-center mt-5">
        <article class="w-full max-w-[335px] sm:max-w-md md:max-w-2xl lg:max-w-4xl flex flex-col gap-2 sm:gap-3 md:gap-4">
            <template x-for="transaction in transactions" :key="transaction.id">
                <div class="block w-full p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <div class="flex flex-row justify-between items-center">
                        <div>
                            <div class="flex flex-row gap-2 items-center">
                                <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white" x-text="transaction.patient.full_name"></h5>
                                <div>
                                    <span
                                        class="text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm bg-blue-100 text-blue-800"
                                        x-text="`PHP ${transaction.total_amount}`">
                                    </span>
                                </div>
                            </div>
                            <p class="font-normal text-sm text-gray-700 dark:text-gray-400" x-text="transaction.formatted_date"></p>
                        </div>
                        <div>
                            <button type="button"
                                class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900"
                                x-on:click="viewFile(transaction.history.file_path)"
                            >View File</button>
                        </div>
                    </div>
                </div>
            </template>
            <template x-if="transactions.length === 0">
                <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        No transactions found.
                    </h5>
                </div>
            </template>
        </article>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('transactions', () => ({
            transactions: [],
            active: 'all',
            init() {
                this.fetchTransactions();
            },
            fetchTransactions() {
                let url = '/api/v1/transactions';

                if(this.active !== 'all') {
                    url += `?status=${this.active}`;
                }

                axios.get(url)
                    .then(response => {
                        this.transactions = response.data.transactions;
                    });
            },
            viewFile(path) {
                console.log(path)
            }         
        }));
    });
</script>
@endpush