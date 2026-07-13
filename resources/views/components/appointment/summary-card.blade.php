@props(['doctor'])

<x-ui.card class="xl:sticky xl:top-24">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">Appointment Summary</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Updates automatically as you schedule.</p>
        </div>
        <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#2F6F3E]/10 text-[#2F6F3E]">
            <i data-lucide="clipboard-check" class="h-5 w-5"></i>
        </span>
    </div>

    <div class="mt-5 space-y-3">
        <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
            <p class="text-xs font-bold text-slate-400">Patient Name</p>
            <p class="mt-1 font-extrabold text-slate-950 dark:text-white" x-text="form.patient_name || 'Not selected'"></p>
        </div>
        <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
            <p class="text-xs font-bold text-slate-400">Doctor</p>
            <p class="mt-1 font-extrabold text-slate-950 dark:text-white">{{ $doctor['name'] }}</p>
        </div>
        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-1">
            <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                <p class="text-xs font-bold text-slate-400">Department</p>
                <p class="mt-1 font-extrabold text-slate-950 dark:text-white" x-text="form.department"></p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                <p class="text-xs font-bold text-slate-400">Appointment Date</p>
                <p class="mt-1 font-extrabold text-slate-950 dark:text-white" x-text="form.appointment_date || 'Not selected'"></p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                <p class="text-xs font-bold text-slate-400">Selected Time</p>
                <p class="mt-1 font-extrabold text-slate-950 dark:text-white" x-text="form.selected_time || 'Not selected'"></p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                <p class="text-xs font-bold text-slate-400">Estimated Duration</p>
                <p class="mt-1 font-extrabold text-slate-950 dark:text-white" x-text="form.duration"></p>
            </div>
        </div>
    </div>

    <div class="mt-5 rounded-2xl bg-[#2F6F3E] p-5 text-white">
        <p class="text-xs font-bold text-white/70">Consultation Fee</p>
        <p class="mt-1 text-2xl font-extrabold">{{ number_format($doctor['fee']) }} ៛</p>
        <p class="mt-2 text-xs font-semibold text-white/70" x-text="form.consultation_type + ' • ' + form.priority"></p>
    </div>
</x-ui.card>
