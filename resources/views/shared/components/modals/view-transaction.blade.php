<div 
    x-data="viewTransactionModal()"
    x-cloak
    @open-view-transaction.window="open($event.detail)"
    @close-view-transaction.window="close()"
    class="custom-modal-wrapper"
>
    <!-- BACKDROP -->
    <div x-show="show" x-transition.opacity.duration.300ms class="custom-modal-backdrop" x-on:click="close()"></div>

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
                <div class="flex items-center gap-2">
                    <h2 class="custom-modal-title">Transaction Details</h2>
                    <span 
                        class="px-2 py-0.5 text-xs font-bold rounded-full uppercase"
                        :class="transaction?.status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800 animate-pulse'"
                        x-text="transaction?.status === 'completed' ? 'Completed' : 'In Progress'"
                    ></span>
                </div>
                <button x-on:click="close" class="custom-modal-close">&times;</button>
            </div>

            <!-- BODY -->
            <div class="custom-modal-body">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400">Patient</label>
                        <p class="text-sm font-semibold dark:text-white" x-text="transaction?.patient?.full_name || (transaction?.patient?.first_name + ' ' + (transaction?.patient?.last_name || ''))"></p>
                        <p class="text-xs text-slate-400" x-text="transaction?.patient?.code"></p>
                    </div>

                    <!-- Timing and Duration Block -->
                    <div class="p-3 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-700">
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-2">Procedure Duration</label>
                        <div class="grid grid-cols-2 gap-3 text-xs mb-2">
                            <div>
                                <span class="text-slate-500 dark:text-slate-400">Check-in:</span>
                                <p class="font-semibold text-slate-800 dark:text-white" x-text="transaction?.formatted_check_in || transaction?.formatted_date || '-'"></p>
                            </div>
                            <div>
                                <span class="text-slate-500 dark:text-slate-400">Check-out:</span>
                                <p class="font-semibold text-slate-800 dark:text-white" x-text="transaction?.status === 'completed' ? (transaction?.formatted_check_out || 'Completed') : 'In Progress...'"></p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-2 border-t border-slate-200 dark:border-slate-700">
                            <span class="text-xs font-bold text-slate-600 dark:text-slate-300">Total Duration:</span>
                            <span class="text-sm font-mono font-bold" 
                                :class="transaction?.status === 'completed' ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400'"
                                x-text="getDurationDisplay()">
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-2">Services Rendered</label>
                        <div class="bg-gray-50 dark:bg-slate-700/50 rounded-lg p-3 max-h-36 overflow-y-auto">
                            <template x-for="service in transaction?.services" :key="service.id">
                                <div class="flex justify-between items-center py-1 border-b border-gray-100 dark:border-slate-600 last:border-0">
                                    <span class="text-xs dark:text-white" x-text="service?.service?.name || 'Dental Service'"></span>
                                    <span class="text-xs font-mono font-bold dark:text-white" x-text="'PHP ' + (service?.price || service?.subtotal || 0)"></span>
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

                <div class="custom-modal-footer mt-4 flex items-center justify-between">
                    <div>
                        <template x-if="transaction?.status === 'in_progress'">
                            <button 
                                type="button" 
                                x-on:click="checkoutCurrent()" 
                                class="custom-modal-btn bg-emerald-600 text-white hover:bg-emerald-700 flex items-center gap-1.5 font-bold"
                            >
                                <i class="fa-solid fa-check"></i>
                                Check Out Patient Now
                            </button>
                        </template>
                    </div>
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
        elapsedSeconds: 0,
        timerInterval: null,

        open(transaction) {
            this.transaction = transaction;
            this.show = true;
            this.startTimer();
        },

        close() {
            this.show = false;
            this.stopTimer();
        },

        startTimer() {
            this.stopTimer();
            if (this.transaction?.status === 'in_progress' && this.transaction?.checked_in_at) {
                const startTime = new Date(this.transaction.checked_in_at).getTime();
                const update = () => {
                    const now = Date.now();
                    this.elapsedSeconds = Math.max(0, Math.floor((now - startTime) / 1000));
                };
                update();
                this.timerInterval = setInterval(update, 1000);
            }
        },

        stopTimer() {
            if (this.timerInterval) {
                clearInterval(this.timerInterval);
                this.timerInterval = null;
            }
        },

        getDurationDisplay() {
            if (!this.transaction) return '-';
            if (this.transaction.status === 'completed') {
                return this.transaction.formatted_duration || (this.transaction.duration_seconds ? this.transaction.duration_seconds + 's' : '0s');
            }
            // Active timer
            const total = this.elapsedSeconds;
            const hours = Math.floor(total / 3600);
            const minutes = Math.floor((total % 3600) / 60);
            const seconds = total % 60;
            if (hours > 0) {
                return `${hours}h ${minutes}m ${seconds}s (Running)`;
            }
            return `${minutes}m ${seconds}s (Running)`;
        },

        async checkoutCurrent() {
            if (!this.transaction?.id) return;

            const result = await Swal.fire({
                title: 'Check Out Patient?',
                text: 'This will stop the procedure timer and finalize the transaction with the total duration.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Check Out Now',
                cancelButtonText: 'Cancel'
            });

            if (!result.isConfirmed) return;

            try {
                const response = await axios.post(`/api/v1/transactions/${this.transaction.id}/checkout`);
                this.stopTimer();
                const data = response.data;

                await Swal.fire({
                    icon: 'success',
                    title: 'Transaction Completed!',
                    html: `<p class="mb-2">Patient has been checked out.</p><p class="text-base font-bold text-emerald-600">Total Duration: ${data.duration_formatted || '0m'}</p>`,
                    confirmButtonText: 'Great!'
                });

                this.close();
                window.location.reload();
            } catch (err) {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Check-out Failed',
                    text: err.response?.data?.message || 'Unable to check out patient.'
                });
            }
        }
    }));
});
</script>
