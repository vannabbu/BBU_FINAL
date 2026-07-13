@props([
    'label' => null,
    'icon' => null,
    'href' => null,
    'tone' => 'primary',
    'type' => 'button',
])

@php
    $classes = [
        'primary' => 'bg-[#2F6F3E] text-white hover:bg-[#285f35] focus:ring-[#2F6F3E]/20',
        'dark' => 'bg-slate-950 text-white hover:bg-slate-800 focus:ring-slate-500/20 dark:bg-white dark:text-slate-950 dark:hover:bg-slate-100',
        'ghost' => 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 focus:ring-slate-500/10 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500/20',
        'blue' => 'bg-sky-600 text-white hover:bg-sky-700 focus:ring-sky-500/20',
    ][$tone] ?? 'bg-[#2F6F3E] text-white hover:bg-[#285f35] focus:ring-[#2F6F3E]/20';
@endphp

@if ($href)
    <a
        href="{{ $href }}"
        {{ $attributes->merge(['class' => "inline-flex items-center justify-center gap-2 rounded-2xl px-4 py-2.5 text-sm font-extrabold shadow-sm transition focus:outline-none focus:ring-4 {$classes}"]) }}
    >
        @if ($icon)
            <i data-lucide="{{ $icon }}" class="h-4 w-4"></i>
        @endif
        {{ $label ?? $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->merge(['class' => "inline-flex items-center justify-center gap-2 rounded-2xl px-4 py-2.5 text-sm font-extrabold shadow-sm transition focus:outline-none focus:ring-4 {$classes}"]) }}
    >
        @if ($icon)
            <i data-lucide="{{ $icon }}" class="h-4 w-4"></i>
        @endif
        {{ $label ?? $slot }}
    </button>
@endif
