@props([
    'title',
    'description' => null,
    'icon' => 'clipboard-list',
])

<section class="rounded-2xl border border-[#E5E7EB] bg-white p-5 shadow-[0_12px_30px_rgba(15,23,42,0.04)] dark:border-slate-800 dark:bg-slate-900 sm:p-6">
    <div class="mb-5 flex items-start gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-[#2F6F3E]/10 text-[#2F6F3E]">
            <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
        </div>
        <div>
            <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">{{ $title }}</h2>
            @if ($description)
                <p class="mt-1 text-sm leading-6 text-slate-500 dark:text-slate-400">{{ $description }}</p>
            @endif
        </div>
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        {{ $slot }}
    </div>
</section>
