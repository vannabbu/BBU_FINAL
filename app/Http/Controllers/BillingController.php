<?php

namespace App\Http\Controllers;

class BillingController extends Controller
{
    public function __invoke()
    {
        return view('billing.index', [
            'doctor' => $this->clinicDoctor(),
            'navigation' => $this->clinicNavigation('invoices'),
            'invoice' => [
                'number' => 'INV-2026-0087',
                'patient_name' => 'សុខ ចាន់ណា',
                'doctor_name' => 'វេជ្ជបណ្ឌិត សុខ សុភា',
                'room' => 'Ward A - Bed 12',
                'visit_date' => '08 កក្កដា 2026',
                'payment_status' => 'Partial Paid',
                'payment_status_kh' => 'បានទូទាត់ខ្លះ',
            ],
            'medicines' => [
                ['id' => 'med-001', 'name' => 'Paracetamol 500mg', 'unit_price' => 500, 'quantity' => 12],
                ['id' => 'med-002', 'name' => 'Amoxicillin 250mg', 'unit_price' => 1200, 'quantity' => 10],
                ['id' => 'med-003', 'name' => 'ORS Sachet', 'unit_price' => 700, 'quantity' => 6],
            ],
            'medicineCatalog' => [
                ['id' => 'med-001', 'name' => 'Paracetamol 500mg', 'unit_price' => 500],
                ['id' => 'med-002', 'name' => 'Amoxicillin 250mg', 'unit_price' => 1200],
                ['id' => 'med-003', 'name' => 'ORS Sachet', 'unit_price' => 700],
                ['id' => 'med-004', 'name' => 'Cetirizine 10mg', 'unit_price' => 800],
                ['id' => 'med-005', 'name' => 'Salbutamol Inhaler', 'unit_price' => 18500],
                ['id' => 'med-006', 'name' => 'Metformin 500mg', 'unit_price' => 950],
            ],
            'services' => [
                ['id' => 'laboratory', 'name' => 'Laboratory', 'name_kh' => 'មន្ទីរពិសោធន៍', 'price' => 35000, 'icon' => 'flask-conical', 'selected' => true],
                ['id' => 'ultrasound', 'name' => 'Ultrasound', 'name_kh' => 'អេកូសាស្ត្រ', 'price' => 70000, 'icon' => 'scan-line', 'selected' => false],
                ['id' => 'blood-test', 'name' => 'Blood Test', 'name_kh' => 'តេស្តឈាម', 'price' => 25000, 'icon' => 'droplets', 'selected' => true],
                ['id' => 'x-ray', 'name' => 'X-Ray', 'name_kh' => 'ថតកាំរស្មី X', 'price' => 50000, 'icon' => 'scan', 'selected' => false],
                ['id' => 'ecg', 'name' => 'ECG', 'name_kh' => 'ពិនិត្យចង្វាក់បេះដូង', 'price' => 40000, 'icon' => 'heart-pulse', 'selected' => false],
                ['id' => 'ct-scan', 'name' => 'CT Scan', 'name_kh' => 'ថត CT Scan', 'price' => 220000, 'icon' => 'brain', 'selected' => false],
            ],
            'recentInvoices' => [
                ['patient' => 'លី វិសាល', 'number' => 'INV-2026-0086', 'amount' => '185,000 ៛', 'status' => 'Paid', 'status_kh' => 'បានទូទាត់', 'tone' => 'green', 'date' => '08 កក្កដា 2026'],
                ['patient' => 'ម៉ៅ សុភ័ក្ត្រ', 'number' => 'INV-2026-0085', 'amount' => '92,500 ៛', 'status' => 'Pending', 'status_kh' => 'រង់ចាំ', 'tone' => 'amber', 'date' => '07 កក្កដា 2026'],
                ['patient' => 'ចាន់ ស្រីនាង', 'number' => 'INV-2026-0084', 'amount' => '340,000 ៛', 'status' => 'Paid', 'status_kh' => 'បានទូទាត់', 'tone' => 'green', 'date' => '07 កក្កដា 2026'],
                ['patient' => 'ហេង ដារ៉ា', 'number' => 'INV-2026-0083', 'amount' => '125,000 ៛', 'status' => 'Draft', 'status_kh' => 'ព្រាង', 'tone' => 'slate', 'date' => '06 កក្កដា 2026'],
            ],
            'taxRate' => 0.10,
            'discount' => 5000,
        ]);
    }

    private function doctor(): array
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
            ['label' => 'មន្ទីរពិសោធន៍', 'href' => route('diagnosis-reports.index'), 'icon' => 'flask-conical', 'active' => false],
            ['label' => 'បន្ទប់', 'href' => route('rooms.index'), 'icon' => 'bed-double', 'active' => false],
            ['label' => 'ឃ្លាំងឱសថ', 'href' => route('medicines.index'), 'icon' => 'pill', 'active' => false],
            ['label' => 'វិក្កយបត្រ', 'href' => route('invoices.index'), 'icon' => 'receipt-text', 'active' => true],
            ['label' => 'ការកំណត់', 'href' => route('settings.index'), 'icon' => 'settings', 'active' => false],
        ];
    }
}
