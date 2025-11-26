<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelanggaran', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('sanksi', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('pelaksanaan_sanksi', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('pelanggaran', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('prestasi', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('sanksi', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('pelaksanaan_sanksi', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
};