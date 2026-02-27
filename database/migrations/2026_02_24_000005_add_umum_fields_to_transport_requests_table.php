<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transport_requests', function (Blueprint $table) {
            $table->date('tanggal_sampai')->nullable()->after('tanggal');
            $table->time('jam_sampai')->nullable()->after('jam');
            $table->string('prioritas')->default('biasa')->after('keperluan'); // biasa | segera
        });
    }

    public function down(): void
    {
        Schema::table('transport_requests', function (Blueprint $table) {
            $table->dropColumn(['tanggal_sampai', 'jam_sampai', 'prioritas']);
        });
    }
};

