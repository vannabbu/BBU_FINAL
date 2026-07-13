<x-layout.app title="Staff & User Management" :navigation="$navigation" :doctor="$doctor">
    <x-layout.breadcrumb :items="[
        ['label' => 'ទំព័រដើម', 'href' => route('dashboard')],
        ['label' => 'Staff', 'href' => url('/staff')],
        ['label' => 'Staff & User Management', 'href' => null],
    ]" />

    <x-layout.page-header
        title="Staff & User Management"
        subtitle="Manage doctors, nurses, administrators, receptionists, laboratory staff, pharmacists, and system users."
    >
        <a href="{{ url('/staff/create') }}" class="fixed bottom-5 right-5 z-30 inline-flex items-center gap-2 rounded-2xl bg-[#2F6F3E] px-4 py-3 text-sm font-extrabold text-white shadow-xl transition hover:bg-[#285f35] focus:outline-none focus:ring-4 focus:ring-[#2F6F3E]/20 sm:static sm:shadow-sm">
            <i data-lucide="user-plus" class="h-4 w-4"></i>
            Add Employee
        </a>
    </x-layout.page-header>

    <section class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $stat)
            <x-staff.stat-card
                :title="$stat['title']"
                :value="$stat['value']"
                :description="$stat['description']"
                :trend="$stat['trend']"
                :icon="$stat['icon']"
                :tone="$stat['tone']"
            />
        @endforeach
    </section>

    <div class="mt-6">
        <x-staff.employee-table
            :employees="$employees"
            :departments="$departments"
            :roles="$roles"
            :statuses="$statuses"
        />
    </div>
</x-layout.app>
