@props(['painScale' => []])

<x-ui.card>
    <div class="flex items-start gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#2F6F3E]/10 text-[#2F6F3E]">
            <i data-lucide="heart-pulse" class="h-5 w-5"></i>
        </div>
        <div>
            <h2 class="text-lg font-extrabold text-slate-950 dark:text-white">Vital Signs</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Record vital signs with normal range guidance and automatic BMI calculation.</p>
        </div>
    </div>

    <div class="mt-5 grid gap-5 md:grid-cols-2">
        <x-measurement.vital-input
            label="Systolic Blood Pressure"
            field="systolic"
            unit="mmHg"
            icon="gauge"
            placeholder="120"
            tooltip="Normal range: 90-120 mmHg"
        />
        <x-measurement.vital-input
            label="Diastolic Blood Pressure"
            field="diastolic"
            unit="mmHg"
            icon="gauge"
            placeholder="80"
            tooltip="Normal range: 60-80 mmHg"
        />
        <x-measurement.vital-input
            label="Heart Rate"
            field="heart_rate"
            unit="BPM"
            icon="heart"
            placeholder="78"
            tooltip="Normal range: 60-100 BPM"
        />
        <x-measurement.vital-input
            label="Respiratory Rate"
            field="respiratory_rate"
            unit="breaths/min"
            icon="wind"
            placeholder="16"
            tooltip="Normal range: 12-20 breaths/min"
        />
        <x-measurement.vital-input
            label="Body Temperature"
            field="temperature"
            unit="°C"
            icon="thermometer"
            placeholder="37.0"
            step="0.1"
            tooltip="Normal range: 36.1-37.2°C"
        />
        <x-measurement.vital-input
            label="Oxygen Saturation"
            field="oxygen_saturation"
            unit="%"
            icon="activity"
            placeholder="98"
            tooltip="Normal range: 95-100%"
        />
        <x-measurement.vital-input
            label="Weight"
            field="weight"
            unit="kg"
            icon="scale"
            placeholder="62"
            step="0.1"
            tooltip="Used with height to calculate BMI"
        />
        <x-measurement.vital-input
            label="Height"
            field="height"
            unit="cm"
            icon="ruler"
            placeholder="165"
            step="0.1"
            tooltip="Used with weight to calculate BMI"
        />

        <label class="block">
            <span class="mb-2 flex items-center justify-between gap-2">
                <span class="inline-flex items-center gap-2 text-sm font-bold text-slate-700 dark:text-slate-200">
                    <i data-lucide="calculator" class="h-4 w-4 text-slate-400"></i>
                    BMI
                </span>
                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-slate-100 text-slate-400 dark:bg-slate-800" title="Calculated automatically from weight and height">
                    <i data-lucide="info" class="h-3.5 w-3.5"></i>
                </span>
            </span>
            <input
                type="text"
                x-bind:value="bmi || 'Auto'"
                readonly
                class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 text-sm font-extrabold text-slate-700 outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-white"
            >
        </label>

        <label class="block">
            <span class="mb-2 flex items-center gap-2 text-sm font-bold text-slate-700 dark:text-slate-200">
                <i data-lucide="smile-plus" class="h-4 w-4 text-slate-400"></i>
                Pain Scale
            </span>
            <select
                x-model.number="vitals.pain_scale"
                x-on:change="markDirty(); detectHealthStatus()"
                class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900"
            >
                @foreach ($painScale as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
        </label>

        <x-measurement.vital-input
            label="Blood Glucose"
            field="blood_glucose"
            unit="mg/dL"
            icon="droplets"
            placeholder="Optional"
            tooltip="Optional. Typical fasting range: 70-99 mg/dL"
            optional
        />
        <x-measurement.vital-input
            label="Pulse"
            field="pulse"
            unit="pulse/min"
            icon="waves"
            placeholder="Optional"
            tooltip="Optional. Usually close to heart rate."
            optional
        />
    </div>
</x-ui.card>
