@extends('layouts.base')

@section('title', 'Services &sdots; ')

@section('content')
<main class="border-t border-slate-200 dark:border-slate-800">
    <!-- Hero Section -->
    <section class="relative py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="grid lg:grid-cols-2 gap-12 items-center">
    <div>
    <span class="inline-block px-4 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider mb-4">Established 2025</span>
    <h2 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6">Redefining the <span class="text-primary">Modern Dental Experience</span></h2>
    <p class="text-lg text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">
        For over 25 years, DentalCare Pro has been at the forefront of clinical excellence. We believe that a healthy smile is the foundation of overall wellness, and we're committed to delivering it with compassion and precision.
    </p>
    <div class="flex gap-4">
    <div class="flex items-center gap-2">
    <span class="material-symbols-outlined text-primary">verified_user</span>
    <span class="font-semibold">Certified Experts</span>
    </div>
    <div class="flex items-center gap-2">
    <span class="material-symbols-outlined text-primary">favorite</span>
    <span class="font-semibold">Patient-First Care</span>
    </div>
    </div>
    </div>
    <div class="relative">
    <div class="aspect-square rounded-2xl overflow-hidden shadow-2xl bg-slate-200 dark:bg-slate-800" data-alt="Modern dental office with bright windows and comfortable chairs"
        style="background-image: url('{{ config('r2.endpoint') }}/images/bg/1.jpg'); background-size: cover; background-position: center;">
    </div>
    <div class="absolute -bottom-6 -left-6 bg-white dark:bg-slate-800 p-6 rounded-xl shadow-xl border border-primary/10 hidden md:block">
    <p class="text-3xl font-bold text-primary">15k+</p>
    <p class="text-sm font-medium text-slate-500">Happy Patients</p>
    </div>
    </div>
    </div>
    </div>
    <div class="absolute top-0 right-0 -z-0 opacity-10 dark:opacity-5">
    <span class="material-symbols-outlined text-[400px] text-primary select-none">dentistry</span>
    </div>
    </section>
    <!-- Mission & History -->
    <section class="py-24 bg-white dark:bg-slate-900/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid md:grid-cols-3 gap-12">
    <div class="space-y-4">
    <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary mb-6">
    <span class="material-symbols-outlined text-3xl">history</span>
    </div>
    <h3 class="text-2xl font-bold">Our Journey</h3>
    <p class="text-slate-600 dark:text-slate-400">Starting as a small family practice, we've grown into a state-of-the-art facility without losing our personal touch and community values.</p>
    </div>
    <div class="space-y-4">
    <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary mb-6">
    <span class="material-symbols-outlined text-3xl">target</span>
    </div>
    <h3 class="text-2xl font-bold">Our Mission</h3>
    <p class="text-slate-600 dark:text-slate-400">To provide exceptional, comprehensive dental care in a warm environment, utilizing the latest innovations to ensure lasting oral health.</p>
    </div>
    <div class="space-y-4">
    <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary mb-6">
    <span class="material-symbols-outlined text-3xl">handshake</span>
    </div>
    <h3 class="text-2xl font-bold">Our Commitment</h3>
    <p class="text-slate-600 dark:text-slate-400">We treat every patient like family, prioritizing comfort, transparency, and personalized treatment plans for every age.</p>
    </div>
    </div>
    </div>
    </section>
    <!-- Technology Section -->
    <section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-primary rounded-3xl overflow-hidden shadow-2xl flex flex-col lg:flex-row">
    <div class="lg:w-1/2 p-12 lg:p-20 text-white flex flex-col justify-center">
    <h2 class="text-3xl md:text-4xl font-extrabold mb-6 leading-tight">Advanced Technology for Better Outcomes</h2>
    <p class="text-white/80 text-lg mb-8">
                                We invest in the latest dental innovations to make your visits faster, more comfortable, and incredibly precise. From 3D imaging to laser dentistry, we provide the future of oral care today.
                            </p>
    <ul class="space-y-4">
    <li class="flex items-center gap-3">
    <span class="material-symbols-outlined text-white/60">check_circle</span>
    <span>Digital 3D Intraoral Scanning</span>
    </li>
    <li class="flex items-center gap-3">
    <span class="material-symbols-outlined text-white/60">check_circle</span>
    <span>Low-Radiation Digital X-Rays</span>
    </li>
    <li class="flex items-center gap-3">
    <span class="material-symbols-outlined text-white/60">check_circle</span>
    <span>Advanced Laser Gum Therapy</span>
    </li>
    </ul>
    </div>
    <div class="lg:w-1/2 min-h-[400px] relative bg-slate-100" data-alt="Close up of high tech dental imaging equipment" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAFaTrUBGFFyJxw8q38NSFYChAvHXOaZiKwxTg7aIMRNSeq8vncqTz5Z0u9kiDdtd9feXYWGHGkcavgUKKnNPISCG7F527BuRHxPzcDOox7-4s5pmmAVZKNEyRugjzZEPIyiXb8d-rSR-tsaum1AgDy_GS-_E0dN4W1rVrtoo9y6fUZ-LzLOcRuVutw7gOe7XtD7791Cqu9l-GzP1j1UJe0dnYTWH1zy7nS89A0X9WBuxBzymFfm0-ihPcY914obD2Ymo8XOFhzD3wm'); background-size: cover; background-position: center;">
    </div>
    </div>
    </div>
    </section>
    <!-- Team Section -->
    <!-- <section class="py-24 bg-white dark:bg-slate-900/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-4xl font-extrabold mb-4">Meet Our Experts</h2>
            <p class="text-slate-600 dark:text-slate-400 text-lg">Our team of highly skilled professionals is dedicated to making your dental experience comfortable and stress-free.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="group">
            <div class="aspect-[4/5] rounded-2xl overflow-hidden mb-4 bg-slate-200 dark:bg-slate-800 transition-transform duration-300 group-hover:-translate-y-2 shadow-lg" data-alt="Portrait of a smiling male dentist in blue scrubs" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBWg5KFOa2BV7U7WnmFoF2pOivAU3gu7xlcD6qBJqBrnDMzYW3eprRWuP2iuHv_8hxhcznwQtN8fLRfzOyV57MsmPQUVawUlZIf9RdmwUsdHov674oJHt4mywcP_QDktQz2XiClHro7fesHTPhhaU4W4A9xCINVHHc0CjbXnJKSpINRrHNk_SBGgPHs-2AeHOXkkxJZtZAsLpiHpP6PZy7ao_FBNIZ-mv11MzkkGQl0ELAM6CU2FcAo-7asusPcjO7EGdCcsPYqyqnk'); background-size: cover; background-position: center;">
            </div>
            <h4 class="text-xl font-bold">Dr. James Wilson</h4>
            <p class="text-primary font-semibold text-sm mb-2">Lead Dentist / Founder</p>
            <p class="text-slate-500 text-sm leading-relaxed">Specializing in restorative dentistry with over 20 years of experience.</p>
            </div>
            <div class="group">
            <div class="aspect-[4/5] rounded-2xl overflow-hidden mb-4 bg-slate-200 dark:bg-slate-800 transition-transform duration-300 group-hover:-translate-y-2 shadow-lg" data-alt="Portrait of a smiling female dentist with glasses" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCKiCIUpj2HrhhVQZVUMnhnl9xH-O0lxrhEEMbXlLbe0PX_avrsnqSiO1ABTIO_O1fRCT0wvAx6-b6TXxH91XmLfQOXC7X9GJGjDJMpVULxIyp7gcoaNAnV9h6Uep6JpuGtrySIJHDPVWJ96keahSnHi0jbkb3AtIlVF4_8W17ZUh1hOPcDyFXggbnbqmiZGsuT9BJWXoUmGds8zpJZebHcpvoDI0tvOQ81EppnayOgCQdBY_v2Qw8quse4e-HOjAbsDaHCmKjU4Xgg'); background-size: cover; background-position: center;">
            </div>
            <h4 class="text-xl font-bold">Dr. Elena Rodriguez</h4>
            <p class="text-primary font-semibold text-sm mb-2">Orthodontist</p>
            <p class="text-slate-500 text-sm leading-relaxed">Passionate about creating perfect smiles through modern alignment technology.</p>
            </div>
            <div class="group">
            <div class="aspect-[4/5] rounded-2xl overflow-hidden mb-4 bg-slate-200 dark:bg-slate-800 transition-transform duration-300 group-hover:-translate-y-2 shadow-lg" data-alt="Portrait of a friendly dental hygienist" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBLvmwfqrha-k9-zFYtr3y45WoibVIdgyoZF6889FvtvQn9FQbe9EPjOodu6ap3PEmfYstfNBj-Fu6zOO5Mt5k0oVzr-Gh_jJ9NKIW5AE9vaB18PGkmpe6OyOohX-q8Glzrm65bTrkWDajm_Gb4tZYvqnGC78QvfBAna8KbL3BgdrGbaweSR60f5n2zTOixNSdDijkz35oqDj5bEZuEvt8zz8nIGcBfIHSoKMMMwPDYvFr0wyILQubm9v_ZCV6OmKOouUsVx9ivyc3G'); background-size: cover; background-position: center;">
            </div>
            <h4 class="text-xl font-bold">Sarah Jenkins</h4>
            <p class="text-primary font-semibold text-sm mb-2">Lead Hygienist</p>
            <p class="text-slate-500 text-sm leading-relaxed">Ensuring every patient leaves with a bright, healthy, and clean smile.</p>
            </div>
            <div class="group">
            <div class="aspect-[4/5] rounded-2xl overflow-hidden mb-4 bg-slate-200 dark:bg-slate-800 transition-transform duration-300 group-hover:-translate-y-2 shadow-lg" data-alt="Portrait of a young male dental specialist" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBAsro1_20pPda4vjT-NjTzkBAEXK4Yk4x_zdFv4piXwtqlkHlurQ1HbihXnxdDry5h6YZlbSd0frvrXsMI9t4nBw8u_Por1sJgAKQUrbksbdiOS6B0B_gzd8GKsxPDG6xplp5-Iv-BAfZi_RfhqDQa8BPsuRnYRLjQ368ECdOZuxYRbEae6rZt3AY5ojGQ1-mQ0upQcZj5pvpIq2ZY8AnlbwQe52Dp7ZIvPaDHE7LDBIOSCoIsjveTWAVv-3jozupVmC1lyxfZYxZ8'); background-size: cover; background-position: center;">
            </div>
            <h4 class="text-xl font-bold">Michael Chen</h4>
            <p class="text-primary font-semibold text-sm mb-2">Dental Specialist</p>
            <p class="text-slate-500 text-sm leading-relaxed">Expert in patient comfort and preventive care education.</p>
            </div>
            </div>
        </div>
    </section> -->
    <!-- CTA Section -->
    <section class="py-20">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-extrabold mb-6">Ready for a Better Dental Experience?</h2>
            <p class="text-slate-600 dark:text-slate-400 text-lg mb-10">We are currently accepting new patients! Join the thousands of families who trust DentalCare Pro.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button
                class="bg-primary text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-primary/90 transition-all shadow-xl shadow-primary/20"
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
                Schedule Your Visit
            </button>
            <a class="bg-white dark:bg-slate-800 border-2 border-primary/20 px-8 py-4 rounded-xl font-bold text-lg hover:border-primary transition-all" href="{{ route('services') }}">
                View Our Services
            </a>
            </div>
        </div>
    </section>
</main>

<!-- Appointment Modal -->
@include('shared.components.modals.create-patient-alt')
@include('shared.components.modals.appointment')
@endsection