<div 
    x-data="editUserModal()"
    x-cloak
    @open-edit-user.window="open($event.detail)"
    @close-edit-user.window="show = false"
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
                <h2 class="custom-modal-title">Edit User</h2>
                <button x-on:click="close" class="custom-modal-close">&times;</button>
            </div>

            <!-- BODY -->
            <div class="custom-modal-body">
                <form @submit.prevent="submit">
                    <div class="mb-2">
                        <label class="mb-1">Name</label>
                        <input type="text" x-model="form.name" class="custom-modal-input" placeholder="User name..." required>
                    </div>
                    <div class="mb-2">
                        <label class="mb-1">Email</label>
                        <input type="email" x-model="form.email" class="custom-modal-input" placeholder="User email..." required>
                    </div>

                    <div class="mb-2">
                        <label class="mb-1">Role</label>
                        <select x-model="form.role" class="custom-modal-input" required>
                            <option value="">Select a role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ ucwords(str_replace('_', ' ', $role->name)) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="custom-modal-footer">
                        <button type="button" x-on:click="close" class="custom-modal-btn custom-modal-btn-secondary">Close</button>
                        <button type="submit" class="custom-modal-btn custom-modal-btn-primary">Update User</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('editUserModal', () => ({
        show: false,
        userId: null,
        form: {
            name: '',
            email: '',
            role: ''
        },

        open(user) {
            this.userId = user.id;
            this.form.name = user.name;
            this.form.email = user.email;
            this.form.role = user.role;
            this.show = true;
        },

        close() {
            this.show = false;
        },

        async submit() {
            try {
                const response = await axios.put(
                    `/api/v1/users/${this.userId}`,
                    this.form,
                );

                Swal.fire({
                    icon: 'success',
                    title: 'User Updated',
                    text: response.data.message || 'User has been updated successfully.',
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
                    title: 'Update Failed',
                    text: error.response?.data?.message || 'Something went wrong.'
                });
            }
        }
    }));
});
</script>
