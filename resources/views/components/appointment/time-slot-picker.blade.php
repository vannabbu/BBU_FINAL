<x-ui.card>
    <div class="flex items-start justify-between gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
        <div class="flex items-start gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#2F6F3E]/10 text-[#2F6F3E]">
                <i data-lucide="clock-3" class="h-5 w-5"></i>
            </div>
            <div>
                <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">Available Time Slots</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Select an available consultation time.</p>
            </div>
        </div>
        <span x-show="nextAvailableSlot" class="hidden rounded-full bg-blue-50 px-3 py-1.5 text-xs font-extrabold text-blue-700 dark:bg-blue-500/10 dark:text-blue-300 sm:inline-flex">
            Next: <span class="ml-1" x-text="nextAvailableSlot"></span>
        </span>
    </div>

    <div class="mt-5">
        <div x-show="slotsLoading" class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
            @for ($i = 0; $i < 6; $i++)
                <div class="h-14 animate-pulse rounded-2xl bg-slate-100 dark:bg-slate-800"></div>
            @endfor
        </div>

        <div x-cloak x-show="! slotsLoading && timeSlots.length > 0" class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
            <template x-for="slot in timeSlots" :key="slot.time">
                <button
                    type="button"
                    x-on:click="selectTimeSlot(slot)"
                    x-bind:disabled="slot.status === 'booked'"
                    x-bind:class="slotButtonClass(slot)"
                    class="flex min-h-14 items-center justify-between rounded-2xl border px-4 py-3 text-left transition disabled:cursor-not-allowed"
                >
                    <span>
                        <span class="block text-sm font-extrabold" x-text="slot.time"></span>
                        <span class="mt-1 block text-xs font-bold opacity-70" x-text="slot.label"></span>
                    </span>
                    <i x-show="form.selected_time === slot.time" data-lucide="check-circle-2" class="h-5 w-5"></i>
                    <i x-show="slot.status === 'booked'" data-lucide="lock" class="h-4 w-4"></i>
                </button>
            </template>
        </div>

        <div x-cloak x-show="! slotsLoading && timeSlots.length === 0" class="rounded-2xl border border-dashed border-slate-200 p-8 text-center dark:border-slate-700">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                <i data-lucide="calendar-x" class="h-6 w-6"></i>
            </div>
            <h3 class="mt-4 text-base font-extrabold text-slate-950 dark:text-white">No available slots</h3>
            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500 dark:text-slate-400">Try another appointment date or use the next available suggestion.</p>
        </div>

        <p x-show="errors.selected_time" x-text="errors.selected_time" class="mt-3 text-xs font-bold text-red-600"></p>
        <p x-show="conflictMessage" x-text="conflictMessage" class="mt-3 rounded-2xl bg-red-50 px-4 py-3 text-sm font-bold text-red-700 dark:bg-red-500/10 dark:text-red-300"></p>
    </div>
</x-ui.card>
