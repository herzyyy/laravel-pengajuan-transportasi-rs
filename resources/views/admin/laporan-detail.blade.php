<x-app-layout title="Detail Laporan — SIPETRANS">
    <div class="max-w-4xl mx-auto px-3 sm:px-4 pt-4 pb-6">

        {{-- Header --}}
        <div class="flex items-center justify-between gap-3 border-b border-slate-200 pb-3 mb-4">
            <div>
                <h1 class="text-lg font-bold text-slate-800">Detail Laporan Pengajuan</h1>
                <p class="text-xs text-slate-500 mt-0.5">{{ $transportRequest->nomor_pengajuan }}</p>
            </div>
            <div class="flex items-center gap-2">
                @if($transportRequest->status === 'selesai')
                    <a href="{{ route('admin.transport.print', $transportRequest) }}" target="_blank"
                       class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs font-semibold text-white"
                       style="background:#007774;">
                        Print
                    </a>
                @endif
                <a href="{{ route('admin.laporan') }}"
                   class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                    Kembali
                </a>
            </div>
        </div>

        @php
            $statusColors = [
                'diajukan'        => 'bg-amber-100 text-amber-800',
                'diproses'        => 'bg-blue-100 text-blue-800',
                'digunakan'       => 'bg-cyan-100 text-cyan-800',
                'selesai'         => 'bg-emerald-100 text-emerald-800',
                'tidak_disetujui' => 'bg-red-100 text-red-800',
            ];
            $statusLabel = match($transportRequest->status) {
                'diproses'        => 'Disetujui',
                'digunakan'       => 'Digunakan',
                'tidak_disetujui' => 'Tidak Disetujui',
                default           => ucfirst($transportRequest->status),
            };
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">

            {{-- Informasi Pengajuan --}}
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
                <div class="px-3 py-2 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                    <h2 class="text-xs font-semibold text-slate-800">Informasi Pengajuan</h2>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusColors[$transportRequest->status] ?? 'bg-slate-100 text-slate-700' }}">
                        {{ $statusLabel }}
                    </span>
                </div>
                <dl class="px-3 py-2.5 text-xs space-y-2">
                    <div class="flex gap-2">
                        <dt class="w-28 text-slate-500 shrink-0">No. Pengajuan</dt>
                        <dd class="font-mono font-semibold text-slate-800">{{ $transportRequest->nomor_pengajuan }}</dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="w-28 text-slate-500 shrink-0">Dibuat</dt>
                        <dd class="text-slate-700">{{ $transportRequest->created_at->format('d/m/Y, H:i') }}</dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="w-28 text-slate-500 shrink-0">Jenis</dt>
                        <dd class="text-slate-800 font-medium">
                            {{ ucfirst($transportRequest->jenis) }}
                            @if($transportRequest->keperluan)
                                <span class="text-slate-500">({{ ucfirst($transportRequest->keperluan) }})</span>
                            @endif
                            @if($transportRequest->prioritas === 'segera')
                                <span class="ml-1 text-[9px] font-bold bg-red-100 text-red-700 px-1.5 py-0.5 rounded">CITO</span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="w-28 text-slate-500 shrink-0">Tanggal</dt>
                        <dd class="text-slate-800 font-medium">
                            {{ $transportRequest->tanggal->format('d/m/Y') }} {{ substr($transportRequest->jam, 0, 5) }}
                            @if($transportRequest->tanggal_sampai && $transportRequest->jam_sampai)
                                &ndash; {{ $transportRequest->tanggal_sampai->format('d/m/Y') }} {{ substr($transportRequest->jam_sampai, 0, 5) }}
                            @else
                                &ndash; <span class="text-slate-500">Sampai Selesai</span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="w-28 text-slate-500 shrink-0">Tujuan</dt>
                        <dd class="text-slate-700">{{ $transportRequest->alamat_tujuan ?? '-' }}</dd>
                    </div>
                    @if($transportRequest->alamat_asal)
                    <div class="flex gap-2">
                        <dt class="w-28 text-slate-500 shrink-0">Asal</dt>
                        <dd class="text-slate-700">{{ $transportRequest->alamat_asal }}</dd>
                    </div>
                    @endif
                    @if($transportRequest->keterangan)
                    <div class="flex gap-2">
                        <dt class="w-28 text-slate-500 shrink-0">Keterangan</dt>
                        <dd class="text-slate-700">{{ $transportRequest->keterangan }}</dd>
                    </div>
                    @endif
                    @if($transportRequest->status === 'tidak_disetujui' && $transportRequest->rejection_reason)
                    <div class="flex gap-2">
                        <dt class="w-28 text-slate-500 shrink-0">Alasan Tolak</dt>
                        <dd class="text-red-700">{{ $transportRequest->rejection_reason }}</dd>
                    </div>
                    @endif
                </dl>
            </div>

            {{-- Pemohon --}}
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
                <div class="px-3 py-2 border-b border-slate-100 bg-slate-50">
                    <h2 class="text-xs font-semibold text-slate-800">Data Pemohon</h2>
                </div>
                <dl class="px-3 py-2.5 text-xs space-y-2">
                    <div class="flex gap-2">
                        <dt class="w-28 text-slate-500 shrink-0">Nama</dt>
                        <dd class="text-slate-800 font-medium">
                            {{ $transportRequest->user->full_name ?? $transportRequest->pemohon_nama }}
                            @if($transportRequest->user && $transportRequest->user->isPriority())
                                <span class="ml-1 text-[9px] font-bold bg-purple-100 text-purple-700 px-1.5 py-0.5 rounded">PRIORITAS</span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="w-28 text-slate-500 shrink-0">Unit Kerja</dt>
                        <dd class="text-slate-700">{{ $transportRequest->user->unit_kerja ?? $transportRequest->pemohon_unit ?? '-' }}</dd>
                    </div>
                    @if($transportRequest->user)
                    <div class="flex gap-2">
                        <dt class="w-28 text-slate-500 shrink-0">NIP</dt>
                        <dd class="text-slate-700 font-mono">{{ $transportRequest->user->nip ?? '-' }}</dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="w-28 text-slate-500 shrink-0">Jabatan</dt>
                        <dd class="text-slate-700">{{ $transportRequest->user->jabatan ?? '-' }}</dd>
                    </div>
                    @endif
                    @if($transportRequest->jenis === 'ambulance')
                    <div class="border-t border-slate-100 pt-2 mt-1">
                        <div class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Data Pasien</div>
                        <div class="space-y-1.5">
                            <div class="flex gap-2">
                                <dt class="w-28 text-slate-500 shrink-0">Nama Pasien</dt>
                                <dd class="text-slate-800 font-medium">{{ $transportRequest->pasien_nama ?? '-' }}</dd>
                            </div>
                            <div class="flex gap-2">
                                <dt class="w-28 text-slate-500 shrink-0">No. RM</dt>
                                <dd class="text-slate-700 font-mono">{{ $transportRequest->pasien_no_rm ?? '-' }}</dd>
                            </div>
                            <div class="flex gap-2">
                                <dt class="w-28 text-slate-500 shrink-0">Alamat Pasien</dt>
                                <dd class="text-slate-700">{{ $transportRequest->alamat_pasien ?? '-' }}</dd>
                            </div>
                        </div>
                    </div>
                    @endif
                </dl>
            </div>

            {{-- Kendaraan & Supir --}}
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
                <div class="px-3 py-2 border-b border-slate-100 bg-slate-50">
                    <h2 class="text-xs font-semibold text-slate-800">Kendaraan &amp; Supir</h2>
                </div>
                <dl class="px-3 py-2.5 text-xs space-y-2">
                    <div class="flex gap-2">
                        <dt class="w-28 text-slate-500 shrink-0">Unit Kendaraan</dt>
                        <dd class="text-slate-800 font-medium capitalize">
                            {{ $transportRequest->unit_mobil ? str_replace('_', ' ', $transportRequest->unit_mobil) : '-' }}
                        </dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="w-28 text-slate-500 shrink-0">Plat Nomor</dt>
                        <dd class="text-slate-700 font-mono">{{ $transportRequest->plat_nomor ?? '-' }}</dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="w-28 text-slate-500 shrink-0">Supir</dt>
                        <dd class="text-slate-800 font-medium">{{ $transportRequest->driver->name ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Data Perjalanan --}}
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
                <div class="px-3 py-2 border-b border-slate-100 bg-slate-50">
                    <h2 class="text-xs font-semibold text-slate-800">Data Perjalanan</h2>
                </div>
                <dl class="px-3 py-2.5 text-xs space-y-2">
                    <div class="flex gap-2">
                        <dt class="w-28 text-slate-500 shrink-0">KM Awal</dt>
                        <dd class="text-slate-700">{{ $transportRequest->km_awal ? number_format($transportRequest->km_awal, 0, ',', '.') . ' km' : '-' }}</dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="w-28 text-slate-500 shrink-0">KM Akhir</dt>
                        <dd class="text-slate-700">{{ $transportRequest->km_akhir ? number_format($transportRequest->km_akhir, 0, ',', '.') . ' km' : '-' }}</dd>
                    </div>
                    @if($transportRequest->km_awal && $transportRequest->km_akhir)
                    <div class="flex gap-2">
                        <dt class="w-28 text-slate-500 shrink-0">Jarak Tempuh</dt>
                        <dd class="font-semibold text-emerald-700">{{ number_format($transportRequest->km_akhir - $transportRequest->km_awal, 0, ',', '.') }} km</dd>
                    </div>
                    @endif
                    <div class="flex gap-2">
                        <dt class="w-28 text-slate-500 shrink-0">Jam Tiba</dt>
                        <dd class="text-slate-700">{{ $transportRequest->jam_kedatangan ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

        </div>

        {{-- Tanda Tangan --}}
        <div class="mt-3 bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="px-3 py-2 border-b border-slate-100 bg-slate-50">
                <h2 class="text-xs font-semibold text-slate-800">Riwayat Tanda Tangan</h2>
            </div>
            <div class="px-3 py-2.5 grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                @foreach([
                    ['label' => 'Pemohon',     'signed' => $transportRequest->signature_pemohon,     'at' => $transportRequest->signature_pemohon_at,     'name' => $transportRequest->user->full_name ?? $transportRequest->pemohon_nama],
                    ['label' => 'Pengelola 1', 'signed' => $transportRequest->signature_pengelola_1, 'at' => $transportRequest->signature_pengelola_1_at, 'name' => $transportRequest->signature_pengelola_1_name],
                    ['label' => 'Supir',       'signed' => $transportRequest->signature_driver,      'at' => $transportRequest->signature_driver_at,      'name' => $transportRequest->driver->name ?? null],
                    ['label' => 'Pengelola 2', 'signed' => $transportRequest->signature_pengelola_2, 'at' => $transportRequest->signature_pengelola_2_at, 'name' => $transportRequest->signature_pengelola_2_name],
                ] as $ttd)
                <div class="text-center p-2 rounded-lg {{ $ttd['signed'] ? 'bg-emerald-50 border border-emerald-200' : 'bg-slate-50 border border-slate-200' }}">
                    <div class="text-[10px] font-semibold {{ $ttd['signed'] ? 'text-emerald-700' : 'text-slate-400' }} mb-1">
                        {{ $ttd['label'] }}
                    </div>
                    @if($ttd['signed'])
                        <svg class="w-4 h-4 text-emerald-600 mx-auto mb-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        @if($ttd['name'])
                            <div class="text-[10px] text-slate-700 font-medium truncate">{{ $ttd['name'] }}</div>
                        @endif
                        @if($ttd['at'])
                            <div class="text-[9px] text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($ttd['at'])->format('d/m/Y H:i') }}</div>
                        @endif
                    @else
                        <svg class="w-4 h-4 text-slate-300 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-[9px] text-slate-400 mt-0.5">Belum TTD</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>
