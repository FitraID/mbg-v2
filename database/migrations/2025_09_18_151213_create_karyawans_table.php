<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode_karyawan');
            $table->unsignedBigInteger('id_cabang');
            $table->string('jabatan');
            $table->unsignedBigInteger('id_shift');
            // $table->unsignedBigInteger('id_absen');
            $table->string('keterangan')->nullable();
            $table->string('status');
            $table->timestamps();

            $table->foreign('id_cabang')->references('id')->on('cabangs')->onDelete('cascade');
            $table->foreign('id_shift')->references('id')->on('shifts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
