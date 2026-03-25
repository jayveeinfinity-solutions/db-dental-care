<div 
    x-data="viewAppointmentModal()"
    x-cloak
    @open-view-appointment.window="open($event.detail)"
    @close-view-appointment.window="show = false"
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
                <h2 class="custom-modal-title">Appointment Details</h2>
                <button x-on:click="close" class="custom-modal-close">&times;</button>
            </div>

            <!-- BODY -->
            <div class="custom-modal-body">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400">Patient</label>
                        <p class="text-sm font-semibold dark:text-white" x-text="appointment?.patient?.first_name + ' ' + appointment?.patient?.last_name"></p>
                        <p class="text-xs text-slate-400" x-text="appointment?.patient?.code"></p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400">Service</label>
                        <p class="text-sm font-semibold dark:text-white" x-text="appointment?.service?.name"></p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400">Date & Time</label>
                        <p class="text-sm font-semibold dark:text-white" x-text="appointment?.formatted_date"></p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400">Status</label>
                        <span 
                            class="px-2.5 py-0.5 text-xs font-bold rounded-1.8 inline-block whitespace-nowrap text-center align-baseline uppercase leading-none text-white bg-gradient-to-tl"
                            :class="getStatusClass()"
                            x-text="appointment?.status"
                        ></span>
                    </div>

                    <div x-show="appointment?.notes">
                        <label class="block text-xs font-bold uppercase text-slate-400">Notes</label>
                        <p class="text-sm dark:text-white" x-text="appointment?.notes"></p>
                    </div>

                    <div x-show="appointment?.status === 'cancelled'">
                        <label class="block text-xs font-bold uppercase text-slate-400">Cancellation Details</label>
                        <p class="text-xs text-red-500 font-semibold" x-text="'Reason: ' + appointment?.cancellation_reason"></p>
                        <p class="text-xs text-slate-400" x-text="'By: ' + appointment?.cancelledBy?.name"></p>
                    </div>

                    <div x-show="appointment?.status === 'completed' && appointment?.history">
                        <label class="block text-xs font-bold uppercase text-slate-400">Record / History</label>
                        <a 
                            :href="'/patient-history/' + appointment?.history?.id" 
                            target="_blank"
                            class="inline-flex items-center gap-1 text-sm font-bold text-blue-500 hover:underline"
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
    Alpine.data('viewAppointmentModal', () => ({
        show: false,
        appointment: null,

        open(appointment) {
            this.appointment = appointment;
            this.show = true;
        },

        close() {
            this.show = false;
        },

        getStatusClass() {
            if (!this.appointment) return '';
            switch (this.appointment.status) {
                case 'pending': return 'from-blue-700 to-cyan-500';
                case 'approved': return 'from-slate-600 to-slate-300';
                case 'cancelled': return 'from-red-600 to-orange-600';
                case 'completed': return 'from-emerald-500 to-teal-400';
                default: return 'from-slate-600 to-slate-300';
            }
        }
    }));
});
</script>
