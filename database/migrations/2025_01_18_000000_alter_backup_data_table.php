<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('backup_data');
        
        Schema::create('backup_data', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('filepath');
            $table->enum('type', ['daily', 'weekly', 'monthly']);
            $table->bigInteger('size');
            $table->timestamp('backup_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('backup_data');
    }
};
