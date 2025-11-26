<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jenis_pelanggaran', function (Blueprint $table) {
            if (Schema::hasColumn('jenis_pelanggaran', 'sanksi_id')) {
                $table->dropForeign(['sanksi_id']);
                $table->dropColumn('sanksi_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jenis_pelanggaran', function (Blueprint $table) {
            $table->foreignId('sanksi_id')->nullable()->constrained('sanksi');
        });
    }
};