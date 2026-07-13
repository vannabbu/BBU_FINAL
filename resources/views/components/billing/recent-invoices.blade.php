@props(['invoices' => []])

<x-ui.card>
    <div class="flex items-start justify-between gap-3">
        <div>
            <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">វិក្កយបត្រថ្មីៗ</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Recent billing activity</p>
        </div>
        <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#2F6F3E]/10 text-[#2F6F3E]">
            <i data-lucide="receipt-text" class="h-5 w-5"></i>
        </span>
    </div>

    <div class="mt-5 space-y-3">
        @foreach ($invoices as $invoice)
            <article class="rounded-2xl border border-slate-100 bg-slate-50/70 p-4 dark:border-slate-800 dark:bg-slate-800/50">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <h3 class="truncate text-sm font-extrabold text-slate-950 dark:text-white">{{ $invoice['patient'] }}</h3>
                        <p class="mt-1 text-xs font-bold text-slate-500 dark:text-slate-400">{{ $invoice['number'] }}</p>
                    </div>
                    <x-ui.badge :label="$invoice['status_kh']" :tone="$invoice['tone']" />
                </div>
                <div class="mt-4 flex items-center justify-between gap-3">
                    <p class="text-sm font-extrabold text-[#2F6F3E]">{{ $invoice['amount'] }}</p>
                    <p class="text-xs font-bold text-slate-400">{{ $invoice['date'] }}</p>
                </div>
            </article>
        @endforeach
    </div>
</x-ui.card>
