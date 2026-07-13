@props([
    'label' => null,
    'tone' => 'green',
    'icon' => null,
])

@php
    $classes = [
        'green' => 'border-[#2F6F3E]/20 bg-[#2F6F3E]/10 text-[#2F6F3E]',
        'blue' => 'border-sky-100 bg-sky-50 text-sky-700 dark:border-sky-500/20 dark:bg-sky-500/10 dark:text-sky-300',
        'amber' => 'border-amber-100 bg-amber-50 text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300',
        'red' => 'border-red-100 bg-red-50 text-red-700 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-300',
        'slate' => 'border-slate-200 bg-slate-100 text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300',
    ][$tone] ?? 'border-slate-200 bg-slate-100 text-slate-700';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-xs font-extrabold {$classes}"]) }}>
    @if ($icon)
        <i data-lucide="{{ $icon }}" class="h-3.5 w-3.5"></i>
    @endif
    {{ $label ?? $slot }}
</span>
