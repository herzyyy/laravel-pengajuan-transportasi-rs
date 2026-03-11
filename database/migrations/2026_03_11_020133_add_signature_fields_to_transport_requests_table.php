<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transport_requests', function (Blueprint $table) {
            $table->string('signature_pemohon')->nullable()->after('status'); // QR signature pemohon
            $table->timestamp('signature_pemohon_at')->nullable();
            
            $table->string('signature_pengelola_1')->nullable(); // QR signature pengelola saat menyetujui
            $table->timestamp('signature_pengelola_1_at')->nullable();
            $table->string('signature_pengelola_1_name')->nullable();
            
            $table->string('signature_driver')->nullable(); // QR signature driver saat mulai digunakan
            $table->timestamp('signature_driver_at')->nullable();
            
            $table->string('signature_pengelola_2')->nullable(); // QR signature pengelola saat selesai
            $table->timestamp('signature_pengelola_2_at')->nullable();
            $table->string('signature_pengelola_2_name')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('transport_requests', function (Blueprint $table) {
            $table->dropColumn([
                'signature_pemohon',
                'signature_pemohon_at',
                'signature_pengelola_1',
                'signature_pengelola_1_at',
                'signature_pengelola_1_name',
                'signature_driver',
                'signature_driver_at',
                'signature_pengelola_2',
                'signature_pengelola_2_at',
                'signature_pengelola_2_name',
            ]);
        });
    }
};
