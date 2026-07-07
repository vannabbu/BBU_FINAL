@extends('layouts.clinic')

@section('title', 'ផ្ទាំងគ្រប់គ្រង | PRUM SANTEPHEAP CLINIC')
@section('page-title', 'ផ្ទាំងគ្រប់គ្រង')

@section('content')
    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $stat)
            <article class="rounded-lg border border-emerald-100 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-emerald-700">{{ $stat['label'] }}</p>
                <p class="mt-3 text-3xl font-bold text-emerald-950">{{ $stat['value'] }}</p>
                <p class="mt-2 text-sm text-gray-500">{{ $stat['caption'] }}</p>
            </article>
        @endforeach
    </section>

    <section class="mt-6 grid gap-4 lg:grid-cols-3">
        <div class="rounded-lg border border-emerald-100 bg-white p-5 shadow-sm lg:col-span-2">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-emerald-950">ការណាត់ជួបថ្មីៗ</h2>
                    <p class="text-sm text-gray-500">បង្ហាញកំណត់ត្រាចុងក្រោយពីតារាងណាត់ជួប</p>
                </div>
                <a href="#" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">បង្កើតថ្មី</a>
            </div>

            <div class="mt-5 overflow-hidden rounded-lg border border-emerald-100">
                <table class="min-w-full divide-y divide-emerald-100 text-left text-sm">
                    <thead class="bg-emerald-50 text-emerald-900">
                        <tr>
                            <th class="px-4 py-3 font-semibold">អ្នកជំងឺ</th>
                            <th class="px-4 py-3 font-semibold">វេជ្ជបណ្ឌិត</th>
                            <th class="px-4 py-3 font-semibold">ថ្ងៃម៉ោង</th>
                            <th class="px-4 py-3 font-semibold">ស្ថានភាព</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-emerald-50 bg-white">
                        @forelse ($appointments as $appointment)
                            @php
                                $status = [
                                    'pending' => 'រង់ចាំ',
                                    'approved' => 'បានអនុម័ត',
                                    'cancelled' => 'បានបោះបង់',
                                ][$appointment->status] ?? $appointment->status;
                            @endphp
                            <tr>
                                <td class="px-4 py-3 text-gray-800">{{ $appointment->patient?->name ?? 'មិនមានទិន្នន័យ' }}</td>
                                <td class="px-4 py-3 text-gray-800">{{ $appointment->doctor?->name ?? 'មិនមានទិន្នន័យ' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $appointment->appointment_date?->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">{{ $status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-6 text-center text-gray-500" colspan="4">មិនទាន់មានការណាត់ជួប</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-lg border border-emerald-100 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-bold text-emerald-950">ស្ថានភាពប្រតិបត្តិការ</h2>
            <div class="mt-5 space-y-4">
                @foreach ($inventory as $item)
                    <div class="flex items-center justify-between rounded-lg bg-emerald-50 px-4 py-3">
                        <span class="text-sm font-medium text-emerald-900">{{ $item['label'] }}</span>
                        <span class="text-lg font-bold text-emerald-950">{{ $item['value'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mt-6 grid gap-4 md:grid-cols-3">
        <article class="rounded-lg border border-emerald-100 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-bold text-emerald-950">ការគ្រប់គ្រងអ្នកជំងឺ</h2>
            <p class="mt-2 text-sm text-gray-500">រក្សាទុកប្រវត្តិ ស្ថានភាពសុខភាព និងទំនាក់ទំនងអ្នកជំងឺ។</p>
        </article>
        <article class="rounded-lg border border-emerald-100 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-bold text-emerald-950">ឱសថ និងស្តុក</h2>
            <p class="mt-2 text-sm text-gray-500">តាមដានប្រភេទឱសថ តម្លៃ ចំនួន និងថ្ងៃផុតកំណត់។</p>
        </article>
        <article class="rounded-lg border border-emerald-100 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-bold text-emerald-950">វិក្កយបត្រ និងទូទាត់</h2>
            <p class="mt-2 text-sm text-gray-500">គាំទ្រការទូទាត់សាច់ប្រាក់ និងការសាកល្បងបាគង។</p>
        </article>
    </section>
@endsection
