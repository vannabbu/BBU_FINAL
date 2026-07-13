@extends('layouts.doctor-dashboard')

@section('title', 'ផ្ទាំងគ្រប់គ្រង | កំណត់ប្រវត្តិវេជ្ជបណ្ឌិត')
@section('page-title', 'កំណត់ប្រវត្តិវេជ្ជបណ្ឌិត')

@section('content')
    <div x-data="{ criticalAlerts: true, routineNotes: true, diagnosticFindings: false }" class="mx-auto max-w-7xl space-y-6">
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="h-24 bg-gradient-to-r from-[#2f6f3e] via-[#3f8750] to-[#9fc7a6]"></div>
            <div class="flex flex-col gap-5 px-5 pb-5 sm:px-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="-mt-10 flex flex-col gap-4 sm:flex-row sm:items-end">
                    <img src="{{ $doctor['avatar'] }}" alt="{{ $doctor['name'] }}" class="h-24 w-24 rounded-2xl border-4 border-white object-cover shadow-sm">
                    <div class="pb-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="text-2xl font-extrabold text-slate-950">{{ $doctor['name'] }}</h2>
                            <span class="rounded-full bg-[#2f6f3e]/10 px-3 py-1 text-xs font-bold text-[#2f6f3e]">{{ $doctor['status'] }}</span>
                        </div>
                        <div class="mt-2 flex flex-wrap gap-x-5 gap-y-2 text-sm text-slate-500">
                            <span>{{ $doctor['specialty'] }}</span>
                            <span>{{ $doctor['department'] }}</span>
                            <span>{{ $doctor['location'] }}</span>
                        </div>
                    </div>
                </div>
                <button type="button" class="inline-flex items-center justify-center rounded-xl border border-[#2f6f3e]/20 bg-white px-4 py-2.5 text-sm font-bold text-[#2f6f3e] shadow-sm hover:bg-[#2f6f3e]/5">
                    កែប្រែប្រវត្តិ
                </button>
            </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
            <div class="space-y-6">
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="border-b border-slate-100 pb-5">
                        <h3 class="text-lg font-extrabold text-slate-950">ព័ត៌មានគណនីវេជ្ជបណ្ឌិត</h3>
                        <p class="mt-1 text-sm text-slate-500">កែប្រែព័ត៌មានទំនាក់ទំនង និងព័ត៌មានប្រចាំថ្ងៃរបស់វេជ្ជបណ្ឌិត។</p>
                    </div>

                    <form class="mt-6 grid gap-5 md:grid-cols-2">
                        <label class="block">
                            <span class="text-sm font-bold text-slate-700">ឈ្មោះ</span>
                            <input value="{{ $doctor['name'] }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#2f6f3e] focus:ring-4 focus:ring-[#2f6f3e]/10">
                        </label>
                        <label class="block">
                            <span class="text-sm font-bold text-slate-700">អ៊ីមែល</span>
                            <input type="email" value="{{ $doctor['email'] }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#2f6f3e] focus:ring-4 focus:ring-[#2f6f3e]/10">
                        </label>
                        <label class="block">
                            <span class="text-sm font-bold text-slate-700">លេខទូរស័ព្ទ</span>
                            <input value="{{ $doctor['phone'] }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#2f6f3e] focus:ring-4 focus:ring-[#2f6f3e]/10">
                        </label>
                        <label class="block">
                            <span class="text-sm font-bold text-slate-700">លេខសម្គាល់វេជ្ជបណ្ឌិត</span>
                            <input value="{{ $doctor['doctor_id'] }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500 outline-none" readonly>
                        </label>
                        <label class="block md:col-span-2">
                            <span class="text-sm font-bold text-slate-700">អាសយដ្ឋាន</span>
                            <input value="{{ $doctor['address'] }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#2f6f3e] focus:ring-4 focus:ring-[#2f6f3e]/10">
                        </label>
                        <label class="block md:col-span-2">
                            <span class="text-sm font-bold text-slate-700">ទំនាក់ទំនងបន្ទាន់</span>
                            <input value="{{ $doctor['emergency_contact'] }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#2f6f3e] focus:ring-4 focus:ring-[#2f6f3e]/10">
                        </label>
                        <label class="block md:col-span-2">
                            <span class="text-sm font-bold text-slate-700">កំណត់ចំណាំ</span>
                            <textarea rows="4" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#2f6f3e] focus:ring-4 focus:ring-[#2f6f3e]/10">{{ $doctor['notes'] }}</textarea>
                        </label>
                    </form>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="border-b border-slate-100 pb-5">
                        <h3 class="text-lg font-extrabold text-slate-950">លិខិតបញ្ជាក់វិជ្ជាជីវៈ</h3>
                        <p class="mt-1 text-sm text-slate-500">ព័ត៌មានឯកទេស អាជ្ញាបណ្ណវេជ្ជសាស្ត្រ និងគុណវុឌ្ឍិ។</p>
                    </div>

                    <div class="mt-6 grid gap-5 md:grid-cols-3">
                        <label class="block">
                            <span class="text-sm font-bold text-slate-700">ឯកទេស</span>
                            <select class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#2f6f3e] focus:ring-4 focus:ring-[#2f6f3e]/10">
                                @foreach ($specialties as $specialty)
                                    <option @selected($specialty === $doctor['specialty'])>{{ $specialty }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block">
                            <span class="text-sm font-bold text-slate-700">លេខអាជ្ញាបណ្ណវេជ្ជសាស្ត្រ</span>
                            <input value="{{ $doctor['license'] }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#2f6f3e] focus:ring-4 focus:ring-[#2f6f3e]/10">
                        </label>
                        <label class="block">
                            <span class="text-sm font-bold text-slate-700">គុណវុឌ្ឍិ</span>
                            <input value="{{ $doctor['qualification'] }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#2f6f3e] focus:ring-4 focus:ring-[#2f6f3e]/10">
                        </label>
                    </div>
                </section>

                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <button type="button" class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50">បោះបង់</button>
                    <button type="button" class="rounded-xl bg-[#2f6f3e] px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-[#285f35]">រក្សាទុកការផ្លាស់ប្តូរ</button>
                </div>
            </div>

            <aside class="space-y-6">
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <h3 class="text-lg font-extrabold text-slate-950">ការកំណត់ជូនដំណឹង</h3>
                    <p class="mt-1 text-sm text-slate-500">គ្រប់គ្រងការជូនដំណឹងសម្រាប់ការថែទាំអ្នកជំងឺ។</p>

                    <div class="mt-6 space-y-4">
                        <div class="flex items-start justify-between gap-4 rounded-2xl border border-slate-100 p-4">
                            <div>
                                <p class="font-bold text-slate-900">ការជូនដំណឹងបន្ទាន់</p>
                                <p class="mt-1 text-sm leading-6 text-slate-500">សម្រាប់ស្ថានភាពធ្ងន់ធ្ងរ និងសញ្ញាព្រមាន។</p>
                            </div>
                            <button type="button" x-on:click="criticalAlerts = !criticalAlerts" x-bind:class="criticalAlerts ? 'bg-[#2f6f3e]' : 'bg-slate-200'" class="relative h-7 w-12 shrink-0 rounded-full transition">
                                <span x-bind:class="criticalAlerts ? 'translate-x-6' : 'translate-x-1'" class="absolute top-1 h-5 w-5 rounded-full bg-white shadow transition"></span>
                            </button>
                        </div>

                        <div class="flex items-start justify-between gap-4 rounded-2xl border border-slate-100 p-4">
                            <div>
                                <p class="font-bold text-slate-900">កំណត់ចំណាំ និងពិនិត្យប្រចាំថ្ងៃ</p>
                                <p class="mt-1 text-sm leading-6 text-slate-500">រំលឹកការតាមដានអ្នកជំងឺ និងការចូលពិនិត្យ។</p>
                            </div>
                            <button type="button" x-on:click="routineNotes = !routineNotes" x-bind:class="routineNotes ? 'bg-[#2f6f3e]' : 'bg-slate-200'" class="relative h-7 w-12 shrink-0 rounded-full transition">
                                <span x-bind:class="routineNotes ? 'translate-x-6' : 'translate-x-1'" class="absolute top-1 h-5 w-5 rounded-full bg-white shadow transition"></span>
                            </button>
                        </div>

                        <div class="flex items-start justify-between gap-4 rounded-2xl border border-slate-100 p-4">
                            <div>
                                <p class="font-bold text-slate-900">លទ្ធផលវិភាគថ្មី</p>
                                <p class="mt-1 text-sm leading-6 text-slate-500">ជូនដំណឹងពេលមានលទ្ធផលមន្ទីរពិសោធន៍ថ្មី។</p>
                            </div>
                            <button type="button" x-on:click="diagnosticFindings = !diagnosticFindings" x-bind:class="diagnosticFindings ? 'bg-[#2f6f3e]' : 'bg-slate-200'" class="relative h-7 w-12 shrink-0 rounded-full transition">
                                <span x-bind:class="diagnosticFindings ? 'translate-x-6' : 'translate-x-1'" class="absolute top-1 h-5 w-5 rounded-full bg-white shadow transition"></span>
                            </button>
                        </div>
                    </div>
                </section>

                <section class="rounded-2xl border border-[#2f6f3e]/15 bg-[#2f6f3e] p-5 text-white shadow-sm sm:p-6">
                    <p class="text-sm font-semibold text-white/75">ស្ថានភាពប្រវត្តិ</p>
                    <h3 class="mt-2 text-2xl font-extrabold">បានធ្វើបច្ចុប្បន្នភាព</h3>
                    <p class="mt-3 text-sm leading-6 text-white/80">ព័ត៌មានវេជ្ជបណ្ឌិត និងការកំណត់ជូនដំណឹងត្រូវបានរៀបចំសម្រាប់ការប្រើប្រាស់ប្រចាំថ្ងៃ។</p>
                </section>
            </aside>
        </div>
    </div>
@endsection
