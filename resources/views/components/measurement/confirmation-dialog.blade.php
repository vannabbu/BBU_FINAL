<div x-cloak x-show="confirmationOpen" x-transition.opacity class="fixed inset-0 z-50 flex items-end justify-center bg-slate-950/50 p-4 sm:items-center">
    <div
        x-show="confirmationOpen"
        x-transition.scale.origin.bottom
        x-on:click.outside="confirmationOpen = false"
        class="w-full max-w-2xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl dark:border-slate-700 dark:bg-slate-900"
    >
        <div class="flex items-start justify-between gap-4 border-b border-slate-100 p-5 dark:border-slate-800 sm:p-6">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full bg-[#2F6F3E]/10 px-3 py-1.5 text-xs font-extrabold text-[#2F6F3E]">
                    <i data-lucide="clipboard-check" class="h-3.5 w-3.5"></i>
                    Measurement Confirmation
                </span>
                <h2 class="mt-4 text-2xl font-extrabold text-slate-950 dark:text-white">Save this patient measurement?</h2>
                <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">Review the patient, visit, and abnormal findings before saving.</p>
            </div>
            <button type="button" x-on:click="confirmationOpen = false" class="rounded-xl p-2 text-slate-400 transition hover:bg-slate-100 dark:hover:bg-slate-800">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <div class="p-5 sm:p-6">
            <div class="grid gap-3 sm:grid-cols-2">
                <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                    <p class="text-xs font-bold text-slate-400">Patient</p>
                    <p class="mt-1 font-extrabold text-slate-950 dark:text-white" x-text="selectedPatient?.full_name"></p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                    <p class="text-xs font-bold text-slate-400">Visit</p>
                    <p class="mt-1 font-extrabold text-slate-950 dark:text-white" x-text="selectedPatient?.visit_id"></p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                    <p class="text-xs font-bold text-slate-400">Blood Pressure</p>
                    <p class="mt-1 font-extrabold text-slate-950 dark:text-white" x-text="vitals.systolic + '/' + vitals.diastolic + ' mmHg'"></p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                    <p class="text-xs font-bold text-slate-400">Abnormal Findings</p>
                    <p class="mt-1 font-extrabold text-slate-950 dark:text-white" x-text="abnormalFindings.length ? abnormalFindings.join(', ') : 'Normal'"></p>
                </div>
            </div>

            <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:justify-end">
                <button type="button" x-on:click="confirmationOpen = false" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-extrabold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                    Review Again
                </button>
                <button type="button" x-on:click="saveMeasurement()" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-[#2F6F3E] px-4 py-3 text-sm font-extrabold text-white shadow-sm transition hover:bg-[#285f35]">
                    <i data-lucide="badge-check" class="h-4 w-4"></i>
                    Confirm Save
                </button>
            </div>
        </div>
    </div>
</div>
