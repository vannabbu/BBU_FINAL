<x-layout.app-layout title="អ្នកជំងឺ | កែប្រែកំណត់ត្រា" :navigation="$navigation" :doctor="$doctor">
    <x-layout.breadcrumb :items="[
        ['label' => 'ទំព័រដើម', 'href' => route('dashboard')],
        ['label' => 'អ្នកជំងឺ', 'href' => route('patients.update')],
        ['label' => 'កែប្រែកំណត់ត្រា', 'href' => null],
    ]" />

    <x-layout.page-header
        title="កែប្រែកំណត់ត្រាអ្នកជំងឺ"
        subtitle="ធ្វើបច្ចុប្បន្នភាពព័ត៌មានចុះឈ្មោះ ទំនាក់ទំនង និងព័ត៌មានវេជ្ជសាស្ត្ររបស់អ្នកជំងឺ។"
    >
        <a href="{{ route('patients.index') }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
            <i data-lucide="list" class="h-4 w-4"></i>
            បញ្ជីអ្នកជំងឺ
        </a>
    </x-layout.page-header>

    <div
        x-data="{ dirty: false, saving: false }"
        x-on:form-dirty.window="dirty = true"
        class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,1fr)_380px]"
    >
        <main class="space-y-6">
            <form class="space-y-6">
                <x-patient-update.form-card
                    title="ព័ត៌មានអ្នកជំងឺ"
                    description="Patient registration and identity details"
                    icon="user-round-check"
                >
                    <div class="md:col-span-2 flex flex-wrap items-center gap-2">
                        <span class="rounded-full bg-[#2F6F3E]/10 px-3 py-1.5 text-xs font-extrabold text-[#2F6F3E]">
                            {{ $patient['id'] }}
                        </span>
                        @if ($patient['old_record'])
                            <span class="rounded-full border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-extrabold text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300">
                                កំណត់ត្រាចាស់
                            </span>
                        @endif
                    </div>

                    <x-patient-update.form-input
                        label="លេខសម្គាល់អ្នកជំងឺ"
                        name="patient_id"
                        :value="$patient['id']"
                        icon="badge"
                        readonly
                    />
                    <x-patient-update.form-input
                        label="ឈ្មោះពេញ"
                        name="full_name"
                        :value="$patient['full_name']"
                        icon="user-round"
                    />
                    <x-patient-update.form-select
                        label="ភេទ"
                        name="gender"
                        :value="$patient['gender']"
                        :options="$genderOptions"
                        icon="users-round"
                    />
                    <x-patient-update.form-input
                        label="ថ្ងៃខែឆ្នាំកំណើត"
                        name="date_of_birth"
                        type="date"
                        :value="$patient['date_of_birth']"
                        icon="calendar"
                    />
                    <x-patient-update.form-input
                        label="អាយុ"
                        name="age"
                        type="number"
                        :value="$patient['age']"
                        icon="timer"
                    />
                    <x-patient-update.form-input
                        label="លេខទូរស័ព្ទ"
                        name="phone"
                        :value="$patient['phone']"
                        icon="phone"
                    />
                </x-patient-update.form-card>

                <x-patient-update.form-card
                    title="ព័ត៌មានទំនាក់ទំនង"
                    description="Contact information and emergency contact"
                    icon="contact-round"
                >
                    <x-patient-update.form-input
                        label="លេខទូរស័ព្ទ"
                        name="contact_phone"
                        :value="$patient['phone']"
                        icon="phone-call"
                    />
                    <x-patient-update.form-input
                        label="ទំនាក់ទំនងបន្ទាន់"
                        name="emergency_contact"
                        :value="$patient['emergency_contact']"
                        icon="siren"
                    />
                    <x-patient-update.form-input
                        label="អាសយដ្ឋាន"
                        name="address"
                        :value="$patient['address']"
                        icon="map-pin"
                        span
                    />
                </x-patient-update.form-card>

                <x-patient-update.form-card
                    title="ព័ត៌មានវេជ្ជសាស្ត្រ"
                    description="Medical record, insurance, allergy, and health condition notes"
                    icon="heart-pulse"
                >
                    <x-patient-update.form-select
                        label="ក្រុមឈាម"
                        name="blood_type"
                        :value="$patient['blood_type']"
                        :options="$bloodTypes"
                        icon="droplets"
                    />
                    <x-patient-update.form-input
                        label="ក្រុមហ៊ុនធានារ៉ាប់រង"
                        name="insurance_provider"
                        :value="$patient['insurance_provider']"
                        icon="shield-check"
                    />
                    <x-patient-update.form-input
                        label="ប្រតិកម្មអាឡែហ្ស៊ី"
                        name="allergy"
                        :value="$patient['allergy']"
                        icon="triangle-alert"
                        span
                    />
                    <x-patient-update.form-input
                        label="កំណត់ចំណាំ / ស្ថានភាពសុខភាព"
                        name="notes"
                        :value="$patient['notes']"
                        placeholder="បញ្ចូលកំណត់ចំណាំសុខភាព ឬព័ត៌មានពាក់ព័ន្ធ..."
                        textarea
                        span
                    />
                </x-patient-update.form-card>

                <div class="sticky bottom-0 z-20 -mx-4 border-t border-[#E5E7EB] bg-white/90 px-4 py-4 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-900/90 sm:-mx-6 sm:px-6 xl:rounded-t-2xl xl:border xl:shadow-[0_-12px_30px_rgba(15,23,42,0.05)]">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">
                            <span x-show="! dirty">គ្មានការផ្លាស់ប្តូរ</span>
                            <span x-cloak x-show="dirty" class="text-[#2F6F3E]">មានការផ្លាស់ប្តូរមិនទាន់រក្សាទុក</span>
                        </p>
                        <div class="flex flex-col gap-3 sm:flex-row">
                            <x-patient-update.action-button label="ត្រឡប់ក្រោយ" icon="arrow-left" tone="ghost" x-on:click="history.back()" />
                            <x-patient-update.action-button label="លុប / បោះបង់" icon="trash-2" tone="danger" />
                            <x-patient-update.action-button label="រក្សាទុកការកែប្រែអ្នកជំងឺ" icon="save" tone="primary" x-on:click="saving = true; setTimeout(() => { saving = false; dirty = false }, 700)" />
                        </div>
                    </div>
                </div>
            </form>
        </main>

        <x-patient-update.queue-card :queue="$queue" />
    </div>
</x-layout.app-layout>
