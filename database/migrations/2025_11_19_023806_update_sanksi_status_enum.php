<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update existing status to new values
        DB::table('sanksi')->whereNull('status')->orWhere('status', '')->update(['status' => 'direncanakan']);
        
        // Modify column to have new status options
        Schema::table('sanksi', function (Blueprint $table) {
            $table->enum('status', ['direncanakan', 'berjalan', 'selesai', 'ditunda', 'dibatalkan'])->default('direncanakan')->change();
        });
    }

    public function down(): void
    {
        Schema::table('sanksi', function (Blueprint $table) {
            $table->string('status')->nullable()->change();
        });
    }
};