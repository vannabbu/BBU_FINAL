<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bed', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->nullable()->constrained('department')->nullOnDelete();
            $table->string('bed_number', 50)->unique();
            $table->string('type', 100)->nullable();
            $table->string('status', 50)->default('available');
            $table->text('description')->nullable();
            $table->timestampsTz();
        });

        Schema::create('bed_allotment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bed_id')->constrained('bed')->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained('patient')->cascadeOnDelete();
            $table->timestampTz('allotment_time');
            $table->timestampTz('discharge_time')->nullable();
            $table->timestampsTz();

            $table->index(['bed_id', 'discharge_time']);
            $table->index(['patient_id', 'allotment_time']);
        });

        Schema::create('blood_bank', function (Blueprint $table) {
            $table->id();
            $table->string('blood_group', 5)->unique();
            $table->unsignedInteger('status')->default(0);
        });

        Schema::create('blood_donor', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('blood_group', 5);
            $table->string('sex', 10)->nullable();
            $table->unsignedSmallInteger('age')->nullable();
            $table->date('last_donation_date')->nullable();
            $table->string('phone', 50)->nullable();
            $table->timestampTz('created_at')->useCurrent();

            $table->index('blood_group');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_donor');
        Schema::dropIfExists('blood_bank');
        Schema::dropIfExists('bed_allotment');
        Schema::dropIfExists('bed');
    }
};
