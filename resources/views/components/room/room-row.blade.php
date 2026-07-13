<template x-for="room in paginatedRows" :key="room.id">
    <tr class="border-b border-slate-100 transition hover:bg-slate-50/80 dark:border-slate-800 dark:hover:bg-slate-800/50">
        <td class="sticky left-0 bg-white px-5 py-4 dark:bg-slate-900">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-[#2F6F3E]/10 text-[#2F6F3E]">
                    <i data-lucide="door-open" class="h-4 w-4"></i>
                </div>
                <div>
                    <p class="text-sm font-extrabold text-slate-950 dark:text-white" x-text="room.room_number"></p>
                    <p class="mt-1 text-xs font-semibold text-slate-500 dark:text-slate-400" x-text="room.id"></p>
                </div>
            </div>
        </td>
        <td class="whitespace-nowrap px-5 py-4 text-sm font-bold text-slate-700 dark:text-slate-300" x-text="room.room_type"></td>
        <td class="whitespace-nowrap px-5 py-4">
            <p class="text-sm font-bold text-slate-700 dark:text-slate-300" x-text="room.floor"></p>
            <p class="mt-1 text-xs font-semibold text-slate-500 dark:text-slate-400" x-text="room.wing"></p>
        </td>
        <td class="whitespace-nowrap px-5 py-4 text-sm font-extrabold text-slate-950 dark:text-white" x-text="money(room.price_per_day)"></td>
        <td class="whitespace-nowrap px-5 py-4">
            <x-room.status-badge dynamic x-text="room.status_label" x-bind:class="statusClass(room.status)" />
        </td>
        <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-slate-500 dark:text-slate-400" x-text="room.last_updated"></td>
        <td class="px-5 py-4 text-right">
            <div class="flex justify-end gap-2">
                <button type="button" x-on:click="openPreview(room)" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50 hover:text-[#2F6F3E] dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800" aria-label="View room">
                    <i data-lucide="eye" class="h-4 w-4"></i>
                </button>
                <a x-bind:href="room.edit_url" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50 hover:text-[#2F6F3E] dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800" aria-label="Edit room">
                    <i data-lucide="pencil" class="h-4 w-4"></i>
                </a>
                <button type="button" x-on:click="deleteRoom(room.id)" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-red-100 bg-red-50 text-red-600 transition hover:bg-red-100 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-300" aria-label="Delete room">
                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                </button>
            </div>
        </td>
    </tr>
</template>
