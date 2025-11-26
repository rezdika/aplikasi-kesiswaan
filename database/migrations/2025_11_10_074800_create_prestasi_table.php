<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa');
            $table->foreignId('kesiswaan_id')->nullable()->constrained('users');
            $table->foreignId('jenis_prestasi_id')->nullable()->constrained('jenis_prestasi');
            $table->foreignId('tahun_ajaran_id')->nullable()->constrained('tahun_ajaran');
            $table->integer('poin');
            $table->text('keterangan')->nullable();
            $table->boolean('status_verifikasi', 50)->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasi');
    }
};
