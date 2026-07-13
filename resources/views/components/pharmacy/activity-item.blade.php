@props(['activity'])

@php
    $tones = [
        'green' => 'bg-[#2F6F3E]/10 text-[#2F6F3E]',
        'blue' => 'bg-sky-50 text-sky-700 dark:bg-sky-500/10 dark:text-sky-300',
        'amber' => 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-300',
        'violet' => 'bg-violet-50 text-violet-700 dark:bg-violet-500/10 dark:text-violet-300',
        'red' => 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-300',
    ][$activity['tone'] ?? 'green'] ?? 'bg-[#2F6F3E]/10 text-[#2F6F3E]';
@endphp

<article class="flex gap-3 rounded-2xl border border-slate-100 bg-slate-50/70 p-4 dark:border-slate-800 dark:bg-slate-800/50">
    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl {{ $tones }}">
        <i data-lucide="{{ $activity['icon'] }}" class="h-4 w-4"></i>
    </div>
    <div class="min-w-0 flex-1">
        <div class="flex items-start justify-between gap-3">
            <h3 class="text-sm font-extrabold text-slate-950 dark:text-white">{{ $activity['title'] }}</h3>
            <span class="shrink-0 text-xs font-bold text-slate-400">{{ $activity['time'] }}</span>
        </div>
        <p class="mt-1 text-sm leading-6 text-slate-500 dark:text-slate-400">{{ $activity['description'] }}</p>
    </div>
</article>
