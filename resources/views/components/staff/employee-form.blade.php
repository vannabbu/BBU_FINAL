@props([
    'employee',
    'departments' => [],
    'roles' => [],
    'statuses' => [],
    'employmentTypes' => [],
    'shifts' => [],
    'permissions' => [],
    'mode' => 'create',
])

<form
    x-data="employeeForm(@js($employee), @js($mode))"
    x-on:submit.prevent="submit()"
    class="space-y-6"
>
    <div
        x-cloak
        x-show="saved"
        x-transition
        class="rounded-2xl border border-[#16A34A]/20 bg-[#16A34A]/10 px-4 py-3 text-sm font-extrabold text-[#16A34A]"
    >
        <div class="flex items-center gap-2">
            <i data-lucide="circle-check-big" class="h-4 w-4"></i>
            <span x-text="mode === 'edit' ? 'Employee updated successfully.' : 'Employee saved successfully.'"></span>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_390px]">
        <main class="space-y-6">
            <x-ui.card>
                <div class="mb-5 flex items-start gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#2F6F3E]/10 text-[#2F6F3E]">
                        <i data-lucide="user-round" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">Personal Information</h2>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Employee identity, contact, and demographic information.</p>
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Employee ID</span>
                        <input type="text" x-model.trim="form.id" placeholder="EMP-1007" x-bind:class="fieldClass('id')" class="h-12 w-full rounded-2xl px-4 text-sm font-semibold text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900">
                        <p x-show="errors.id" x-text="errors.id" class="mt-2 text-xs font-bold text-red-600"></p>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Gender</span>
                        <select x-model="form.gender" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
                            <option>Female</option>
                            <option>Male</option>
                            <option>Other</option>
                        </select>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">First Name</span>
                        <input type="text" x-model.trim="form.first_name" placeholder="First name" x-bind:class="fieldClass('first_name')" class="h-12 w-full rounded-2xl px-4 text-sm font-semibold text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900">
                        <p x-show="errors.first_name" x-text="errors.first_name" class="mt-2 text-xs font-bold text-red-600"></p>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Last Name</span>
                        <input type="text" x-model.trim="form.last_name" placeholder="Last name" x-bind:class="fieldClass('last_name')" class="h-12 w-full rounded-2xl px-4 text-sm font-semibold text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900">
                        <p x-show="errors.last_name" x-text="errors.last_name" class="mt-2 text-xs font-bold text-red-600"></p>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Date of Birth</span>
                        <input type="date" x-model="form.date_of_birth" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">National ID</span>
                        <input type="text" x-model.trim="form.national_id" placeholder="KH-00000000" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Phone</span>
                        <input type="text" x-model.trim="form.phone" placeholder="012 345 678" x-bind:class="fieldClass('phone')" class="h-12 w-full rounded-2xl px-4 text-sm font-semibold text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900">
                        <p x-show="errors.phone" x-text="errors.phone" class="mt-2 text-xs font-bold text-red-600"></p>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Email</span>
                        <input type="email" x-model.trim="form.email" placeholder="employee@clinic.test" x-bind:class="fieldClass('email')" class="h-12 w-full rounded-2xl px-4 text-sm font-semibold text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900">
                        <p x-show="errors.email" x-text="errors.email" class="mt-2 text-xs font-bold text-red-600"></p>
                    </label>
                    <label class="block md:col-span-2">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Address</span>
                        <textarea x-model.trim="form.address" rows="3" placeholder="Employee address..." class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold leading-7 text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900"></textarea>
                    </label>
                </div>
            </x-ui.card>

            <x-ui.card>
                <div class="mb-5 flex items-start gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-300">
                        <i data-lucide="briefcase-medical" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">Employment Information</h2>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Department, position, role, salary, shift, and reporting line.</p>
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Department</span>
                        <select x-model="form.department" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
                            @foreach ($departments as $department)
                                <option value="{{ $department }}">{{ $department }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Position</span>
                        <input type="text" x-model.trim="form.position" placeholder="Position" x-bind:class="fieldClass('position')" class="h-12 w-full rounded-2xl px-4 text-sm font-semibold text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900">
                        <p x-show="errors.position" x-text="errors.position" class="mt-2 text-xs font-bold text-red-600"></p>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Role</span>
                        <select x-model="form.role" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
                            @foreach ($roles as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Employment Type</span>
                        <select x-model="form.employment_type" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
                            @foreach ($employmentTypes as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Join Date</span>
                        <input type="date" x-model="form.join_date" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Salary</span>
                        <input type="number" min="0" step="10000" x-model.number="form.salary" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Shift</span>
                        <select x-model="form.shift" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
                            @foreach ($shifts as $shift)
                                <option value="{{ $shift }}">{{ $shift }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Supervisor</span>
                        <input type="text" x-model.trim="form.supervisor" placeholder="Supervisor name" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
                    </label>
                </div>
            </x-ui.card>
        </main>

        <aside class="space-y-6">
            <x-ui.card class="xl:sticky xl:top-24">
                <div class="mb-5 flex items-start gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300">
                        <i data-lucide="shield-check" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">Account Information</h2>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">System user account and permissions.</p>
                    </div>
                </div>

                <div class="space-y-5">
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Status</span>
                        <select x-model="form.status" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
                            @foreach ($statuses as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Username</span>
                        <input type="text" x-model.trim="form.username" placeholder="employee.username" x-bind:class="fieldClass('username')" class="h-12 w-full rounded-2xl px-4 text-sm font-semibold text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900">
                        <p x-show="errors.username" x-text="errors.username" class="mt-2 text-xs font-bold text-red-600"></p>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Password</span>
                        <input type="password" x-model="form.password" placeholder="Password" x-bind:class="fieldClass('password')" class="h-12 w-full rounded-2xl px-4 text-sm font-semibold text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900">
                        <p x-show="errors.password" x-text="errors.password" class="mt-2 text-xs font-bold text-red-600"></p>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Confirm Password</span>
                        <input type="password" x-model="form.password_confirmation" placeholder="Confirm password" x-bind:class="fieldClass('password_confirmation')" class="h-12 w-full rounded-2xl px-4 text-sm font-semibold text-slate-700 outline-none transition focus:bg-white focus:ring-4 dark:text-white dark:focus:bg-slate-900">
                        <p x-show="errors.password_confirmation" x-text="errors.password_confirmation" class="mt-2 text-xs font-bold text-red-600"></p>
                    </label>

                    <div>
                        <p class="mb-3 text-sm font-bold text-slate-700 dark:text-slate-200">Permissions</p>
                        <div class="space-y-2">
                            @foreach ($permissions as $permission)
                                <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-3 transition hover:border-[#2F6F3E]/40 dark:border-slate-700 dark:bg-slate-800">
                                    <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-[#2F6F3E] focus:ring-[#2F6F3E]" x-bind:checked="hasPermission(@js($permission))" x-on:change="togglePermission(@js($permission))">
                                    <span class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $permission }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </x-ui.card>
        </aside>
    </div>

    <div class="sticky bottom-0 z-20 -mx-4 border-t border-[#E5E7EB] bg-white/92 px-4 py-4 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-900/92 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 xl:rounded-t-2xl xl:border xl:shadow-[0_-12px_30px_rgba(15,23,42,0.05)]">
        <div class="mx-auto flex max-w-7xl flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">
                <span x-show="! hasErrors()">Ready to save employee account.</span>
                <span x-show="hasErrors()" class="text-red-600">Please fix validation errors before saving.</span>
            </p>
            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ url('/staff') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-extrabold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                    <i data-lucide="x" class="h-4 w-4"></i>
                    Cancel
                </a>
                <button type="button" x-on:click="resetForm()" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-extrabold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                    <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
                    Reset
                </button>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-[#2F6F3E] px-4 py-3 text-sm font-extrabold text-white shadow-sm transition hover:bg-[#285f35] focus:outline-none focus:ring-4 focus:ring-[#2F6F3E]/20">
                    <i data-lucide="save" class="h-4 w-4"></i>
                    <span x-text="mode === 'edit' ? 'Update Employee' : 'Save Employee'"></span>
                </button>
            </div>
        </div>
    </div>
</form>

@once
    @push('scripts')
        <script>
            function employeeForm(initialEmployee, mode) {
                return {
                    initialEmployee: JSON.parse(JSON.stringify(initialEmployee)),
                    form: JSON.parse(JSON.stringify(initialEmployee)),
                    mode,
                    errors: {},
                    saved: false,
                    fieldClass(field) {
                        return this.errors[field]
                            ? 'border border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-500/10 dark:border-red-500/40 dark:bg-red-500/10'
                            : 'border border-slate-200 bg-slate-50 focus:border-[#2F6F3E] focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800';
                    },
                    validate() {
                        this.errors = {};

                        ['id', 'first_name', 'last_name', 'phone', 'email', 'position', 'username'].forEach((field) => {
                            if (! this.form[field]) {
                                this.errors[field] = 'This field is required.';
                            }
                        });

                        if (this.form.email && ! /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.form.email)) {
                            this.errors.email = 'Please enter a valid email address.';
                        }

                        if (this.mode === 'create' && ! this.form.password) {
                            this.errors.password = 'Password is required for new employees.';
                        }

                        if (this.form.password && this.form.password.length < 8) {
                            this.errors.password = 'Password must be at least 8 characters.';
                        }

                        if (this.form.password !== this.form.password_confirmation) {
                            this.errors.password_confirmation = 'Passwords do not match.';
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

                        this.form.full_name = `${this.form.first_name} ${this.form.last_name}`.trim();
                        this.saved = true;
                        this.initialEmployee = JSON.parse(JSON.stringify(this.form));

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
                        this.form = JSON.parse(JSON.stringify(this.initialEmployee));
                        this.errors = {};
                        this.saved = false;
                    },
                    hasPermission(permission) {
                        return (this.form.permissions || []).includes(permission);
                    },
                    togglePermission(permission) {
                        const permissions = this.form.permissions || [];

                        if (permissions.includes(permission)) {
                            this.form.permissions = permissions.filter((item) => item !== permission);
                        } else {
                            this.form.permissions = [...permissions, permission];
                        }
                    },
                };
            }
        </script>
    @endpush
@endonce
