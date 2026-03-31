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
        // Migration ini hanya untuk dokumentasi
        // Status 'kadaluarsa' telah digabungkan ke dalam status 'tidak_disetujui'
        // Tidak perlu mengubah struktur tabel karena kolom status sudah ada sebagai string
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak ada perubahan struktur tabel
    }
};
