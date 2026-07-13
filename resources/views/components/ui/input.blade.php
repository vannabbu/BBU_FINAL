@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => '',
    'icon' => null,
])

<label class="block">
    @if ($label)
        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">{{ $label }}</span>
    @endif
    <span class="relative block">
        @if ($icon)
            <i data-lucide="{{ $icon }}" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
        @endif
        <input
            type="{{ $type }}"
            @if ($name) name="{{ $name }}" @endif
            @if (! is_null($value)) value="{{ $value }}" @endif
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => 'h-11 w-full rounded-2xl border border-slate-200 bg-slate-50 '.($icon ? 'pl-10' : 'pl-4').' pr-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900']) }}
        >
    </span>
</label>
