<x-layout.app title="Room Management" :navigation="$navigation" :doctor="$doctor">
    <x-layout.breadcrumb :items="[
        ['label' => 'ទំព័រដើម', 'href' => route('dashboard')],
        ['label' => 'Rooms', 'href' => route('rooms.index')],
        ['label' => 'Room Management', 'href' => null],
    ]" />

    <x-layout.page-header
        title="Room Management"
        subtitle="Manage hospital rooms, availability, pricing, and occupancy."
    >
        <a href="{{ route('rooms.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-[#2F6F3E] px-4 py-2.5 text-sm font-extrabold text-white shadow-sm transition hover:bg-[#285f35] focus:outline-none focus:ring-4 focus:ring-[#2F6F3E]/20">
            <i data-lucide="plus" class="h-4 w-4"></i>
            Add New Room
        </a>
    </x-layout.page-header>

    <section class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $stat)
            <x-room.stat-card
                :title="$stat['title']"
                :value="$stat['value']"
                :description="$stat['description']"
                :icon="$stat['icon']"
                :tone="$stat['tone']"
            />
        @endforeach
    </section>

    <div class="mt-6">
        <x-room.room-table
            :rooms="$rooms"
            :room-types="$roomTypes"
            :status-options="$statusOptions"
        />
    </div>
</x-layout.app>
