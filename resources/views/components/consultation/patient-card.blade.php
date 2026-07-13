@props(['patient'])

<section class="rounded-2xl border border-[#E5E7EB] bg-white p-5 shadow-[0_12px_30px_rgba(15,23,42,0.04)] dark:border-slate-800 dark:bg-slate-900">
    <div class="flex items-start gap-4">
        <img src="{{ $patient['avatar'] }}" alt="{{ $patient['name'] }}" class="h-16 w-16 rounded-2xl object-cover ring-4 ring-[#2F6F3E]/10">
        <div class="min-w-0 flex-1">
            <div class="flex flex-wrap items-center gap-2">
                <h2 class="truncate text-lg font-extrabold text-slate-950 dark:text-white">{{ $patient['name'] }}</h2>
                <span class="rounded-full bg-[#2F6F3E]/10 px-2.5 py-1 text-xs font-bold text-[#2F6F3E]">កំពុងពិគ្រោះ</span>
            </div>
            <p class="mt-1 text-sm font-semibold text-slate-500 dark:text-slate-400">{{ $patient['id'] }}</p>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-2 gap-3">
        <div class="rounded-2xl bg-slate-50 p-3 dark:bg-slate-800">
            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">អាយុ</p>
            <p class="mt-1 text-base font-extrabold text-slate-950 dark:text-white">{{ $patient['age'] }} ឆ្នាំ</p>
        </div>
        <div class="rounded-2xl bg-slate-50 p-3 dark:bg-slate-800">
            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">ភេទ</p>
            <p class="mt-1 text-base font-extrabold text-slate-950 dark:text-white">{{ $patient['gender'] }}</p>
        </div>
        <div class="rounded-2xl bg-slate-50 p-3 dark:bg-slate-800">
            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">ក្រុមឈាម</p>
            <p class="mt-1 text-base font-extrabold text-slate-950 dark:text-white">{{ $patient['blood_group'] }}</p>
        </div>
        <div class="rounded-2xl bg-slate-50 p-3 dark:bg-slate-800">
            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">ពិនិត្យចុងក្រោយ</p>
            <p class="mt-1 text-base font-extrabold text-slate-950 dark:text-white">{{ $patient['last_visit'] }}</p>
        </div>
    </div>
</section>
