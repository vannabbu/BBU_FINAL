@props([
    'title',
    'value',
    'description',
    'icon' => 'bed-double',
    'tone' => 'green',
])

@php
    $tones = [
        'green' => 'bg-[#2F6F3E]/10 text-[#2F6F3E]',
        'blue' => 'bg-sky-50 text-sky-700 dark:bg-sky-500/10 dark:text-sky-300',
        'amber' => 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-300',
        'red' => 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-300',
    ][$tone] ?? 'bg-[#2F6F3E]/10 text-[#2F6F3E]';
@endphp

<article class="group rounded-2xl border border-[#E5E7EB] bg-white p-5 shadow-[0_12px_30px_rgba(15,23,42,0.04)] transition duration-200 hover:-translate-y-1 hover:shadow-[0_18px_45px_rgba(15,23,42,0.08)] dark:border-slate-800 dark:bg-slate-900">
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-sm font-bold text-slate-500 dark:text-slate-400">{{ $title }}</p>
            <p class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950 dark:text-white">{{ $value }}</p>
            <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">{{ $description }}</p>
        </div>
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl {{ $tones }} transition group-hover:scale-105">
            <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
        </div>
    </div>
</article>
