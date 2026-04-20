<x-app-layout>
    <div class="max-w-3xl mx-auto px-3 pt-3 pb-6 space-y-3">

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-base font-bold text-slate-900">Riwayat Perjalanan</h1>
                <div class="flex items-center gap-2 mt-0.5">
                    <p class="text-[11px] text-slate-500">{{ $driver->name }}</p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                        {{ $historyRequests->total() }} total
                    </span>
                </div>
            </div>
            <a href="{{ route('driver.dashboard') }}"
               class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-slate-200 bg-white text-xs font-medium text-slate-600 hover:bg-slate-50 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            @if($historyRequests->isEmpty())
                <div class="p-10 text-center">
                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-xs text-slate-500 font-medium">Belum ada riwayat perjalanan</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-xs">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr class="text-left text-[10px] font-semibold uppercase tracking-wide text-slate-500">
                                <th class="px-3 py-2.5">No. Pengajuan</th>
                                <th class="px-3 py-2.5">Tanggal</th>
                                <th class="px-3 py-2.5">Pemohon</th>
                                <th class="px-3 py-2.5">Kendaraan</th>
                                <th class="px-3 py-2.5">Tujuan</th>
                                <th class="px-3 py-2.5">Status</th>
                                <th class="px-3 py-2.5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($historyRequests as $item)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-3 py-2.5">
                                        <span class="font-mono text-[11px] font-semibold text-slate-700 bg-slate-100 px-2 py-0.5 rounded">
                                            {{ $item->nomor_pengajuan }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2.5 whitespace-nowrap text-slate-700">
                                        {{ $item->tanggal->format('d/m/Y') }}
                                    </td>
                                    <td class="px-3 py-2.5">
                                        <div class="font-medium text-slate-800 truncate max-w-[120px]">{{ $item->user->full_name ?? $item->pemohon_nama }}</div>
                                        @if($item->user?->unit_kerja)
                                            <div class="text-[10px] text-slate-400 truncate max-w-[120px]">{{ $item->user->unit_kerja }}</div>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2.5">
                                        <div class="font-medium text-slate-700">{{ $item->unit_mobil ?? '-' }}</div>
                                        <div class="text-[10px] text-slate-400">{{ ucfirst($item->jenis) }}</div>
                                    </td>
                                    <td class="px-3 py-2.5">
                                        <div class="text-slate-600 truncate max-w-[140px]">{{ $item->alamat_tujuan ?? '-' }}</div>
                                    </td>
                                    <td class="px-3 py-2.5">
                                        @if($item->status === 'selesai')
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-emerald-100 text-emerald-800">Selesai</span>
                                        @else
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-red-100 text-red-800">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2.5 text-center">
                                        <a href="{{ route('driver.detail', $item) }}"
                                           class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600 hover:text-emerald-700 hover:underline transition">
                                            Detail
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($historyRequests->hasPages())
                    <div class="px-3 py-3 bg-slate-50 border-t border-slate-200">
                        {{ $historyRequests->links() }}
                    </div>
                @endif
            @endif
        </div>

    </div>
</x-app-layout>
