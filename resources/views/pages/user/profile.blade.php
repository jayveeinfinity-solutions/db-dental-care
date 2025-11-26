@extends('layouts.base')

@section('title', 'Patient Information &sdots; ')

@section('content')
<section
    class="relative w-full flex justify-center p-6 lg:p-8 bg-center bg-cover bg-no-repeat"
    style="background-image: url('{{ config('r2.endpoint') }}/images/bg/1.jpg');"
>
    <div class="absolute inset-0 bg-gradient-to-r from-black/90 to-transparent"></div>
    <article class="relative z-5 w-full max-w-[335px] sm:max-w-md md:max-w-2xl lg:max-w-4xl flex justify-between">
        <div class="w-full text-start">
            <h1 class="mb-4 lg:mb-6 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl dark:text-white">
                Patient Information
            </h1>
        </div>
    </article>
</section>
<section class="w-full p-6 lg:p-8" x-data="patient()">
    <article class="w-full max-w-[335px] sm:max-w-md md:max-w-2xl lg:max-w-4xl mx-auto">
        <div class="sm:hidden" x-show="patient.code">
            <label for="tabs" class="sr-only">Status</label>
            <select id="tabs" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Patient Information</option>
                <option>Account Settings</option>
                <option>Appointments</option>
                <option>Transactions</option>
                <option>Patient History</option>
                <option>Settings</option>
            </select>
        </div>
        <ul class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow-sm sm:flex dark:divide-gray-700 dark:text-gray-400" x-show="patient.code">
            <li class="w-full focus-within:z-10">
                <a href="javascript:void(0)"
                    class="inline-block w-full p-4 border-r border-gray-200 dark:border-gray-700 rounded-s-lg focus:ring-4 focus:ring-blue-300 focus:outline-none dark:bg-gray-800 text-gray-900 bg-gray-100 active dark:bg-gray-700 dark:text-white"
                >Patient Information</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="{{ route('user.appointments') }}" class="inline-block w-full p-4 border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700 bg-white hover:bg-gray-50"
                >Appointments</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="{{ route('user.transactions') }}" class="inline-block w-full p-4 border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700 bg-white hover:bg-gray-50"
                >Transactions</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="javascript:void(0)" class="inline-block w-full p-4 border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700 bg-white hover:bg-gray-50"
                >Patient History</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="{{ route('user.settings') }}" class="inline-block w-full p-4 border-s-0 border-gray-200 dark:border-gray-700 rounded-e-lg hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700 bg-white hover:bg-gray-50"
                >Settings</a>
            </li>
        </ul>
    </article>
    <div class="flex justify-center mt-5">
        <article class="w-full max-w-[335px] sm:max-w-md md:max-w-2xl lg:max-w-4xl flex flex-col gap-2 sm:gap-3 md:gap-4">
            <div class="flex items-start gap-5">
                <!-- Icon -->
                <div class="flex-shrink-0 place-self-center">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-300 to-blue-700 flex items-center justify-center shadow-sm">
                        <!-- patient icon -->
                        <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 12c2.8 0 5-2.3 5-5s-2.2-5-5-5-5 2.3-5 5 2.2 5 5 5zm0 2c-4.4 0-8 3.1-8 7v1h10.5a6.5 6.5 0 01-.5-2H7c0-3.3 2.7-6 6-6 .7 0 1.4.1 2 .3v2.1l1.5-1.5C15.7 13.3 13.9 14 12 14zm9 1h-2v-2h-2v2h-2v2h2v2h2v-2h2v-2z"
                                fill="currentColor"/>
                        </svg>
                    </div>
                </div>

                <!-- Content -->
                <div class="flex-1">
                    <h2 class="text-2xl sm:text-3xl font-semibold text-slate-900 leading-tight"
                        x-text="!patient.code ? 'Fill up personal details' : 'Patient Information' ">
                    </h2>
                    <p class="text-sm sm:text-base text-slate-600">
                        <template x-if="patient.code">
                            <span>Below are the patient personal information.</span>
                        </template>
                        <template x-if="!patient.code">
                            <span>Below are the required fields to continue using <span class="font-medium text-slate-800">DB Dental Care</span> online services.</span>
                        </template>
                    </p>
                </div>
            </div>

            <form class="space-y-4" @submit.prevent="submit">

                <!-- Code -->
                <div x-show="patient.code">
                    <label class="block text-sm font-medium mb-1" for="code">Patient Code</label>
                    <input type="input" name="code" id="code" class="w-full px-3 py-2 border rounded" disabled :value="patient.code">
                </div>

                <!-- Name -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1" for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="w-full px-3 py-2 border rounded" x-model="form.first_name" placeholder="First name..." required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="middle_name">Middle Name</label>
                        <input type="text" name="middle_name" id="middle_name" class="w-full px-3 py-2 border rounded" x-model="form.middle_name" placeholder="Middle name...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="w-full px-3 py-2 border rounded" x-model="form.last_name" placeholder="Last name..." required>
                    </div>
                </div>

                <!-- Birthdate -->
                <div>
                    <label class="block text-sm font-medium mb-1" for="birthdate">Birthdate</label>
                    <input type="date" name="birthdate" id="birthdate" class="w-full px-3 py-2 border rounded" x-model="form.birthdate" required>
                </div>

                <!-- Sex -->
                <div>
                    <label class="block text-sm font-medium mb-1">Sex</label>
                    <div class="flex gap-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="sex" value="male" class="form-radio" x-model="form.sex" required>
                            <span class="ml-2">Male</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="sex" value="female" class="form-radio" x-model="form.sex" required>
                            <span class="ml-2">Female</span>
                        </label>
                    </div>
                </div>

                <!-- Contact Number -->
                <div>
                    <label class="block text-sm font-medium mb-1" for="contact_number"></tex>Contact Number</label>
                    <input type="text" name="contact_number" id="contact_number" class="w-full px-3 py-2 border rounded" x-model="form.contact_number" placeholder="e.g. 09xxxxxxxxx" required>
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-sm font-medium mb-1" for="address">Address</label>
                    <textarea name="address" id="address" rows="3" class="w-full px-3 py-2 border rounded" x-model="form.address" placeholder="Address..." required></textarea>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white font-medium rounded hover:bg-blue-700 transition"
                        :disbled="isLoading"
                        x-text="isLoading ? 'Updating...' : 'Update patient information'">
                    </button>
                </div>
            </form>
        </article>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('patient', () => ({
            isLoading: false,
            patient: [],
            form: {
                user_id: '',
                first_name: '',
                middle_name: '',
                last_name: '',
                birthdate: '',
                sex: '',
                contact_number: '',
                address: ''
            },
            init() {
                this.fetchPatient();
            },
            fetchPatient() {
                let url = '/api/v1/patient';

                axios.get(url)
                    .then(response => {
                        this.patient = response.data;
                        
                        this.form.first_name = this.patient.first_name;
                        this.form.middle_name = this.patient.middle_name;
                        this.form.last_name = this.patient.last_name;
                        this.form.birthdate = this.patient.birthdate;
                        this.form.sex = this.patient.sex;
                        this.form.contact_number = this.patient.contact_number;
                        this.form.address = this.patient.address;
                    });
            },
            submit() {
                if(this.patient) {
                    this.createPatientInfo();
                } else {
                    this.updatePatientInfo();
                }
            },
            createPatientInfo() {
                this.isLoading = true;
                this.form.user_id = @js(auth()->id());

                axios.post('/api/v1/patients', this.form)
                    .then((response) => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.data.message || 'Patient record has been saved.',
                            allowOutsideClick: false,
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = '/profile';
                        });
                    })
                    .catch((error) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: error.response?.data?.message || 'Something went wrong. Please try again.',
                        });
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            },
            updatePatientInfo() {
                if(!this.patient) {
                     Swal.fire({
                        title: "Error!",
                        text: "There was an error updating patient information.",
                        icon: "error",
                        allowOutsideClick: false
                    });
                }
                
                this.isLoading = true;

                let url = `/api/v1/patients/${this.patient.id}`;

                axios.put(url, this.form)
                    .then(response => {
                        Swal.fire({
                            title: "Success!",
                            text: "Patient information updated successfully.",
                            icon: "success",
                            allowOutsideClick: false,
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        }).then(() => {
                            this.fetchPatient();
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            title: "Error!",
                            text: "There was an error updating patient information.",
                            icon: "error",
                            allowOutsideClick: false
                        });
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            }
        }));
    });
</script>
@endpush