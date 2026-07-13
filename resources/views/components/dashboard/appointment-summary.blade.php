@props(['summary'])

<section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-[0_12px_30px_rgba(15,23,42,0.04)] dark:border-slate-800 dark:bg-slate-900 sm:p-6">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">សង្ខេបការណាត់ជួប</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">ស្ថានភាពការណាត់ជួបថ្ងៃនេះ</p>
        </div>
        <a href="{{ $summary['href'] }}" class="rounded-xl bg-[#2F6F3E] px-3 py-2 text-sm font-bold text-white hover:bg-[#285f35]">មើលទាំងអស់</a>
    </div>

    <div class="mt-6 grid grid-cols-2 gap-3">
        <div class="rounded-2xl bg-[#2F6F3E]/10 p-4">
            <p class="text-xs font-bold text-[#2F6F3E]">ថ្ងៃនេះ</p>
            <p class="mt-2 text-2xl font-extrabold text-slate-950 dark:text-white">{{ $summary['today'] }}</p>
        </div>
        <div class="rounded-2xl bg-red-50 p-4 dark:bg-red-500/10">
            <p class="text-xs font-bold text-red-600 dark:text-red-300">បន្ទាន់</p>
            <p class="mt-2 text-2xl font-extrabold text-slate-950 dark:text-white">{{ $summary['emergency'] }}</p>
        </div>
        <div class="rounded-2xl bg-amber-50 p-4 dark:bg-amber-500/10">
            <p class="text-xs font-bold text-amber-600 dark:text-amber-300">រង់ចាំ</p>
            <p class="mt-2 text-2xl font-extrabold text-slate-950 dark:text-white">{{ $summary['pending'] }}</p>
        </div>
        <div class="rounded-2xl bg-green-50 p-4 dark:bg-green-500/10">
            <p class="text-xs font-bold text-green-600 dark:text-green-300">បានបញ្ចប់</p>
            <p class="mt-2 text-2xl font-extrabold text-slate-950 dark:text-white">{{ $summary['completed'] }}</p>
        </div>
    </div>
</section>
