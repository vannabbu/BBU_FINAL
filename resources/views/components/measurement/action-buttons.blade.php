<div class="sticky bottom-0 z-20 -mx-4 border-t border-[#E5E7EB] bg-white/92 px-4 py-4 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-900/92 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 xl:rounded-t-2xl xl:border xl:shadow-[0_-12px_30px_rgba(15,23,42,0.05)]">
    <div class="mx-auto flex max-w-7xl flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">
            <span x-show="! dirty">No unsaved changes.</span>
            <span x-show="dirty && ! hasErrors()" class="text-[#2F6F3E]">Unsaved measurement changes are ready.</span>
            <span x-show="hasErrors()" class="text-[#DC2626]">Please fix validation errors before saving.</span>
        </p>
        <div class="grid gap-3 sm:flex sm:items-center">
            <a href="{{ route('diagnosis-reports.index') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-extrabold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                <i data-lucide="x" class="h-4 w-4"></i>
                Cancel
            </a>
            <button type="button" x-on:click="resetForm()" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-extrabold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
                Reset Form
            </button>
            <button type="button" x-on:click="saveDraft()" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-extrabold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                <i data-lucide="save" class="h-4 w-4"></i>
                Save Draft
            </button>
            <button type="button" x-on:click="openConfirmation()" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-[#2F6F3E] px-4 py-3 text-sm font-extrabold text-white shadow-sm transition hover:bg-[#285f35] focus:outline-none focus:ring-4 focus:ring-[#2F6F3E]/20">
                <i data-lucide="badge-check" class="h-4 w-4"></i>
                Save Measurement
            </button>
        </div>
    </div>
</div>
