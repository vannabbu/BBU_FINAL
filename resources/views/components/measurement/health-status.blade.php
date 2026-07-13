<x-ui.card>
    <div class="flex items-start justify-between gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
        <div class="flex items-start gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-300">
                <i data-lucide="shield-alert" class="h-5 w-5"></i>
            </div>
            <div>
                <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">Health Status</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Automatic indicators highlight abnormal vital signs in real time.</p>
            </div>
        </div>
        <span x-show="abnormalFindings.length === 0" class="rounded-full bg-[#16A34A]/10 px-3 py-1.5 text-xs font-extrabold text-[#16A34A]">Normal</span>
    </div>

    <div class="mt-5">
        <div x-show="statusIndicators.length === 0" class="rounded-2xl border border-dashed border-slate-200 p-6 text-center dark:border-slate-700">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                <i data-lucide="activity" class="h-5 w-5"></i>
            </div>
            <h3 class="mt-3 text-sm font-extrabold text-slate-950 dark:text-white">Waiting for vital signs</h3>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Enter measurements to generate clinical indicators.</p>
        </div>

        <div x-show="statusIndicators.length > 0" class="grid gap-3 sm:grid-cols-2">
            <template x-for="indicator in statusIndicators" :key="indicator.label">
                <div x-bind:class="indicatorClass(indicator.tone)" class="rounded-2xl border p-4">
                    <div class="flex items-start gap-3">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/70 dark:bg-slate-900/60">
                            <i x-bind:data-lucide="indicator.icon" class="h-4 w-4"></i>
                        </span>
                        <div>
                            <p class="font-extrabold" x-text="indicator.label"></p>
                            <p class="mt-1 text-sm opacity-80" x-text="indicator.message"></p>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</x-ui.card>
