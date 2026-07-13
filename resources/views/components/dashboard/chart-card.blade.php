@props([
    'title',
    'subtitle' => null,
])

<section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-[0_12px_30px_rgba(15,23,42,0.04)] dark:border-slate-800 dark:bg-slate-900 sm:p-6">
    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">{{ $title }}</h2>
            @if ($subtitle)
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $subtitle }}</p>
            @endif
        </div>
        @if (isset($actions))
            <div class="flex flex-wrap gap-2">{{ $actions }}</div>
        @endif
    </div>
    <div class="relative">
        {{ $slot }}
    </div>
</section>
