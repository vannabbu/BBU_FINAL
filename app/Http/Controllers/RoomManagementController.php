<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;

class RoomManagementController extends Controller
{
    public function index()
    {
        $rooms = $this->rooms()->map(fn (array $room) => $room + [
            'edit_url' => route('rooms.edit', ['room' => $room['id']]),
        ]);

        return view('rooms.index', [
            'doctor' => $this->clinicDoctor(),
            'navigation' => $this->clinicNavigation('rooms'),
            'stats' => $this->statistics($rooms),
            'rooms' => $rooms,
            'roomTypes' => $this->roomTypes(),
            'statusOptions' => $this->statusOptions(),
        ]);
    }

    public function create()
    {
        return view('rooms.form', [
            'doctor' => $this->clinicDoctor(),
            'navigation' => $this->clinicNavigation('rooms'),
            'mode' => 'create',
            'room' => $this->blankRoom(),
            'roomTypes' => $this->roomTypes(),
            'statusOptions' => $this->statusOptions(),
            'amenities' => $this->amenities(),
        ]);
    }

    public function edit(string $room)
    {
        $selectedRoom = $this->rooms()
            ->firstWhere('id', $room)
            ?? $this->rooms()->firstWhere('room_number', $room)
            ?? $this->rooms()->first();

        return view('rooms.form', [
            'doctor' => $this->clinicDoctor(),
            'navigation' => $this->clinicNavigation('rooms'),
            'mode' => 'edit',
            'room' => $selectedRoom,
            'roomTypes' => $this->roomTypes(),
            'statusOptions' => $this->statusOptions(),
            'amenities' => $this->amenities(),
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
            ['label' => 'បន្ទប់', 'href' => route('rooms.index'), 'icon' => 'bed-double', 'active' => true],
            ['label' => 'ឃ្លាំងឱសថ', 'href' => route('medicines.index'), 'icon' => 'pill', 'active' => false],
            ['label' => 'វិក្កយបត្រ', 'href' => route('invoices.index'), 'icon' => 'receipt-text', 'active' => false],
            ['label' => 'ការកំណត់', 'href' => route('settings.index'), 'icon' => 'settings', 'active' => false],
        ];
    }

    private function rooms(): Collection
    {
        return collect([
            [
                'id' => 'RM-301',
                'room_number' => '301-A',
                'room_type' => 'VIP Room',
                'floor' => '3rd Floor',
                'wing' => 'North Wing',
                'price_per_day' => 180000,
                'capacity' => 1,
                'status' => 'available',
                'status_label' => 'Available',
                'last_updated' => '10 minutes ago',
                'description' => 'Premium private room with oxygen supply and private bathroom.',
                'amenities' => ['Wi-Fi', 'Air Conditioner', 'Private Bathroom', 'Television', 'Oxygen Supply', 'Emergency Call Button'],
            ],
            [
                'id' => 'RM-204',
                'room_number' => '204-B',
                'room_type' => 'General Ward',
                'floor' => '2nd Floor',
                'wing' => 'East Wing',
                'price_per_day' => 65000,
                'capacity' => 4,
                'status' => 'occupied',
                'status_label' => 'Occupied',
                'last_updated' => '24 minutes ago',
                'description' => 'Shared ward for routine inpatient recovery.',
                'amenities' => ['Wi-Fi', 'Oxygen Supply', 'Wheelchair Access', 'Emergency Call Button'],
            ],
            [
                'id' => 'RM-118',
                'room_number' => '118-C',
                'room_type' => 'ICU',
                'floor' => '1st Floor',
                'wing' => 'Critical Care',
                'price_per_day' => 260000,
                'capacity' => 1,
                'status' => 'reserved',
                'status_label' => 'Reserved',
                'last_updated' => '1 hour ago',
                'description' => 'Critical care room configured for continuous monitoring.',
                'amenities' => ['Air Conditioner', 'Oxygen Supply', 'Wheelchair Access', 'Emergency Call Button'],
            ],
            [
                'id' => 'RM-012',
                'room_number' => 'ER-02',
                'room_type' => 'Emergency',
                'floor' => 'Ground Floor',
                'wing' => 'Emergency Wing',
                'price_per_day' => 120000,
                'capacity' => 2,
                'status' => 'cleaning',
                'status_label' => 'Cleaning',
                'last_updated' => '2 hours ago',
                'description' => 'Emergency observation room currently being prepared.',
                'amenities' => ['Oxygen Supply', 'Wheelchair Access', 'Emergency Call Button'],
            ],
            [
                'id' => 'RM-420',
                'room_number' => '420-D',
                'room_type' => 'Private Room',
                'floor' => '4th Floor',
                'wing' => 'South Wing',
                'price_per_day' => 140000,
                'capacity' => 1,
                'status' => 'maintenance',
                'status_label' => 'Maintenance',
                'last_updated' => 'Yesterday',
                'description' => 'Private room under scheduled maintenance.',
                'amenities' => ['Wi-Fi', 'Air Conditioner', 'Private Bathroom', 'Television'],
            ],
            [
                'id' => 'RM-OP1',
                'room_number' => 'OR-01',
                'room_type' => 'Operating Room',
                'floor' => '2nd Floor',
                'wing' => 'Surgical Wing',
                'price_per_day' => 350000,
                'capacity' => 1,
                'status' => 'available',
                'status_label' => 'Available',
                'last_updated' => 'Today',
                'description' => 'Sterile operating room for scheduled procedures.',
                'amenities' => ['Air Conditioner', 'Oxygen Supply', 'Wheelchair Access', 'Emergency Call Button'],
            ],
        ]);
    }

    private function statistics(Collection $rooms): array
    {
        return [
            ['title' => 'Total Rooms', 'value' => $rooms->count(), 'description' => 'All configured rooms', 'icon' => 'building-2', 'tone' => 'green'],
            ['title' => 'Available Rooms', 'value' => $rooms->where('status', 'available')->count(), 'description' => 'Ready for new patients', 'icon' => 'circle-check-big', 'tone' => 'blue'],
            ['title' => 'Occupied Rooms', 'value' => $rooms->where('status', 'occupied')->count(), 'description' => 'Currently in use', 'icon' => 'bed-double', 'tone' => 'amber'],
            ['title' => 'Maintenance Rooms', 'value' => $rooms->where('status', 'maintenance')->count(), 'description' => 'Needs facility review', 'icon' => 'wrench', 'tone' => 'red'],
        ];
    }

    private function blankRoom(): array
    {
        return [
            'id' => null,
            'room_number' => '',
            'room_type' => 'General Ward',
            'floor' => '',
            'wing' => '',
            'price_per_day' => '',
            'capacity' => 1,
            'status' => 'available',
            'status_label' => 'Available',
            'last_updated' => '',
            'description' => '',
            'amenities' => ['Wi-Fi', 'Oxygen Supply', 'Emergency Call Button'],
        ];
    }

    private function roomTypes(): array
    {
        return [
            'General Ward',
            'Private Room',
            'VIP Room',
            'ICU',
            'Emergency',
            'Operating Room',
            'Isolation Room',
        ];
    }

    private function statusOptions(): array
    {
        return [
            'available' => 'Available',
            'occupied' => 'Occupied',
            'reserved' => 'Reserved',
            'maintenance' => 'Maintenance',
            'cleaning' => 'Cleaning',
        ];
    }

    private function amenities(): array
    {
        return [
            'Wi-Fi',
            'Air Conditioner',
            'Private Bathroom',
            'Television',
            'Oxygen Supply',
            'Wheelchair Access',
            'Emergency Call Button',
        ];
    }
}
