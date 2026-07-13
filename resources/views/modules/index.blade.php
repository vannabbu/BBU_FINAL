<x-layout.app :title="$title" :navigation="$navigation" :doctor="$doctor">
    <x-layout.breadcrumb :items="[
        ['label' => 'ទំព័រដើម', 'href' => route('dashboard')],
        ['label' => $title, 'href' => null],
    ]" />

    <x-layout.page-header :title="$title" :subtitle="$description">
        @foreach ($actions ?? [] as $action)
            <x-ui.button :label="$action['label']" icon="activity" tone="ghost" :href="$action['href']" />
        @endforeach

        @if ($createModule)
            <x-ui.button label="បន្ថែមថ្មី" icon="plus" :href="route('modules.create', ['module' => $createModule])" />
        @endif
    </x-layout.page-header>

    @if (session('success'))
        <div class="mt-6 rounded-2xl border border-[#16A34A]/20 bg-[#16A34A]/10 px-4 py-3 text-sm font-extrabold text-[#16A34A]">
            <div class="flex items-center gap-2">
                <i data-lucide="circle-check-big" class="h-4 w-4"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <x-ui.card class="mt-6 overflow-hidden" padding="p-0">
        <div class="flex flex-col gap-4 border-b border-[#E5E7EB] p-5 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#2F6F3E]/10 text-[#2F6F3E]">
                    <i data-lucide="database" class="h-5 w-5"></i>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">{{ $title }}</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">បញ្ជីទិន្នន័យ និងព័ត៌មានសង្ខេបសម្រាប់ម៉ូឌុលនេះ។</p>
                </div>
            </div>

            <x-ui.badge tone="green" icon="list-checks">
                {{ number_format($rows->count()) }} កំណត់ត្រា
            </x-ui.badge>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#E5E7EB] text-left text-sm dark:divide-slate-800">
                <thead class="sticky top-0 bg-slate-50 text-slate-700 dark:bg-slate-900 dark:text-slate-200">
                    <tr>
                        @foreach ($columns as $column)
                            <th class="whitespace-nowrap px-5 py-4 text-xs font-extrabold uppercase tracking-wide">{{ $column }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white dark:divide-slate-800 dark:bg-slate-900">
                    @forelse ($rows as $row)
                        <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-800/60">
                            @foreach ($columns as $column)
                                <td class="whitespace-nowrap px-5 py-4 font-semibold text-slate-700 dark:text-slate-200">
                                    {{ $row[$column] ?? 'មិនមាន' }}
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td class="px-5 py-14 text-center" colspan="{{ count($columns) }}">
                                <div class="mx-auto flex max-w-md flex-col items-center">
                                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-500">
                                        <i data-lucide="folder-open" class="h-6 w-6"></i>
                                    </div>
                                    <h3 class="mt-4 text-base font-extrabold text-slate-950 dark:text-white">មិនទាន់មានទិន្នន័យ</h3>
                                    <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">នៅពេលមានការបញ្ចូលទិន្នន័យថ្មី វានឹងបង្ហាញនៅទីនេះ។</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.card>
</x-layout.app>
