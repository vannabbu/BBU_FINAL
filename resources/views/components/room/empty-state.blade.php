@props([
    'title' => 'No rooms found',
    'message' => 'Try changing search keywords or filters.',
    'icon' => 'search-x',
])

<div {{ $attributes->merge(['class' => 'px-5 py-14 text-center']) }}>
    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
        <i data-lucide="{{ $icon }}" class="h-6 w-6"></i>
    </div>
    <h3 class="mt-4 text-base font-extrabold text-slate-950 dark:text-white">{{ $title }}</h3>
    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500 dark:text-slate-400">{{ $message }}</p>
    @if ($slot->isNotEmpty())
        <div class="mt-5">
            {{ $slot }}
        </div>
    @endif
</div>
