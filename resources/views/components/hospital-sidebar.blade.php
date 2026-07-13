@props(['items' => []])

<aside
    class="fixed inset-y-0 left-0 z-40 w-72 -translate-x-full border-r border-slate-200 bg-white transition-transform duration-200 lg:translate-x-0"
    x-bind:class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
>
    <div class="flex h-full flex-col">
        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-5">
            <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#2f6f3e] text-lg font-extrabold text-white shadow-sm">ព</div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-extrabold text-slate-950">ព្រហ្ម សន្តិភាព</p>
                    <p class="truncate text-xs font-semibold text-slate-500">មន្ទីរពេទ្យ និងគ្លីនិក</p>
                </div>
            </a>
            <button type="button" class="rounded-lg p-2 text-slate-500 lg:hidden" x-on:click="sidebarOpen = false" aria-label="បិទម៉ឺនុយ">✕</button>
        </div>

        <nav class="scrollbar-hidden flex-1 space-y-1 overflow-y-auto px-3 py-5">
            @foreach ($items as $item)
                <a
                    href="{{ $item['href'] }}"
                    class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ $item['active'] ? 'bg-[#2f6f3e] text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }}"
                >
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg {{ $item['active'] ? 'bg-white/15 text-white' : 'bg-slate-100 text-slate-500 group-hover:text-[#2f6f3e]' }}">
                        @switch($item['icon'])
                            @case('dashboard')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 13h7V4H4v9Z"/><path d="M13 20h7V4h-7v16Z"/><path d="M4 20h7v-5H4v5Z"/></svg>
                                @break
                            @case('stethoscope')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 3v6a4 4 0 0 0 8 0V3"/><path d="M10 13v2a5 5 0 0 0 10 0v-3"/><circle cx="20" cy="10" r="2"/></svg>
                                @break
                            @case('doctor')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="7" r="4"/><path d="M5.5 21a6.5 6.5 0 0 1 13 0"/><path d="M12 15v5"/><path d="M9.5 17.5h5"/></svg>
                                @break
                            @case('patients')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="8" r="4"/><path d="M3 21a6 6 0 0 1 12 0"/><path d="M16 11a3 3 0 1 0 0-6"/><path d="M17 21a5 5 0 0 0-3-4.6"/></svg>
                                @break
                            @case('chart')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19V5"/><path d="M4 19h16"/><path d="m7 15 4-4 3 3 5-7"/></svg>
                                @break
                            @case('calendar')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4"/><path d="M8 3v4"/><path d="M3 11h18"/></svg>
                                @break
                            @case('lab')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 2v6l-5 9a3 3 0 0 0 2.6 4.5h8.8A3 3 0 0 0 19 17L14 8V2"/><path d="M8 2h8"/><path d="M7 16h10"/></svg>
                                @break
                            @case('rooms')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12V5a2 2 0 0 1 2-2h8a3 3 0 0 1 3 3v6"/><path d="M4 21v-5h16v5"/><path d="M20 16v-3a2 2 0 0 0-2-2H4"/></svg>
                                @break
                            @default
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a8 8 0 0 0 .1-6"/><path d="M4.5 9a8 8 0 0 0 .1 6"/><path d="M15 4.6a8 8 0 0 0-6 0"/><path d="M9 19.4a8 8 0 0 0 6 0"/></svg>
                        @endswitch
                    </span>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="m-4 rounded-2xl border border-[#2f6f3e]/15 bg-[#2f6f3e]/5 p-4">
            <p class="text-sm font-bold text-[#2f6f3e]">ស្ថានភាពប្រព័ន្ធ</p>
            <p class="mt-1 text-xs leading-5 text-slate-500">ការជូនដំណឹង និងប្រវត្តិវេជ្ជសាស្ត្រត្រូវបានតាមដានជាប្រចាំ។</p>
        </div>
    </div>
</aside>

<div
    class="fixed inset-0 z-30 bg-slate-950/30 lg:hidden"
    x-cloak
    x-show="sidebarOpen"
    x-on:click="sidebarOpen = false"
></div>
