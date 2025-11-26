<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sanksi', function (Blueprint $table) {
            // Cek dan drop kolom jika ada
            if (Schema::hasColumn('sanksi', 'jenis_sanksi')) {
                $table->dropColumn('jenis_sanksi');
            }
            if (Schema::hasColumn('sanksi', 'deskripsi')) {
                $table->dropColumn('deskripsi');
            }
            
            // Tambah kolom baru
            if (!Schema::hasColumn('sanksi', 'jenis_sanksi_id')) {
                $table->foreignId('jenis_sanksi_id')->after('pelanggaran_id')->constrained('jenis_sanksi');
            }
            
            // Modify existing columns
            $table->date('tanggal_mulai')->nullable()->change();
            $table->date('tanggal_selesai')->nullable()->change();
            
            // Drop dan recreate status column
            if (Schema::hasColumn('sanksi', 'status')) {
                $table->dropColumn('status');
            }
            $table->enum('status', ['pending', 'berlangsung', 'selesai'])->default('pending');
            
            if (!Schema::hasColumn('sanksi', 'catatan')) {
                $table->text('catatan')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('sanksi', function (Blueprint $table) {
            if (Schema::hasColumn('sanksi', 'jenis_sanksi_id')) {
                $table->dropForeign(['jenis_sanksi_id']);
                $table->dropColumn('jenis_sanksi_id');
            }
            if (Schema::hasColumn('sanksi', 'catatan')) {
                $table->dropColumn('catatan');
            }
            
            $table->string('jenis_sanksi', 100)->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('status')->default('0');
        });
    }
};