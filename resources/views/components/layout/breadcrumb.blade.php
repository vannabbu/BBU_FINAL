@props(['items' => []])

<nav class="mb-4 flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400" aria-label="Breadcrumb">
    @foreach ($items as $item)
        @if (! $loop->first)
            <i data-lucide="chevron-right" class="h-4 w-4"></i>
        @endif

        @if ($item['href'])
            <a href="{{ $item['href'] }}" class="font-medium hover:text-[#2F6F3E]">{{ $item['label'] }}</a>
        @else
            <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>
