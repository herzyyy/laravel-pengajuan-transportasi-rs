<x-app-layout>
    <div class="max-w-5xl mx-auto px-3 pt-3 pb-6 space-y-3">

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
            @if($historyRequests->isEmpty() && !request()->hasAny(['status','tanggal','jenis']))
                <div class="p-10 text-center">
                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-xs text-slate-500 font-medium">Belum ada riwayat perjalanan</p>
                </div>
            @else
                <!-- Filter -->
                <form method="GET" action="{{ route('driver.history') }}" id="driver-history-filter" class="flex flex-wrap gap-2 px-3 py-2.5 border-b border-slate-200 bg-slate-50/70">
                    <select name="status" class="rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-2 focus:ring-teal-400 focus:border-teal-400 bg-white">
                        <option value="">Semua Status</option>
                        <option value="selesai" @selected(request('status') === 'selesai')>Selesai</option>
                        <option value="tidak_disetujui" @selected(request('status') === 'tidak_disetujui')>Ditolak</option>
                    </select>
                    <select name="jenis" class="rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-2 focus:ring-teal-400 focus:border-teal-400 bg-white">
                        <option value="">Semua Jenis</option>
                        <option value="umum" @selected(request('jenis') === 'umum')>Umum</option>
                        <option value="ambulance" @selected(request('jenis') === 'ambulance')>Ambulance</option>
                    </select>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                           class="rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-2 focus:ring-teal-400 focus:border-teal-400 bg-white">
                </form>

                {{-- TABLE: desktop only --}}
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full text-xs">
                        <thead>
                            <tr class="text-left text-[10px] font-semibold text-white uppercase tracking-wider" style="background: linear-gradient(to right, #007774, #009e9a);">
                                <th class="px-4 py-3">No. Pengajuan</th>
                                <th class="px-4 py-3">Pemohon</th>
                                <th class="px-4 py-3">Jenis</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Unit Mobil</th>
                                <th class="px-4 py-3">Tujuan</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($historyRequests as $item)
                                <tr class="hover:bg-teal-50/40 transition-colors">
                                    <td class="px-4 py-3">
                                        <span class="font-mono text-[10px] font-semibold text-teal-700 bg-teal-50 border border-teal-100 px-2 py-0.5 rounded-md">{{ $item->nomor_pengajuan }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <p class="font-semibold text-slate-800 truncate max-w-[140px]">{{ $item->user->full_name ?? $item->pemohon_nama }}</p>
                                        @if($item->user?->unit_kerja)
                                            <p class="text-[10px] text-slate-400 truncate max-w-[140px]">{{ $item->user->unit_kerja }}</p>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $item->jenis === 'ambulance' ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                            {{ ucfirst($item->jenis) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-700 font-medium whitespace-nowrap">{{ $item->tanggal->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $item->unit_mobil ?? '-' }}</td>
                                    <td class="px-4 py-3 text-slate-500 max-w-[160px] truncate">{{ $item->alamat_tujuan ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        @if($item->status === 'selesai')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">Selesai</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-800 border border-red-200">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('driver.detail', $item) }}"
                                           class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-semibold text-white whitespace-nowrap transition hover:opacity-90" style="background:#007774; color:white;">
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

                {{-- CARDS: mobile only --}}
                <div class="sm:hidden divide-y divide-slate-100">
                    @foreach($historyRequests as $item)
                        <div class="px-3 py-3 hover:bg-slate-50 transition">
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap mb-1">
                                        <span class="font-mono text-[10px] font-semibold text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded">{{ $item->nomor_pengajuan }}</span>
                                        @if($item->status === 'selesai')
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-emerald-100 text-emerald-800">Selesai</span>
                                        @else
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-red-100 text-red-800">Ditolak</span>
                                        @endif
                                        <span class="text-[9px] text-slate-400">{{ ucfirst($item->jenis) }}</span>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-800 truncate">{{ $item->user->full_name ?? $item->pemohon_nama }}</p>
                                    @if($item->user?->unit_kerja)
                                        <p class="text-[10px] text-slate-400 truncate">{{ $item->user->unit_kerja }}</p>
                                    @endif
                                    <div class="flex items-center gap-3 mt-1.5 text-[10px] text-slate-500 flex-wrap">
                                        <span>{{ $item->tanggal->format('d/m/Y') }}</span>
                                        @if($item->unit_mobil)
                                            <span class="font-medium text-slate-700">{{ $item->unit_mobil }}</span>
                                        @endif
                                        @if($item->alamat_tujuan)
                                            <span class="truncate max-w-[160px]">→ {{ $item->alamat_tujuan }}</span>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('driver.detail', $item) }}"
                                   class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600 hover:text-emerald-700 shrink-0 mt-0.5">
                                    Detail
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($historyRequests->hasPages())
                    <div class="px-3 py-3 bg-slate-50 border-t border-slate-200">
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
