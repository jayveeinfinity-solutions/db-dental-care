<div 
    x-data="viewAppointmentModal()"
    x-cloak
    @open-view-appointment.window="open($event.detail)"
    @close-view-appointment.window="close()"
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
                <div class="flex items-center">
                    <h2 class="custom-modal-title mr-3">Appointment Details</h2>
                    <template x-if="isCheckedIn()">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                            <span class="w-2 h-2 mr-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Checked In &bull; In Progress
                        </span>
                    </template>
                </div>
                <button x-on:click="close" class="custom-modal-close">&times;</button>
            </div>

            <!-- BODY -->
            <div class="custom-modal-body">
                <div class="grid grid-cols-1 gap-4">

                    <!-- Live Procedure Duration Timer Banner (when checked in) -->
                    <template x-if="isCheckedIn()">
                        <div class="p-4 bg-emerald-50 dark:bg-emerald-950/30 rounded-xl border border-emerald-200 dark:border-emerald-800 shadow-xs">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <span class="w-2.5 h-2.5 mr-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span class="text-xs font-bold uppercase text-emerald-800 dark:text-emerald-300 tracking-wider">
                                        Procedure In Progress
                                    </span>
                                </div>
                                <span class="text-xs font-semibold text-emerald-700 dark:text-emerald-400" x-show="getCheckInTime()">
                                    Checked In at <span x-text="getCheckInTime()"></span>
                                </span>
                            </div>

                            <div class="flex items-center justify-between pt-1">
                                <span class="text-xs font-semibold text-slate-600 dark:text-slate-300">Elapsed Procedure Duration:</span>
                                <div class="flex items-center">
                                    <i class="fa-solid fa-stopwatch text-emerald-600 mr-2 text-base animate-pulse"></i>
                                    <span class="text-xl font-mono font-bold text-emerald-700 dark:text-emerald-300" x-text="elapsedTimeDisplay">00m 00s</span>
                                </div>
                            </div>

                            <div class="mt-3 pt-2.5 border-t border-emerald-200 dark:border-emerald-800 flex items-center justify-end">
                                <button 
                                    type="button" 
                                    @click="checkoutAppointmentNow()"
                                    class="inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all bg-gradient-to-tl from-emerald-500 to-teal-400 rounded-lg cursor-pointer text-xs leading-normal tracking-tight-rem shadow-xs hover:-translate-y-px active:opacity-85 hover:shadow-md"
                                >
                                    <i class="fa-solid fa-check mr-1.5 text-xs"></i>
                                    Check Out &amp; Complete Procedure
                                </button>
                            </div>
                        </div>
                    </template>

                    <!-- Completed Procedure Total Duration -->
                    <template x-if="appointment?.status === 'completed' && (appointment?.transaction?.duration_seconds || appointment?.transaction?.formatted_duration)">
                        <div class="p-3 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-700 flex items-center justify-between text-xs">
                            <span class="font-bold uppercase text-slate-500">Total Procedure Duration:</span>
                            <span class="font-mono font-bold text-emerald-600 dark:text-emerald-400 text-sm" x-text="appointment?.transaction?.formatted_duration || (appointment?.transaction?.duration_seconds + 's')"></span>
                        </div>
                    </template>

                    <!-- Patient Info -->
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400">Patient</label>
                        <p class="text-sm font-semibold dark:text-white text-slate-800 mb-0" x-text="appointment?.patient?.full_name || ((appointment?.patient?.first_name || '') + ' ' + (appointment?.patient?.last_name || ''))"></p>
                        <p class="text-xs text-slate-400 mb-0" x-text="'Code: ' + (appointment?.patient?.code || 'N/A')"></p>
                    </div>

                    <!-- Services List (Cleanly spaced badges with icons) -->
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-2">
                            Services Rendered
                            <span class="text-slate-400 font-normal" x-show="appointment?.services && appointment.services.length > 0" x-text="'(' + appointment.services.length + ')'"></span>
                        </label>
                        <template x-if="appointment?.services && appointment.services.length > 0">
                            <div class="flex flex-wrap items-center mt-1">
                                <template x-for="srv in appointment.services" :key="srv.id">
                                    <div class="inline-flex items-center px-3 py-1.5 mr-2 mb-2 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800 shadow-2xs">
                                        <i class="fa-solid fa-tooth mr-1.5 text-xs text-blue-500"></i>
                                        <span x-text="srv.name"></span>
                                    </div>
                                </template>
                            </div>
                        </template>
                        <template x-if="!appointment?.services || appointment.services.length === 0">
                            <div class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800">
                                <i class="fa-solid fa-tooth mr-1.5 text-xs text-blue-500"></i>
                                <span x-text="appointment?.service?.name || 'No services listed'"></span>
                            </div>
                        </template>
                    </div>

                    <!-- Date & Time -->
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400">Date &amp; Time</label>
                        <p class="text-sm font-semibold dark:text-white text-slate-800" x-text="appointment?.formatted_date"></p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-1">Status</label>
                        <span 
                            class="px-3 py-1.5 text-xs font-bold rounded-1.8 inline-block whitespace-nowrap text-center align-baseline uppercase leading-none text-white bg-gradient-to-tl shadow-xs"
                            :class="getStatusClass()"
                            x-text="appointment?.status === 'checked_in' ? 'Checked In (In Progress)' : appointment?.status"
                        ></span>
                    </div>

                    <!-- Notes -->
                    <div x-show="appointment?.notes">
                        <label class="block text-xs font-bold uppercase text-slate-400">Notes</label>
                        <p class="text-sm text-slate-700 dark:text-white" x-text="appointment?.notes"></p>
                    </div>

                    <!-- Cancellation Details -->
                    <div x-show="appointment?.status === 'cancelled'">
                        <label class="block text-xs font-bold uppercase text-slate-400">Cancellation Details</label>
                        <p class="text-xs text-red-500 font-semibold" x-text="'Reason: ' + appointment?.cancellation_reason"></p>
                        <p class="text-xs text-slate-400" x-text="'By: ' + appointment?.cancelledBy?.name"></p>
                    </div>

                    <!-- History / PDF -->
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

                <div class="custom-modal-footer mt-4 flex items-center justify-between">
                    <div>
                        <!-- Check In Patient button if appointment is approved and not checked in -->
                        <template x-if="appointment?.status === 'approved' && !isCheckedIn()">
                            <button 
                                type="button" 
                                @click="checkInFromModal()" 
                                class="inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all bg-blue-500 hover:bg-blue-600 rounded-lg cursor-pointer text-xs leading-normal tracking-tight-rem shadow-xs hover:-translate-y-px active:opacity-85 hover:shadow-md"
                            >
                                <i class="fa-solid fa-stopwatch mr-1.5 text-xs"></i>
                                Check In Patient Now
                            </button>
                        </template>

                        <!-- Check Out Patient button if checked in -->
                        <template x-if="isCheckedIn()">
                            <button 
                                type="button" 
                                @click="checkoutAppointmentNow()" 
                                class="inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all bg-gradient-to-tl from-emerald-500 to-teal-400 rounded-lg cursor-pointer text-xs leading-normal tracking-tight-rem shadow-xs hover:-translate-y-px active:opacity-85 hover:shadow-md"
                            >
                                <i class="fa-solid fa-check mr-1.5 text-xs"></i>
                                Check Out Patient
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
    Alpine.data('viewAppointmentModal', () => ({
        show: false,
        appointment: null,
        elapsedSeconds: 0,
        elapsedTimeDisplay: '00m 00s',
        timerInterval: null,

        async open(appointment) {
            this.appointment = appointment;
            this.show = true;
            this.checkAndStartTimer();

            // Refresh appointment with latest transaction status from backend
            if (appointment?.id) {
                try {
                    const response = await axios.get(`/api/v1/appointments/${appointment.id}`);
                    if (response.data) {
                        this.appointment = response.data;
                        this.checkAndStartTimer();
                    }
                } catch (e) {
                    console.warn('Could not refresh appointment details', e);
                }
            }
        },

        close() {
            this.show = false;
            this.stopTimer();
        },

        isCheckedIn() {
            if (!this.appointment) return false;
            return this.appointment.status === 'checked_in' || 
                   this.appointment.transaction?.status === 'in_progress';
        },

        getCheckInTime() {
            const raw = this.appointment?.transaction?.checked_in_at || this.appointment?.transaction?.created_at;
            if (!raw) return '';
            try {
                return new Date(raw).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            } catch (e) {
                return '';
            }
        },

        checkAndStartTimer() {
            this.stopTimer();
            if (!this.isCheckedIn()) return;

            const checkInRaw = this.appointment?.transaction?.checked_in_at || 
                               this.appointment?.transaction?.created_at ||
                               this.appointment?.updated_at;
            if (!checkInRaw) return;

            const startTime = new Date(checkInRaw).getTime();

            const update = () => {
                const now = Date.now();
                this.elapsedSeconds = Math.max(0, Math.floor((now - startTime) / 1000));
                const hours = Math.floor(this.elapsedSeconds / 3600);
                const minutes = Math.floor((this.elapsedSeconds % 3600) / 60);
                const seconds = this.elapsedSeconds % 60;

                const pad = (n) => String(n).padStart(2, '0');
                if (hours > 0) {
                    this.elapsedTimeDisplay = `${hours}h ${pad(minutes)}m ${pad(seconds)}s`;
                } else {
                    this.elapsedTimeDisplay = `${pad(minutes)}m ${pad(seconds)}s`;
                }
            };

            update();
            this.timerInterval = setInterval(update, 1000);
        },

        stopTimer() {
            if (this.timerInterval) {
                clearInterval(this.timerInterval);
                this.timerInterval = null;
            }
        },

        getStatusClass() {
            if (!this.appointment) return 'from-slate-600 to-slate-400';
            switch (this.appointment.status) {
                case 'pending': return 'from-blue-700 to-cyan-500';
                case 'approved': return 'from-slate-600 to-slate-400';
                case 'checked_in': return 'from-emerald-500 to-teal-400';
                case 'cancelled': return 'from-red-600 to-orange-600';
                case 'completed': return 'from-emerald-500 to-teal-400';
                default: return 'from-slate-600 to-slate-400';
            }
        },

        async checkInFromModal() {
            if (!this.appointment?.id) return;

            const result = await Swal.fire({
                title: 'Check In Patient?',
                text: 'This will begin the appointment procedure and start duration tracking immediately.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Check In Now',
                cancelButtonText: 'Cancel'
            });

            if (!result.isConfirmed) return;

            try {
                const res = await axios.post(`/api/v1/appointments/${this.appointment.id}/check-in`);
                await Swal.fire({
                    icon: 'success',
                    title: 'Patient Checked In!',
                    text: 'Procedure timer is now running.',
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
            }
        },

        async checkoutAppointmentNow() {
            const transactionId = this.appointment?.transaction?.id;
            const appointmentId = this.appointment?.id;

            const result = await Swal.fire({
                title: 'Check Out Patient?',
                text: 'Stop procedure timer and complete the appointment transaction?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Check Out',
                cancelButtonText: 'Cancel'
            });

            if (!result.isConfirmed) return;

            try {
                let data = null;
                if (transactionId) {
                    const res = await axios.post(`/api/v1/transactions/${transactionId}/checkout`);
                    data = res.data;
                } else {
                    const res = await axios.put(`/api/v1/appointments/${appointmentId}/status`, {
                        status: 'completed'
                    });
                    data = res.data;
                }

                this.stopTimer();

                await Swal.fire({
                    icon: 'success',
                    title: 'Procedure Completed!',
                    html: `
                        <div class="text-left p-3 bg-emerald-50 rounded-lg text-emerald-900 border border-emerald-200">
                            <p class="mb-1 text-sm font-semibold">Patient checked out successfully!</p>
                            <p class="text-sm font-bold">Total Duration: <span class="text-emerald-600 font-mono">${data.duration_formatted || this.elapsedTimeDisplay}</span></p>
                        </div>
                    `,
                    confirmButtonText: 'OK'
                });

                this.close();
                window.location.reload();
            } catch (err) {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Check-out Failed',
                    text: err.response?.data?.message || 'Something went wrong.'
                });
            }
        }
    }));
});
</script>
