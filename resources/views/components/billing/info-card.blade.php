@props([
    'label',
    'value',
    'icon' => 'info',
    'note' => null,
    'tone' => 'green',
])

@php
    $tones = [
        'green' => 'bg-[#2F6F3E]/10 text-[#2F6F3E]',
        'blue' => 'bg-sky-50 text-sky-700 dark:bg-sky-500/10 dark:text-sky-300',
        'amber' => 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-300',
        'violet' => 'bg-violet-50 text-violet-700 dark:bg-violet-500/10 dark:text-violet-300',
        'slate' => 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300',
    ][$tone] ?? 'bg-[#2F6F3E]/10 text-[#2F6F3E]';
@endphp

<x-ui.card padding="p-4">
    <div class="flex items-start gap-3">
        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl {{ $tones }}">
            <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
        </div>
        <div class="min-w-0">
            <p class="text-xs font-extrabold uppercase tracking-wide text-slate-400">{{ $label }}</p>
            <p class="mt-1 truncate text-base font-extrabold text-slate-950 dark:text-white">{{ $value }}</p>
            @if ($note)
                <p class="mt-1 text-xs font-semibold text-slate-500 dark:text-slate-400">{{ $note }}</p>
            @endif
        </div>
    </div>
</x-ui.card>
