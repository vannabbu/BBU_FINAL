@props([
    'label' => '',
    'tone' => 'green',
    'dynamic' => false,
])

@php
    $tones = [
        'green' => 'border-[#2F6F3E]/20 bg-[#2F6F3E]/10 text-[#2F6F3E]',
        'blue' => 'border-sky-100 bg-sky-50 text-sky-700 dark:border-sky-500/20 dark:bg-sky-500/10 dark:text-sky-300',
        'amber' => 'border-amber-100 bg-amber-50 text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300',
        'red' => 'border-red-100 bg-red-50 text-red-700 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-300',
        'violet' => 'border-violet-100 bg-violet-50 text-violet-700 dark:border-violet-500/20 dark:bg-violet-500/10 dark:text-violet-300',
        'slate' => 'border-slate-200 bg-slate-100 text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300',
    ];
@endphp

<span
    {{ $attributes->merge([
        'class' => 'inline-flex items-center rounded-full border px-2.5 py-1 text-xs font-extrabold '.($dynamic ? '' : ($tones[$tone] ?? $tones['slate'])),
    ]) }}
>
    @unless ($dynamic)
        {{ $label }}
    @endunless
</span>
