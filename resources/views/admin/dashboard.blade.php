<x-app-layout title="Dashboard Admin — SIPETRANS">
    <div class="container-fluid px-2 px-sm-3 px-md-4 pt-2 pt-sm-3 pb-4 pb-sm-5">
        <!-- Header -->
        <div class="mb-3 mb-sm-4">
            <h1 class="fs-5 fw-bold text-slate-900">Dashboard Admin</h1>
            <p class="text-xs text-slate-500 mt-1">Ringkasan dan monitoring pengajuan transportasi</p>
        </div>

        <!-- Summary Statistics Cards -->
        <div class="row g-2 g-sm-3 mb-3 mb-sm-4">
            @foreach([
                ['label'=>'Total',          'value'=>$summary['total'],                    'color'=>'slate',   'path'=>'M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5z'],
                ['label'=>'Diajukan',       'value'=>$summary['diajukan'],                 'color'=>'amber',   'path'=>'M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z'],
                ['label'=>'Disetujui',      'value'=>$summary['diproses'],                 'color'=>'blue',    'path'=>'M5.5 16a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 16h-8z'],
                ['label'=>'Digunakan',      'value'=>$summary['digunakan'] ?? 0,           'color'=>'cyan',    'path'=>'M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3z'],
                ['label'=>'Selesai',        'value'=>$summary['selesai'],                  'color'=>'emerald', 'path'=>'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z'],
                ['label'=>'Tidak Disetujui','value'=>$summary['tidak_disetujui'],          'color'=>'red',     'path'=>'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z'],
            ] as $stat)
            <div class="col-6 col-sm-4 col-lg-2">
            @if($stat['label'] === 'Diajukan')
                @php $hasPending = $summary['diajukan'] > 0; @endphp
                <a href="{{ route('admin.transport.index') }}"
                   class="sp-stat-card border border-amber-200 text-decoration-none {{ $hasPending ? 'card-diajukan-pulse' : '' }}">
                    <div class="sp-stat-icon bg-amber-100 shrink-0">
                        <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20" style="width:1rem;height:1rem;color:#d97706;">
                            <path fill-rule="evenodd" d="{{ $stat['path'] }}" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="sp-stat-label text-amber-600 d-flex align-items-center gap-1">
                            {{ $stat['label'] }}
                            @if($hasPending)
                                <span class="d-inline-block rounded-circle bg-amber-500" style="width:.375rem;height:.375rem;animation:pulse 2s infinite;"></span>
                            @endif
                        </p>
                        <p class="sp-stat-value">{{ $stat['value'] }}</p>
                    </div>
                </a>
            @elseif($stat['label'] === 'Disetujui')
                @php $hasApprovedToday = ($approvedToday ?? 0) > 0; @endphp
                <a href="{{ route('admin.transport.index', ['status' => 'diproses']) }}"
                   class="sp-stat-card border border-blue-200 text-decoration-none {{ $hasApprovedToday ? 'card-disetujui-pulse' : '' }}">
                    <div class="sp-stat-icon bg-blue-100 shrink-0">
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20" style="width:1rem;height:1rem;color:#2563eb;">
                            <path fill-rule="evenodd" d="{{ $stat['path'] }}" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="sp-stat-label text-blue-600 d-flex align-items-center gap-1">
                            {{ $stat['label'] }}
                            @if($hasApprovedToday)
                                <span class="d-inline-block rounded-circle bg-blue-500" style="width:.375rem;height:.375rem;animation:pulse 2s infinite;"></span>
                            @endif
                        </p>
                        <p class="sp-stat-value">{{ $stat['value'] }}</p>
                    </div>
                </a>
            @else
            <div class="sp-stat-card border border-{{ $stat['color'] }}-200">
                <div class="sp-stat-icon bg-{{ $stat['color'] }}-100 shrink-0">
                    <svg fill="currentColor" viewBox="0 0 20 20" style="width:1rem;height:1rem;" class="text-{{ $stat['color'] }}-600">
                        <path fill-rule="evenodd" d="{{ $stat['path'] }}" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="sp-stat-label text-{{ $stat['color'] }}-600">{{ $stat['label'] }}</p>
                    <p class="sp-stat-value">{{ $stat['value'] }}</p>
                </div>
            </div>
            @endif
            </div>
            @endforeach
        </div>

        @if($summary['diajukan'] > 0 || ($approvedToday ?? 0) > 0)
        {{-- Pulse animations are already defined in sipetrans.css --}}
        @endif

        <!-- Latest Requests + Active Vehicles -->
        <div class="row g-3">

            <!-- Tabel Pengajuan Terbaru (2/3) -->
            <div class="col-12 col-xl-8">
                <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-sm-between mb-3 gap-2">
                    <div>
                        <h2 class="text-sm fw-bold text-slate-900 mb-0">Pengajuan Terbaru</h2>
                        <p class="text-xs text-slate-500 mb-0">5 pengajuan terakhir</p>
                    </div>
                    <a href="{{ route('admin.transport.index', ['status' => '']) }}"
                       class="d-inline-flex align-items-center gap-1 px-2 py-1 text-xs fw-500 text-emerald-700 rounded align-self-start align-self-sm-auto"
                       style="text-decoration:none;">
                        Lihat Semua
                        <svg style="width:.875rem;height:.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="sp-card overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="sp-table w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal &amp; Jam</th>
                                    <th>Dibuat</th>
                                    <th class="d-none d-sm-table-cell">Pemohon</th>
                                    <th>Jenis</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latest as $item)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.transport.show', $item) }}"
                                               class="font-mono text-xxs fw-600 text-teal-700" style="text-decoration:none;">
                                                {{ $item->nomor_pengajuan }}
                                            </a>
                                        </td>
                                        <td class="text-slate-700 fw-500 whitespace-nowrap">
                                            <div>{{ $item->tanggal->format('d/m/Y') }}</div>
                                            <div class="text-xxs text-slate-500">{{ substr($item->jam, 0, 5) }}</div>
                                        </td>
                                        <td class="whitespace-nowrap">
                                            <div class="text-xs text-slate-700 fw-500">{{ $item->created_at->format('d/m/Y') }}</div>
                                            <div class="text-xxs text-slate-500">{{ $item->created_at->format('H:i') }}</div>
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <div class="fw-500 text-slate-900 text-xs">{{ $item->user->full_name ?? $item->pemohon_nama }}</div>
                                            <div class="text-xxs text-slate-500">{{ $item->user->unit_kerja ?? $item->pemohon_unit }}</div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-1">
                                                <span class="badge status-badge {{ $item->jenis === 'ambulance' ? 'bg-red-100 text-red-700 border border-red-200' : 'bg-blue-100 text-blue-700 border border-blue-200' }}">{{ ucfirst($item->jenis) }}</span>
                                                @if($item->prioritas === 'segera')
                                                    <span class="badge status-badge badge-red align-self-start">CITO</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $statusConfig = match($item->status) {
                                                    'diajukan' => ['badge' => 'badge-amber', 'label' => 'Diajukan'],
                                                    'diproses' => ['badge' => 'badge-blue', 'label' => 'Disetujui'],
                                                    'digunakan' => ['badge' => 'badge-cyan', 'label' => 'Digunakan'],
                                                    'selesai' => ['badge' => 'badge-emerald', 'label' => 'Selesai'],
                                                    'tidak_disetujui' => ['badge' => 'badge-red', 'label' => 'Tidak Disetujui'],
                                                    default => ['badge' => 'badge-slate', 'label' => ucfirst($item->status)]
                                                };
                                            @endphp
                                            <span class="badge status-badge {{ $statusConfig['badge'] }}">
                                                {{ $statusConfig['label'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-2 px-sm-3 py-4 text-center">
                                            <div class="d-flex flex-column align-items-center gap-2">
                                                <svg style="width:2.5rem;height:2.5rem;" class="text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                <p class="text-slate-500 fw-500 text-xs mb-0">Belum ada pengajuan</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Card Kendaraan Sedang Digunakan (1/3) -->
            <div class="col-12 col-xl-4">
                <div class="mb-3">
                    <h2 class="text-sm fw-bold text-slate-900 mb-0">Sedang Digunakan</h2>
                    <p class="text-xs text-slate-500 mb-0">Kendaraan aktif saat ini</p>
                </div>

                <div class="sp-card overflow-hidden ring-1 ring-cyan-200">
                    @if($activeVehicles->isEmpty())
                        <div class="px-4 py-5 text-center">
                            <svg style="width:2rem;height:2rem;" class="text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-xs text-slate-500 fw-500 mb-0">Tidak ada kendaraan</p>
                            <p class="text-xxs text-slate-400 mt-1 mb-0">yang sedang digunakan</p>
                        </div>
                    @else
                        <div class="divide-y divide-slate-100">
                            @foreach($activeVehicles as $v)
                                <a href="{{ route('admin.transport.show', $v) }}"
                                   class="d-flex align-items-start gap-2 px-3 py-2 text-decoration-none" style="transition:background .1s;" onmouseover="this.style.background='#ecfeff'" onmouseout="this.style.background=''">
                                    <div class="mt-1 flex-shrink-0 d-flex align-items-center justify-content-center rounded bg-cyan-100" style="width:1.75rem;height:1.75rem;">
                                        <svg style="width:.875rem;height:.875rem;color:#0e7490;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM3 4h13l3 5v4H3V4z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="text-xs fw-600 text-slate-900 truncate">
                                            {{ $v->unit_mobil ?? '-' }}
                                        </div>
                                        <div class="text-xxs text-slate-500 mt-1">
                                            {{ $v->tanggal->format('d/m/Y') }} {{ substr($v->jam, 0, 5) }}
                                            <span class="text-slate-400">–</span>
                                            @if($v->tanggal_sampai && $v->jam_sampai)
                                                {{ $v->tanggal_sampai->format('d/m/Y') }} {{ substr($v->jam_sampai, 0, 5) }}
                                            @else
                                                Sampai Selesai
                                            @endif
                                        </div>
                                        <div class="text-xxs text-slate-400 truncate mt-1">
                                            {{ $v->user->full_name ?? $v->pemohon_nama }}
                                        </div>
                                    </div>
                                    @if($v->prioritas === 'segera')
                                        <span class="flex-shrink-0 badge status-badge badge-red">CITO</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
