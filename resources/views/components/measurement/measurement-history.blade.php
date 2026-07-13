<x-ui.card>
    <div class="flex items-start justify-between gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
        <div class="flex items-start gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-300">
                <i data-lucide="history" class="h-5 w-5"></i>
            </div>
            <div>
                <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">Measurement History</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Latest measurements and trend indicators.</p>
            </div>
        </div>
        <button type="button" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-xs font-extrabold text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
            <i data-lucide="external-link" class="h-3.5 w-3.5"></i>
            View Full History
        </button>
    </div>

    <div class="mt-5">
        <div x-show="historyLoading" class="space-y-3">
            @for ($i = 0; $i < 3; $i++)
                <div class="animate-pulse rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/60">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-slate-200 dark:bg-slate-700"></div>
                        <div class="flex-1 space-y-2">
                            <div class="h-3 w-1/3 rounded bg-slate-200 dark:bg-slate-700"></div>
                            <div class="h-3 w-1/2 rounded bg-slate-200 dark:bg-slate-700"></div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        <div x-cloak x-show="! historyLoading && history.length === 0" class="rounded-2xl border border-dashed border-slate-200 p-8 text-center dark:border-slate-700">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                <i data-lucide="clipboard-x" class="h-6 w-6"></i>
            </div>
            <h3 class="mt-4 text-base font-extrabold text-slate-950 dark:text-white">No measurement history</h3>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">History will appear after this patient has recorded measurements.</p>
        </div>

        <div x-cloak x-show="! historyLoading && history.length > 0" class="overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700">
            <div class="hidden overflow-x-auto md:block">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs font-extrabold uppercase tracking-wide text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                        <tr>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Blood Pressure</th>
                            <th class="px-4 py-3">Temperature</th>
                            <th class="px-4 py-3">Heart Rate</th>
                            <th class="px-4 py-3">BMI</th>
                            <th class="px-4 py-3">Recorded By</th>
                            <th class="px-4 py-3">Trend</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="item in history" :key="item.date">
                            <tr class="border-t border-slate-100 dark:border-slate-800">
                                <td class="whitespace-nowrap px-4 py-3 font-bold text-slate-700 dark:text-slate-200" x-text="item.date"></td>
                                <td class="whitespace-nowrap px-4 py-3 text-slate-500" x-text="item.blood_pressure"></td>
                                <td class="whitespace-nowrap px-4 py-3 text-slate-500" x-text="item.temperature"></td>
                                <td class="whitespace-nowrap px-4 py-3 text-slate-500" x-text="item.heart_rate"></td>
                                <td class="whitespace-nowrap px-4 py-3 text-slate-500" x-text="item.bmi"></td>
                                <td class="whitespace-nowrap px-4 py-3 text-slate-500" x-text="item.recorded_by"></td>
                                <td class="px-4 py-3">
                                    <span x-bind:class="trendClass(item.trend)" class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-extrabold">
                                        <i x-bind:data-lucide="trendIcon(item.trend)" class="h-3.5 w-3.5"></i>
                                        <span x-text="item.trend"></span>
                                    </span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div class="grid gap-3 p-4 md:hidden">
                <template x-for="item in history" :key="item.date">
                    <article class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-extrabold text-slate-950 dark:text-white" x-text="item.date"></p>
                                <p class="mt-1 text-xs font-bold text-slate-500" x-text="'Recorded by ' + item.recorded_by"></p>
                            </div>
                            <span x-bind:class="trendClass(item.trend)" class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-extrabold">
                                <i x-bind:data-lucide="trendIcon(item.trend)" class="h-3.5 w-3.5"></i>
                                <span x-text="item.trend"></span>
                            </span>
                        </div>
                        <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
                            <p class="rounded-xl bg-white p-2 font-bold text-slate-600 dark:bg-slate-900" x-text="'BP: ' + item.blood_pressure"></p>
                            <p class="rounded-xl bg-white p-2 font-bold text-slate-600 dark:bg-slate-900" x-text="'Temp: ' + item.temperature"></p>
                            <p class="rounded-xl bg-white p-2 font-bold text-slate-600 dark:bg-slate-900" x-text="'HR: ' + item.heart_rate"></p>
                            <p class="rounded-xl bg-white p-2 font-bold text-slate-600 dark:bg-slate-900" x-text="'BMI: ' + item.bmi"></p>
                        </div>
                    </article>
                </template>
            </div>
        </div>
    </div>
</x-ui.card>
