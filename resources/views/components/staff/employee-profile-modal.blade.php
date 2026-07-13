<div x-cloak x-show="profileOpen" x-transition.opacity class="fixed inset-0 z-50 flex items-end justify-center bg-slate-950/50 p-4 sm:items-center">
    <div
        x-show="profileOpen"
        x-transition.scale.origin.bottom
        x-on:click.outside="profileOpen = false"
        class="max-h-[92vh] w-full max-w-5xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl dark:border-slate-700 dark:bg-slate-900"
    >
        <div class="flex items-start justify-between gap-4 border-b border-slate-100 p-5 dark:border-slate-800 sm:p-6">
            <div class="flex items-center gap-4">
                <img x-bind:src="selectedEmployee?.avatar" x-bind:alt="selectedEmployee?.full_name" class="h-16 w-16 rounded-2xl object-cover">
                <div>
                    <p class="text-xs font-extrabold text-[#2F6F3E]" x-text="selectedEmployee?.id"></p>
                    <h2 class="mt-1 text-2xl font-extrabold text-slate-950 dark:text-white" x-text="selectedEmployee?.full_name"></h2>
                    <p class="mt-1 text-sm font-semibold text-slate-500 dark:text-slate-400" x-text="selectedEmployee?.position + ' • ' + selectedEmployee?.department"></p>
                </div>
            </div>
            <button type="button" x-on:click="profileOpen = false" class="rounded-xl p-2 text-slate-400 transition hover:bg-slate-100 dark:hover:bg-slate-800" aria-label="Close profile modal">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <div class="max-h-[calc(92vh-110px)] overflow-y-auto p-5 sm:p-6">
            <div class="grid gap-5 lg:grid-cols-2">
                <section class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/50">
                    <h3 class="font-extrabold text-slate-950 dark:text-white">Personal Information</h3>
                    <dl class="mt-4 grid gap-3 text-sm">
                        <div class="flex justify-between gap-3"><dt class="font-bold text-slate-500">Employee ID</dt><dd class="font-extrabold text-slate-900 dark:text-white" x-text="selectedEmployee?.id"></dd></div>
                        <div class="flex justify-between gap-3"><dt class="font-bold text-slate-500">Gender</dt><dd class="font-extrabold text-slate-900 dark:text-white" x-text="selectedEmployee?.gender"></dd></div>
                        <div class="flex justify-between gap-3"><dt class="font-bold text-slate-500">Date of Birth</dt><dd class="font-extrabold text-slate-900 dark:text-white" x-text="selectedEmployee?.date_of_birth"></dd></div>
                        <div class="flex justify-between gap-3"><dt class="font-bold text-slate-500">National ID</dt><dd class="font-extrabold text-slate-900 dark:text-white" x-text="selectedEmployee?.national_id"></dd></div>
                    </dl>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/50">
                    <h3 class="font-extrabold text-slate-950 dark:text-white">Employment Information</h3>
                    <dl class="mt-4 grid gap-3 text-sm">
                        <div class="flex justify-between gap-3"><dt class="font-bold text-slate-500">Department</dt><dd class="font-extrabold text-slate-900 dark:text-white" x-text="selectedEmployee?.department"></dd></div>
                        <div class="flex justify-between gap-3"><dt class="font-bold text-slate-500">Position</dt><dd class="font-extrabold text-slate-900 dark:text-white" x-text="selectedEmployee?.position"></dd></div>
                        <div class="flex justify-between gap-3"><dt class="font-bold text-slate-500">Role</dt><dd><x-staff.role-badge dynamic x-text="selectedEmployee?.role" x-bind:class="roleClass(selectedEmployee?.role)" /></dd></div>
                        <div class="flex justify-between gap-3"><dt class="font-bold text-slate-500">Join Date</dt><dd class="font-extrabold text-slate-900 dark:text-white" x-text="selectedEmployee?.join_date"></dd></div>
                        <div class="flex justify-between gap-3"><dt class="font-bold text-slate-500">Employment Status</dt><dd><x-staff.status-badge dynamic x-text="selectedEmployee?.status_label" x-bind:class="statusClass(selectedEmployee?.status)" /></dd></div>
                    </dl>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/50">
                    <h3 class="font-extrabold text-slate-950 dark:text-white">Contact Information</h3>
                    <dl class="mt-4 grid gap-3 text-sm">
                        <div><dt class="font-bold text-slate-500">Phone</dt><dd class="mt-1 font-extrabold text-slate-900 dark:text-white" x-text="selectedEmployee?.phone"></dd></div>
                        <div><dt class="font-bold text-slate-500">Email</dt><dd class="mt-1 break-all font-extrabold text-slate-900 dark:text-white" x-text="selectedEmployee?.email"></dd></div>
                        <div><dt class="font-bold text-slate-500">Address</dt><dd class="mt-1 font-extrabold text-slate-900 dark:text-white" x-text="selectedEmployee?.address"></dd></div>
                        <div><dt class="font-bold text-slate-500">Emergency Contact</dt><dd class="mt-1 font-extrabold text-slate-900 dark:text-white" x-text="selectedEmployee?.emergency_contact"></dd></div>
                    </dl>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/50">
                    <h3 class="font-extrabold text-slate-950 dark:text-white">System Information</h3>
                    <dl class="mt-4 grid gap-3 text-sm">
                        <div class="flex justify-between gap-3"><dt class="font-bold text-slate-500">Username</dt><dd class="font-extrabold text-slate-900 dark:text-white" x-text="selectedEmployee?.username"></dd></div>
                        <div class="flex justify-between gap-3"><dt class="font-bold text-slate-500">Last Login</dt><dd class="font-extrabold text-slate-900 dark:text-white" x-text="selectedEmployee?.last_login"></dd></div>
                        <div class="flex justify-between gap-3"><dt class="font-bold text-slate-500">Account Status</dt><dd class="font-extrabold text-slate-900 dark:text-white" x-text="selectedEmployee?.account_status"></dd></div>
                    </dl>
                    <div class="mt-4">
                        <p class="text-sm font-bold text-slate-500">Assigned Permissions</p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <template x-for="permission in selectedEmployee?.permissions || []" :key="permission">
                                <span class="rounded-full bg-[#2F6F3E]/10 px-3 py-1.5 text-xs font-extrabold text-[#2F6F3E]" x-text="permission"></span>
                            </template>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
