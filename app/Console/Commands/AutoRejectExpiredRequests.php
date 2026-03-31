<?php

namespace App\Console\Commands;

use App\Models\TransportRequest;
use Illuminate\Console\Command;
use Carbon\Carbon;

class AutoRejectExpiredRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transport:auto-reject-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Otomatis mengubah status pengajuan menjadi tidak disetujui jika sudah melewati waktu transportasi';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        
        // Cari pengajuan yang masih berstatus 'diajukan' dan sudah melewati waktu transportasi
        $expiredRequests = TransportRequest::where('status', 'diajukan')
            ->where(function($query) use ($now) {
                // Gabungkan tanggal dan jam untuk perbandingan yang akurat
                $query->whereRaw("CONCAT(tanggal, ' ', jam) < ?", [$now->format('Y-m-d H:i:s')]);
            })
            ->get();

        $count = 0;
        foreach ($expiredRequests as $request) {
            $request->update(['status' => 'tidak_disetujui']);
            $count++;
            
            $requestDateTime = $request->tanggal->format('d/m/Y') . ' ' . $request->jam;
            $userName = $request->user ? $request->user->full_name : $request->pemohon_nama;
            $this->info("Pengajuan #{$request->id} dari {$userName} ({$requestDateTime}) tidak disetujui karena melewati waktu");
        }

        if ($count > 0) {
            $this->info("✓ Total {$count} pengajuan telah berubah menjadi tidak disetujui karena melewati waktu.");
        } else {
            $this->info("✓ Tidak ada pengajuan yang melewati waktu.");
        }

        return Command::SUCCESS;
    }
}
