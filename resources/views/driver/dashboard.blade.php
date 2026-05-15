<x-app-layout title="Dashboard — SIPETRANS">
<div class="mx-auto px-3 pt-3 pb-5" style="max-width:42rem;">

    {{-- ── HEADER ── --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="fw-bold text-slate-900 mb-0" style="font-size:1rem;">Halo, {{ $driver->name }} 👋</h1>
            <p class="text-xxs text-slate-500 mt-1 mb-0">Berikut tugas perjalanan Anda hari ini.</p>
        </div>
        <a href="{{ route('driver.history') }}"
           class="d-inline-flex align-items-center gap-1 text-xxs fw-600 text-slate-500 border border-slate-200 bg-white rounded px-3 py-2">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
            </svg>
            Riwayat
        </a>
    </div>

    {{-- ── ALERTS ── --}}
    @if(session('success'))
        <div class="d-flex align-items-center gap-2 px-3 py-2 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded text-xs fw-500 mb-3">
            <svg class="shrink-0" width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="px-3 py-2 bg-red-50 border border-red-200 text-red-700 rounded text-xs mb-3">
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
    @endif

    {{-- ── STATS ── --}}
    <div class="row g-2 mb-3">
        <div class="col-4">
            <div class="bg-white border border-slate-200 rounded text-center px-3 py-2 shadow-sm">
                <p class="fw-bold text-slate-800 leading-none mb-1" style="font-size:1.25rem;">{{ $totalTugas }}</p>
                <p class="text-xxs fw-500 text-slate-500 mb-0">Total</p>
            </div>
        </div>
        <div class="col-4">
            <div class="bg-cyan-50 border border-cyan-200 rounded text-center px-3 py-2 shadow-sm">
                <p class="fw-bold text-cyan-700 leading-none mb-1" style="font-size:1.25rem;">{{ $tugasSaatIni }}</p>
                <p class="text-xxs fw-500 text-cyan-600 mb-0">Aktif</p>
            </div>
        </div>
        <div class="col-4">
            <div class="bg-emerald-50 border border-emerald-200 rounded text-center px-3 py-2 shadow-sm">
                <p class="fw-bold text-emerald-700 leading-none mb-1" style="font-size:1.25rem;">{{ $tugasSelesai }}</p>
                <p class="text-xxs fw-500 text-emerald-600 mb-0">Selesai</p>
            </div>
        </div>
    </div>

    {{-- ── TUGAS AKTIF ── --}}
    @forelse($activeRequests as $item)
    <div class="bg-white rounded border border-cyan-200 shadow-sm overflow-hidden mb-3" x-data="{ open: false }">

        {{-- Card header --}}
        <div class="px-4 pt-3 pb-2">
            <div class="d-flex align-items-start justify-content-between gap-2">
                <div class="flex-grow-1 min-w-0">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="badge badge-cyan d-inline-flex align-items-center rounded-pill text-xxs fw-bold">
                            <span class="rounded-circle me-1" style="width:.375rem; height:.375rem; background-color:#06b6d4; display:inline-block; animation:pulse 2s infinite;"></span>
                            Sedang Digunakan
                        </span>
                        <span class="badge {{ $item->jenis === 'ambulance' ? 'badge-red' : 'badge-amber' }} d-inline-flex align-items-center rounded-pill text-xxs fw-600">
                            {{ ucfirst($item->jenis) }}
                        </span>
                        @if($item->prioritas === 'segera')
                            <span class="badge bg-danger text-white rounded-pill text-xxs fw-bold">⚡ CITO</span>
                        @endif
                    </div>
                    <p class="font-mono text-xxs text-slate-400 mt-1 mb-0">{{ $item->nomor_pengajuan }}</p>
                </div>
                <a href="{{ route('driver.print', $item) }}?from=driver_active" target="_blank"
                   class="d-inline-flex align-items-center gap-1 text-xxs fw-600 px-3 py-1 rounded shrink-0"
                   style="background-color:#00685E; color:white !important;">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print
                </a>
            </div>

            {{-- Kendaraan --}}
            <div class="d-flex align-items-center gap-2 mt-3">
                <div class="d-flex align-items-center justify-content-center rounded bg-slate-100 shrink-0" style="width:2rem; height:2rem;">
                    <svg class="text-slate-500" width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs fw-bold text-slate-800 mb-0">{{ $item->unit_mobil ?? '-' }}</p>
                    @if($item->plat_nomor)<p class="text-xxs text-slate-400 font-mono mb-0">{{ $item->plat_nomor }}</p>@endif
                </div>
                @if($item->km_awal)
                <div class="ms-auto text-end">
                    <p class="text-xxs text-slate-400 mb-0">KM Awal</p>
                    <p class="text-xs fw-bold text-slate-700 mb-0">{{ number_format($item->km_awal, 0, ',', '.') }} km</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Info rows --}}
        <div class="mx-3 mb-3 bg-slate-50 rounded border border-slate-200 divide-y divide-slate-200" style="font-size:.6875rem;">
            <div class="d-flex align-items-center gap-2 px-3 py-2">
                <svg class="text-slate-400 shrink-0" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="text-slate-400 shrink-0" style="width:3.5rem;">Pemohon</span>
                <span class="fw-500 text-slate-800 truncate">{{ $item->user->full_name ?? $item->pemohon_nama }}</span>
            </div>
            <div class="d-flex align-items-center gap-2 px-3 py-2">
                <svg class="text-slate-400 shrink-0" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-slate-400 shrink-0" style="width:3.5rem;">Jadwal</span>
                <span class="fw-500 text-slate-800">{{ $item->tanggal->format('d/m/Y') }} {{ substr($item->jam, 0, 5) }}
                    @if($item->jam_sampai) – {{ substr($item->jam_sampai, 0, 5) }}@endif
                </span>
            </div>
            <div class="d-flex align-items-center gap-2 px-3 py-2">
                <svg class="text-slate-400 shrink-0" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="text-slate-400 shrink-0" style="width:3.5rem;">Tujuan</span>
                <span class="fw-500 text-slate-800 truncate">{{ $item->alamat_tujuan ?? '-' }}</span>
            </div>
        </div>

        {{-- Selesaikan --}}
        <div class="px-4 pb-4">
            <button type="button" @click="open = !open"
                    class="btn w-100 text-xs fw-600 px-3 py-2 d-flex align-items-center justify-content-center gap-2"
                    :class="open ? 'btn-outline-secondary' : 'btn-sp-primary'">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <span x-text="open ? 'Batal' : 'Selesaikan Perjalanan'"></span>
            </button>

            <div x-show="open" x-transition class="mt-2 bg-slate-50 rounded border border-slate-200 p-3">
                <form method="POST" action="{{ route('driver.complete', $item) }}">
                    @csrf
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label text-xxs fw-600 text-slate-700 mb-1">KM Tiba <span class="text-danger">*</span></label>
                            <input type="text" id="km_akhir_display_{{ $item->id }}" placeholder="Masukkan KM"
                                   inputmode="numeric" autocomplete="off"
                                   class="form-control form-control-sm text-xs">
                            <input type="hidden" name="km_akhir" id="km_akhir_{{ $item->id }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-xxs fw-600 text-slate-700 mb-1">Jam Tiba <span class="text-danger">*</span></label>
                            <input type="text" name="jam_kedatangan" placeholder="00:00"
                                   value="{{ now()->format('H:i') }}"
                                   maxlength="5" inputmode="numeric"
                                   class="form-control form-control-sm text-xs">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label text-xxs fw-600 text-slate-700 mb-1">Biaya E-Tol <span class="text-slate-400 fw-normal">(opsional)</span></label>
                        <input type="text" id="biaya_tol_display_{{ $item->id }}" placeholder="0"
                               inputmode="numeric" autocomplete="off"
                               class="form-control form-control-sm text-xs">
                        <input type="hidden" name="biaya_tol" id="biaya_tol_{{ $item->id }}">
                    </div>
                    <button type="submit" class="btn btn-sp-primary w-100 text-xs fw-600 py-2">
                        Simpan &amp; Selesai
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded border border-slate-200 shadow-sm p-5 text-center">
        <div class="d-flex align-items-center justify-content-center rounded-circle bg-slate-100 mx-auto mb-3" style="width:3rem; height:3rem;">
            <svg class="text-slate-400" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="text-sm fw-600 text-slate-700 mb-1">Tidak ada tugas aktif</p>
        <p class="text-xs text-slate-400 mb-0">Semua perjalanan sudah selesai.</p>
    </div>
    @endforelse

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[id^="km_akhir_display_"]').forEach(function (display) {
        const hidden = document.getElementById('km_akhir_' + display.id.replace('km_akhir_display_', ''));
        function fmt() { const r = display.value.replace(/\D/g,''); display.value = r ? parseInt(r).toLocaleString('id-ID') : ''; if (hidden) hidden.value = r; }
        display.addEventListener('input', function () {
            const r = this.value.replace(/\D/g,''); const c = this.selectionStart; const pl = this.value.length;
            this.value = r ? parseInt(r).toLocaleString('id-ID') : ''; if (hidden) hidden.value = r;
            this.setSelectionRange(c + this.value.length - pl, c + this.value.length - pl);
        });
        display.addEventListener('blur', fmt); display.addEventListener('change', fmt);
        display.addEventListener('keypress', e => { if (!/[0-9]/.test(e.key)) e.preventDefault(); });
    });

    document.querySelectorAll('[id^="biaya_tol_display_"]').forEach(function (display) {
        const hidden = document.getElementById('biaya_tol_' + display.id.replace('biaya_tol_display_', ''));
        function fmt() { const r = display.value.replace(/\D/g,''); display.value = r ? parseInt(r).toLocaleString('id-ID') : ''; if (hidden) hidden.value = r || ''; }
        display.addEventListener('input', function () {
            const r = this.value.replace(/\D/g,''); const c = this.selectionStart; const pl = this.value.length;
            this.value = r ? parseInt(r).toLocaleString('id-ID') : ''; if (hidden) hidden.value = r || '';
            this.setSelectionRange(c + this.value.length - pl, c + this.value.length - pl);
        });
        display.addEventListener('blur', fmt); display.addEventListener('change', fmt);
        display.addEventListener('keypress', e => { if (!/[0-9]/.test(e.key)) e.preventDefault(); });
    });

    document.querySelectorAll('input[name="jam_kedatangan"]').forEach(function (el) {
        el.addEventListener('input', function () {
            let v = this.value.replace(/[^0-9]/g, '');
            if (v.length > 2) v = v.slice(0,2) + ':' + v.slice(2,4);
            this.value = v;
        });
        el.addEventListener('keypress', e => { if (!/[0-9]/.test(e.key)) e.preventDefault(); });
    });
});
</script>
</x-app-layout>
