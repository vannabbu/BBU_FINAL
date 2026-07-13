@props([
    'percentage' => 0,
    'caption' => '',
    'stats' => [],
])

@php
    $offset = 314 - (314 * (int) $percentage / 100);
@endphp

<section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-[0_12px_30px_rgba(15,23,42,0.04)] dark:border-slate-800 dark:bg-slate-900 sm:p-6">
    <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">ប្រសិទ្ធភាពមន្ទីរពេទ្យ</h2>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $caption }}</p>
    <div class="mt-6 flex items-center justify-center">
        <div class="relative h-44 w-44">
            <svg viewBox="0 0 120 120" class="h-full w-full -rotate-90">
                <circle cx="60" cy="60" r="50" fill="none" stroke="currentColor" stroke-width="12" class="text-slate-100 dark:text-slate-800" />
                <circle cx="60" cy="60" r="50" fill="none" stroke="#2F6F3E" stroke-width="12" stroke-linecap="round" stroke-dasharray="314" stroke-dashoffset="{{ $offset }}" />
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-3xl font-extrabold text-slate-950 dark:text-white">{{ $percentage }}%</span>
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">សរុប</span>
            </div>
        </div>
    </div>
    <div class="mt-6 grid gap-3">
        @foreach ($stats as $stat)
            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-800">
                <span class="text-sm font-semibold text-slate-600 dark:text-slate-300">{{ $stat['label'] }}</span>
                <span class="text-sm font-extrabold text-slate-950 dark:text-white">{{ $stat['value'] }}</span>
            </div>
        @endforeach
    </div>
</section>
