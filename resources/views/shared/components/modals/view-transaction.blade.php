<div 
    x-data="viewTransactionModal()"
    x-cloak
    @open-view-transaction.window="open($event.detail)"
    @close-view-transaction.window="show = false"
    class="custom-modal-wrapper"
>
    <!-- BACKDROP -->
    <div x-show="show" x-transition.opacity.duration.300ms class="custom-modal-backdrop" x-on:click="show=false"></div>

    <!-- MODAL -->
    <div x-show="show"
         x-transition:enter="custom-modal-enter"
         x-transition:enter-start="custom-modal-enter-start"
         x-transition:enter-end="custom-modal-enter-end"
         x-transition:leave="custom-modal-leave"
         x-transition:leave-start="custom-modal-leave-start"
         x-transition:leave-end="custom-modal-leave-end"
         class="custom-modal-container"
    >
        <div class="custom-modal-box">

            <!-- HEADER -->
            <div class="custom-modal-header">
                <h2 class="custom-modal-title">Transaction Details</h2>
                <button x-on:click="close" class="custom-modal-close">&times;</button>
            </div>

            <!-- BODY -->
            <div class="custom-modal-body">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400">Patient</label>
                        <p class="text-sm font-semibold dark:text-white" x-text="transaction?.patient?.full_name"></p>
                        <p class="text-xs text-slate-400" x-text="transaction?.patient?.code"></p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400">Date</label>
                        <p class="text-sm font-semibold dark:text-white" x-text="transaction?.formatted_date"></p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-2">Services Rendered</label>
                        <div class="bg-gray-50 dark:bg-slate-700/50 rounded-lg p-3">
                            <template x-for="service in transaction?.services" :key="service.id">
                                <div class="flex justify-between items-center py-1 border-b border-gray-100 dark:border-slate-600 last:border-0">
                                    <span class="text-xs dark:text-white" x-text="service?.service?.name"></span>
                                    <span class="text-xs font-mono font-bold dark:text-white" x-text="'PHP ' + service?.price"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="flex justify-between items-center bg-blue-50 dark:bg-blue-900/20 p-3 rounded-lg">
                        <label class="text-sm font-bold uppercase text-blue-600 dark:text-blue-400">Total Amount</label>
                        <p class="text-lg font-bold text-blue-600 dark:text-blue-400" x-text="'PHP ' + transaction?.total_amount"></p>
                    </div>

                    <div x-show="transaction?.history" class="mt-2 text-center">
                        <a 
                            :href="'/patient-history/' + transaction?.history?.id" 
                            target="_blank"
                            class="inline-flex items-center gap-2 px-6 py-2 bg-blue-500 text-white font-bold rounded-lg hover:bg-blue-600 transition-all text-sm"
                        >
                            <i class="fa-solid fa-file-pdf"></i>
                            View PDF Record
                        </a>
                    </div>
                </div>

                <div class="custom-modal-footer mt-4">
                    <button type="button" x-on:click="close" class="custom-modal-btn custom-modal-btn-secondary">Close</button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('viewTransactionModal', () => ({
        show: false,
        transaction: null,

        open(transaction) {
            this.transaction = transaction;
            this.show = true;
        },

        close() {
            this.show = false;
        }
    }));
});
</script>
