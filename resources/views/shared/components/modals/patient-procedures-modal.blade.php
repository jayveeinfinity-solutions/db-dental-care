<div 
    x-data="patientProceduresModal()"
    x-cloak
    @open-patient-procedures.window="open($event.detail)"
    @close-patient-procedures.window="show = false"
    class="custom-modal-wrapper"
>
    <!-- BACKDROP -->
    <div x-show="show" x-transition.opacity.duration.300ms class="custom-modal-backdrop" x-on:click="close()"></div>

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
        <div class="custom-modal-box max-w-4xl w-full bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-100 dark:border-gray-700 flex flex-col max-h-[90vh]">

            <!-- HEADER -->
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 text-white flex justify-between items-center">
                <div>
                    <div class="flex items-center gap-3">
                        <h2 class="text-lg font-bold">Patient Procedure & Treatment Records</h2>
                        <span class="px-2 py-0.5 bg-white/20 text-white text-xs font-mono font-bold rounded-full" x-text="patient?.code"></span>
                    </div>
                    <p class="text-xs text-blue-100 mt-0.5" x-text="patient?.full_name || patient?.name"></p>
                </div>
                <button type="button" x-on:click="close()" class="text-white/80 hover:text-white text-2xl font-light">&times;</button>
            </div>

            <!-- BODY (SCROLLABLE) -->
            <div class="p-6 overflow-y-auto space-y-6 flex-1">

                <!-- TABS: 1) Procedure History, 2) Log New Procedure & Dental Chart -->
                <div class="flex border-b border-gray-200 dark:border-gray-700">
                    <button type="button" 
                        @click="activeTab = 'history'" 
                        :class="activeTab === 'history' ? 'border-b-2 border-blue-600 text-blue-600 font-bold' : 'text-gray-500 hover:text-gray-700'"
                        class="py-2.5 px-4 text-sm font-medium transition-colors">
                        <i class="fa-solid fa-clock-rotate-left mr-1.5"></i>
                        Procedure History (<span x-text="procedures.length"></span>)
                    </button>
                    <button type="button" 
                        @click="activeTab = 'log'" 
                        :class="activeTab === 'log' ? 'border-b-2 border-blue-600 text-blue-600 font-bold' : 'text-gray-500 hover:text-gray-700'"
                        class="py-2.5 px-4 text-sm font-medium transition-colors">
                        <i class="fa-solid fa-plus-circle mr-1.5"></i>
                        Log New Procedure & Dental Chart
                    </button>
                </div>

                <!-- TAB 1: PROCEDURE HISTORY TABLE -->
                <div x-show="activeTab === 'history'" class="space-y-4">
                    <div class="flex justify-between items-center">
                        <h4 class="text-sm font-bold text-gray-800 dark:text-white">Historical Consultations & Treatments</h4>
                        <button type="button" @click="activeTab = 'log'" class="text-xs px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition-colors">
                            + Add Procedure Record
                        </button>
                    </div>

                    <div x-show="isLoading" class="text-center py-8 text-slate-400">
                        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
                        <p class="text-xs">Loading procedure records...</p>
                    </div>

                    <div x-show="!isLoading && procedures.length === 0" class="text-center py-12 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-dashed border-gray-300 dark:border-gray-600">
                        <i class="fa-solid fa-tooth text-3xl text-gray-300 dark:text-gray-500 mb-2"></i>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">No procedures recorded yet for this patient.</p>
                        <p class="text-xs text-gray-400 mt-1">Use the "Log New Procedure" tab to record treatments with exact tooth target specifics and medical history.</p>
                    </div>

                    <div x-show="!isLoading && procedures.length > 0" class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="w-full text-left text-xs text-gray-600 dark:text-gray-300">
                            <thead class="bg-gray-100 dark:bg-gray-700/80 text-gray-700 dark:text-gray-200 uppercase font-semibold text-[11px]">
                                <tr>
                                    <th class="px-4 py-3">Date</th>
                                    <th class="px-4 py-3">Procedure Performed</th>
                                    <th class="px-4 py-3">Target Specifics / Tooth</th>
                                    <th class="px-4 py-3 text-right">Amount</th>
                                    <th class="px-4 py-3">Medical History / Notes</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                <template x-for="item in procedures" :key="item.id">
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white whitespace-nowrap" x-text="item.formatted_date || item.procedure_date"></td>
                                        <td class="px-4 py-3 font-medium text-gray-800 dark:text-gray-100">
                                            <div class="font-bold text-blue-600 dark:text-blue-400" x-text="item.procedure_name"></div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-indigo-50 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300" x-text="item.target_specifics || ('Tooth #' + (item.tooth_number || 'General'))"></span>
                                        </td>
                                        <td class="px-4 py-3 text-right font-mono font-bold text-gray-900 dark:text-white whitespace-nowrap" x-text="'PHP ' + Number(item.amount).toLocaleString(undefined, {minimumFractionDigits: 2})"></td>
                                        <td class="px-4 py-3 max-w-xs truncate" :title="item.medical_history" x-text="item.medical_history || 'None recorded'"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 2: LOG NEW PROCEDURE & EXTENSIBLE DENTAL CHART -->
                <div x-show="activeTab === 'log'" class="space-y-6">

                    <!-- EXTENSIBLE DENTAL CHART INTEGRATION -->
                    <div class="p-4 bg-slate-50 dark:bg-gray-700/60 rounded-xl border border-slate-200 dark:border-gray-600">
                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-200">
                                    <i class="fa-solid fa-teeth-open text-blue-600 mr-1.5"></i>
                                    Interactive Adult Dental Chart (Universal 1 - 32)
                                </h4>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                    Click any tooth to automatically set target specifics and view history on that tooth.
                                </p>
                            </div>
                            <div class="flex items-center gap-2 text-[11px]">
                                <span class="inline-block w-3 h-3 bg-blue-600 rounded-sm"></span> Selected
                                <span class="inline-block w-3 h-3 bg-amber-400 rounded-sm ml-2"></span> Treated Tooth
                            </div>
                        </div>

                        <!-- Upper Arch (Teeth 1-16) -->
                        <div class="mb-3">
                            <div class="text-[10px] font-bold text-center uppercase tracking-widest text-slate-400 mb-1">
                                Upper Arch (Maxillary) &bull; Right to Left
                            </div>
                            <div class="flex justify-center gap-1 flex-wrap">
                                <template x-for="t in upperTeeth" :key="t.num">
                                    <button type="button"
                                        @click="selectTooth(t)"
                                        :title="t.num + ': ' + t.name"
                                        class="w-7 h-10 sm:w-8 sm:h-11 rounded border text-[11px] font-bold flex flex-col items-center justify-between py-1 transition-all"
                                        :class="newProcedure.tooth_number === t.num.toString() 
                                            ? 'bg-blue-600 text-white border-blue-700 shadow-md scale-105' 
                                            : (hasToothHistory(t.num) 
                                                ? 'bg-amber-100 text-amber-900 border-amber-300 dark:bg-amber-900/40 dark:text-amber-200' 
                                                : 'bg-white text-slate-700 border-slate-300 hover:bg-blue-50 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600')"
                                    >
                                        <span class="text-[9px] opacity-70" x-text="t.short"></span>
                                        <span x-text="t.num"></span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <!-- Lower Arch (Teeth 17-32) -->
                        <div>
                            <div class="flex justify-center gap-1 flex-wrap">
                                <template x-for="t in lowerTeeth" :key="t.num">
                                    <button type="button"
                                        @click="selectTooth(t)"
                                        :title="t.num + ': ' + t.name"
                                        class="w-7 h-10 sm:w-8 sm:h-11 rounded border text-[11px] font-bold flex flex-col items-center justify-between py-1 transition-all"
                                        :class="newProcedure.tooth_number === t.num.toString() 
                                            ? 'bg-blue-600 text-white border-blue-700 shadow-md scale-105' 
                                            : (hasToothHistory(t.num) 
                                                ? 'bg-amber-100 text-amber-900 border-amber-300 dark:bg-amber-900/40 dark:text-amber-200' 
                                                : 'bg-white text-slate-700 border-slate-300 hover:bg-blue-50 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600')"
                                    >
                                        <span x-text="t.num"></span>
                                        <span class="text-[9px] opacity-70" x-text="t.short"></span>
                                    </button>
                                </template>
                            </div>
                            <div class="text-[10px] font-bold text-center uppercase tracking-widest text-slate-400 mt-1">
                                Lower Arch (Mandibular) &bull; Left to Right
                            </div>
                        </div>
                    </div>

                    <!-- PROCEDURE LOGGING FORM -->
                    <form @submit.prevent="submitProcedure" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Date of the procedure -->
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-700 dark:text-gray-300 mb-1">
                                    Date of Procedure <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                    x-model="newProcedure.procedure_date" 
                                    class="w-full text-sm p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required>
                            </div>

                            <!-- Amount / Cost of the procedure -->
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-700 dark:text-gray-300 mb-1">
                                    Amount / Cost (PHP) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                    step="0.01"
                                    min="0"
                                    x-model="newProcedure.amount" 
                                    placeholder="e.g. 1500.00"
                                    class="w-full text-sm p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Specific procedure performed -->
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-700 dark:text-gray-300 mb-1">
                                    Specific Procedure Performed <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                    x-model="newProcedure.procedure_name" 
                                    placeholder="e.g. Simple Extraction, Composite Filling, Scaling"
                                    list="procedures-list"
                                    class="w-full text-sm p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required>
                                <datalist id="procedures-list">
                                    <option value="Consultation"></option>
                                    <option value="Simple Extraction"></option>
                                    <option value="Complicated Extraction"></option>
                                    <option value="Composite Filling (Per Surface)"></option>
                                    <option value="Temporary Filling"></option>
                                    <option value="Oral Prophylaxis (Moderate)"></option>
                                    <option value="Topical Fluoride"></option>
                                    <option value="Endodontics"></option>
                                    <option value="Jacket Crown"></option>
                                    <option value="Dental Certificate"></option>
                                </datalist>
                            </div>

                            <!-- Target specifics (e.g. exact tooth extracted or filled) -->
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-700 dark:text-gray-300 mb-1">
                                    Target Specifics (e.g., exact tooth, quadrant, surface) <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                    x-model="newProcedure.target_specifics" 
                                    placeholder="e.g. Tooth #14 (Upper Left First Molar) - Occlusal"
                                    class="w-full text-sm p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required>
                            </div>
                        </div>

                        <!-- Specific medical history per procedure -->
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-700 dark:text-gray-300 mb-1">
                                Clinical Notes & Specific Medical History for Procedure
                            </label>
                            <textarea 
                                x-model="newProcedure.medical_history" 
                                rows="3" 
                                placeholder="Patient anesthesia tolerance, pre-existing conditions, specific post-op advice, complications..."
                                class="w-full text-sm p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            ></textarea>
                        </div>

                        <div class="flex justify-end gap-3 pt-2">
                            <button type="button" @click="activeTab = 'history'" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 dark:text-gray-300">
                                Cancel
                            </button>
                            <button type="submit" 
                                :disabled="isSaving"
                                class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-sm transition-colors shadow-sm disabled:opacity-50">
                                <span x-show="!isSaving">Save Procedure Record</span>
                                <span x-show="isSaving">Saving...</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <button type="button" x-on:click="close()" class="px-4 py-2 bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 rounded-lg text-xs font-semibold">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('patientProceduresModal', () => ({
        show: false,
        activeTab: 'history',
        patient: null,
        procedures: [],
        isLoading: false,
        isSaving: false,

        newProcedure: {
            procedure_date: new Date().toISOString().split('T')[0],
            procedure_name: '',
            tooth_number: '',
            target_specifics: '',
            amount: '',
            medical_history: ''
        },

        // Universal 32-teeth numbering system with tooth type metadata
        upperTeeth: [
            { num: 1,  short: 'M3', name: 'Upper Right 3rd Molar (Wisdom)' },
            { num: 2,  short: 'M2', name: 'Upper Right 2nd Molar' },
            { num: 3,  short: 'M1', name: 'Upper Right 1st Molar' },
            { num: 4,  short: 'P2', name: 'Upper Right 2nd Premolar' },
            { num: 5,  short: 'P1', name: 'Upper Right 1st Premolar' },
            { num: 6,  short: 'C',  name: 'Upper Right Canine' },
            { num: 7,  short: 'I2', name: 'Upper Right Lateral Incisor' },
            { num: 8,  short: 'I1', name: 'Upper Right Central Incisor' },
            { num: 9,  short: 'I1', name: 'Upper Left Central Incisor' },
            { num: 10, short: 'I2', name: 'Upper Left Lateral Incisor' },
            { num: 11, short: 'C',  name: 'Upper Left Canine' },
            { num: 12, short: 'P1', name: 'Upper Left 1st Premolar' },
            { num: 13, short: 'P2', name: 'Upper Left 2nd Premolar' },
            { num: 14, short: 'M1', name: 'Upper Left 1st Molar' },
            { num: 15, short: 'M2', name: 'Upper Left 2nd Molar' },
            { num: 16, short: 'M3', name: 'Upper Left 3rd Molar (Wisdom)' },
        ],

        lowerTeeth: [
            { num: 32, short: 'M3', name: 'Lower Right 3rd Molar (Wisdom)' },
            { num: 31, short: 'M2', name: 'Lower Right 2nd Molar' },
            { num: 30, short: 'M1', name: 'Lower Right 1st Molar' },
            { num: 29, short: 'P2', name: 'Lower Right 2nd Premolar' },
            { num: 28, short: 'P1', name: 'Lower Right 1st Premolar' },
            { num: 27, short: 'C',  name: 'Lower Right Canine' },
            { num: 26, short: 'I2', name: 'Lower Right Lateral Incisor' },
            { num: 25, short: 'I1', name: 'Lower Right Central Incisor' },
            { num: 24, short: 'I1', name: 'Lower Left Central Incisor' },
            { num: 23, short: 'I2', name: 'Lower Left Lateral Incisor' },
            { num: 22, short: 'C',  name: 'Lower Left Canine' },
            { num: 21, short: 'P1', name: 'Lower Left 1st Premolar' },
            { num: 20, short: 'P2', name: 'Lower Left 2nd Premolar' },
            { num: 19, short: 'M1', name: 'Lower Left 1st Molar' },
            { num: 18, short: 'M2', name: 'Lower Left 2nd Molar' },
            { num: 17, short: 'M3', name: 'Lower Left 3rd Molar (Wisdom)' },
        ],

        open(patient) {
            this.patient = patient;
            this.show = true;
            this.activeTab = 'history';
            this.resetForm();
            this.fetchProcedures();
        },

        close() {
            this.show = false;
        },

        resetForm() {
            this.newProcedure = {
                procedure_date: new Date().toISOString().split('T')[0],
                procedure_name: '',
                tooth_number: '',
                target_specifics: '',
                amount: '',
                medical_history: ''
            };
        },

        selectTooth(t) {
            this.newProcedure.tooth_number = t.num.toString();
            this.newProcedure.target_specifics = `Tooth #${t.num} (${t.name})`;
        },

        hasToothHistory(toothNum) {
            return this.procedures.some(p => p.tooth_number == toothNum || (p.target_specifics && p.target_specifics.includes('#' + toothNum)));
        },

        async fetchProcedures() {
            if (!this.patient || !this.patient.id) return;
            this.isLoading = true;

            try {
                const res = await axios.get(`/api/v1/patients/${this.patient.id}/procedures`);
                this.procedures = res.data.procedures || [];
            } catch (err) {
                console.error('Failed to load procedures:', err);
                this.procedures = [];
            } finally {
                this.isLoading = false;
            }
        },

        async submitProcedure() {
            if (!this.patient || !this.patient.id) return;
            this.isSaving = true;

            try {
                const payload = {
                    ...this.newProcedure,
                    patient_id: this.patient.id
                };

                const res = await axios.post(`/api/v1/patients/${this.patient.id}/procedures`, payload);

                Swal.fire({
                    icon: 'success',
                    title: 'Procedure Saved',
                    text: 'Patient procedure record has been logged successfully.',
                    timer: 2000,
                    showConfirmButton: false
                });

                this.resetForm();
                await this.fetchProcedures();
                this.activeTab = 'history';

            } catch (err) {
                console.error('Failed to save procedure:', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Save Failed',
                    text: err.response?.data?.message || 'Unable to save procedure record.'
                });
            } finally {
                this.isSaving = false;
            }
        }
    }));
});
</script>
