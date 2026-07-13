<?php

namespace App\Http\Controllers;

class DoctorConsultationController extends Controller
{
    public function __invoke()
    {
        $doctor = [
            'name' => 'វេជ្ជបណ្ឌិត សុខ សុភា',
            'department' => 'ផ្នែកពិគ្រោះជំងឺទូទៅ',
            'avatar' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=160&q=80',
            'href' => route('profile'),
        ];

        $navigation = [
            ['label' => 'ផ្ទាំងគ្រប់គ្រង', 'href' => route('dashboard'), 'icon' => 'layout-dashboard', 'active' => false],
            ['label' => 'វេជ្ជបណ្ឌិត', 'href' => route('doctors.consultation'), 'icon' => 'stethoscope', 'active' => true],
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

        $doctor = $this->clinicDoctor();
        $navigation = $this->clinicNavigation('doctors');

        $patient = [
            'name' => 'សុខ ចាន់ណា',
            'id' => 'PT-2026-0148',
            'age' => 32,
            'gender' => 'ស្រី',
            'avatar' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=180&q=80',
            'blood_group' => 'A+',
            'last_visit' => '08 កក្កដា 2026',
        ];

        $vitals = [
            ['label' => 'សម្ពាធឈាម', 'value' => '120/80', 'unit' => 'mmHg', 'status' => 'ធម្មតា', 'icon' => 'activity', 'tone' => 'green'],
            ['label' => 'ចង្វាក់បេះដូង', 'value' => '78', 'unit' => 'bpm', 'status' => 'ស្ថិរភាព', 'icon' => 'heart-pulse', 'tone' => 'blue'],
            ['label' => 'សីតុណ្ហភាព', 'value' => '37.2', 'unit' => '°C', 'status' => 'តាមដាន', 'icon' => 'thermometer', 'tone' => 'amber'],
            ['label' => 'អុកស៊ីសែន', 'value' => '98', 'unit' => '%', 'status' => 'ល្អ', 'icon' => 'wind', 'tone' => 'green'],
        ];

        $notes = [
            'doctor' => 'Patient reports intermittent headache and mild fatigue. No chest pain. Hydration and rest advised while monitoring blood pressure.',
            'symptoms' => 'រោគសញ្ញាមុនៗ៖ ឈឺក្បាលស្រាល អស់កម្លាំង និងគេងមិនសូវលក់។ មិនមានក្អក ឬដង្ហើមខ្លី។',
        ];

        $diagnoses = [
            ['label' => 'Hypertension stage 1', 'color' => 'green'],
            ['label' => 'Mild dehydration', 'color' => 'blue'],
            ['label' => 'Tension headache', 'color' => 'amber'],
        ];

        $suggestions = [
            'Acute bronchitis',
            'Type 2 diabetes',
            'Migraine',
            'Anemia',
            'Seasonal allergy',
            'Gastritis',
        ];

        return view('doctor.consultation', [
            'doctor' => $doctor,
            'navigation' => $navigation,
            'patient' => $patient,
            'vitals' => $vitals,
            'notes' => $notes,
            'diagnoses' => $diagnoses,
            'suggestions' => $suggestions,
        ]);
    }
}
