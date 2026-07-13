<x-ui.card>
    <div class="flex items-start gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300">
            <i data-lucide="paperclip" class="h-5 w-5"></i>
        </div>
        <div>
            <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">Attachments</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Upload lab results, images, PDF, ECG, or other medical documents.</p>
        </div>
    </div>

    <div class="mt-5">
        <label class="flex cursor-pointer flex-col items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center transition hover:border-[#2F6F3E] hover:bg-[#2F6F3E]/5 dark:border-slate-700 dark:bg-slate-800/60">
            <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-[#2F6F3E] shadow-sm dark:bg-slate-900">
                <i data-lucide="upload-cloud" class="h-6 w-6"></i>
            </span>
            <span class="mt-4 text-sm font-extrabold text-slate-950 dark:text-white">Drop files here or browse</span>
            <span class="mt-1 text-xs font-semibold text-slate-500">PDF, JPG, PNG, ECG, Lab Result, or Medical Document</span>
            <input type="file" multiple class="sr-only" x-on:change="handleFiles($event)">
        </label>

        <div x-show="attachments.length === 0" class="mt-4 rounded-2xl bg-slate-50 p-4 text-sm font-semibold text-slate-500 dark:bg-slate-800">
            No uploaded files yet.
        </div>

        <div x-show="attachments.length > 0" class="mt-4 space-y-3">
            <template x-for="file in attachments" :key="file.id">
                <article class="flex items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white p-3 dark:border-slate-700 dark:bg-slate-900">
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#2F6F3E]/10 text-[#2F6F3E]">
                            <i x-bind:data-lucide="file.icon" class="h-4 w-4"></i>
                        </span>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-extrabold text-slate-950 dark:text-white" x-text="file.name"></p>
                            <p class="mt-1 text-xs font-bold text-slate-500" x-text="file.size"></p>
                        </div>
                    </div>
                    <button type="button" x-on:click="removeFile(file.id)" class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-red-50 text-red-600 transition hover:bg-red-100 dark:bg-red-500/10 dark:text-red-300">
                        <i data-lucide="x" class="h-4 w-4"></i>
                    </button>
                </article>
            </template>
        </div>
    </div>
</x-ui.card>
