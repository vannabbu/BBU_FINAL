<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message', function (Blueprint $table) {
            $table->id();
            $table->string('sender_role', 50);
            $table->unsignedBigInteger('sender_id');
            $table->string('receiver_role', 50);
            $table->unsignedBigInteger('receiver_id');
            $table->text('message_text');
            $table->boolean('is_read')->default(false);
            $table->timestampTz('timestamp')->useCurrent();

            $table->index(['sender_role', 'sender_id']);
            $table->index(['receiver_role', 'receiver_id']);
            $table->index('is_read');
        });

        Schema::create('noticeboard', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('notice');
            $table->date('date');
            $table->timestampTz('created_at')->useCurrent();
        });

        Schema::create('email_template', function (Blueprint $table) {
            $table->id();
            $table->string('task');
            $table->string('subject');
            $table->text('body');
            $table->timestampTz('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_template');
        Schema::dropIfExists('noticeboard');
        Schema::dropIfExists('message');
    }
};
