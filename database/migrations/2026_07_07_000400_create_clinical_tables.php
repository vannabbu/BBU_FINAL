<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patient')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('doctor')->cascadeOnDelete();
            $table->timestampTz('appointment_date');
            $table->string('status', 50)->default('pending');
            $table->text('remarks')->nullable();
            $table->timestampsTz();

            $table->unique(['doctor_id', 'appointment_date'], 'appointment_doctor_date_unique');
            $table->index(['patient_id', 'appointment_date']);
        });

        Schema::create('prescription', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctor')->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained('patient')->cascadeOnDelete();
            $table->text('case_history')->nullable();
            $table->text('medication');
            $table->text('description')->nullable();
            $table->date('date');
            $table->timestampTz('created_at')->useCurrent();
        });

        Schema::create('diagnosis_report', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patient')->cascadeOnDelete();
            $table->foreignId('laboratorist_id')->nullable()->constrained('laboratorist')->nullOnDelete();
            $table->string('report_type');
            $table->string('document_url')->nullable();
            $table->text('description')->nullable();
            $table->timestampTz('date')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnosis_report');
        Schema::dropIfExists('prescription');
        Schema::dropIfExists('appointment');
    }
};
