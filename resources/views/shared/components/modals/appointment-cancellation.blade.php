<x-modal name="appointment-cancellation-modal" :show="false" :maxWidth="'md'" :allowClickOutside="false" :allowEscapeKey="false">
    <div class="relative p-4 w-full max-h-full"
        x-data="{
            id: null, 
            form: {
                reason: ''
            },
            message: '',
            success: false,
            reasons: [
                'Patient postponed treatment',
                'Doctor unavailable',
                'Ongoing dental pain or health issue',
                'Reschedule due to incomplete payment',
                'Procedure already done elsewhere',
                'No confirmation from patient',
            ],
            selectedReason: '',
            otherReason: '',

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

                console.log('appointment-cancellation-modal submitting...')

                try {
                    await axios.get('/sanctum/csrf-cookie');
                    const response = await axios.post(`/api/v1/appointments/${id}/cancel`, this.form);
                    this.message = response.data.message || 'Appointment booked successfully!';
                    this.success = true;

                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: this.message,
                        allowOutsideClick: false,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '/appointments';
                    });

                    setTimeout(() => {
                        this.$dispatch('close-modal', 'appointment-cancellation-modal');
                    }, 500);

                    this.form.reason = '';
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
        }"
        x-on:open-modal.window="(e) => {
            if (e.detail.name === 'appointment-cancellation-modal') {
                show = true;
                id = e.detail.appointmentId || null;
            }
        }"
    >
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between px-4 pb-3 md:px-5 md:pb-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Book an appointment
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    x-data
                    x-on:click.prevent="$dispatch('close-modal', 'appointment-cancellation-modal')">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <form class="max-w-sm mx-auto opacity-8"  @submit.prevent="submit">
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
                    <button type="submit"
                        x-on:click="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </form>
            </div>
        </div>
    </div>
</x-modal>