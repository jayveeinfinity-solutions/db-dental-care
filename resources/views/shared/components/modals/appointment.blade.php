<x-modal name="appointment-modal" :show="false" :maxWidth="'lg'">
    <div class="relative p-4 w-full max-h-full"
        x-data="{
            isServiceLocked: false,
            todayDate: new Date().toISOString().split('T')[0],
            form: {
                service_ids: [],
                date: '',
                time: '',
                notes: ''
            },
            allServices: {{ $dentalServices->toJson() }},
            availableSlots: [],
            isLoadingSlots: false,
            totalDuration: 0,
            estimatedPriceRange: '',
            message: '',
            success: false,
            searchQuery: '',

            init() {
                this.form.date = this.todayDate;
                this.$watch('form.service_ids', () => {
                    this.updateCalculations();
                    if (this.form.date) {
                        this.fetchAvailableSlots();
                    }
                });
                this.$watch('form.date', () => {
                    if (this.form.date) {
                        this.fetchAvailableSlots();
                    }
                });
            },

            updateCalculations() {
                const selected = this.allServices.filter(s => this.form.service_ids.includes(s.id));
                
                // Calculate duration
                let duration = 0;
                let minPrice = 0;
                let maxPrice = 0;

                selected.forEach(s => {
                    let d = s.duration_minutes;
                    if (!d) {
                        if (s.name.toLowerCase().includes('consultation')) d = 10;
                        else if (s.name.toLowerCase().includes('extraction')) d = s.name.toLowerCase().includes('complicated') ? 60 : 30;
                        else d = 30;
                    }
                    duration += Number(d);
                    minPrice += Number(s.price_min || 0);
                    maxPrice += Number(s.price_max || s.price_min || 0);
                });

                this.totalDuration = Math.max(15, duration);

                if (selected.length > 0) {
                    if (minPrice === maxPrice) {
                        this.estimatedPriceRange = 'PHP ' + minPrice.toLocaleString();
                    } else {
                        this.estimatedPriceRange = 'PHP ' + minPrice.toLocaleString() + ' - ' + maxPrice.toLocaleString();
                    }
                } else {
                    this.estimatedPriceRange = '';
                }
            },

            toggleService(id) {
                const numId = Number(id);
                const index = this.form.service_ids.indexOf(numId);
                if (index > -1) {
                    this.form.service_ids.splice(index, 1);
                } else {
                    this.form.service_ids.push(numId);
                }
            },

            isServiceSelected(id) {
                return this.form.service_ids.includes(Number(id));
            },

            async fetchAvailableSlots() {
                if (!this.form.date) return;
                this.isLoadingSlots = true;
                this.form.time = ''; // Reset selected time on change

                try {
                    const params = {
                        date: this.form.date,
                        service_ids: this.form.service_ids.join(','),
                        duration: this.totalDuration || 30
                    };
                    const res = await axios.get('/api/v1/appointments/available-slots', { params });
                    this.availableSlots = res.data.slots || [];
                } catch (error) {
                    console.error('Failed to fetch slots:', error);
                    this.availableSlots = [];
                } finally {
                    this.isLoadingSlots = false;
                }
            },

            async submit() {
                if (this.form.service_ids.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Select a Service',
                        text: 'Please select at least one dental service for your appointment.'
                    });
                    return;
                }

                if (!this.form.time) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Select Time',
                        text: 'Please select an available time slot.'
                    });
                    return;
                }

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
                        timerProgressBar: true,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '/appointments';
                    });

                    setTimeout(() => {
                        this.$dispatch('close-modal', 'appointment-modal');
                    }, 500);

                    this.form.service_ids = [];
                    this.form.date = this.todayDate;
                    this.form.time = '';
                    this.form.notes = '';
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
            if (e.detail.name === 'appointment-modal') {
                show = true;
                if (e.detail.serviceId) {
                    form.service_ids = [Number(e.detail.serviceId)];
                }
                if (!form.date) {
                    form.date = todayDate;
                }
                updateCalculations();
                fetchAvailableSlots();
            }
        }"
    >
        <!-- Modal content -->
        <div class="relative bg-white rounded-xl shadow-xl dark:bg-gray-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-700 border-gray-100">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        Book an Appointment
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        Select one or more services and choose your preferred schedule
                    </p>
                </div>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-700 dark:hover:text-white"
                    x-data
                    x-on:click.prevent="$dispatch('close-modal', 'appointment-modal')">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4 max-h-[80vh] overflow-y-auto">
                @if($userPendingAppointments > 0)
                    <section class="w-full flex justify-center">
                        <article class="w-full">
                            <div id="alert-1" class="flex items-center w-full p-4 text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 border border-blue-200 dark:border-blue-900" role="alert">
                                <svg class="shrink-0 w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                </svg>
                                <span class="sr-only">Info</span>
                                <div class="ms-3 text-sm font-medium">
                                    <span class="font-bold">You currently have a pending appointment!</span><br>
                                    Please click <a class="underline font-bold hover:text-blue-900" href="{{ route('user.appointments') }}">View Appointments</a> to check your booking status.
                                </div>
                            </div>
                        </article>
                    </section>
                @else
                    <form class="space-y-5" @submit.prevent="submit">
                        <!-- SECTION: Service Selection (Multiple Services Checkbox List) -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-bold text-gray-900 dark:text-white">
                                    Select Services <span class="text-red-500">*</span>
                                </label>
                                <span class="text-xs font-semibold px-2 py-0.5 bg-blue-50 text-blue-700 dark:bg-blue-950 dark:text-blue-300 rounded-full"
                                      x-show="form.service_ids.length > 0"
                                      x-text="form.service_ids.length + ' selected'"></span>
                            </div>

                            <!-- Search service box -->
                            <div class="relative mb-2">
                                <input type="text"
                                    x-model="searchQuery"
                                    placeholder="Filter services by name..."
                                    class="w-full text-xs px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                >
                            </div>

                            <!-- Checkbox List Container -->
                            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-3 max-h-56 overflow-y-auto space-y-3 bg-gray-50/50 dark:bg-gray-700/50">
                                @php
                                    $groupedServices = $dentalServices->groupBy(fn($s) => $s->category->name ?? 'General');
                                @endphp

                                @foreach($groupedServices as $categoryName => $services)
                                    <div>
                                        <h5 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5 pb-1 border-b border-gray-200 dark:border-gray-600">
                                            {{ $categoryName }}
                                        </h5>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                            @foreach($services as $service)
                                                <label 
                                                    class="flex items-start p-2 rounded-lg cursor-pointer transition-colors hover:bg-white dark:hover:bg-gray-600 border border-transparent"
                                                    :class="isServiceSelected({{ $service->id }}) ? 'bg-blue-50/80 border-blue-300 dark:bg-blue-900/30 dark:border-blue-700' : ''"
                                                    x-show="!searchQuery || '{{ strtolower($service->name) }}'.includes(searchQuery.toLowerCase())"
                                                >
                                                    <input type="checkbox"
                                                        value="{{ $service->id }}"
                                                        :checked="isServiceSelected({{ $service->id }})"
                                                        @change="toggleService({{ $service->id }})"
                                                        class="w-4 h-4 mt-0.5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                    >
                                                    <div class="ms-2 text-xs">
                                                        <div class="font-medium text-gray-800 dark:text-gray-200 leading-tight">
                                                            {{ $service->name }}
                                                        </div>
                                                        <div class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">
                                                            @if($service->price_min)
                                                                PHP {{ number_format($service->price_min) }}@if($service->price_max && $service->price_max != $service->price_min) - {{ number_format($service->price_max) }}@endif
                                                            @endif
                                                            • {{ $service->duration_minutes ?? 30 }}m
                                                        </div>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Duration & Cost Summary Pill -->
                            <div x-show="form.service_ids.length > 0" class="mt-2.5 p-2.5 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg flex items-center justify-between text-xs">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-blue-600 text-white">
                                        <i class="fa-solid fa-clock mr-1"></i>
                                        Est. Duration: <span class="ml-1" x-text="totalDuration + ' mins'"></span>
                                    </span>
                                </div>
                                <div class="font-semibold text-blue-900 dark:text-blue-300" x-show="estimatedPriceRange">
                                    Est. Cost: <span x-text="estimatedPriceRange"></span>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION: Date Selection (Disables Past Dates) -->
                        <div>
                            <label for="date" class="block mb-1.5 text-sm font-bold text-gray-900 dark:text-white">
                                Appointment Date <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="date" 
                                id="date" 
                                x-model="form.date"
                                :min="todayDate"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                required
                            />
                            <p class="text-[11px] text-gray-500 mt-1">Past dates cannot be selected.</p>
                        </div>

                        <!-- SECTION: Time Slot Picker (Disables Booked & Past Times) -->
                        <div>
                            <div class="flex justify-between items-center mb-1.5">
                                <label class="block text-sm font-bold text-gray-900 dark:text-white">
                                    Available Time Slot <span class="text-red-500">*</span>
                                </label>
                                <span x-show="isLoadingSlots" class="text-xs text-blue-600 animate-pulse">
                                    Checking availability...
                                </span>
                            </div>

                            <select 
                                x-model="form.time" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                :disabled="isLoadingSlots || availableSlots.length === 0"
                                required
                            >
                                <option value="" selected disabled>-- Select an available time slot --</option>
                                <template x-for="slot in availableSlots" :key="slot.value">
                                    <option 
                                        :value="slot.value"
                                        :disabled="!slot.available"
                                        :class="!slot.available ? 'text-gray-400 bg-gray-100 dark:bg-gray-800' : 'text-gray-900 font-medium'"
                                        x-text="slot.text + (!slot.available ? (slot.reason === 'past_time' ? ' (Passed)' : (slot.reason === 'booked' ? ' (Already Booked)' : ' (Not enough time)')) : ' (Available)')"
                                    ></option>
                                </template>
                            </select>
                            <p class="text-[11px] text-gray-500 mt-1">
                                Times are evaluated based on consecutive free slots to cover your full <span class="font-semibold" x-text="totalDuration"></span>-minute appointment.
                            </p>
                        </div>

                        <!-- Notes (Optional) -->
                        <div>
                            <label for="notes" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Additional Notes (Optional)</label>
                            <textarea id="notes" x-model="form.notes" rows="2" placeholder="Any specific dental concerns or preferences..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" 
                                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors shadow-md"
                                :disabled="form.service_ids.length === 0 || !form.time">
                                Confirm & Book Appointment
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-modal>