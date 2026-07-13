<x-layout.app title="Billing Management" :navigation="$navigation" :doctor="$doctor">
    <x-layout.breadcrumb :items="[
        ['label' => 'ទំព័រដើម', 'href' => route('dashboard')],
        ['label' => 'វិក្កយបត្រ', 'href' => route('invoices.index')],
        ['label' => 'Billing Management', 'href' => null],
    ]" />

    <x-layout.page-header
        title="Billing Management"
        subtitle="Manage patient invoices, services, medicine bills, and payments"
    >
        <x-ui.badge label="Active Invoice" tone="green" icon="badge-check" />
    </x-layout.page-header>

    <div
        x-data="billingPage(@js($medicines), @js($medicineCatalog), @js($services), @js($taxRate), @js($discount))"
        x-init="init()"
        class="mt-6 space-y-6"
    >
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-6">
            <x-billing.info-card label="Invoice Number" :value="$invoice['number']" icon="receipt-text" tone="green" note="លេខវិក្កយបត្រ" />
            <x-billing.info-card label="Patient Name" :value="$invoice['patient_name']" icon="user-round" tone="blue" note="អ្នកជំងឺ" />
            <x-billing.info-card label="Doctor Name" :value="$invoice['doctor_name']" icon="stethoscope" tone="green" note="វេជ្ជបណ្ឌិត" />
            <x-billing.info-card label="Room / Ward" :value="$invoice['room']" icon="bed-double" tone="violet" note="បន្ទប់ / វួដ" />
            <x-billing.info-card label="Visit Date" :value="$invoice['visit_date']" icon="calendar-days" tone="slate" note="ថ្ងៃពិនិត្យ" />
            <x-billing.info-card label="Payment Status" :value="$invoice['payment_status_kh']" icon="wallet-cards" tone="amber" :note="$invoice['payment_status']" />
        </section>

        <section class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_380px]">
            <main class="min-w-0 space-y-6">
                <x-billing.medicine-table />

                <x-ui.card>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">ជ្រើសរើសសេវាវេជ្ជសាស្ត្រ</h2>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Select medical services to include in this invoice</p>
                        </div>
                        <x-ui.badge tone="blue" icon="check-circle-2">
                            <span x-text="selectedServices.length"></span> selected
                        </x-ui.badge>
                    </div>

                    <div class="mt-5 grid gap-4 md:grid-cols-2 2xl:grid-cols-3">
                        @foreach ($services as $service)
                            <x-billing.service-card :service="$service" />
                        @endforeach
                    </div>
                </x-ui.card>
            </main>

            <aside class="space-y-6">
                <x-billing.payment-summary />
                <x-billing.recent-invoices :invoices="$recentInvoices" />
            </aside>
        </section>
    </div>

    @push('scripts')
        <script>
            function billingPage(initialMedicines, medicineCatalog, initialServices, taxRate, discount) {
                return {
                    medicines: initialMedicines,
                    medicineCatalog,
                    services: initialServices,
                    taxRate,
                    discount,
                    medicineSearch: '',
                    paymentStatus: 'idle',
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
                    get filteredCatalog() {
                        const query = this.medicineSearch.trim().toLowerCase();

                        return this.medicineCatalog.filter((medicine) => {
                            const matchesQuery = query === '' || medicine.name.toLowerCase().includes(query) || medicine.id.toLowerCase().includes(query);

                            return matchesQuery;
                        });
                    },
                    addFirstSearchResult() {
                        this.addMedicine(this.filteredCatalog[0]);
                    },
                    addMedicine(item) {
                        if (! item) {
                            return;
                        }

                        const existing = this.medicines.find((medicine) => medicine.id === item.id);

                        if (existing) {
                            existing.quantity += 1;
                        } else {
                            this.medicines.push({
                                id: item.id,
                                name: item.name,
                                unit_price: item.unit_price,
                                quantity: 1,
                            });
                        }

                        this.medicineSearch = '';
                        this.refreshIcons();
                    },
                    removeMedicine(id) {
                        this.medicines = this.medicines.filter((medicine) => medicine.id !== id);
                        this.refreshIcons();
                    },
                    lineSubtotal(medicine) {
                        const quantity = Math.max(1, Number(medicine.quantity || 1));

                        return medicine.unit_price * quantity;
                    },
                    get medicineTotal() {
                        return this.medicines.reduce((total, medicine) => total + this.lineSubtotal(medicine), 0);
                    },
                    get selectedServices() {
                        return this.services.filter((service) => service.selected);
                    },
                    serviceSelected(id) {
                        return this.services.some((service) => service.id === id && service.selected);
                    },
                    toggleService(id) {
                        this.services = this.services.map((service) => service.id === id ? { ...service, selected: ! service.selected } : service);
                        this.refreshIcons();
                    },
                    get serviceTotal() {
                        return this.selectedServices.reduce((total, service) => total + service.price, 0);
                    },
                    get taxTotal() {
                        return Math.round((this.medicineTotal + this.serviceTotal) * this.taxRate);
                    },
                    get grandTotal() {
                        return Math.max(0, this.medicineTotal + this.serviceTotal + this.taxTotal - Number(this.discount || 0));
                    },
                    money(value) {
                        return `${new Intl.NumberFormat('en-US').format(Math.max(0, Math.round(Number(value) || 0)))} ៛`;
                    },
                };
            }
        </script>
    @endpush
</x-layout.app>
