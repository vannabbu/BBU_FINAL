<x-layout.app :title="'បន្ថែមថ្មី | '.$title" :navigation="$navigation" :doctor="$doctor">
    <x-layout.breadcrumb :items="[
        ['label' => 'ទំព័រដើម', 'href' => route('dashboard')],
        ['label' => $title, 'href' => $indexUrl],
        ['label' => 'បន្ថែមថ្មី', 'href' => null],
    ]" />

    <x-layout.page-header title="បន្ថែមថ្មី" :subtitle="$description">
        <x-ui.button label="ត្រឡប់ក្រោយ" icon="arrow-left" tone="ghost" :href="$indexUrl" />
    </x-layout.page-header>

    @if ($errors->any())
        <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-300">
            <div class="flex gap-3">
                <i data-lucide="triangle-alert" class="mt-0.5 h-4 w-4 shrink-0"></i>
                <div>
                    <p class="font-extrabold">សូមពិនិត្យព័ត៌មានខាងក្រោមម្ដងទៀត។</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ $storeUrl }}" class="mt-6 space-y-6">
        @csrf

        <x-ui.card>
            <div class="flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#2F6F3E]/10 text-[#2F6F3E]">
                    <i data-lucide="clipboard-plus" class="h-5 w-5"></i>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">{{ $title }}</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">បំពេញព័ត៌មានចាំបាច់សម្រាប់ការបញ្ចូលកំណត់ត្រាថ្មី។</p>
                </div>
            </div>

            <div class="mt-5 grid gap-5 md:grid-cols-2">
                @foreach ($fields as $field)
                    @php
                        $type = $field['type'];
                        $name = $field['name'];
                        $label = $field['label'];
                        $value = old($name);
                        $isTextarea = $type === 'textarea';
                        $isSelect = $type === 'select';
                        $span = $isTextarea ? 'md:col-span-2' : '';
                        $fieldClass = $errors->has($name)
                            ? 'border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-500/10 dark:border-red-500/40 dark:bg-red-500/10'
                            : 'border-slate-200 bg-slate-50 focus:border-[#2F6F3E] focus:bg-white focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:focus:bg-slate-900';
                    @endphp

                    <label class="{{ $span }} block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">{{ $label }}</span>

                        @if ($isTextarea)
                            <textarea
                                name="{{ $name }}"
                                rows="4"
                                placeholder="{{ $field['placeholder'] }}"
                                class="w-full rounded-2xl border px-4 py-3 text-sm font-semibold text-slate-700 outline-none transition focus:ring-4 dark:text-white {{ $fieldClass }}"
                            >{{ $value }}</textarea>
                        @elseif ($isSelect)
                            <select
                                name="{{ $name }}"
                                class="h-12 w-full rounded-2xl border px-4 text-sm font-semibold text-slate-700 outline-none transition focus:ring-4 dark:text-white {{ $fieldClass }}"
                            >
                                <option value="">ជ្រើសរើស</option>
                                @foreach ($field['options'] as $optionValue => $optionLabel)
                                    <option value="{{ $optionValue }}" @selected((string) $value === (string) $optionValue)>{{ $optionLabel }}</option>
                                @endforeach
                            </select>
                        @else
                            <input
                                type="{{ $type }}"
                                name="{{ $name }}"
                                value="{{ $value }}"
                                @if (isset($field['step'])) step="{{ $field['step'] }}" @endif
                                placeholder="{{ $field['placeholder'] }}"
                                class="h-12 w-full rounded-2xl border px-4 text-sm font-semibold text-slate-700 outline-none transition focus:ring-4 dark:text-white {{ $fieldClass }}"
                            >
                        @endif

                        @error($name)
                            <span class="mt-2 block text-xs font-bold text-red-600 dark:text-red-300">{{ $message }}</span>
                        @enderror
                    </label>
                @endforeach
            </div>
        </x-ui.card>

        <div class="sticky bottom-0 z-20 -mx-4 border-t border-[#E5E7EB] bg-white/92 px-4 py-4 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-900/92 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 xl:rounded-t-2xl xl:border xl:shadow-[0_-12px_30px_rgba(15,23,42,0.05)]">
            <div class="mx-auto flex max-w-7xl flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                <x-ui.button label="បោះបង់" icon="x" tone="ghost" :href="$indexUrl" />
                <x-ui.button label="រក្សាទុក" icon="save" type="submit" />
            </div>
        </div>
    </form>
</x-layout.app>
