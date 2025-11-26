<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bimbingan_konseling', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa');
            $table->foreignId('bk_id')->constrained('users');
            $table->foreignId('pelanggaran_id')->nullable()->constrained('pelanggaran');
            $table->text('tindakan')->nullable();
            $table->enum('status', ['terdaftar', 'diproses', 'selesai', 'tindak_lanjut'])->default('terdaftar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bimbingan_konseling');
    }
};
