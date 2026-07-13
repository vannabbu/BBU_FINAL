@props(['queue' => []])

<aside
    x-data="{ filter: 'all' }"
    class="rounded-2xl border border-[#E5E7EB] bg-white p-5 shadow-[0_12px_30px_rgba(15,23,42,0.04)] dark:border-slate-800 dark:bg-slate-900 xl:sticky xl:top-24"
>
    <div class="flex items-start justify-between gap-3">
        <div>
            <div class="flex items-center gap-2">
                <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">ជួររង់ចាំផ្ទាល់</h2>
                <span class="relative flex h-3 w-3">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex h-3 w-3 rounded-full bg-red-500"></span>
                </span>
            </div>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Live Waiting Queue</p>
        </div>
        <span class="rounded-2xl bg-[#2F6F3E]/10 px-3 py-2 text-xs font-extrabold text-[#2F6F3E]">~ 18 នាទី</span>
    </div>

    <div class="mt-5 grid grid-cols-2 gap-2">
        <button type="button" x-on:click="filter = 'all'" x-bind:class="filter === 'all' ? 'bg-[#2F6F3E] text-white' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300'" class="rounded-2xl px-3 py-2 text-xs font-extrabold transition">ទាំងអស់</button>
        <button type="button" x-on:click="filter = 'waiting'" x-bind:class="filter === 'waiting' ? 'bg-[#2F6F3E] text-white' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300'" class="rounded-2xl px-3 py-2 text-xs font-extrabold transition">រង់ចាំ</button>
        <button type="button" x-on:click="filter = 'active'" x-bind:class="filter === 'active' ? 'bg-[#2F6F3E] text-white' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300'" class="rounded-2xl px-3 py-2 text-xs font-extrabold transition">កំពុងពិនិត្យ</button>
        <button type="button" x-on:click="filter = 'next'" x-bind:class="filter === 'next' ? 'bg-[#2F6F3E] text-white' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300'" class="rounded-2xl px-3 py-2 text-xs font-extrabold transition">បន្ទាប់</button>
    </div>

    <div class="mt-5 max-h-[620px] space-y-3 overflow-y-auto pr-1">
        @foreach ($queue as $item)
            <x-patient-update.queue-item :item="$item" />
        @endforeach
    </div>
</aside>
