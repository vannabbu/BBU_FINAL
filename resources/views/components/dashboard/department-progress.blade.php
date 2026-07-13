@props(['departments'])

<section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-[0_12px_30px_rgba(15,23,42,0.04)] dark:border-slate-800 dark:bg-slate-900 sm:p-6">
    <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">ប្រសិទ្ធភាពតាមផ្នែក</h2>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">ចំនួនអ្នកជំងឺ និងភាគរយប្រតិបត្តិការ</p>
    <div class="mt-6 space-y-5">
        @foreach ($departments as $department)
            <div>
                <div class="mb-2 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $department['name'] }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $department['patients'] }} អ្នកជំងឺ</p>
                    </div>
                    <span class="text-sm font-extrabold text-[#2F6F3E]">{{ $department['percentage'] }}%</span>
                </div>
                <div class="h-2.5 rounded-full bg-slate-100 dark:bg-slate-800">
                    <div class="h-2.5 rounded-full bg-[#2F6F3E]" style="width: {{ $department['percentage'] }}%"></div>
                </div>
            </div>
        @endforeach
    </div>
</section>
