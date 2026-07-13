@props([
    'label',
    'value',
    'unit',
    'status',
    'icon' => 'activity',
    'tone' => 'green',
])

@php
    $toneClasses = [
        'green' => 'bg-[#2F6F3E]/10 text-[#2F6F3E] border-[#2F6F3E]/15',
        'blue' => 'bg-sky-50 text-sky-700 border-sky-100 dark:bg-sky-500/10 dark:text-sky-300 dark:border-sky-500/20',
        'amber' => 'bg-amber-50 text-amber-700 border-amber-100 dark:bg-amber-500/10 dark:text-amber-300 dark:border-amber-500/20',
        'red' => 'bg-red-50 text-red-700 border-red-100 dark:bg-red-500/10 dark:text-red-300 dark:border-red-500/20',
    ][$tone] ?? 'bg-[#2F6F3E]/10 text-[#2F6F3E] border-[#2F6F3E]/15';
@endphp

<article class="rounded-2xl border border-[#E5E7EB] bg-white p-4 shadow-[0_12px_30px_rgba(15,23,42,0.04)] transition hover:-translate-y-0.5 hover:shadow-[0_18px_40px_rgba(15,23,42,0.08)] dark:border-slate-800 dark:bg-slate-900">
    <div class="flex items-start justify-between gap-3">
        <div class="flex h-11 w-11 items-center justify-center rounded-2xl border {{ $toneClasses }}">
            <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
        </div>
        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ $status }}</span>
    </div>
    <p class="mt-4 text-sm font-bold text-slate-500 dark:text-slate-400">{{ $label }}</p>
    <div class="mt-2 flex items-end gap-2">
        <p class="text-2xl font-extrabold text-slate-950 dark:text-white">{{ $value }}</p>
        <p class="pb-1 text-sm font-semibold text-slate-500 dark:text-slate-400">{{ $unit }}</p>
    </div>
</article>
