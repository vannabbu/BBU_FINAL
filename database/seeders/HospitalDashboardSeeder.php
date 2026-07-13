<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HospitalDashboardSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $departments = [
            ['name' => 'វេជ្ជសាស្ត្រទូទៅ', 'description' => 'ពិនិត្យ និងព្យាបាលជំងឺទូទៅ'],
            ['name' => 'ជំងឺបេះដូង', 'description' => 'ពិនិត្យសុខភាពបេះដូង និងសរសៃឈាម'],
            ['name' => 'កុមារ', 'description' => 'ពិនិត្យ និងថែទាំសុខភាពកុមារ'],
            ['name' => 'មន្ទីរពិសោធន៍', 'description' => 'វិភាគឈាម និងលទ្ធផលវេជ្ជសាស្ត្រ'],
        ];

        foreach ($departments as $department) {
            DB::table('department')->updateOrInsert(
                ['name' => $department['name']],
                ['description' => $department['description'], 'created_at' => $now, 'updated_at' => $now]
            );
        }

        $generalDepartmentId = DB::table('department')->where('name', 'វេជ្ជសាស្ត្រទូទៅ')->value('id');
        $cardiologyDepartmentId = DB::table('department')->where('name', 'ជំងឺបេះដូង')->value('id');

        $doctors = [
            ['name' => 'វេជ្ជបណ្ឌិត សុខ សុភា', 'email' => 'sophea.doctor@prumsantepheap.clinic', 'phone' => '012 345 678', 'designation' => 'វេជ្ជបណ្ឌិតទូទៅ', 'department_id' => $generalDepartmentId],
            ['name' => 'វេជ្ជបណ្ឌិត ចាន់ ដារា', 'email' => 'dara.doctor@prumsantepheap.clinic', 'phone' => '011 222 333', 'designation' => 'ឯកទេសបេះដូង', 'department_id' => $cardiologyDepartmentId],
        ];

        foreach ($doctors as $doctor) {
            DB::table('doctor')->updateOrInsert(
                ['email' => $doctor['email']],
                [
                    'department_id' => $doctor['department_id'],
                    'name' => $doctor['name'],
                    'password' => Hash::make('password'),
                    'phone' => $doctor['phone'],
                    'designation' => $doctor['designation'],
                    'profile' => 'វេជ្ជបណ្ឌិតមានបទពិសោធន៍ក្នុងការថែទាំអ្នកជំងឺ។',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $patients = [
            ['name' => 'សុខ ចាន់ណា', 'email' => 'channa@example.com', 'phone' => '010 123 456', 'sex' => 'ស្រី', 'age' => 32, 'blood_group' => 'A+'],
            ['name' => 'ហេង វិសាល', 'email' => 'visal@example.com', 'phone' => '012 222 111', 'sex' => 'ប្រុស', 'age' => 41, 'blood_group' => 'O+'],
            ['name' => 'លី សុវណ្ណ', 'email' => 'sovann@example.com', 'phone' => '015 333 444', 'sex' => 'ប្រុស', 'age' => 27, 'blood_group' => 'B+'],
        ];

        foreach ($patients as $patient) {
            DB::table('patient')->updateOrInsert(
                ['email' => $patient['email']],
                [
                    'name' => $patient['name'],
                    'phone' => $patient['phone'],
                    'sex' => $patient['sex'],
                    'age' => $patient['age'],
                    'blood_group' => $patient['blood_group'],
                    'address' => 'ភ្នំពេញ',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $doctorId = DB::table('doctor')->where('email', 'sophea.doctor@prumsantepheap.clinic')->value('id');
        $patientIds = DB::table('patient')->orderBy('id')->pluck('id');

        foreach ($patientIds as $index => $patientId) {
            $appointmentTime = now()->startOfDay()->addHours(9 + $index)->format('Y-m-d H:i:s');

            DB::table('appointment')->updateOrInsert(
                ['doctor_id' => $doctorId, 'patient_id' => $patientId, 'appointment_date' => $appointmentTime],
                ['status' => $index === 0 ? 'pending' : 'approved', 'remarks' => 'ការណាត់ជួបសម្រាប់ពិនិត្យសុខភាព', 'created_at' => $now, 'updated_at' => $now]
            );
        }

        DB::table('bed')->updateOrInsert(
            ['bed_number' => 'VIP-01'],
            ['department_id' => $generalDepartmentId, 'type' => 'VIP', 'status' => 'available', 'description' => 'បន្ទប់ VIP សម្រាប់អ្នកជំងឺស្នាក់នៅ', 'created_at' => $now, 'updated_at' => $now]
        );

        foreach (['A+' => 12, 'B+' => 8, 'O+' => 18, 'AB+' => 5] as $group => $stock) {
            DB::table('blood_bank')->updateOrInsert(['blood_group' => $group], ['status' => $stock]);
        }

        DB::table('medicine_category')->updateOrInsert(
            ['name' => 'ថ្នាំទូទៅ'],
            ['description' => 'ថ្នាំប្រើប្រាស់ជាទូទៅ', 'created_at' => $now]
        );

        $categoryId = DB::table('medicine_category')->where('name', 'ថ្នាំទូទៅ')->value('id');

        DB::table('medicine')->updateOrInsert(
            ['name' => 'Paracetamol 500mg'],
            ['category_id' => $categoryId, 'price' => 500, 'total_quantity' => 320, 'expiry_date' => now()->addYear()->toDateString(), 'company' => 'Clinic Pharmacy', 'created_at' => $now, 'updated_at' => $now]
        );

        foreach ($patientIds as $index => $patientId) {
            DB::table('diagnosis_report')->updateOrInsert(
                ['patient_id' => $patientId, 'report_type' => $index === 0 ? 'Blood Test' : 'General Checkup'],
                ['laboratorist_id' => null, 'document_url' => null, 'description' => 'លទ្ធផលស្ថិតក្នុងកម្រិតធម្មតា', 'date' => now()->subHours($index)->format('Y-m-d H:i:s')]
            );

            DB::table('invoice')->updateOrInsert(
                ['patient_id' => $patientId, 'date' => now()->subDays($index)->toDateString()],
                ['total_amount' => 120000 + ($index * 35000), 'discount' => 5000, 'vat' => 0, 'grand_total' => 115000 + ($index * 35000), 'status' => $index === 0 ? 'unpaid' : 'paid', 'created_at' => $now]
            );
        }

        DB::table('settings')->updateOrInsert(
            ['system_name' => 'PRUM SANTEPHEAP CLINIC'],
            ['system_email' => 'info@prumsantepheap.clinic', 'address' => 'ភ្នំពេញ', 'phone' => '012 345 678', 'currency' => 'KHR', 'updated_at' => $now]
        );
    }
}
