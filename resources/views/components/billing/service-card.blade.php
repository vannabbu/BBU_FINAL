@props(['service'])

<label
    x-bind:class="serviceSelected(@js($service['id'])) ? 'border-[#2F6F3E] bg-[#2F6F3E]/5 ring-4 ring-[#2F6F3E]/10' : 'border-[#E5E7EB] bg-white hover:border-[#2F6F3E]/40 dark:border-slate-800 dark:bg-slate-900'"
    class="group flex cursor-pointer items-start gap-4 rounded-2xl border p-4 shadow-[0_12px_30px_rgba(15,23,42,0.04)] transition"
>
    <input
        type="checkbox"
        class="sr-only"
        x-bind:checked="serviceSelected(@js($service['id']))"
        x-on:change="toggleService(@js($service['id']))"
    >

    <span
        x-bind:class="serviceSelected(@js($service['id'])) ? 'bg-[#2F6F3E] text-white' : 'bg-slate-100 text-slate-500 group-hover:text-[#2F6F3E] dark:bg-slate-800 dark:text-slate-300'"
        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl transition"
    >
        <i data-lucide="{{ $service['icon'] }}" class="h-5 w-5"></i>
    </span>

    <span class="min-w-0 flex-1">
        <span class="block text-sm font-extrabold text-slate-950 dark:text-white">{{ $service['name_kh'] }}</span>
        <span class="mt-1 block text-xs font-bold text-slate-500 dark:text-slate-400">{{ $service['name'] }}</span>
        <span class="mt-3 inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-extrabold text-slate-700 dark:bg-slate-800 dark:text-slate-300">
            {{ number_format($service['price']) }} ៛
        </span>
    </span>

    <span
        x-bind:class="serviceSelected(@js($service['id'])) ? 'border-[#2F6F3E] bg-[#2F6F3E] text-white' : 'border-slate-200 bg-white text-transparent dark:border-slate-700 dark:bg-slate-900'"
        class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border transition"
    >
        <i data-lucide="check" class="h-3.5 w-3.5"></i>
    </span>
</label>
