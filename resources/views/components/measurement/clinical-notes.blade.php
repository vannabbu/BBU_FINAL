<x-ui.card>
    <div class="flex items-start gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-300">
            <i data-lucide="notebook-pen" class="h-5 w-5"></i>
        </div>
        <div>
            <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">Clinical Notes</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Document diagnosis, complaint, observation, symptoms, notes, and follow-up recommendation.</p>
        </div>
    </div>

    <div class="mt-5 grid gap-5 lg:grid-cols-2">
        <label class="block">
            <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Primary Diagnosis</span>
            <input
                type="text"
                x-model.trim="notes.primary_diagnosis"
                x-on:input="markDirty()"
                placeholder="Example: Hypertension stage 1"
                class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900"
            >
        </label>
        <label class="block">
            <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Chief Complaint</span>
            <input
                type="text"
                x-model.trim="notes.chief_complaint"
                x-on:input="markDirty()"
                placeholder="Example: Headache and fatigue"
                class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900"
            >
        </label>

        @foreach ([
            'clinical_observation' => ['Clinical Observation', 'Describe objective clinical observations...'],
            'symptoms' => ['Symptoms', 'List current symptoms reported by the patient...'],
            'doctor_notes' => ['Doctor/Nurse Notes', 'Add professional notes for this measurement...'],
            'follow_up' => ['Follow-up Recommendation', 'Recommend follow-up care, monitoring, or next steps...'],
        ] as $field => [$label, $placeholder])
            <label class="block lg:col-span-2">
                <span class="mb-2 flex items-center justify-between gap-3">
                    <span class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $label }}</span>
                    <span class="text-xs font-bold text-slate-400"><span x-text="(notes.{{ $field }} || '').length"></span>/600</span>
                </span>
                <textarea
                    x-model.trim="notes.{{ $field }}"
                    x-on:input="markDirty()"
                    maxlength="600"
                    rows="4"
                    placeholder="{{ $placeholder }}"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold leading-7 text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900"
                ></textarea>
            </label>
        @endforeach
    </div>
</x-ui.card>
