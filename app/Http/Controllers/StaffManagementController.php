<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class StaffManagementController extends Controller
{
    public function index()
    {
        $employees = $this->employees();

        return view('staff.index', [
            'doctor' => $this->doctor(),
            'navigation' => $this->navigation(),
            'stats' => Cache::remember('staff.management.statistics.v1', now()->addMinutes(5), fn () => $this->statistics($employees)),
            'employees' => $employees,
            'departments' => $this->departments(),
            'roles' => $this->roles(),
            'statuses' => $this->statuses(),
        ]);
    }

    public function create()
    {
        return view('staff.form', [
            'doctor' => $this->doctor(),
            'navigation' => $this->navigation(),
            'mode' => 'create',
            'employee' => $this->blankEmployee(),
            'departments' => $this->departments(),
            'roles' => $this->roles(),
            'statuses' => $this->statuses(),
            'employmentTypes' => $this->employmentTypes(),
            'shifts' => $this->shifts(),
            'permissions' => $this->permissions(),
        ]);
    }

    public function edit(string $employee)
    {
        $selectedEmployee = $this->employees()->firstWhere('id', $employee) ?? $this->employees()->first();

        return view('staff.form', [
            'doctor' => $this->doctor(),
            'navigation' => $this->navigation(),
            'mode' => 'edit',
            'employee' => $selectedEmployee,
            'departments' => $this->departments(),
            'roles' => $this->roles(),
            'statuses' => $this->statuses(),
            'employmentTypes' => $this->employmentTypes(),
            'shifts' => $this->shifts(),
            'permissions' => $this->permissions(),
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
            ['label' => 'វិក្កយបត្រ', 'href' => route('invoices.index'), 'icon' => 'receipt-text', 'active' => false],
            ['label' => 'បុគ្គលិក', 'href' => url('/staff'), 'icon' => 'id-card', 'active' => true],
            ['label' => 'ការកំណត់', 'href' => route('settings.index'), 'icon' => 'settings', 'active' => false],
        ];
    }

    private function employees(): Collection
    {
        return collect([
            [
                'id' => 'EMP-1001',
                'avatar' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=120&q=80',
                'first_name' => 'សុខ',
                'last_name' => 'សុភា',
                'full_name' => 'សុខ សុភា',
                'gender' => 'Female',
                'date_of_birth' => '1988-03-12',
                'national_id' => 'KH-01020344',
                'department' => 'General Medicine',
                'position' => 'Senior Doctor',
                'role' => 'Doctor',
                'phone' => '012 345 678',
                'email' => 'sophea.doctor@prumsantepheap.clinic',
                'address' => 'ផ្ទះលេខ 12, ផ្លូវ 271, ខណ្ឌមានជ័យ, ភ្នំពេញ',
                'emergency_contact' => 'លោក សុខ ដារ៉ា - 010 222 333',
                'status' => 'active',
                'status_label' => 'Active',
                'join_date' => '2021-01-15',
                'employment_type' => 'Full-time',
                'salary' => 2800000,
                'shift' => 'Morning',
                'supervisor' => 'Administrator',
                'username' => 'sophea.doctor',
                'last_login' => 'Today 09:12',
                'account_status' => 'Enabled',
                'permissions' => ['View Patients', 'Edit Patients', 'Create Appointments', 'Manage Laboratory'],
            ],
            [
                'id' => 'EMP-1002',
                'avatar' => 'https://images.unsplash.com/photo-1582750433449-648ed127bb54?auto=format&fit=crop&w=120&q=80',
                'first_name' => 'ចាន់',
                'last_name' => 'ដារា',
                'full_name' => 'ចាន់ ដារា',
                'gender' => 'Male',
                'date_of_birth' => '1985-11-02',
                'national_id' => 'KH-77551320',
                'department' => 'Cardiology',
                'position' => 'Cardiologist',
                'role' => 'Doctor',
                'phone' => '011 222 333',
                'email' => 'dara.cardiology@prumsantepheap.clinic',
                'address' => 'ទួលគោក, ភ្នំពេញ',
                'emergency_contact' => 'អ្នកស្រី ចាន់ មុនី - 011 999 888',
                'status' => 'on_leave',
                'status_label' => 'On Leave',
                'join_date' => '2020-08-10',
                'employment_type' => 'Full-time',
                'salary' => 3200000,
                'shift' => 'Evening',
                'supervisor' => 'Medical Director',
                'username' => 'dara.cardio',
                'last_login' => 'Yesterday 17:40',
                'account_status' => 'Enabled',
                'permissions' => ['View Patients', 'Edit Patients', 'Create Appointments'],
            ],
            [
                'id' => 'EMP-1003',
                'avatar' => 'https://images.unsplash.com/photo-1594824476967-48c8b964273f?auto=format&fit=crop&w=120&q=80',
                'first_name' => 'លី',
                'last_name' => 'ស្រីនាង',
                'full_name' => 'លី ស្រីនាង',
                'gender' => 'Female',
                'date_of_birth' => '1994-06-22',
                'national_id' => 'KH-55002198',
                'department' => 'Emergency',
                'position' => 'Charge Nurse',
                'role' => 'Nurse',
                'phone' => '015 333 444',
                'email' => 'sreynang.nurse@prumsantepheap.clinic',
                'address' => 'ច្បារអំពៅ, ភ្នំពេញ',
                'emergency_contact' => 'លោក លី វិសាល - 015 777 888',
                'status' => 'active',
                'status_label' => 'Active',
                'join_date' => '2022-04-01',
                'employment_type' => 'Full-time',
                'salary' => 1400000,
                'shift' => 'Night',
                'supervisor' => 'Head Nurse',
                'username' => 'sreynang.nurse',
                'last_login' => 'Today 07:18',
                'account_status' => 'Enabled',
                'permissions' => ['View Patients', 'Create Appointments', 'Manage Rooms'],
            ],
            [
                'id' => 'EMP-1004',
                'avatar' => 'https://images.unsplash.com/photo-1607990281513-2c110a25bd8c?auto=format&fit=crop&w=120&q=80',
                'first_name' => 'ហេង',
                'last_name' => 'វិសាល',
                'full_name' => 'ហេង វិសាល',
                'gender' => 'Male',
                'date_of_birth' => '1991-09-19',
                'national_id' => 'KH-33445112',
                'department' => 'Pharmacy',
                'position' => 'Pharmacist',
                'role' => 'Pharmacist',
                'phone' => '012 555 991',
                'email' => 'visal.pharmacy@prumsantepheap.clinic',
                'address' => 'សែនសុខ, ភ្នំពេញ',
                'emergency_contact' => 'អ្នកស្រី ហេង សុភី - 012 555 992',
                'status' => 'active',
                'status_label' => 'Active',
                'join_date' => '2023-02-18',
                'employment_type' => 'Full-time',
                'salary' => 1600000,
                'shift' => 'Morning',
                'supervisor' => 'Operations Manager',
                'username' => 'visal.pharma',
                'last_login' => 'Today 08:01',
                'account_status' => 'Enabled',
                'permissions' => ['Manage Pharmacy', 'View Patients'],
            ],
            [
                'id' => 'EMP-1005',
                'avatar' => 'https://images.unsplash.com/photo-1607746882042-944635dfe10e?auto=format&fit=crop&w=120&q=80',
                'first_name' => 'ម៉ៅ',
                'last_name' => 'សុភ័ក្ត្រ',
                'full_name' => 'ម៉ៅ សុភ័ក្ត្រ',
                'gender' => 'Male',
                'date_of_birth' => '1996-12-05',
                'national_id' => 'KH-88990021',
                'department' => 'Laboratory',
                'position' => 'Laboratory Technician',
                'role' => 'Laboratory Technician',
                'phone' => '010 456 789',
                'email' => 'sopheak.lab@prumsantepheap.clinic',
                'address' => 'ដូនពេញ, ភ្នំពេញ',
                'emergency_contact' => 'លោក ម៉ៅ រដ្ឋា - 010 456 700',
                'status' => 'suspended',
                'status_label' => 'Suspended',
                'join_date' => '2023-09-11',
                'employment_type' => 'Part-time',
                'salary' => 950000,
                'shift' => 'Afternoon',
                'supervisor' => 'Lab Manager',
                'username' => 'sopheak.lab',
                'last_login' => '5 days ago',
                'account_status' => 'Disabled',
                'permissions' => ['Manage Laboratory'],
            ],
            [
                'id' => 'EMP-1006',
                'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=120&q=80',
                'first_name' => 'ពេជ្រ',
                'last_name' => 'មុនី',
                'full_name' => 'ពេជ្រ មុនី',
                'gender' => 'Female',
                'date_of_birth' => '1990-01-28',
                'national_id' => 'KH-22001155',
                'department' => 'Billing',
                'position' => 'Cashier',
                'role' => 'Cashier',
                'phone' => '017 234 555',
                'email' => 'mony.cashier@prumsantepheap.clinic',
                'address' => 'បឹងកេងកង, ភ្នំពេញ',
                'emergency_contact' => 'លោក ពេជ្រ សុវណ្ណ - 017 234 556',
                'status' => 'inactive',
                'status_label' => 'Inactive',
                'join_date' => '2021-10-30',
                'employment_type' => 'Contract',
                'salary' => 1200000,
                'shift' => 'Morning',
                'supervisor' => 'Finance Manager',
                'username' => 'mony.cashier',
                'last_login' => '2 weeks ago',
                'account_status' => 'Locked',
                'permissions' => ['Manage Billing'],
            ],
        ])->map(fn (array $employee) => $employee + [
            'edit_url' => url('/staff/'.$employee['id'].'/edit'),
        ]);
    }

    private function blankEmployee(): array
    {
        return [
            'id' => '',
            'avatar' => 'https://images.unsplash.com/photo-1582750433449-648ed127bb54?auto=format&fit=crop&w=120&q=80',
            'first_name' => '',
            'last_name' => '',
            'full_name' => '',
            'gender' => 'Female',
            'date_of_birth' => '',
            'national_id' => '',
            'department' => 'General Medicine',
            'position' => '',
            'role' => 'Nurse',
            'phone' => '',
            'email' => '',
            'address' => '',
            'emergency_contact' => '',
            'status' => 'active',
            'status_label' => 'Active',
            'join_date' => now()->toDateString(),
            'employment_type' => 'Full-time',
            'salary' => '',
            'shift' => 'Morning',
            'supervisor' => '',
            'username' => '',
            'password' => '',
            'password_confirmation' => '',
            'last_login' => 'Never',
            'account_status' => 'Enabled',
            'permissions' => ['View Patients'],
        ];
    }

    private function statistics(Collection $employees): array
    {
        return [
            ['title' => 'Total Employees', 'value' => $employees->count(), 'description' => 'All hospital staff records', 'trend' => '+12%', 'icon' => 'users-round', 'tone' => 'green'],
            ['title' => 'Doctors', 'value' => $employees->where('role', 'Doctor')->count(), 'description' => 'Active clinical providers', 'trend' => '+4%', 'icon' => 'stethoscope', 'tone' => 'blue'],
            ['title' => 'Nurses', 'value' => $employees->where('role', 'Nurse')->count(), 'description' => 'Ward and emergency nurses', 'trend' => '+8%', 'icon' => 'heart-pulse', 'tone' => 'amber'],
            ['title' => 'Active Users', 'value' => $employees->where('account_status', 'Enabled')->count(), 'description' => 'Enabled system accounts', 'trend' => '+15%', 'icon' => 'shield-check', 'tone' => 'info'],
        ];
    }

    private function departments(): array
    {
        return ['General Medicine', 'Cardiology', 'Emergency', 'Pharmacy', 'Laboratory', 'Billing', 'Administration', 'Reception'];
    }

    private function roles(): array
    {
        return ['Administrator', 'Doctor', 'Nurse', 'Receptionist', 'Pharmacist', 'Laboratory Technician', 'Cashier', 'HR Officer'];
    }

    private function statuses(): array
    {
        return [
            'active' => 'Active',
            'on_leave' => 'On Leave',
            'suspended' => 'Suspended',
            'inactive' => 'Inactive',
            'resigned' => 'Resigned',
        ];
    }

    private function employmentTypes(): array
    {
        return ['Full-time', 'Part-time', 'Contract', 'Internship', 'Visiting'];
    }

    private function shifts(): array
    {
        return ['Morning', 'Afternoon', 'Evening', 'Night', 'Rotating'];
    }

    private function permissions(): array
    {
        return [
            'View Patients',
            'Edit Patients',
            'Create Appointments',
            'Manage Billing',
            'Manage Pharmacy',
            'Manage Laboratory',
            'Manage Rooms',
            'Manage Employees',
            'System Settings',
        ];
    }
}
