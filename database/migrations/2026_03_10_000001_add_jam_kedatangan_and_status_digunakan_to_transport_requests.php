<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Support;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transport_requests', function (Blueprint $table) {
            $table->string('jam_kedatangan', 10)->nullable()->after('jam_sampai');
        });
        
        // Update existing 'diproses' status description
        // Status flow: diajukan -> diproses (disetujui) -> digunakan -> selesai
    }

    public function down(): void
    {
        Schema::table('transport_requests', function (Blueprint $table) {
            $table->dropColumn('jam_kedatangan');
        });
    }
};
