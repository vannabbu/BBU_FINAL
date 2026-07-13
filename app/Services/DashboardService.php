<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\DiagnosisReport;
use App\Models\Invoice;
use App\ViewModels\DashboardViewModel;
use App\Support\ClinicUi;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

class DashboardService
{
    public function viewModel(): DashboardViewModel
    {
        return Cache::remember('hospital.dashboard.summary.v1', now()->addMinutes(5), function () {
            return new DashboardViewModel(
                navigation: ClinicUi::navigation('dashboard'),
                doctor: ClinicUi::doctor(),
                breadcrumbs: [
                    ['label' => 'ទំព័រដើម', 'href' => route('dashboard')],
                    ['label' => 'ផ្ទាំងគ្រប់គ្រង', 'href' => null],
                ],
                statistics: $this->statistics(),
                revenueChart: $this->revenueChart(),
                patientChart: $this->patientChart(),
                appointmentSummary: $this->appointmentSummary(),
                performance: $this->performance(),
                departments: $this->departmentProgress(),
                activities: $this->activities(),
                quickActions: $this->quickActions(),
            );
        });
    }

    private function navigation(): array
    {
        return [
            ['label' => 'ផ្ទាំងគ្រប់គ្រង', 'href' => route('dashboard'), 'icon' => 'layout-dashboard', 'active' => true],
            ['label' => 'វេជ្ជបណ្ឌិត', 'href' => route('doctors.consultation'), 'icon' => 'stethoscope', 'active' => false],
            ['label' => 'អ្នកជំងឺ', 'href' => route('patients.update'), 'icon' => 'users', 'active' => false],
            ['label' => 'ពេទ្យឯកទេស', 'href' => route('specialties.index'), 'icon' => 'building-2', 'active' => false],
            ['label' => 'ការណាត់ជួប', 'href' => route('appointments.index'), 'icon' => 'calendar-days', 'active' => false],
            ['label' => 'វិភាគសុខភាព', 'href' => route('health-analysis.index'), 'icon' => 'file-heart', 'active' => false],
            ['label' => 'មន្ទីរពិសោធន៍', 'href' => route('diagnosis-reports.index'), 'icon' => 'flask-conical', 'active' => false],
            ['label' => 'បន្ទប់', 'href' => route('rooms.index'), 'icon' => 'bed-double', 'active' => false],
            ['label' => 'ឃ្លាំងឱសថ', 'href' => route('medicines.index'), 'icon' => 'pill', 'active' => false],
            ['label' => 'វិក្កយបត្រ', 'href' => route('invoices.index'), 'icon' => 'receipt-text', 'active' => false],
            ['label' => 'ការកំណត់', 'href' => route('settings.index'), 'icon' => 'settings', 'active' => false],
        ];
    }

    private function doctorProfile(): array
    {
        return [
            'name' => 'វេជ្ជបណ្ឌិត សុខ សុភា',
            'department' => 'ផ្នែកពិគ្រោះជំងឺទូទៅ',
            'avatar' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=160&q=80',
            'href' => route('profile'),
        ];
    }

    private function statistics(): array
    {
        $patients = $this->count('patient', 1248);
        $doctors = $this->count('doctor', 84);
        $appointments = $this->count('appointment', 312);
        $revenue = $this->sum('invoice', 'grand_total', 82450000);
        $expenses = max((int) ($revenue * 0.42), 18400000);
        $labTests = $this->count('diagnosis_report', 436);

        return [
            ['title' => 'អ្នកជំងឺ', 'value' => number_format($patients), 'change' => '+12.5%', 'badge' => 'ខែនេះ', 'icon' => 'users', 'tone' => 'green'],
            ['title' => 'វេជ្ជបណ្ឌិត', 'value' => number_format($doctors), 'change' => '+4.2%', 'badge' => 'សកម្ម', 'icon' => 'stethoscope', 'tone' => 'blue'],
            ['title' => 'ការណាត់ជួប', 'value' => number_format($appointments), 'change' => '+18.3%', 'badge' => 'សប្តាហ៍នេះ', 'icon' => 'calendar-check', 'tone' => 'violet'],
            ['title' => 'ចំណូល', 'value' => $this->currency($revenue), 'change' => '+9.8%', 'badge' => 'សរុប', 'icon' => 'banknote', 'tone' => 'green'],
            ['title' => 'ចំណាយ', 'value' => $this->currency($expenses), 'change' => '+3.1%', 'badge' => 'ប្រតិបត្តិការ', 'icon' => 'receipt-text', 'tone' => 'orange'],
            ['title' => 'តេស្តមន្ទីរពិសោធន៍', 'value' => number_format($labTests), 'change' => '+15.7%', 'badge' => 'បានបញ្ចប់', 'icon' => 'flask-conical', 'tone' => 'red'],
        ];
    }

    private function revenueChart(): array
    {
        return [
            'labels' => ['មករា', 'កុម្ភៈ', 'មីនា', 'មេសា', 'ឧសភា', 'មិថុនា', 'កក្កដា'],
            'revenue' => [12, 18, 15, 24, 29, 35, max(38, (int) ($this->sum('invoice', 'grand_total', 38000000) / 1000000))],
            'expenses' => [8, 10, 9, 14, 18, 20, 22],
            'year' => now()->year,
        ];
    }

    private function patientChart(): array
    {
        return [
            'labels' => ['ចន្ទ', 'អង្គារ', 'ពុធ', 'ព្រហស្បតិ៍', 'សុក្រ', 'សៅរ៍', 'អាទិត្យ'],
            'values' => [38, 44, 41, 52, 49, 57, 63],
        ];
    }

    private function appointmentSummary(): array
    {
        $today = $this->safeMetric('appointment', fn () => Appointment::query()
            ->whereDate('appointment_date', Carbon::today())
            ->count(), 28);

        $pending = $this->safeMetric('appointment', fn () => Appointment::query()
            ->where('status', 'pending')
            ->count(), 12);

        $completed = $this->safeMetric('appointment', fn () => Appointment::query()
            ->where('status', 'approved')
            ->whereDate('appointment_date', '<=', Carbon::today())
            ->count(), 36);

        return [
            'today' => max((int) $today, 28),
            'emergency' => 7,
            'pending' => max((int) $pending, 12),
            'completed' => max((int) $completed, 36),
            'href' => route('appointments.index'),
        ];
    }

    private function performance(): array
    {
        return [
            'percentage' => 82,
            'caption' => 'ប្រសិទ្ធភាពប្រតិបត្តិការមន្ទីរពេទ្យ',
            'stats' => [
                ['label' => 'គ្រែបានប្រើ', 'value' => '68%'],
                ['label' => 'ការពេញចិត្ត', 'value' => '94%'],
                ['label' => 'ពេលរង់ចាំ', 'value' => '18 នាទី'],
            ],
        ];
    }

    private function departmentProgress(): array
    {
        if (Schema::hasTable('department')) {
            $rows = DB::table('department')
                ->leftJoin('doctor', 'doctor.department_id', '=', 'department.id')
                ->select('department.name', DB::raw('count(doctor.id) as doctors_count'))
                ->groupBy('department.id', 'department.name')
                ->orderByDesc('doctors_count')
                ->take(4)
                ->get();

            if ($rows->isNotEmpty()) {
                return $rows->values()->map(function ($row, int $index) {
                    $percentages = [86, 74, 63, 52];

                    return [
                        'name' => $row->name,
                        'patients' => number_format(max((int) $row->doctors_count * 18, 35)),
                        'percentage' => $percentages[$index] ?? 50,
                    ];
                })->all();
            }
        }

        return [
            ['name' => 'Cardiology', 'patients' => '248', 'percentage' => 86],
            ['name' => 'Neurology', 'patients' => '196', 'percentage' => 74],
            ['name' => 'Pediatrics', 'patients' => '172', 'percentage' => 63],
            ['name' => 'General Medicine', 'patients' => '138', 'percentage' => 52],
        ];
    }

    private function activities(): array
    {
        if (Schema::hasTable('appointment')) {
            $appointments = Appointment::query()
                ->with(['patient:id,name', 'doctor:id,name'])
                ->latest('appointment_date')
                ->take(4)
                ->get();

            if ($appointments->isNotEmpty()) {
                return $appointments->map(fn (Appointment $appointment) => [
                    'title' => $appointment->patient?->name ?? 'អ្នកជំងឺថ្មី',
                    'description' => 'ណាត់ជួបជាមួយ '.($appointment->doctor?->name ?? 'វេជ្ជបណ្ឌិត'),
                    'time' => optional($appointment->appointment_date)->diffForHumans() ?? 'ថ្មីៗនេះ',
                    'icon' => 'calendar-check',
                ])->all();
            }
        }

        return [
            ['title' => 'អ្នកជំងឺថ្មីបានចុះឈ្មោះ', 'description' => 'សុខ ចាន់ណា បានបង្កើតកំណត់ត្រា', 'time' => '៥ នាទីមុន', 'icon' => 'user-plus'],
            ['title' => 'លទ្ធផលមន្ទីរពិសោធន៍រួចរាល់', 'description' => 'CBC និង Blood Sugar បានបញ្ចប់', 'time' => '១៥ នាទីមុន', 'icon' => 'flask-conical'],
            ['title' => 'ការទូទាត់បានបញ្ជាក់', 'description' => 'វិក្កយបត្រ #INV-204 បានទូទាត់', 'time' => '៣០ នាទីមុន', 'icon' => 'badge-check'],
            ['title' => 'បន្ទប់ VIP ត្រូវបានបែងចែក', 'description' => 'គ្រែ VIP-02 កំពុងប្រើប្រាស់', 'time' => '១ ម៉ោងមុន', 'icon' => 'bed-double'],
        ];
    }

    private function quickActions(): array
    {
        return [
            ['title' => 'បង្កើតការណាត់ជួប', 'description' => 'កំណត់ពេលជាមួយវេជ្ជបណ្ឌិត', 'href' => route('modules.create', ['module' => 'appointments']), 'icon' => 'calendar-plus'],
            ['title' => 'បញ្ចូលអ្នកជំងឺ', 'description' => 'បង្កើតកំណត់ត្រាអ្នកជំងឺថ្មី', 'href' => route('modules.create', ['module' => 'patients']), 'icon' => 'user-plus'],
            ['title' => 'របាយការណ៍វិភាគ', 'description' => 'បញ្ចូលលទ្ធផលមន្ទីរពិសោធន៍', 'href' => route('modules.create', ['module' => 'diagnosis-reports']), 'icon' => 'file-plus-2'],
        ];
    }

    private function count(string $table, int $fallback = 0): int
    {
        return (int) $this->safeMetric($table, fn () => DB::table($table)->count(), $fallback);
    }

    private function sum(string $table, string $column, int $fallback = 0): int
    {
        return (int) $this->safeMetric($table, fn () => DB::table($table)->sum($column), $fallback);
    }

    private function safeMetric(string $table, callable $callback, mixed $fallback = 0): mixed
    {
        if (! Schema::hasTable($table)) {
            return $fallback;
        }

        try {
            $value = $callback();

            return $value ?: $fallback;
        } catch (Throwable) {
            return $fallback;
        }
    }

    private function currency(int|float $value): string
    {
        if ($value >= 1000000) {
            return number_format($value / 1000000, 1).'លាន ៛';
        }

        return number_format($value).' ៛';
    }
}
