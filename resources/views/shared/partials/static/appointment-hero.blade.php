<section class="px-6 md:px-20 py-20">
    <div class="max-w-6xl mx-auto rounded-2xl bg-slate-900 overflow-hidden relative">
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_top_right,var(--tw-gradient-from),transparent)] from-primary"></div>
        <div class="relative p-10 md:p-16 flex flex-col md:flex-row items-center justify-between gap-10">
            <div class="max-w-xl">
            <h2 class="text-white text-3xl md:text-4xl font-bold mb-4">Invest in your future smile today.</h2>
            <p class="text-slate-400 text-lg">Our expert team is ready to help you maintain a healthy, vibrant smile for years to come. Most preventive care is 100% covered by insurance.</p>
            </div>
            <div class="flex-shrink-0">
                <button
                    type="button"
                    class="inline-flex items-center justify-center px-8 py-4 rounded-full bg-primary text-white font-bold text-lg hover:bg-primary/90 transition-all shadow-lg shadow-primary/40"
                    x-data
                    x-on:click.prevent="
                        @auth
                            @haspatient
                                $dispatch('open-modal', 'appointment-modal')
                            @else
                                $dispatch('open-modal', 'create-patient-alt-modal')
                            @endhaspatient
                        @else
                            $dispatch('open-modal', 'authentication-modal')
                        @endauth
                    ">
                    Book Your Appointment
                </button>
            </div>
        </div>
    </div>
</section>