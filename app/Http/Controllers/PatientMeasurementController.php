<?php

namespace App\Http\Controllers;

class PatientMeasurementController extends Controller
{
    public function create()
    {
        return view('measurements.create', [
            'doctor' => $this->clinicDoctor(),
            'navigation' => $this->clinicNavigation('diagnosis-reports'),
            'patients' => $this->patients(),
            'recentPatients' => array_slice($this->patients(), 0, 3),
            'visit' => [
                'id' => 'VIS-2026-0708-0148',
                'date' => '2026-07-08',
                'time' => '09:45',
                'department' => 'Laboratory',
                'assigned_doctor' => 'វេជ្ជបណ្ឌិត សុខ សុភា',
            ],
            'departments' => [
                'Laboratory',
                'General Medicine',
                'Cardiology',
                'Emergency',
                'Pediatrics',
                'Neurology',
                'Surgery',
            ],
            'doctors' => [
                'វេជ្ជបណ្ឌិត សុខ សុភា',
                'វេជ្ជបណ្ឌិត ចាន់ ដារា',
                'វេជ្ជបណ្ឌិត លី សុវណ្ណ',
            ],
            'painScale' => range(0, 10),
            'history' => [
                ['date' => '2026-07-07 10:20', 'blood_pressure' => '122/80', 'temperature' => '37.0°C', 'heart_rate' => '76 bpm', 'bmi' => '22.7', 'recorded_by' => 'Nurse Sreynang', 'trend' => 'stable'],
                ['date' => '2026-07-01 14:05', 'blood_pressure' => '130/86', 'temperature' => '37.4°C', 'heart_rate' => '82 bpm', 'bmi' => '22.8', 'recorded_by' => 'Dr. Sophea', 'trend' => 'up'],
                ['date' => '2026-06-24 08:30', 'blood_pressure' => '118/78', 'temperature' => '36.8°C', 'heart_rate' => '72 bpm', 'bmi' => '22.6', 'recorded_by' => 'Nurse Sreynang', 'trend' => 'down'],
            ],
        ]);
    }

    private function topbarDoctor(): array
    {
        return [
            'name' => 'វេជ្ជបណ្ឌិត សុខ សុភា',
            'department' => 'ផ្នែកពិគ្រោះជំងឺទូទៅ',
            'avatar' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=160&q=80',
            'href' => route('profile'),
        ];
    }

    private function navigation(): array
    {
        return [
            ['label' => 'ផ្ទាំងគ្រប់គ្រង', 'href' => route('dashboard'), 'icon' => 'layout-dashboard', 'active' => false],
            ['label' => 'វេជ្ជបណ្ឌិត', 'href' => route('doctors.consultation'), 'icon' => 'stethoscope', 'active' => false],
            ['label' => 'អ្នកជំងឺ', 'href' => route('patients.update'), 'icon' => 'users', 'active' => false],
            ['label' => 'ពេទ្យឯកទេស', 'href' => route('specialties.index'), 'icon' => 'building-2', 'active' => false],
            ['label' => 'ការណាត់ជួប', 'href' => route('appointments.index'), 'icon' => 'calendar-days', 'active' => false],
            ['label' => 'វិភាគសុខភាព', 'href' => route('health-analysis.index'), 'icon' => 'file-heart', 'active' => false],
            ['label' => 'មន្ទីរពិសោធន៍', 'href' => route('diagnosis-reports.index'), 'icon' => 'flask-conical', 'active' => true],
            ['label' => 'បន្ទប់', 'href' => route('rooms.index'), 'icon' => 'bed-double', 'active' => false],
            ['label' => 'ឃ្លាំងឱសថ', 'href' => route('medicines.index'), 'icon' => 'pill', 'active' => false],
            ['label' => 'វិក្កយបត្រ', 'href' => route('invoices.index'), 'icon' => 'receipt-text', 'active' => false],
            ['label' => 'ការកំណត់', 'href' => route('settings.index'), 'icon' => 'settings', 'active' => false],
        ];
    }

    private function patients(): array
    {
        return [
            [
                'id' => 'PT-2026-0148',
                'full_name' => 'សុខ ចាន់ណា',
                'avatar' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=180&q=80',
                'gender' => 'Female',
                'age' => 32,
                'blood_type' => 'A+',
                'height' => 165,
                'weight' => 62,
                'phone' => '010 123 456',
                'allergies' => ['Penicillin'],
                'visit_id' => 'VIS-2026-0708-0148',
            ],
            [
                'id' => 'PT-2026-0151',
                'full_name' => 'ហេង វិសាល',
                'avatar' => 'https://images.unsplash.com/photo-1607990281513-2c110a25bd8c?auto=format&fit=crop&w=180&q=80',
                'gender' => 'Male',
                'age' => 41,
                'blood_type' => 'O+',
                'height' => 172,
                'weight' => 74,
                'phone' => '012 222 111',
                'allergies' => ['None'],
                'visit_id' => 'VIS-2026-0708-0151',
            ],
            [
                'id' => 'PT-2026-0154',
                'full_name' => 'លី សុវណ្ណ',
                'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=180&q=80',
                'gender' => 'Male',
                'age' => 27,
                'blood_type' => 'B+',
                'height' => 170,
                'weight' => 68,
                'phone' => '015 333 444',
                'allergies' => ['Seafood'],
                'visit_id' => 'VIS-2026-0708-0154',
            ],
            [
                'id' => 'PT-2026-0159',
                'full_name' => 'ចាន់ ស្រីនាង',
                'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=180&q=80',
                'gender' => 'Female',
                'age' => 35,
                'blood_type' => 'AB+',
                'height' => 160,
                'weight' => 58,
                'phone' => '017 456 789',
                'allergies' => ['Ibuprofen'],
                'visit_id' => 'VIS-2026-0708-0159',
            ],
        ];
    }
}
