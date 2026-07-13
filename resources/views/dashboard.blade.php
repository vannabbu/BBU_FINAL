<x-layout.app-layout title="ផ្ទាំងគ្រប់គ្រង" :navigation="$navigation" :doctor="$doctor">
    <x-layout.breadcrumb :items="$breadcrumbs" />

    <x-layout.page-header
        title="ផ្ទាំងគ្រប់គ្រងមន្ទីរពេទ្យ"
        subtitle="មើលស្ថានភាពប្រតិបត្តិការ អ្នកជំងឺ ការណាត់ជួប ចំណូល និងការវិភាគសុខភាពក្នុងមួយកន្លែង។"
    >
        <a href="{{ route('modules.create', ['module' => 'appointments']) }}" class="inline-flex items-center gap-2 rounded-2xl bg-[#2F6F3E] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#285f35]">
            <i data-lucide="calendar-plus" class="h-4 w-4"></i>
            ការណាត់ជួបថ្មី
        </a>
        <a href="{{ route('profile') }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
            <i data-lucide="user-round" class="h-4 w-4"></i>
            ប្រវត្តិរូប
        </a>
    </x-layout.page-header>

    <section class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-6">
        @foreach ($statistics as $stat)
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

    <section class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
        <x-dashboard.chart-card title="ចំណូល និងចំណាយ" subtitle="តារាងបន្ទាត់ប្រចាំខែ ឆ្នាំ {{ $revenueChart['year'] }}">
            <x-slot:actions>
                <select class="rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-600 outline-none focus:border-[#2F6F3E] focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                    <option>{{ $revenueChart['year'] }}</option>
                    <option>{{ $revenueChart['year'] - 1 }}</option>
                </select>
                <select class="rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-600 outline-none focus:border-[#2F6F3E] focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                    <option>ប្រចាំខែ</option>
                    <option>ប្រចាំត្រីមាស</option>
                </select>
            </x-slot:actions>
            <x-dashboard.revenue-chart :chart="$revenueChart" />
        </x-dashboard.chart-card>

        <div class="space-y-6">
            <x-dashboard.appointment-summary :summary="$appointmentSummary" />
            <x-dashboard.circular-progress
                :percentage="$performance['percentage']"
                :caption="$performance['caption']"
                :stats="$performance['stats']"
            />
        </div>
    </section>

    <section class="mt-6 grid gap-6 xl:grid-cols-3">
        <div class="xl:col-span-2">
            <x-dashboard.chart-card title="អ្នកជំងឺប្រចាំសប្តាហ៍" subtitle="តារាងផ្ទៃបង្ហាញចំនួនអ្នកជំងឺតាមថ្ងៃ">
                <x-dashboard.patient-chart :chart="$patientChart" />
            </x-dashboard.chart-card>
        </div>

        <x-dashboard.department-progress :departments="$departments" />
    </section>

    <section class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
        <div>
            <h2 class="mb-4 text-lg font-extrabold text-slate-950 dark:text-white">សកម្មភាពរហ័ស</h2>
            <div class="grid gap-4 md:grid-cols-3">
                @foreach ($quickActions as $action)
                    <x-dashboard.quick-action-card
                        :title="$action['title']"
                        :description="$action['description']"
                        :href="$action['href']"
                        :icon="$action['icon']"
                    />
                @endforeach
            </div>
        </div>

        <x-dashboard.activity-card :activities="$activities" />
    </section>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const primary = '#2F6F3E';
                const success = '#16A34A';
                const warning = '#F59E0B';

                const revenueCanvas = document.getElementById('revenueChart');
                if (revenueCanvas && window.Chart) {
                    const data = JSON.parse(revenueCanvas.dataset.chart);
                    const context = revenueCanvas.getContext('2d');
                    const gradient = context.createLinearGradient(0, 0, 0, 280);
                    gradient.addColorStop(0, 'rgba(47, 111, 62, 0.20)');
                    gradient.addColorStop(1, 'rgba(47, 111, 62, 0.00)');

                    new Chart(revenueCanvas, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [
                                {
                                    label: 'ចំណូល',
                                    data: data.revenue,
                                    borderColor: primary,
                                    backgroundColor: gradient,
                                    fill: true,
                                    tension: 0.42,
                                    borderWidth: 3,
                                    pointRadius: 0,
                                    pointHoverRadius: 5,
                                },
                                {
                                    label: 'ចំណាយ',
                                    data: data.expenses,
                                    borderColor: warning,
                                    backgroundColor: 'rgba(245, 158, 11, 0.08)',
                                    fill: true,
                                    tension: 0.42,
                                    borderWidth: 3,
                                    pointRadius: 0,
                                    pointHoverRadius: 5,
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: { duration: 900, easing: 'easeOutQuart' },
                            interaction: { mode: 'index', intersect: false },
                            plugins: {
                                legend: { labels: { usePointStyle: true, boxWidth: 8 } },
                                tooltip: {
                                    callbacks: {
                                        label: (item) => `${item.dataset.label}: ${item.formattedValue} លាន ៛`,
                                    },
                                },
                            },
                            scales: {
                                x: { grid: { display: false } },
                                y: {
                                    beginAtZero: true,
                                    ticks: { callback: (value) => `${value}លាន` },
                                    grid: { color: 'rgba(148, 163, 184, 0.18)' },
                                },
                            },
                        },
                    });
                }

                const patientCanvas = document.getElementById('patientChart');
                if (patientCanvas && window.Chart) {
                    const data = JSON.parse(patientCanvas.dataset.chart);
                    const context = patientCanvas.getContext('2d');
                    const gradient = context.createLinearGradient(0, 0, 0, 240);
                    gradient.addColorStop(0, 'rgba(22, 163, 74, 0.22)');
                    gradient.addColorStop(1, 'rgba(22, 163, 74, 0.00)');

                    new Chart(patientCanvas, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'អ្នកជំងឺ',
                                data: data.values,
                                borderColor: success,
                                backgroundColor: gradient,
                                fill: true,
                                tension: 0.45,
                                borderWidth: 3,
                                pointRadius: 0,
                                pointHoverRadius: 5,
                            }],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: { duration: 850, easing: 'easeOutQuart' },
                            plugins: { legend: { display: false } },
                            scales: {
                                x: { grid: { display: false } },
                                y: {
                                    beginAtZero: true,
                                    grid: { color: 'rgba(148, 163, 184, 0.18)' },
                                },
                            },
                        },
                    });
                }
            });
        </script>
    @endpush
</x-layout.app-layout>
