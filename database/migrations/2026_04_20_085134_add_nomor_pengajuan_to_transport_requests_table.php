<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transport_requests', function (Blueprint $table) {
            $table->string('nomor_pengajuan', 20)->nullable()->unique()->after('id');
        });

        // Backfill data lama berdasarkan created_at
        $requests = DB::table('transport_requests')->orderBy('created_at')->get();
        $counter = [];

        foreach ($requests as $req) {
            $dateKey = date('ymd', strtotime($req->created_at));
            $counter[$dateKey] = ($counter[$dateKey] ?? 0) + 1;
            $nomor = $dateKey . $counter[$dateKey];

            DB::table('transport_requests')
                ->where('id', $req->id)
                ->update(['nomor_pengajuan' => $nomor]);
        }
    }

    public function down(): void
    {
        Schema::table('transport_requests', function (Blueprint $table) {
            $table->dropColumn('nomor_pengajuan');
        });
    }
};
