<x-app-layout title="Buat Pengajuan — SIPETRANS">
@php
    $total    = auth()->user()->transportRequests()->count();
    $pending  = auth()->user()->transportRequests()->where('status', 'diajukan')->count();
    $approved = auth()->user()->transportRequests()->where('status', 'diproses')->count();
    $inuse    = auth()->user()->transportRequests()->where('status', 'digunakan')->count();
    $done     = auth()->user()->transportRequests()->where('status', 'selesai')->count();
    $rejected = auth()->user()->transportRequests()->where('status', 'tidak_disetujui')->count();
@endphp

<div class="mx-auto px-3 pt-4 pb-5" style="max-width:42rem;">

    {{-- ── GREETING ── --}}
    <div class="mb-4">
        <h1 class="fw-bold text-slate-800 mb-1" style="font-size:1rem;">Halo, {{ auth()->user()->full_name }} 👋</h1>
        <p class="text-xs text-slate-500 mb-0">Pilih jenis transportasi yang Anda butuhkan.</p>
    </div>

    {{-- ── STATS ── --}}
    <div class="row g-2 mb-4">
        <div class="col-4 col-sm-2">
            <div class="bg-slate-100 border border-slate-300 rounded text-center px-2 py-2 shadow-sm">
                <p class="fw-bold text-slate-700 leading-none mb-1" style="font-size:1.25rem;">{{ $total }}</p>
                <p class="text-xxs fw-500 text-slate-500 mb-0">Total</p>
            </div>
        </div>
        <div class="col-4 col-sm-2">
            <div class="bg-amber-50 border border-amber-200 rounded text-center px-2 py-2 shadow-sm">
                <p class="fw-bold text-amber-700 leading-none mb-1" style="font-size:1.25rem;">{{ $pending }}</p>
                <p class="text-xxs fw-500 text-slate-500 mb-0">Menunggu</p>
            </div>
        </div>
        <div class="col-4 col-sm-2">
            <div class="bg-blue-50 border border-blue-200 rounded text-center px-2 py-2 shadow-sm">
                <p class="fw-bold text-blue-700 leading-none mb-1" style="font-size:1.25rem;">{{ $approved }}</p>
                <p class="text-xxs fw-500 text-slate-500 mb-0">Disetujui</p>
            </div>
        </div>
        <div class="col-4 col-sm-2">
            <div class="bg-cyan-50 border border-cyan-200 rounded text-center px-2 py-2 shadow-sm">
                <p class="fw-bold text-cyan-700 leading-none mb-1" style="font-size:1.25rem;">{{ $inuse }}</p>
                <p class="text-xxs fw-500 text-slate-500 mb-0">Digunakan</p>
            </div>
        </div>
        <div class="col-4 col-sm-2">
            <div class="bg-emerald-50 border border-emerald-200 rounded text-center px-2 py-2 shadow-sm">
                <p class="fw-bold text-emerald-700 leading-none mb-1" style="font-size:1.25rem;">{{ $done }}</p>
                <p class="text-xxs fw-500 text-slate-500 mb-0">Selesai</p>
            </div>
        </div>
        <div class="col-4 col-sm-2">
            <div class="bg-red-50 border border-red-200 rounded text-center px-2 py-2 shadow-sm">
                <p class="fw-bold text-red-700 leading-none mb-1" style="font-size:1.25rem;">{{ $rejected }}</p>
                <p class="text-xxs fw-500 text-slate-500 mb-0">Ditolak</p>
            </div>
        </div>
    </div>

    {{-- ── PILIH JENIS ── --}}
    <div class="row g-3 mb-4">

        {{-- Ambulance --}}
        <div class="col-12 col-sm-6">
            <a href="{{ route('pengajuan.ambulance.create') }}"
               class="d-flex align-items-center gap-3 bg-white rounded border border-slate-200 px-4 py-4 shadow-sm text-decoration-none transition"
               style="hover-shadow:0 4px 12px rgba(0,0,0,.1);">
                <div class="d-flex align-items-center justify-content-center rounded shrink-0"
                     style="width:3.5rem; height:3.5rem; background-color:#e6f2f1; border:1.5px solid #00685E;">
                    <img src="{{ asset('images/ambulance-icon.png') }}" alt="Ambulance" style="width:2rem; height:2rem; object-fit:contain;">
                </div>
                <div class="flex-grow-1 min-w-0">
                    <p class="text-sm fw-bold text-slate-800 mb-0">Ambulance</p>
                    <p class="text-xxs text-slate-500 mb-0 mt-1">Layanan darurat &amp; rujukan medis</p>
                </div>
                <svg class="text-slate-300 shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        {{-- Mobil Umum --}}
        <div class="col-12 col-sm-6">
            <a href="{{ route('pengajuan.umum.create') }}"
               class="d-flex align-items-center gap-3 bg-white rounded border border-slate-200 px-4 py-4 shadow-sm text-decoration-none transition">
                <div class="d-flex align-items-center justify-content-center rounded shrink-0"
                     style="width:3.5rem; height:3.5rem; background-color:#e8f4e0; border:1.5px solid #00685E;">
                    <img src="{{ asset('images/umum-icon.png') }}" alt="Mobil Umum" style="width:2rem; height:2rem; object-fit:contain;">
                </div>
                <div class="flex-grow-1 min-w-0">
                    <p class="text-sm fw-bold text-slate-800 mb-0">Mobil Umum</p>
                    <p class="text-xxs text-slate-500 mb-0 mt-1">Transportasi operasional &amp; dinas</p>
                </div>
                <svg class="text-slate-300 shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

    </div>

    {{-- ── SHORTCUT RIWAYAT ── --}}
    <a href="{{ route('pengajuan.index') }}"
       class="d-flex align-items-center justify-content-between bg-white rounded border border-slate-200 px-3 py-3 shadow-sm text-decoration-none transition">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded bg-slate-100" style="width:2rem; height:2rem;">
                <svg class="text-slate-500" width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div>
                <p class="text-xs fw-600 text-slate-700 mb-0">Riwayat Pengajuan</p>
                <p class="text-xxs text-slate-400 mb-0">{{ $total }} pengajuan tercatat</p>
            </div>
        </div>
        <svg class="text-slate-300" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
    </a>

</div>
</x-app-layout>
