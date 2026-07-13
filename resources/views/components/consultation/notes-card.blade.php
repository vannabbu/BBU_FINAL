@props([
    'title',
    'icon' => 'clipboard-plus',
])

<section class="rounded-2xl border border-[#E5E7EB] bg-white p-5 shadow-[0_12px_30px_rgba(15,23,42,0.04)] dark:border-slate-800 dark:bg-slate-900">
    <div class="flex items-center gap-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#2F6F3E]/10 text-[#2F6F3E]">
            <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
        </div>
        <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">{{ $title }}</h2>
    </div>
    <div class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300">
        {{ $slot }}
    </div>
</section>
