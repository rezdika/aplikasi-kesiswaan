<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bimbingan_konseling', function (Blueprint $table) {
            $table->enum('status', ['terdaftar', 'diproses', 'selesai', 'tindak_lanjut'])->default('terdaftar')->change();
        });
    }

    public function down(): void
    {
        Schema::table('bimbingan_konseling', function (Blueprint $table) {
            $table->enum('status', ['terdaftar', 'diproses', 'selesai', 'tindak_lanjut'])->default('terdaftar')->change();
        });
    }
};