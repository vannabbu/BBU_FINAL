@props(['calendar' => []])

<x-ui.card>
    <div class="flex items-start gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-300">
            <i data-lucide="calendar-days" class="h-5 w-5"></i>
        </div>
        <div>
            <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">Appointment Date</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Pick a date and review doctor availability.</p>
        </div>
    </div>

    <div class="mt-5 grid gap-5 lg:grid-cols-[minmax(0,1fr)_280px]">
        <label class="block">
            <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Appointment Date</span>
            <input
                type="date"
                x-model="form.appointment_date"
                x-on:change="loadTimeSlots()"
                x-bind:class="fieldClass('appointment_date')"
                class="h-12 w-full rounded-2xl px-4 text-sm font-semibold text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900"
            >
            <p x-show="errors.appointment_date" x-text="errors.appointment_date" class="mt-2 text-xs font-bold text-red-600"></p>
        </label>

        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-800">
            <div class="mb-3 flex items-center justify-between">
                <p class="text-sm font-extrabold text-slate-950 dark:text-white">Availability Calendar</p>
                <span class="rounded-full bg-[#2F6F3E]/10 px-2.5 py-1 text-xs font-extrabold text-[#2F6F3E]">Live</span>
            </div>
            <div class="grid grid-cols-2 gap-2">
                @foreach ($calendar as $day)
                    <button
                        type="button"
                        x-on:click="form.appointment_date = @js($day['date']); loadTimeSlots()"
                        class="rounded-2xl border border-slate-200 bg-white p-3 text-left transition hover:border-[#2F6F3E]/40 dark:border-slate-700 dark:bg-slate-900"
                    >
                        <span class="block text-xs font-bold text-slate-500">{{ $day['label'] }}</span>
                        <span class="mt-1 block text-sm font-extrabold {{ $day['available'] > 0 ? 'text-[#2F6F3E]' : 'text-red-600' }}">
                            {{ $day['available'] }} slots
                        </span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</x-ui.card>
