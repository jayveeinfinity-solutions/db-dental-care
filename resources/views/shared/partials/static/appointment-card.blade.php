
<div class="w-full md:w-80 space-y-8">
    <div class="rounded-xl p-6 bg-primary text-white shadow-xl shadow-primary/20">
        <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined">lightbulb</span>
            At-Home Tips
        </h3>
        <ul class="space-y-4 text-sm">
            <li class="flex items-start gap-3">
                <span class="material-symbols-outlined text-sm mt-1">check_circle</span>
                <span>Brush twice daily for at least two minutes with fluoride toothpaste.</span>
            </li>
            <li class="flex items-start gap-3">
                <span class="material-symbols-outlined text-sm mt-1">check_circle</span>
                <span>Floss once every day to remove debris between teeth.</span>
            </li>
            <li class="flex items-start gap-3">
                <span class="material-symbols-outlined text-sm mt-1">check_circle</span>
                <span>Limit sugary snacks and acidic drinks between meals.</span>
            </li>
            <li class="flex items-start gap-3">
                <span class="material-symbols-outlined text-sm mt-1">check_circle</span>
                <span>Replace your toothbrush every 3-4 months.</span>
            </li>
        </ul>
    </div>
    <div class="rounded-xl p-6 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
        <h3 class="text-slate-900 dark:text-slate-100 font-bold mb-3">Next Step?</h3>
        <p class="text-slate-600 dark:text-slate-400 text-sm mb-6 leading-relaxed">Regular checkups are recommended every 6 months for optimal health.</p>
        <button
            type="button"
            class="w-full bg-slate-900 dark:bg-white dark:text-slate-900 text-white font-bold py-3 rounded-lg flex items-center justify-center gap-2 transition-transform hover:scale-[1.02]"
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
            <span class="material-symbols-outlined">event</span>
            Schedule Checkup
        </button>
    </div>
</div>