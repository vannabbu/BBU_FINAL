@props(['doctor'])

@php
    $statusClasses = [
        'available' => 'border-[#16A34A]/20 bg-[#16A34A]/10 text-[#16A34A]',
        'busy' => 'border-[#F59E0B]/20 bg-[#F59E0B]/10 text-[#B45309] dark:text-amber-300',
        'on_leave' => 'border-[#DC2626]/20 bg-[#DC2626]/10 text-[#DC2626]',
    ][$doctor['status']] ?? 'border-slate-200 bg-slate-100 text-slate-700';
@endphp

<x-ui.card>
    <div class="flex items-start justify-between gap-4">
        <div class="flex items-center gap-4">
            <img src="{{ $doctor['avatar'] }}" alt="{{ $doctor['name'] }}" class="h-16 w-16 rounded-2xl object-cover ring-4 ring-[#2F6F3E]/10">
            <div>
                <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">{{ $doctor['name'] }}</h2>
                <p class="mt-1 text-sm font-semibold text-slate-500 dark:text-slate-400">{{ $doctor['specialty'] }}</p>
                <p class="mt-1 text-xs font-bold text-slate-400">{{ $doctor['department'] }}</p>
            </div>
        </div>
        <span class="rounded-full border px-3 py-1.5 text-xs font-extrabold {{ $statusClasses }}">{{ $doctor['status_label'] }}</span>
    </div>

    <div class="mt-5 grid gap-3 sm:grid-cols-2">
        <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
            <div class="flex items-center gap-2 text-amber-500">
                <i data-lucide="star" class="h-4 w-4 fill-current"></i>
                <span class="text-sm font-extrabold">{{ $doctor['rating'] }}</span>
            </div>
            <p class="mt-1 text-xs font-bold text-slate-500 dark:text-slate-400">Patient rating</p>
        </div>
        <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
            <p class="text-sm font-extrabold text-slate-950 dark:text-white">{{ $doctor['experience_years'] }} years</p>
            <p class="mt-1 text-xs font-bold text-slate-500 dark:text-slate-400">Experience</p>
        </div>
        <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800 sm:col-span-2">
            <div class="flex items-start gap-2">
                <i data-lucide="calendar-clock" class="mt-0.5 h-4 w-4 text-[#2F6F3E]"></i>
                <div>
                    <p class="text-sm font-extrabold text-slate-950 dark:text-white">{{ $doctor['availability'] }}</p>
                    <p class="mt-1 text-xs font-bold text-slate-500 dark:text-slate-400">Current availability</p>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-[#2F6F3E] p-4 text-white sm:col-span-2">
            <p class="text-xs font-bold text-white/70">Consultation fee</p>
            <p class="mt-1 text-2xl font-extrabold">{{ number_format($doctor['fee']) }} ៛</p>
        </div>
    </div>
</x-ui.card>
