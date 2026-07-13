<x-layout.app title="Add Patient Measurement" :navigation="$navigation" :doctor="$doctor">
    <x-layout.breadcrumb :items="[
        ['label' => 'ទំព័រដើម', 'href' => route('dashboard')],
        ['label' => 'មន្ទីរពិសោធន៍', 'href' => route('diagnosis-reports.index')],
        ['label' => 'Add Patient Measurement', 'href' => null],
    ]" />

    <x-layout.page-header
        title="Add Patient Measurement"
        subtitle="Record patient vital signs, clinical observations, and visit information."
    >
        <button type="button" x-data x-on:click="$dispatch('measurement-save-draft')" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-extrabold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
            <i data-lucide="save" class="h-4 w-4"></i>
            Save as Draft
        </button>
        <button type="button" x-data x-on:click="$dispatch('measurement-save')" class="inline-flex items-center gap-2 rounded-2xl bg-[#2F6F3E] px-4 py-2.5 text-sm font-extrabold text-white shadow-sm transition hover:bg-[#285f35]">
            <i data-lucide="badge-check" class="h-4 w-4"></i>
            Save Measurement
        </button>
    </x-layout.page-header>

    <div
        x-data="patientMeasurement(@js($patients), @js($visit), @js($history))"
        x-init="init()"
        x-on:measurement-save.window="openConfirmation()"
        x-on:measurement-save-draft.window="saveDraft()"
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
                <x-measurement.patient-card
                    :recent-patients="$recentPatients"
                    :visit="$visit"
                    :departments="$departments"
                    :doctors="$doctors"
                />

                <div class="xl:hidden">
                    <x-measurement.summary-card />
                </div>

                <x-measurement.vital-signs-card :pain-scale="$painScale" />
                <x-measurement.health-status />
                <x-measurement.clinical-notes />
                <x-measurement.attachment-upload />
                <x-measurement.measurement-history />
            </main>

            <aside class="hidden xl:block">
                <x-measurement.summary-card />
            </aside>
        </section>

        <x-measurement.action-buttons />
        <x-measurement.confirmation-dialog />
    </div>

    @push('scripts')
        <script>
            function patientMeasurement(patients, initialVisit, initialHistory) {
                return {
                    patients,
                    selectedPatient: null,
                    patientQuery: '',
                    patientSearchOpen: false,
                    visit: JSON.parse(JSON.stringify(initialVisit)),
                    initialVisit: JSON.parse(JSON.stringify(initialVisit)),
                    history: [],
                    initialHistory,
                    historyLoading: true,
                    attachments: [],
                    dirty: false,
                    confirmationOpen: false,
                    successMessage: '',
                    errors: {},
                    vitals: {
                        systolic: '',
                        diastolic: '',
                        heart_rate: '',
                        respiratory_rate: '',
                        temperature: '',
                        oxygen_saturation: '',
                        weight: '',
                        height: '',
                        pain_scale: 0,
                        blood_glucose: '',
                        pulse: '',
                    },
                    notes: {
                        primary_diagnosis: '',
                        chief_complaint: '',
                        clinical_observation: '',
                        symptoms: '',
                        doctor_notes: '',
                        follow_up: '',
                    },
                    statusIndicators: [],
                    init() {
                        setTimeout(() => {
                            this.history = this.initialHistory;
                            this.historyLoading = false;
                            this.refreshIcons();
                        }, 350);

                        window.addEventListener('beforeunload', (event) => {
                            if (! this.dirty) {
                                return;
                            }

                            event.preventDefault();
                            event.returnValue = '';
                        });
                    },
                    refreshIcons() {
                        this.$nextTick(() => {
                            if (window.lucide) {
                                window.lucide.createIcons();
                            }
                        });
                    },
                    markDirty() {
                        this.dirty = true;
                        this.successMessage = '';
                    },
                    get filteredPatients() {
                        const query = this.patientQuery.trim().toLowerCase();

                        return this.patients.filter((patient) => {
                            const haystack = `${patient.id} ${patient.full_name} ${patient.phone}`.toLowerCase();

                            return query !== '' && haystack.includes(query);
                        });
                    },
                    selectPatient(patient) {
                        this.selectedPatient = patient;
                        this.patientQuery = patient.full_name;
                        this.patientSearchOpen = false;
                        this.visit.id = patient.visit_id;
                        this.vitals.height = patient.height;
                        this.vitals.weight = patient.weight;
                        this.calculateBmi();
                        this.markDirty();
                        delete this.errors.patient;
                        this.refreshIcons();
                    },
                    simulateQrLookup() {
                        this.selectPatient(this.patients[0]);
                    },
                    calculateBmi() {
                        const weight = Number(this.vitals.weight);
                        const heightCm = Number(this.vitals.height);

                        if (! weight || ! heightCm) {
                            return;
                        }

                        this.detectHealthStatus();
                    },
                    get bmi() {
                        const weight = Number(this.vitals.weight);
                        const heightCm = Number(this.vitals.height);

                        if (! weight || ! heightCm) {
                            return '';
                        }

                        const heightM = heightCm / 100;

                        return (weight / (heightM * heightM)).toFixed(1);
                    },
                    get recordedVitalCount() {
                        return Object.entries(this.vitals).filter(([key, value]) => {
                            if (key === 'pain_scale') {
                                return Number(value) > 0;
                            }

                            return value !== '' && value !== null;
                        }).length;
                    },
                    get abnormalFindings() {
                        return this.statusIndicators
                            .filter((indicator) => indicator.tone !== 'success')
                            .map((indicator) => indicator.label);
                    },
                    detectHealthStatus() {
                        const indicators = [];
                        const systolic = Number(this.vitals.systolic);
                        const diastolic = Number(this.vitals.diastolic);
                        const temperature = Number(this.vitals.temperature);
                        const spo2 = Number(this.vitals.oxygen_saturation);
                        const heartRate = Number(this.vitals.heart_rate);
                        const pain = Number(this.vitals.pain_scale);
                        const bmi = Number(this.bmi);

                        if (systolic || diastolic) {
                            if (systolic >= 140 || diastolic >= 90) {
                                indicators.push({ label: 'High Blood Pressure', message: 'Blood pressure is above normal clinical range.', tone: 'danger', icon: 'triangle-alert' });
                            } else if (systolic >= 121 || diastolic >= 81) {
                                indicators.push({ label: 'Elevated', message: 'Blood pressure is slightly elevated.', tone: 'warning', icon: 'circle-alert' });
                            } else {
                                indicators.push({ label: 'Normal Blood Pressure', message: 'Blood pressure is within expected range.', tone: 'success', icon: 'circle-check-big' });
                            }
                        }

                        if (temperature) {
                            if (temperature >= 38) {
                                indicators.push({ label: 'Fever', message: 'Temperature indicates fever.', tone: 'danger', icon: 'thermometer-sun' });
                            } else {
                                indicators.push({ label: 'Normal Temperature', message: 'Temperature is within normal range.', tone: 'success', icon: 'circle-check-big' });
                            }
                        }

                        if (spo2) {
                            if (spo2 < 95) {
                                indicators.push({ label: 'Low Oxygen', message: 'SpO2 is below the recommended threshold.', tone: 'danger', icon: 'activity' });
                            } else {
                                indicators.push({ label: 'Normal Oxygen', message: 'Oxygen saturation is within normal range.', tone: 'success', icon: 'circle-check-big' });
                            }
                        }

                        if (heartRate) {
                            if (heartRate < 60 || heartRate > 100) {
                                indicators.push({ label: 'Heart Rate Alert', message: 'Heart rate is outside normal adult range.', tone: 'warning', icon: 'heart-pulse' });
                            }
                        }

                        if (pain >= 7) {
                            indicators.push({ label: 'Severe Pain', message: 'Pain scale indicates urgent comfort assessment.', tone: 'danger', icon: 'siren' });
                        }

                        if (bmi && (bmi < 18.5 || bmi >= 30)) {
                            indicators.push({ label: 'BMI Alert', message: 'BMI is outside standard healthy range.', tone: 'warning', icon: 'scale' });
                        }

                        this.statusIndicators = indicators;
                        this.refreshIcons();
                    },
                    validateField(field, optional = false) {
                        if (optional && (this.vitals[field] === '' || this.vitals[field] === null)) {
                            delete this.errors[field];
                            return;
                        }

                        if (this.vitals[field] === '' || this.vitals[field] === null) {
                            this.errors[field] = 'This vital sign is required.';
                        } else if (Number(this.vitals[field]) < 0) {
                            this.errors[field] = 'Value must be a positive number.';
                        } else {
                            delete this.errors[field];
                        }
                    },
                    validate() {
                        this.errors = {};

                        if (! this.selectedPatient) {
                            this.errors.patient = 'Please select a patient.';
                        }

                        ['systolic', 'diastolic', 'heart_rate', 'respiratory_rate', 'temperature', 'oxygen_saturation', 'weight', 'height'].forEach((field) => {
                            this.validateField(field, false);
                        });

                        if (Number(this.vitals.systolic) < Number(this.vitals.diastolic)) {
                            this.errors.systolic = 'Systolic should be higher than diastolic.';
                        }

                        return ! this.hasErrors();
                    },
                    hasErrors() {
                        return Object.keys(this.errors).length > 0;
                    },
                    fieldClass(field) {
                        return this.errors[field]
                            ? 'border border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-500/10 dark:border-red-500/40 dark:bg-red-500/10'
                            : 'border border-slate-200 bg-slate-50 focus:border-[#2F6F3E] focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800';
                    },
                    indicatorClass(tone) {
                        return {
                            success: 'border-[#16A34A]/20 bg-[#16A34A]/10 text-[#166534]',
                            warning: 'border-[#F59E0B]/20 bg-[#F59E0B]/10 text-[#B45309] dark:text-amber-300',
                            danger: 'border-[#DC2626]/20 bg-[#DC2626]/10 text-[#DC2626]',
                            info: 'border-[#2563EB]/20 bg-[#2563EB]/10 text-[#2563EB]',
                        }[tone] || 'border-slate-200 bg-slate-100 text-slate-700';
                    },
                    trendClass(trend) {
                        return {
                            stable: 'bg-[#16A34A]/10 text-[#16A34A]',
                            up: 'bg-[#F59E0B]/10 text-[#B45309] dark:text-amber-300',
                            down: 'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-300',
                        }[trend] || 'bg-slate-100 text-slate-700';
                    },
                    trendIcon(trend) {
                        return {
                            stable: 'minus',
                            up: 'trending-up',
                            down: 'trending-down',
                        }[trend] || 'activity';
                    },
                    handleFiles(event) {
                        const files = Array.from(event.target.files || []);

                        files.forEach((file) => {
                            this.attachments.push({
                                id: `${file.name}-${file.size}-${Date.now()}`,
                                name: file.name,
                                size: `${(file.size / 1024).toFixed(1)} KB`,
                                icon: file.type.includes('image') ? 'image' : (file.type.includes('pdf') ? 'file-text' : 'file-plus-2'),
                            });
                        });

                        this.markDirty();
                        this.refreshIcons();
                    },
                    removeFile(id) {
                        this.attachments = this.attachments.filter((file) => file.id !== id);
                        this.markDirty();
                    },
                    openConfirmation() {
                        this.successMessage = '';

                        if (! this.validate()) {
                            return;
                        }

                        this.confirmationOpen = true;
                        this.refreshIcons();
                    },
                    saveMeasurement() {
                        this.confirmationOpen = false;
                        this.dirty = false;
                        this.successMessage = `Measurement saved for ${this.selectedPatient.full_name}.`;
                        this.refreshIcons();
                    },
                    saveDraft() {
                        this.dirty = false;
                        this.successMessage = 'Measurement draft saved locally.';
                        this.refreshIcons();
                    },
                    resetForm() {
                        this.vitals = {
                            systolic: '',
                            diastolic: '',
                            heart_rate: '',
                            respiratory_rate: '',
                            temperature: '',
                            oxygen_saturation: '',
                            weight: this.selectedPatient?.weight || '',
                            height: this.selectedPatient?.height || '',
                            pain_scale: 0,
                            blood_glucose: '',
                            pulse: '',
                        };
                        this.notes = {
                            primary_diagnosis: '',
                            chief_complaint: '',
                            clinical_observation: '',
                            symptoms: '',
                            doctor_notes: '',
                            follow_up: '',
                        };
                        this.visit = JSON.parse(JSON.stringify(this.initialVisit));
                        this.errors = {};
                        this.statusIndicators = [];
                        this.attachments = [];
                        this.successMessage = '';
                        this.dirty = false;
                    },
                };
            }
        </script>
    @endpush
</x-layout.app>
