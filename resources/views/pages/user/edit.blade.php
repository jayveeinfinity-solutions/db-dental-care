@extends('layouts.base')

@section('title', 'Patient Information &sdots; ')

@section('content')
<section
    class="relative w-full flex justify-center p-6 lg:p-8 bg-center bg-cover bg-no-repeat"
    style="background-image: url('/storage/images/bg/1.jpg');"
>
    <div class="absolute inset-0 bg-gradient-to-r from-black/90 to-transparent"></div>
    <article class="relative z-5 w-full lg:max-w-4xl max-w-[335px] flex justify-between">
        <div class="w-[60%]">
            <h1 class="mb-4 lg:mb-6 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl dark:text-white">
                My Profile
            </h1>
        </div>
    </article>
</section>
<section class="w-full p-6 lg:p-8" x-data="user()">
    <article class="w-full max-w-[335px] sm:max-w-md md:max-w-2xl lg:max-w-4xl mx-auto">
        <div class="sm:hidden">
            <label for="tabs" class="sr-only">Status</label>
            <select id="tabs" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Patient Information</option>
                <option>Account Settings</option>
                <option>Appointments</option>
                <option>Transactions</option>
                <option>Patient History</option>
                <option>Account Settings</option>
            </select>
        </div>
        <ul class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow-sm sm:flex dark:divide-gray-700 dark:text-gray-400">
            <li class="w-full focus-within:z-10">
                <a href="javascript:void(0)"
                    class="inline-block w-full p-4 border-r border-gray-200 dark:border-gray-700 rounded-s-lg focus:ring-4 focus:ring-blue-300 focus:outline-none dark:bg-gray-800 text-gray-900 bg-gray-100 active dark:bg-gray-700 dark:text-white"
                >Patient Information</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="{{ route('appointments') }}" class="inline-block w-full p-4 border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700 bg-white hover:bg-gray-50"
                >Appointments</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="javascript:void(0)" class="inline-block w-full p-4 border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700 bg-white hover:bg-gray-50"
                >Transactions</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="javascript:void(0)" class="inline-block w-full p-4 border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700 bg-white hover:bg-gray-50"
                >Patient History</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="javascript:void(0)" class="inline-block w-full p-4 border-s-0 border-gray-200 dark:border-gray-700 rounded-e-lg hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700 bg-white hover:bg-gray-50"
                >Account Settings</a>
            </li>
        </ul>
    </article>
    <div class="flex justify-center mt-5">
        <article class="w-full max-w-[335px] sm:max-w-md md:max-w-2xl lg:max-w-4xl flex flex-col gap-2 sm:gap-3 md:gap-4">
            <form class="space-y-4" @submit.prevent="updatePatientInfo">

                <!-- Code -->
                <div>
                    <label class="block text-sm font-medium mb-1" for="code">Patient Code</label>
                    <input type="input" name="code" id="code" class="w-full px-3 py-2 border rounded" disabled :value="patient.code">
                </div>

                <!-- Name -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1" for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="w-full px-3 py-2 border rounded" x-model="patientForm.first_name" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="middle_name">Middle Name</label>
                        <input type="text" name="middle_name" id="middle_name" class="w-full px-3 py-2 border rounded" x-model="patientForm.middle_name">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="w-full px-3 py-2 border rounded" x-model="patientForm.last_name" required>
                    </div>
                </div>

                <!-- Birthdate -->
                <div>
                    <label class="block text-sm font-medium mb-1" for="birthdate">Birthdate</label>
                    <input type="date" name="birthdate" id="birthdate" class="w-full px-3 py-2 border rounded" x-model="patientForm.birthdate" required>
                </div>

                <!-- Sex -->
                <div>
                    <label class="block text-sm font-medium mb-1">Sex</label>
                    <div class="flex gap-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="sex" value="male" class="form-radio" x-model="patientForm.sex" required>
                            <span class="ml-2">Male</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="sex" value="female" class="form-radio" x-model="patientForm.sex" required>
                            <span class="ml-2">Female</span>
                        </label>
                    </div>
                </div>

                <!-- Contact Number -->
                <div>
                    <label class="block text-sm font-medium mb-1" for="contact_number"></tex>Contact Number</label>
                    <input type="text" name="contact_number" id="contact_number" class="w-full px-3 py-2 border rounded" x-model="patientForm.contact_number" required>
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-sm font-medium mb-1" for="address">Address</label>
                    <textarea name="address" id="address" rows="3" class="w-full px-3 py-2 border rounded" x-model="patientForm.address" required></textarea>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded hover:bg-blue-700 transition">
                        Update patient information
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
        Alpine.data('user', () => ({
            patient: [],
            user: [],
            patientForm: {
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
                this.fetchUser();
            },
            fetchPatient() {
                let url = '/api/v1/patient';

                axios.get(url)
                    .then(response => {
                        this.patient = response.data;
                        
                        this.patientForm.first_name = this.patient.first_name;
                        this.patientForm.middle_name = this.patient.middle_name;
                        this.patientForm.last_name = this.patient.last_name;
                        this.patientForm.birthdate = this.patient.birthdate;
                        this.patientForm.sex = this.patient.sex;
                        this.patientForm.contact_number = this.patient.contact_number;
                        this.patientForm.address = this.patient.address;
                    });
            },
            fetchUser() {
                let url = '/api/v1/user';

                axios.get(url)
                    .then(response => {
                        this.user = response.data;
                    });
            },
            updatePatientInfo() {
                let url = `/api/v1/patients/${this.patient.id}`;

                axios.put(url, this.patientForm)
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
                            allowOutsideClick: false,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    });
            }
        }));
    });
</script>
@endpush