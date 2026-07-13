@props([
    'departments' => [],
    'roles' => [],
    'statuses' => [],
])

<x-ui.card>
    <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
        <div class="min-w-0 flex-1">
            <p class="text-sm font-extrabold text-slate-950 dark:text-white">Search & Filter</p>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Instantly filter employees by ID, name, phone, email, department, role, or status.</p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row">
            <x-ui.button label="Reset Filters" icon="rotate-ccw" tone="ghost" x-on:click="resetFilters()" />
            <x-ui.button label="Export Employees" icon="download" tone="primary" />
        </div>
    </div>

    <div class="mt-5 grid gap-3 lg:grid-cols-[minmax(0,1.5fr)_repeat(3,minmax(0,1fr))]">
        <x-ui.search-input
            placeholder="Search employee by ID, name, phone or email..."
            x-model.debounce.180ms="search"
            x-on:input="page = 1"
        />
        <x-ui.dropdown
            label="Department"
            placeholder="All Departments"
            :options="$departments"
            x-model="department"
            x-on:change="page = 1"
        />
        <x-ui.dropdown
            label="Role"
            placeholder="All Roles"
            :options="$roles"
            x-model="role"
            x-on:change="page = 1"
        />
        <x-ui.dropdown
            label="Status"
            placeholder="All Status"
            :options="$statuses"
            x-model="status"
            x-on:change="page = 1"
        />
    </div>
</x-ui.card>
