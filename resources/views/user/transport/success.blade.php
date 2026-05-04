<x-app-layout>
@php
    $statusCfg = match($item->status) {
        'diajukan'        => ['bg'=>'bg-amber-100',   'text'=>'text-amber-800',   'border'=>'border-amber-300',   'dot'=>'bg-amber-400',   'label'=>'Diajukan'],
        'diproses'        => ['bg'=>'bg-blue-100',    'text'=>'text-blue-800',    'border'=>'border-blue-300',    'dot'=>'bg-blue-500',    'label'=>'Disetujui'],
        'digunakan'       => ['bg'=>'bg-cyan-100',    'text'=>'text-cyan-800',    'border'=>'border-cyan-300',    'dot'=>'bg-cyan-500',    'label'=>'Digunakan'],
        'selesai'         => ['bg'=>'bg-emerald-100', 'text'=>'text-emerald-800', 'border'=>'border-emerald-300', 'dot'=>'bg-emerald-500', 'label'=>'Selesai'],
        'tidak_disetujui' => ['bg'=>'bg-red-100',     'text'=>'text-red-800',     'border'=>'border-red-300',     'dot'=>'bg-red-500',     'label'=>'Tidak Disetujui'],
        default           => ['bg'=>'bg-slate-100',   'text'=>'text-slate-800',   'border'=>'border-slate-300',   'dot'=>'bg-slate-400',   'label'=>ucfirst($item->status)],
    };
    $steps = ['diajukan','diproses','digunakan','selesai'];
    $currentStep = array_search($item->status, $steps);
    $isRejected = $item->status === 'tidak_disetujui';
@endphp

<div class="max-w-3xl mx-auto px-3 pt-3 pb-4 space-y-2.5">

    {{-- ── TOP BAR ── --}}
    <div class="flex items-center justify-between gap-2">
        <div>
            <div class="flex items-center gap-2 flex-wrap">
                <h1 class="text-sm font-bold text-slate-800">Detail Pengajuan</h1>
                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusCfg['bg'] }} {{ $statusCfg['text'] }} border {{ $statusCfg['border'] }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $statusCfg['dot'] }}"></span>
                    {{ $statusCfg['label'] }}
                </span>
                @if($item->prioritas === 'segera')
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-red-600 text-white">⚡ CITO</span>
                @endif
            </div>
            <p class="text-[10px] text-slate-400 mt-0.5 font-mono">{{ $item->nomor_pengajuan }}</p>
        </div>
        <a href="{{ route('pengajuan.index') }}"
           class="inline-flex items-center gap-1 rounded-lg border border-slate-300 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition shrink-0">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Riwayat
        </a>
    </div>

    {{-- ── STEPPER / REJECTED BANNER ── --}}
    @if(!$isRejected)
    <div class="bg-white rounded-lg border border-slate-200 px-3 py-2">
        <div class="flex items-center relative">
            <div class="absolute left-3 right-3 top-3 h-px bg-slate-200 z-0"></div>
            @foreach(['diajukan'=>'Diajukan','diproses'=>'Disetujui','digunakan'=>'Digunakan','selesai'=>'Selesai'] as $step=>$stepLabel)
                @php
                    $idx    = array_search($step, $steps);
                    $done   = $currentStep !== false && $idx <= $currentStep;
                    $active = $step === $item->status;
                @endphp
                <div class="relative z-10 flex flex-col items-center flex-1">
                    <div class="w-6 h-6 rounded-full flex items-center justify-center text-[9px] font-bold border-2
                        {{ $done ? 'bg-emerald-600 border-emerald-600 text-white' : 'bg-white border-slate-300 text-slate-400' }}
                        {{ $active ? 'ring-2 ring-emerald-300 ring-offset-1' : '' }}">
                        @if($done && !$active)
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        @else
                            {{ $idx + 1 }}
                        @endif
                    </div>
                    <span class="text-[9px] font-medium mt-0.5 {{ $done ? 'text-emerald-700' : 'text-slate-400' }} whitespace-nowrap">{{ $stepLabel }}</span>
                </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="flex items-start gap-2 bg-red-50 border border-red-200 rounded-lg px-3 py-2">
        <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
        <p class="text-xs font-semibold text-red-700">Tidak Disetujui
            @if($item->rejection_reason)
                <span class="font-normal text-red-600"> — {{ $item->rejection_reason }}</span>
            @endif
        </p>
    </div>
    @endif

    {{-- ── SINGLE COLUMN STACK ── --}}
    <div class="flex flex-col gap-2.5">

        {{-- TOP: Info Pengajuan + Pasien --}}
        <div class="space-y-2.5">

            {{-- Info Pengajuan --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 border-b border-slate-200">
                    <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h2 class="text-[10px] font-bold text-slate-600 uppercase tracking-wide">Informasi Pengajuan</h2>
                </div>
                <div class="px-3 py-1">
                    <table class="w-full text-xs">
                        <tbody class="divide-y divide-slate-100">
                            <tr>
                                <td class="py-1.5 pr-3 text-slate-400 whitespace-nowrap w-20">Jenis</td>
                                <td class="py-1.5">
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-bold {{ $item->jenis === 'ambulance' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ ucfirst($item->jenis) }}
                                    </span>
                                    @if($item->keperluan)
                                        <span class="text-slate-500 ml-1">· {{ ucfirst($item->keperluan) }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1.5 pr-3 text-slate-400 whitespace-nowrap">Jadwal</td>
                                <td class="py-1.5 font-medium text-slate-800 text-[11px]">
                                    {{ $item->tanggal?->format('d M Y') }}, {{ substr($item->jam, 0, 5) }}
                                    @if($item->tanggal_sampai && $item->jam_sampai)
                                        <span class="text-slate-400 font-normal block">→ {{ $item->tanggal_sampai->format('d M Y') }}, {{ substr($item->jam_sampai, 0, 5) }}</span>
                                    @else
                                        <span class="text-slate-400 font-normal"> → Selesai</span>
                                    @endif
                                </td>
                            </tr>
                            @if($item->alamat_tujuan || $item->alamat_asal)
                            <tr>
                                <td class="py-1.5 pr-3 text-slate-400 whitespace-nowrap">Rute</td>
                                <td class="py-1.5 text-[11px] text-slate-800">
                                    <span class="text-slate-500">{{ $item->alamat_asal ?: 'RS Azra' }}</span>
                                    <span class="text-slate-400 mx-1">→</span>
                                    <span class="font-medium">{{ $item->alamat_tujuan ?: '-' }}</span>
                                </td>
                            </tr>
                            @endif
                            @if($item->jumlah_penumpang)
                            <tr>
                                <td class="py-1.5 pr-3 text-slate-400 whitespace-nowrap">Penumpang</td>
                                <td class="py-1.5 font-medium text-slate-800">{{ $item->jumlah_penumpang }} orang</td>
                            </tr>
                            @endif
                            @if($item->keterangan)
                            <tr>
                                <td class="py-1.5 pr-3 text-slate-400 whitespace-nowrap">Keterangan</td>
                                <td class="py-1.5 text-slate-700">{{ $item->keterangan }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="py-1.5 pr-3 text-slate-400 whitespace-nowrap">Dibuat</td>
                                <td class="py-1.5 text-slate-400 text-[10px]">{{ $item->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Data Pasien (ambulance) --}}
            @if($item->jenis === 'ambulance' && $item->pasien_nama)
            <div class="bg-white rounded-xl border border-rose-200 shadow-sm overflow-hidden">
                <div class="flex items-center gap-2 px-3 py-1.5 bg-rose-50 border-b border-rose-200">
                    <svg class="w-3 h-3 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <h2 class="text-[10px] font-bold text-rose-700 uppercase tracking-wide">Data Pasien</h2>
                </div>
                <div class="px-3 py-1">
                    <table class="w-full text-xs">
                        <tbody class="divide-y divide-slate-100">
                            <tr>
                                <td class="py-1.5 pr-3 text-slate-400 whitespace-nowrap w-20">Nama</td>
                                <td class="py-1.5 font-medium text-slate-800">{{ $item->pasien_nama }}</td>
                            </tr>
                            @if($item->pasien_no_rm)
                            <tr>
                                <td class="py-1.5 pr-3 text-slate-400">No. RM</td>
                                <td class="py-1.5 font-mono text-slate-800">{{ $item->pasien_no_rm }}</td>
                            </tr>
                            @endif
                            @if($item->alamat_pasien)
                            <tr>
                                <td class="py-1.5 pr-3 text-slate-400">Alamat</td>
                                <td class="py-1.5 text-slate-800">{{ $item->alamat_pasien }}</td>
                            </tr>
                            @endif
                            @if($item->pendamping_nama)
                            <tr>
                                <td class="py-1.5 pr-3 text-slate-400">Pendamping</td>
                                <td class="py-1.5 text-slate-800">{{ $item->pendamping_nama }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>{{-- end top --}}

        {{-- BOTTOM: Kendaraan + Aksi --}}
        <div class="space-y-2.5">

            {{-- Kendaraan & Perjalanan --}}
            @if(in_array($item->status, ['digunakan','selesai']) && $item->unit_mobil)
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 border-b border-slate-200">
                    <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM3 4h13l2 4H3V4z"/>
                    </svg>
                    <h2 class="text-[10px] font-bold text-slate-600 uppercase tracking-wide">Kendaraan & Perjalanan</h2>
                </div>
                <div class="px-3 py-2 grid grid-cols-2 gap-1.5 text-xs">
                    <div class="bg-slate-50 rounded-lg p-2 border border-slate-200">
                        <p class="text-[9px] text-slate-400 font-medium mb-0.5">Unit</p>
                        <p class="font-bold text-slate-800 text-[11px]">{{ $item->unit_mobil }}</p>
                        @if($item->plat_nomor)<p class="text-[10px] text-slate-500 font-mono">{{ $item->plat_nomor }}</p>@endif
                    </div>
                    @if($item->driver)
                    <div class="bg-slate-50 rounded-lg p-2 border border-slate-200">
                        <p class="text-[9px] text-slate-400 font-medium mb-0.5">Pengemudi</p>
                        <p class="font-bold text-slate-800 text-[11px]">{{ $item->driver->name }}</p>
                    </div>
                    @endif
                    @if($item->km_awal)
                    <div class="bg-emerald-50 rounded-lg p-2 border border-emerald-200">
                        <p class="text-[9px] text-emerald-600 font-medium mb-0.5">KM Berangkat</p>
                        <p class="font-bold text-emerald-800 text-[11px]">{{ number_format($item->km_awal, 0, ',', '.') }} km</p>
                    </div>
                    @endif
                    @if($item->km_akhir)
                    <div class="bg-emerald-50 rounded-lg p-2 border border-emerald-200">
                        <p class="text-[9px] text-emerald-600 font-medium mb-0.5">KM Tiba</p>
                        <p class="font-bold text-emerald-800 text-[11px]">{{ number_format($item->km_akhir, 0, ',', '.') }} km</p>
                    </div>
                    @endif
                    @if($item->km_awal && $item->km_akhir)
                    <div class="col-span-2 bg-emerald-50 rounded-lg p-2 border border-emerald-200 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        <div>
                            <p class="text-[9px] text-emerald-600 font-medium">Total Jarak</p>
                            <p class="font-bold text-emerald-800 text-[11px]">{{ number_format($item->km_akhir - $item->km_awal, 0, ',', '.') }} km</p>
                        </div>
                    </div>
                    @endif
                    @if($item->jam_kedatangan)
                    <div class="col-span-2 bg-slate-50 rounded-lg p-2 border border-slate-200 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-[9px] text-slate-400 font-medium">Jam Kedatangan</p>
                            <p class="font-bold text-slate-800 text-[11px]">{{ $item->jam_kedatangan }} WIB</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Aksi --}}
            <div class="flex flex-row justify-end gap-2">
                @if($item->status === 'selesai')
                <a href="{{ route('pengajuan.print', $item) }}" target="_blank"
                   class="inline-flex justify-center items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold bg-emerald-600 hover:bg-emerald-700 transition shadow-sm"
                   style="color: white !important;">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak Surat
                </a>
                @endif
                <a href="{{ route('dashboard') }}"
                   class="inline-flex justify-center items-center px-4 py-2 rounded-xl text-xs font-semibold bg-emerald-600 hover:bg-emerald-700 transition shadow-sm"
                   style="color: white !important;">
                    Buat Pengajuan Baru
                </a>
            </div>

        </div>{{-- end bottom --}}

    </div>{{-- end stack --}}

</div>
</x-app-layout>
