@props([
    'room',
    'roomTypes' => [],
    'statusOptions' => [],
    'amenities' => [],
    'mode' => 'create',
])

<form
    x-data="roomForm(@js($room), @js($mode))"
    x-on:submit.prevent="submit()"
    class="space-y-6"
>
    <div
        x-cloak
        x-show="saved"
        x-transition
        class="rounded-2xl border border-[#2F6F3E]/20 bg-[#2F6F3E]/10 px-4 py-3 text-sm font-extrabold text-[#2F6F3E]"
    >
        <div class="flex items-center gap-2">
            <i data-lucide="circle-check-big" class="h-4 w-4"></i>
            <span x-text="mode === 'edit' ? 'Room updated successfully.' : 'Room saved successfully.'"></span>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_380px]">
        <main class="space-y-6">
            <x-room.form-section
                title="Room Specification"
                subtitle="Configure hospital room details and availability."
                icon="door-open"
            >
                <div class="grid gap-5 md:grid-cols-2">
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Room Number</span>
                        <input
                            type="text"
                            x-model.trim="form.room_number"
                            placeholder="Example: 301-A"
                            x-bind:class="errors.room_number ? 'border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-500/10 dark:border-red-500/40 dark:bg-red-500/10' : 'border-slate-200 bg-slate-50 focus:border-[#2F6F3E] focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800'"
                            class="h-12 w-full rounded-2xl px-4 text-sm font-semibold text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900"
                        >
                        <p x-show="errors.room_number" x-text="errors.room_number" class="mt-2 text-xs font-bold text-red-600"></p>
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Room Type</span>
                        <select
                            x-model="form.room_type"
                            x-bind:class="errors.room_type ? 'border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-500/10 dark:border-red-500/40 dark:bg-red-500/10' : 'border-slate-200 bg-slate-50 focus:border-[#2F6F3E] focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800'"
                            class="h-12 w-full rounded-2xl px-4 text-sm font-semibold text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900"
                        >
                            @foreach ($roomTypes as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                        <p x-show="errors.room_type" x-text="errors.room_type" class="mt-2 text-xs font-bold text-red-600"></p>
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Floor</span>
                        <input
                            type="text"
                            x-model.trim="form.floor"
                            placeholder="Example: 3rd Floor"
                            x-bind:class="errors.floor ? 'border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-500/10 dark:border-red-500/40 dark:bg-red-500/10' : 'border-slate-200 bg-slate-50 focus:border-[#2F6F3E] focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800'"
                            class="h-12 w-full rounded-2xl px-4 text-sm font-semibold text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900"
                        >
                        <p x-show="errors.floor" x-text="errors.floor" class="mt-2 text-xs font-bold text-red-600"></p>
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Wing / Building</span>
                        <input
                            type="text"
                            x-model.trim="form.wing"
                            placeholder="Example: North Wing"
                            x-bind:class="errors.wing ? 'border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-500/10 dark:border-red-500/40 dark:bg-red-500/10' : 'border-slate-200 bg-slate-50 focus:border-[#2F6F3E] focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800'"
                            class="h-12 w-full rounded-2xl px-4 text-sm font-semibold text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900"
                        >
                        <p x-show="errors.wing" x-text="errors.wing" class="mt-2 text-xs font-bold text-red-600"></p>
                    </label>
                </div>
            </x-room.form-section>

            <x-room.form-section
                title="Pricing & Capacity"
                subtitle="Set occupancy capacity, patient price, and billing baseline."
                icon="banknote"
            >
                <div class="grid gap-5 md:grid-cols-2">
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Price Per Day</span>
                        <div class="relative">
                            <input
                                type="number"
                                min="0"
                                step="1000"
                                x-model.number="form.price_per_day"
                                placeholder="180000"
                                x-bind:class="errors.price_per_day ? 'border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-500/10 dark:border-red-500/40 dark:bg-red-500/10' : 'border-slate-200 bg-slate-50 focus:border-[#2F6F3E] focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800'"
                                class="h-12 w-full rounded-2xl px-4 pr-12 text-sm font-semibold text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900"
                            >
                            <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-sm font-extrabold text-slate-400">៛</span>
                        </div>
                        <p x-show="errors.price_per_day" x-text="errors.price_per_day" class="mt-2 text-xs font-bold text-red-600"></p>
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Capacity</span>
                        <input
                            type="number"
                            min="1"
                            x-model.number="form.capacity"
                            x-bind:class="errors.capacity ? 'border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-500/10 dark:border-red-500/40 dark:bg-red-500/10' : 'border-slate-200 bg-slate-50 focus:border-[#2F6F3E] focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800'"
                            class="h-12 w-full rounded-2xl px-4 text-sm font-semibold text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900"
                        >
                        <p x-show="errors.capacity" x-text="errors.capacity" class="mt-2 text-xs font-bold text-red-600"></p>
                    </label>
                </div>
            </x-room.form-section>

            <x-room.form-section
                title="Description"
                subtitle="Add operational notes that help admission and facility teams."
                icon="notebook-pen"
            >
                <label class="block">
                    <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Description</span>
                    <textarea
                        x-model.trim="form.description"
                        rows="5"
                        placeholder="Describe room usage, facility notes, or special instructions..."
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold leading-7 text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900"
                    ></textarea>
                </label>
            </x-room.form-section>
        </main>

        <aside class="space-y-6">
            <x-room.form-section
                title="Availability"
                subtitle="Control room status for admission visibility."
                icon="activity"
                :open="true"
            >
                <label class="block">
                    <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Current Status</span>
                    <select
                        x-model="form.status"
                        class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900"
                    >
                        @foreach ($statusOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </label>

                <div class="mt-5 rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                    <p class="text-xs font-extrabold uppercase tracking-wide text-slate-400">Current Preview</p>
                    <div class="mt-3 flex items-center justify-between gap-3">
                        <div>
                            <p class="font-extrabold text-slate-950 dark:text-white" x-text="form.room_number || 'Room number'"></p>
                            <p class="mt-1 text-xs font-semibold text-slate-500 dark:text-slate-400" x-text="form.room_type"></p>
                        </div>
                        <x-room.status-badge dynamic x-text="statusLabel(form.status)" x-bind:class="statusClass(form.status)" />
                    </div>
                </div>
            </x-room.form-section>

            <x-room.form-section
                title="Amenities"
                subtitle="Select facilities available inside this room."
                icon="sparkles"
                :open="true"
            >
                <div class="space-y-3">
                    @foreach ($amenities as $amenity)
                        <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-3 transition hover:border-[#2F6F3E]/40 dark:border-slate-700 dark:bg-slate-800">
                            <input
                                type="checkbox"
                                class="h-4 w-4 rounded border-slate-300 text-[#2F6F3E] focus:ring-[#2F6F3E]"
                                x-bind:checked="hasAmenity(@js($amenity))"
                                x-on:change="toggleAmenity(@js($amenity))"
                            >
                            <span class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $amenity }}</span>
                        </label>
                    @endforeach
                </div>
            </x-room.form-section>
        </aside>
    </div>

    <div class="sticky bottom-0 z-20 -mx-4 border-t border-[#E5E7EB] bg-white/92 px-4 py-4 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-900/92 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 xl:rounded-t-2xl xl:border xl:shadow-[0_-12px_30px_rgba(15,23,42,0.05)]">
        <div class="mx-auto flex max-w-7xl flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">
                <span x-show="! hasErrors()">Ready to save room configuration.</span>
                <span x-show="hasErrors()" class="text-red-600">Please fix validation errors before saving.</span>
            </p>
            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('rooms.index') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-extrabold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                    <i data-lucide="x" class="h-4 w-4"></i>
                    Cancel
                </a>
                <button type="button" x-on:click="resetForm()" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-extrabold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                    <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
                    Reset
                </button>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-[#2F6F3E] px-4 py-3 text-sm font-extrabold text-white shadow-sm transition hover:bg-[#285f35] focus:outline-none focus:ring-4 focus:ring-[#2F6F3E]/20">
                    <i data-lucide="save" class="h-4 w-4"></i>
                    <span x-text="mode === 'edit' ? 'Update Room' : 'Save Room'"></span>
                </button>
            </div>
        </div>
    </div>
</form>

@once
    @push('scripts')
        <script>
            function roomForm(initialRoom, mode) {
                return {
                    initialRoom: JSON.parse(JSON.stringify(initialRoom)),
                    form: JSON.parse(JSON.stringify(initialRoom)),
                    mode,
                    errors: {},
                    saved: false,
                    statusLabels: {
                        available: 'Available',
                        occupied: 'Occupied',
                        reserved: 'Reserved',
                        maintenance: 'Maintenance',
                        cleaning: 'Cleaning',
                    },
                    validate() {
                        this.errors = {};

                        if (! this.form.room_number) {
                            this.errors.room_number = 'Room number is required.';
                        }

                        if (! this.form.room_type) {
                            this.errors.room_type = 'Room type is required.';
                        }

                        if (! this.form.floor) {
                            this.errors.floor = 'Floor is required.';
                        }

                        if (! this.form.wing) {
                            this.errors.wing = 'Wing or building is required.';
                        }

                        if (! Number(this.form.price_per_day) || Number(this.form.price_per_day) <= 0) {
                            this.errors.price_per_day = 'Price per day must be greater than zero.';
                        }

                        if (! Number(this.form.capacity) || Number(this.form.capacity) < 1) {
                            this.errors.capacity = 'Capacity must be at least one patient.';
                        }

                        return ! this.hasErrors();
                    },
                    hasErrors() {
                        return Object.keys(this.errors).length > 0;
                    },
                    submit() {
                        this.saved = false;

                        if (! this.validate()) {
                            return;
                        }

                        this.saved = true;
                        this.initialRoom = JSON.parse(JSON.stringify(this.form));

                        this.$nextTick(() => {
                            if (window.lucide) {
                                window.lucide.createIcons();
                            }
                        });

                        setTimeout(() => {
                            this.saved = false;
                        }, 2800);
                    },
                    resetForm() {
                        this.form = JSON.parse(JSON.stringify(this.initialRoom));
                        this.errors = {};
                        this.saved = false;
                    },
                    hasAmenity(amenity) {
                        return (this.form.amenities || []).includes(amenity);
                    },
                    toggleAmenity(amenity) {
                        const amenities = this.form.amenities || [];

                        if (amenities.includes(amenity)) {
                            this.form.amenities = amenities.filter((item) => item !== amenity);
                        } else {
                            this.form.amenities = [...amenities, amenity];
                        }
                    },
                    statusLabel(status) {
                        return this.statusLabels[status] || status;
                    },
                    statusClass(status) {
                        return {
                            available: 'border-[#2F6F3E]/20 bg-[#2F6F3E]/10 text-[#2F6F3E]',
                            occupied: 'border-amber-100 bg-amber-50 text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300',
                            reserved: 'border-sky-100 bg-sky-50 text-sky-700 dark:border-sky-500/20 dark:bg-sky-500/10 dark:text-sky-300',
                            maintenance: 'border-red-100 bg-red-50 text-red-700 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-300',
                            cleaning: 'border-violet-100 bg-violet-50 text-violet-700 dark:border-violet-500/20 dark:bg-violet-500/10 dark:text-violet-300',
                        }[status] || 'border-slate-200 bg-slate-100 text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300';
                    },
                };
            }
        </script>
    @endpush
@endonce
