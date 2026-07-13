@props(['items' => []])

<aside
    class="fixed inset-y-0 left-0 z-40 w-72 -translate-x-full border-r border-slate-200 bg-white transition-transform duration-200 dark:border-slate-800 dark:bg-slate-900 lg:translate-x-0"
    x-bind:class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    aria-label="ម៉ឺនុយគ្រប់គ្រង"
>
    <div class="flex h-full flex-col">
        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-5 dark:border-slate-800">
            <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center gap-3">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#2F6F3E] text-xl font-extrabold text-white shadow-sm">ព</div>
                <div class="min-w-0">
                    <p class="truncate text-base font-extrabold text-slate-950 dark:text-white">PRUM SANTEPHEAP</p>
                    <p class="truncate text-xs font-semibold text-slate-500 dark:text-slate-400">Hospital Management</p>
                </div>
            </a>
            <button type="button" class="rounded-xl p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 lg:hidden" x-on:click="sidebarOpen = false" aria-label="បិទម៉ឺនុយ">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <nav class="scrollbar-hidden flex-1 space-y-1 overflow-y-auto px-3 py-5">
            @foreach ($items as $item)
                <a
                    href="{{ $item['href'] }}"
                    class="group flex items-center gap-3 rounded-2xl px-3 py-2.5 text-sm font-semibold transition duration-200 {{ $item['active'] ? 'bg-[#2F6F3E] text-white shadow-sm' : 'text-slate-600 hover:scale-[1.01] hover:bg-slate-100 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' }}"
                    @if ($item['active']) aria-current="page" @endif
                >
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl {{ $item['active'] ? 'bg-white/15 text-white' : 'bg-slate-100 text-slate-500 group-hover:text-[#2F6F3E] dark:bg-slate-800 dark:text-slate-400' }}">
                        <i data-lucide="{{ $item['icon'] }}" class="h-4 w-4"></i>
                    </span>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="space-y-2 border-t border-slate-100 p-4 dark:border-slate-800">
            <a href="{{ route('settings.index') }}" class="flex items-center gap-3 rounded-2xl px-3 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800">
                <i data-lucide="settings" class="h-4 w-4"></i>
                <span>ការកំណត់</span>
            </a>
            <a href="#" class="flex items-center gap-3 rounded-2xl px-3 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800">
                <i data-lucide="life-buoy" class="h-4 w-4"></i>
                <span>ជំនួយ</span>
            </a>
        </div>
    </div>
</aside>

<div
    x-cloak
    x-show="sidebarOpen"
    x-transition.opacity
    x-on:click="sidebarOpen = false"
    class="fixed inset-0 z-30 bg-slate-950/40 lg:hidden"
></div>
