@props(['activities'])

<section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-[0_12px_30px_rgba(15,23,42,0.04)] dark:border-slate-800 dark:bg-slate-900 sm:p-6">
    <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">សកម្មភាពថ្មីៗ</h2>
    <div class="mt-5 space-y-4">
        @foreach ($activities as $activity)
            <div class="flex gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-[#2F6F3E]/10 text-[#2F6F3E]">
                    <i data-lucide="{{ $activity['icon'] }}" class="h-4 w-4"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-bold text-slate-900 dark:text-white">{{ $activity['title'] }}</p>
                    <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">{{ $activity['description'] }}</p>
                    <p class="mt-1 text-xs font-semibold text-slate-400">{{ $activity['time'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>
