@props([
    'padding' => 'p-5 sm:p-6',
])

<section {{ $attributes->merge(['class' => "rounded-2xl border border-[#E5E7EB] bg-white {$padding} shadow-[0_12px_30px_rgba(15,23,42,0.04)] dark:border-slate-800 dark:bg-slate-900"]) }}>
    {{ $slot }}
</section>
