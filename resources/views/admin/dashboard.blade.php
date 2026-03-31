<x-app-layout>
    <div class="max-w-7xl mx-auto px-2 sm:px-3 md:px-4 pt-2 sm:pt-3 pb-4 sm:pb-6">
        <!-- Header -->
        <div class="mb-3 sm:mb-4">
            <h1 class="text-lg sm:text-xl font-bold text-slate-900">Dashboard Admin</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Ringkasan dan monitoring pengajuan transportasi</p>
        </div>

        <!-- Summary Statistics Cards -->
        <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2 sm:gap-3 mb-3 sm:mb-4">
            <div class="bg-white rounded-lg shadow-sm ring-1 ring-slate-200 p-2 sm:p-3 hover:shadow-md transition">
                <div class="text-[10px] font-semibold text-slate-600 uppercase tracking-wide mb-1">Total</div>
                <div class="text-xl sm:text-2xl font-bold text-slate-900">{{ $summary['total'] }}</div>
                <p class="text-[10px] text-slate-500 mt-0.5 hidden sm:block">Semua pengajuan</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm ring-1 ring-amber-200 p-2 sm:p-3 hover:shadow-md transition">
                <div class="text-[10px] font-semibold text-amber-700 uppercase tracking-wide mb-1">Diajukan</div>
                <div class="text-xl sm:text-2xl font-bold text-amber-900">{{ $summary['diajukan'] }}</div>
                <p class="text-[10px] text-amber-600 mt-0.5 hidden sm:block">Menunggu persetujuan</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm ring-1 ring-blue-200 p-2 sm:p-3 hover:shadow-md transition">
                <div class="text-[10px] font-semibold text-blue-700 uppercase tracking-wide mb-1">Disetujui</div>
                <div class="text-xl sm:text-2xl font-bold text-blue-900">{{ $summary['diproses'] }}</div>
                <p class="text-[10px] text-blue-600 mt-0.5 hidden sm:block">Sudah disetujui</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm ring-1 ring-cyan-200 p-2 sm:p-3 hover:shadow-md transition">
                <div class="text-[10px] font-semibold text-cyan-700 uppercase tracking-wide mb-1">Digunakan</div>
                <div class="text-xl sm:text-2xl font-bold text-cyan-900">{{ $summary['digunakan'] ?? 0 }}</div>
                <p class="text-[10px] text-cyan-600 mt-0.5 hidden sm:block">Sedang digunakan</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm ring-1 ring-emerald-200 p-2 sm:p-3 hover:shadow-md transition">
                <div class="text-[10px] font-semibold text-emerald-700 uppercase tracking-wide mb-1">Selesai</div>
                <div class="text-xl sm:text-2xl font-bold text-emerald-900">{{ $summary['selesai'] }}</div>
                <p class="text-[10px] text-emerald-600 mt-0.5 hidden sm:block">Sudah selesai</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm ring-1 ring-red-200 p-2 sm:p-3 hover:shadow-md transition">
                <div class="text-[10px] font-semibold text-red-700 uppercase tracking-wide mb-1">Tidak Disetujui</div>
                <div class="text-xl sm:text-2xl font-bold text-red-900">{{ $summary['tidak_disetujui'] }}</div>
                <p class="text-[10px] text-red-600 mt-0.5 hidden sm:block">Ditolak/kadaluarsa</p>
            </div>
        </div>

        <!-- Latest Requests Section -->
        <div>
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
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr class="text-[10px] font-semibold text-slate-600 uppercase tracking-wider">
                                <th class="px-2 sm:px-3 py-2 text-left">Tanggal</th>
                                <th class="px-2 sm:px-3 py-2 text-left hidden sm:table-cell">Pemohon</th>
                                <th class="px-2 sm:px-3 py-2 text-left">Jenis</th>
                                <th class="px-2 sm:px-3 py-2 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($latest as $item)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-2 sm:px-3 py-2 text-slate-700 font-medium whitespace-nowrap">
                                        {{ $item->tanggal->format('d/m/Y') }}
                                    </td>
                                    <td class="px-2 sm:px-3 py-2 hidden sm:table-cell">
                                        <div class="font-medium text-slate-900 text-xs">{{ $item->user->full_name ?? $item->pemohon_nama }}</div>
                                        <div class="text-[10px] text-slate-500">{{ $item->user->unit_kerja ?? $item->pemohon_unit }}</div>
                                    </td>
                                    <td class="px-2 sm:px-3 py-2">
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-1.5">
                                            <span class="text-slate-700 text-xs">{{ ucfirst($item->jenis) }}</span>
                                            @if($item->prioritas === 'segera')
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-md text-[9px] font-bold bg-red-100 text-red-700 self-start">CITO</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-2 sm:px-3 py-2">
                                        @php
                                            $statusConfig = match($item->status) {
                                                'diajukan' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'label' => 'Diajukan'],
                                                'diproses' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Disetujui'],
                                                'digunakan' => ['bg' => 'bg-cyan-100', 'text' => 'text-cyan-800', 'label' => 'Digunakan'],
                                                'selesai' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'label' => 'Selesai'],
                                                'tidak_disetujui' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Tidak Disetujui'],
                                                default => ['bg' => 'bg-slate-100', 'text' => 'text-slate-800', 'label' => ucfirst($item->status)]
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-1.5 sm:px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                            {{ $statusConfig['label'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-2 sm:px-3 py-6 sm:py-8 text-center">
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
    </div>
</x-app-layout>
