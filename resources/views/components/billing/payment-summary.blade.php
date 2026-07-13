<x-ui.card class="xl:sticky xl:top-24">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">សង្ខេបការទូទាត់</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Payment summary and invoice actions</p>
        </div>
        <x-ui.badge label="Active Invoice" tone="green" icon="badge-check" />
    </div>

    <div class="mt-5 space-y-3">
        <div class="flex items-center justify-between rounded-2xl bg-slate-50 p-3 dark:bg-slate-800">
            <span class="text-sm font-bold text-slate-500 dark:text-slate-400">Medicine total</span>
            <span class="text-sm font-extrabold text-slate-950 dark:text-white" x-text="money(medicineTotal)"></span>
        </div>
        <div class="flex items-center justify-between rounded-2xl bg-slate-50 p-3 dark:bg-slate-800">
            <span class="text-sm font-bold text-slate-500 dark:text-slate-400">Service total</span>
            <span class="text-sm font-extrabold text-slate-950 dark:text-white" x-text="money(serviceTotal)"></span>
        </div>
        <div class="flex items-center justify-between rounded-2xl bg-slate-50 p-3 dark:bg-slate-800">
            <span class="text-sm font-bold text-slate-500 dark:text-slate-400">Tax <span x-text="'(' + Math.round(taxRate * 100) + '%)'"></span></span>
            <span class="text-sm font-extrabold text-slate-950 dark:text-white" x-text="money(taxTotal)"></span>
        </div>
        <div class="rounded-2xl bg-slate-50 p-3 dark:bg-slate-800">
            <x-ui.input
                label="Discount / បញ្ចុះតម្លៃ"
                type="number"
                icon="badge-percent"
                x-model.number="discount"
                min="0"
            />
        </div>
    </div>

    <div class="mt-5 rounded-2xl bg-[#2F6F3E] p-5 text-white">
        <div class="flex items-center justify-between gap-3">
            <span class="text-sm font-bold text-white/70">Grand total</span>
            <span class="text-2xl font-extrabold" x-text="money(grandTotal)"></span>
        </div>
        <p class="mt-2 text-xs font-semibold text-white/70">សរុបចុងក្រោយបន្ទាប់ពីបន្ថែមពន្ធ និងដកការបញ្ចុះតម្លៃ។</p>
    </div>

    <div class="mt-5 grid gap-3 sm:grid-cols-2 xl:grid-cols-1">
        <x-ui.button label="រក្សាទុកព្រាង" icon="save" tone="ghost" class="w-full" />
        <x-ui.button label="បង្កើតវិក្កយបត្រ" icon="file-check-2" class="w-full" />
        <x-ui.button label="បោះពុម្ពវិក្កយបត្រ" icon="printer" tone="ghost" class="w-full" x-on:click="window.print()" />
        <x-ui.button label="ដំណើរការទូទាត់" icon="credit-card" tone="blue" class="w-full" x-on:click="paymentStatus = 'processing'" />
    </div>

    <p x-show="paymentStatus === 'processing'" x-transition class="mt-4 rounded-2xl bg-sky-50 px-4 py-3 text-sm font-bold text-sky-700 dark:bg-sky-500/10 dark:text-sky-300">
        កំពុងរៀបចំការទូទាត់... Payment simulation is ready.
    </p>
</x-ui.card>
