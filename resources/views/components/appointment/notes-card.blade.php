<x-ui.card>
    <div class="flex items-start gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-300">
            <i data-lucide="notebook-pen" class="h-5 w-5"></i>
        </div>
        <div>
            <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">Visit Notes</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Additional notes, symptoms, or special requests.</p>
        </div>
    </div>

    <textarea
        x-model.trim="form.notes"
        rows="7"
        placeholder="Enter additional notes, symptoms, or special requests..."
        class="mt-5 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold leading-7 text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900"
    ></textarea>
</x-ui.card>
