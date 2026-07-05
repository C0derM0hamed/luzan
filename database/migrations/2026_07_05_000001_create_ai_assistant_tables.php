<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_chat_logs', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 64)->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_message');
            $table->text('assistant_message')->nullable();
            $table->string('model')->nullable();
            $table->unsignedInteger('tokens_used')->nullable();
            $table->string('status', 20)->default('success');
            $table->text('error_message')->nullable();
            $table->timestamps();
        });

        Schema::create('ai_chat_usage', function (Blueprint $table) {
            $table->id();
            $table->date('usage_date');
            $table->string('identifier', 64);
            $table->unsignedInteger('message_count')->default(0);
            $table->timestamps();

            $table->unique(['usage_date', 'identifier']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_chat_usage');
        Schema::dropIfExists('ai_chat_logs');
    }
};
