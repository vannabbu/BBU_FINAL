@props([
    'role' => '',
    'dynamic' => false,
])

@php
    $classes = [
        'Administrator' => 'border-violet-100 bg-violet-50 text-violet-700 dark:border-violet-500/20 dark:bg-violet-500/10 dark:text-violet-300',
        'Doctor' => 'border-blue-100 bg-blue-50 text-blue-700 dark:border-blue-500/20 dark:bg-blue-500/10 dark:text-blue-300',
        'Nurse' => 'border-pink-100 bg-pink-50 text-pink-700 dark:border-pink-500/20 dark:bg-pink-500/10 dark:text-pink-300',
        'Receptionist' => 'border-cyan-100 bg-cyan-50 text-cyan-700 dark:border-cyan-500/20 dark:bg-cyan-500/10 dark:text-cyan-300',
        'Pharmacist' => 'border-[#2F6F3E]/20 bg-[#2F6F3E]/10 text-[#2F6F3E]',
        'Laboratory Technician' => 'border-amber-100 bg-amber-50 text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300',
        'Cashier' => 'border-emerald-100 bg-emerald-50 text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300',
        'HR Officer' => 'border-slate-200 bg-slate-100 text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300',
    ][$role] ?? 'border-slate-200 bg-slate-100 text-slate-700';
@endphp

<span
    {{ $attributes->merge([
        'class' => 'inline-flex items-center rounded-full border px-2.5 py-1 text-xs font-extrabold '.($dynamic ? '' : $classes),
    ]) }}
>
    @unless ($dynamic)
        {{ $role }}
    @endunless
</span>
