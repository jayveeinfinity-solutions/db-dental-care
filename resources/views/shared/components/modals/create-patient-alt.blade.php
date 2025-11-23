<x-modal name="create-patient-alt-modal" :show="false" :maxWidth="'md'">
    <div class="relative p-4 w-full max-h-full"
        x-data="{
            tab: 'no-id',
            form: {
                code: '',
                
                first_name: '',
                middle_name: '',
                last_name: '',
                birthdate: '',
                sex: '',
                contact_number: '',
                address: ''
            },
            message: '',
            success: false,

            submit() {
                if (this.tab === 'no-id') {
                    this.createPatientRecord();
                } else if (this.tab === 'has-id') {
                    this.linkPatientRecord();
                }
            },

            async createPatientRecord() {
                this.message = '';
                this.success = false;

                try {
                    await axios.get('/sanctum/csrf-cookie');
                    const response = await axios.post('/api/v1/appointments', this.form);
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
                        this.$dispatch('close-modal', 'create-patient-alt-modal');
                    }, 500);

                    this.form.service_id = '';
                    this.form.date = '';
                    this.form.time = '';
                } catch (error) {
                    this.success = false;
                    this.message = error.response?.data?.message || 'Something went wrong. Please try again.';

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: this.message,
                    });
                }
            },

            async linkPatientRecord() {
                this.message = '';
                this.success = false;

                try {
                    await axios.get('/sanctum/csrf-cookie');
                    const response = await axios.post('/api/v1/patients/link', { code: this.form.code });
                    this.message = response.data.message || 'Patient record linked successfully!';
                    this.success = true;

                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: this.message,
                        allowOutsideClick: false,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });

                    setTimeout(() => {
                        this.$dispatch('close-modal', 'create-patient-alt-modal');
                    }, 500);

                    this.form.code = '';
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
    >
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between px-4 pb-3 md:px-5 md:pb-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Create Patient Information
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    x-data
                    x-on:click.prevent="$dispatch('close-modal', 'create-patient-alt-modal')">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <div class="w-full inline-flex rounded-md shadow-xs mb-5 justify-center">
                    <a href="javascript:void(0)"
                        x-on:click="tab = 'no-id'"
                        class="px-4 py-2 text-sm font-medium bg-white border border-gray-200 rounded-s-lg"
                        :class="{
                            'text-blue-700': tab === 'no-id',
                            'text-gray-900 hover:text-blue-700 hover:bg-gray-100': tab !== 'no-id'
                        }">
                        No patient ID yet?
                    </a>
                    <a href="javascript:void(0)"
                        x-on:click="tab = 'has-id'"
                        class="px-4 py-2 text-sm font-medium bg-white border border-gray-200 rounded-e-lg"
                        :class="{
                            'text-blue-700': tab === 'has-id',
                            'text-gray-900 hover:text-blue-700 hover:bg-gray-100': tab !== 'has-id'
                        }">
                        Already have patient ID?
                    </a>
                </div>
                <form class="max-w-sm mx-auto opacity-8" x-show="tab === 'no-id'" @submit.prevent="submit">
                    <div class="mb-5">
                        <label for="services" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select service</label>
                        <select id="services" x-model="form.service_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" selected disabled>Choose a service...</option>
                            @php $category = ''; @endphp
                            @foreach($services as $service)
                                @php $currentCategory = $service->category->name; @endphp
                                @if($category !== $currentCategory) {
                                    <option class="font-bold" disabled>{{ str()->upper($currentCategory) }}</option>
                                    @php $category = $currentCategory; @endphp
                                }
                                @endif
                                <option class="ps-3" value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-5">
                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date</label>
                        <input type="date" id="date" x-model="form.date" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light" required/>
                    </div>
                    <div class="mb-5">
                        <label class="block text-sm font-semibold">Select Time</label>
                        <select x-model="form.time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" selected disabled>-- Select Time --</option>
                            @foreach($times as $time)
                                <option value="{{ $time['value'] }}">{{ $time['text'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </form>
                <!-- BIND PATIENT ID -->
                <form class="max-w-sm mx-auto opacity-8" x-show="tab === 'has-id'" @submit.prevent="submit">
                    <div class="mb-5">
                        <label for="code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Patient Code</label>
                        <input id="code" x-model="form.code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="e.g. PAT-00000" required>
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Link patient record</button>
                </form>
            </div>
        </div>
    </div>
</x-modal>