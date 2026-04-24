<x-app-layout>
    <div class="max-w-full mx-auto px-3 sm:px-4 pt-4 pb-4">
        <div class="flex items-center justify-between mb-3">
            <div>
                <h1 class="text-lg font-bold text-slate-900">Laporan Pengajuan</h1>
                <p class="text-xs text-slate-500 mt-0.5">Data lengkap seluruh pengajuan transportasi</p>
            </div>
        </div>

        {{-- Filter --}}
        <form method="GET" action="{{ route('admin.laporan') }}"
              class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-3 mb-3">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2">

                <div>
                    <label class="block text-[10px] font-semibold text-slate-600 mb-1">No. Pengajuan</label>
                    <input type="text" name="nomor" value="{{ request('nomor') }}" placeholder="Cari nomor..."
                           class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-xs">
                </div>

                <div>
                    <label class="block text-[10px] font-semibold text-slate-600 mb-1">Jenis</label>
                    <select name="jenis" class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-xs">
                        <option value="">Semua</option>
                        <option value="umum" @selected(request('jenis') === 'umum')>Umum</option>
                        <option value="ambulance" @selected(request('jenis') === 'ambulance')>Ambulance</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-semibold text-slate-600 mb-1">Status</label>
                    <select name="status" class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-xs">
                        <option value="">Semua</option>
                        <option value="diajukan" @selected(request('status') === 'diajukan')>Diajukan</option>
                        <option value="diproses" @selected(request('status') === 'diproses')>Disetujui</option>
                        <option value="digunakan" @selected(request('status') === 'digunakan')>Digunakan</option>
                        <option value="selesai" @selected(request('status') === 'selesai')>Selesai</option>
                        <option value="tidak_disetujui" @selected(request('status') === 'tidak_disetujui')>Tidak Disetujui</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-semibold text-slate-600 mb-1">Prioritas</label>
                    <select name="prioritas" class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-xs">
                        <option value="">Semua</option>
                        <option value="biasa" @selected(request('prioritas') === 'biasa')>Biasa</option>
                        <option value="segera" @selected(request('prioritas') === 'segera')>Segera / CITO</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-semibold text-slate-600 mb-1">Unit Kerja</label>
                    <input type="text" name="unit_kerja" value="{{ request('unit_kerja') }}" placeholder="Cari unit..."
                           class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-xs">
                </div>

                <div>
                    <label class="block text-[10px] font-semibold text-slate-600 mb-1">Unit Kendaraan</label>
                    <input type="text" name="unit_mobil" value="{{ request('unit_mobil') }}" placeholder="Cari kendaraan..."
                           class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-xs">
                </div>

                <div>
                    <label class="block text-[10px] font-semibold text-slate-600 mb-1">Tanggal Dari</label>
                    <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}"
                           class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-xs">
                </div>

                <div>
                    <label class="block text-[10px] font-semibold text-slate-600 mb-1">Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai_filter" value="{{ request('tanggal_sampai_filter') }}"
                           class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-xs">
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="flex-1 rounded-lg px-3 py-1.5 text-xs font-semibold text-white transition"
                            style="background:#007774;">
                        Filter
                    </button>
                    @if(request()->hasAny(['nomor','jenis','status','prioritas','unit_kerja','unit_mobil','tanggal_dari','tanggal_sampai_filter']))
                        <a href="{{ route('admin.laporan') }}"
                           class="flex-1 text-center rounded-lg px-3 py-1.5 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>

        {{-- Tabel --}}
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-xs min-w-[1100px]">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr class="text-[10px] font-semibold text-slate-600 uppercase tracking-wider">
                            <th class="px-3 py-2 text-left whitespace-nowrap">No. Pengajuan</th>
                            <th class="px-3 py-2 text-left whitespace-nowrap">Dibuat</th>
                            <th class="px-3 py-2 text-left whitespace-nowrap">Pemohon</th>
                            <th class="px-3 py-2 text-left whitespace-nowrap">Unit Kerja</th>
                            <th class="px-3 py-2 text-left whitespace-nowrap">Jenis</th>
                            <th class="px-3 py-2 text-left whitespace-nowrap">Keperluan</th>
                            <th class="px-3 py-2 text-left whitespace-nowrap">Tanggal</th>
                            <th class="px-3 py-2 text-left whitespace-nowrap">Jam</th>
                            <th class="px-3 py-2 text-left whitespace-nowrap">Tujuan</th>
                            <th class="px-3 py-2 text-left whitespace-nowrap">Kendaraan</th>
                            <th class="px-3 py-2 text-left whitespace-nowrap">Supir</th>
                            <th class="px-3 py-2 text-left whitespace-nowrap">KM</th>
                            <th class="px-3 py-2 text-left whitespace-nowrap">Jam Tiba</th>
                            <th class="px-3 py-2 text-left whitespace-nowrap">Status</th>
                            <th class="px-3 py-2 text-center whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($items as $item)
                            @php
                                $statusColors = [
                                    'diajukan'       => 'bg-amber-100 text-amber-800',
                                    'diproses'       => 'bg-blue-100 text-blue-800',
                                    'digunakan'      => 'bg-cyan-100 text-cyan-800',
                                    'selesai'        => 'bg-emerald-100 text-emerald-800',
                                    'tidak_disetujui'=> 'bg-red-100 text-red-800',
                                ];
                                $statusLabel = match($item->status) {
                                    'diproses'       => 'Disetujui',
                                    'tidak_disetujui'=> 'Tdk Disetujui',
                                    default          => ucfirst($item->status),
                                };
                            @endphp
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <span class="font-mono font-semibold text-slate-700">{{ $item->nomor_pengajuan }}</span>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-slate-600">
                                    <div>{{ $item->created_at->format('d/m/Y') }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $item->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <div class="font-medium text-slate-900">{{ $item->user->full_name ?? $item->pemohon_nama }}</div>
                                    @if($item->user && $item->user->isPriority())
                                        <span class="text-[9px] font-bold text-purple-600 bg-purple-50 px-1 rounded">PRIORITAS</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-slate-600 whitespace-nowrap">
                                    {{ $item->user->unit_kerja ?? $item->pemohon_unit ?? '-' }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-bold {{ $item->jenis === 'ambulance' ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                                        {{ ucfirst($item->jenis) }}
                                    </span>
                                    @if($item->prioritas === 'segera')
                                        <span class="ml-1 text-[9px] font-bold bg-red-100 text-red-700 px-1 rounded">CITO</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-slate-600 max-w-[120px] truncate" title="{{ $item->keperluan }}">
                                    {{ $item->keperluan ?? '-' }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-slate-700">
                                    {{ $item->tanggal->format('d/m/Y') }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-slate-600">
                                    {{ substr($item->jam, 0, 5) }}
                                    @if($item->jam_sampai)
                                        <span class="text-slate-400">-</span> {{ substr($item->jam_sampai, 0, 5) }}
                                    @else
                                        <span class="text-slate-400 text-[10px]">- selesai</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-slate-600 max-w-[140px] truncate" title="{{ $item->alamat_tujuan }}">
                                    {{ $item->alamat_tujuan ?? '-' }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-slate-700">
                                    @if($item->unit_mobil)
                                        <div class="font-medium capitalize">{{ str_replace('_', ' ', $item->unit_mobil) }}</div>
                                        @if($item->plat_nomor)
                                            <div class="text-[10px] text-slate-400 font-mono">{{ $item->plat_nomor }}</div>
                                        @endif
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-slate-600">
                                    {{ $item->driver->name ?? '-' }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-slate-600">
                                    @if($item->km_awal)
                                        <div class="text-[10px]">Awal: {{ number_format($item->km_awal) }}</div>
                                    @endif
                                    @if($item->km_akhir)
                                        <div class="text-[10px]">Akhir: {{ number_format($item->km_akhir) }}</div>
                                        <div class="text-[10px] font-semibold text-emerald-700">+{{ number_format($item->km_akhir - $item->km_awal) }} km</div>
                                    @endif
                                    @if(!$item->km_awal && !$item->km_akhir)
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-slate-600">
                                    {{ $item->jam_kedatangan ?? '-' }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusColors[$item->status] ?? 'bg-slate-100 text-slate-700' }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-center whitespace-nowrap">
                                    <a href="{{ route('admin.laporan.detail', $item) }}"
                                       class="inline-flex items-center gap-1 rounded-lg px-2 py-1 text-[10px] font-semibold text-white transition"
                                       style="background:#007774;">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="15" class="px-3 py-10 text-center">
                                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-slate-500 text-xs font-medium">Tidak ada data yang sesuai filter.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($items->hasPages())
                <div class="px-4 py-3 bg-slate-50 border-t border-slate-200">
                    {{ $items->links() }}
                </div>
            @endif
        </div>

        <div class="mt-2 text-[10px] text-slate-400">
            Menampilkan {{ $items->firstItem() ?? 0 }}–{{ $items->lastItem() ?? 0 }} dari {{ $items->total() }} data
        </div>
    </div>
</x-app-layout>
