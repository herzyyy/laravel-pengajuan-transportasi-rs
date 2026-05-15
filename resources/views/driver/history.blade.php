<x-app-layout title="Riwayat Tugas — SIPETRANS">
    <div class="mx-auto px-3 pt-3 pb-5" style="max-width:64rem;">

        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h1 class="fw-bold text-slate-900 mb-0" style="font-size:1rem;">Riwayat Perjalanan</h1>
                <div class="d-flex align-items-center gap-2 mt-1">
                    <p class="text-xxs text-slate-500 mb-0">{{ $driver->name }}</p>
                    <span class="badge badge-slate d-inline-flex align-items-center rounded-pill text-xxs fw-bold">
                        {{ $historyRequests->total() }} total
                    </span>
                </div>
            </div>
            <a href="{{ route('driver.dashboard') }}"
               class="d-inline-flex align-items-center gap-1 px-3 py-2 rounded border border-slate-200 bg-white text-xs fw-500 text-slate-600">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>

        <div class="sp-card overflow-hidden">
            @if($historyRequests->isEmpty() && !request()->hasAny(['status','tanggal','jenis']))
                <div class="p-5 text-center">
                    <svg class="text-slate-300 mx-auto mb-2" width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-xs text-slate-500 fw-500 mb-0">Belum ada riwayat perjalanan</p>
                </div>
            @else
                <!-- Filter -->
                <form method="GET" action="{{ route('driver.history') }}" id="driver-history-filter"
                      class="d-flex flex-wrap gap-2 px-3 py-2 border-bottom border-slate-200 bg-slate-50">
                    <select name="status" class="form-select form-select-sm text-xs" style="width:auto;">
                        <option value="">Semua Status</option>
                        <option value="selesai" @selected(request('status') === 'selesai')>Selesai</option>
                        <option value="tidak_disetujui" @selected(request('status') === 'tidak_disetujui')>Ditolak</option>
                    </select>
                    <select name="jenis" class="form-select form-select-sm text-xs" style="width:auto;">
                        <option value="">Semua Jenis</option>
                        <option value="umum" @selected(request('jenis') === 'umum')>Umum</option>
                        <option value="ambulance" @selected(request('jenis') === 'ambulance')>Ambulance</option>
                    </select>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                           class="form-control form-control-sm text-xs" style="width:auto;">
                </form>

                {{-- TABLE: desktop only --}}
                <div class="d-none d-sm-block overflow-x-auto">
                    <table class="sp-table">
                        <thead>
                            <tr>
                                <th>No. Pengajuan</th>
                                <th>Pemohon</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Unit Mobil</th>
                                <th>Tujuan</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($historyRequests as $item)
                                <tr>
                                    <td>
                                        <span class="font-mono text-xxs fw-600 text-teal-700 bg-teal-50 border border-slate-200 px-2 py-1 rounded">{{ $item->nomor_pengajuan }}</span>
                                    </td>
                                    <td>
                                        <p class="fw-600 text-slate-800 truncate mb-0" style="max-width:140px;">{{ $item->user->full_name ?? $item->pemohon_nama }}</p>
                                        @if($item->user?->unit_kerja)
                                            <p class="text-xxs text-slate-400 truncate mb-0" style="max-width:140px;">{{ $item->user->unit_kerja }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $item->jenis === 'ambulance' ? 'badge-red' : 'badge-blue' }} d-inline-flex align-items-center rounded-pill text-xxs fw-600">
                                            {{ ucfirst($item->jenis) }}
                                        </span>
                                    </td>
                                    <td class="text-slate-700 fw-500 whitespace-nowrap">{{ $item->tanggal->format('d/m/Y') }}</td>
                                    <td class="text-slate-600">{{ $item->unit_mobil ?? '-' }}</td>
                                    <td class="text-slate-500 truncate" style="max-width:160px;">{{ $item->alamat_tujuan ?? '-' }}</td>
                                    <td>
                                        @if($item->status === 'selesai')
                                            <span class="badge badge-emerald d-inline-flex align-items-center rounded-pill text-xxs fw-bold">Selesai</span>
                                        @else
                                            <span class="badge badge-red d-inline-flex align-items-center rounded-pill text-xxs fw-bold">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('driver.detail', $item) }}"
                                           class="d-inline-flex align-items-center gap-1 px-3 py-1 rounded text-xxs fw-600 text-white whitespace-nowrap"
                                           style="background:#007774; color:white;">
                                            Detail
                                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- CARDS: mobile only --}}
                <div class="d-sm-none divide-y divide-slate-100">
                    @foreach($historyRequests as $item)
                        <div class="px-3 py-3">
                            <div class="d-flex align-items-start justify-content-between gap-2">
                                <div class="flex-grow-1 min-w-0">
                                    <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                        <span class="font-mono text-xxs fw-600 text-slate-500 bg-slate-100 px-2 py-1 rounded">{{ $item->nomor_pengajuan }}</span>
                                        @if($item->status === 'selesai')
                                            <span class="badge badge-emerald d-inline-flex align-items-center rounded-pill text-xxs fw-bold">Selesai</span>
                                        @else
                                            <span class="badge badge-red d-inline-flex align-items-center rounded-pill text-xxs fw-bold">Ditolak</span>
                                        @endif
                                        <span class="text-xxs text-slate-400">{{ ucfirst($item->jenis) }}</span>
                                    </div>
                                    <p class="text-xs fw-600 text-slate-800 truncate mb-0">{{ $item->user->full_name ?? $item->pemohon_nama }}</p>
                                    @if($item->user?->unit_kerja)
                                        <p class="text-xxs text-slate-400 truncate mb-0">{{ $item->user->unit_kerja }}</p>
                                    @endif
                                    <div class="d-flex align-items-center gap-3 mt-1 text-xxs text-slate-500 flex-wrap">
                                        <span>{{ $item->tanggal->format('d/m/Y') }}</span>
                                        @if($item->unit_mobil)
                                            <span class="fw-500 text-slate-700">{{ $item->unit_mobil }}</span>
                                        @endif
                                        @if($item->alamat_tujuan)
                                            <span class="truncate" style="max-width:160px;">→ {{ $item->alamat_tujuan }}</span>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('driver.detail', $item) }}"
                                   class="d-inline-flex align-items-center gap-1 text-xxs fw-600 text-emerald-600 shrink-0 mt-1">
                                    Detail
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($historyRequests->hasPages())
                    <div class="px-3 py-3 bg-slate-50 border-top border-slate-200">
                        {{ $historyRequests->links() }}
                    </div>
                @endif
            @endif
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('driver-history-filter');
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

    </div>
</x-app-layout>
