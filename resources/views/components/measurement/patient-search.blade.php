@props(['recentPatients' => []])

<div class="relative">
    <label class="block">
        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Search Patient</span>
        <span class="relative block">
            <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
            <input
                type="search"
                x-model.debounce.150ms="patientQuery"
                x-on:focus="patientSearchOpen = true"
                placeholder="Search by patient ID, name, phone, or scan Patient ID..."
                class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 pl-10 pr-12 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900"
            >
            <button type="button" x-on:click="simulateQrLookup()" class="absolute right-2 top-1/2 inline-flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-xl bg-[#2F6F3E]/10 text-[#2F6F3E] transition hover:bg-[#2F6F3E] hover:text-white" title="QR code / Patient ID lookup">
                <i data-lucide="qr-code" class="h-4 w-4"></i>
            </button>
        </span>
    </label>

    <div
        x-cloak
        x-show="patientSearchOpen"
        x-transition
        x-on:click.outside="patientSearchOpen = false"
        class="absolute left-0 right-0 top-[76px] z-30 overflow-hidden rounded-2xl border border-slate-200 bg-white p-2 shadow-xl dark:border-slate-700 dark:bg-slate-900"
    >
        <template x-if="patientQuery.length === 0">
            <div class="p-2">
                <p class="px-2 pb-2 text-xs font-extrabold uppercase tracking-wide text-slate-400">Recently viewed patients</p>
                @foreach ($recentPatients as $patient)
                    <button type="button" x-on:click="selectPatient(@js($patient))" class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left transition hover:bg-slate-100 dark:hover:bg-slate-800">
                        <img src="{{ $patient['avatar'] }}" alt="{{ $patient['full_name'] }}" class="h-10 w-10 rounded-xl object-cover">
                        <span class="min-w-0">
                            <span class="block truncate text-sm font-extrabold text-slate-950 dark:text-white">{{ $patient['full_name'] }}</span>
                            <span class="mt-1 block text-xs font-bold text-slate-500">{{ $patient['id'] }} • {{ $patient['phone'] }}</span>
                        </span>
                    </button>
                @endforeach
            </div>
        </template>

        <template x-if="patientQuery.length > 0">
            <div>
                <template x-for="patient in filteredPatients.slice(0, 5)" :key="patient.id">
                    <button type="button" x-on:click="selectPatient(patient)" class="flex w-full items-center justify-between gap-3 rounded-xl px-3 py-3 text-left transition hover:bg-slate-100 dark:hover:bg-slate-800">
                        <span class="flex min-w-0 items-center gap-3">
                            <img x-bind:src="patient.avatar" x-bind:alt="patient.full_name" class="h-10 w-10 rounded-xl object-cover">
                            <span class="min-w-0">
                                <span class="block truncate text-sm font-extrabold text-slate-950 dark:text-white" x-text="patient.full_name"></span>
                                <span class="mt-1 block text-xs font-bold text-slate-500" x-text="patient.id + ' • ' + patient.phone"></span>
                            </span>
                        </span>
                        <i data-lucide="arrow-right" class="h-4 w-4 text-slate-400"></i>
                    </button>
                </template>

                <div x-show="filteredPatients.length === 0" class="px-3 py-6 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                        <i data-lucide="user-search" class="h-5 w-5"></i>
                    </div>
                    <p class="mt-3 text-sm font-bold text-slate-600 dark:text-slate-300">No patient found</p>
                    <p class="mt-1 text-xs text-slate-500">Try another ID, phone, or full name.</p>
                </div>
            </div>
        </template>
    </div>
</div>
