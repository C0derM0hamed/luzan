<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_usage_records', function (Blueprint $table) {
            $table->id();
            $table->string('provider', 30)->index();
            $table->string('model', 150)->index();
            $table->unsignedInteger('tokens_used')->nullable();
            $table->decimal('estimated_cost', 12, 6)->nullable();
            $table->string('status', 20)->default('success');
            $table->timestamps();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_usage_records');
    }
};
