@props([
    'inventory' => [],
    'categories' => [],
])

<section
    x-data="pharmacyInventory(@js($inventory), @js($categories))"
    x-init="init()"
    class="rounded-2xl border border-[#E5E7EB] bg-white shadow-[0_12px_30px_rgba(15,23,42,0.04)] dark:border-slate-800 dark:bg-slate-900"
>
    <div class="border-b border-slate-100 p-5 dark:border-slate-800 sm:p-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">តារាងឃ្លាំងឱសថ</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Inventory table with live search, filter, sort, and pagination</p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row">
                <label class="relative block sm:w-72">
                    <span class="sr-only">ស្វែងរកឱសថ</span>
                    <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                    <input
                        x-model.debounce.200ms="search"
                        x-on:input="page = 1"
                        type="search"
                        placeholder="ស្វែងរកឱសថ ឬ SKU..."
                        class="h-11 w-full rounded-2xl border border-slate-200 bg-slate-50 pl-10 pr-4 text-sm outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900"
                    >
                </label>
                <x-ui.button label="បន្ថែមឱសថ" icon="plus" :href="route('modules.create', ['module' => 'medicines'])" />
            </div>
        </div>

        <div class="mt-5 grid gap-3 md:grid-cols-3">
            <label>
                <span class="mb-2 block text-xs font-extrabold uppercase tracking-wide text-slate-400">ប្រភេទ</span>
                <select x-model="category" x-on:change="page = 1" class="h-11 w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                    <option value="all">ប្រភេទទាំងអស់</option>
                    <template x-for="item in categories" :key="item">
                        <option x-bind:value="item" x-text="item"></option>
                    </template>
                </select>
            </label>
            <label>
                <span class="mb-2 block text-xs font-extrabold uppercase tracking-wide text-slate-400">ស្ថានភាព</span>
                <select x-model="status" x-on:change="page = 1" class="h-11 w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                    <option value="all">ស្ថានភាពទាំងអស់</option>
                    <option value="healthy">គ្រប់គ្រាន់</option>
                    <option value="low">ខ្វះស្តុក</option>
                    <option value="expiry">ជិតផុតកំណត់</option>
                </select>
            </label>
            <label>
                <span class="mb-2 block text-xs font-extrabold uppercase tracking-wide text-slate-400">តម្រៀប</span>
                <select x-model="sort" x-on:change="page = 1" class="h-11 w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                    <option value="name_asc">ឈ្មោះ A-Z</option>
                    <option value="stock_asc">ស្តុកតិចទៅច្រើន</option>
                    <option value="stock_desc">ស្តុកច្រើនទៅតិច</option>
                    <option value="value_desc">តម្លៃស្តុកខ្ពស់</option>
                </select>
            </label>
        </div>
    </div>

    <div x-show="loading" class="space-y-3 p-5 dark:border-slate-800 sm:p-6">
        @for ($i = 0; $i < 5; $i++)
            <div class="animate-pulse rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/60">
                <div class="flex items-center gap-3">
                    <div class="h-11 w-11 rounded-2xl bg-slate-200 dark:bg-slate-700"></div>
                    <div class="flex-1 space-y-2">
                        <div class="h-3 w-1/3 rounded bg-slate-200 dark:bg-slate-700"></div>
                        <div class="h-3 w-1/4 rounded bg-slate-200 dark:bg-slate-700"></div>
                    </div>
                    <div class="h-8 w-24 rounded-full bg-slate-200 dark:bg-slate-700"></div>
                </div>
            </div>
        @endfor
    </div>

    <div x-cloak x-show="! loading">
        <div class="hidden overflow-x-auto md:block">
            <table class="min-w-full text-left">
                <thead class="bg-slate-50 text-xs font-extrabold uppercase tracking-wide text-slate-500 dark:bg-slate-800/60 dark:text-slate-400">
                    <tr>
                        <th class="px-5 py-3">ឈ្មោះឱសថ</th>
                        <th class="px-5 py-3">NDC / SKU</th>
                        <th class="px-5 py-3">ប្រភេទ</th>
                        <th class="px-5 py-3">ស្តុកបច្ចុប្បន្ន</th>
                        <th class="px-5 py-3">អប្បបរមា</th>
                        <th class="px-5 py-3">ស្ថានភាព</th>
                        <th class="px-5 py-3 text-right">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    <x-pharmacy.inventory-row />
                </tbody>
            </table>
        </div>

        <div class="space-y-3 p-5 md:hidden">
            <template x-for="medicine in paginatedRows" :key="medicine.id">
                <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-extrabold text-slate-950 dark:text-white" x-text="medicine.name"></p>
                            <p class="mt-1 text-xs font-bold text-slate-500 dark:text-slate-400" x-text="medicine.sku"></p>
                        </div>
                        <x-ui.status-badge dynamic x-text="medicine.status_label" x-bind:class="statusBadgeClass(medicine.status_tone)" />
                    </div>
                    <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                        <div class="rounded-2xl bg-slate-50 p-3 dark:bg-slate-800">
                            <p class="text-xs font-bold text-slate-400">ស្តុក</p>
                            <p class="mt-1 font-extrabold text-slate-950 dark:text-white" x-text="number(medicine.current_stock)"></p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-3 dark:bg-slate-800">
                            <p class="text-xs font-bold text-slate-400">អប្បបរមា</p>
                            <p class="mt-1 font-extrabold text-slate-950 dark:text-white" x-text="number(medicine.minimum_stock)"></p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-500">
                            <span x-text="medicine.category"></span>
                            <span x-text="money(medicine.stock_value)"></span>
                        </div>
                        <div class="mt-2 h-2 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                            <div class="h-full rounded-full" x-bind:class="stockBarClass(medicine.status_tone)" x-bind:style="'width: ' + medicine.stock_percent + '%'"></div>
                        </div>
                    </div>
                </article>
            </template>
        </div>

        <div x-show="paginatedRows.length === 0" class="px-5 py-14 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                <i data-lucide="search-x" class="h-6 w-6"></i>
            </div>
            <h3 class="mt-4 text-base font-extrabold text-slate-950 dark:text-white">មិនមានទិន្នន័យឱសថ</h3>
            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500 dark:text-slate-400">សូមប្ដូរពាក្យស្វែងរក ឬ filter ដើម្បីមើលទិន្នន័យផ្សេងទៀត។</p>
        </div>

        <div class="flex flex-col gap-3 border-t border-slate-100 px-5 py-4 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">
                បង្ហាញ <span class="font-extrabold text-slate-950 dark:text-white" x-text="paginatedRows.length"></span>
                ក្នុងចំណោម <span class="font-extrabold text-slate-950 dark:text-white" x-text="filteredRows.length"></span> ឱសថ
            </p>
            <div class="flex items-center gap-2">
                <button type="button" x-on:click="page = Math.max(1, page - 1)" x-bind:disabled="page === 1" class="inline-flex h-10 items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 text-sm font-extrabold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-45 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                    <i data-lucide="chevron-left" class="h-4 w-4"></i>
                    មុន
                </button>
                <span class="rounded-2xl bg-slate-100 px-3 py-2 text-sm font-extrabold text-slate-700 dark:bg-slate-800 dark:text-slate-200">
                    <span x-text="page"></span>/<span x-text="totalPages"></span>
                </span>
                <button type="button" x-on:click="page = Math.min(totalPages, page + 1)" x-bind:disabled="page === totalPages" class="inline-flex h-10 items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 text-sm font-extrabold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-45 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                    បន្ទាប់
                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                </button>
            </div>
        </div>
    </div>
</section>

@once
    @push('scripts')
        <script>
            function pharmacyInventory(rows, categories) {
                return {
                    rows,
                    categories,
                    search: '',
                    category: 'all',
                    status: 'all',
                    sort: 'name_asc',
                    page: 1,
                    perPage: 5,
                    loading: true,
                    init() {
                        setTimeout(() => {
                            this.loading = false;
                        }, 280);
                    },
                    get filteredRows() {
                        const query = this.search.trim().toLowerCase();

                        return this.rows.filter((medicine) => {
                            const haystack = `${medicine.name} ${medicine.sku} ${medicine.category} ${medicine.supplier}`.toLowerCase();
                            const matchesSearch = query === '' || haystack.includes(query);
                            const matchesCategory = this.category === 'all' || medicine.category === this.category;
                            const matchesStatus = this.status === 'all' || medicine.status_key === this.status;

                            return matchesSearch && matchesCategory && matchesStatus;
                        });
                    },
                    get sortedRows() {
                        return [...this.filteredRows].sort((a, b) => {
                            if (this.sort === 'stock_asc') {
                                return a.current_stock - b.current_stock;
                            }

                            if (this.sort === 'stock_desc') {
                                return b.current_stock - a.current_stock;
                            }

                            if (this.sort === 'value_desc') {
                                return b.stock_value - a.stock_value;
                            }

                            return a.name.localeCompare(b.name);
                        });
                    },
                    get totalPages() {
                        return Math.max(1, Math.ceil(this.sortedRows.length / this.perPage));
                    },
                    get paginatedRows() {
                        if (this.page > this.totalPages) {
                            this.page = this.totalPages;
                        }

                        const start = (this.page - 1) * this.perPage;

                        return this.sortedRows.slice(start, start + this.perPage);
                    },
                    number(value) {
                        return new Intl.NumberFormat('en-US').format(value);
                    },
                    money(value) {
                        return `${new Intl.NumberFormat('en-US').format(value)} ៛`;
                    },
                    statusBadgeClass(tone) {
                        return {
                            green: 'border-[#2F6F3E]/20 bg-[#2F6F3E]/10 text-[#2F6F3E]',
                            amber: 'border-amber-100 bg-amber-50 text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300',
                            red: 'border-red-100 bg-red-50 text-red-700 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-300',
                            blue: 'border-sky-100 bg-sky-50 text-sky-700 dark:border-sky-500/20 dark:bg-sky-500/10 dark:text-sky-300',
                        }[tone] || 'border-slate-200 bg-slate-100 text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300';
                    },
                    stockBarClass(tone) {
                        return {
                            green: 'bg-[#2F6F3E]',
                            amber: 'bg-amber-500',
                            red: 'bg-red-500',
                            blue: 'bg-sky-500',
                        }[tone] || 'bg-slate-400';
                    },
                };
            }
        </script>
    @endpush
@endonce
