<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Medicine;
use Illuminate\Support\Facades\Schema;
use Throwable;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            [
                'label' => 'អ្នកជំងឺសរុប',
                'value' => $this->metric('patient', fn () => number_format((int) Schema::getConnection()->table('patient')->count())),
                'caption' => 'កំណត់ត្រាអ្នកជំងឺ',
            ],
            [
                'label' => 'វេជ្ជបណ្ឌិត',
                'value' => $this->metric('doctor', fn () => number_format((int) Schema::getConnection()->table('doctor')->count())),
                'caption' => 'បុគ្គលិកព្យាបាល',
            ],
            [
                'label' => 'ណាត់ជួបថ្ងៃនេះ',
                'value' => $this->metric('appointment', fn () => number_format((int) Appointment::query()
                    ->whereDate('appointment_date', now()->toDateString())
                    ->count())),
                'caption' => 'កាលវិភាគប្រចាំថ្ងៃ',
            ],
            [
                'label' => 'វិក្កយបត្រមិនទាន់ទូទាត់',
                'value' => $this->metric('invoice', fn () => number_format((int) Invoice::query()
                    ->whereIn('status', ['unpaid', 'partial'])
                    ->count())),
                'caption' => 'ត្រូវពិនិត្យការទូទាត់',
            ],
        ];

        $inventory = [
            [
                'label' => 'ឱសថសរុបក្នុងឃ្លាំង',
                'value' => $this->metric('medicine', fn () => number_format((int) Medicine::query()->sum('total_quantity'))),
            ],
            [
                'label' => 'គ្រែទំនេរ',
                'value' => $this->metric('bed', fn () => number_format((int) Schema::getConnection()
                    ->table('bed')
                    ->where('status', 'available')
                    ->count())),
            ],
            [
                'label' => 'ឈាមក្នុងស្តុក',
                'value' => $this->metric('blood_bank', fn () => number_format((int) Schema::getConnection()
                    ->table('blood_bank')
                    ->sum('status'))),
            ],
        ];

        $appointments = $this->metric('appointment', fn () => Appointment::query()
            ->with(['patient', 'doctor'])
            ->latest('appointment_date')
            ->take(5)
            ->get(), collect());

        return view('dashboard', [
            'stats' => $stats,
            'inventory' => $inventory,
            'appointments' => $appointments,
        ]);
    }

    private function metric(string $table, callable $callback, mixed $default = '0'): mixed
    {
        if (! Schema::hasTable($table)) {
            return $default;
        }

        try {
            return $callback();
        } catch (Throwable) {
            return $default;
        }
    }
}
