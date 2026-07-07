<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicine_category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestampTz('created_at')->useCurrent();
        });

        Schema::create('medicine', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('medicine_category')->nullOnDelete();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('total_quantity')->default(0);
            $table->date('expiry_date')->nullable();
            $table->string('company')->nullable();
            $table->timestampsTz();

            $table->index(['category_id', 'expiry_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicine');
        Schema::dropIfExists('medicine_category');
    }
};
