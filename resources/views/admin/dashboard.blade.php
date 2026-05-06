<x-app-layout title="Dashboard Admin — SIPETRANS">
    <div class="max-w-7xl mx-auto px-2 sm:px-3 md:px-4 pt-2 sm:pt-3 pb-4 sm:pb-6">
        <!-- Header -->
        <div class="mb-3 sm:mb-4">
            <h1 class="text-lg sm:text-xl font-bold text-slate-900">Dashboard Admin</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Ringkasan dan monitoring pengajuan transportasi</p>
        </div>

        <!-- Summary Statistics Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2 sm:gap-3 mb-3 sm:mb-4">
            @foreach([
                ['label'=>'Total',          'value'=>$summary['total'],                    'color'=>'slate',   'path'=>'M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5z'],
                ['label'=>'Diajukan',       'value'=>$summary['diajukan'],                 'color'=>'amber',   'path'=>'M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z'],
                ['label'=>'Disetujui',      'value'=>$summary['diproses'],                 'color'=>'blue',    'path'=>'M5.5 16a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 16h-8z'],
                ['label'=>'Digunakan',      'value'=>$summary['digunakan'] ?? 0,           'color'=>'cyan',    'path'=>'M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3z'],
                ['label'=>'Selesai',        'value'=>$summary['selesai'],                  'color'=>'emerald', 'path'=>'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z'],
                ['label'=>'Tidak Disetujui','value'=>$summary['tidak_disetujui'],          'color'=>'red',     'path'=>'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z'],
            ] as $stat)
            @if($stat['label'] === 'Diajukan')
                @php $hasPending = $summary['diajukan'] > 0; @endphp
                <a href="{{ route('admin.transport.index') }}"
                   class="relative overflow-hidden bg-white border border-amber-200 rounded-lg px-3 py-4 flex items-center gap-3 shadow-sm hover:shadow-md transition {{ $hasPending ? 'card-diajukan-pulse' : '' }}">
                    @if($hasPending)
                        <span class="absolute inset-0 rounded-lg animate-ping-border pointer-events-none"></span>
                    @endif
                    <div class="shrink-0 rounded-lg p-2 bg-amber-100 relative z-10">
                        <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="{{ $stat['path'] }}" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="min-w-0 relative z-10">
                        <p class="text-[9px] font-semibold text-amber-600 uppercase tracking-wide truncate flex items-center gap-1">
                            {{ $stat['label'] }}
                            @if($hasPending)
                                <span class="inline-block w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                            @endif
                        </p>
                        <p class="text-2xl font-bold text-slate-900 leading-none mt-1">{{ $stat['value'] }}</p>
                    </div>
                </a>
            @elseif($stat['label'] === 'Disetujui')
                <a href="{{ route('admin.transport.index', ['status' => 'diproses']) }}"
                   class="bg-white border border-blue-200 rounded-lg px-3 py-4 flex items-center gap-3 shadow-sm hover:shadow-md transition">
                    <div class="shrink-0 rounded-lg p-2 bg-blue-100">
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="{{ $stat['path'] }}" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[9px] font-semibold text-blue-600 uppercase tracking-wide truncate">{{ $stat['label'] }}</p>
                        <p class="text-2xl font-bold text-slate-900 leading-none mt-1">{{ $stat['value'] }}</p>
                    </div>
                </a>
            @else
            <div class="bg-white border border-{{ $stat['color'] }}-200 rounded-lg px-3 py-4 flex items-center gap-3 shadow-sm hover:shadow-md transition">
                <div class="shrink-0 rounded-lg p-2 bg-{{ $stat['color'] }}-100">
                    <svg class="w-4 h-4 text-{{ $stat['color'] }}-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="{{ $stat['path'] }}" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[9px] font-semibold text-{{ $stat['color'] }}-600 uppercase tracking-wide truncate">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-bold text-slate-900 leading-none mt-1">{{ $stat['value'] }}</p>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        @if($summary['diajukan'] > 0)
        <style>
            .card-diajukan-pulse {
                animation: diajukan-glow 2s ease-in-out infinite;
            }
            @keyframes diajukan-glow {
                0%, 100% { border-color: #f59e0b; border-width: 2px; box-shadow: 0 0 0 0 rgba(245, 158, 11, 0), 0 0 8px rgba(245, 158, 11, 0.3); background-color: #fffbeb; }
                50%       { border-color: #d97706; border-width: 2px; box-shadow: 0 0 0 6px rgba(245, 158, 11, 0.25), 0 0 16px rgba(245, 158, 11, 0.5); background-color: #fef3c7; }
            }
        </style>
        @endif

        <!-- Latest Requests + Active Vehicles -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-3">

            <!-- Tabel Pengajuan Terbaru (2/3) -->
            <div class="xl:col-span-2">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3 gap-2">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Pengajuan Terbaru</h2>
                        <p class="text-xs text-slate-500 mt-0">5 pengajuan terakhir</p>
                    </div>
                    <a href="{{ route('admin.transport.index') }}"
                       class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium text-emerald-700 hover:bg-emerald-50 rounded-lg transition self-start sm:self-auto">
                        Lihat Semua
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="bg-white rounded-lg shadow-sm ring-1 ring-slate-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs">
                            <thead>
                                <tr class="text-left text-[10px] font-semibold text-white uppercase tracking-wider" style="background: linear-gradient(to right, #007774, #009e9a);">
                                    <th class="px-2 sm:px-3 py-2.5">No</th>
                                    <th class="px-2 sm:px-3 py-2.5">Tanggal & Jam</th>
                                    <th class="px-2 sm:px-3 py-2.5">Dibuat</th>
                                    <th class="px-2 sm:px-3 py-2.5 hidden sm:table-cell">Pemohon</th>
                                    <th class="px-2 sm:px-3 py-2.5">Jenis</th>
                                    <th class="px-2 sm:px-3 py-2.5">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($latest as $item)
                                    <tr class="hover:bg-teal-50/40 transition-colors">
                                        <td class="px-2 sm:px-3 py-2.5">
                                            <a href="{{ route('admin.transport.show', $item) }}"
                                               class="font-mono text-[11px] font-semibold text-teal-700 hover:underline">
                                                {{ $item->nomor_pengajuan }}
                                            </a>
                                        </td>
                                        <td class="px-2 sm:px-3 py-2.5 text-slate-700 font-medium whitespace-nowrap">
                                            <div>{{ $item->tanggal->format('d/m/Y') }}</div>
                                            <div class="text-[10px] text-slate-500">{{ substr($item->jam, 0, 5) }}</div>
                                        </td>
                                        <td class="px-2 sm:px-3 py-2.5 whitespace-nowrap">
                                            <div class="text-xs text-slate-700 font-medium">{{ $item->created_at->format('d/m/Y') }}</div>
                                            <div class="text-[10px] text-slate-500">{{ $item->created_at->format('H:i') }}</div>
                                        </td>
                                        <td class="px-2 sm:px-3 py-2.5 hidden sm:table-cell">
                                            <div class="font-medium text-slate-900 text-xs">{{ $item->user->full_name ?? $item->pemohon_nama }}</div>
                                            <div class="text-[10px] text-slate-500">{{ $item->user->unit_kerja ?? $item->pemohon_unit }}</div>
                                        </td>
                                        <td class="px-2 sm:px-3 py-2.5">
                                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-1.5">
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-semibold {{ $item->jenis === 'ambulance' ? 'bg-rose-100 text-rose-700 border border-rose-200' : 'bg-blue-100 text-blue-700 border border-blue-200' }}">{{ ucfirst($item->jenis) }}</span>
                                                @if($item->prioritas === 'segera')
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-md text-[9px] font-bold bg-red-100 text-red-700 border border-red-200 self-start">CITO</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-2 sm:px-3 py-2.5">
                                            @php
                                                $statusConfig = match($item->status) {
                                                    'diajukan' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'border' => 'border-amber-200', 'label' => 'Diajukan'],
                                                    'diproses' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'border' => 'border-blue-200', 'label' => 'Disetujui'],
                                                    'digunakan' => ['bg' => 'bg-cyan-100', 'text' => 'text-cyan-800', 'border' => 'border-cyan-200', 'label' => 'Digunakan'],
                                                    'selesai' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'border' => 'border-emerald-200', 'label' => 'Selesai'],
                                                    'tidak_disetujui' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'border' => 'border-red-200', 'label' => 'Tidak Disetujui'],
                                                    default => ['bg' => 'bg-slate-100', 'text' => 'text-slate-800', 'border' => 'border-slate-200', 'label' => ucfirst($item->status)]
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-1.5 sm:px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }}">
                                                {{ $statusConfig['label'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-2 sm:px-3 py-6 sm:py-8 text-center">
                                            <div class="flex flex-col items-center gap-2">
                                                <svg class="w-8 sm:w-10 h-8 sm:h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                <p class="text-slate-500 font-medium text-xs">Belum ada pengajuan</p>
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
            <div>
                <div class="mb-3">
                    <h2 class="text-sm font-bold text-slate-900">Sedang Digunakan</h2>
                    <p class="text-xs text-slate-500 mt-0">Kendaraan aktif saat ini</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm ring-1 ring-cyan-200 overflow-hidden">
                    @if($activeVehicles->isEmpty())
                        <div class="px-4 py-8 text-center">
                            <svg class="w-8 h-8 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-xs text-slate-500 font-medium">Tidak ada kendaraan</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">yang sedang digunakan</p>
                        </div>
                    @else
                        <div class="divide-y divide-slate-100">
                            @foreach($activeVehicles as $v)
                                <a href="{{ route('admin.transport.show', $v) }}"
                                   class="flex items-start gap-2.5 px-3 py-2.5 hover:bg-cyan-50 transition">
                                    <div class="mt-0.5 flex-shrink-0 w-7 h-7 rounded-lg bg-cyan-100 flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM3 4h13l3 5v4H3V4z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-xs font-semibold text-slate-900 truncate">
                                            {{ $v->unit_mobil ?? '-' }}
                                        </div>
                                        <div class="text-[10px] text-slate-500 mt-0.5">
                                            {{ $v->tanggal->format('d/m/Y') }} {{ substr($v->jam, 0, 5) }}
                                            <span class="text-slate-400">–</span>
                                            @if($v->tanggal_sampai && $v->jam_sampai)
                                                {{ $v->tanggal_sampai->format('d/m/Y') }} {{ substr($v->jam_sampai, 0, 5) }}
                                            @else
                                                Sampai Selesai
                                            @endif
                                        </div>
                                        <div class="text-[10px] text-slate-400 truncate mt-0.5">
                                            {{ $v->user->full_name ?? $v->pemohon_nama }}
                                        </div>
                                    </div>
                                    @if($v->prioritas === 'segera')
                                        <span class="flex-shrink-0 text-[9px] font-bold bg-red-100 text-red-700 px-1.5 py-0.5 rounded-full">CITO</span>
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
