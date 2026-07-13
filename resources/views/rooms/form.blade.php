@php
    $isEdit = $mode === 'edit';
@endphp

<x-layout.app :title="$isEdit ? 'Edit Room' : 'Add Room'" :navigation="$navigation" :doctor="$doctor">
    <x-layout.breadcrumb :items="[
        ['label' => 'ទំព័រដើម', 'href' => route('dashboard')],
        ['label' => 'Rooms', 'href' => route('rooms.index')],
        ['label' => $isEdit ? 'Edit Room' : 'Add Room', 'href' => null],
    ]" />

    <x-layout.page-header
        :title="$isEdit ? 'Edit Room' : 'Add Room'"
        subtitle="Configure hospital room details and availability."
    >
        <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-extrabold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Back to Rooms
        </a>
    </x-layout.page-header>

    <div class="mt-6">
        <x-room.room-form
            :room="$room"
            :room-types="$roomTypes"
            :status-options="$statusOptions"
            :amenities="$amenities"
            :mode="$mode"
        />
    </div>
</x-layout.app>
