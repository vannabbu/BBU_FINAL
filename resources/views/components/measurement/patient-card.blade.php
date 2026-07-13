@props([
    'recentPatients' => [],
    'visit' => [],
    'departments' => [],
    'doctors' => [],
])

<x-ui.card>
    <div class="flex items-start gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#2F6F3E]/10 text-[#2F6F3E]">
            <i data-lucide="user-round-check" class="h-5 w-5"></i>
        </div>
        <div>
            <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">Patient Information</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Search patient, confirm identity, and attach measurement to current visit.</p>
        </div>
    </div>

    <div class="mt-5">
        <x-measurement.patient-search :recent-patients="$recentPatients" />
    </div>

    <div x-show="! selectedPatient" class="mt-5 rounded-2xl border border-dashed border-slate-200 p-8 text-center dark:border-slate-700">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
            <i data-lucide="scan-search" class="h-6 w-6"></i>
        </div>
        <h3 class="mt-4 text-base font-extrabold text-slate-950 dark:text-white">No patient selected</h3>
        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500 dark:text-slate-400">Search an existing patient or use QR / Patient ID lookup to begin recording vital signs.</p>
    </div>

    <div x-cloak x-show="selectedPatient" x-transition class="mt-5 space-y-5">
        <div class="flex flex-col gap-4 rounded-2xl bg-slate-50 p-4 dark:bg-slate-800 sm:flex-row sm:items-center">
            <img x-bind:src="selectedPatient?.avatar" x-bind:alt="selectedPatient?.full_name" class="h-20 w-20 rounded-2xl object-cover ring-4 ring-white dark:ring-slate-900">
            <div class="min-w-0 flex-1">
                <div class="flex flex-wrap items-center gap-2">
                    <h3 class="text-xl font-extrabold text-slate-950 dark:text-white" x-text="selectedPatient?.full_name"></h3>
                    <span class="rounded-full bg-[#2F6F3E]/10 px-3 py-1 text-xs font-extrabold text-[#2F6F3E]" x-text="selectedPatient?.id"></span>
                </div>
                <div class="mt-3 grid gap-2 text-sm sm:grid-cols-2">
                    <p class="font-semibold text-slate-500">Gender: <span class="font-extrabold text-slate-900 dark:text-white" x-text="selectedPatient?.gender"></span></p>
                    <p class="font-semibold text-slate-500">Age: <span class="font-extrabold text-slate-900 dark:text-white" x-text="selectedPatient?.age + ' years'"></span></p>
                    <p class="font-semibold text-slate-500">Blood Type: <span class="font-extrabold text-slate-900 dark:text-white" x-text="selectedPatient?.blood_type"></span></p>
                    <p class="font-semibold text-slate-500">Visit ID: <span class="font-extrabold text-slate-900 dark:text-white" x-text="selectedPatient?.visit_id"></span></p>
                </div>
            </div>
        </div>

        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-4 dark:border-slate-700 dark:bg-slate-900">
                <p class="text-xs font-bold text-slate-400">Height</p>
                <p class="mt-1 text-lg font-extrabold text-slate-950 dark:text-white"><span x-text="selectedPatient?.height"></span> cm</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-4 dark:border-slate-700 dark:bg-slate-900">
                <p class="text-xs font-bold text-slate-400">Latest Weight</p>
                <p class="mt-1 text-lg font-extrabold text-slate-950 dark:text-white"><span x-text="selectedPatient?.weight"></span> kg</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-4 dark:border-slate-700 dark:bg-slate-900 sm:col-span-2">
                <p class="text-xs font-bold text-slate-400">Allergies</p>
                <div class="mt-2 flex flex-wrap gap-2">
                    <template x-for="allergy in selectedPatient?.allergies || []" :key="allergy">
                        <span x-bind:class="allergy === 'None' ? 'bg-[#16A34A]/10 text-[#16A34A]' : 'bg-[#DC2626]/10 text-[#DC2626]'" class="rounded-full px-3 py-1 text-xs font-extrabold" x-text="allergy"></span>
                    </template>
                </div>
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <label class="block">
                <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Visit Date</span>
                <input type="date" x-model="visit.date" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
            </label>
            <label class="block">
                <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Visit Time</span>
                <input type="time" x-model="visit.time" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
            </label>
            <label class="block">
                <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Department</span>
                <select x-model="visit.department" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
                    @foreach ($departments as $department)
                        <option value="{{ $department }}">{{ $department }}</option>
                    @endforeach
                </select>
            </label>
            <label class="block">
                <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Assigned Doctor</span>
                <select x-model="visit.assigned_doctor" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor }}">{{ $doctor }}</option>
                    @endforeach
                </select>
            </label>
        </div>
    </div>
</x-ui.card>
