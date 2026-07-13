@props([
    'placeholder' => 'Search...',
])

<label class="relative block">
    <span class="sr-only">{{ $placeholder }}</span>
    <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
    <input
        type="search"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'h-11 w-full rounded-2xl border border-slate-200 bg-slate-50 pl-10 pr-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900']) }}
    >
</label>
