@props([
    'label',
    'name',
    'value' => '',
    'type' => 'text',
    'placeholder' => '',
    'icon' => null,
    'readonly' => false,
    'textarea' => false,
    'span' => false,
])

<label class="{{ $span ? 'md:col-span-2' : '' }} block">
    <span class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $label }}</span>
    <span class="relative mt-2 block">
        @if ($icon)
            <i data-lucide="{{ $icon }}" class="pointer-events-none absolute left-3 top-3.5 h-4 w-4 text-slate-400"></i>
        @endif

        @if ($textarea)
            <textarea
                name="{{ $name }}"
                rows="4"
                placeholder="{{ $placeholder }}"
                x-on:input="$dispatch('form-dirty')"
                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm leading-7 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900"
            >{{ $value }}</textarea>
        @else
            <input
                type="{{ $type }}"
                name="{{ $name }}"
                value="{{ $value }}"
                placeholder="{{ $placeholder }}"
                @readonly($readonly)
                x-on:input="$dispatch('form-dirty')"
                class="h-12 w-full rounded-2xl border border-slate-200 {{ $readonly ? 'bg-slate-100 text-slate-500 dark:bg-slate-800/70' : 'bg-slate-50 dark:bg-slate-800' }} {{ $icon ? 'pl-10' : 'pl-4' }} pr-4 text-sm outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:text-white dark:focus:bg-slate-900"
            >
        @endif
    </span>
</label>
