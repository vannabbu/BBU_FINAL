@props([
    'status' => '',
    'label' => null,
    'dynamic' => false,
])

@php
    $classes = [
        'active' => 'border-[#16A34A]/20 bg-[#16A34A]/10 text-[#16A34A]',
        'on_leave' => 'border-[#F59E0B]/20 bg-[#F59E0B]/10 text-[#B45309] dark:text-amber-300',
        'suspended' => 'border-[#DC2626]/20 bg-[#DC2626]/10 text-[#DC2626]',
        'inactive' => 'border-slate-200 bg-slate-100 text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300',
        'resigned' => 'border-zinc-200 bg-zinc-100 text-zinc-700 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300',
    ][$status] ?? 'border-slate-200 bg-slate-100 text-slate-700';
@endphp

<span
    {{ $attributes->merge([
        'class' => 'inline-flex items-center rounded-full border px-2.5 py-1 text-xs font-extrabold '.($dynamic ? '' : $classes),
    ]) }}
>
    @unless ($dynamic)
        {{ $label ?? ucfirst(str_replace('_', ' ', (string) $status)) }}
    @endunless
</span>
