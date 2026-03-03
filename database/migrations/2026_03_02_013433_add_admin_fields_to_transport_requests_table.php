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
        Schema::table('transport_requests', function (Blueprint $table) {
            $table->string('plat_nomor')->nullable()->after('keterangan');
            $table->integer('km_awal')->nullable()->after('plat_nomor');
            $table->integer('km_akhir')->nullable()->after('km_awal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transport_requests', function (Blueprint $table) {
            $table->dropColumn(['plat_nomor', 'km_awal', 'km_akhir']);
        });
    }
};
