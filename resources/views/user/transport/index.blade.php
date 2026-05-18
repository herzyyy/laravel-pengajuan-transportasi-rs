<x-app-layout title="Riwayat Pengajuan — SIPETRANS">
<div class="mx-auto px-2 px-sm-3 pt-2 pb-4" style="max-width:56rem;">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
        <div>
            <h1 class="fw-bold text-slate-900 mb-0" style="font-size:1rem;">Riwayat Pengajuan</h1>
            <p class="text-xxs text-slate-500 mt-1 mb-0">Daftar pengajuan transportasi yang telah Anda buat</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('dashboard') }}"
               class="d-inline-flex align-items-center gap-1 rounded px-2 py-1 text-xxs fw-600 text-white text-decoration-none"
               style="background:#059669;">
                <svg width="12" height="12" fill="white" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                </svg>
                <span class="d-none d-sm-inline">Pengajuan Baru</span>
                <span class="d-sm-none">Baru</span>
            </a>
            <a href="{{ route('dashboard') }}"
               class="d-inline-flex align-items-center gap-1 rounded border border-slate-300 bg-white px-2 py-1 text-xxs fw-600 text-slate-600 text-decoration-none">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Filter --}}
    <form action="{{ route('pengajuan.index') }}" method="GET" id="user-filter-form"
          class="sp-card px-3 py-2 mb-2 d-flex flex-wrap align-items-end gap-2">
        <div>
            <label class="form-label text-xxs fw-600 text-slate-600 mb-1 d-block">Jenis</label>
            <select name="jenis" class="form-select form-select-sm" style="width:auto;">
                <option value="">Semua</option>
                <option value="ambulance" {{ request('jenis')=='ambulance'?'selected':'' }}>Ambulance</option>
                <option value="umum" {{ request('jenis')=='umum'?'selected':'' }}>Umum</option>
            </select>
        </div>
        <div>
            <label class="form-label text-xxs fw-600 text-slate-600 mb-1 d-block">Status</label>
            <select name="status" class="form-select form-select-sm" style="width:auto;">
                <option value="">Semua</option>
                <option value="diajukan" {{ request('status')=='diajukan'?'selected':'' }}>Diajukan</option>
                <option value="diproses" {{ request('status')=='diproses'?'selected':'' }}>Disetujui</option>
                <option value="digunakan" {{ request('status')=='digunakan'?'selected':'' }}>Digunakan</option>
                <option value="selesai" {{ request('status')=='selesai'?'selected':'' }}>Selesai</option>
                <option value="tidak_disetujui" {{ request('status')=='tidak_disetujui'?'selected':'' }}>Tidak Disetujui</option>
            </select>
        </div>
        <div>
            <label class="form-label text-xxs fw-600 text-slate-600 mb-1 d-block">Tanggal</label>
            <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                   class="form-control form-control-sm" style="width:auto;">
        </div>
        @if(request()->hasAny(['jenis','status','tanggal']))
        <a href="{{ route('pengajuan.index') }}"
           class="d-inline-flex align-items-center px-2 py-1 rounded border border-slate-200 bg-white text-xxs fw-500 text-slate-500 text-decoration-none" style="margin-top:1.25rem;">
            Reset
        </a>
        @endif
    </form>

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

    {{-- Table / Cards --}}
    <div class="sp-card">

        {{-- Desktop Table --}}
        <div class="d-none d-md-block overflow-x-auto">
            <table class="sp-table" style="min-width:640px; table-layout:fixed;">
                <thead>
                    <tr>
                        <th style="width:5.5rem;">No. Pengajuan</th>
                        <th style="width:22%;">Jenis &amp; Keperluan</th>
                        <th style="width:22%;">Jadwal</th>
                        <th style="width:6rem;">Dibuat</th>
                        <th style="width:6rem;">Status</th>
                        <th style="width:3.5rem; text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                    <tr>
                        <td>
                            <span class="font-mono text-xxs fw-600 text-teal-700 bg-teal-50 border border-slate-200 px-1 py-0.5 rounded">
                                {{ $item->nomor_pengajuan }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-1 flex-wrap mb-1">
                                @if($item->jenis === 'ambulance')
                                    <span class="badge-emerald">Ambulance</span>
                                @else
                                    <span class="badge-amber">Umum</span>
                                @endif
                                @if($item->prioritas === 'segera')
                                    <span class="badge-red">⚡ CITO</span>
                                @endif
                            </div>
                            @if($item->keperluan)
                                <div class="text-xxs text-slate-600 fw-500 truncate" title="{{ ucfirst($item->keperluan) }}">
                                    {{ ucfirst($item->keperluan) }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="text-xxs text-slate-800 fw-500 whitespace-nowrap">
                                {{ $item->tanggal?->format('d M Y') }} {{ substr($item->jam, 0, 5) }}
                            </div>
                            <div class="text-xxs text-slate-400 whitespace-nowrap">
                                @if($item->tanggal_sampai && $item->jam_sampai)
                                    s/d {{ $item->tanggal_sampai?->format('d M Y') }} {{ substr($item->jam_sampai, 0, 5) }}
                                @else
                                    s/d selesai
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="text-xxs text-slate-700 fw-500 whitespace-nowrap">{{ $item->created_at->format('d M Y') }}</div>
                            <div class="text-xxs text-slate-400 whitespace-nowrap">{{ $item->created_at->format('H:i') }}</div>
                        </td>
                        <td>
                            @php
                                $sc = match($item->status) {
                                    'diajukan'        => ['badge-amber',   'Diajukan'],
                                    'diproses'        => ['badge-blue',    'Disetujui'],
                                    'digunakan'       => ['badge-cyan',    'Digunakan'],
                                    'selesai'         => ['badge-emerald', 'Selesai'],
                                    'tidak_disetujui' => ['badge-red',     'Ditolak'],
                                    default           => ['badge-slate',   ucfirst($item->status)],
                                };
                            @endphp
                            <span class="{{ $sc[0] }}">{{ $sc[1] }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('pengajuan.success', $item) }}"
                               class="d-inline-flex align-items-center gap-1 text-xxs fw-600 text-decoration-none"
                               style="color:#007774;">
                                Detail
                                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-4 text-center text-xxs text-slate-500">
                            Belum ada pengajuan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="d-md-none divide-y divide-slate-100">
            @forelse ($items as $item)
            <div class="px-3 py-2 min-w-0">
                <div class="d-flex align-items-start justify-content-between gap-2">
                    <div class="flex-grow-1 min-w-0">
                        <div class="d-flex align-items-center gap-1 flex-wrap mb-1">
                            <span class="font-mono text-xxs fw-600 text-slate-500 bg-slate-100 px-1 rounded">{{ $item->nomor_pengajuan }}</span>
                            @php
                                $sc = match($item->status) {
                                    'diajukan'        => ['badge-amber',   'Diajukan'],
                                    'diproses'        => ['badge-blue',    'Disetujui'],
                                    'digunakan'       => ['badge-cyan',    'Digunakan'],
                                    'selesai'         => ['badge-emerald', 'Selesai'],
                                    'tidak_disetujui' => ['badge-red',     'Ditolak'],
                                    default           => ['badge-slate',   ucfirst($item->status)],
                                };
                            @endphp
                            <span class="{{ $sc[0] }}">{{ $sc[1] }}</span>
                            @if($item->jenis === 'ambulance')
                                <span class="badge-emerald">Ambulance</span>
                            @else
                                <span class="badge-amber">Umum</span>
                            @endif
                            @if($item->prioritas === 'segera')
                                <span class="badge-red">⚡ CITO</span>
                            @endif
                        </div>
                        @if($item->keperluan)
                            <div class="text-xxs fw-600 text-slate-800 truncate">{{ ucfirst($item->keperluan) }}</div>
                        @endif
                        <div class="text-xxs text-slate-500 mt-1">
                            {{ $item->tanggal?->format('d/m/Y') }} {{ substr($item->jam, 0, 5) }}
                            @if($item->tanggal_sampai && $item->jam_sampai)
                                → {{ $item->tanggal_sampai?->format('d/m/Y') }} {{ substr($item->jam_sampai, 0, 5) }}
                            @endif
                        </div>
                        <div class="text-xxs text-slate-400">Dibuat: {{ $item->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <a href="{{ route('pengajuan.success', $item) }}"
                       class="d-inline-flex align-items-center gap-1 text-xxs fw-600 text-decoration-none shrink-0 mt-1"
                       style="color:#007774;">
                        Detail
                        <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="p-4 text-center text-xxs text-slate-500">Belum ada pengajuan</div>
            @endforelse
        </div>

        @if($items->hasPages())
        <div class="px-3 py-2 bg-slate-50 border-top border-slate-200">
            {{ $items->links() }}
        </div>
        @endif
    </div>

</div>

{{-- Modal Pengajuan Berulang --}}
@if(session('recurring_success'))
<div id="recurringSuccessModal"
     class="position-fixed inset-0 d-flex align-items-center justify-content-center p-3"
     style="z-index:9999; background:rgba(0,0,0,0.45); backdrop-filter:blur(2px);">
    <div id="recurringModalBox"
         class="position-relative bg-white rounded shadow w-100 overflow-hidden"
         style="max-width:22rem; animation: modalPop 0.35s cubic-bezier(0.34,1.56,0.64,1) both;">
        <div style="height:.25rem; background:linear-gradient(to right, #007774, #81BD41);"></div>
        <div class="px-4 py-3 text-center">
            <div class="mx-auto mb-2 d-flex align-items-center justify-content-center rounded-circle"
                 style="width:3rem; height:3rem; background:#e6f7f6; border:2px solid #007774;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#007774" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </div>
            <h2 class="fw-bold text-slate-900 mb-1" style="font-size:.875rem;">Pengajuan Berulang Dibuat!</h2>
            <p class="text-xxs text-slate-500 mb-2">{{ session('recurring_success') }}</p>
            <p class="text-xxs text-indigo-600 fw-600 bg-indigo-50 border border-indigo-200 rounded px-2 py-1">
                🔁 Pengajuan akan dibuat otomatis setiap hari yang dipilih
            </p>
        </div>
        <div class="px-4 pb-3">
            <button onclick="closeRecurringModal()"
                    class="btn w-100 text-xs fw-600 text-white"
                    style="background:linear-gradient(to right, #007774, #009e9a); padding:.375rem;">
                Mengerti, Oke!
            </button>
        </div>
    </div>
</div>
<style>
    @keyframes modalPop {
        0%   { opacity:0; transform:scale(0.7) translateY(20px); }
        100% { opacity:1; transform:scale(1) translateY(0); }
    }
</style>
<script>
    function closeRecurringModal() {
        const modal = document.getElementById('recurringSuccessModal');
        const box = document.getElementById('recurringModalBox');
        if (box) { box.style.transition='opacity .2s,transform .2s'; box.style.opacity='0'; box.style.transform='scale(0.85)'; }
        setTimeout(() => { if (modal) modal.remove(); }, 220);
    }
    document.getElementById('recurringSuccessModal')?.addEventListener('click', function(e) { if (e.target===this) closeRecurringModal(); });
    setTimeout(closeRecurringModal, 8000);
</script>
@endif

</x-app-layout>
