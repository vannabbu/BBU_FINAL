<x-ui.card padding="p-0">
    <div class="border-b border-slate-100 p-5 dark:border-slate-800 sm:p-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">តារាងថ្លៃឱសថ</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Medicine bill table with live quantity and subtotal calculation</p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row">
                <div class="relative sm:w-72">
                    <x-ui.input
                        icon="search"
                        placeholder="ស្វែងរកឱសថ..."
                        x-model.debounce.150ms="medicineSearch"
                    />

                    <div
                        x-cloak
                        x-show="medicineSearch.length > 0"
                        x-transition
                        class="absolute left-0 right-0 top-12 z-20 overflow-hidden rounded-2xl border border-slate-200 bg-white p-2 shadow-xl dark:border-slate-700 dark:bg-slate-900"
                    >
                        <template x-for="item in filteredCatalog.slice(0, 4)" :key="item.id">
                            <button type="button" x-on:click="addMedicine(item)" class="flex w-full items-center justify-between gap-3 rounded-xl px-3 py-2 text-left text-sm transition hover:bg-slate-100 dark:hover:bg-slate-800">
                                <span class="font-bold text-slate-700 dark:text-slate-200" x-text="item.name"></span>
                                <span class="text-xs font-extrabold text-[#2F6F3E]" x-text="money(item.unit_price)"></span>
                            </button>
                        </template>
                        <p x-show="filteredCatalog.length === 0" class="px-3 py-3 text-sm font-semibold text-slate-500">រកមិនឃើញឱសថ</p>
                    </div>
                </div>

                <x-ui.button
                    label="បន្ថែមឱសថ"
                    icon="plus"
                    x-on:click="addFirstSearchResult()"
                    x-bind:disabled="filteredCatalog.length === 0"
                    class="disabled:cursor-not-allowed disabled:opacity-50"
                />
            </div>
        </div>
    </div>

    <div class="hidden overflow-x-auto md:block">
        <table class="min-w-full text-left">
            <thead class="bg-slate-50 text-xs font-extrabold uppercase tracking-wide text-slate-500 dark:bg-slate-800/60 dark:text-slate-400">
                <tr>
                    <th class="px-5 py-3">ឈ្មោះឱសថ</th>
                    <th class="px-5 py-3">តម្លៃឯកតា</th>
                    <th class="px-5 py-3">ចំនួន</th>
                    <th class="px-5 py-3">សរុបរង</th>
                    <th class="px-5 py-3 text-right">លុប</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="medicine in medicines" :key="medicine.id">
                    <tr class="border-b border-slate-100 transition hover:bg-slate-50/80 dark:border-slate-800 dark:hover:bg-slate-800/50">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-[#2F6F3E]/10 text-[#2F6F3E]">
                                    <i data-lucide="pill" class="h-4 w-4"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold text-slate-950 dark:text-white" x-text="medicine.name"></p>
                                    <p class="mt-1 text-xs font-semibold text-slate-500 dark:text-slate-400" x-text="medicine.id.toUpperCase()"></p>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-5 py-4 text-sm font-bold text-slate-600 dark:text-slate-300" x-text="money(medicine.unit_price)"></td>
                        <td class="px-5 py-4">
                            <input
                                type="number"
                                min="1"
                                x-model.number="medicine.quantity"
                                x-on:input="medicine.quantity = Math.max(1, Number(medicine.quantity || 1))"
                                class="h-10 w-24 rounded-2xl border border-slate-200 bg-slate-50 px-3 text-sm font-extrabold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                            >
                        </td>
                        <td class="whitespace-nowrap px-5 py-4 text-sm font-extrabold text-slate-950 dark:text-white" x-text="money(lineSubtotal(medicine))"></td>
                        <td class="px-5 py-4 text-right">
                            <button type="button" x-on:click="removeMedicine(medicine.id)" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-red-100 bg-red-50 text-red-600 transition hover:bg-red-100 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-300">
                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <div class="space-y-3 p-5 md:hidden">
        <template x-for="medicine in medicines" :key="medicine.id">
            <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-950 dark:text-white" x-text="medicine.name"></h3>
                        <p class="mt-1 text-xs font-bold text-slate-500 dark:text-slate-400" x-text="money(medicine.unit_price) + ' / unit'"></p>
                    </div>
                    <button type="button" x-on:click="removeMedicine(medicine.id)" class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-red-50 text-red-600 dark:bg-red-500/10 dark:text-red-300">
                        <i data-lucide="trash-2" class="h-4 w-4"></i>
                    </button>
                </div>
                <div class="mt-4 flex items-center justify-between gap-3">
                    <input type="number" min="1" x-model.number="medicine.quantity" class="h-10 w-24 rounded-2xl border border-slate-200 bg-slate-50 px-3 text-sm font-extrabold text-slate-700 outline-none focus:border-[#2F6F3E] focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                    <p class="text-base font-extrabold text-slate-950 dark:text-white" x-text="money(lineSubtotal(medicine))"></p>
                </div>
            </article>
        </template>
    </div>

    <div x-show="medicines.length === 0" class="px-5 py-14 text-center">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
            <i data-lucide="receipt" class="h-6 w-6"></i>
        </div>
        <h3 class="mt-4 text-base font-extrabold text-slate-950 dark:text-white">មិនទាន់មានឱសថក្នុងវិក្កយបត្រ</h3>
        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500 dark:text-slate-400">សូមស្វែងរក និងបន្ថែមឱសថ ដើម្បីគណនាតម្លៃឱសថសម្រាប់អ្នកជំងឺនេះ។</p>
    </div>
</x-ui.card>
