<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update existing empty status to 'terjadwal'
        DB::table('pelaksanaan_sanksi')
            ->where('status', '')
            ->orWhereNull('status')
            ->update(['status' => 'terjadwal']);
            
        // Modify column to have new status options
        Schema::table('pelaksanaan_sanksi', function (Blueprint $table) {
            $table->enum('status', ['terjadwal', 'dikerjakan', 'tuntas', 'terlambat', 'perpanjangan'])->default('terjadwal')->change();
        });
    }

    public function down(): void
    {
        Schema::table('pelaksanaan_sanksi', function (Blueprint $table) {
            $table->enum('status', ['terjadwal', 'berlangsung', 'selesai'])->default('terjadwal')->change();
        });
    }
};