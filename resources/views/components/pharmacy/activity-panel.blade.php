@props(['activities' => []])

<section class="rounded-2xl border border-[#E5E7EB] bg-white p-5 shadow-[0_12px_30px_rgba(15,23,42,0.04)] dark:border-slate-800 dark:bg-slate-900">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">សកម្មភាពថ្មីៗ</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Recent pharmacy activity</p>
        </div>
        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#2F6F3E]/10 px-3 py-1.5 text-xs font-extrabold text-[#2F6F3E]">
            <span class="h-2 w-2 rounded-full bg-[#2F6F3E]"></span>
            Live
        </span>
    </div>

    <div class="mt-5 space-y-3">
        @foreach ($activities as $activity)
            <x-pharmacy.activity-item :activity="$activity" />
        @endforeach
    </div>
</section>
