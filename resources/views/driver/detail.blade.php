<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-3 pb-6 space-y-3">

        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-base font-bold text-slate-900">Detail Pengajuan</h1>
                <p class="text-[11px] text-slate-500 font-mono">{{ $transportRequest->nomor_pengajuan }}</p>
            </div>
            <div class="flex items-center gap-2">
                @php
                    $statusCfg = match($transportRequest->status) {
                        'digunakan' => ['bg-cyan-100','text-cyan-800','Digunakan'],
                        'selesai'   => ['bg-emerald-100','text-emerald-800','Selesai'],
                        default     => ['bg-slate-100','text-slate-800', ucfirst($transportRequest->status)],
                    };
                @endphp
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusCfg[0] }} {{ $statusCfg[1] }}">
                    {{ $statusCfg[2] }}
                </span>
                <a href="{{ route('driver.print', $transportRequest) }}" target="_blank"
                   class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs font-semibold"
                   style="background-color: #00685E; color: white !important;">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print
                </a>
                <a href="{{ route('driver.dashboard') }}"
                   class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                    Kembali
                </a>
            </div>
        </div>

        <!-- Info Pengajuan -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-3 py-2 border-b border-slate-100 bg-slate-50">
                <p class="text-[10px] font-semibold text-slate-600 uppercase tracking-wide">Informasi Pengajuan</p>
            </div>
            <dl class="px-3 py-2 space-y-1.5 text-xs">
                <div class="flex gap-2">
                    <dt class="w-28 text-slate-500 shrink-0">Jenis</dt>
                    <dd class="font-medium text-slate-800">{{ ucfirst($transportRequest->jenis) }}
                        @if($transportRequest->prioritas === 'segera')
                            <span class="ml-1 text-[9px] font-bold bg-red-100 text-red-700 px-1.5 py-0.5 rounded-full">CITO</span>
                        @endif
                    </dd>
                </div>
                <div class="flex gap-2">
                    <dt class="w-28 text-slate-500 shrink-0">Pemohon</dt>
                    <dd class="font-medium text-slate-800">{{ $transportRequest->user->full_name ?? $transportRequest->pemohon_nama }}
                        <span class="text-slate-500 font-normal"> · {{ $transportRequest->user->unit_kerja ?? $transportRequest->pemohon_unit }}</span>
                    </dd>
                </div>
                <div class="flex gap-2">
                    <dt class="w-28 text-slate-500 shrink-0">Jadwal</dt>
                    <dd class="font-medium text-slate-800">
                        {{ $transportRequest->tanggal->format('d/m/Y') }} {{ substr($transportRequest->jam, 0, 5) }}
                        <span class="text-slate-400">–</span>
                        {{ $transportRequest->tanggal_sampai->format('d/m/Y') }} {{ substr($transportRequest->jam_sampai, 0, 5) }}
                    </dd>
                </div>
                <div class="flex gap-2">
                    <dt class="w-28 text-slate-500 shrink-0">Tgl Dibuat</dt>
                    <dd class="text-slate-500">{{ $transportRequest->created_at->format('d/m/Y, H:i') }}</dd>
                </div>
                <div class="flex gap-2">
                    <dt class="w-28 text-slate-500 shrink-0">Unit Kendaraan</dt>
                    <dd class="font-medium text-slate-800">{{ $transportRequest->unit_mobil ?? '-' }}
                        @if($transportRequest->plat_nomor)
                            <span class="text-slate-500 font-normal font-mono"> ({{ $transportRequest->plat_nomor }})</span>
                        @endif
                    </dd>
                </div>
                @if($transportRequest->alamat_tujuan)
                <div class="flex gap-2">
                    <dt class="w-28 text-slate-500 shrink-0">Tujuan</dt>
                    <dd class="font-medium text-slate-800">{{ $transportRequest->alamat_tujuan }}</dd>
                </div>
                @endif
                @if($transportRequest->alamat_asal && $transportRequest->alamat_asal !== 'RS')
                <div class="flex gap-2">
                    <dt class="w-28 text-slate-500 shrink-0">Asal</dt>
                    <dd class="font-medium text-slate-800">{{ $transportRequest->alamat_asal }}</dd>
                </div>
                @endif
                @if($transportRequest->keperluan)
                <div class="flex gap-2">
                    <dt class="w-28 text-slate-500 shrink-0">Keperluan</dt>
                    <dd class="font-medium text-slate-800">{{ $transportRequest->keperluan }}</dd>
                </div>
                @endif
            </dl>
        </div>

        @if($transportRequest->jenis === 'ambulance' && $transportRequest->pasien_nama)
        <!-- Info Pasien -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-3 py-2 border-b border-slate-100 bg-slate-50">
                <p class="text-[10px] font-semibold text-slate-600 uppercase tracking-wide">Identitas Pasien</p>
            </div>
            <dl class="px-3 py-2 space-y-1.5 text-xs">
                <div class="flex gap-2">
                    <dt class="w-28 text-slate-500 shrink-0">Nama</dt>
                    <dd class="font-medium text-slate-800">{{ $transportRequest->pasien_nama }}</dd>
                </div>
                @if($transportRequest->pasien_no_rm)
                <div class="flex gap-2">
                    <dt class="w-28 text-slate-500 shrink-0">No. RM</dt>
                    <dd class="font-medium text-slate-800">{{ $transportRequest->pasien_no_rm }}</dd>
                </div>
                @endif
                @if($transportRequest->alamat_pasien)
                <div class="flex gap-2">
                    <dt class="w-28 text-slate-500 shrink-0">Alamat</dt>
                    <dd class="font-medium text-slate-800">{{ $transportRequest->alamat_pasien }}</dd>
                </div>
                @endif
            </dl>
        </div>
        @endif

        <!-- Info Perjalanan -->
        @if($transportRequest->km_awal || $transportRequest->km_akhir || $transportRequest->jam_kedatangan)
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-3 py-2 border-b border-slate-100 bg-slate-50">
                <p class="text-[10px] font-semibold text-slate-600 uppercase tracking-wide">Data Perjalanan</p>
            </div>
            <dl class="px-3 py-2 space-y-1.5 text-xs">
                @if($transportRequest->km_awal)
                <div class="flex gap-2">
                    <dt class="w-28 text-slate-500 shrink-0">KM Berangkat</dt>
                    <dd class="font-medium text-slate-800">{{ number_format($transportRequest->km_awal, 0, ',', '.') }} km</dd>
                </div>
                @endif
                @if($transportRequest->km_akhir)
                <div class="flex gap-2">
                    <dt class="w-28 text-slate-500 shrink-0">KM Tiba</dt>
                    <dd class="font-medium text-slate-800">{{ number_format($transportRequest->km_akhir, 0, ',', '.') }} km</dd>
                </div>
                @endif
                @if($transportRequest->km_awal && $transportRequest->km_akhir)
                <div class="flex gap-2">
                    <dt class="w-28 text-slate-500 shrink-0">Total Jarak</dt>
                    <dd class="font-semibold text-emerald-700">{{ number_format($transportRequest->km_akhir - $transportRequest->km_awal, 0, ',', '.') }} km</dd>
                </div>
                @endif
                @if($transportRequest->jam_kedatangan)
                <div class="flex gap-2">
                    <dt class="w-28 text-slate-500 shrink-0">Jam Tiba</dt>
                    <dd class="font-medium text-slate-800">{{ $transportRequest->jam_kedatangan }}</dd>
                </div>
                @endif
            </dl>
        </div>
        @endif

    </div>
</x-app-layout>
