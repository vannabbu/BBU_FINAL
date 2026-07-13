<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\BedAllotment;
use App\Models\DiagnosisReport;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Medicine;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

class ClinicModuleController extends Controller
{
    public function departments()
    {
        return $this->specialties();
    }

    public function specialties()
    {
        return $this->page(
            'ពេទ្យឯកទេស',
            'គ្រប់គ្រងឯកទេស និងផ្នែកសេវាព្យាបាលរបស់គ្លីនិក។',
            ['ឯកទេស', 'ពិពណ៌នា', 'ថ្ងៃបង្កើត'],
            $this->rows('department', fn () => DB::table('department')
                ->latest('id')
                ->take(50)
                ->get()
                ->map(fn ($department) => [
                    'ឯកទេស' => $this->display($department->name),
                    'ពិពណ៌នា' => $this->display($department->description),
                    'ថ្ងៃបង្កើត' => $this->date($department->created_at ?? null),
                ])),
            'departments'
        );
    }

    public function doctors()
    {
        return $this->page(
            'វេជ្ជបណ្ឌិត',
            'បញ្ជីវេជ្ជបណ្ឌិតតាមផ្នែក និងព័ត៌មានទំនាក់ទំនង។',
            ['ឈ្មោះ', 'អ៊ីមែល', 'ទូរស័ព្ទ', 'ផ្នែក', 'តួនាទី'],
            $this->rows('doctor', fn () => Doctor::query()
                ->with('department')
                ->latest('id')
                ->take(50)
                ->get()
                ->map(fn (Doctor $doctor) => [
                    'ឈ្មោះ' => $this->display($doctor->name),
                    'អ៊ីមែល' => $this->display($doctor->email),
                    'ទូរស័ព្ទ' => $this->display($doctor->phone),
                    'ផ្នែក' => $this->display($doctor->department?->name),
                    'តួនាទី' => $this->display($doctor->designation),
                ]))
        );
    }

    public function patients()
    {
        return $this->page(
            'អ្នកជំងឺ',
            'កំណត់ត្រាអ្នកជំងឺ សុខភាព និងព័ត៌មានទំនាក់ទំនង។',
            ['ឈ្មោះ', 'ទូរស័ព្ទ', 'ភេទ', 'អាយុ', 'ក្រុមឈាម'],
            $this->rows('patient', fn () => DB::table('patient')
                ->latest('id')
                ->take(50)
                ->get()
                ->map(fn ($patient) => [
                    'ឈ្មោះ' => $this->display($patient->name),
                    'ទូរស័ព្ទ' => $this->display($patient->phone),
                    'ភេទ' => $this->display($patient->sex),
                    'អាយុ' => $this->display($patient->age),
                    'ក្រុមឈាម' => $this->display($patient->blood_group),
                ]))
        );
    }

    public function healthAnalysis()
    {
        return $this->page(
            'វិភាគសុខភាព',
            'បង្ហាញទិន្នន័យវិភាគសុខភាព និងរបាយការណ៍ពាក់ព័ន្ធរបស់អ្នកជំងឺ។',
            ['អ្នកជំងឺ', 'ប្រភេទវិភាគ', 'ពិពណ៌នា', 'ថ្ងៃបង្កើត'],
            $this->rows('diagnosis_report', fn () => DB::table('diagnosis_report')
                ->leftJoin('patient', 'diagnosis_report.patient_id', '=', 'patient.id')
                ->select('patient.name as patient_name', 'diagnosis_report.report_type', 'diagnosis_report.description', 'diagnosis_report.date')
                ->orderByDesc('diagnosis_report.date')
                ->take(50)
                ->get()
                ->map(fn ($report) => [
                    'អ្នកជំងឺ' => $this->display($report->patient_name),
                    'ប្រភេទវិភាគ' => $this->display($report->report_type),
                    'ពិពណ៌នា' => $this->display($report->description),
                    'ថ្ងៃបង្កើត' => $this->date($report->date, 'd/m/Y H:i'),
                ])),
            false
        );
    }

    public function appointments()
    {
        return $this->page(
            'ការណាត់ជួប',
            'តាមដានការណាត់ជួបរវាងអ្នកជំងឺ និងវេជ្ជបណ្ឌិត។',
            ['អ្នកជំងឺ', 'វេជ្ជបណ្ឌិត', 'ថ្ងៃម៉ោង', 'ស្ថានភាព', 'កំណត់ចំណាំ'],
            $this->rows('appointment', fn () => Appointment::query()
                ->with(['patient', 'doctor'])
                ->latest('appointment_date')
                ->take(50)
                ->get()
                ->map(fn (Appointment $appointment) => [
                    'អ្នកជំងឺ' => $this->display($appointment->patient?->name),
                    'វេជ្ជបណ្ឌិត' => $this->display($appointment->doctor?->name),
                    'ថ្ងៃម៉ោង' => $this->date($appointment->appointment_date, 'd/m/Y H:i'),
                    'ស្ថានភាព' => $this->status($appointment->status),
                    'កំណត់ចំណាំ' => $this->display($appointment->remarks),
                ]))
        );
    }

    public function bloodBank()
    {
        return $this->page(
            'ធនាគារឈាម',
            'បរិមាណឈាមតាមក្រុមឈាមសម្រាប់ការព្យាបាល។',
            ['ក្រុមឈាម', 'ចំនួនក្នុងស្តុក'],
            $this->rows('blood_bank', fn () => DB::table('blood_bank')
                ->orderBy('blood_group')
                ->get()
                ->map(fn ($blood) => [
                    'ក្រុមឈាម' => $this->display($blood->blood_group),
                    'ចំនួនក្នុងស្តុក' => number_format((int) $blood->status),
                ]))
        );
    }

    public function bedAllotments()
    {
        return $this->page(
            'បែងចែកគ្រែ',
            'គ្រប់គ្រងការស្នាក់នៅ និងការចេញពីគ្រែរបស់អ្នកជំងឺ។',
            ['លេខគ្រែ', 'អ្នកជំងឺ', 'ចូលស្នាក់នៅ', 'ចេញពីគ្រែ'],
            $this->rows('bed_allotment', fn () => BedAllotment::query()
                ->with(['bed', 'patient'])
                ->latest('allotment_time')
                ->take(50)
                ->get()
                ->map(fn (BedAllotment $allotment) => [
                    'លេខគ្រែ' => $this->display($allotment->bed?->bed_number),
                    'អ្នកជំងឺ' => $this->display($allotment->patient?->name),
                    'ចូលស្នាក់នៅ' => $this->date($allotment->allotment_time, 'd/m/Y H:i'),
                    'ចេញពីគ្រែ' => $this->date($allotment->discharge_time, 'd/m/Y H:i'),
                ]))
        );
    }

    public function rooms()
    {
        return $this->page(
            'បន្ទប់',
            'បង្ហាញបន្ទប់ និងគ្រែសម្រាប់ការស្នាក់នៅរបស់អ្នកជំងឺ។',
            ['លេខគ្រែ', 'ប្រភេទ', 'ផ្នែក', 'ស្ថានភាព'],
            $this->rows('bed', fn () => DB::table('bed')
                ->leftJoin('department', 'bed.department_id', '=', 'department.id')
                ->select('bed.bed_number', 'bed.type', 'bed.status', 'department.name as department_name')
                ->orderBy('bed.bed_number')
                ->take(50)
                ->get()
                ->map(fn ($bed) => [
                    'លេខគ្រែ' => $this->display($bed->bed_number),
                    'ប្រភេទ' => $this->display($bed->type),
                    'ផ្នែក' => $this->display($bed->department_name),
                    'ស្ថានភាព' => $this->status($bed->status),
                ])),
            false
        );
    }

    public function medicines()
    {
        return $this->page(
            'ឃ្លាំងឱសថ',
            'តាមដានប្រភេទឱសថ តម្លៃ ចំនួន និងថ្ងៃផុតកំណត់។',
            ['ឈ្មោះឱសថ', 'ប្រភេទ', 'តម្លៃ', 'ចំនួន', 'ថ្ងៃផុតកំណត់'],
            $this->rows('medicine', fn () => Medicine::query()
                ->with('category')
                ->latest('id')
                ->take(50)
                ->get()
                ->map(fn (Medicine $medicine) => [
                    'ឈ្មោះឱសថ' => $this->display($medicine->name),
                    'ប្រភេទ' => $this->display($medicine->category?->name),
                    'តម្លៃ' => number_format((float) $medicine->price, 2).' ៛',
                    'ចំនួន' => number_format((int) $medicine->total_quantity),
                    'ថ្ងៃផុតកំណត់' => $this->date($medicine->expiry_date),
                ]))
        );
    }

    public function diagnosisReports()
    {
        return $this->page(
            'មន្ទីរពិសោធន៍',
            'លទ្ធផលពិនិត្យ និងរបាយការណ៍វេជ្ជសាស្ត្រ។',
            ['អ្នកជំងឺ', 'ប្រភេទរបាយការណ៍', 'បុគ្គលិកពិសោធន៍', 'ថ្ងៃបង្កើត'],
            $this->rows('diagnosis_report', fn () => DiagnosisReport::query()
                ->with(['patient', 'laboratorist'])
                ->latest('date')
                ->take(50)
                ->get()
                ->map(fn (DiagnosisReport $report) => [
                    'អ្នកជំងឺ' => $this->display($report->patient?->name),
                    'ប្រភេទរបាយការណ៍' => $this->display($report->report_type),
                    'បុគ្គលិកពិសោធន៍' => $this->display($report->laboratorist?->name),
                    'ថ្ងៃបង្កើត' => $this->date($report->date, 'd/m/Y H:i'),
                ])),
            null,
            [
                ['label' => 'បន្ថែមការវាស់វែង', 'href' => route('diagnosis-reports.measurements.create')],
            ]
        );
    }

    public function invoices()
    {
        return $this->page(
            'វិក្កយបត្រ',
            'គ្រប់គ្រងវិក្កយបត្រ ការបញ្ចុះតម្លៃ និងស្ថានភាពទូទាត់។',
            ['លេខវិក្កយបត្រ', 'អ្នកជំងឺ', 'សរុបចុងក្រោយ', 'ស្ថានភាព', 'កាលបរិច្ឆេទ'],
            $this->rows('invoice', fn () => Invoice::query()
                ->with('patient')
                ->latest('date')
                ->take(50)
                ->get()
                ->map(fn (Invoice $invoice) => [
                    'លេខវិក្កយបត្រ' => '#'.$invoice->id,
                    'អ្នកជំងឺ' => $this->display($invoice->patient?->name),
                    'សរុបចុងក្រោយ' => number_format((float) $invoice->grand_total, 2).' ៛',
                    'ស្ថានភាព' => $this->status($invoice->status),
                    'កាលបរិច្ឆេទ' => $this->date($invoice->date),
                ]))
        );
    }

    public function settings()
    {
        return $this->page(
            'ការកំណត់',
            'បង្ហាញព័ត៌មានកំណត់ប្រព័ន្ធសម្រាប់គ្លីនិក។',
            ['ឈ្មោះប្រព័ន្ធ', 'អ៊ីមែល', 'ទូរស័ព្ទ', 'រូបិយប័ណ្ណ'],
            $this->rows('settings', fn () => DB::table('settings')
                ->latest('id')
                ->take(50)
                ->get()
                ->map(fn ($setting) => [
                    'ឈ្មោះប្រព័ន្ធ' => $this->display($setting->system_name),
                    'អ៊ីមែល' => $this->display($setting->system_email),
                    'ទូរស័ព្ទ' => $this->display($setting->phone),
                    'រូបិយប័ណ្ណ' => $this->display($setting->currency),
                ])),
            false
        );
    }

    private function page(string $title, string $description, array $columns, Collection $rows, mixed $createModule = null, array $actions = [])
    {
        return view('modules.index', [
            'title' => $title,
            'description' => $description,
            'columns' => $columns,
            'rows' => $rows,
            'createModule' => $createModule === null ? request()->segment(1) : $createModule,
            'actions' => $actions,
            'doctor' => $this->clinicDoctor(),
            'navigation' => $this->clinicNavigation($this->activeNavigationKey()),
        ]);
    }

    private function activeNavigationKey(): ?string
    {
        return match (request()->segment(1)) {
            'departments' => 'specialties',
            'bed-allotments' => 'rooms',
            default => request()->segment(1),
        };
    }

    private function rows(string $table, callable $callback): Collection
    {
        if (! Schema::hasTable($table)) {
            return collect();
        }

        try {
            return $callback();
        } catch (Throwable) {
            return collect();
        }
    }

    private function display(mixed $value): string
    {
        if ($value === null || $value === '') {
            return 'មិនមាន';
        }

        return (string) $value;
    }

    private function date(mixed $value, string $format = 'd/m/Y'): string
    {
        if ($value === null || $value === '') {
            return 'មិនមាន';
        }

        try {
            return Carbon::parse($value)->format($format);
        } catch (Throwable) {
            return 'មិនមាន';
        }
    }

    private function status(?string $status): string
    {
        return [
            'pending' => 'រង់ចាំ',
            'approved' => 'បានអនុម័ត',
            'cancelled' => 'បានបោះបង់',
            'paid' => 'បានទូទាត់',
            'unpaid' => 'មិនទាន់ទូទាត់',
            'partial' => 'ទូទាត់ខ្លះ',
            'available' => 'ទំនេរ',
            'occupied' => 'កំពុងប្រើ',
        ][$status ?? ''] ?? $this->display($status);
    }
}
