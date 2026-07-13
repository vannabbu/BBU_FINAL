<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Throwable;

class MedicineStockController extends Controller
{
    public function __invoke()
    {
        $inventory = $this->inventory();

        return view('pharmacy.stock', [
            'doctor' => $this->clinicDoctor(),
            'navigation' => $this->clinicNavigation('medicines'),
            'stats' => Cache::remember('pharmacy.inventory.statistics.v1', now()->addMinutes(5), fn () => $this->statistics($inventory)),
            'inventory' => $inventory,
            'categories' => $inventory->pluck('category')->unique()->values()->all(),
            'activities' => $this->activities(),
            'insight' => $this->insight($inventory),
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
            ['label' => 'ឃ្លាំងឱសថ', 'href' => route('medicines.index'), 'icon' => 'pill', 'active' => true],
            ['label' => 'វិក្កយបត្រ', 'href' => route('invoices.index'), 'icon' => 'receipt-text', 'active' => false],
            ['label' => 'ការកំណត់', 'href' => route('settings.index'), 'icon' => 'settings', 'active' => false],
        ];
    }

    private function inventory()
    {
        if (Schema::hasTable('medicine')) {
            try {
                $medicines = Medicine::query()
                    ->with('category')
                    ->latest('id')
                    ->take(40)
                    ->get();

                if ($medicines->isNotEmpty()) {
                    return $medicines->map(fn (Medicine $medicine) => $this->medicineRow($medicine))->values();
                }
            } catch (Throwable) {
                return collect($this->sampleInventory());
            }
        }

        return collect($this->sampleInventory());
    }

    private function medicineRow(Medicine $medicine): array
    {
        $minimumStock = max(40, min(150, (int) ceil(max($medicine->total_quantity, 1) * 0.35)));
        $expiry = $medicine->expiry_date ? Carbon::parse($medicine->expiry_date) : null;
        $daysToExpiry = $expiry?->diffInDays(now(), false);
        $nearExpiry = $expiry ? now()->diffInDays($expiry, false) <= 45 : false;
        $stock = (int) $medicine->total_quantity;
        $status = $nearExpiry
            ? ['label' => 'ជិតផុតកំណត់', 'tone' => 'red', 'key' => 'expiry']
            : ($stock <= $minimumStock
                ? ['label' => 'ខ្វះស្តុក', 'tone' => 'amber', 'key' => 'low']
                : ['label' => 'គ្រប់គ្រាន់', 'tone' => 'green', 'key' => 'healthy']);

        return [
            'id' => 'med-'.$medicine->id,
            'name' => $medicine->name,
            'sku' => 'MED-'.str_pad((string) $medicine->id, 5, '0', STR_PAD_LEFT),
            'category' => $medicine->category?->name ?? 'មិនមានប្រភេទ',
            'current_stock' => $stock,
            'minimum_stock' => $minimumStock,
            'stock_percent' => min(100, (int) round(($stock / max($minimumStock * 2, 1)) * 100)),
            'price' => (float) $medicine->price,
            'stock_value' => (float) $medicine->price * $stock,
            'expiry_date' => $expiry?->format('d M Y') ?? 'មិនមាន',
            'status_label' => $status['label'],
            'status_tone' => $status['tone'],
            'status_key' => $status['key'],
            'supplier' => $medicine->company ?: 'Clinic Pharmacy',
            'updated_at' => $medicine->updated_at?->diffForHumans() ?? 'ថ្មីៗនេះ',
            'days_to_expiry' => $daysToExpiry,
        ];
    }

    private function sampleInventory(): array
    {
        return [
            ['id' => 'med-001', 'name' => 'Paracetamol 500mg', 'sku' => 'NDC-PAR-500', 'category' => 'ថ្នាំបំបាត់ឈឺ', 'current_stock' => 320, 'minimum_stock' => 120, 'stock_percent' => 100, 'price' => 500, 'stock_value' => 160000, 'expiry_date' => '12 កក្កដា 2027', 'status_label' => 'គ្រប់គ្រាន់', 'status_tone' => 'green', 'status_key' => 'healthy', 'supplier' => 'Clinic Pharmacy', 'updated_at' => '១០ នាទីមុន'],
            ['id' => 'med-002', 'name' => 'Amoxicillin 250mg', 'sku' => 'SKU-AMX-250', 'category' => 'Antibiotic', 'current_stock' => 42, 'minimum_stock' => 80, 'stock_percent' => 26, 'price' => 1200, 'stock_value' => 50400, 'expiry_date' => '28 សីហា 2026', 'status_label' => 'ខ្វះស្តុក', 'status_tone' => 'amber', 'status_key' => 'low', 'supplier' => 'MediSupply Phnom Penh', 'updated_at' => '៣០ នាទីមុន'],
            ['id' => 'med-003', 'name' => 'Cetirizine 10mg', 'sku' => 'SKU-CET-010', 'category' => 'Allergy', 'current_stock' => 18, 'minimum_stock' => 60, 'stock_percent' => 15, 'price' => 800, 'stock_value' => 14400, 'expiry_date' => '18 កញ្ញា 2026', 'status_label' => 'ខ្វះស្តុក', 'status_tone' => 'amber', 'status_key' => 'low', 'supplier' => 'HealthCare Depot', 'updated_at' => '១ ម៉ោងមុន'],
            ['id' => 'med-004', 'name' => 'ORS Sachet', 'sku' => 'SKU-ORS-001', 'category' => 'Emergency Care', 'current_stock' => 210, 'minimum_stock' => 90, 'stock_percent' => 100, 'price' => 700, 'stock_value' => 147000, 'expiry_date' => '05 មករា 2028', 'status_label' => 'គ្រប់គ្រាន់', 'status_tone' => 'green', 'status_key' => 'healthy', 'supplier' => 'Clinic Pharmacy', 'updated_at' => 'ថ្ងៃនេះ'],
            ['id' => 'med-005', 'name' => 'Salbutamol Inhaler', 'sku' => 'NDC-SAL-INH', 'category' => 'Respiratory', 'current_stock' => 14, 'minimum_stock' => 25, 'stock_percent' => 28, 'price' => 18500, 'stock_value' => 259000, 'expiry_date' => '20 កក្កដា 2026', 'status_label' => 'ជិតផុតកំណត់', 'status_tone' => 'red', 'status_key' => 'expiry', 'supplier' => 'Kampuchea Medical', 'updated_at' => '២ ម៉ោងមុន'],
            ['id' => 'med-006', 'name' => 'Metformin 500mg', 'sku' => 'SKU-MET-500', 'category' => 'Diabetes', 'current_stock' => 168, 'minimum_stock' => 100, 'stock_percent' => 84, 'price' => 950, 'stock_value' => 159600, 'expiry_date' => '14 ធ្នូ 2027', 'status_label' => 'គ្រប់គ្រាន់', 'status_tone' => 'green', 'status_key' => 'healthy', 'supplier' => 'MediSupply Phnom Penh', 'updated_at' => 'ម្សិលមិញ'],
        ];
    }

    private function statistics($inventory): array
    {
        $totalSkus = $inventory->count();
        $stockValue = $inventory->sum('stock_value');
        $lowStock = $inventory->where('status_key', 'low')->count();
        $nearExpiry = $inventory->where('status_key', 'expiry')->count();

        return [
            ['title' => 'SKU សរុប', 'value' => number_format($totalSkus), 'change' => '+8.4%', 'badge' => 'សកម្ម', 'icon' => 'package-check', 'tone' => 'green'],
            ['title' => 'តម្លៃស្តុក', 'value' => number_format($stockValue).' ៛', 'change' => '+12.1%', 'badge' => 'ខែនេះ', 'icon' => 'banknote', 'tone' => 'blue'],
            ['title' => 'ស្តុកទាប', 'value' => number_format($lowStock), 'change' => $lowStock > 0 ? 'ត្រូវបញ្ជាទិញ' : 'ល្អ', 'badge' => 'Alert', 'icon' => 'triangle-alert', 'tone' => 'orange'],
            ['title' => 'ជិតផុតកំណត់', 'value' => number_format($nearExpiry), 'change' => $nearExpiry > 0 ? 'ពិនិត្យ' : 'គ្មាន', 'badge' => 'Expiry', 'icon' => 'calendar-clock', 'tone' => 'red'],
        ];
    }

    private function activities(): array
    {
        return [
            ['title' => 'បានទទួលស្តុកថ្មី', 'description' => 'ORS Sachet ចំនួន 120 កញ្ចប់បានចូលឃ្លាំង', 'time' => '១០ នាទីមុន', 'icon' => 'package-plus', 'tone' => 'green'],
            ['title' => 'បានចែកចាយឱសថ', 'description' => 'Paracetamol 500mg ចេញតាមវេជ្ជបញ្ជា #RX-2034', 'time' => '២៥ នាទីមុន', 'icon' => 'pill', 'tone' => 'blue'],
            ['title' => 'ការជូនដំណឹងស្តុកទាប', 'description' => 'Amoxicillin 250mg ទាបជាងកម្រិតអប្បបរមា', 'time' => '៤៥ នាទីមុន', 'icon' => 'triangle-alert', 'tone' => 'amber'],
            ['title' => 'ផ្ទេរពី Pharmacy', 'description' => 'Salbutamol Inhaler ផ្ទេរទៅបន្ទប់សង្គ្រោះបន្ទាន់', 'time' => '១ ម៉ោងមុន', 'icon' => 'refresh-cw', 'tone' => 'violet'],
        ];
    }

    private function insight($inventory): array
    {
        $lowItems = $inventory->whereIn('status_key', ['low', 'expiry'])->values();
        $priority = $lowItems->first();

        return [
            'title' => 'AI Reorder Recommendation',
            'medicine' => $priority['name'] ?? 'Amoxicillin 250mg',
            'message' => 'ប្រព័ន្ធណែនាំឲ្យបញ្ជាទិញបន្ថែមក្នុងរយៈពេល ៤៨ ម៉ោង ដើម្បីការពារការខ្វះស្តុកក្នុងម៉ោងព្យាបាល។',
            'confidence' => 86,
            'quantity' => '150 units',
            'saving' => 'អាចរក្សាសេវាឱសថបាន ៣ សប្តាហ៍',
        ];
    }
}
