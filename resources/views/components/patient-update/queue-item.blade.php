@props(['item'])

@php
    $badge = [
        'green' => 'bg-[#2F6F3E]/10 text-[#2F6F3E] border-[#2F6F3E]/20',
        'blue' => 'bg-sky-50 text-sky-700 border-sky-100 dark:bg-sky-500/10 dark:text-sky-300 dark:border-sky-500/20',
        'amber' => 'bg-amber-50 text-amber-700 border-amber-100 dark:bg-amber-500/10 dark:text-amber-300 dark:border-amber-500/20',
        'red' => 'bg-red-50 text-red-700 border-red-100 dark:bg-red-500/10 dark:text-red-300 dark:border-red-500/20',
    ][$item['tone']] ?? 'bg-slate-100 text-slate-700 border-slate-200';
@endphp

<article
    x-show="filter === 'all' || filter === '{{ $item['status_key'] }}'"
    x-transition.opacity.scale.95
    class="rounded-2xl border border-slate-200 bg-white p-4 transition hover:border-[#2F6F3E]/30 hover:shadow-sm dark:border-slate-800 dark:bg-slate-900"
>
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0">
            <p class="text-xs font-extrabold text-[#2F6F3E]">{{ $item['number'] }}</p>
            <h3 class="mt-1 truncate text-sm font-extrabold text-slate-950 dark:text-white">{{ $item['name'] }}</h3>
            <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">{{ $item['reason'] }}</p>
        </div>
        <span class="shrink-0 rounded-full border px-2.5 py-1 text-xs font-bold {{ $badge }}">{{ $item['status'] }}</span>
    </div>
    <div class="mt-3 flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
        <i data-lucide="clock-3" class="h-3.5 w-3.5"></i>
        <span>{{ $item['wait'] }}</span>
    </div>
</article>
