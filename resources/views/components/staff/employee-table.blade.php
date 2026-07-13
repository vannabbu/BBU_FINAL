@props([
    'employees' => [],
    'departments' => [],
    'roles' => [],
    'statuses' => [],
])

<section
    x-data="staffDirectory(@js($employees->values()))"
    x-init="init()"
    class="space-y-5"
>
    <x-staff.filter-toolbar :departments="$departments" :roles="$roles" :statuses="$statuses" />

    <div class="rounded-2xl border border-[#E5E7EB] bg-white shadow-[0_12px_30px_rgba(15,23,42,0.04)] dark:border-slate-800 dark:bg-slate-900">
        <div class="border-b border-slate-100 p-5 dark:border-slate-800 sm:p-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">Employee Directory</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Professional staff and system account directory.</p>
                </div>
                <span class="inline-flex items-center gap-2 rounded-full bg-[#2F6F3E]/10 px-3 py-1.5 text-xs font-extrabold text-[#2F6F3E]">
                    <i data-lucide="database" class="h-3.5 w-3.5"></i>
                    <span x-text="filteredRows.length"></span> employees
                </span>
            </div>
        </div>

        <div x-show="loading" class="space-y-3 p-5 sm:p-6">
            @for ($i = 0; $i < 6; $i++)
                <div class="animate-pulse rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/60">
                    <div class="flex items-center gap-4">
                        <div class="h-11 w-11 rounded-2xl bg-slate-200 dark:bg-slate-700"></div>
                        <div class="flex-1 space-y-2">
                            <div class="h-3 w-1/3 rounded bg-slate-200 dark:bg-slate-700"></div>
                            <div class="h-3 w-1/4 rounded bg-slate-200 dark:bg-slate-700"></div>
                        </div>
                        <div class="hidden h-8 w-28 rounded-full bg-slate-200 dark:bg-slate-700 sm:block"></div>
                    </div>
                </div>
            @endfor
        </div>

        <div x-cloak x-show="! loading">
            <div class="hidden max-h-[680px] overflow-auto xl:block">
                <table class="min-w-full text-left">
                    <thead class="sticky top-0 z-10 border-b border-slate-100 bg-slate-50 text-xs font-extrabold uppercase tracking-wide text-slate-500 dark:border-slate-800 dark:bg-slate-800 dark:text-slate-400">
                        <tr>
                            <th class="sticky left-0 bg-slate-50 px-5 py-3 dark:bg-slate-800">
                                <button type="button" x-on:click="setSort('id')" class="inline-flex items-center gap-1 hover:text-[#2F6F3E]">Employee ID <i data-lucide="arrow-up-down" class="h-3.5 w-3.5"></i></button>
                            </th>
                            <th class="px-5 py-3">Avatar</th>
                            <th class="px-5 py-3">
                                <button type="button" x-on:click="setSort('full_name')" class="inline-flex items-center gap-1 hover:text-[#2F6F3E]">Full Name <i data-lucide="arrow-up-down" class="h-3.5 w-3.5"></i></button>
                            </th>
                            <th class="px-5 py-3">
                                <button type="button" x-on:click="setSort('department')" class="inline-flex items-center gap-1 hover:text-[#2F6F3E]">Department <i data-lucide="arrow-up-down" class="h-3.5 w-3.5"></i></button>
                            </th>
                            <th class="px-5 py-3">Position</th>
                            <th class="px-5 py-3">Role</th>
                            <th class="px-5 py-3">Phone</th>
                            <th class="px-5 py-3">Email</th>
                            <th class="px-5 py-3">
                                <button type="button" x-on:click="setSort('status')" class="inline-flex items-center gap-1 hover:text-[#2F6F3E]">Status <i data-lucide="arrow-up-down" class="h-3.5 w-3.5"></i></button>
                            </th>
                            <th class="px-5 py-3">Joined Date</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <x-staff.employee-row />
                    </tbody>
                </table>
            </div>

            <div class="grid gap-4 p-5 xl:hidden">
                <template x-for="employee in paginatedRows" :key="employee.id">
                    <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-[#2F6F3E]/30 dark:border-slate-800 dark:bg-slate-900">
                        <div class="flex items-start gap-3">
                            <img x-bind:src="employee.avatar" x-bind:alt="employee.full_name" class="h-14 w-14 rounded-2xl object-cover">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <p class="text-xs font-extrabold text-[#2F6F3E]" x-text="employee.id"></p>
                                        <h3 class="mt-1 text-base font-extrabold text-slate-950 dark:text-white" x-text="employee.full_name"></h3>
                                    </div>
                                    <x-staff.status-badge dynamic x-text="employee.status_label" x-bind:class="statusClass(employee.status)" />
                                </div>
                                <p class="mt-1 text-sm font-semibold text-slate-500 dark:text-slate-400" x-text="employee.position + ' • ' + employee.department"></p>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <x-staff.role-badge dynamic x-text="employee.role" x-bind:class="roleClass(employee.role)" />
                                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-600 dark:bg-slate-800 dark:text-slate-300" x-text="employee.phone"></span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 grid gap-2 sm:grid-cols-2">
                            <button type="button" x-on:click="openProfile(employee)" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm font-extrabold text-slate-700 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                                <i data-lucide="eye" class="h-4 w-4"></i>
                                View Profile
                            </button>
                            <a x-bind:href="employee.edit_url" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-[#2F6F3E] px-3 py-2 text-sm font-extrabold text-white">
                                <i data-lucide="pencil" class="h-4 w-4"></i>
                                Edit
                            </a>
                        </div>
                    </article>
                </template>
            </div>

            <div x-show="paginatedRows.length === 0" class="px-5 py-14 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <i data-lucide="user-search" class="h-6 w-6"></i>
                </div>
                <h3 class="mt-4 text-base font-extrabold text-slate-950 dark:text-white">No employees found</h3>
                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500 dark:text-slate-400">Try changing the search keyword, department, role, or status filter.</p>
            </div>

            <div class="flex flex-col gap-3 border-t border-slate-100 px-5 py-4 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">
                    Showing <span class="font-extrabold text-slate-950 dark:text-white" x-text="paginatedRows.length"></span>
                    of <span class="font-extrabold text-slate-950 dark:text-white" x-text="filteredRows.length"></span> employees
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
    </div>

    <x-staff.employee-profile-modal />
</section>

@once
    @push('scripts')
        <script>
            function staffDirectory(initialRows) {
                return {
                    rows: initialRows,
                    search: '',
                    department: 'all',
                    role: 'all',
                    status: 'all',
                    sortKey: 'id',
                    sortDirection: 'asc',
                    page: 1,
                    perPage: 5,
                    loading: true,
                    profileOpen: false,
                    selectedEmployee: null,
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
                    resetFilters() {
                        this.search = '';
                        this.department = 'all';
                        this.role = 'all';
                        this.status = 'all';
                        this.page = 1;
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

                        return this.rows.filter((employee) => {
                            const haystack = `${employee.id} ${employee.full_name} ${employee.phone} ${employee.email}`.toLowerCase();
                            const matchesSearch = query === '' || haystack.includes(query);
                            const matchesDepartment = this.department === 'all' || employee.department === this.department;
                            const matchesRole = this.role === 'all' || employee.role === this.role;
                            const matchesStatus = this.status === 'all' || employee.status === this.status;

                            return matchesSearch && matchesDepartment && matchesRole && matchesStatus;
                        });
                    },
                    get sortedRows() {
                        return [...this.filteredRows].sort((a, b) => {
                            const left = a[this.sortKey] ?? '';
                            const right = b[this.sortKey] ?? '';
                            const direction = this.sortDirection === 'asc' ? 1 : -1;

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
                    openProfile(employee) {
                        this.selectedEmployee = employee;
                        this.profileOpen = true;
                        this.refreshIcons();
                    },
                    confirmAction(message) {
                        window.confirm(message);
                    },
                    disableEmployee(id) {
                        if (! window.confirm('Disable this employee account?')) {
                            return;
                        }

                        this.rows = this.rows.map((employee) => employee.id === id ? {
                            ...employee,
                            status: 'inactive',
                            status_label: 'Inactive',
                            account_status: 'Disabled',
                        } : employee);
                    },
                    deleteEmployee(id) {
                        if (! window.confirm('Delete this employee from the current directory view?')) {
                            return;
                        }

                        this.rows = this.rows.filter((employee) => employee.id !== id);
                    },
                    statusClass(status) {
                        return {
                            active: 'border-[#16A34A]/20 bg-[#16A34A]/10 text-[#16A34A]',
                            on_leave: 'border-[#F59E0B]/20 bg-[#F59E0B]/10 text-[#B45309] dark:text-amber-300',
                            suspended: 'border-[#DC2626]/20 bg-[#DC2626]/10 text-[#DC2626]',
                            inactive: 'border-slate-200 bg-slate-100 text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300',
                            resigned: 'border-zinc-200 bg-zinc-100 text-zinc-700 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300',
                        }[status] || 'border-slate-200 bg-slate-100 text-slate-700';
                    },
                    roleClass(role) {
                        return {
                            Administrator: 'border-violet-100 bg-violet-50 text-violet-700 dark:border-violet-500/20 dark:bg-violet-500/10 dark:text-violet-300',
                            Doctor: 'border-blue-100 bg-blue-50 text-blue-700 dark:border-blue-500/20 dark:bg-blue-500/10 dark:text-blue-300',
                            Nurse: 'border-pink-100 bg-pink-50 text-pink-700 dark:border-pink-500/20 dark:bg-pink-500/10 dark:text-pink-300',
                            Receptionist: 'border-cyan-100 bg-cyan-50 text-cyan-700 dark:border-cyan-500/20 dark:bg-cyan-500/10 dark:text-cyan-300',
                            Pharmacist: 'border-[#2F6F3E]/20 bg-[#2F6F3E]/10 text-[#2F6F3E]',
                            'Laboratory Technician': 'border-amber-100 bg-amber-50 text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300',
                            Cashier: 'border-emerald-100 bg-emerald-50 text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300',
                            'HR Officer': 'border-slate-200 bg-slate-100 text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300',
                        }[role] || 'border-slate-200 bg-slate-100 text-slate-700';
                    },
                };
            }
        </script>
    @endpush
@endonce
