<x-app-layout title="Riwayat Pengajuan — SIPETRANS">
<div class="mx-auto px-2 px-sm-3 pt-2 pt-sm-3 pb-4 pb-sm-5" style="max-width:80rem;">

    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mb-3">
        <div>
            <h1 class="fw-bold text-slate-900 mb-0" style="font-size:1.125rem;">Riwayat Pengajuan</h1>
            <p class="text-xs text-slate-500 mt-1 mb-0">Daftar pengajuan transportasi yang telah Anda buat</p>
        </div>
        <div class="d-flex align-items-center justify-content-end gap-2">
            <a href="{{ route('dashboard') }}"
               class="d-inline-flex align-items-center justify-content-center gap-1 rounded text-xs fw-600 px-3 py-2 text-white"
               style="background-color:#059669;">
                <svg width="14" height="14" fill="white" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                Pengajuan Baru
            </a>
            <a href="{{ route('dashboard') }}"
               class="d-inline-flex align-items-center gap-1 rounded border border-slate-300 bg-white px-3 py-2 text-xs fw-600 text-slate-600">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="sp-card mb-3">
        <div class="p-3">
            <form action="{{ route('pengajuan.index') }}" method="GET" id="user-filter-form">
                <div class="row g-2">
                    <div class="col-6 col-sm-4">
                        <label for="jenis" class="form-label text-xxs fw-600 text-slate-600 mb-1">Jenis</label>
                        <select name="jenis" id="jenis" class="form-select form-select-sm text-xs">
                            <option value="">Semua</option>
                            <option value="ambulance" {{ request('jenis') == 'ambulance' ? 'selected' : '' }}>Ambulance</option>
                            <option value="umum" {{ request('jenis') == 'umum' ? 'selected' : '' }}>Umum</option>
                        </select>
                    </div>
                    <div class="col-6 col-sm-4">
                        <label for="status" class="form-label text-xxs fw-600 text-slate-600 mb-1">Status</label>
                        <select name="status" id="status" class="form-select form-select-sm text-xs">
                            <option value="">Semua</option>
                            <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Disetujui</option>
                            <option value="digunakan" {{ request('status') == 'digunakan' ? 'selected' : '' }}>Digunakan</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="tidak_disetujui" {{ request('status') == 'tidak_disetujui' ? 'selected' : '' }}>Tidak Disetujui</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label for="tanggal" class="form-label text-xxs fw-600 text-slate-600 mb-1">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ request('tanggal') }}"
                               class="form-control form-control-sm text-xs">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('user-filter-form');
            if (!form) return;
            let timer;
            function submitClean(delay) {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    form.querySelectorAll('input, select').forEach(el => { if (el.value === '') el.disabled = true; });
                    form.submit();
                }, delay);
            }
            form.querySelectorAll('input[type="date"]').forEach(el => el.addEventListener('input', () => submitClean(300)));
            form.querySelectorAll('select').forEach(el => el.addEventListener('change', () => submitClean(0)));
        });
    </script>

    <!-- Table Card (Desktop) / Card List (Mobile) -->
    <div class="sp-card">
        <!-- Desktop Table View -->
        <div class="d-none d-md-block overflow-x-auto">
            <table class="sp-table" style="min-width:680px; table-layout:fixed;">
                <thead>
                    <tr>
                        <th style="width:4rem;">ID</th>
                        <th style="width:25%;">Jenis &amp; Keperluan</th>
                        <th style="width:25%;">Jadwal</th>
                        <th style="width:7rem;">Dibuat</th>
                        <th style="width:5rem;">Status</th>
                        <th style="width:4rem; text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <!-- ID -->
                            <td>
                                <span class="font-mono text-xxs fw-600 text-teal-700 bg-teal-50 border border-slate-200 px-2 py-1 rounded">
                                    {{ $item->nomor_pengajuan }}
                                </span>
                            </td>

                            <!-- Jenis -->
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <div class="d-flex align-items-center gap-2">
                                        @if($item->jenis === 'ambulance')
                                            <span class="badge badge-emerald d-inline-flex align-items-center gap-1 rounded-pill text-xxs fw-600">
                                                <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
                                                </svg>
                                                Ambulance
                                            </span>
                                        @else
                                            <span class="badge badge-amber d-inline-flex align-items-center gap-1 rounded-pill text-xxs fw-600">
                                                <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3z"></path>
                                                </svg>
                                                Umum
                                            </span>
                                        @endif
                                        @if($item->prioritas === 'segera')
                                            <span class="badge badge-red d-inline-flex align-items-center rounded-pill text-xxs fw-bold">
                                                ⚡ CITO
                                            </span>
                                        @endif
                                    </div>
                                    @if ($item->keperluan)
                                        <div class="text-xs text-slate-600 fw-500 truncate" title="{{ ucfirst($item->keperluan) }}">
                                            {{ ucfirst($item->keperluan) }}
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Jadwal -->
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <div class="d-flex align-items-center gap-1 text-slate-900 fw-500">
                                        <svg class="text-slate-400 flex-shrink-0" width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-xxs truncate">{{ $item->tanggal?->format('d M Y') }} | {{ substr($item->jam, 0, 5) }}</span>
                                    </div>
                                    @if ($item->tanggal_sampai && $item->jam_sampai)
                                        <div class="text-xxs text-slate-500 truncate">s/d {{ $item->tanggal_sampai?->format('d M Y') }} | {{ substr($item->jam_sampai, 0, 5) }}</div>
                                    @else
                                        <div class="text-xxs text-slate-500">s/d selesai</div>
                                    @endif
                                </div>
                            </td>

                            <!-- Jam Pengajuan -->
                            <td>
                                <div class="text-xs text-slate-700 fw-500 whitespace-nowrap">{{ $item->created_at->format('d M Y') }}</div>
                                <div class="text-xxs text-slate-500 whitespace-nowrap">{{ $item->created_at->format('H:i') }}</div>
                            </td>

                            <!-- Status -->
                            <td>
                                @php
                                    $statusConfig = match($item->status) {
                                        'diajukan'        => ['badge-amber',   'Diajukan',        '<svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>'],
                                        'diproses'        => ['badge-blue',    'Disetujui',       '<svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 16a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 16h-8z"/></svg>'],
                                        'digunakan'       => ['badge-cyan',    'Digunakan',       '<svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/><path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3z"/></svg>'],
                                        'selesai'         => ['badge-emerald', 'Selesai',         '<svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>'],
                                        'tidak_disetujui' => ['badge-red',     'Tidak Disetujui', '<svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>'],
                                        default           => ['badge-slate',   ucfirst($item->status), ''],
                                    };
                                @endphp
                                <span class="badge {{ $statusConfig[0] }} d-inline-flex align-items-center gap-1 rounded-pill text-xxs fw-600">
                                    {!! $statusConfig[2] !!}
                                    {{ $statusConfig[1] }}
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="text-center">
                                <a href="{{ route('pengajuan.success', $item) }}"
                                   class="d-inline-flex align-items-center gap-1 text-xxs fw-600 text-emerald-600">
                                    Detail
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-5 text-center">
                                <div class="d-flex flex-column align-items-center gap-3">
                                    <div class="bg-slate-100 rounded-circle p-3">
                                        <svg class="text-slate-400" width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="fw-600 text-slate-900 mb-1 text-xs">Belum ada pengajuan</p>
                                        <p class="text-xs text-slate-500 mb-0">Buat pengajuan transportasi untuk memulai</p>
                                    </div>
                                    <a href="{{ route('dashboard') }}" class="d-inline-flex align-items-center gap-2 px-3 py-2 text-white text-xs fw-600 rounded" style="background-color:#059669;">
                                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        Buat Pengajuan
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="d-md-none divide-y divide-slate-200 overflow-hidden">
            @forelse ($items as $item)
                <div class="p-3 p-sm-4 min-w-0">
                    <!-- Header with ID and Status -->
                    <div class="d-flex flex-wrap align-items-start justify-content-between gap-2 mb-3 min-w-0">
                        <span class="font-mono text-xs fw-600 text-slate-700 bg-slate-100 px-2 py-1 rounded">
                            {{ $item->nomor_pengajuan }}
                        </span>
                        @php
                            $statusConfig = match($item->status) {
                                'diajukan'        => ['badge-amber',   'Diajukan'],
                                'diproses'        => ['badge-blue',    'Disetujui'],
                                'digunakan'       => ['badge-cyan',    'Digunakan'],
                                'selesai'         => ['badge-emerald', 'Selesai'],
                                'tidak_disetujui' => ['badge-red',     'Tidak Disetujui'],
                                default           => ['badge-slate',   ucfirst($item->status)],
                            };
                        @endphp
                        <span class="badge {{ $statusConfig[0] }} d-inline-flex align-items-center rounded-pill text-xxs fw-bold">
                            {{ $statusConfig[1] }}
                        </span>
                    </div>

                    <!-- Jenis & Prioritas -->
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-3 min-w-0">
                        @if($item->jenis === 'ambulance')
                            <span class="badge badge-emerald d-inline-flex align-items-center gap-1 rounded-pill text-xxs fw-600 shrink-0">
                                <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
                                </svg>
                                Ambulance
                            </span>
                        @else
                            <span class="badge badge-amber d-inline-flex align-items-center gap-1 rounded-pill text-xxs fw-600">
                                <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3z"></path>
                                </svg>
                                Umum
                            </span>
                        @endif
                        @if($item->prioritas === 'segera')
                            <span class="badge badge-red d-inline-flex align-items-center rounded-pill text-xxs fw-bold">
                                ⚡ CITO
                            </span>
                        @endif
                    </div>

                    <!-- Keperluan -->
                    @if ($item->keperluan)
                        <div class="text-xs text-slate-900 fw-500 mb-3">
                            {{ ucfirst($item->keperluan) }}
                        </div>
                    @endif

                    <!-- Jadwal -->
                    <div class="mb-3 text-xs">
                        <div class="d-flex align-items-center gap-2 text-slate-700 mb-1">
                            <svg class="text-slate-400" width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="fw-500">{{ $item->tanggal?->format('d/m/Y') }}</span>
                            <span class="text-slate-500">{{ substr($item->jam, 0, 5) }}</span>
                        </div>
                        @if ($item->tanggal_sampai && $item->jam_sampai)
                            <div class="text-xxs text-slate-500 ps-4">
                                s/d {{ $item->tanggal_sampai?->format('d/m/Y') }} {{ substr($item->jam_sampai, 0, 5) }}
                            </div>
                        @endif
                        <div class="text-xxs text-slate-400 ps-4">Dibuat: {{ $item->created_at->format('d/m/Y, H:i') }}</div>
                    </div>

                    <!-- Action Button -->
                    <a href="{{ route('pengajuan.success', $item) }}" class="d-block w-100 text-center rounded text-xs fw-600 text-white px-4 py-2" style="background-color:#059669; color:white !important;">
                        Lihat Detail
                    </a>
                </div>

            @empty
                <div class="p-5 text-center">
                    <div class="d-flex flex-column align-items-center gap-3">
                        <div class="bg-slate-100 rounded-circle p-3">
                            <svg class="text-slate-400" width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="fw-600 text-slate-900 mb-1 text-xs">Belum ada pengajuan</p>
                            <p class="text-xs text-slate-500 mb-0">Buat pengajuan transportasi untuk memulai</p>
                        </div>
                        <a href="{{ route('dashboard') }}" class="d-inline-flex align-items-center gap-2 px-3 py-2 text-white text-xs fw-600 rounded" style="background-color:#059669;">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                            Buat Pengajuan
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($items->hasPages())
        <div class="px-3 py-3 bg-slate-50 border-top border-slate-200">
            {{ $items->links() }}
        </div>
        @endif
    </div>

</div>

{{-- ✅ Modal Popup Berhasil Buat Pengajuan Berulang --}}
@if(session('recurring_success'))
<div id="recurringSuccessModal"
     class="position-fixed inset-0 d-flex align-items-center justify-content-center p-3"
     style="z-index:9999; background:rgba(0,0,0,0.45); backdrop-filter:blur(2px);">
    <div id="recurringModalBox"
         class="position-relative bg-white rounded shadow-2xl w-100 overflow-hidden"
         style="max-width:24rem; animation: modalPop 0.35s cubic-bezier(0.34,1.56,0.64,1) both;">

        {{-- Top accent bar --}}
        <div style="height:.375rem; background:linear-gradient(to right, #007774, #81BD41);"></div>

        <div class="px-4 py-4 text-center">
            {{-- Ikon centang animasi --}}
            <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle"
                 style="width:4rem; height:4rem; background:linear-gradient(135deg,#e6f7f6 0%,#f0fae8 100%); border:3px solid #007774;">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none"
                     stroke="#007774" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                     style="animation: checkDraw 0.5s 0.2s ease both;">
                    <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </div>

            {{-- Judul --}}
            <h2 class="text-sm fw-bold text-slate-900 mb-1">Pengajuan Berulang Dibuat!</h2>

            {{-- Pesan --}}
            <p class="text-xs text-slate-500 mb-1">
                {{ session('recurring_success') }}
            </p>
            <p class="text-xxs text-indigo-600 fw-600 bg-indigo-50 border border-indigo-200 rounded px-3 py-2 mt-3">
                🔁 Pengajuan akan dibuat otomatis setiap hari yang dipilih
            </p>
        </div>

        {{-- Tombol tutup --}}
        <div class="px-4 pb-4">
            <button onclick="closeRecurringModal()"
                    class="btn w-100 text-sm fw-600 text-white"
                    style="background:linear-gradient(to right, #007774, #009e9a); padding-top:.625rem; padding-bottom:.625rem;">
                Mengerti, Oke!
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes modalPop {
        0%   { opacity: 0; transform: scale(0.7) translateY(30px); }
        100% { opacity: 1; transform: scale(1) translateY(0); }
    }
</style>

<script>
    function closeRecurringModal() {
        const modal = document.getElementById('recurringSuccessModal');
        const box   = document.getElementById('recurringModalBox');
        if (box) {
            box.style.transition = 'opacity 0.2s, transform 0.2s';
            box.style.opacity = '0';
            box.style.transform = 'scale(0.85)';
        }
        setTimeout(() => { if (modal) modal.remove(); }, 220);
    }

    document.getElementById('recurringSuccessModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeRecurringModal();
    });

    setTimeout(closeRecurringModal, 8000);
</script>
@endif

</x-app-layout>
