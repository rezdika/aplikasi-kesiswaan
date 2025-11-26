<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orangtua', function (Blueprint $table) {
            $table->id('orangtua_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('siswa_id');
            $table->enum('hubungan', ['ayah', 'ibu', 'wali']);
            $table->string('nama_orangtua');
            $table->string('pekerjaan');
            $table->string('pendidikan');
            $table->string('no_telp');
            $table->text('alamat');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orangtua');
    }
};
