<x-app-layout>
@php
    $colors = [
        'diajukan'        => ['bg' => 'bg-amber-100',   'text' => 'text-amber-800',   'border' => 'border-amber-300',   'dot' => 'bg-amber-400'],
        'diproses'        => ['bg' => 'bg-blue-100',    'text' => 'text-blue-800',    'border' => 'border-blue-300',    'dot' => 'bg-blue-500'],
        'digunakan'       => ['bg' => 'bg-cyan-100',    'text' => 'text-cyan-800',    'border' => 'border-cyan-300',    'dot' => 'bg-cyan-500'],
        'selesai'         => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'border' => 'border-emerald-300', 'dot' => 'bg-emerald-500'],
        'tidak_disetujui' => ['bg' => 'bg-red-100',     'text' => 'text-red-800',     'border' => 'border-red-300',     'dot' => 'bg-red-500'],
    ];
    $sc = $colors[$transportRequest->status] ?? $colors['diajukan'];
    $label = match($transportRequest->status) {
        'diproses'        => 'Disetujui',
        'digunakan'       => 'Digunakan',
        'tidak_disetujui' => 'Tidak Disetujui',
        default           => ucfirst($transportRequest->status)
    };
    $steps = ['diajukan','diproses','digunakan','selesai'];
    $currentStep = array_search($transportRequest->status, $steps);
    $isRejected = $transportRequest->status === 'tidak_disetujui';
@endphp

<div class="max-w-5xl mx-auto px-3 sm:px-4 pt-4 pb-8 space-y-4">

    {{-- ── TOP BAR ── --}}
    <div class="flex flex-wrap items-start justify-between gap-3">
        <div>
            <div class="flex items-center gap-2 flex-wrap">
                <h1 class="text-base font-bold text-slate-800">Detail Pengajuan</h1>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $sc['bg'] }} {{ $sc['text'] }} border {{ $sc['border'] }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $sc['dot'] }}"></span>
                    {{ $label }}
                </span>
                @if($transportRequest->prioritas === 'segera')
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-600 text-white">⚡ CITO</span>
                @endif
            </div>
            <p class="text-[11px] text-slate-400 mt-0.5 font-mono">{{ $transportRequest->nomor_pengajuan }}</p>
        </div>
        <div class="flex items-center gap-2">
            @if($transportRequest->status === 'selesai')
                <a href="{{ route('admin.transport.print', $transportRequest) }}" target="_blank"
                   class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold bg-teal-700 hover:bg-teal-800 transition"
                   style="color: white !important;">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak Surat
                </a>
            @endif
            <a href="{{ route('admin.transport.index') }}"
               class="inline-flex items-center gap-1 rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- ── ALERTS ── --}}
    @if(session('success'))
        <div class="flex items-center gap-2 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-medium">
            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="p-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-xs">
            <div class="font-semibold mb-1">Periksa kembali:</div>
            <ul class="list-disc ml-4 space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    {{-- ── PROGRESS STEPPER ── --}}
    @if(!$isRejected)
    <div class="bg-white rounded-lg border border-slate-200 px-3 py-2">
        <div class="flex items-center relative">
            <div class="absolute left-3 right-3 top-3 h-px bg-slate-200 z-0"></div>
            @foreach(['diajukan' => 'Diajukan', 'diproses' => 'Disetujui', 'digunakan' => 'Digunakan', 'selesai' => 'Selesai'] as $step => $stepLabel)
                @php
                    $stepIdx = array_search($step, $steps);
                    $done    = $currentStep !== false && $stepIdx <= $currentStep;
                    $active  = $step === $transportRequest->status;
                @endphp
                <div class="relative z-10 flex flex-col items-center flex-1">
                    <div class="w-6 h-6 rounded-full flex items-center justify-center text-[9px] font-bold border-2
                        {{ $done ? 'bg-teal-700 border-teal-700 text-white' : 'bg-white border-slate-300 text-slate-400' }}
                        {{ $active ? 'ring-2 ring-teal-300 ring-offset-1' : '' }}">
                        @if($done && !$active)
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        @else
                            {{ $stepIdx + 1 }}
                        @endif
                    </div>
                    <span class="text-[9px] font-medium mt-0.5 {{ $done ? 'text-teal-700' : 'text-slate-400' }} whitespace-nowrap">{{ $stepLabel }}</span>
                </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="flex items-center gap-2 bg-red-50 border border-red-200 rounded-lg px-3 py-2">
        <svg class="w-4 h-4 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
        <p class="text-xs font-semibold text-red-700">Tidak Disetujui
            @if($transportRequest->rejection_reason)
                <span class="font-normal text-red-600"> — {{ $transportRequest->rejection_reason }}</span>
            @endif
        </p>
    </div>
    @endif

    {{-- ── MAIN GRID ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- ── LEFT COLUMN: Info Cards ── --}}
        <div class="lg:col-span-2 space-y-3">

            {{-- Card: Informasi Pengajuan --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="flex items-center gap-2 px-3 py-2 bg-slate-50 border-b border-slate-200">
                    <svg class="w-3 h-3 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h2 class="text-[10px] font-bold text-slate-600 uppercase tracking-wide">Informasi Pengajuan</h2>
                </div>
                <div class="px-3 py-2">
                    <table class="w-full text-xs">
                        <tbody class="divide-y divide-slate-100">
                            <tr>
                                <td class="py-1 pr-3 text-slate-400 whitespace-nowrap w-28">Pemohon</td>
                                <td class="py-1 font-medium text-slate-800">
                                    {{ $transportRequest->user->full_name ?? $transportRequest->pemohon_nama }}
                                    <span class="text-slate-400 font-normal"> · {{ $transportRequest->user->unit_kerja ?? $transportRequest->pemohon_unit }}</span>
                                    @if($transportRequest->user->nip ?? null)
                                        <span class="text-slate-400 font-mono font-normal"> · {{ $transportRequest->user->nip }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1 pr-3 text-slate-400 whitespace-nowrap">Jenis</td>
                                <td class="py-1">
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-bold {{ $transportRequest->jenis === 'ambulance' ? 'bg-rose-100 text-rose-700' : 'bg-teal-100 text-teal-700' }}">
                                        {{ ucfirst($transportRequest->jenis) }}
                                    </span>
                                    @if($transportRequest->jenis === 'ambulance' && $transportRequest->keperluan)
                                        <span class="text-slate-500 ml-1">({{ ucfirst($transportRequest->keperluan) }})</span>
                                    @endif
                                    @if($transportRequest->jenis === 'umum' && $transportRequest->jumlah_penumpang)
                                        <span class="text-slate-500 ml-1">· {{ $transportRequest->jumlah_penumpang }} penumpang</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1 pr-3 text-slate-400 whitespace-nowrap">Jadwal</td>
                                <td class="py-1 font-medium text-slate-800">
                                    {{ $transportRequest->tanggal->format('d M Y') }}, {{ substr($transportRequest->jam, 0, 5) }}
                                    @if($transportRequest->tanggal_sampai && $transportRequest->jam_sampai)
                                        <span class="text-slate-400">→</span> {{ $transportRequest->tanggal_sampai->format('d M Y') }}, {{ substr($transportRequest->jam_sampai, 0, 5) }}
                                    @else
                                        <span class="text-slate-400">→ Sampai Selesai</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1 pr-3 text-slate-400 whitespace-nowrap">Tujuan</td>
                                <td class="py-1 font-medium text-slate-800">
                                    {{ $transportRequest->alamat_tujuan ?? '-' }}
                                    @if($transportRequest->alamat_asal)
                                        <span class="text-slate-400 font-normal"> (dari: {{ $transportRequest->alamat_asal }})</span>
                                    @endif
                                </td>
                            </tr>
                            @if($transportRequest->keperluan && $transportRequest->jenis === 'umum')
                            <tr>
                                <td class="py-1 pr-3 text-slate-400 whitespace-nowrap">Keperluan</td>
                                <td class="py-1 text-slate-700">{{ $transportRequest->keperluan }}</td>
                            </tr>
                            @endif
                            @if($transportRequest->keterangan)
                            <tr>
                                <td class="py-1 pr-3 text-slate-400 whitespace-nowrap">Keterangan</td>
                                <td class="py-1 text-slate-700">{{ $transportRequest->keterangan }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="py-1 pr-3 text-slate-400 whitespace-nowrap">Dibuat</td>
                                <td class="py-1 text-slate-400">{{ $transportRequest->created_at->format('d M Y, H:i') }} WIB</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Card: Data Pasien (ambulance only) --}}
            @if($transportRequest->jenis === 'ambulance')
            <div class="bg-white rounded-xl border border-rose-200 shadow-sm overflow-hidden">
                <div class="flex items-center gap-2 px-3 py-2 bg-rose-50 border-b border-rose-200">
                    <svg class="w-3 h-3 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <h2 class="text-[10px] font-bold text-rose-700 uppercase tracking-wide">Data Pasien</h2>
                </div>
                <div class="px-3 py-2">
                    <table class="w-full text-xs">
                        <tbody class="divide-y divide-slate-100">
                            <tr>
                                <td class="py-1 pr-3 text-slate-400 whitespace-nowrap w-28">Nama</td>
                                <td class="py-1 font-medium text-slate-800">{{ $transportRequest->pasien_nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="py-1 pr-3 text-slate-400 whitespace-nowrap">No. RM</td>
                                <td class="py-1 font-mono text-slate-800">{{ $transportRequest->pasien_no_rm ?? '-' }}</td>
                            </tr>
                            @if($transportRequest->ruangan)
                            <tr>
                                <td class="py-1 pr-3 text-slate-400 whitespace-nowrap">Ruangan</td>
                                <td class="py-1 text-slate-800">{{ $transportRequest->ruangan }}</td>
                            </tr>
                            @endif
                            @if($transportRequest->pendamping_nama)
                            <tr>
                                <td class="py-1 pr-3 text-slate-400 whitespace-nowrap">Pendamping</td>
                                <td class="py-1 text-slate-800">{{ $transportRequest->pendamping_nama }}</td>
                            </tr>
                            @endif
                            @if($transportRequest->alamat_pasien)
                            <tr>
                                <td class="py-1 pr-3 text-slate-400 whitespace-nowrap">Alamat</td>
                                <td class="py-1 text-slate-800">{{ $transportRequest->alamat_pasien }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- Card: Kendaraan & Perjalanan --}}
            @if(in_array($transportRequest->status, ['digunakan','selesai']))
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="flex items-center gap-2 px-4 py-2.5 bg-slate-50 border-b border-slate-200">
                    <svg class="w-3.5 h-3.5 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM3 4h13l2 4H3V4z"/>
                    </svg>
                    <h2 class="text-[11px] font-bold text-slate-700 uppercase tracking-wide">Kendaraan & Perjalanan</h2>
                </div>
                <div class="px-4 py-3 grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                    <div class="bg-slate-50 rounded-lg p-2.5 border border-slate-200">
                        <p class="text-[10px] text-slate-400 font-medium mb-0.5">Unit</p>
                        <p class="font-bold text-slate-800 text-[11px]">{{ $transportRequest->unit_mobil ?? '-' }}</p>
                        @if($transportRequest->plat_nomor)
                            <p class="text-[10px] text-slate-500 font-mono">{{ $transportRequest->plat_nomor }}</p>
                        @endif
                    </div>
                    <div class="bg-slate-50 rounded-lg p-2.5 border border-slate-200">
                        <p class="text-[10px] text-slate-400 font-medium mb-0.5">Pengemudi</p>
                        <p class="font-bold text-slate-800 text-[11px]">{{ $transportRequest->driver->name ?? '-' }}</p>
                        @if($transportRequest->driver?->phone)
                            <p class="text-[10px] text-slate-500">{{ $transportRequest->driver->phone }}</p>
                        @endif
                    </div>
                    <div class="bg-teal-50 rounded-lg p-2.5 border border-teal-200">
                        <p class="text-[10px] text-teal-600 font-medium mb-0.5">KM Berangkat</p>
                        <p class="font-bold text-teal-800 text-[11px]">{{ $transportRequest->km_awal ? number_format($transportRequest->km_awal, 0, ',', '.') : '-' }} km</p>
                    </div>
                    <div class="bg-teal-50 rounded-lg p-2.5 border border-teal-200">
                        <p class="text-[10px] text-teal-600 font-medium mb-0.5">KM Tiba</p>
                        <p class="font-bold text-teal-800 text-[11px]">{{ $transportRequest->km_akhir ? number_format($transportRequest->km_akhir, 0, ',', '.') : '-' }} km</p>
                    </div>
                    @if($transportRequest->km_awal && $transportRequest->km_akhir)
                    <div class="col-span-2 sm:col-span-2 bg-emerald-50 rounded-lg p-2.5 border border-emerald-200 flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        <div>
                            <p class="text-[10px] text-emerald-600 font-medium">Total Jarak</p>
                            <p class="font-bold text-emerald-800">{{ number_format($transportRequest->km_akhir - $transportRequest->km_awal, 0, ',', '.') }} km</p>
                        </div>
                    </div>
                    @endif
                    @if($transportRequest->jam_kedatangan)
                    <div class="col-span-2 sm:col-span-2 bg-slate-50 rounded-lg p-2.5 border border-slate-200 flex items-center gap-3">
                        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-[10px] text-slate-400 font-medium">Jam Kedatangan</p>
                            <p class="font-bold text-slate-800">{{ $transportRequest->jam_kedatangan }} WIB</p>
                        </div>
                    </div>
                    @endif
                    @if($transportRequest->biaya_tol)
                    <div class="col-span-2 sm:col-span-2 bg-amber-50 rounded-lg p-2.5 border border-amber-200 flex items-center gap-3">
                        <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <div>
                            <p class="text-[10px] text-amber-600 font-medium">Biaya E-Tol</p>
                            <p class="font-bold text-amber-800">Rp {{ number_format($transportRequest->biaya_tol, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif


        </div>{{-- end left column --}}

        {{-- ── RIGHT COLUMN: Admin Action ── --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden sticky top-4"
                 x-data="{ currentStatus: '{{ $transportRequest->status }}', savedStatus: '{{ $transportRequest->status }}', editOpen: false }">
                <div class="flex items-center gap-2 px-4 py-2.5 bg-teal-700 border-b border-teal-800">
                    <svg class="w-3.5 h-3.5 text-teal-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <h2 class="text-[11px] font-bold text-white uppercase tracking-wide">Eksekusi Admin</h2>
                </div>

                @php $isBlocked = false; @endphp

                <form method="POST" action="{{ route('admin.transport.update', $transportRequest) }}"
                      class="px-4 py-3 space-y-3 text-xs" id="mainFormWrapper">
                    @csrf
                    @method('PUT')

                    {{-- Status Select --}}
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-600 mb-1 uppercase tracking-wide">Ubah Status</label>
                        <select name="status" x-model="currentStatus"
                                class="w-full rounded-lg border border-slate-300 px-2.5 py-2 text-xs focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white">
                            @if($transportRequest->status === 'diajukan')
                                <option value="diajukan">Diajukan (Menunggu)</option>
                                @if($unitAvailable || ($transportRequest->user && $transportRequest->user->isPriority()))
                                    <option value="diproses">✓ Setujui</option>
                                @endif
                                <option value="tidak_disetujui">✗ Tolak</option>
                            @elseif($transportRequest->status === 'diproses')
                                <option value="diproses">Disetujui</option>
                                <option value="digunakan">→ Tandai Digunakan</option>
                            @elseif($transportRequest->status === 'digunakan')
                                <option value="digunakan">Digunakan</option>
                                <option value="selesai">✓ Tandai Selesai</option>
                            @elseif($transportRequest->status === 'selesai')
                                <option value="selesai">Selesai</option>
                            @elseif($transportRequest->status === 'tidak_disetujui')
                                <option value="tidak_disetujui">Tidak Disetujui</option>
                            @endif
                        </select>

                        @if($transportRequest->status === 'diajukan' && !$unitAvailable && !($transportRequest->user && $transportRequest->user->isPriority()))
                        <div class="mt-2 flex items-start gap-1.5 rounded-lg bg-red-50 border border-red-200 px-2.5 py-2">
                            <svg class="w-3.5 h-3.5 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            <p class="text-[10px] text-red-700">Semua unit penuh di waktu ini. Hanya bisa ditolak.</p>
                        </div>
                        @endif
                    </div>

                    {{-- Alasan Penolakan --}}
                    <div x-show="currentStatus === 'tidak_disetujui' && savedStatus === 'diajukan'">
                        <label class="block text-[10px] font-semibold text-slate-600 mb-1 uppercase tracking-wide">Alasan Penolakan <span class="text-red-500">*</span></label>
                        <textarea name="rejection_reason" rows="3"
                                  class="w-full rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-2 focus:ring-teal-500 focus:border-teal-500 resize-none"
                                  placeholder="Tuliskan alasan...">{{ old('rejection_reason') }}</textarea>
                        @error('rejection_reason')<p class="text-[10px] text-red-600 mt-0.5">{{ $message }}</p>@enderror
                    </div>

                    {{-- Form Disetujui → Digunakan --}}
                    <div x-show="currentStatus === 'digunakan' && '{{ $transportRequest->status }}' === 'diproses'" class="space-y-2.5">
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-1 uppercase tracking-wide">Unit Kendaraan <span class="text-red-500">*</span></label>
                            <select name="unit_mobil" id="unit_mobil"
                                    class="w-full rounded-lg border border-slate-300 px-2.5 py-2 text-xs focus:ring-2 focus:ring-teal-500 bg-white">
                                <option value="">-- Pilih Unit --</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->name }}" data-plate="{{ $vehicle->plate_number }}" data-last-km="{{ $vehicle->last_km ?? 0 }}"
                                            @selected(old('unit_mobil') == $vehicle->name)>
                                        {{ $vehicle->name }} ({{ $vehicle->plate_number }})
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="plat_nomor" id="plat_nomor" value="{{ old('plat_nomor', $transportRequest->plat_nomor) }}">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-1 uppercase tracking-wide">Pengemudi <span class="text-red-500">*</span></label>
                            <select name="driver_id"
                                    class="w-full rounded-lg border border-slate-300 px-2.5 py-2 text-xs focus:ring-2 focus:ring-teal-500 bg-white">
                                <option value="">-- Pilih Supir --</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}" @selected(old('driver_id', $transportRequest->driver_id) == $driver->id)>
                                        {{ $driver->name }}@if($driver->phone) · {{ $driver->phone }}@endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-1 uppercase tracking-wide">KM Keberangkatan <span class="text-red-500">*</span></label>
                            <input type="number" name="km_awal" id="km_awal" value="{{ old('km_awal', $transportRequest->km_awal) }}"
                                   class="w-full rounded-lg border border-slate-300 px-2.5 py-2 text-xs focus:ring-2 focus:ring-teal-500" placeholder="Masukkan KM" min="0">
                            <p id="km_awal_hint" class="text-[10px] text-amber-600 mt-0.5 hidden"></p>
                            <p id="km_awal_error" class="text-[10px] text-red-600 mt-0.5 hidden"></p>
                        </div>
                    </div>

                    {{-- Form Digunakan → Selesai --}}
                    <div x-show="currentStatus === 'selesai' && '{{ $transportRequest->status }}' === 'digunakan'" class="space-y-2.5">
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-1 uppercase tracking-wide">KM Tiba <span class="text-red-500">*</span></label>
                            <input type="number" name="km_akhir" id="km_akhir" value="{{ old('km_akhir', $transportRequest->km_akhir) }}"
                                   class="w-full rounded-lg border border-slate-300 px-2.5 py-2 text-xs focus:ring-2 focus:ring-teal-500" placeholder="Masukkan KM" min="0">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-1 uppercase tracking-wide">Jam Kedatangan <span class="text-red-500">*</span></label>
                            <input type="text" name="jam_kedatangan" id="jam_kedatangan"
                                   value="{{ old('jam_kedatangan', $transportRequest->jam_kedatangan ?? now()->format('H:i')) }}"
                                   class="w-full rounded-lg border border-slate-300 px-2.5 py-2 text-xs focus:ring-2 focus:ring-teal-500"
                                   placeholder="00:00" maxlength="5" inputmode="numeric">
                        </div>
                    </div>

                    {{-- Data Terisi (digunakan/selesai) --}}
                    <div x-show="'{{ $transportRequest->status }}' === 'digunakan' || '{{ $transportRequest->status }}' === 'selesai'"
                         class="bg-slate-50 rounded-lg border border-slate-200 p-3 space-y-1.5 text-[11px]">
                        <p class="text-[10px] font-bold text-slate-600 uppercase tracking-wide mb-2">Data Terisi</p>
                        @if($transportRequest->unit_mobil)
                        <div class="flex justify-between"><span class="text-slate-500">Unit</span><span class="font-semibold text-slate-800">{{ $transportRequest->unit_mobil }}</span></div>
                        @endif
                        @if($transportRequest->driver_id)
                        <div class="flex justify-between"><span class="text-slate-500">Supir</span><span class="font-semibold text-slate-800">{{ $transportRequest->driver->name ?? '-' }}</span></div>
                        @endif
                        @if($transportRequest->km_awal)
                        <div class="flex justify-between"><span class="text-slate-500">KM Awal</span><span class="font-semibold text-slate-800">{{ number_format($transportRequest->km_awal, 0, ',', '.') }} km</span></div>
                        @endif
                        @if($transportRequest->km_akhir)
                        <div class="flex justify-between"><span class="text-slate-500">KM Akhir</span><span class="font-semibold text-slate-800">{{ number_format($transportRequest->km_akhir, 0, ',', '.') }} km</span></div>
                        @endif
                        @if($transportRequest->km_awal && $transportRequest->km_akhir)
                        <div class="flex justify-between pt-1 border-t border-slate-200"><span class="text-slate-500">Total</span><span class="font-bold text-emerald-700">{{ number_format($transportRequest->km_akhir - $transportRequest->km_awal, 0, ',', '.') }} km</span></div>
                        @endif
                        @if($transportRequest->jam_kedatangan)
                        <div class="flex justify-between"><span class="text-slate-500">Jam Tiba</span><span class="font-semibold text-slate-800">{{ $transportRequest->jam_kedatangan }}</span></div>
                        @endif
                    </div>

                    {{-- Tombol Edit (digunakan) --}}
                    @if($transportRequest->status === 'digunakan')
                    <div x-show="currentStatus !== 'selesai'">
                        <button type="button" @click="editOpen = !editOpen"
                                class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold border transition"
                                :class="editOpen ? 'bg-slate-100 text-slate-700 border-slate-300' : 'bg-white text-teal-700 border-teal-300 hover:bg-teal-50'">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <span x-text="editOpen ? 'Tutup Edit' : 'Edit Unit / Supir / KM'"></span>
                        </button>
                    </div>
                    @endif

                    {{-- Submit --}}
                    <div x-show="currentStatus !== savedStatus">
                        <button type="submit" @if($isBlocked) disabled @endif
                                class="w-full inline-flex items-center justify-center gap-1.5 rounded-lg px-3 py-2 text-xs font-semibold text-white transition
                                    {{ $isBlocked ? 'bg-slate-400 cursor-not-allowed' : 'bg-teal-700 hover:bg-teal-800' }}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span x-text="currentStatus === 'selesai' ? 'Simpan & Selesaikan' : 'Simpan Perubahan'"></span>
                        </button>
                    </div>
                </form>

                {{-- Form Edit Digunakan — di dalam Alpine scope yang sama --}}
                @if($transportRequest->status === 'digunakan')
                <div x-show="editOpen && currentStatus !== 'selesai'" x-transition class="px-4 pb-4 border-t border-slate-200 pt-3">
                    <form method="POST" action="{{ route('admin.transport.update', $transportRequest) }}"
                          class="space-y-2.5 text-xs" id="editDigunakanFormEl">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="digunakan">
                        <input type="hidden" name="_edit_digunakan" value="1">

                        <p class="text-[10px] font-bold text-slate-600 uppercase tracking-wide">Edit Data Digunakan</p>

                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-1 uppercase tracking-wide">Unit Kendaraan</label>
                            <select name="unit_mobil" id="unit_mobil_edit"
                                    class="w-full rounded-lg border border-slate-300 px-2.5 py-2 text-xs focus:ring-2 focus:ring-teal-500 bg-white">
                                <option value="">-- Pilih Unit --</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->name }}" data-plate="{{ $vehicle->plate_number }}"
                                            @selected($transportRequest->unit_mobil == $vehicle->name)>
                                        {{ $vehicle->name }} ({{ $vehicle->plate_number }})
                                    </option>
                                @endforeach
                                @if($transportRequest->unit_mobil && !$vehicles->contains('name', $transportRequest->unit_mobil))
                                    <option value="{{ $transportRequest->unit_mobil }}" selected>{{ $transportRequest->unit_mobil }} — saat ini</option>
                                @endif
                            </select>
                            <input type="hidden" name="plat_nomor" id="plat_nomor_edit" value="{{ $transportRequest->plat_nomor }}">
                        </div>

                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-1 uppercase tracking-wide">Pengemudi</label>
                            <select name="driver_id"
                                    class="w-full rounded-lg border border-slate-300 px-2.5 py-2 text-xs focus:ring-2 focus:ring-teal-500 bg-white">
                                <option value="">-- Pilih Supir --</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}" @selected($transportRequest->driver_id == $driver->id)>
                                        {{ $driver->name }}@if($driver->phone) · {{ $driver->phone }}@endif
                                    </option>
                                @endforeach
                                @if($transportRequest->driver_id && !$drivers->contains('id', $transportRequest->driver_id))
                                    <option value="{{ $transportRequest->driver_id }}" selected>{{ $transportRequest->driver->name ?? '-' }} — saat ini</option>
                                @endif
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-1 uppercase tracking-wide">KM Keberangkatan</label>
                            <input type="text" id="km_awal_edit_display"
                                   value="{{ $transportRequest->km_awal ? number_format($transportRequest->km_awal, 0, ',', '.') : '' }}"
                                   class="w-full rounded-lg border border-slate-300 px-2.5 py-2 text-xs focus:ring-2 focus:ring-teal-500"
                                   placeholder="Masukkan KM" inputmode="numeric" autocomplete="off">
                            <input type="hidden" name="km_awal" id="km_awal_edit" value="{{ $transportRequest->km_awal }}">
                        </div>

                        <button type="submit"
                                class="w-full rounded-lg bg-teal-700 hover:bg-teal-800 text-white px-3 py-2 text-xs font-semibold transition">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>{{-- end right column --}}

    </div>{{-- end main grid --}}
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    // ── Unit → Plat Nomor ──
    const unitSel = document.getElementById('unit_mobil');
    const platIn  = document.getElementById('plat_nomor');
    if (unitSel && platIn) {
        unitSel.addEventListener('change', function () {
            platIn.value = this.options[this.selectedIndex].getAttribute('data-plate') || '';
        });
    }

    // ── Jam Kedatangan ──
    const jamEl = document.getElementById('jam_kedatangan');
    if (jamEl) {
        jamEl.addEventListener('input', function () {
            let v = this.value.replace(/\D/g, '');
            if (v.length > 2) v = v.slice(0,2) + ':' + v.slice(2,4);
            this.value = v;
        });
        jamEl.addEventListener('keypress', e => { if (!/[0-9]/.test(e.key)) e.preventDefault(); });
        jamEl.addEventListener('blur', function () {
            const d = this.value.replace(/\D/g, '');
            if (d.length === 4) {
                let h = Math.min(parseInt(d.slice(0,2)), 23);
                let m = Math.min(parseInt(d.slice(2,4)), 59);
                this.value = String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0');
            }
        });
    }

    // ── KM Akhir Validation ──
    function validateKm() {
        const a = parseInt(document.getElementById('km_awal')?.value) || 0;
        const b = parseInt(document.getElementById('km_akhir')?.value) || 0;
        const el = document.getElementById('km_akhir');
        if (!el) return true;
        let alert = document.getElementById('km_akhir_alert');
        if (b > 0 && a > 0 && b <= a) {
            el.classList.add('border-red-400'); el.classList.remove('border-slate-300');
            if (!alert) { alert = document.createElement('p'); alert.id = 'km_akhir_alert'; alert.className = 'mt-0.5 text-[10px] text-red-600'; el.parentNode.appendChild(alert); }
            alert.textContent = 'KM tiba harus lebih besar dari KM berangkat (' + a.toLocaleString('id-ID') + ' km).';
            return false;
        }
        el.classList.remove('border-red-400'); el.classList.add('border-slate-300');
        if (alert) alert.remove();
        return true;
    }
    const kmAkhirEl = document.getElementById('km_akhir');
    if (kmAkhirEl) { kmAkhirEl.addEventListener('input', validateKm); kmAkhirEl.addEventListener('blur', validateKm); }

    // ── KM Awal Hint & Validation ──
    const kmAwalEl   = document.getElementById('km_awal');
    const kmHint     = document.getElementById('km_awal_hint');
    const kmError    = document.getElementById('km_awal_error');
    let minKm = 0;
    function updateKmHint() {
        if (!unitSel) return;
        const lastKm = parseInt(unitSel.options[unitSel.selectedIndex]?.dataset?.lastKm) || 0;
        minKm = lastKm;
        if (kmAwalEl) { kmAwalEl.min = lastKm; kmAwalEl.placeholder = lastKm > 0 ? 'Min. ' + lastKm.toLocaleString('id-ID') + ' km' : 'Masukkan KM'; }
        if (kmHint) { kmHint.textContent = lastKm > 0 ? 'KM terakhir: ' + lastKm.toLocaleString('id-ID') + ' km' : ''; kmHint.classList.toggle('hidden', !lastKm); }
        if (kmAwalEl?.value) validateKmAwal();
    }
    function validateKmAwal() {
        if (!kmAwalEl || !kmError) return true;
        const v = parseInt(kmAwalEl.value) || 0;
        if (minKm > 0 && v < minKm) {
            kmAwalEl.classList.add('border-red-400'); kmAwalEl.classList.remove('border-slate-300');
            kmError.textContent = 'KM tidak boleh kurang dari ' + minKm.toLocaleString('id-ID') + ' km.';
            kmError.classList.remove('hidden'); return false;
        }
        kmAwalEl.classList.remove('border-red-400'); kmAwalEl.classList.add('border-slate-300');
        kmError.classList.add('hidden'); return true;
    }
    if (unitSel) { unitSel.addEventListener('change', updateKmHint); updateKmHint(); }
    if (kmAwalEl) { kmAwalEl.addEventListener('blur', validateKmAwal); kmAwalEl.addEventListener('input', validateKmAwal); }

    // ── Edit form: unit_mobil_edit → plat_nomor_edit ──
    const unitEdit = document.getElementById('unit_mobil_edit');
    const platEdit = document.getElementById('plat_nomor_edit');
    if (unitEdit && platEdit) {
        unitEdit.addEventListener('change', function () {
            platEdit.value = this.options[this.selectedIndex].getAttribute('data-plate') || '';
        });
    }

    // ── Edit form: KM format ──
    const dispEdit = document.getElementById('km_awal_edit_display');
    const hidEdit  = document.getElementById('km_awal_edit');
    if (dispEdit && hidEdit) {
        function fmtEdit() { const r = dispEdit.value.replace(/\D/g,''); hidEdit.value = r; dispEdit.value = r ? parseInt(r).toLocaleString('id-ID') : ''; }
        dispEdit.addEventListener('input', function () {
            const r = this.value.replace(/\D/g,''); const c = this.selectionStart; const pl = this.value.length;
            this.value = r ? parseInt(r).toLocaleString('id-ID') : ''; hidEdit.value = r;
            this.setSelectionRange(c + this.value.length - pl, c + this.value.length - pl);
        });
        dispEdit.addEventListener('blur', fmtEdit);
        dispEdit.addEventListener('keypress', e => { if (!/[0-9]/.test(e.key)) e.preventDefault(); });
        if (dispEdit.value) fmtEdit();
    }

    // ── Submit Guard ──
    const mainForm = document.getElementById('mainFormWrapper');
    if (mainForm) {
        mainForm.addEventListener('submit', function (e) {
            if (kmAkhirEl && kmAkhirEl.value !== '' && !validateKm()) { e.preventDefault(); kmAkhirEl.focus(); return; }
            if (kmAwalEl && !validateKmAwal()) { e.preventDefault(); kmAwalEl.focus(); }
        });
    }
});
</script>
</x-app-layout>
