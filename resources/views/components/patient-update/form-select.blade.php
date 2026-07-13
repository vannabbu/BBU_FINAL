@props([
    'label',
    'name',
    'value' => '',
    'options' => [],
    'icon' => null,
    'span' => false,
])

<label x-data="{ selected: @js($value) }" class="{{ $span ? 'md:col-span-2' : '' }} block">
    <span class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $label }}</span>
    <span class="relative mt-2 block">
        @if ($icon)
            <i data-lucide="{{ $icon }}" class="pointer-events-none absolute left-3 top-3.5 h-4 w-4 text-slate-400"></i>
        @endif
        <select
            name="{{ $name }}"
            x-model="selected"
            x-on:change="$dispatch('form-dirty')"
            class="h-12 w-full appearance-none rounded-2xl border border-slate-200 bg-slate-50 {{ $icon ? 'pl-10' : 'pl-4' }} pr-10 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900"
        >
            @foreach ($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}">{{ $optionLabel }}</option>
            @endforeach
        </select>
        <i data-lucide="chevron-down" class="pointer-events-none absolute right-3 top-3.5 h-4 w-4 text-slate-400"></i>
    </span>
</label>
