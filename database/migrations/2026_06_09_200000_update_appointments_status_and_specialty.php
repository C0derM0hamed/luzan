<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('specialty')->nullable()->after('doctor_id');
        });

        DB::table('appointments')->where('status', 'confirmed')->update(['status' => 'approved']);
        DB::table('appointments')->where('status', 'completed')->update(['status' => 'cancelled']);
    }

    public function down(): void
    {
        DB::table('appointments')->where('status', 'approved')->update(['status' => 'confirmed']);

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('specialty');
        });
    }
};
