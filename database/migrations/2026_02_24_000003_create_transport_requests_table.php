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
        Schema::create('transport_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('jenis'); // umum | ambulance
            $table->string('keperluan')->nullable(); // antar | jemput

            $table->date('tanggal');
            $table->time('jam');
            $table->string('kontak');

            $table->text('alamat_asal')->nullable();
            $table->text('alamat_tujuan')->nullable();
            $table->text('keterangan')->nullable();

            // Umum
            $table->string('pemohon_nama')->nullable();
            $table->string('pemohon_unit')->nullable();
            $table->unsignedInteger('jumlah_penumpang')->nullable();

            // Ambulance
            $table->string('pasien_nama')->nullable();
            $table->string('pasien_no_rm')->nullable();
            $table->string('ruangan')->nullable();
            $table->string('kondisi_pasien')->nullable();
            $table->string('pendamping_nama')->nullable();

            $table->string('status')->default('diajukan'); // diajukan | diproses | selesai | ditolak

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_requests');
    }
};

