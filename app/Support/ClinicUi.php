<?php

namespace App\Support;

class ClinicUi
{
    public static function doctor(): array
    {
        return [
            'name' => 'វេជ្ជបណ្ឌិត សុខ សុភា',
            'department' => 'ផ្នែកពិគ្រោះជំងឺទូទៅ',
            'avatar' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=160&q=80',
            'href' => route('profile'),
        ];
    }

    public static function navigation(?string $active = null): array
    {
        return collect([
            ['key' => 'dashboard', 'label' => 'ផ្ទាំងគ្រប់គ្រង', 'href' => route('dashboard'), 'icon' => 'layout-dashboard', 'patterns' => ['dashboard']],
            ['key' => 'specialties', 'label' => 'ពេទ្យឯកទេស', 'href' => route('specialties.index'), 'icon' => 'building-2', 'patterns' => ['specialties.*', 'departments.*']],
            ['key' => 'doctors', 'label' => 'វេជ្ជបណ្ឌិត', 'href' => route('doctors.consultation'), 'icon' => 'stethoscope', 'patterns' => ['doctors.*']],
            ['key' => 'patients', 'label' => 'អ្នកជំងឺ', 'href' => route('patients.update'), 'icon' => 'users', 'patterns' => ['patients.*']],
            ['key' => 'health-analysis', 'label' => 'វិភាគសុខភាព', 'href' => route('health-analysis.index'), 'icon' => 'file-heart', 'patterns' => ['health-analysis.*']],
            ['key' => 'appointments', 'label' => 'ការណាត់ជួប', 'href' => route('appointments.index'), 'icon' => 'calendar-days', 'patterns' => ['appointments.*']],
            ['key' => 'diagnosis-reports', 'label' => 'មន្ទីរពិសោធន៍', 'href' => route('diagnosis-reports.index'), 'icon' => 'flask-conical', 'patterns' => ['diagnosis-reports.*']],
            ['key' => 'rooms', 'label' => 'បន្ទប់', 'href' => route('rooms.index'), 'icon' => 'bed-double', 'patterns' => ['rooms.*']],
            ['key' => 'medicines', 'label' => 'ឃ្លាំងឱសថ', 'href' => route('medicines.index'), 'icon' => 'pill', 'patterns' => ['medicines.*']],
            ['key' => 'invoices', 'label' => 'វិក្កយបត្រ', 'href' => route('invoices.index'), 'icon' => 'receipt-text', 'patterns' => ['invoices.*']],
            ['key' => 'settings', 'label' => 'ការកំណត់', 'href' => route('settings.index'), 'icon' => 'settings', 'patterns' => ['settings.*']],
        ])->map(function (array $item) use ($active) {
            $item['active'] = $active
                ? $item['key'] === $active
                : request()->routeIs(...$item['patterns']);

            unset($item['key'], $item['patterns']);

            return $item;
        })->all();
    }
}
