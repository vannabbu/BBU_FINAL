@props([
    'title',
    'value',
    'change',
    'badge',
    'icon' => 'activity',
    'tone' => 'green',
])

@php
    $tones = [
        'green' => 'bg-[#2F6F3E]/10 text-[#2F6F3E]',
        'blue' => 'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-300',
        'violet' => 'bg-violet-50 text-violet-700 dark:bg-violet-500/10 dark:text-violet-300',
        'orange' => 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-300',
        'red' => 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-300',
    ][$tone] ?? 'bg-[#2F6F3E]/10 text-[#2F6F3E]';
@endphp

<article class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-[0_12px_30px_rgba(15,23,42,0.04)] transition duration-200 hover:-translate-y-1 hover:shadow-[0_18px_45px_rgba(15,23,42,0.08)] dark:border-slate-800 dark:bg-slate-900">
    <div class="flex items-start justify-between gap-3">
        <div class="flex h-11 w-11 items-center justify-center rounded-2xl {{ $tones }}">
            <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
        </div>
        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ $badge }}</span>
    </div>
    <p class="mt-5 text-sm font-semibold text-slate-500 dark:text-slate-400">{{ $title }}</p>
    <div class="mt-2 flex items-end justify-between gap-3">
        <p class="text-2xl font-extrabold text-slate-950 dark:text-white">{{ $value }}</p>
        <span class="inline-flex items-center gap-1 rounded-full bg-[#16A34A]/10 px-2 py-1 text-xs font-bold text-[#16A34A]">
            <i data-lucide="trending-up" class="h-3 w-3"></i>
            {{ $change }}
        </span>
    </div>
</article>
