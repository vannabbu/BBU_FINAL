<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 50)->nullable();
            $table->text('address')->nullable();
            $this->twoFactorColumns($table);
            $table->timestampsTz();
        });

        Schema::create('doctor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->nullable()->constrained('department')->nullOnDelete();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 50)->nullable();
            $table->string('designation')->nullable();
            $table->text('profile')->nullable();
            $this->twoFactorColumns($table);
            $table->timestampsTz();
        });

        Schema::create('nurse', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 50)->nullable();
            $this->twoFactorColumns($table);
            $table->timestampsTz();
        });

        Schema::create('laboratorist', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 50)->nullable();
            $this->twoFactorColumns($table);
            $table->timestampsTz();
        });

        Schema::create('pharmacist', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 50)->nullable();
            $this->twoFactorColumns($table);
            $table->timestampsTz();
        });

        Schema::create('accountant', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 50)->nullable();
            $this->twoFactorColumns($table);
            $table->timestampsTz();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accountant');
        Schema::dropIfExists('pharmacist');
        Schema::dropIfExists('laboratorist');
        Schema::dropIfExists('nurse');
        Schema::dropIfExists('doctor');
        Schema::dropIfExists('admin');
    }

    private function twoFactorColumns(Blueprint $table): void
    {
        $table->text('two_factor_secret')->nullable();
        $table->text('two_factor_recovery_codes')->nullable();
        $table->timestampTz('two_factor_confirmed_at')->nullable();
    }
};
