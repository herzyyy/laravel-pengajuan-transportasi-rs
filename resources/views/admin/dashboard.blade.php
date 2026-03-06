<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 pt-8 pb-12">
        <h1 class="text-2xl font-bold text-slate-800">
            Dashboard Admin Transportasi
        </h1>
        <p class="text-slate-500 mt-1 text-sm">
            Ringkasan cepat jumlah pengajuan berdasarkan status.
        </p>

        <!-- Summary Cards -->
        <div class="mt-6 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 px-5 py-4">
                <div class="text-xs font-medium text-slate-500 uppercase tracking-wide">Total Pengajuan</div>
                <div class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $summary['total'] }}
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-amber-200 px-5 py-4">
                <div class="text-xs font-medium text-amber-700 uppercase tracking-wide">Diajukan</div>
                <div class="mt-2 text-3xl font-bold text-amber-900">
                    {{ $summary['diajukan'] }}
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-blue-200 px-5 py-4">
                <div class="text-xs font-medium text-blue-700 uppercase tracking-wide">Disetujui</div>
                <div class="mt-2 text-3xl font-bold text-blue-900">
                    {{ $summary['diproses'] }}
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-emerald-200 px-5 py-4">
                <div class="text-xs font-medium text-emerald-700 uppercase tracking-wide">Selesai</div>
                <div class="mt-2 text-3xl font-bold text-emerald-900">
                    {{ $summary['selesai'] }}
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-red-200 px-5 py-4">
                <div class="text-xs font-medium text-red-700 uppercase tracking-wide">Ditolak</div>
                <div class="mt-2 text-3xl font-bold text-red-900">
                    {{ $summary['ditolak'] }}
                </div>
            </div>
        </div>

        <!-- Latest Requests Table -->
        <div class="mt-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-800">
                    Pengajuan Terbaru
                </h2>
                <a href="{{ route('admin.transport.index') }}"
                   class="inline-flex items-center gap-1 text-sm font-medium text-emerald-700 hover:text-emerald-900 transition">
                    Lihat semua pengajuan
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr class="text-xs font-semibold text-slate-600 uppercase tracking-wide">
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Pemohon</th>
                                <th class="py-3 px-4">Jenis</th>
                                <th class="py-3 px-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($latest as $item)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3 px-4 text-slate-700 whitespace-nowrap">
                                        {{ $item->tanggal->format('d M Y') }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="font-medium text-slate-900">
                                            {{ $item->user->full_name ?? $item->pemohon_nama }}
                                        </div>
                                        <div class="text-xs text-slate-500">
                                            {{ $item->user->unit_kerja ?? $item->pemohon_unit }}
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-slate-700">
                                        <span class="font-medium">{{ ucfirst($item->jenis) }}</span>
                                        @if($item->prioritas === 'segera')
                                            <span class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-700">
                                                CITO
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @php
                                            $statusConfig = match($item->status) {
                                                'diajukan' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'label' => 'Diajukan'],
                                                'diproses' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Disetujui'],
                                                'selesai' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'label' => 'Selesai'],
                                                'ditolak' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Ditolak'],
                                                default => ['bg' => 'bg-slate-100', 'text' => 'text-slate-800', 'label' => ucfirst($item->status)]
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                            {{ $statusConfig['label'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-slate-500 text-sm">
                                        <div class="flex flex-col items-center gap-2">
                                            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <p class="font-medium">Belum ada pengajuan</p>
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
