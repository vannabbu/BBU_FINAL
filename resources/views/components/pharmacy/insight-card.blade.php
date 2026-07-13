@props(['insight'])

<section class="overflow-hidden rounded-2xl bg-[#2F6F3E] p-5 text-white shadow-[0_22px_60px_rgba(47,111,62,0.28)]">
    <div class="flex items-start justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-2 rounded-full bg-white/12 px-3 py-1.5 text-xs font-extrabold text-white/90 ring-1 ring-white/15">
                <i data-lucide="sparkles" class="h-3.5 w-3.5"></i>
                Smart Insight
            </span>
            <h2 class="mt-4 text-xl font-extrabold">{{ $insight['title'] }}</h2>
            <p class="mt-2 text-sm leading-7 text-white/75">{{ $insight['message'] }}</p>
        </div>
        <div class="hidden h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white/12 ring-1 ring-white/15 sm:flex">
            <i data-lucide="brain-circuit" class="h-6 w-6"></i>
        </div>
    </div>

    <div class="mt-5 rounded-2xl bg-white/10 p-4 ring-1 ring-white/15">
        <div class="flex items-center justify-between gap-3">
            <div>
                <p class="text-xs font-bold uppercase tracking-wide text-white/60">ឱសថអាទិភាព</p>
                <p class="mt-1 text-base font-extrabold">{{ $insight['medicine'] }}</p>
            </div>
            <span class="rounded-full bg-white px-3 py-1.5 text-xs font-extrabold text-[#2F6F3E]">{{ $insight['quantity'] }}</span>
        </div>

        <div class="mt-5">
            <div class="flex items-center justify-between text-xs font-bold text-white/70">
                <span>Confidence</span>
                <span>{{ $insight['confidence'] }}%</span>
            </div>
            <div class="mt-2 h-2 overflow-hidden rounded-full bg-white/15">
                <div class="h-full rounded-full bg-white" style="width: {{ $insight['confidence'] }}%"></div>
            </div>
        </div>

        <p class="mt-4 text-sm font-semibold text-white/80">{{ $insight['saving'] }}</p>
    </div>

    <div class="mt-5 flex flex-col gap-3 sm:flex-row">
        <x-ui.button label="បញ្ជាទិញឡើងវិញ" icon="shopping-cart" tone="dark" class="w-full bg-white text-[#2F6F3E] hover:bg-white/90 dark:bg-white dark:text-[#2F6F3E]" />
        <button type="button" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-white/20 px-4 py-2.5 text-sm font-extrabold text-white transition hover:bg-white/10">
            <i data-lucide="chart-no-axes-combined" class="h-4 w-4"></i>
            មើលការព្យាករណ៍
        </button>
    </div>
</section>
