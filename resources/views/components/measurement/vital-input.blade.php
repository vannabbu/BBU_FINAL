@props([
    'label',
    'field',
    'unit',
    'icon' => 'activity',
    'placeholder' => '',
    'tooltip' => '',
    'step' => '1',
    'optional' => false,
])

<label class="block">
    <span class="mb-2 flex items-center justify-between gap-2">
        <span class="inline-flex items-center gap-2 text-sm font-bold text-slate-700 dark:text-slate-200">
            <i data-lucide="{{ $icon }}" class="h-4 w-4 text-slate-400"></i>
            {{ $label }}
        </span>
        @if ($tooltip)
            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-slate-100 text-slate-400 dark:bg-slate-800" title="{{ $tooltip }}">
                <i data-lucide="info" class="h-3.5 w-3.5"></i>
            </span>
        @endif
    </span>
    <span class="relative block">
        <input
            type="number"
            step="{{ $step }}"
            x-model.number="vitals.{{ $field }}"
            x-on:input="markDirty(); calculateBmi(); detectHealthStatus(); validateField(@js($field), @js($optional))"
            placeholder="{{ $placeholder }}"
            x-bind:class="fieldClass(@js($field))"
            class="h-12 w-full rounded-2xl px-4 pr-16 text-sm font-semibold text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900"
        >
        <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs font-extrabold text-slate-400">{{ $unit }}</span>
    </span>
    <p x-show="errors[@js($field)]" x-text="errors[@js($field)]" class="mt-2 text-xs font-bold text-red-600"></p>
</label>
