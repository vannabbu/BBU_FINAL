<x-layout.app title="ឃ្លាំងឱសថ | គ្រប់គ្រងស្តុក" :navigation="$navigation" :doctor="$doctor">
    <x-layout.breadcrumb :items="[
        ['label' => 'ទំព័រដើម', 'href' => route('dashboard')],
        ['label' => 'ឃ្លាំងឱសថ', 'href' => route('medicines.index')],
        ['label' => 'គ្រប់គ្រងស្តុក', 'href' => null],
    ]" />

    <x-layout.page-header
        title="គ្រប់គ្រងស្តុកឱសថ"
        subtitle="តាមដានបរិមាណឱសថ តម្លៃស្តុក ការផុតកំណត់ និងការណែនាំបញ្ជាទិញសម្រាប់ផ្នែកឱសថស្ថាន។"
    >
        <x-ui.button label="នាំចេញរបាយការណ៍" icon="download" tone="ghost" />
        <x-ui.button label="បន្ថែមឱសថថ្មី" icon="package-plus" :href="route('modules.create', ['module' => 'medicines'])" />
    </x-layout.page-header>

    <section class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $stat)
            <x-dashboard.stat-card
                :title="$stat['title']"
                :value="$stat['value']"
                :change="$stat['change']"
                :badge="$stat['badge']"
                :icon="$stat['icon']"
                :tone="$stat['tone']"
            />
        @endforeach
    </section>

    <section class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,1fr)_380px]">
        <div class="min-w-0">
            <x-pharmacy.inventory-table :inventory="$inventory" :categories="$categories" />
        </div>

        <aside class="space-y-6 xl:sticky xl:top-24 xl:self-start">
            <x-pharmacy.insight-card :insight="$insight" />
            <x-pharmacy.activity-panel :activities="$activities" />
        </aside>
    </section>
</x-layout.app>
