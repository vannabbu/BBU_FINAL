<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Medicine;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Schema;
use Throwable;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return $this->legacyDashboard();
    }

    public function doctorProfile()
    {
        $doctor = [
            'name' => 'វេជ្ជបណ្ឌិត សុខ សុភា',
            'avatar' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=240&q=80',
            'status' => 'កំពុងបម្រើការ',
            'specialty' => 'វេជ្ជសាស្ត្រទូទៅ',
            'department' => 'ផ្នែកពិគ្រោះជំងឺទូទៅ',
            'location' => 'PRUM SANTEPHEAP CLINIC, ភ្នំពេញ',
            'email' => 'sophea.doctor@prumsantepheap.clinic',
            'phone' => '012 345 678',
            'doctor_id' => 'PSC-DR-0042',
            'address' => 'ផ្ទះលេខ 12, ផ្លូវ 271, ខណ្ឌមានជ័យ, ភ្នំពេញ',
            'emergency_contact' => 'លោក សុខ ដារ៉ា - 010 222 333',
            'notes' => 'ពិនិត្យអ្នកជំងឺប្រចាំថ្ងៃ និងតាមដានលទ្ធផលមន្ទីរពិសោធន៍សំខាន់ៗ។',
            'license' => 'MC-KH-2026-1188',
            'qualification' => 'MD, General Medicine, University of Health Sciences',
        ];

        $navigation = [
            ['label' => 'ផ្ទាំងគ្រប់គ្រង', 'href' => route('dashboard'), 'icon' => 'dashboard', 'active' => request()->routeIs('dashboard')],
            ['label' => 'ពេទ្យឯកទេស', 'href' => route('specialties.index'), 'icon' => 'stethoscope', 'active' => false],
            ['label' => 'វេជ្ជបណ្ឌិត', 'href' => route('doctors.consultation'), 'icon' => 'doctor', 'active' => false],
            ['label' => 'អ្នកជំងឺ', 'href' => route('patients.update'), 'icon' => 'patients', 'active' => false],
            ['label' => 'វិភាគសុខភាព', 'href' => route('health-analysis.index'), 'icon' => 'chart', 'active' => false],
            ['label' => 'ការណាត់ជួប', 'href' => route('appointments.index'), 'icon' => 'calendar', 'active' => false],
            ['label' => 'មន្ទីរពិសោធន៍', 'href' => route('diagnosis-reports.index'), 'icon' => 'lab', 'active' => false],
            ['label' => 'បន្ទប់', 'href' => route('rooms.index'), 'icon' => 'rooms', 'active' => false],
            ['label' => 'ឃ្លាំងឱសថ', 'href' => route('medicines.index'), 'icon' => 'medicine', 'active' => false],
            ['label' => 'វិក្កយបត្រ', 'href' => route('invoices.index'), 'icon' => 'receipt', 'active' => false],
            ['label' => 'ការកំណត់', 'href' => route('settings.index'), 'icon' => 'settings', 'active' => false],
        ];

        $navigation = $this->clinicNavigation();

        $specialties = [
            'វេជ្ជសាស្ត្រទូទៅ',
            'ជំងឺបេះដូង',
            'កុមារ',
            'មន្ទីរពិសោធន៍',
            'រោគស្ត្រី',
        ];

        return view('doctor.profile', [
            'doctor' => $doctor,
            'navigation' => $navigation,
            'specialties' => $specialties,
        ]);
    }

    public function legacyDashboard(DashboardService $dashboard)
    {
        return view('dashboard', $dashboard->viewModel()->toArray());
    }

    public function oldDashboard()
    {
        $stats = [
            [
                'label' => 'អ្នកជំងឺសរុប',
                'value' => $this->metric('patient', fn () => number_format((int) Schema::getConnection()->table('patient')->count())),
                'caption' => 'កំណត់ត្រាអ្នកជំងឺ',
            ],
            [
                'label' => 'វេជ្ជបណ្ឌិត',
                'value' => $this->metric('doctor', fn () => number_format((int) Schema::getConnection()->table('doctor')->count())),
                'caption' => 'បុគ្គលិកព្យាបាល',
            ],
            [
                'label' => 'ណាត់ជួបថ្ងៃនេះ',
                'value' => $this->metric('appointment', fn () => number_format((int) Appointment::query()
                    ->whereDate('appointment_date', now()->toDateString())
                    ->count())),
                'caption' => 'កាលវិភាគប្រចាំថ្ងៃ',
            ],
            [
                'label' => 'វិក្កយបត្រមិនទាន់ទូទាត់',
                'value' => $this->metric('invoice', fn () => number_format((int) Invoice::query()
                    ->whereIn('status', ['unpaid', 'partial'])
                    ->count())),
                'caption' => 'ត្រូវពិនិត្យការទូទាត់',
            ],
        ];

        $inventory = [
            [
                'label' => 'ឱសថសរុបក្នុងឃ្លាំង',
                'value' => $this->metric('medicine', fn () => number_format((int) Medicine::query()->sum('total_quantity'))),
            ],
            [
                'label' => 'គ្រែទំនេរ',
                'value' => $this->metric('bed', fn () => number_format((int) Schema::getConnection()
                    ->table('bed')
                    ->where('status', 'available')
                    ->count())),
            ],
            [
                'label' => 'ឈាមក្នុងស្តុក',
                'value' => $this->metric('blood_bank', fn () => number_format((int) Schema::getConnection()
                    ->table('blood_bank')
                    ->sum('status'))),
            ],
        ];

        $appointments = $this->metric('appointment', fn () => Appointment::query()
            ->with(['patient', 'doctor'])
            ->latest('appointment_date')
            ->take(5)
            ->get(), collect());

        return view('dashboard', [
            'stats' => $stats,
            'inventory' => $inventory,
            'appointments' => $appointments,
        ]);
    }

    private function metric(string $table, callable $callback, mixed $default = '0'): mixed
    {
        if (! Schema::hasTable($table)) {
            return $default;
        }

        try {
            return $callback();
        } catch (Throwable) {
            return $default;
        }
    }
}
