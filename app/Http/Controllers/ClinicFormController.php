<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Bed;
use App\Models\BedAllotment;
use App\Models\BloodBank;
use App\Models\Department;
use App\Models\DiagnosisReport;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Medicine;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class ClinicFormController extends Controller
{
    public function create(string $module)
    {
        $config = $this->config($module);

        abort_if($config === null, 404);

        return view('modules.create', [
            'module' => $module,
            'title' => $config['title'],
            'description' => $config['description'],
            'fields' => $this->fields($config),
            'indexUrl' => route($config['index_route']),
            'storeUrl' => route('modules.store', ['module' => $module]),
            'doctor' => $this->clinicDoctor(),
            'navigation' => $this->clinicNavigation($this->activeNavigationKey($module)),
        ]);
    }

    public function store(Request $request, string $module)
    {
        $config = $this->config($module);

        abort_if($config === null, 404);

        $fields = $this->fields($config);
        $rules = collect($fields)
            ->mapWithKeys(fn (array $field) => [$field['name'] => $field['rules']])
            ->all();

        $validated = $request->validate(
            $rules,
            [
                'required' => 'សូមបំពេញ :attribute',
                'email' => ':attribute មិនត្រឹមត្រូវ',
                'unique' => ':attribute មានរួចហើយ',
                'exists' => ':attribute មិនមានក្នុងប្រព័ន្ធ',
                'numeric' => ':attribute ត្រូវតែជាលេខ',
                'integer' => ':attribute ត្រូវតែជាចំនួនគត់',
                'date' => ':attribute ត្រូវតែជាកាលបរិច្ឆេទត្រឹមត្រូវ',
            ],
            collect($fields)->pluck('label', 'name')->all()
        );

        $validated = collect($validated)
            ->map(fn ($value) => $value === '' ? null : $value)
            ->all();

        $this->storeModule($module, $validated);

        return redirect()
            ->route($config['index_route'])
            ->with('success', 'បានបន្ថែមទិន្នន័យថ្មីដោយជោគជ័យ។');
    }

    private function storeModule(string $module, array $data): void
    {
        match ($module) {
            'departments' => Department::query()->create($data),
            'doctors' => Doctor::query()->create($data),
            'patients' => Patient::query()->create($data),
            'appointments' => $this->storeAppointment($data),
            'blood-bank' => BloodBank::query()->create($data),
            'bed-allotments' => $this->storeBedAllotment($data),
            'medicines' => Medicine::query()->create($data),
            'diagnosis-reports' => DiagnosisReport::query()->create($this->dateTimeData($data, 'date')),
            'invoices' => Invoice::query()->create($this->invoiceData($data)),
        };
    }

    private function activeNavigationKey(string $module): ?string
    {
        return match ($module) {
            'departments' => 'specialties',
            'bed-allotments' => 'rooms',
            default => $module,
        };
    }

    private function storeAppointment(array $data): void
    {
        $appointmentDate = Carbon::parse($data['appointment_date']);

        $alreadyBooked = Appointment::query()
            ->where('doctor_id', $data['doctor_id'])
            ->where('appointment_date', $appointmentDate)
            ->exists();

        if ($alreadyBooked) {
            back()
                ->withErrors(['appointment_date' => 'វេជ្ជបណ្ឌិតនេះមានការណាត់ជួបនៅម៉ោងនេះរួចហើយ។'])
                ->withInput()
                ->throwResponse();
        }

        $data['appointment_date'] = $appointmentDate;

        Appointment::query()->create($data);
    }

    private function storeBedAllotment(array $data): void
    {
        if (($data['bed_id'] ?? null) === null && ($data['new_bed_number'] ?? null) !== null) {
            $bed = Bed::query()->create([
                'department_id' => $data['department_id'] ?? null,
                'bed_number' => $data['new_bed_number'],
                'type' => $data['new_bed_type'] ?? null,
                'status' => 'available',
            ]);

            $data['bed_id'] = $bed->id;
        }

        unset($data['department_id'], $data['new_bed_number'], $data['new_bed_type']);

        $isOccupied = BedAllotment::query()
            ->where('bed_id', $data['bed_id'])
            ->whereNull('discharge_time')
            ->exists();

        if ($isOccupied) {
            back()
                ->withErrors(['bed_id' => 'គ្រែនេះកំពុងប្រើប្រាស់រួចហើយ។'])
                ->withInput()
                ->throwResponse();
        }

        $data = $this->dateTimeData($data, 'allotment_time');
        $data = $this->dateTimeData($data, 'discharge_time');

        BedAllotment::query()->create($data);

        if (($data['discharge_time'] ?? null) === null) {
            Bed::query()->whereKey($data['bed_id'])->update(['status' => 'occupied']);
        }
    }

    private function dateTimeData(array $data, string $key): array
    {
        if (($data[$key] ?? null) !== null) {
            $data[$key] = Carbon::parse($data[$key]);
        }

        return $data;
    }

    private function invoiceData(array $data): array
    {
        $total = (float) ($data['total_amount'] ?? 0);
        $discount = (float) ($data['discount'] ?? 0);
        $vat = (float) ($data['vat'] ?? 0);

        if (($data['grand_total'] ?? null) === null) {
            $data['grand_total'] = max($total - $discount + $vat, 0);
        }

        return $data;
    }

    private function fields(array $config): array
    {
        return collect($config['fields'])
            ->map(function (array $field) {
                if (isset($field['options']) && is_callable($field['options'])) {
                    $field['options'] = $field['options']();
                }

                $field['options'] ??= [];
                $field['placeholder'] ??= '';

                return $field;
            })
            ->all();
    }

    private function config(string $module): ?array
    {
        return [
            'departments' => [
                'title' => 'ផ្នែកព្យាបាល',
                'description' => 'បង្កើតផ្នែកព្យាបាលថ្មីសម្រាប់គ្លីនិក។',
                'index_route' => 'departments.index',
                'fields' => [
                    ['name' => 'name', 'label' => 'ឈ្មោះផ្នែក', 'type' => 'text', 'rules' => ['required', 'string', 'max:255']],
                    ['name' => 'description', 'label' => 'ពិពណ៌នា', 'type' => 'textarea', 'rules' => ['nullable', 'string']],
                ],
            ],
            'doctors' => [
                'title' => 'វេជ្ជបណ្ឌិត',
                'description' => 'បង្កើតគណនីវេជ្ជបណ្ឌិតថ្មី។',
                'index_route' => 'doctors.index',
                'fields' => [
                    ['name' => 'department_id', 'label' => 'ផ្នែក', 'type' => 'select', 'rules' => ['nullable', Rule::exists('department', 'id')], 'options' => fn () => $this->options('department', 'name')],
                    ['name' => 'name', 'label' => 'ឈ្មោះ', 'type' => 'text', 'rules' => ['required', 'string', 'max:255']],
                    ['name' => 'email', 'label' => 'អ៊ីមែល', 'type' => 'email', 'rules' => ['required', 'email', 'max:255', Rule::unique('doctor', 'email')]],
                    ['name' => 'password', 'label' => 'ពាក្យសម្ងាត់', 'type' => 'password', 'rules' => ['required', 'string', 'min:6']],
                    ['name' => 'phone', 'label' => 'ទូរស័ព្ទ', 'type' => 'text', 'rules' => ['nullable', 'string', 'max:50']],
                    ['name' => 'designation', 'label' => 'តួនាទី', 'type' => 'text', 'rules' => ['nullable', 'string', 'max:255']],
                    ['name' => 'profile', 'label' => 'ប្រវត្តិសង្ខេប', 'type' => 'textarea', 'rules' => ['nullable', 'string']],
                ],
            ],
            'patients' => [
                'title' => 'អ្នកជំងឺ',
                'description' => 'បញ្ចូលកំណត់ត្រាអ្នកជំងឺថ្មី។',
                'index_route' => 'patients.index',
                'fields' => [
                    ['name' => 'name', 'label' => 'ឈ្មោះ', 'type' => 'text', 'rules' => ['required', 'string', 'max:255']],
                    ['name' => 'email', 'label' => 'អ៊ីមែល', 'type' => 'email', 'rules' => ['nullable', 'email', 'max:255', Rule::unique('patient', 'email')]],
                    ['name' => 'phone', 'label' => 'ទូរស័ព្ទ', 'type' => 'text', 'rules' => ['required', 'string', 'max:50']],
                    ['name' => 'sex', 'label' => 'ភេទ', 'type' => 'select', 'rules' => ['nullable', 'string', 'max:10'], 'options' => ['ប្រុស' => 'ប្រុស', 'ស្រី' => 'ស្រី']],
                    ['name' => 'age', 'label' => 'អាយុ', 'type' => 'number', 'rules' => ['nullable', 'integer', 'min:0', 'max:150']],
                    ['name' => 'blood_group', 'label' => 'ក្រុមឈាម', 'type' => 'select', 'rules' => ['nullable', 'string', 'max:5'], 'options' => $this->bloodGroups()],
                    ['name' => 'address', 'label' => 'អាសយដ្ឋាន', 'type' => 'textarea', 'rules' => ['nullable', 'string']],
                ],
            ],
            'appointments' => [
                'title' => 'ការណាត់ជួប',
                'description' => 'បង្កើតការណាត់ជួបថ្មី និងការពារការណាត់ជួបជាន់ម៉ោង។',
                'index_route' => 'appointments.index',
                'fields' => [
                    ['name' => 'patient_id', 'label' => 'អ្នកជំងឺ', 'type' => 'select', 'rules' => ['required', Rule::exists('patient', 'id')], 'options' => fn () => $this->options('patient', 'name')],
                    ['name' => 'doctor_id', 'label' => 'វេជ្ជបណ្ឌិត', 'type' => 'select', 'rules' => ['required', Rule::exists('doctor', 'id')], 'options' => fn () => $this->options('doctor', 'name')],
                    ['name' => 'appointment_date', 'label' => 'ថ្ងៃម៉ោងណាត់ជួប', 'type' => 'datetime-local', 'rules' => ['required', 'date']],
                    ['name' => 'status', 'label' => 'ស្ថានភាព', 'type' => 'select', 'rules' => ['required', Rule::in(['pending', 'approved', 'cancelled'])], 'options' => ['pending' => 'រង់ចាំ', 'approved' => 'បានអនុម័ត', 'cancelled' => 'បានបោះបង់']],
                    ['name' => 'remarks', 'label' => 'កំណត់ចំណាំ', 'type' => 'textarea', 'rules' => ['nullable', 'string']],
                ],
            ],
            'blood-bank' => [
                'title' => 'ធនាគារឈាម',
                'description' => 'បញ្ចូលក្រុមឈាម និងចំនួនក្នុងស្តុក។',
                'index_route' => 'blood-bank.index',
                'fields' => [
                    ['name' => 'blood_group', 'label' => 'ក្រុមឈាម', 'type' => 'select', 'rules' => ['required', 'string', 'max:5', Rule::unique('blood_bank', 'blood_group')], 'options' => $this->bloodGroups()],
                    ['name' => 'status', 'label' => 'ចំនួនក្នុងស្តុក', 'type' => 'number', 'rules' => ['required', 'integer', 'min:0']],
                ],
            ],
            'bed-allotments' => [
                'title' => 'បែងចែកគ្រែ',
                'description' => 'កំណត់គ្រែសម្រាប់អ្នកជំងឺស្នាក់នៅ។',
                'index_route' => 'bed-allotments.index',
                'fields' => [
                    ['name' => 'bed_id', 'label' => 'ជ្រើសគ្រែស្រាប់', 'type' => 'select', 'rules' => ['nullable', Rule::exists('bed', 'id')], 'options' => fn () => $this->options('bed', 'bed_number')],
                    ['name' => 'new_bed_number', 'label' => 'លេខគ្រែថ្មី', 'type' => 'text', 'rules' => ['nullable', 'required_without:bed_id', 'string', 'max:50', Rule::unique('bed', 'bed_number')], 'placeholder' => 'បំពេញតែពេលមិនជ្រើសគ្រែស្រាប់'],
                    ['name' => 'department_id', 'label' => 'ផ្នែកសម្រាប់គ្រែថ្មី', 'type' => 'select', 'rules' => ['nullable', Rule::exists('department', 'id')], 'options' => fn () => $this->options('department', 'name')],
                    ['name' => 'new_bed_type', 'label' => 'ប្រភេទគ្រែថ្មី', 'type' => 'text', 'rules' => ['nullable', 'string', 'max:100'], 'placeholder' => 'ICU, VIP, Normal'],
                    ['name' => 'patient_id', 'label' => 'អ្នកជំងឺ', 'type' => 'select', 'rules' => ['required', Rule::exists('patient', 'id')], 'options' => fn () => $this->options('patient', 'name')],
                    ['name' => 'allotment_time', 'label' => 'ពេលចូលស្នាក់នៅ', 'type' => 'datetime-local', 'rules' => ['required', 'date']],
                    ['name' => 'discharge_time', 'label' => 'ពេលចេញពីគ្រែ', 'type' => 'datetime-local', 'rules' => ['nullable', 'date', 'after_or_equal:allotment_time']],
                ],
            ],
            'medicines' => [
                'title' => 'ឃ្លាំងឱសថ',
                'description' => 'បញ្ចូលឱសថថ្មីទៅក្នុងឃ្លាំង។',
                'index_route' => 'medicines.index',
                'fields' => [
                    ['name' => 'category_id', 'label' => 'ប្រភេទឱសថ', 'type' => 'select', 'rules' => ['nullable', Rule::exists('medicine_category', 'id')], 'options' => fn () => $this->options('medicine_category', 'name')],
                    ['name' => 'name', 'label' => 'ឈ្មោះឱសថ', 'type' => 'text', 'rules' => ['required', 'string', 'max:255']],
                    ['name' => 'price', 'label' => 'តម្លៃ', 'type' => 'number', 'step' => '0.01', 'rules' => ['required', 'numeric', 'min:0']],
                    ['name' => 'total_quantity', 'label' => 'ចំនួន', 'type' => 'number', 'rules' => ['required', 'integer', 'min:0']],
                    ['name' => 'expiry_date', 'label' => 'ថ្ងៃផុតកំណត់', 'type' => 'date', 'rules' => ['nullable', 'date']],
                    ['name' => 'company', 'label' => 'ក្រុមហ៊ុន', 'type' => 'text', 'rules' => ['nullable', 'string', 'max:255']],
                ],
            ],
            'diagnosis-reports' => [
                'title' => 'មន្ទីរពិសោធន៍',
                'description' => 'បញ្ចូលលទ្ធផលពិនិត្យ ឬរបាយការណ៍វេជ្ជសាស្ត្រ។',
                'index_route' => 'diagnosis-reports.index',
                'fields' => [
                    ['name' => 'patient_id', 'label' => 'អ្នកជំងឺ', 'type' => 'select', 'rules' => ['required', Rule::exists('patient', 'id')], 'options' => fn () => $this->options('patient', 'name')],
                    ['name' => 'laboratorist_id', 'label' => 'បុគ្គលិកពិសោធន៍', 'type' => 'select', 'rules' => ['nullable', Rule::exists('laboratorist', 'id')], 'options' => fn () => $this->options('laboratorist', 'name')],
                    ['name' => 'report_type', 'label' => 'ប្រភេទរបាយការណ៍', 'type' => 'text', 'rules' => ['required', 'string', 'max:255']],
                    ['name' => 'document_url', 'label' => 'ទីតាំងឯកសារ', 'type' => 'text', 'rules' => ['nullable', 'string', 'max:255']],
                    ['name' => 'description', 'label' => 'ពិពណ៌នា', 'type' => 'textarea', 'rules' => ['nullable', 'string']],
                    ['name' => 'date', 'label' => 'ថ្ងៃបង្កើត', 'type' => 'datetime-local', 'rules' => ['nullable', 'date']],
                ],
            ],
            'invoices' => [
                'title' => 'វិក្កយបត្រ',
                'description' => 'បង្កើតវិក្កយបត្រថ្មីសម្រាប់អ្នកជំងឺ។',
                'index_route' => 'invoices.index',
                'fields' => [
                    ['name' => 'patient_id', 'label' => 'អ្នកជំងឺ', 'type' => 'select', 'rules' => ['required', Rule::exists('patient', 'id')], 'options' => fn () => $this->options('patient', 'name')],
                    ['name' => 'total_amount', 'label' => 'ចំនួនសរុប', 'type' => 'number', 'step' => '0.01', 'rules' => ['required', 'numeric', 'min:0']],
                    ['name' => 'discount', 'label' => 'បញ្ចុះតម្លៃ', 'type' => 'number', 'step' => '0.01', 'rules' => ['nullable', 'numeric', 'min:0']],
                    ['name' => 'vat', 'label' => 'ពន្ធ', 'type' => 'number', 'step' => '0.01', 'rules' => ['nullable', 'numeric', 'min:0']],
                    ['name' => 'grand_total', 'label' => 'សរុបចុងក្រោយ', 'type' => 'number', 'step' => '0.01', 'rules' => ['nullable', 'numeric', 'min:0'], 'placeholder' => 'ទុកទទេ ដើម្បីគណនាស្វ័យប្រវត្តិ'],
                    ['name' => 'status', 'label' => 'ស្ថានភាព', 'type' => 'select', 'rules' => ['required', Rule::in(['unpaid', 'partial', 'paid'])], 'options' => ['unpaid' => 'មិនទាន់ទូទាត់', 'partial' => 'ទូទាត់ខ្លះ', 'paid' => 'បានទូទាត់']],
                    ['name' => 'date', 'label' => 'កាលបរិច្ឆេទ', 'type' => 'date', 'rules' => ['required', 'date']],
                ],
            ],
        ][$module] ?? null;
    }

    private function options(string $table, string $labelColumn): array
    {
        if (! Schema::hasTable($table)) {
            return [];
        }

        return DB::table($table)
            ->orderBy($labelColumn)
            ->pluck($labelColumn, 'id')
            ->map(fn ($label) => (string) $label)
            ->all();
    }

    private function bloodGroups(): array
    {
        return collect(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])
            ->mapWithKeys(fn (string $group) => [$group => $group])
            ->all();
    }
}
