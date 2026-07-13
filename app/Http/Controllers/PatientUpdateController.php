<?php

namespace App\Http\Controllers;

class PatientUpdateController extends Controller
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
            ['label' => 'វេជ្ជបណ្ឌិត', 'href' => route('doctors.consultation'), 'icon' => 'stethoscope', 'active' => false],
            ['label' => 'អ្នកជំងឺ', 'href' => route('patients.update'), 'icon' => 'users', 'active' => true],
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
        $navigation = $this->clinicNavigation('patients');

        $patient = [
            'id' => 'PT-2026-0148',
            'full_name' => 'សុខ ចាន់ណា',
            'gender' => 'female',
            'date_of_birth' => '1994-03-12',
            'age' => 32,
            'phone' => '010 123 456',
            'address' => 'ផ្ទះលេខ 21, ផ្លូវ 271, សង្កាត់ទឹកថ្លា, ភ្នំពេញ',
            'emergency_contact' => 'លោក សុខ ដារ៉ា - 010 222 333',
            'blood_type' => 'A+',
            'insurance_provider' => 'National Social Security Fund',
            'allergy' => 'Penicillin allergy',
            'notes' => 'អ្នកជំងឺមានប្រវត្តិឈឺក្បាលស្រាល និងសម្ពាធឈាមឡើងខ្លះៗ។ ត្រូវតាមដាន BP និងការផឹកទឹកជាប្រចាំ។',
            'old_record' => true,
        ];

        $queue = [
            ['number' => 'Q-021', 'name' => 'ម៉ៅ សុភ័ក្ត្រ', 'reason' => 'ពិនិត្យទូទៅ', 'status' => 'កំពុងរង់ចាំ', 'status_key' => 'waiting', 'tone' => 'amber', 'wait' => '8 នាទី'],
            ['number' => 'Q-022', 'name' => 'សុខ ចាន់ណា', 'reason' => 'ធ្វើបច្ចុប្បន្នភាពកំណត់ត្រា', 'status' => 'កំពុងពិនិត្យ', 'status_key' => 'active', 'tone' => 'green', 'wait' => 'ឥឡូវនេះ'],
            ['number' => 'Q-023', 'name' => 'លី វិសាល', 'reason' => 'តាមដានលទ្ធផលឈាម', 'status' => 'បន្ទាប់', 'status_key' => 'next', 'tone' => 'blue', 'wait' => '15 នាទី'],
            ['number' => 'Q-024', 'name' => 'ចាន់ ស្រីនាង', 'reason' => 'ចាក់វ៉ាក់សាំង', 'status' => 'រង់ចាំ', 'status_key' => 'waiting', 'tone' => 'amber', 'wait' => '22 នាទី'],
            ['number' => 'Q-025', 'name' => 'ហេង ដារ៉ា', 'reason' => 'ពិគ្រោះជំងឺផ្លូវដង្ហើម', 'status' => 'រង់ចាំ', 'status_key' => 'waiting', 'tone' => 'amber', 'wait' => '31 នាទី'],
        ];

        return view('patient.update', [
            'doctor' => $doctor,
            'navigation' => $navigation,
            'patient' => $patient,
            'queue' => $queue,
            'genderOptions' => [
                'male' => 'ប្រុស',
                'female' => 'ស្រី',
                'other' => 'ផ្សេងៗ',
            ],
            'bloodTypes' => [
                'A+' => 'A+',
                'A-' => 'A-',
                'B+' => 'B+',
                'B-' => 'B-',
                'AB+' => 'AB+',
                'AB-' => 'AB-',
                'O+' => 'O+',
                'O-' => 'O-',
            ],
        ]);
    }
}
