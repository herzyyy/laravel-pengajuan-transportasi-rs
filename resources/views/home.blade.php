<x-app-layout>
    <div class="space-y-4">

        {{-- Welcome Banner --}}
        <div class="relative overflow-hidden rounded-lg bg-emerald-600 px-5 py-5 text-white shadow-md">
            {{-- Decorative circles --}}
            <div class="pointer-events-none absolute -right-8 -top-8 h-36 w-36 rounded-full bg-white/10"></div>
            <div class="pointer-events-none absolute -bottom-6 right-16 h-24 w-24 rounded-full bg-white/5"></div>

            <div class="relative flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-medium text-emerald-200 mb-0.5">Dashboard Pengajuan</p>
                    <h1 class="text-xl font-bold leading-tight">
                        Halo, {{ auth()->user()->first_name }}!
                    </h1>
                    <p class="mt-1 text-xs text-emerald-100 max-w-xs">
                        Kelola pengajuan transportasi Anda dengan mudah dan terpantau.
                    </p>
                </div>
                <div class="hidden sm:block shrink-0 text-right">
                    <div class="inline-block rounded-lg bg-white/15 border border-white/20 px-3 py-2 backdrop-blur-sm">
                        <p class="text-[10px] text-emerald-200 mb-0.5">Unit Kerja</p>
                        <p class="text-sm font-semibold">{{ auth()->user()->unit_kerja ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Row --}}
        @php
            $total    = auth()->user()->transportRequests()->count();
            $pending  = auth()->user()->transportRequests()->where('status', 'diajukan')->count();
            $approved = auth()->user()->transportRequests()->where('status', 'diproses')->count();
            $inuse    = auth()->user()->transportRequests()->where('status', 'digunakan')->count();
            $done     = auth()->user()->transportRequests()->where('status', 'selesai')->count();
            $rejected = auth()->user()->transportRequests()->where('status', 'tidak_disetujui')->count();
        @endphp
        <div class="grid grid-cols-2 sm:grid-cols-6 gap-2 sm:gap-3">
            @foreach([
                ['label'=>'Total',     'value'=>$total,    'color'=>'slate',   'icon'=>'M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5z'],
                ['label'=>'Menunggu',  'value'=>$pending,  'color'=>'amber',   'icon'=>'M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z'],
                ['label'=>'Disetujui', 'value'=>$approved, 'color'=>'blue',    'icon'=>'M5.5 16a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 16h-8z'],
                ['label'=>'Digunakan', 'value'=>$inuse,    'color'=>'cyan',    'icon'=>'M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3z'],
                ['label'=>'Selesai',   'value'=>$done,     'color'=>'emerald', 'icon'=>'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z'],
                ['label'=>'Ditolak',   'value'=>$rejected, 'color'=>'red',     'icon'=>'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z'],
            ] as $stat)
            <div class="bg-white border border-{{ $stat['color'] }}-200 rounded-lg px-3 py-4 flex items-center gap-3 shadow-sm hover:shadow-md transition">
                <div class="shrink-0 rounded-lg p-2 bg-{{ $stat['color'] }}-100">
                    <svg class="w-4 h-4 text-{{ $stat['color'] }}-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="{{ $stat['icon'] }}" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[9px] font-semibold text-{{ $stat['color'] }}-600 uppercase tracking-wide">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-bold text-slate-900 leading-none mt-1">{{ $stat['value'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Service Cards --}}
        <div class="grid sm:grid-cols-2 gap-3">

            {{-- Mobil Umum --}}
            <a href="{{ route('pengajuan.umum.create') }}"
               class="group relative overflow-hidden bg-white border-2 border-slate-200 hover:border-amber-400 rounded-lg p-5 transition-all hover:shadow-lg flex items-center gap-4">
                <div class="absolute inset-y-0 left-0 w-1 bg-amber-400 rounded-l-lg opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="shrink-0 w-14 h-14 rounded-lg bg-amber-50 border border-amber-200 flex items-center justify-center group-hover:bg-amber-100 transition">
                    <img src="{{ asset('images/umum-icon.png') }}" alt="Mobil Umum" class="w-8 h-8 object-contain">
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <h3 class="text-sm font-bold text-slate-900 group-hover:text-amber-700 transition">Mobil Umum</h3>
                        <span class="text-[9px] font-bold px-1.5 py-0.5 bg-amber-100 text-amber-700 rounded-full">NON-MEDIS</span>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">Pengambilan obat, dokumen, logistik, dan keperluan umum lainnya.</p>
                </div>
                <svg class="w-4 h-4 text-slate-300 group-hover:text-amber-500 group-hover:translate-x-1 transition shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            {{-- Ambulance --}}
            <a href="{{ route('pengajuan.ambulance.create') }}"
               class="group relative overflow-hidden bg-white border-2 border-slate-200 hover:border-emerald-400 rounded-lg p-5 transition-all hover:shadow-lg flex items-center gap-4">
                <div class="absolute inset-y-0 left-0 w-1 bg-emerald-500 rounded-l-lg opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="shrink-0 w-14 h-14 rounded-lg bg-emerald-50 border border-emerald-200 flex items-center justify-center group-hover:bg-emerald-100 transition">
                    <img src="{{ asset('images/ambulance-icon.png') }}" alt="Ambulance" class="w-8 h-8 object-contain">
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <h3 class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition">Ambulance</h3>
                        <span class="text-[9px] font-bold px-1.5 py-0.5 bg-emerald-100 text-emerald-700 rounded-full">MEDIS</span>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">Antar/jemput pasien dari dan ke rumah sakit sesuai prosedur medis.</p>
                </div>
                <svg class="w-4 h-4 text-slate-300 group-hover:text-emerald-500 group-hover:translate-x-1 transition shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

        </div>

        {{-- Riwayat shortcut --}}
        <div class="flex justify-end">
            <a href="{{ route('pengajuan.index') }}"
               class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-500 hover:text-emerald-600 transition">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                </svg>
                Lihat semua riwayat pengajuan →
            </a>
        </div>

    </div>
</x-app-layout>
