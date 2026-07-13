<x-layout.app-layout title="វេជ្ជបណ្ឌិត | ពិគ្រោះជំងឺ" :navigation="$navigation" :doctor="$doctor">
    <x-layout.breadcrumb :items="[
        ['label' => 'ទំព័រដើម', 'href' => route('dashboard')],
        ['label' => 'វេជ្ជបណ្ឌិត', 'href' => route('doctors.consultation')],
        ['label' => 'ពិគ្រោះជំងឺ', 'href' => null],
    ]" />

    <x-layout.page-header
        title="ផ្ទាំងពិគ្រោះជំងឺ"
        subtitle="កត់ត្រារោគសញ្ញា រោគវិនិច្ឆ័យ វេជ្ជបញ្ជា និងសកម្មភាពបន្ទាប់សម្រាប់អ្នកជំងឺ។"
    >
        <span class="inline-flex items-center gap-2 rounded-full bg-[#2F6F3E]/10 px-3 py-2 text-sm font-bold text-[#2F6F3E]">
            <i data-lucide="shield-check" class="h-4 w-4"></i>
            Secure consultation
        </span>
    </x-layout.page-header>

    <div class="mt-6 grid gap-6 xl:grid-cols-[360px_minmax(0,1fr)]">
        <aside class="space-y-6">
            <x-consultation.patient-card :patient="$patient" />

            <section class="rounded-2xl border border-[#E5E7EB] bg-white p-5 shadow-[0_12px_30px_rgba(15,23,42,0.04)] dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">សញ្ញាជីវិត</h2>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Vital signs latest reading</p>
                    </div>
                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-bold text-green-700 dark:bg-green-500/10 dark:text-green-300">Updated</span>
                </div>
                <div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-1">
                    @foreach ($vitals as $vital)
                        <x-consultation.vital-sign-card
                            :label="$vital['label']"
                            :value="$vital['value']"
                            :unit="$vital['unit']"
                            :status="$vital['status']"
                            :icon="$vital['icon']"
                            :tone="$vital['tone']"
                        />
                    @endforeach
                </div>
            </section>
        </aside>

        <main class="space-y-6">
            <div class="grid gap-6 lg:grid-cols-2">
                <x-consultation.notes-card title="កំណត់ចំណាំវេជ្ជបណ្ឌិត" icon="notebook-pen">
                    {{ $notes['doctor'] }}
                </x-consultation.notes-card>

                <x-consultation.notes-card title="សង្ខេបរោគសញ្ញាមុនៗ" icon="history">
                    {{ $notes['symptoms'] }}
                </x-consultation.notes-card>
            </div>

            <section
                x-data="{ complaint: '', max: 900 }"
                class="rounded-2xl border border-[#E5E7EB] bg-white p-5 shadow-[0_12px_30px_rgba(15,23,42,0.04)] dark:border-slate-800 dark:bg-slate-900"
            >
                <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">បញ្ហាសំខាន់របស់អ្នកជំងឺ</h2>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Chief complaint and current symptoms</p>
                    </div>
                    <span class="text-xs font-bold text-slate-400"><span x-text="complaint.length"></span>/<span x-text="max"></span></span>
                </div>
                <textarea
                    x-model="complaint"
                    x-bind:maxlength="max"
                    rows="7"
                    placeholder="សូមបញ្ចូលបញ្ហាសំខាន់ៗដែលអ្នកជំងឺបានប្រាប់ ដូចជា ឈឺក្បាល ក្តៅខ្លួន ឈឺទ្រូង ឬរោគសញ្ញាផ្សេងៗ..."
                    class="mt-5 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm leading-7 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900"
                ></textarea>
            </section>

            <x-consultation.diagnosis-tags :selected="$diagnoses" :suggestions="$suggestions" />

            <section
                x-data="{ medication: 'Paracetamol 500mg - 1 tablet every 8 hours after food\nOral rehydration salts as needed\nFollow-up in 3 days if symptoms persist' }"
                class="rounded-2xl border border-[#E5E7EB] bg-white p-5 shadow-[0_12px_30px_rgba(15,23,42,0.04)] dark:border-slate-800 dark:bg-slate-900"
            >
                <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">វេជ្ជបញ្ជា</h2>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Medication instructions and prescription details</p>
                    </div>
                    <span class="inline-flex items-center gap-2 rounded-full bg-[#2F6F3E]/10 px-3 py-1.5 text-xs font-bold text-[#2F6F3E]">
                        <i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i>
                        រួចរាល់សម្រាប់បញ្ជាក់
                    </span>
                </div>
                <textarea
                    x-model="medication"
                    rows="7"
                    placeholder="សូមបញ្ចូលឈ្មោះថ្នាំ កម្រិតប្រើប្រាស់ ចំនួនថ្ងៃ និងការណែនាំ..."
                    class="mt-5 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm leading-7 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900"
                ></textarea>
                <p class="mt-3 text-sm font-medium text-slate-500 dark:text-slate-400">
                    ស្ថានភាព៖ វេជ្ជបញ្ជានឹងត្រូវរក្សាទុកបន្ទាប់ពីចុច “បញ្ជាក់ និងចេញវេជ្ជបញ្ជា”។
                </p>
            </section>
        </main>
    </div>

    <div class="sticky bottom-0 z-20 -mx-4 mt-8 border-t border-[#E5E7EB] bg-white/90 px-4 py-4 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-900/90 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
        <div class="mx-auto flex max-w-7xl flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
            <x-consultation.action-button label="បញ្ជូនទៅតេស្តមន្ទីរពិសោធន៍" icon="flask-conical" tone="blue" />
            <x-consultation.action-button label="ដាក់សម្រាកជាអ្នកជំងឺក្នុង" icon="bed-double" tone="warning" />
            <x-consultation.action-button label="បញ្ជាក់ និងចេញវេជ្ជបញ្ជា" icon="badge-check" tone="primary" />
        </div>
    </div>
</x-layout.app-layout>
