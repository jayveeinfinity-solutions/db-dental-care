<x-modal name="appointment-modal" :show="false" :maxWidth="'lg'">
    <div class="relative p-4 w-full max-h-full"
        x-data="{
            form: {
                service_ids: [],
                date: '',
                time: '',
            },
            servicesSearch: '',
            minDate: '{{ now()->addDay()->format('Y-m-d') }}',
            message: '',
            success: false,

            toggleService(id) {
                const numericId = parseInt(id);
                const index = this.form.service_ids.indexOf(numericId);
                if (index === -1) {
                    this.form.service_ids.push(numericId);
                } else {
                    this.form.service_ids.splice(index, 1);
                }
            },

            isServiceSelected(id) {
                return this.form.service_ids.includes(parseInt(id));
            },

            removeService(id) {
                this.form.service_ids = this.form.service_ids.filter(sId => sId !== parseInt(id));
            },

            async submit() {
                this.message = '';
                this.success = false;

                if (this.form.service_ids.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Select Service',
                        text: 'Please select at least one dental service for your appointment.',
                    });
                    return;
                }

                // Double-check date client-side
                const today = new Date().toISOString().split('T')[0];
                if (this.form.date <= today) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Invalid Date',
                        text: 'Appointments can only be booked starting tomorrow. Today and previous dates are disabled.',
                    });
                    return;
                }

                try {
                    await axios.get('/sanctum/csrf-cookie');
                    const payload = {
                        service_ids: this.form.service_ids,
                        service_id: this.form.service_ids[0], // for backward compatibility
                        date: this.form.date,
                        time: this.form.time,
                    };
                    const response = await axios.post('/api/v1/appointments', payload);
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
            }
        }"
        x-on:open-modal.window="(e) => {
            if (e.detail === 'appointment-modal' || e.detail?.name === 'appointment-modal') {
                const incomingId = e.detail?.serviceId ? parseInt(e.detail.serviceId) : null;
                if (incomingId && !form.service_ids.includes(incomingId)) {
                    form.service_ids.push(incomingId);
                }
            }
        }"
    >
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between pl-4 pb-3 md:pl-5 md:pb-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Book an appointment
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Select one or more services and your preferred date &amp; time</p>
                </div>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    x-data
                    x-on:click.prevent="$dispatch('close-modal', 'appointment-modal')">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                @if($userPendingAppointments > 0)
                    <section class="w-full flex justify-center">
                        <article class="w-full">
                            <div id="alert-1" class="flex items-center w-full p-4 text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                                <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                </svg>
                                <span class="sr-only">Info</span>
                                <div class="ms-3 text-sm font-medium">
                                    <span class="font-medium">You have a pending appointment!</span><br>Click <a class="underline" href="{{ route('user.appointments') }}">view appointment</a> to view.
                                </div>
                            </div>
                        </article>
                    </section>
                @else
                    <form class="max-w-md mx-auto space-y-4" @submit.prevent="submit">
                        <!-- Multiple Services Selector -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white">
                                    Select Services <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">(Multiple Allowed)</span>
                                </label>
                                <span class="text-xs text-gray-500 dark:text-gray-400" x-text="form.service_ids.length + ' selected'"></span>
                            </div>

                            <!-- Selected Services Badges -->
                            <div x-show="form.service_ids.length > 0" class="flex flex-wrap gap-1.5 mb-2 p-2 bg-blue-50/70 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg max-h-24 overflow-y-auto">
                                @foreach($dentalServices as $service)
                                    <template x-if="isServiceSelected({{ $service->id }})">
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-md dark:bg-blue-900 dark:text-blue-300">
                                            {{ $service->name }}
                                            <button type="button" @click="removeService({{ $service->id }})" class="ml-1 text-blue-600 hover:text-blue-900 dark:text-blue-300 dark:hover:text-white font-bold">&times;</button>
                                        </span>
                                    </template>
                                @endforeach
                            </div>

                            <!-- Services Filter & List Container -->
                            <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden bg-gray-50 dark:bg-gray-800">
                                <div class="p-2 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-700">
                                    <input 
                                        type="text" 
                                        x-model="servicesSearch" 
                                        placeholder="Search dental services..."
                                        class="w-full text-xs px-2.5 py-1.5 border border-gray-200 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 dark:bg-gray-800 dark:text-white"
                                    >
                                </div>
                                <div class="max-h-48 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-700 p-1">
                                    @php $lastCategory = ''; @endphp
                                    @foreach($dentalServices as $service)
                                        @php $currentCategory = $service->category->name ?? 'General'; @endphp
                                        @if($lastCategory !== $currentCategory)
                                            <div class="px-2 py-1 text-[11px] font-bold text-gray-500 uppercase tracking-wider bg-gray-100/80 dark:bg-gray-750 dark:text-gray-400">
                                                {{ $currentCategory }}
                                            </div>
                                            @php $lastCategory = $currentCategory; @endphp
                                        @endif
                                        <label 
                                            class="flex items-center justify-between px-2.5 py-1.5 hover:bg-blue-50 dark:hover:bg-gray-700/60 rounded cursor-pointer transition-colors"
                                            x-show="!servicesSearch || '{{ strtolower(addslashes($service->name)) }}'.includes(servicesSearch.toLowerCase()) || '{{ strtolower(addslashes($currentCategory)) }}'.includes(servicesSearch.toLowerCase())"
                                        >
                                            <div class="flex items-center gap-2">
                                                <input 
                                                    type="checkbox" 
                                                    :checked="isServiceSelected({{ $service->id }})" 
                                                    @change="toggleService({{ $service->id }})"
                                                    class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
                                                >
                                                <span class="text-xs text-gray-800 dark:text-gray-200 font-medium">{{ $service->name }}</span>
                                            </div>
                                            <span class="text-[11px] text-gray-500 dark:text-gray-400">
                                                PHP {{ number_format($service->price_min) }}
                                                @if($service->price_min !== $service->price_max)
                                                    - {{ number_format($service->price_max) }}
                                                @endif
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Date input with today and previous dates disabled -->
                        <div>
                            <label for="date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                                Appointment Date <span class="text-xs text-slate-500 font-normal">(Tomorrow or later)</span>
                            </label>
                            <input 
                                type="date" 
                                id="date" 
                                x-model="form.date" 
                                min="{{ now()->addDay()->format('Y-m-d') }}"
                                :min="minDate"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light" 
                                required
                            />
                            <p class="mt-1 text-[11px] text-slate-500 dark:text-slate-400">
                                Today and previous dates are disabled. Please choose a future date.
                            </p>
                        </div>

                        <!-- Time slot divisible by 30 minutes -->
                        <div>
                            <label class="block mb-1 text-sm font-semibold text-gray-900 dark:text-white">Select Time</label>
                            <select 
                                x-model="form.time" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required
                            >
                                <option value="" selected disabled>-- Select Time Slot --</option>
                                @foreach($times as $time)
                                    <option value="{{ $time['value'] }}">{{ $time['text'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button 
                            type="submit" 
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-all shadow-md hover:shadow-lg"
                        >
                            Book Appointment
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-modal>