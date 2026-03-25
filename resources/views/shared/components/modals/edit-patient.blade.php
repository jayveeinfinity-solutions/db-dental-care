<div 
    x-data="editPatientModal()"
    x-cloak
    @open-edit-patient.window="open($event.detail)"
    @close-edit-patient.window="show = false"
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
                <h2 class="custom-modal-title">Edit patient record</h2>
                <button x-on:click="close" class="custom-modal-close">&times;</button>
            </div>

            <!-- BODY -->
            <div class="custom-modal-body">
                <form @submit.prevent="submit">
                    <div class="mb-2">
                        <label class="mb-1">First name</label>
                        <input type="text" x-model="form.first_name" class="custom-modal-input" placeholder="First name..." required>
                    </div>
                    <div class="mb-2">
                        <label class="mb-1">Middle name (Optional)</label>
                        <input type="text" x-model="form.middle_name" class="custom-modal-input" placeholder="Middle name...">
                    </div>
                    <div class="mb-2">
                        <label class="mb-1">Last name</label>
                        <input type="text" x-model="form.last_name" class="custom-modal-input" placeholder="Last name..." required>
                    </div>

                    <div class="mb-2">
                        <label class="mb-1">Birthdate</label>
                        <input type="date" x-model="form.birthdate" class="custom-modal-input" required>
                    </div>

                    <div class="mb-2">
                        <label class="mb-1">Sex</label>
                        <div class="flex items-center gap-4 mt-1">
                            <label class="flex items-center gap-1">
                                <input type="radio" name="sex" value="male" x-model="form.sex" required>
                                Male
                            </label>

                            <label class="flex items-center gap-1">
                                <input type="radio" name="sex" value="female" x-model="form.sex" required>
                                Female
                            </label>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="mb-1">Contact Number</label>
                        <input 
                            type="text" 
                            x-model="form.contact_number" 
                            class="custom-modal-input" 
                            placeholder="09XXXXXXXXX"
                            required
                        >
                    </div>

                    <div class="mb-2">
                        <label class="mb-1">Address</label>
                        <input type="text" x-model="form.address" class="custom-modal-input" placeholder="Address..." required>
                    </div>

                    <div class="custom-modal-footer">
                        <button type="button" x-on:click="close" class="custom-modal-btn custom-modal-btn-secondary">Close</button>
                        <button type="submit" class="custom-modal-btn custom-modal-btn-primary">Update Record</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('editPatientModal', () => ({
        show: false,
        patientId: null,
        form: {
            first_name: '',
            middle_name: '',
            last_name: '',
            birthdate: '',
            sex: '',
            contact_number: '',
            address: ''
        },

        open(patient) {
            this.show = true;
            this.patientId = patient.id;
            this.form = {
                first_name: patient.first_name,
                middle_name: patient.middle_name,
                last_name: patient.last_name,
                birthdate: patient.birthdate,
                sex: patient.sex,
                contact_number: patient.contact_number,
                address: patient.address
            };
        },

        close() {
            this.show = false;
        },

        async submit() {
            try {
                const response = await axios.put(
                    `/api/v1/patients/${this.patientId}`,
                    this.form,
                );

                Swal.fire({
                    icon: 'success',
                    title: 'Patient Record Updated',
                    text: response.data.message || 'Patient record has been updated.',
                    allowOutsideClick: false,
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false
                }).then(() => {
                    // Close the modal
                    this.show = false;
                    // Reload page AFTER swal closes
                    window.location.reload();
                });

            } catch (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Update Failed',
                    text: error.response?.data?.message || 'Something went wrong.'
                });
            }
        }
    }));
});
</script>
