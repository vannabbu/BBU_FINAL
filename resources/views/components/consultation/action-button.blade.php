@props([
    'label',
    'icon',
    'tone' => 'primary',
    'type' => 'button',
])

@php
    $classes = [
        'primary' => 'bg-[#2F6F3E] text-white hover:bg-[#285f35] focus:ring-[#2F6F3E]/20',
        'blue' => 'bg-sky-600 text-white hover:bg-sky-700 focus:ring-sky-500/20',
        'warning' => 'bg-amber-500 text-white hover:bg-amber-600 focus:ring-amber-500/20',
        'ghost' => 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 focus:ring-slate-500/10 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800',
    ][$tone] ?? 'bg-[#2F6F3E] text-white hover:bg-[#285f35] focus:ring-[#2F6F3E]/20';
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => "inline-flex w-full items-center justify-center gap-2 rounded-2xl px-4 py-3 text-sm font-extrabold shadow-sm transition focus:outline-none focus:ring-4 sm:w-auto {$classes}"]) }}
>
    <i data-lucide="{{ $icon }}" class="h-4 w-4"></i>
    {{ $label }}
</button>
