<?php

namespace App\Console\Commands;

use App\Models\TransportRequest;
use Illuminate\Console\Command;
use Carbon\Carbon;

class AutoRejectExpiredRequests extends Command
{
    protected $signature = 'transport:auto-reject-expired';

    protected $description = 'Otomatis menolak pengajuan yang tidak diproses/dieksekusi dalam 24 jam';

    public function handle()
    {
        $now = Carbon::now();
        $deadline = $now->copy()->subHours(24);
        $count = 0;

        // 1. Status "diajukan" yang sudah lebih dari 24 jam sejak dibuat tanpa diproses admin
        $pendingExpired = TransportRequest::where('status', 'diajukan')
            ->where('created_at', '<=', $deadline)
            ->get();

        foreach ($pendingExpired as $request) {
            $request->update([
                'status'           => 'tidak_disetujui',
                'rejection_reason' => 'Pengajuan otomatis ditolak karena tidak diproses oleh admin dalam 24 jam sejak pengajuan dibuat.',
            ]);
            $count++;
            $nama = $request->user?->full_name ?? $request->pemohon_nama;
            $this->info("Ditolak (tidak diproses) #{$request->nomor_pengajuan} — {$nama}");
        }

        // 2. Status "diproses" (disetujui) yang tanggal+jam transportasi sudah lewat 24 jam tanpa dieksekusi
        $approvedExpired = TransportRequest::where('status', 'diproses')
            ->whereRaw("CONCAT(tanggal, ' ', jam) <= ?", [$deadline->format('Y-m-d H:i:s')])
            ->get();

        foreach ($approvedExpired as $request) {
            $jadwal = $request->tanggal->format('d/m/Y') . ' ' . $request->jam;
            $request->update([
                'status'           => 'tidak_disetujui',
                'rejection_reason' => "Pengajuan otomatis ditolak karena transportasi yang dijadwalkan pada {$jadwal} tidak dieksekusi dalam 24 jam setelah waktu keberangkatan.",
            ]);
            $count++;
            $nama = $request->user?->full_name ?? $request->pemohon_nama;
            $this->info("Ditolak (tidak dieksekusi) #{$request->nomor_pengajuan} — {$nama} (jadwal: {$jadwal})");
        }

        if ($count > 0) {
            $this->info("✓ Total {$count} pengajuan otomatis ditolak.");
        } else {
            $this->info("✓ Tidak ada pengajuan yang perlu ditolak.");
        }

        return Command::SUCCESS;
    }
}
