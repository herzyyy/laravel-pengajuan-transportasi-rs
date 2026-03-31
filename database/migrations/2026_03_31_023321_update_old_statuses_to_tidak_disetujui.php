<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update old status values to the new consolidated status
        DB::table('transport_requests')
            ->whereIn('status', ['ditolak', 'kadaluarsa'])
            ->update(['status' => 'tidak_disetujui']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: We cannot reliably reverse this migration since we don't know
        // which records were originally 'ditolak' vs 'kadaluarsa'
        // This is a one-way migration for data consistency
    }
};
