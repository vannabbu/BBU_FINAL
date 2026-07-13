@props([
    'label' => null,
    'options' => [],
    'placeholder' => 'All',
])

<label class="block">
    @if ($label)
        <span class="mb-2 block text-xs font-extrabold uppercase tracking-wide text-slate-400">{{ $label }}</span>
    @endif
    <select
        {{ $attributes->merge(['class' => 'h-11 w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 text-sm font-bold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900']) }}
    >
        <option value="all">{{ $placeholder }}</option>
        @foreach ($options as $value => $optionLabel)
            <option value="{{ is_int($value) ? $optionLabel : $value }}">{{ $optionLabel }}</option>
        @endforeach
    </select>
</label>
