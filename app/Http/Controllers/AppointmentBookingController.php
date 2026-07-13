<?php

namespace App\Http\Controllers;

class AppointmentBookingController extends Controller
{
    public function __invoke()
    {
        return view('appointments.booking', [
            'doctor' => $this->clinicDoctor(),
            'navigation' => $this->clinicNavigation('appointments'),
            'patients' => $this->patients(),
            'selectedDoctor' => [
                'id' => 'DR-0042',
                'name' => 'វេជ្ជបណ្ឌិត សុខ សុភា',
                'avatar' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=180&q=80',
                'department' => 'General Medicine',
                'specialty' => 'Internal Medicine',
                'rating' => '4.9',
                'experience_years' => 12,
                'availability' => 'Available today until 05:30 PM',
                'fee' => 45000,
                'status' => 'available',
                'status_label' => 'Available',
            ],
            'departments' => [
                'General Medicine',
                'Cardiology',
                'Pediatrics',
                'Emergency',
                'Laboratory',
                'Neurology',
            ],
            'consultationTypes' => [
                'General Consultation',
                'Follow-up',
                'Emergency',
                'Online Consultation',
                'Specialist Consultation',
            ],
            'priorities' => ['Normal', 'Urgent', 'Emergency'],
            'durations' => ['15 Minutes', '30 Minutes', '45 Minutes', '60 Minutes'],
            'timeSlots' => [
                ['time' => '08:00 AM', 'status' => 'available', 'label' => 'Available'],
                ['time' => '09:30 AM', 'status' => 'booked', 'label' => 'Booked'],
                ['time' => '11:00 AM', 'status' => 'available', 'label' => 'Available'],
                ['time' => '01:30 PM', 'status' => 'available', 'label' => 'Available'],
                ['time' => '03:30 PM', 'status' => 'booked', 'label' => 'Booked'],
                ['time' => '05:00 PM', 'status' => 'available', 'label' => 'Available'],
            ],
            'availabilityCalendar' => [
                ['date' => '2026-07-08', 'label' => 'Today', 'available' => 4],
                ['date' => '2026-07-09', 'label' => 'Tomorrow', 'available' => 6],
                ['date' => '2026-07-10', 'label' => 'Fri', 'available' => 2],
                ['date' => '2026-07-11', 'label' => 'Sat', 'available' => 0],
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
            ['label' => 'ការណាត់ជួប', 'href' => route('appointments.index'), 'icon' => 'calendar-days', 'active' => true],
            ['label' => 'វិភាគសុខភាព', 'href' => route('health-analysis.index'), 'icon' => 'file-heart', 'active' => false],
            ['label' => 'មន្ទីរពិសោធន៍', 'href' => route('diagnosis-reports.index'), 'icon' => 'flask-conical', 'active' => false],
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
                'phone' => '010 123 456',
                'date_of_birth' => '1994-03-12',
                'gender' => 'Female',
            ],
            [
                'id' => 'PT-2026-0151',
                'full_name' => 'ហេង វិសាល',
                'phone' => '012 222 111',
                'date_of_birth' => '1985-09-21',
                'gender' => 'Male',
            ],
            [
                'id' => 'PT-2026-0154',
                'full_name' => 'លី សុវណ្ណ',
                'phone' => '015 333 444',
                'date_of_birth' => '1998-01-08',
                'gender' => 'Male',
            ],
            [
                'id' => 'PT-2026-0159',
                'full_name' => 'ចាន់ ស្រីនាង',
                'phone' => '017 456 789',
                'date_of_birth' => '1991-11-18',
                'gender' => 'Female',
            ],
        ];
    }
}
