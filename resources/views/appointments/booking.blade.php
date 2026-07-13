<x-layout.app title="Appointment Booking" :navigation="$navigation" :doctor="$doctor">
    <x-layout.breadcrumb :items="[
        ['label' => 'ទំព័រដើម', 'href' => route('dashboard')],
        ['label' => 'Appointments', 'href' => route('appointments.index')],
        ['label' => 'Appointment Booking', 'href' => null],
    ]" />

    <x-layout.page-header
        title="Appointment Booking"
        subtitle="Schedule patient appointments, assign doctors, select consultation time, and manage visit information."
    >
        <span class="inline-flex items-center gap-2 rounded-full bg-[#2F6F3E]/10 px-3 py-2 text-sm font-extrabold text-[#2F6F3E]">
            <i data-lucide="shield-check" class="h-4 w-4"></i>
            Reception workflow
        </span>
    </x-layout.page-header>

    <div
        x-data="appointmentBooking(@js($patients), @js($selectedDoctor), @js($timeSlots), @js($departments), @js($consultationTypes), @js($priorities), @js($durations))"
        x-init="init()"
        class="mt-6 space-y-6"
    >
        <div
            x-cloak
            x-show="successMessage"
            x-transition
            class="rounded-2xl border border-[#16A34A]/20 bg-[#16A34A]/10 px-4 py-3 text-sm font-extrabold text-[#16A34A]"
        >
            <div class="flex items-center gap-2">
                <i data-lucide="circle-check-big" class="h-4 w-4"></i>
                <span x-text="successMessage"></span>
            </div>
        </div>

        <section class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_390px]">
            <main class="min-w-0 space-y-6">
                <x-appointment.patient-card />

                <div class="xl:hidden">
                    <x-appointment.doctor-card :doctor="$selectedDoctor" />
                </div>

                <x-appointment.date-picker :calendar="$availabilityCalendar" />
                <x-appointment.time-slot-picker />

                <x-ui.card>
                    <div class="flex items-start gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300">
                            <i data-lucide="clipboard-list" class="h-5 w-5"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">Appointment Details</h2>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Select department, consultation type, priority, and estimated duration.</p>
                        </div>
                    </div>

                    <div class="mt-5 grid gap-5 md:grid-cols-2">
                        <label class="block">
                            <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Department</span>
                            <select x-model="form.department" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
                                @foreach ($departments as $department)
                                    <option value="{{ $department }}">{{ $department }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block">
                            <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Consultation Type</span>
                            <select x-model="form.consultation_type" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
                                @foreach ($consultationTypes as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block">
                            <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Priority</span>
                            <select x-model="form.priority" x-bind:class="priorityClass" class="h-12 w-full rounded-2xl border px-4 text-sm font-semibold outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900">
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority }}">{{ $priority }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block">
                            <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Estimated Duration</span>
                            <select x-model="form.duration" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
                                @foreach ($durations as $duration)
                                    <option value="{{ $duration }}">{{ $duration }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </x-ui.card>

                <x-appointment.notes-card />
            </main>

            <aside class="space-y-6">
                <div class="hidden xl:block">
                    <x-appointment.doctor-card :doctor="$selectedDoctor" />
                </div>
                <x-appointment.summary-card :doctor="$selectedDoctor" />
            </aside>
        </section>

        <x-appointment.action-buttons />
        <x-appointment.confirmation-modal />
    </div>

    @push('scripts')
        <script>
            function appointmentBooking(patients, doctor, initialSlots, departments, consultationTypes, priorities, durations) {
                return {
                    patients,
                    doctor,
                    baseSlots: initialSlots,
                    timeSlots: initialSlots,
                    departments,
                    consultationTypes,
                    priorities,
                    durations,
                    patientQuery: '',
                    patientSearchOpen: false,
                    slotsLoading: false,
                    confirmationOpen: false,
                    successMessage: '',
                    conflictMessage: '',
                    errors: {},
                    form: {
                        patient_id: '',
                        patient_name: '',
                        phone: '',
                        date_of_birth: '',
                        gender: 'Female',
                        visit_reason: '',
                        is_new_patient: false,
                        appointment_date: '2026-07-08',
                        selected_time: '',
                        department: departments[0] || 'General Medicine',
                        consultation_type: consultationTypes[0] || 'General Consultation',
                        priority: priorities[0] || 'Normal',
                        duration: durations[1] || '30 Minutes',
                        notes: '',
                    },
                    init() {
                        this.refreshIcons();
                    },
                    refreshIcons() {
                        this.$nextTick(() => {
                            if (window.lucide) {
                                window.lucide.createIcons();
                            }
                        });
                    },
                    get filteredPatients() {
                        const query = this.patientQuery.trim().toLowerCase();

                        return this.patients.filter((patient) => {
                            const haystack = `${patient.id} ${patient.full_name} ${patient.phone}`.toLowerCase();

                            return query !== '' && haystack.includes(query);
                        });
                    },
                    selectPatient(patient) {
                        this.form.patient_id = patient.id;
                        this.form.patient_name = patient.full_name;
                        this.form.phone = patient.phone;
                        this.form.date_of_birth = patient.date_of_birth;
                        this.form.gender = patient.gender;
                        this.form.is_new_patient = false;
                        this.patientQuery = patient.full_name;
                        this.patientSearchOpen = false;
                        delete this.errors.patient_id;
                        delete this.errors.patient_name;
                        delete this.errors.phone;
                    },
                    registerNewPatient() {
                        const seed = Math.floor(1000 + Math.random() * 9000);
                        this.form.patient_id = `NEW-${seed}`;
                        this.form.patient_name = this.patientQuery;
                        this.form.phone = '';
                        this.form.date_of_birth = '';
                        this.form.gender = 'Female';
                        this.form.is_new_patient = true;
                        this.patientSearchOpen = false;
                    },
                    loadTimeSlots() {
                        this.slotsLoading = true;
                        this.form.selected_time = '';
                        this.conflictMessage = '';

                        setTimeout(() => {
                            if (this.form.appointment_date === '2026-07-11') {
                                this.timeSlots = [];
                            } else if (this.form.appointment_date === '2026-07-10') {
                                this.timeSlots = this.baseSlots.map((slot, index) => ({
                                    ...slot,
                                    status: index < 2 ? 'available' : 'booked',
                                    label: index < 2 ? 'Available' : 'Booked',
                                }));
                            } else {
                                this.timeSlots = this.baseSlots;
                            }

                            this.slotsLoading = false;
                            this.refreshIcons();
                        }, 320);
                    },
                    selectTimeSlot(slot) {
                        if (slot.status === 'booked') {
                            this.conflictMessage = `${slot.time} is already booked. Suggested next available slot: ${this.nextAvailableSlot || 'none'}.`;
                            return;
                        }

                        this.form.selected_time = slot.time;
                        this.conflictMessage = '';
                        delete this.errors.selected_time;
                        this.refreshIcons();
                    },
                    get nextAvailableSlot() {
                        return this.timeSlots.find((slot) => slot.status === 'available')?.time || '';
                    },
                    slotButtonClass(slot) {
                        if (slot.status === 'booked') {
                            return 'border-red-100 bg-red-50 text-red-500 opacity-70 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-300';
                        }

                        if (this.form.selected_time === slot.time) {
                            return 'border-[#2F6F3E] bg-[#2F6F3E] text-white shadow-sm ring-4 ring-[#2F6F3E]/10';
                        }

                        return 'border-slate-200 bg-white text-slate-700 hover:border-[#2F6F3E]/40 hover:bg-[#2F6F3E]/5 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800';
                    },
                    get priorityClass() {
                        return {
                            Normal: 'border-slate-200 bg-slate-50 text-slate-700 focus:border-[#2F6F3E] focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800',
                            Urgent: 'border-[#F59E0B]/30 bg-[#F59E0B]/10 text-[#B45309] focus:border-[#F59E0B] focus:ring-[#F59E0B]/10 dark:text-amber-300',
                            Emergency: 'border-[#DC2626]/30 bg-[#DC2626]/10 text-[#DC2626] focus:border-[#DC2626] focus:ring-[#DC2626]/10',
                        }[this.form.priority] || 'border-slate-200 bg-slate-50 text-slate-700';
                    },
                    fieldClass(field) {
                        return this.errors[field]
                            ? 'border border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-500/10 dark:border-red-500/40 dark:bg-red-500/10'
                            : 'border border-slate-200 bg-slate-50 focus:border-[#2F6F3E] focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800';
                    },
                    validate() {
                        this.errors = {};

                        if (! this.form.patient_id) {
                            this.errors.patient_id = 'Please select or register a patient.';
                        }

                        if (! this.form.patient_name) {
                            this.errors.patient_name = 'Patient name is required.';
                        }

                        if (! this.form.phone) {
                            this.errors.phone = 'Phone number is required.';
                        }

                        if (! this.form.visit_reason) {
                            this.errors.visit_reason = 'Visit reason is required.';
                        }

                        if (! this.form.appointment_date) {
                            this.errors.appointment_date = 'Appointment date is required.';
                        }

                        if (! this.form.selected_time) {
                            this.errors.selected_time = 'Please select an available time slot.';
                        }

                        return ! this.hasErrors();
                    },
                    hasErrors() {
                        return Object.keys(this.errors).length > 0;
                    },
                    openConfirmation() {
                        this.successMessage = '';

                        if (! this.validate()) {
                            return;
                        }

                        this.confirmationOpen = true;
                        this.refreshIcons();
                    },
                    confirmAppointment() {
                        this.confirmationOpen = false;
                        this.successMessage = `Appointment confirmed for ${this.form.patient_name} at ${this.form.selected_time}.`;
                        this.refreshIcons();
                    },
                    saveDraft() {
                        this.successMessage = 'Appointment draft saved locally.';
                        this.refreshIcons();
                    },
                    clearForm() {
                        this.patientQuery = '';
                        this.patientSearchOpen = false;
                        this.conflictMessage = '';
                        this.errors = {};
                        this.successMessage = '';
                        this.form = {
                            patient_id: '',
                            patient_name: '',
                            phone: '',
                            date_of_birth: '',
                            gender: 'Female',
                            visit_reason: '',
                            is_new_patient: false,
                            appointment_date: '2026-07-08',
                            selected_time: '',
                            department: this.departments[0] || 'General Medicine',
                            consultation_type: this.consultationTypes[0] || 'General Consultation',
                            priority: this.priorities[0] || 'Normal',
                            duration: this.durations[1] || '30 Minutes',
                            notes: '',
                        };
                        this.timeSlots = this.baseSlots;
                    },
                };
            }
        </script>
    @endpush
</x-layout.app>
