<x-app-layout>
@php
    $total    = auth()->user()->transportRequests()->count();
    $pending  = auth()->user()->transportRequests()->where('status', 'diajukan')->count();
    $approved = auth()->user()->transportRequests()->where('status', 'diproses')->count();
    $inuse    = auth()->user()->transportRequests()->where('status', 'digunakan')->count();
    $done     = auth()->user()->transportRequests()->where('status', 'selesai')->count();
    $rejected = auth()->user()->transportRequests()->where('status', 'tidak_disetujui')->count();
@endphp

<div class="max-w-2xl mx-auto px-3 pt-5 pb-8 space-y-5">

    {{-- ── GREETING ── --}}
    <div>
        <h1 class="text-base font-bold text-slate-800">Halo, {{ auth()->user()->first_name }} 👋</h1>
        <p class="text-xs text-slate-500 mt-0.5">Pilih jenis transportasi yang Anda butuhkan.</p>
    </div>

    {{-- ── STATS ── --}}
    <div class="grid grid-cols-3 sm:grid-cols-6 gap-2">
        @foreach([
            ['label'=>'Total',     'value'=>$total,    'bg'=>'bg-slate-100',   'text'=>'text-slate-700'],
            ['label'=>'Menunggu',  'value'=>$pending,  'bg'=>'bg-amber-50',    'text'=>'text-amber-700'],
            ['label'=>'Disetujui', 'value'=>$approved, 'bg'=>'bg-blue-50',     'text'=>'text-blue-700'],
            ['label'=>'Digunakan', 'value'=>$inuse,    'bg'=>'bg-cyan-50',     'text'=>'text-cyan-700'],
            ['label'=>'Selesai',   'value'=>$done,     'bg'=>'bg-emerald-50',  'text'=>'text-emerald-700'],
            ['label'=>'Ditolak',   'value'=>$rejected, 'bg'=>'bg-red-50',      'text'=>'text-red-700'],
        ] as $stat)
        <div class="{{ $stat['bg'] }} rounded-xl px-3 py-2.5 text-center border border-white shadow-sm">
            <p class="text-xl font-bold {{ $stat['text'] }} leading-none">{{ $stat['value'] }}</p>
            <p class="text-[10px] font-medium text-slate-500 mt-0.5">{{ $stat['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- ── PILIH JENIS ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

        {{-- Ambulance --}}
        <a href="{{ route('pengajuan.ambulance.create') }}"
           class="group flex items-center gap-4 bg-white rounded-2xl border border-slate-200 px-5 py-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center shrink-0"
                 style="background-color: #e6f2f1; border: 1.5px solid #00685E;">
                <img src="{{ asset('images/ambulance-icon.png') }}" alt="Ambulance" class="w-8 h-8 object-contain">
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-slate-800 group-hover:text-emerald-700 transition">Ambulance</p>
                <p class="text-[11px] text-slate-500 mt-0.5">Layanan darurat & rujukan medis</p>
            </div>
            <svg class="w-4 h-4 text-slate-300 group-hover:text-emerald-500 transition shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </a>

        {{-- Mobil Umum --}}
        <a href="{{ route('pengajuan.umum.create') }}"
           class="group flex items-center gap-4 bg-white rounded-2xl border border-slate-200 px-5 py-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center shrink-0"
                 style="background-color: #e8f4e0; border: 1.5px solid #00685E;">
                <img src="{{ asset('images/umum-icon.png') }}" alt="Mobil Umum" class="w-8 h-8 object-contain">
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-slate-800 group-hover:text-emerald-700 transition">Mobil Umum</p>
                <p class="text-[11px] text-slate-500 mt-0.5">Transportasi operasional & dinas</p>
            </div>
            <svg class="w-4 h-4 text-slate-300 group-hover:text-emerald-500 transition shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </a>

    </div>

    {{-- ── SHORTCUT RIWAYAT ── --}}
    <a href="{{ route('pengajuan.index') }}"
       class="flex items-center justify-between bg-white rounded-xl border border-slate-200 px-4 py-3 shadow-sm hover:bg-slate-50 transition group">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center">
                <svg class="w-4 h-4 text-slate-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-700">Riwayat Pengajuan</p>
                <p class="text-[10px] text-slate-400">{{ $total }} pengajuan tercatat</p>
            </div>
        </div>
        <svg class="w-4 h-4 text-slate-300 group-hover:text-slate-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
    </a>

</div>
</x-app-layout>
