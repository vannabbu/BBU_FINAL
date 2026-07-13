@props([
    'selected' => [],
    'suggestions' => [],
])

<section
    x-data="{
        query: '',
        diagnoses: @js($selected),
        suggestions: @js($suggestions),
        colors: ['green', 'blue', 'amber', 'red'],
        colorClass(color) {
            return {
                green: 'bg-[#2F6F3E]/10 text-[#2F6F3E] border-[#2F6F3E]/20',
                blue: 'bg-sky-50 text-sky-700 border-sky-100',
                amber: 'bg-amber-50 text-amber-700 border-amber-100',
                red: 'bg-red-50 text-red-700 border-red-100'
            }[color] || 'bg-slate-100 text-slate-700 border-slate-200';
        },
        addDiagnosis(label = null) {
            const text = (label || this.query).trim();
            if (! text || this.diagnoses.some((item) => item.label.toLowerCase() === text.toLowerCase())) {
                this.query = '';
                return;
            }
            this.diagnoses.push({ label: text, color: this.colors[this.diagnoses.length % this.colors.length] });
            this.query = '';
        },
        removeDiagnosis(index) {
            this.diagnoses.splice(index, 1);
        },
        filteredSuggestions() {
            if (! this.query) return this.suggestions.slice(0, 4);
            return this.suggestions.filter((item) => item.toLowerCase().includes(this.query.toLowerCase())).slice(0, 4);
        }
    }"
    class="rounded-2xl border border-[#E5E7EB] bg-white p-5 shadow-[0_12px_30px_rgba(15,23,42,0.04)] dark:border-slate-800 dark:bg-slate-900"
>
    <div class="flex items-start justify-between gap-3">
        <div>
            <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">រោគវិនិច្ឆ័យ</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">ស្វែងរក និងបន្ថែមរោគវិនិច្ឆ័យសម្រាប់ការពិគ្រោះនេះ។</p>
        </div>
    </div>

    <div class="mt-5">
        <label class="relative block">
            <span class="sr-only">ស្វែងរករោគវិនិច្ឆ័យ</span>
            <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
            <input
                x-model="query"
                x-on:keydown.enter.prevent="addDiagnosis()"
                type="search"
                placeholder="ស្វែងរក ឬបញ្ចូលរោគវិនិច្ឆ័យ..."
                class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 pl-10 pr-4 text-sm outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900"
            >
        </label>

        <div class="mt-3 flex flex-wrap gap-2">
            <template x-for="suggestion in filteredSuggestions()" :key="suggestion">
                <button
                    type="button"
                    x-on:click="addDiagnosis(suggestion)"
                    class="rounded-full border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-600 transition hover:border-[#2F6F3E]/30 hover:bg-[#2F6F3E]/5 hover:text-[#2F6F3E] dark:border-slate-700 dark:text-slate-300"
                    x-text="suggestion"
                ></button>
            </template>
        </div>
    </div>

    <div class="mt-5 flex flex-wrap gap-2">
        <template x-for="(diagnosis, index) in diagnoses" :key="diagnosis.label">
            <span x-bind:class="colorClass(diagnosis.color)" class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs font-extrabold">
                <span x-text="diagnosis.label"></span>
                <button type="button" x-on:click="removeDiagnosis(index)" class="rounded-full p-0.5 hover:bg-white/60" aria-label="លុបរោគវិនិច្ឆ័យ">
                    <span class="block text-sm leading-none">&times;</span>
                </button>
            </span>
        </template>
    </div>
</section>
