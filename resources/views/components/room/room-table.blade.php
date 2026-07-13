@props([
    'rooms' => [],
    'roomTypes' => [],
    'statusOptions' => [],
])

<section
    x-data="roomDirectory(@js($rooms->values()), @js($roomTypes))"
    x-init="init()"
    class="rounded-2xl border border-[#E5E7EB] bg-white shadow-[0_12px_30px_rgba(15,23,42,0.04)] dark:border-slate-800 dark:bg-slate-900"
>
    <div class="border-b border-slate-100 p-5 dark:border-slate-800 sm:p-6">
        <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
            <div>
                <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">Room Directory</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Search, filter, sort, and manage hospital rooms.</p>
            </div>

            <div class="grid gap-3 sm:grid-cols-2 xl:flex xl:items-center">
                <label class="relative block sm:col-span-2 xl:w-72">
                    <span class="sr-only">Search room</span>
                    <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                    <input
                        type="search"
                        x-model.debounce.180ms="search"
                        x-on:input="page = 1"
                        placeholder="Search room..."
                        class="h-11 w-full rounded-2xl border border-slate-200 bg-slate-50 pl-10 pr-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900"
                    >
                </label>

                <select x-model="status" x-on:change="page = 1" class="h-11 rounded-2xl border border-slate-200 bg-slate-50 px-3 text-sm font-bold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                    <option value="all">All Status</option>
                    @foreach ($statusOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>

                <select x-model="roomType" x-on:change="page = 1" class="h-11 rounded-2xl border border-slate-200 bg-slate-50 px-3 text-sm font-bold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                    <option value="all">All Room Types</option>
                    @foreach ($roomTypes as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div x-show="loading" class="space-y-3 p-5 sm:p-6">
        @for ($i = 0; $i < 6; $i++)
            <div class="animate-pulse rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/60">
                <div class="flex items-center gap-4">
                    <div class="h-10 w-10 rounded-2xl bg-slate-200 dark:bg-slate-700"></div>
                    <div class="flex-1 space-y-2">
                        <div class="h-3 w-1/4 rounded bg-slate-200 dark:bg-slate-700"></div>
                        <div class="h-3 w-1/5 rounded bg-slate-200 dark:bg-slate-700"></div>
                    </div>
                    <div class="hidden h-8 w-28 rounded-full bg-slate-200 dark:bg-slate-700 sm:block"></div>
                </div>
            </div>
        @endfor
    </div>

    <div x-cloak x-show="! loading">
        <div class="hidden max-h-[680px] overflow-auto lg:block">
            <table class="min-w-full text-left">
                <thead class="sticky top-0 z-10 border-b border-slate-100 bg-slate-50 text-xs font-extrabold uppercase tracking-wide text-slate-500 dark:border-slate-800 dark:bg-slate-800 dark:text-slate-400">
                    <tr>
                        <th class="sticky left-0 bg-slate-50 px-5 py-3 dark:bg-slate-800">
                            <button type="button" x-on:click="setSort('room_number')" class="inline-flex items-center gap-1 hover:text-[#2F6F3E]">
                                Room Number
                                <i data-lucide="arrow-up-down" class="h-3.5 w-3.5"></i>
                            </button>
                        </th>
                        <th class="px-5 py-3">
                            <button type="button" x-on:click="setSort('room_type')" class="inline-flex items-center gap-1 hover:text-[#2F6F3E]">
                                Room Type
                                <i data-lucide="arrow-up-down" class="h-3.5 w-3.5"></i>
                            </button>
                        </th>
                        <th class="px-5 py-3">Floor / Wing</th>
                        <th class="px-5 py-3">
                            <button type="button" x-on:click="setSort('price_per_day')" class="inline-flex items-center gap-1 hover:text-[#2F6F3E]">
                                Price Per Day
                                <i data-lucide="arrow-up-down" class="h-3.5 w-3.5"></i>
                            </button>
                        </th>
                        <th class="px-5 py-3">
                            <button type="button" x-on:click="setSort('status')" class="inline-flex items-center gap-1 hover:text-[#2F6F3E]">
                                Current Status
                                <i data-lucide="arrow-up-down" class="h-3.5 w-3.5"></i>
                            </button>
                        </th>
                        <th class="px-5 py-3">Last Updated</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <x-room.room-row />
                </tbody>
            </table>
        </div>

        <div class="grid gap-4 p-5 lg:hidden">
            <template x-for="room in paginatedRows" :key="room.id">
                <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-[#2F6F3E]/30 dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-xs font-extrabold text-[#2F6F3E]" x-text="room.id"></p>
                            <h3 class="mt-1 text-lg font-extrabold text-slate-950 dark:text-white" x-text="room.room_number"></h3>
                            <p class="mt-1 text-sm font-semibold text-slate-500 dark:text-slate-400" x-text="room.room_type + ' • ' + room.floor"></p>
                        </div>
                        <x-room.status-badge dynamic x-text="room.status_label" x-bind:class="statusClass(room.status)" />
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-3">
                        <div class="rounded-2xl bg-slate-50 p-3 dark:bg-slate-800">
                            <p class="text-xs font-bold text-slate-400">Wing</p>
                            <p class="mt-1 text-sm font-extrabold text-slate-950 dark:text-white" x-text="room.wing"></p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-3 dark:bg-slate-800">
                            <p class="text-xs font-bold text-slate-400">Price</p>
                            <p class="mt-1 text-sm font-extrabold text-slate-950 dark:text-white" x-text="money(room.price_per_day)"></p>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <button type="button" x-on:click="openPreview(room)" class="inline-flex flex-1 items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm font-extrabold text-slate-700 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                            <i data-lucide="eye" class="h-4 w-4"></i>
                            View
                        </button>
                        <a x-bind:href="room.edit_url" class="inline-flex flex-1 items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm font-extrabold text-slate-700 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                            <i data-lucide="pencil" class="h-4 w-4"></i>
                            Edit
                        </a>
                        <button type="button" x-on:click="deleteRoom(room.id)" class="inline-flex flex-1 items-center justify-center gap-2 rounded-2xl bg-red-600 px-3 py-2 text-sm font-extrabold text-white">
                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                            Delete
                        </button>
                    </div>
                </article>
            </template>
        </div>

        <x-room.empty-state
            x-show="paginatedRows.length === 0"
            title="No rooms found"
            message="No room matches the current search or filters."
        />

        <div class="flex flex-col gap-3 border-t border-slate-100 px-5 py-4 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">
                Showing <span class="font-extrabold text-slate-950 dark:text-white" x-text="paginatedRows.length"></span>
                of <span class="font-extrabold text-slate-950 dark:text-white" x-text="filteredRows.length"></span> rooms
            </p>
            <div class="flex items-center gap-2">
                <button type="button" x-on:click="page = Math.max(1, page - 1)" x-bind:disabled="page === 1" class="inline-flex h-10 items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 text-sm font-extrabold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-45 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                    <i data-lucide="chevron-left" class="h-4 w-4"></i>
                    Previous
                </button>
                <span class="rounded-2xl bg-slate-100 px-3 py-2 text-sm font-extrabold text-slate-700 dark:bg-slate-800 dark:text-slate-200">
                    <span x-text="page"></span>/<span x-text="totalPages"></span>
                </span>
                <button type="button" x-on:click="page = Math.min(totalPages, page + 1)" x-bind:disabled="page === totalPages" class="inline-flex h-10 items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 text-sm font-extrabold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-45 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                    Next
                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                </button>
            </div>
        </div>
    </div>

    <div x-cloak x-show="previewOpen" x-transition.opacity class="fixed inset-0 z-50 flex items-end justify-center bg-slate-950/50 p-4 sm:items-center">
        <div x-show="previewOpen" x-transition.scale.origin.bottom class="w-full max-w-xl rounded-2xl border border-slate-200 bg-white p-5 shadow-2xl dark:border-slate-700 dark:bg-slate-900" x-on:click.outside="previewOpen = false">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-extrabold text-[#2F6F3E]" x-text="selectedRoom?.id"></p>
                    <h3 class="mt-1 text-2xl font-extrabold text-slate-950 dark:text-white" x-text="selectedRoom?.room_number"></h3>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400" x-text="selectedRoom?.description"></p>
                </div>
                <button type="button" x-on:click="previewOpen = false" class="rounded-xl p-2 text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>
            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                    <p class="text-xs font-bold text-slate-400">Type</p>
                    <p class="mt-1 font-extrabold text-slate-950 dark:text-white" x-text="selectedRoom?.room_type"></p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                    <p class="text-xs font-bold text-slate-400">Floor / Wing</p>
                    <p class="mt-1 font-extrabold text-slate-950 dark:text-white" x-text="selectedRoom?.floor + ' • ' + selectedRoom?.wing"></p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                    <p class="text-xs font-bold text-slate-400">Capacity</p>
                    <p class="mt-1 font-extrabold text-slate-950 dark:text-white" x-text="selectedRoom?.capacity + ' patient(s)'"></p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                    <p class="text-xs font-bold text-slate-400">Price</p>
                    <p class="mt-1 font-extrabold text-slate-950 dark:text-white" x-text="money(selectedRoom?.price_per_day || 0)"></p>
                </div>
            </div>
            <div class="mt-5 flex flex-wrap gap-2">
                <template x-for="amenity in selectedRoom?.amenities || []" :key="amenity">
                    <span class="rounded-full bg-[#2F6F3E]/10 px-3 py-1.5 text-xs font-extrabold text-[#2F6F3E]" x-text="amenity"></span>
                </template>
            </div>
        </div>
    </div>
</section>

@once
    @push('scripts')
        <script>
            function roomDirectory(initialRows, roomTypes) {
                return {
                    rows: initialRows,
                    roomTypes,
                    search: '',
                    status: 'all',
                    roomType: 'all',
                    sortKey: 'room_number',
                    sortDirection: 'asc',
                    page: 1,
                    perPage: 5,
                    loading: true,
                    previewOpen: false,
                    selectedRoom: null,
                    init() {
                        setTimeout(() => {
                            this.loading = false;
                            this.refreshIcons();
                        }, 280);
                    },
                    refreshIcons() {
                        this.$nextTick(() => {
                            if (window.lucide) {
                                window.lucide.createIcons();
                            }
                        });
                    },
                    setSort(key) {
                        if (this.sortKey === key) {
                            this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                        } else {
                            this.sortKey = key;
                            this.sortDirection = 'asc';
                        }
                    },
                    get filteredRows() {
                        const query = this.search.trim().toLowerCase();

                        return this.rows.filter((room) => {
                            const haystack = `${room.room_number} ${room.room_type} ${room.floor} ${room.wing} ${room.status_label}`.toLowerCase();
                            const matchesSearch = query === '' || haystack.includes(query);
                            const matchesStatus = this.status === 'all' || room.status === this.status;
                            const matchesType = this.roomType === 'all' || room.room_type === this.roomType;

                            return matchesSearch && matchesStatus && matchesType;
                        });
                    },
                    get sortedRows() {
                        return [...this.filteredRows].sort((a, b) => {
                            const left = a[this.sortKey];
                            const right = b[this.sortKey];
                            const direction = this.sortDirection === 'asc' ? 1 : -1;

                            if (typeof left === 'number' && typeof right === 'number') {
                                return (left - right) * direction;
                            }

                            return String(left).localeCompare(String(right)) * direction;
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
                    openPreview(room) {
                        this.selectedRoom = room;
                        this.previewOpen = true;
                        this.refreshIcons();
                    },
                    deleteRoom(id) {
                        if (! window.confirm('Delete this room from the current directory view?')) {
                            return;
                        }

                        this.rows = this.rows.filter((room) => room.id !== id);
                        this.refreshIcons();
                    },
                    money(value) {
                        return `${new Intl.NumberFormat('en-US').format(Math.round(Number(value) || 0))} ៛`;
                    },
                    statusClass(status) {
                        return {
                            available: 'border-[#2F6F3E]/20 bg-[#2F6F3E]/10 text-[#2F6F3E]',
                            occupied: 'border-amber-100 bg-amber-50 text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300',
                            reserved: 'border-sky-100 bg-sky-50 text-sky-700 dark:border-sky-500/20 dark:bg-sky-500/10 dark:text-sky-300',
                            maintenance: 'border-red-100 bg-red-50 text-red-700 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-300',
                            cleaning: 'border-violet-100 bg-violet-50 text-violet-700 dark:border-violet-500/20 dark:bg-violet-500/10 dark:text-violet-300',
                        }[status] || 'border-slate-200 bg-slate-100 text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300';
                    },
                };
            }
        </script>
    @endpush
@endonce
