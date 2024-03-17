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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('inv');
            $table->dateTime('tanggal');
            $table->unsignedBigInteger('total');
            $table->enum('status', ['proses', 'selesai']);
            $table->unsignedBigInteger('id_users');
            $table->timestamps();

            $table->foreign('id_users')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
