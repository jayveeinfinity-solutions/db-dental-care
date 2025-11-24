<div 
    x-data="createPatientModal()"
    x-cloak
    @open-create-patient.window="open()"
    @close-create-patient.window="show = false"
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
                <h2 class="custom-modal-title">Add patient record</h2>
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
                        <button type="submit" class="custom-modal-btn custom-modal-btn-primary">Save Record</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('createPatientModal', () => ({
        show: false,
        appointmentId: null,
        form: {
            first_name: '',
            middle_name: '',
            last_name: '',
            birthdate: '',
            sex: '',
            contact_number: '',
            address: ''
        },

        open() {
            this.show = true;

            this.form = {
                first_name: '',
                middle_name: '',
                last_name: '',
                birthdate: '',
                sex: '',
                contact_number: '',
                address: ''
            };
        },

        close() {
            this.show = false;
            window.location.reload();
        },

        async submit() {
            try {
                const formData = new FormData();

                formData.append('first_name', this.form.first_name);
                formData.append('middle_name', this.form.middle_name);
                formData.append('last_name', this.form.last_name);
                formData.append('birthdate', this.form.birthdate);
                formData.append('sex', this.form.sex);
                formData.append('contact_number', this.form.contact_number);
                formData.append('address', this.form.address);

                const response = await axios.post(
                    `/api/v1/patients`,
                    formData,
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

                    // Close the modal
                    this.show = false;

                    // Reload page AFTER swal closes
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

.gap-1 {
    gap: 0.25rem;
}
.gap-4 {
    gap: 1rem;
}
</style>