<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <!-- Header -->
            <div class="bg-emerald-50 px-5 py-4 flex items-center gap-4 border-b border-emerald-100">
                <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-emerald-100 flex-shrink-0">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-slate-900 mb-0.5">Pengajuan Berhasil</h1>
                    <p class="text-slate-500 text-sm">Nomor Referensi: <span class="font-semibold text-emerald-600">#{{ $item->id }}</span></p>
                </div>
            </div>

            <!-- Details -->
            <div class="px-6 py-2">
                <dl class="divide-y divide-slate-100 text-sm">
                    <div class="py-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 sm:gap-4">
                        <dt class="text-slate-500">Jenis Pengajuan</dt>
                        <dd class="font-medium text-slate-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wide {{ $item->jenis === 'ambulance' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $item->jenis }}
                            </span>
                        </dd>
                    </div>

                    @if ($item->unit_mobil)
                    <div class="py-4 flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4">
                        <dt class="text-slate-500 sm:whitespace-nowrap">Unit Mobil</dt>
                        <dd class="font-medium text-slate-900 sm:text-right uppercase">{{ str_replace('_', ' ', $item->unit_mobil) }}</dd>
                    </div>
                    @endif

                    @if ($item->prioritas)
                    <div class="py-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 sm:gap-4">
                        <dt class="text-slate-500 sm:whitespace-nowrap">Prioritas</dt>
                        <dd class="font-medium text-slate-900 sm:text-right">
                            @if($item->prioritas === 'segera')
                                <span class="bg-red-50 text-red-600 font-bold uppercase text-xs px-2.5 py-0.5 rounded-full inline-flex items-center ring-1 ring-red-200">Segera / Cito</span>
                            @else
                                <span class="bg-slate-50 text-slate-600 font-bold uppercase text-xs px-2.5 py-0.5 rounded-full inline-flex items-center ring-1 ring-slate-200">Biasa</span>
                            @endif
                        </dd>
                    </div>
                    @endif

                    @if ($item->keperluan)
                    <div class="py-4 flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4">
                        <dt class="text-slate-500 sm:whitespace-nowrap">Keperluan</dt>
                        <dd class="font-medium text-slate-900 sm:text-right">{{ $item->keperluan }}</dd>
                    </div>
                    @endif

                    @if ($item->keterangan)
                    <div class="py-4 flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4">
                        <dt class="text-slate-500 sm:whitespace-nowrap">Keterangan Tambahan</dt>
                        <dd class="font-medium text-slate-900 sm:text-right">{{ $item->keterangan }}</dd>
                    </div>
                    @endif

                    <div class="py-4 flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4">
                        <dt class="text-slate-500 sm:whitespace-nowrap">Jadwal Penggunaan</dt>
                        <dd class="font-medium text-slate-900 sm:text-right">
                            {{ $item->tanggal?->format('d/m/Y') }} {{ substr($item->jam, 0, 5) }}
                            @if ($item->tanggal_sampai && $item->jam_sampai)
                                <span class="text-slate-400 font-normal mx-1">s/d</span>
                                {{ $item->tanggal_sampai?->format('d/m/Y') }} {{ substr($item->jam_sampai, 0, 5) }}
                            @endif
                        </dd>
                    </div>

                    @if ($item->kontak)
                    <div class="py-4 flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4">
                        <dt class="text-slate-500 sm:whitespace-nowrap">Kontak Pemohon</dt>
                        <dd class="font-medium text-slate-900 sm:text-right">{{ $item->kontak }}</dd>
                    </div>
                    @endif

                    @if ($item->alamat_asal || $item->alamat_tujuan)
                    <div class="py-4 flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4">
                        <dt class="text-slate-500 sm:whitespace-nowrap">Rute Perjalanan</dt>
                        <dd class="font-medium text-slate-900 sm:text-right">
                            @if($item->alamat_asal) {{ $item->alamat_asal }} @else - @endif
                            <span class="text-slate-400 mx-1">&rarr;</span> 
                            @if($item->alamat_tujuan) {{ $item->alamat_tujuan }} @else - @endif
                        </dd>
                    </div>
                    @endif

                    @if ($item->jenis === 'ambulance' && $item->pasien_nama)
                    <div class="py-4 flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4">
                        <dt class="text-slate-500 sm:whitespace-nowrap">Identitas Pasien</dt>
                        <dd class="font-medium text-slate-900 sm:text-right">
                            {{ $item->pasien_nama }}
                            @if ($item->pasien_no_rm)
                                <span class="text-slate-500 font-normal ml-1">(RM: {{ $item->pasien_no_rm }})</span>
                            @endif
                        </dd>
                    </div>
                    @endif

                    @if ($item->jenis === 'ambulance' && $item->alamat_pasien)
                    <div class="py-4 flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4">
                        <dt class="text-slate-500 sm:whitespace-nowrap">Alamat Pasien</dt>
                        <dd class="font-medium text-slate-900 sm:text-right">{{ $item->alamat_pasien }}</dd>
                    </div>
                    @endif

                    <div class="py-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 sm:gap-4">
                        <dt class="text-slate-500">Status</dt>
                        <dd class="font-bold text-emerald-600">{{ ucfirst($item->status) }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Actions -->
            <div class="bg-slate-50 px-6 py-5 border-t border-slate-100 flex flex-col-reverse sm:flex-row gap-3 sm:justify-end">
                <a href="{{ route('pengajuan.index') }}" class="inline-flex justify-center items-center px-5 py-2.5 border border-slate-300 shadow-sm text-sm font-semibold rounded-xl text-slate-700 bg-white hover:bg-slate-50 transition-colors w-full sm:w-auto">
                    Lihat Riwayat
                </a>
                <a href="{{ route('dashboard') }}" class="inline-flex justify-center items-center px-5 py-2.5 border border-transparent shadow-sm text-sm font-semibold rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 transition-colors w-full sm:w-auto">
                    Buat Pengajuan Baru
                </a>
            </div>
        </div>
    </div>
</x-app-layout>