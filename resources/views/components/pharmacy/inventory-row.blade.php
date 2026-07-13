<template x-for="medicine in paginatedRows" :key="medicine.id">
    <tr class="border-b border-slate-100 transition hover:bg-slate-50/80 dark:border-slate-800 dark:hover:bg-slate-800/50">
        <td class="px-5 py-4">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#2F6F3E]/10 text-[#2F6F3E]">
                    <i data-lucide="pill" class="h-5 w-5"></i>
                </div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-extrabold text-slate-950 dark:text-white" x-text="medicine.name"></p>
                    <p class="mt-1 text-xs font-semibold text-slate-500 dark:text-slate-400" x-text="medicine.supplier"></p>
                </div>
            </div>
        </td>
        <td class="whitespace-nowrap px-5 py-4 text-sm font-bold text-slate-600 dark:text-slate-300" x-text="medicine.sku"></td>
        <td class="whitespace-nowrap px-5 py-4">
            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-extrabold text-slate-600 dark:bg-slate-800 dark:text-slate-300" x-text="medicine.category"></span>
        </td>
        <td class="px-5 py-4">
            <div class="min-w-32">
                <div class="flex items-center justify-between gap-3">
                    <span class="text-sm font-extrabold text-slate-950 dark:text-white" x-text="number(medicine.current_stock)"></span>
                    <span class="text-xs font-bold text-slate-400" x-text="medicine.stock_percent + '%'"></span>
                </div>
                <div class="mt-2 h-2 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                    <div class="h-full rounded-full transition-all" x-bind:class="stockBarClass(medicine.status_tone)" x-bind:style="'width: ' + medicine.stock_percent + '%'"></div>
                </div>
            </div>
        </td>
        <td class="whitespace-nowrap px-5 py-4 text-sm font-bold text-slate-600 dark:text-slate-300" x-text="number(medicine.minimum_stock)"></td>
        <td class="whitespace-nowrap px-5 py-4">
            <x-ui.status-badge dynamic x-text="medicine.status_label" x-bind:class="statusBadgeClass(medicine.status_tone)" />
        </td>
        <td class="px-5 py-4 text-right">
            <div x-data="{ open: false }" class="relative inline-flex">
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800" x-on:click="open = ! open" x-on:keydown.escape.window="open = false" aria-label="បើកសកម្មភាព">
                    <i data-lucide="more-horizontal" class="h-4 w-4"></i>
                </button>
                <div x-cloak x-show="open" x-transition x-on:click.outside="open = false" class="absolute right-0 top-11 z-20 w-48 rounded-2xl border border-slate-200 bg-white p-2 text-left shadow-xl dark:border-slate-700 dark:bg-slate-900">
                    <button type="button" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
                        <i data-lucide="eye" class="h-4 w-4"></i>
                        មើលលម្អិត
                    </button>
                    <button type="button" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
                        <i data-lucide="package-plus" class="h-4 w-4"></i>
                        បន្ថែមស្តុក
                    </button>
                    <button type="button" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10">
                        <i data-lucide="archive" class="h-4 w-4"></i>
                        ដាក់ក្នុងបណ្ណសារ
                    </button>
                </div>
            </div>
        </td>
    </tr>
</template>
