@php
    $isEdit = $mode === 'edit';
@endphp

<x-layout.app :title="$isEdit ? 'Edit Employee' : 'Add Employee'" :navigation="$navigation" :doctor="$doctor">
    <x-layout.breadcrumb :items="[
        ['label' => 'ទំព័រដើម', 'href' => route('dashboard')],
        ['label' => 'Staff', 'href' => url('/staff')],
        ['label' => $isEdit ? 'Edit Employee' : 'Add Employee', 'href' => null],
    ]" />

    <x-layout.page-header
        :title="$isEdit ? 'Edit Employee' : 'Add Employee'"
        subtitle="Create or update employee identity, employment details, account access, roles, and permissions."
    >
        <a href="{{ url('/staff') }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-extrabold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Back to Staff
        </a>
    </x-layout.page-header>

    <div class="mt-6">
        <x-staff.employee-form
            :employee="$employee"
            :departments="$departments"
            :roles="$roles"
            :statuses="$statuses"
            :employment-types="$employmentTypes"
            :shifts="$shifts"
            :permissions="$permissions"
            :mode="$mode"
        />
    </div>
</x-layout.app>
