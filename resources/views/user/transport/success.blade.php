<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 py-4">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <!-- Header -->
            <div class="bg-emerald-50 px-3 py-2.5 flex items-center gap-3 border-b border-emerald-100">
                <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 flex-shrink-0">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-sm font-bold text-slate-900">Pengajuan Berhasil</h1>
                    <p class="text-slate-500 text-xs">Ref: <span class="font-semibold text-emerald-600">#{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</span></p>
                </div>
            </div>

            <!-- Details -->
            <div class="px-3 py-2">
                <dl class="divide-y divide-slate-100 text-xs">
                    <div class="py-2 flex justify-between items-center gap-3">
                        <dt class="text-slate-500">Jenis</dt>
                        <dd class="font-medium text-slate-900">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $item->jenis === 'ambulance' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $item->jenis }}
                            </span>
                        </dd>
                    </div>

                    @if ($item->unit_mobil)
                    <div class="py-2 flex justify-between gap-3">
                        <dt class="text-slate-500">Unit Mobil</dt>
                        <dd class="font-medium text-slate-900 text-right uppercase">{{ str_replace('_', ' ', $item->unit_mobil) }}</dd>
                    </div>
                    @endif

                    @if ($item->prioritas)
                    <div class="py-2 flex justify-between items-center gap-3">
                        <dt class="text-slate-500">Prioritas</dt>
                        <dd class="font-medium text-slate-900">
                            @if($item->prioritas === 'segera')
                                <span class="bg-red-50 text-red-600 font-bold uppercase text-[10px] px-2 py-0.5 rounded-full inline-flex items-center ring-1 ring-red-200">CITO</span>
                            @else
                                <span class="bg-slate-50 text-slate-600 font-bold uppercase text-[10px] px-2 py-0.5 rounded-full inline-flex items-center ring-1 ring-slate-200">Biasa</span>
                            @endif
                        </dd>
                    </div>
                    @endif

                    @if ($item->keperluan)
                    <div class="py-2 flex justify-between gap-3">
                        <dt class="text-slate-500">Keperluan</dt>
                        <dd class="font-medium text-slate-900 text-right">{{ $item->keperluan }}</dd>
                    </div>
                    @endif

                    @if ($item->keterangan)
                    <div class="py-2 flex justify-between gap-3">
                        <dt class="text-slate-500">Keterangan</dt>
                        <dd class="font-medium text-slate-900 text-right">{{ $item->keterangan }}</dd>
                    </div>
                    @endif

                    <div class="py-2 flex justify-between gap-3">
                        <dt class="text-slate-500">Jadwal</dt>
                        <dd class="font-medium text-slate-900 text-right">
                            {{ $item->tanggal?->format('d/m/Y') }} {{ substr($item->jam, 0, 5) }}
                            @if ($item->tanggal_sampai && $item->jam_sampai)
                                <span class="text-slate-400 font-normal mx-1">-</span>
                                {{ $item->tanggal_sampai?->format('d/m/Y') }} {{ substr($item->jam_sampai, 0, 5) }}
                            @endif
                        </dd>
                    </div>

                    @if ($item->kontak)
                    <div class="py-2 flex justify-between gap-3">
                        <dt class="text-slate-500">Kontak</dt>
                        <dd class="font-medium text-slate-900 text-right">{{ $item->kontak }}</dd>
                    </div>
                    @endif

                    @if ($item->alamat_asal || $item->alamat_tujuan)
                    <div class="py-2 flex justify-between gap-3">
                        <dt class="text-slate-500">Rute</dt>
                        <dd class="font-medium text-slate-900 text-right">
                            @if($item->alamat_asal) {{ $item->alamat_asal }} @else - @endif
                            <span class="text-slate-400 mx-1">→</span> 
                            @if($item->alamat_tujuan) {{ $item->alamat_tujuan }} @else - @endif
                        </dd>
                    </div>
                    @endif

                    @if ($item->jenis === 'ambulance' && $item->pasien_nama)
                    <div class="py-2 flex justify-between gap-3">
                        <dt class="text-slate-500">Pasien</dt>
                        <dd class="font-medium text-slate-900 text-right">
                            {{ $item->pasien_nama }}
                            @if ($item->pasien_no_rm)
                                <span class="text-slate-500 font-normal ml-1">(RM: {{ $item->pasien_no_rm }})</span>
                            @endif
                        </dd>
                    </div>
                    @endif

                    @if ($item->jenis === 'ambulance' && $item->alamat_pasien)
                    <div class="py-2 flex justify-between gap-3">
                        <dt class="text-slate-500">Alamat Pasien</dt>
                        <dd class="font-medium text-slate-900 text-right">{{ $item->alamat_pasien }}</dd>
                    </div>
                    @endif

                    <div class="py-2 flex justify-between items-center gap-3">
                        <dt class="text-slate-500">Status</dt>
                        <dd>
                            @php
                                $statusConfig = match($item->status) {
                                    'diajukan' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'label' => 'Diajukan'],
                                    'diproses' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Disetujui'],
                                    'digunakan' => ['bg' => 'bg-cyan-100', 'text' => 'text-cyan-800', 'label' => 'Digunakan'],
                                    'selesai' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'label' => 'Selesai'],
                                    'tidak_disetujui' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Tidak Disetujui'],
                                    default => ['bg' => 'bg-slate-100', 'text' => 'text-slate-800', 'label' => ucfirst($item->status)]
                                };
                            @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                {{ $statusConfig['label'] }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Actions -->
            <div class="bg-slate-50 px-3 py-2.5 border-t border-slate-100 flex flex-col-reverse sm:flex-row gap-2 sm:justify-end">
                <a href="{{ route('pengajuan.index') }}" class="inline-flex justify-center items-center px-3 py-2 border border-slate-300 text-xs font-semibold rounded-lg text-slate-700 bg-white hover:bg-slate-50 transition-colors w-full sm:w-auto">
                    Lihat Riwayat
                </a>
                <a href="{{ route('dashboard') }}" class="inline-flex justify-center items-center px-3 py-2 border border-transparent text-xs font-semibold rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 transition-colors w-full sm:w-auto">
                    <span class="text-white font-semibold">Buat Pengajuan Baru</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
