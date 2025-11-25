<div 
    x-data="createTransactionModal()"
    x-cloak
    @open-create-transaction.window="open($event.detail?.id)"
    @close-create-transaction.window="show = false"
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
                <h2 class="custom-modal-title">Add patient transaction</h2>
                <button x-on:click="close" class="custom-modal-close">&times;</button>
            </div>

            <!-- BODY -->
            <div class="custom-modal-body">
                <form @submit.prevent="submit">
                    <div class="w-full max-w-lg mb-3">
                        <!-- Display / Input container -->
                        <div x-on:click="openInput()" class="flex items-center justify-between p-3 border rounded-md cursor-pointer hover:ring-2 hover:ring-blue-500">
                            <div>
                                <template x-if="selectedPatient">
                                    <div>
                                        <div class="font-medium text-gray-800" x-text="selectedPatient.name"></div>
                                        <div class="text-sm text-gray-500" x-text="selectedPatient.code"></div>
                                    </div>
                                </template>
                                <template x-if="!selectedPatient">
                                    <div class="text-gray-400">Select a patient...</div>
                                </template>
                            </div>
                            <div>
                                <template x-if="!selectedPatient">
                                    <button x-on:click.stop="openInput()" class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700">Search</button>
                                </template>
                                <template x-if="selectedPatient">
                                    <button x-on:click.stop="removePatient()" class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700">Remove</button>
                                </template>
                            </div>
                        </div>

                        <!-- Input field for searching -->
                        <div x-show="inputOpen"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 transform translate-y-0"
                            x-transition:leave-end="opacity-0 transform -translate-y-2"
                            class="relative mt-2">
                            <input 
                                type="text"
                                x-ref="searchInput"
                                x-model="query" 
                                @input="searchPatients()" 
                                @keydown.escape="inputOpen = false"
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Type patient name or code..."
                            >

                            <!-- Suggestions dropdown -->
                            <ul x-show="filteredPatients.length > 0" class="absolute z-10 w-full bg-white border rounded mt-1 max-h-48 overflow-y-auto shadow-lg">
                                <template x-for="patient in filteredPatients" :key="patient.id">
                                    <li 
                                        x-on:click="selectPatient(patient)" 
                                        class="px-3 py-2 hover:bg-blue-100 cursor-pointer"
                                    >
                                        <div class="font-medium" x-text="patient.name"></div>
                                        <div class="text-sm text-gray-500" x-text="patient.code"></div>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="mb-1">Services</label>
                        <template x-for="(service, index) in form.services" :key="index">
                            <div class="flex flex-row gap-1 mb-2 relative">
                                <!-- Autocomplete input -->
                                <input type="text" 
                                    x-model="service.name"
                                    @input.debounce.300ms="searchService(index)"
                                    placeholder="Type service name..."
                                    class="custom-modal-input" 
                                    required>

                                <!-- Suggestions dropdown -->
                                <ul x-show="service.suggestions.length > 0" class="absolute bg-white border rounded shadow mt-1 w-full max-h-40 overflow-y-auto z-50" style="top: 100%; left: 0;">
                                    <template x-for="item in service.suggestions" :key="item.id">
                                        <li x-on:click="selectService(index, item)" 
                                            class="px-2 py-1 cursor-pointer hover:bg-gray-200"
                                            x-text="item.name"></li>
                                    </template>
                                </ul>

                                <input type="number" x-model="service.amount" placeholder="Amount" class="custom-modal-input" required>

                                <button type="button" x-on:click="removeService(index)" class="custom-modal-btn custom-modal-btn-secondary w-10 mt-1">-</button>
                            </div>
                        </template>
                        <button type="button" x-on:click="addService()" class="custom-modal-btn custom-modal-btn-primary mb-4">+ Add Service</button>
                    </div>

                    <div class="mb-2">
                        <label class="mb-1">Patient Record (PDF)</label>
                        <input type="file" 
                            x-ref="pdfFile" 
                            accept="application/pdf"
                            class="custom-modal-input">
                    </div>

                    <div class="mb-2">
                        <label class="mb-1">Notes</label>
                        <textarea x-model="form.notes" class="custom-modal-input" rows="3"></textarea>
                    </div>

                    <div class="custom-modal-footer">
                        <button type="button" x-on:click="close" class="custom-modal-btn custom-modal-btn-secondary">Close</button>
                        <button type="submit" class="custom-modal-btn custom-modal-btn-primary">Save Record</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('createTransactionModal', () => ({
        show: false,
        appointmentId: null,
        form: {
            notes: '',
            services: []
        },
        query: '',
        inputOpen: false,
        selectedPatient: null,
        filteredPatients: [],

        openInput() {
            this.$nextTick(() => this.$refs.searchInput.focus());
            this.inputOpen = true;
            this.query = '';
            this.filteredPatients = [];
        },

        searchPatients() {
            if (this.query.length < 2) {
                this.filteredPatients = [];
                return;
            }

            axios.get('/api/v1/patients/search', { params: { q: this.query } })
                .then(res => {
                    this.filteredPatients = res.data;
                })
                .catch(err => {
                    console.error(err);
                    this.filteredPatients = [];
                });
        },

        selectPatient(patient) {
            this.selectedPatient = patient;
            this.inputOpen = false;
            this.query = '';
            this.form.patient_id = this.selectedPatient?.id || -1
        },

        removePatient() {
            this.selectedPatient = null;
        },

        open(id) {
            this.appointmentId = id || -1;
            this.show = true;

            this.form = {
                patient_id: -1,
                notes: '',
                services: []
            };

            if(this.appointmentId != -1) 
                this.fetchAppointmentDetails();
        },

        close() {
            this.show = false;
        },

        async fetchAppointmentDetails() {
            if (!this.appointmentId) return;

            try {
                const response = await axios.get(`/api/v1/appointments/${this.appointmentId}`);
                const data = response.data;

                // Auto-fill form with retrieved data
                this.form.name = data.user.name || '';
                this.form.page = '';
                this.form.notes = data.notes || '';

                if (data.service) {
                    this.form.services = [{
                        id: data.service.id,
                        name: data.service.name,
                        amount: data.service.amount || '',
                        suggestions: []
                    }];
                }

            } catch (error) {
                console.error('Failed to fetch appointment details:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Fetch Failed',
                    text: error.response?.data?.message || 'Unable to retrieve appointment details.'
                });
            }
        },

        addService() {
            this.form.services.push({ name: '', amount: '' });
        },

        removeService(index) {
            this.form.services.splice(index, 1);
        },

        async searchService(index) {
            const query = this.form.services[index].name;
            if (!query) { this.form.services[index].suggestions = []; return; }

            try {
                const res = await axios.get(`/api/v1/services/search?q=${encodeURIComponent(query)}`);
                this.form.services[index].suggestions = res.data || [];
            } catch (err) {
                console.error(err);
            }
        },

        selectService(index, service) {
            this.form.services[index].id = service.id;
            this.form.services[index].name = service.name;
            this.form.services[index].suggestions = [];
        },

        // async searchPatients(index) {
        //     const query = this.form.patients[index].name;
        //     if (!query) { this.form.patients[index].suggestions = []; return; }

        //     try {
        //         const res = await axios.get(`/api/v1/services/search?q=${encodeURIComponent(query)}`);
        //         this.form.patients[index].suggestions = res.data || [];
        //     } catch (err) {
        //         console.error(err);
        //     }
        // },

        // selectPatients(index, service) {
        //     this.form.patients[index].id = service.id;
        //     this.form.patients[index].name = service.name;
        //     this.form.patients[index].suggestions = [];
        // },

        async submit() {
            try {
                const formData = new FormData();

                formData.append('patient_id', this.form.patient_id);
                formData.append('notes', this.form.notes);

                // Append services array as JSON string
                formData.append('services', JSON.stringify(this.form.services));

                // Append file if selected
                const file = this.$refs.pdfFile.files[0];
                if (file) {
                    formData.append('pdf_file', file);
                }

                const response = await axios.post(
                    `/api/v1/transactions`,
                    formData,
                    { headers: { 'Content-Type': 'multipart/form-data' } }
                );

                Swal.fire({
                    icon: 'success',
                    title: 'Patient Record Saved',
                    text: response.data.message || 'Patient record has been saved.',
                    allowOutsideClick: false,
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false
                }).then(() => {
                    this.show = false;
                    window.location.reload();
                });

            } catch (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Save Failed',
                    text: error.response?.data?.message || 'Something went wrong.'
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