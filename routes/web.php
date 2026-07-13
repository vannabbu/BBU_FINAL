<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentBookingController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ClinicModuleController;
use App\Http\Controllers\ClinicFormController;
use App\Http\Controllers\DoctorConsultationController;
use App\Http\Controllers\MedicineStockController;
use App\Http\Controllers\PatientMeasurementController;
use App\Http\Controllers\PatientUpdateController;
use App\Http\Controllers\RoomManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'legacyDashboard'])->name('dashboard');
Route::get('/profile', [DashboardController::class, 'doctorProfile'])->name('profile');
Route::get('/doctor-profile', [DashboardController::class, 'doctorProfile'])->name('doctor.profile');
Route::get('/doctors/consultation', DoctorConsultationController::class)->name('doctors.consultation');
Route::get('/departments', [ClinicModuleController::class, 'departments'])->name('departments.index');
Route::get('/specialties', [ClinicModuleController::class, 'specialties'])->name('specialties.index');
Route::get('/doctors', [ClinicModuleController::class, 'doctors'])->name('doctors.index');
Route::get('/patients/update', PatientUpdateController::class)->name('patients.update');
Route::get('/patients', [ClinicModuleController::class, 'patients'])->name('patients.index');
Route::get('/health-analysis', [ClinicModuleController::class, 'healthAnalysis'])->name('health-analysis.index');
Route::get('/appointments', AppointmentBookingController::class)->name('appointments.index');
Route::get('/blood-bank', [ClinicModuleController::class, 'bloodBank'])->name('blood-bank.index');
Route::get('/bed-allotments', [ClinicModuleController::class, 'bedAllotments'])->name('bed-allotments.index');
Route::get('/rooms', [RoomManagementController::class, 'index'])->name('rooms.index');
Route::get('/rooms/create', [RoomManagementController::class, 'create'])->name('rooms.create');
Route::get('/rooms/{room}/edit', [RoomManagementController::class, 'edit'])->name('rooms.edit');
Route::get('/medicines', MedicineStockController::class)->name('medicines.index');
Route::get('/diagnosis-reports', [ClinicModuleController::class, 'diagnosisReports'])->name('diagnosis-reports.index');
Route::get('/diagnosis-reports/measurements/create', [PatientMeasurementController::class, 'create'])->name('diagnosis-reports.measurements.create');
Route::get('/invoices', BillingController::class)->name('invoices.index');
Route::get('/settings', [ClinicModuleController::class, 'settings'])->name('settings.index');

Route::get('/{module}/create', [ClinicFormController::class, 'create'])
    ->where('module', 'departments|doctors|patients|appointments|blood-bank|bed-allotments|medicines|diagnosis-reports|invoices')
    ->name('modules.create');

Route::post('/{module}', [ClinicFormController::class, 'store'])
    ->where('module', 'departments|doctors|patients|appointments|blood-bank|bed-allotments|medicines|diagnosis-reports|invoices')
    ->name('modules.store');
