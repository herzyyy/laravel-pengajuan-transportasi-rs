<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RecurringTransportTemplate;
use App\Models\TransportRequest;
use Carbon\Carbon;

class GenerateRecurringRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-recurring-requests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate daily transport requests from active recurring templates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        // $today->format('N') mengembalikan 1 untuk Senin hingga 7 untuk Minggu
        $dayOfWeek = (int) $today->format('N');

        $activeTemplates = RecurringTransportTemplate::where('is_active', true)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->get();

        $count = 0;
        foreach ($activeTemplates as $template) {
            $days = $template->hari ?? [];
            if (!in_array($dayOfWeek, $days)) {
                continue; 
            }

            // Mencegah duplikasi data per user, keperluan, dan jam yang sama di hari ini
            $existing = TransportRequest::where('user_id', $template->user_id)
                ->where('keperluan', $template->keperluan)
                ->where('jenis', $template->jenis)
                ->whereDate('tanggal', $today)
                ->where('jam', $template->jam)
                ->exists();

            if ($existing) continue;

            $tanggalSampai = $today->format('Y-m-d');
            // Jika tidak ada jam_sampai dari template, buat saja "23:59" atau tetap kosong (null) tergantu model.
            // Model TransportRequest mengizinkan nullable
            
            TransportRequest::create([
                'user_id' => $template->user_id,
                'jenis' => $template->jenis,
                'nomor_pengajuan' => TransportRequest::generateNomor(),
                'tanggal' => $today->format('Y-m-d'),
                'jam' => substr($template->jam, 0, 5),
                'tanggal_sampai' => $tanggalSampai,
                'jam_sampai' => $template->jam_sampai ? substr($template->jam_sampai, 0, 5) : null,
                'keperluan' => $template->keperluan,
                'prioritas' => $template->prioritas,
                'pemohon_nama' => $template->pemohon_nama,
                'pemohon_unit' => $template->pemohon_unit,
                'jumlah_penumpang' => $template->jumlah_penumpang,
                'alamat_asal' => $template->alamat_asal,
                'alamat_tujuan' => $template->alamat_tujuan,
                'keterangan' => $template->keterangan,
                'pasien_nama' => $template->pasien_nama,
                'pasien_no_rm' => $template->pasien_no_rm,
                'kontak' => '',
                'signature_pemohon' => \Illuminate\Support\Str::random(32),
                'signature_pemohon_at' => now(),
            ]);

            $count++;
        }

        $this->info("Generated {$count} recurring transport requests for today.");
    }
}
