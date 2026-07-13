<x-ui.card class="xl:sticky xl:top-24">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">Summary Panel</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Live measurement summary.</p>
        </div>
        <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#2F6F3E]/10 text-[#2F6F3E]">
            <i data-lucide="clipboard-check" class="h-5 w-5"></i>
        </span>
    </div>

    <div class="mt-5 space-y-3">
        <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
            <p class="text-xs font-bold text-slate-400">Patient</p>
            <p class="mt-1 font-extrabold text-slate-950 dark:text-white" x-text="selectedPatient?.full_name || 'No patient selected'"></p>
        </div>
        <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
            <p class="text-xs font-bold text-slate-400">Visit</p>
            <p class="mt-1 font-extrabold text-slate-950 dark:text-white" x-text="(selectedPatient?.visit_id || 'Pending') + ' • ' + visit.department"></p>
        </div>
        <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
            <p class="text-xs font-bold text-slate-400">Recorded Vital Signs</p>
            <p class="mt-1 font-extrabold text-slate-950 dark:text-white" x-text="recordedVitalCount + ' fields entered'"></p>
        </div>
        <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
            <p class="text-xs font-bold text-slate-400">Abnormal Findings</p>
            <div class="mt-2 flex flex-wrap gap-2">
                <template x-for="finding in abnormalFindings" :key="finding">
                    <span class="rounded-full bg-[#DC2626]/10 px-2.5 py-1 text-xs font-extrabold text-[#DC2626]" x-text="finding"></span>
                </template>
                <span x-show="abnormalFindings.length === 0" class="rounded-full bg-[#16A34A]/10 px-2.5 py-1 text-xs font-extrabold text-[#16A34A]">Normal</span>
            </div>
        </div>
        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-1">
            <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                <p class="text-xs font-bold text-slate-400">Assigned Doctor</p>
                <p class="mt-1 font-extrabold text-slate-950 dark:text-white" x-text="visit.assigned_doctor"></p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                <p class="text-xs font-bold text-slate-400">Measurement Time</p>
                <p class="mt-1 font-extrabold text-slate-950 dark:text-white" x-text="visit.date + ' • ' + visit.time"></p>
            </div>
        </div>
    </div>

    <div class="mt-5 rounded-2xl bg-[#2F6F3E] p-5 text-white">
        <p class="text-xs font-bold text-white/70">Current BMI</p>
        <p class="mt-1 text-2xl font-extrabold" x-text="bmi || 'Auto'"></p>
        <p class="mt-2 text-xs font-semibold text-white/70">Calculated from height and weight.</p>
    </div>
</x-ui.card>
