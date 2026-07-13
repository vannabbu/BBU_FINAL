<template x-for="employee in paginatedRows" :key="employee.id">
    <tr class="border-b border-slate-100 transition hover:bg-slate-50/80 dark:border-slate-800 dark:hover:bg-slate-800/50">
        <td class="sticky left-0 bg-white px-5 py-4 dark:bg-slate-900">
            <span class="text-sm font-extrabold text-[#2F6F3E]" x-text="employee.id"></span>
        </td>
        <td class="px-5 py-4">
            <img x-bind:src="employee.avatar" x-bind:alt="employee.full_name" class="h-11 w-11 rounded-2xl object-cover ring-2 ring-white dark:ring-slate-900">
        </td>
        <td class="px-5 py-4">
            <p class="whitespace-nowrap text-sm font-extrabold text-slate-950 dark:text-white" x-text="employee.full_name"></p>
            <p class="mt-1 whitespace-nowrap text-xs font-semibold text-slate-500 dark:text-slate-400" x-text="employee.username"></p>
        </td>
        <td class="whitespace-nowrap px-5 py-4 text-sm font-bold text-slate-600 dark:text-slate-300" x-text="employee.department"></td>
        <td class="whitespace-nowrap px-5 py-4 text-sm font-bold text-slate-600 dark:text-slate-300" x-text="employee.position"></td>
        <td class="whitespace-nowrap px-5 py-4">
            <x-staff.role-badge dynamic x-text="employee.role" x-bind:class="roleClass(employee.role)" />
        </td>
        <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-slate-500 dark:text-slate-400" x-text="employee.phone"></td>
        <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-slate-500 dark:text-slate-400" x-text="employee.email"></td>
        <td class="whitespace-nowrap px-5 py-4">
            <x-staff.status-badge dynamic x-text="employee.status_label" x-bind:class="statusClass(employee.status)" />
        </td>
        <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-slate-500 dark:text-slate-400" x-text="employee.join_date"></td>
        <td class="px-5 py-4 text-right">
            <div x-data="{ open: false }" class="relative inline-flex">
                <button type="button" x-on:click="open = ! open" x-on:keydown.escape.window="open = false" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800" aria-label="Open employee actions">
                    <i data-lucide="more-horizontal" class="h-4 w-4"></i>
                </button>
                <div x-cloak x-show="open" x-transition x-on:click.outside="open = false" class="absolute right-0 top-12 z-30 w-56 rounded-2xl border border-slate-200 bg-white p-2 text-left shadow-xl dark:border-slate-700 dark:bg-slate-900">
                    <button type="button" x-on:click="open = false; openProfile(employee)" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
                        <i data-lucide="eye" class="h-4 w-4"></i>
                        View Profile
                    </button>
                    <a x-bind:href="employee.edit_url" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
                        <i data-lucide="pencil" class="h-4 w-4"></i>
                        Edit Employee
                    </a>
                    <button type="button" x-on:click="confirmAction('Reset password for ' + employee.full_name + '?')" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
                        <i data-lucide="key-round" class="h-4 w-4"></i>
                        Reset Password
                    </button>
                    <button type="button" x-on:click="confirmAction('Change role for ' + employee.full_name + '?')" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
                        <i data-lucide="shield" class="h-4 w-4"></i>
                        Change Role
                    </button>
                    <button type="button" x-on:click="disableEmployee(employee.id)" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-amber-700 hover:bg-amber-50 dark:text-amber-300 dark:hover:bg-amber-500/10">
                        <i data-lucide="user-x" class="h-4 w-4"></i>
                        Disable Account
                    </button>
                    <button type="button" x-on:click="deleteEmployee(employee.id)" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10">
                        <i data-lucide="trash-2" class="h-4 w-4"></i>
                        Delete Employee
                    </button>
                </div>
            </div>
        </td>
    </tr>
</template>
