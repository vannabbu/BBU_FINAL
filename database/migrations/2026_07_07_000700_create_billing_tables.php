<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patient')->cascadeOnDelete();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('vat', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2);
            $table->string('status', 50)->default('unpaid');
            $table->date('date');
            $table->timestampTz('created_at')->useCurrent();

            $table->index(['patient_id', 'date']);
            $table->index('status');
        });

        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoice')->cascadeOnDelete();
            $table->string('payment_method', 50);
            $table->string('transaction_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->timestampTz('timestamp')->useCurrent();

            $table->index(['invoice_id', 'timestamp']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment');
        Schema::dropIfExists('invoice');
    }
};
