<x-ui.card>
    <div class="flex items-start justify-between gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
        <div class="flex items-start gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#2F6F3E]/10 text-[#2F6F3E]">
                <i data-lucide="user-round-search" class="h-5 w-5"></i>
            </div>
            <div>
                <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">Patient Information</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Search existing patient or register a new patient.</p>
            </div>
        </div>
        <span x-show="form.is_new_patient" class="rounded-full bg-blue-50 px-3 py-1.5 text-xs font-extrabold text-blue-700 dark:bg-blue-500/10 dark:text-blue-300">New Patient</span>
    </div>

    <div class="mt-5 grid gap-5 md:grid-cols-2">
        <div class="relative md:col-span-2">
            <label class="block">
                <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Patient Search</span>
                <span class="relative block">
                    <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                    <input
                        type="search"
                        x-model.debounce.150ms="patientQuery"
                        x-on:focus="patientSearchOpen = true"
                        placeholder="Search by patient ID, name, or phone..."
                        class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 pl-10 pr-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900"
                    >
                </span>
            </label>

            <div
                x-cloak
                x-show="patientSearchOpen && patientQuery.length > 0"
                x-transition
                x-on:click.outside="patientSearchOpen = false"
                class="absolute left-0 right-0 top-[76px] z-20 overflow-hidden rounded-2xl border border-slate-200 bg-white p-2 shadow-xl dark:border-slate-700 dark:bg-slate-900"
            >
                <template x-for="patient in filteredPatients.slice(0, 5)" :key="patient.id">
                    <button type="button" x-on:click="selectPatient(patient)" class="flex w-full items-center justify-between gap-3 rounded-xl px-3 py-3 text-left transition hover:bg-slate-100 dark:hover:bg-slate-800">
                        <span>
                            <span class="block text-sm font-extrabold text-slate-950 dark:text-white" x-text="patient.full_name"></span>
                            <span class="mt-1 block text-xs font-bold text-slate-500" x-text="patient.id + ' • ' + patient.phone"></span>
                        </span>
                        <i data-lucide="arrow-right" class="h-4 w-4 text-slate-400"></i>
                    </button>
                </template>
                <div x-show="filteredPatients.length === 0" class="px-3 py-5 text-center">
                    <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                        <i data-lucide="user-plus" class="h-5 w-5"></i>
                    </div>
                    <p class="mt-3 text-sm font-bold text-slate-600 dark:text-slate-300">No existing patient found.</p>
                    <button type="button" x-on:click="registerNewPatient()" class="mt-3 inline-flex items-center gap-2 rounded-2xl bg-[#2F6F3E] px-3 py-2 text-xs font-extrabold text-white">
                        <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                        Register New Patient
                    </button>
                </div>
            </div>
        </div>

        <label class="block">
            <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Patient ID</span>
            <input type="text" x-model="form.patient_id" readonly x-bind:class="fieldClass('patient_id')" class="h-12 w-full rounded-2xl px-4 text-sm font-semibold text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900">
            <p x-show="errors.patient_id" x-text="errors.patient_id" class="mt-2 text-xs font-bold text-red-600"></p>
        </label>

        <label class="block">
            <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Full Name</span>
            <input type="text" x-model.trim="form.patient_name" placeholder="Patient full name" x-bind:class="fieldClass('patient_name')" class="h-12 w-full rounded-2xl px-4 text-sm font-semibold text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900">
            <p x-show="errors.patient_name" x-text="errors.patient_name" class="mt-2 text-xs font-bold text-red-600"></p>
        </label>

        <label class="block">
            <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Phone Number</span>
            <input type="text" x-model.trim="form.phone" placeholder="010 123 456" x-bind:class="fieldClass('phone')" class="h-12 w-full rounded-2xl px-4 text-sm font-semibold text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900">
            <p x-show="errors.phone" x-text="errors.phone" class="mt-2 text-xs font-bold text-red-600"></p>
        </label>

        <label class="block">
            <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Date of Birth</span>
            <input type="date" x-model="form.date_of_birth" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
        </label>

        <label class="block">
            <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Gender</span>
            <select x-model="form.gender" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
                <option>Female</option>
                <option>Male</option>
                <option>Other</option>
            </select>
        </label>

        <label class="block md:col-span-2">
            <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Visit Reason</span>
            <textarea x-model.trim="form.visit_reason" rows="4" placeholder="Describe the main reason for this visit..." x-bind:class="fieldClass('visit_reason')" class="w-full rounded-2xl px-4 py-3 text-sm font-semibold leading-7 text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900"></textarea>
            <p x-show="errors.visit_reason" x-text="errors.visit_reason" class="mt-2 text-xs font-bold text-red-600"></p>
        </label>
    </div>
</x-ui.card>
