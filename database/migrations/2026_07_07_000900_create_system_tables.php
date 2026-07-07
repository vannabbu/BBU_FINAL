<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log', function (Blueprint $table) {
            $table->id();
            $table->string('user_role', 50)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('action');
            $table->string('ip_address', 45)->nullable();
            $table->timestampTz('timestamp')->useCurrent();

            $table->index(['user_role', 'user_id']);
        });

        Schema::create('language', function (Blueprint $table) {
            $table->id();
            $table->string('phrase');
            $table->text('khmer')->nullable();
            $table->text('english')->nullable();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('system_name');
            $table->string('system_email')->nullable();
            $table->text('address')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('currency', 10)->default('KHR');
            $table->timestampTz('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('report', function (Blueprint $table) {
            $table->id();
            $table->string('type', 100);
            $table->string('generated_by', 100)->nullable();
            $table->text('description')->nullable();
            $table->timestampTz('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('language');
        Schema::dropIfExists('log');
    }
};
