<x-app-layout title="Buat Pengajuan — SIPETRANS">
@php
    $total    = auth()->user()->transportRequests()->count();
    $pending  = auth()->user()->transportRequests()->where('status', 'diajukan')->count();
    $approved = auth()->user()->transportRequests()->where('status', 'diproses')->count();
    $inuse    = auth()->user()->transportRequests()->where('status', 'digunakan')->count();
    $done     = auth()->user()->transportRequests()->where('status', 'selesai')->count();
    $rejected = auth()->user()->transportRequests()->where('status', 'tidak_disetujui')->count();
@endphp

<div class="mx-auto px-4 pt-5 pb-5" style="max-width:42rem;">

    <style>
        .sp-choose-card { transition: all 0.25s ease; border: 1px solid #e2e8f0; }
        .sp-choose-card:hover { transform: translateY(-3px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); border-color: #007774; }
        .sp-choose-card:hover svg.arrow-icon { color: #007774 !important; transform: translateX(4px); transition: all 0.25s ease; }
        .sp-choose-card svg.arrow-icon { transition: all 0.25s ease; }
    </style>

    {{-- ── GREETING ── --}}
    <div class="mb-4">
        <h1 class="fw-bold text-slate-800 mb-1" style="font-size:1rem;">Halo, {{ auth()->user()->full_name }} 👋</h1>
        <p class="text-xs text-slate-500 mb-0">Pilih jenis transportasi yang Anda butuhkan.</p>
    </div>

    {{-- ── STATS ── --}}
    <div class="rounded-3 border border-slate-200 p-3 mb-4" style="background:#fff;">        <div class="text-xxs fw-600 text-slate-500 mb-2 text-uppercase" style="letter-spacing:.05em;">Ringkasan Pengajuan Anda</div>
        <div class="row g-2">
        <div class="col-4 col-sm-2">
            <div class="rounded text-center px-2 py-2 shadow-sm" style="background:#e0f2fe;border:1px solid #7dd3fc;">
                <p class="fw-bold leading-none mb-1" style="font-size:1.25rem;color:#0369a1;">{{ $total }}</p>
                <p class="text-xxs fw-600 mb-0" style="color:#0284c7;">Total</p>
            </div>
        </div>
        <div class="col-4 col-sm-2">
            <div class="rounded text-center px-2 py-2 shadow-sm" style="background:#fef9c3;border:1px solid #fde047;">
                <p class="fw-bold leading-none mb-1" style="font-size:1.25rem;color:#a16207;">{{ $pending }}</p>
                <p class="text-xxs fw-600 mb-0" style="color:#ca8a04;">Menunggu</p>
            </div>
        </div>
        <div class="col-4 col-sm-2">
            <div class="rounded text-center px-2 py-2 shadow-sm" style="background:#dbeafe;border:1px solid #93c5fd;">
                <p class="fw-bold leading-none mb-1" style="font-size:1.25rem;color:#1d4ed8;">{{ $approved }}</p>
                <p class="text-xxs fw-600 mb-0" style="color:#2563eb;">Disetujui</p>
            </div>
        </div>
        <div class="col-4 col-sm-2">
            <div class="rounded text-center px-2 py-2 shadow-sm" style="background:#cffafe;border:1px solid #67e8f9;">
                <p class="fw-bold leading-none mb-1" style="font-size:1.25rem;color:#0e7490;">{{ $inuse }}</p>
                <p class="text-xxs fw-600 mb-0" style="color:#0891b2;">Digunakan</p>
            </div>
        </div>
        <div class="col-4 col-sm-2">
            <div class="rounded text-center px-2 py-2 shadow-sm" style="background:#dcfce7;border:1px solid #86efac;">
                <p class="fw-bold leading-none mb-1" style="font-size:1.25rem;color:#15803d;">{{ $done }}</p>
                <p class="text-xxs fw-600 mb-0" style="color:#16a34a;">Selesai</p>
            </div>
        </div>
        <div class="col-4 col-sm-2">
            <div class="rounded text-center px-2 py-2 shadow-sm" style="background:#fee2e2;border:1px solid #fca5a5;">
                <p class="fw-bold leading-none mb-1" style="font-size:1.25rem;color:#b91c1c;">{{ $rejected }}</p>
                <p class="text-xxs fw-600 mb-0" style="color:#dc2626;">Ditolak</p>
            </div>
        </div>
    </div>
    </div>{{-- /stats wrapper --}}

    {{-- ── PILIH JENIS ── --}}
    <div class="row g-3 mb-4">

        {{-- Ambulance --}}
        <div class="col-12 col-sm-6">
            <a href="{{ route('pengajuan.ambulance.create') }}"
               class="sp-choose-card d-flex align-items-center gap-3 bg-white rounded px-4 py-4 shadow-sm text-decoration-none">
                <div class="d-flex align-items-center justify-content-center rounded shrink-0"
                     style="width:3.5rem; height:3.5rem; background-color:#e6f2f1; border:1.5px solid #00685E;">
                    <img src="{{ asset('images/ambulance-icon.png') }}" alt="Ambulance" style="width:2rem; height:2rem; object-fit:contain;">
                </div>
                <div class="flex-grow-1 min-w-0">
                    <p class="text-sm fw-bold text-slate-800 mb-0">Ambulance</p>
                    <p class="text-xxs text-slate-500 mb-0 mt-1">Layanan darurat &amp; rujukan medis</p>
                </div>
                <svg class="text-slate-300 shrink-0 arrow-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        {{-- Mobil Umum --}}
        <div class="col-12 col-sm-6">
            <a href="{{ route('pengajuan.umum.create') }}"
               class="sp-choose-card d-flex align-items-center gap-3 bg-white rounded px-4 py-4 shadow-sm text-decoration-none">
                <div class="d-flex align-items-center justify-content-center rounded shrink-0"
                     style="width:3.5rem; height:3.5rem; background-color:#e8f4e0; border:1.5px solid #00685E;">
                    <img src="{{ asset('images/umum-icon.png') }}" alt="Mobil Umum" style="width:2rem; height:2rem; object-fit:contain;">
                </div>
                <div class="flex-grow-1 min-w-0">
                    <p class="text-sm fw-bold text-slate-800 mb-0">Mobil Umum</p>
                    <p class="text-xxs text-slate-500 mb-0 mt-1">Transportasi operasional &amp; dinas</p>
                </div>
                <svg class="text-slate-300 shrink-0 arrow-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

    </div>

    {{-- ── SHORTCUT RIWAYAT ── --}}
    <a href="{{ route('pengajuan.index') }}"
       class="sp-choose-card d-flex align-items-center justify-content-between bg-white rounded px-3 py-3 shadow-sm text-decoration-none">
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
        <svg class="text-slate-300 arrow-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
    </a>

</div>
</x-app-layout>
