@props([
    'title',
    'description',
    'href',
    'icon',
])

<a href="{{ $href }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-[0_12px_30px_rgba(15,23,42,0.04)] transition duration-200 hover:-translate-y-1 hover:border-[#2F6F3E]/30 hover:shadow-[0_18px_45px_rgba(15,23,42,0.08)] dark:border-slate-800 dark:bg-slate-900">
    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#2F6F3E]/10 text-[#2F6F3E] transition group-hover:bg-[#2F6F3E] group-hover:text-white">
        <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
    </div>
    <p class="mt-4 text-sm font-extrabold text-slate-950 dark:text-white">{{ $title }}</p>
    <p class="mt-1 text-sm leading-6 text-slate-500 dark:text-slate-400">{{ $description }}</p>
</a>
