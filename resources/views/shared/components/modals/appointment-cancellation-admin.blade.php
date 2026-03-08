<div 
    x-data="cancelAppointmentModal()"
    x-cloak
    @open-appointment-cancellation-admin.window="open($event.detail?.id)"
    @close-appointment-cancellation-admin.window="show = false"
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
                <h2 class="custom-modal-title">Cancel appointment</h2>
                <button x-on:click="close" class="custom-modal-close">&times;</button>
            </div>

            <!-- BODY -->
            <div class="custom-modal-body">
                <form class="max-w-sm mx-auto opacity-8" @submit.prevent="submit">
                    <div class="mb-5">
                        <label for="services" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reason for cancellation of appointment:</label>
                        <template x-for="(reason, index) in reasons" :key="index">
                            <div class="flex items-center mb-4">
                                <input :id="'reason-' + index" type="radio" name="reason"
                                    x-model="selectedReason"
                                    :value="reason"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label :for="'reason-' + index" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300" x-text="reason"></label>
                            </div>
                        </template>
                        <div class="flex items-center mb-4">
                            <input id="reason-other" type="radio" name="reason" 
                                x-model="selectedReason"
                                value="Other"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="reason-other" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Other</label>
                        </div>
                    </div>
                    <div class="mb-5" x-show="selectedReason === 'Other'">
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Other reason message</label>
                        <textarea id="message" rows="4"
                            x-model="otherReason"
                            placeholder="Please specify your reason..."
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('cancelAppointmentModal', () => ({
        show: false,
        id: null, 
        form: {
            reason: ''
        },
        message: '',
        success: false,
        reasons: [
            'I need to postpone my treatment',
            'My doctor is unavailable',
            'I’m experiencing dental pain or a health issue',
            'I need to reschedule because my payment is incomplete',
            'I already had the procedure done somewhere else',
            'I wasn’t able to confirm my appointment'
        ],
        selectedReason: '',
        otherReason: '',

        open(id) {
            this.id = id || -1;
            this.show = true;

            this.form = {
                reason: ''
            };
        },

        close() {
            this.show = false;
            window.location.reload();
        },

        async submit() {
            this.message = '';
            this.success = false;

            let finalReason = this.selectedReason === 'Other' ? this.otherReason : this.selectedReason;
            if (!finalReason) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Please select or enter a reason.',
                });
                return;
            }

            this.form.reason = finalReason;

            try {
                const response = await axios.patch(`/api/v1/appointments/${this.id}/cancel`, this.form);
                this.message = response.data.message || 'Appointment booked successfully!';
                this.success = true;
                
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: this.message,
                    allowOutsideClick: false,
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload();
                });

                setTimeout(() => {
                    this.close();
                }, 500);

                this.form.reason = '';
                this.selectedReason = '';
                this.otherReason = '';
                this.success = false;
                this.message = '';
            } catch (error) {
                this.success = false;
                this.message = error.response?.data?.message || 'Something went wrong. Please try again.';

                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: this.message,
                });
            }
        }
    }));
});

</script>

<style>
/* Hide elements until Alpine loads */
[x-cloak] { display: none !important; }

/* Backdrop */
.custom-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(3px);
    z-index: 998;
}

/* Modal wrapper */
.custom-modal-wrapper {
    position: relative;
}

/* Center container */
.custom-modal-container {
    position: fixed;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    z-index: 999;
}

/* Modal box */
.custom-modal-box {
    background: #ffffff;
    color: #333;
    width: 100%;
    max-width: 500px;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.25);
    overflow: hidden;
}

/* Header */
.custom-modal-header {
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid #eee;
}
.custom-modal-title {
    font-size: 1.2rem;
    font-weight: 600;
}
.custom-modal-close {
    background: none;
    border: none;
    font-size: 1.4rem;
    cursor: pointer;
    opacity: 0.6;
}
.custom-modal-close:hover {
    opacity: 1;
}

/* Body */
.custom-modal-body {
    padding: 1rem;
}
.custom-modal-input {
    width: 100%;
    padding: .5rem .75rem;
    border: 1px solid #ccc;
    border-radius: 6px;
}
.custom-modal-checkbox-label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: .9rem;
}

/* Footer */
.custom-modal-footer {
    padding: 1rem 0;
    display: flex;
    justify-content: flex-end;
    gap: .5rem;
    border-top: 1px solid #eee;
}

/* Buttons */
.custom-modal-btn {
    padding: .5rem 1rem;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-size: .85rem;
}
.custom-modal-btn-primary {
    background: #2563eb;
    color: #fff;
}
.custom-modal-btn-primary:hover {
    background: #1d4ed8;
}
.custom-modal-btn-secondary {
    background: #9ca3af;
    color: #fff;
}
.custom-modal-btn-secondary:hover {
    background: #6b7280;
}

/* Transitions */
.custom-modal-enter {
    transition: all 0.3s ease-out;
}
.custom-modal-enter-start {
    opacity: 0;
    transform: scale(0.9) translateY(10px);
}
.custom-modal-enter-end {
    opacity: 1;
    transform: scale(1) translateY(0);
}
.custom-modal-leave {
    transition: all 0.2s ease-in;
}
.custom-modal-leave-start {
    opacity: 1;
    transform: scale(1) translateY(0);
}
.custom-modal-leave-end {
    opacity: 0;
    transform: scale(0.9) translateY(10px);
}
</style>