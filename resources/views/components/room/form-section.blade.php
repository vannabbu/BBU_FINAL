@props([
    'title',
    'subtitle' => null,
    'icon' => 'settings-2',
    'open' => true,
])

<section
    x-data="{ open: @js($open) }"
    class="rounded-2xl border border-[#E5E7EB] bg-white shadow-[0_12px_30px_rgba(15,23,42,0.04)] dark:border-slate-800 dark:bg-slate-900"
>
    <button type="button" x-on:click="open = ! open" class="flex w-full items-start gap-3 p-5 text-left sm:p-6 lg:pointer-events-none">
        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#2F6F3E]/10 text-[#2F6F3E]">
            <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
        </span>
        <span class="min-w-0 flex-1">
            <span class="block text-lg font-extrabold text-slate-950 dark:text-white">{{ $title }}</span>
            @if ($subtitle)
                <span class="mt-1 block text-sm leading-6 text-slate-500 dark:text-slate-400">{{ $subtitle }}</span>
            @endif
        </span>
        <i data-lucide="chevron-down" class="mt-1 h-5 w-5 text-slate-400 transition lg:hidden" x-bind:class="open ? 'rotate-180' : ''"></i>
    </button>

    <div x-show="open" x-transition.opacity class="border-t border-slate-100 p-5 dark:border-slate-800 sm:p-6">
        {{ $slot }}
    </div>
</section>
