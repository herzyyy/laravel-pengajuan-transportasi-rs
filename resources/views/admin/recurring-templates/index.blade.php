<x-app-layout title="Master Pengajuan Berulang — SIPETRANS">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 pt-4 sm:pt-6 pb-4">
        <h1 class="text-lg sm:text-xl font-bold text-slate-800">
            Master Pengajuan Berulang
        </h1>
        <p class="text-slate-500 mt-0.5 text-xs">
            Kelola template jadwal pengajuan transportasi otomatis
        </p>

        @if (session('success'))
            <div class="mt-3 p-2.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg font-medium text-xs">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-3 sm:mt-4">
            <!-- Filters -->
            <form method="GET" action="{{ route('admin.recurring-templates.index') }}" class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-2.5 mb-3">
                <div class="flex flex-col sm:flex-row flex-wrap gap-2">
                    <select name="jenis" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs focus:ring-2 focus:ring-emerald-500" onchange="this.form.submit()">
                        <option value="">Semua Jenis</option>
                        <option value="umum" @selected(request('jenis') === 'umum')>Mobil Umum</option>
                        <option value="ambulance" @selected(request('jenis') === 'ambulance')>Ambulance</option>
                    </select>

                    <select name="status" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs focus:ring-2 focus:ring-emerald-500" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected(request('status') === 'nonaktif')>Nonaktif</option>
                    </select>

                    @if(request()->hasAny(['jenis', 'status']))
                        <a href="{{ route('admin.recurring-templates.index') }}" class="px-3 py-1.5 text-xs font-medium text-slate-600 hover:text-slate-900 rounded-lg hover:bg-slate-100 transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-[10px] font-semibold text-white uppercase tracking-wider" style="background: linear-gradient(to right, #007774, #009e9a);">
                                <th class="px-3 py-3">Pemohon</th>
                                <th class="px-3 py-3">Jenis/Keperluan</th>
                                <th class="px-3 py-3">Jam Pengajuan</th>
                                <th class="px-3 py-3">Periode</th>
                                <th class="px-3 py-3">Hari Aktif</th>
                                <th class="px-3 py-3">Status</th>
                                <th class="px-3 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($items as $item)
                                <tr class="hover:bg-teal-50/40 transition-colors">
                                    <td class="px-3 py-2.5">
                                        <div class="font-semibold text-xs text-slate-900">{{ $item->pemohon_nama }}</div>
                                        <div class="text-[10px] text-slate-500">{{ $item->pemohon_unit }}</div>
                                    </td>
                                    <td class="px-3 py-2.5">
                                        <div class="flex items-center gap-1 mb-1">
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-bold {{ $item->jenis === 'ambulance' ? 'bg-rose-100 text-rose-700 border border-rose-200' : 'bg-emerald-100 text-emerald-700 border border-emerald-200' }}">
                                                {{ ucfirst($item->jenis) }}
                                            </span>
                                            @if($item->prioritas === 'segera')
                                                <span class="inline-flex items-center px-1 py-0.5 rounded text-[9px] font-bold bg-red-100 text-red-700 border border-red-200">CITO</span>
                                            @endif
                                        </div>
                                        <div class="text-[10px] font-medium">{{ $item->keperluan }}</div>
                                    </td>
                                    <td class="px-3 py-2.5">
                                        <div class="text-xs text-slate-700 font-medium whitespace-nowrap">{{ substr($item->jam, 0, 5) }} {{ $item->jam_sampai ? '- '.substr($item->jam_sampai,0,5) : '- Selesai' }}</div>
                                    </td>
                                    <td class="px-3 py-2.5">
                                        <div class="text-[10px] text-slate-700 font-medium whitespace-nowrap">Sejak: {{ $item->start_date->format('d/m/Y') }}</div>
                                        <div class="text-[10px] text-slate-500 font-medium whitespace-nowrap">Terus Menerus</div>
                                    </td>
                                    <td class="px-3 py-2.5">
                                        @php
                                            $dayNames = [1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu'];
                                            $activeDays = array_map(fn($d) => $dayNames[$d] ?? '', $item->hari ?? []);
                                        @endphp
                                        <div class="flex flex-wrap gap-1 max-w-[150px]">
                                            @foreach($activeDays as $day)
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                                    {{ $day }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-3 py-2.5">
                                        @if($item->is_active)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border bg-emerald-100 text-emerald-800 border-emerald-200">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border bg-slate-100 text-slate-600 border-slate-200">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2.5 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <a href="{{ route('admin.recurring-templates.edit', $item) }}" class="inline-flex items-center justify-center w-7 h-7 rounded bg-amber-50 text-amber-600 hover:bg-amber-100 transition ring-1 ring-amber-200" title="Edit">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.recurring-templates.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus template ini? Pengajuan yang sudah terbuat tidak akan terhapus.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center w-7 h-7 rounded bg-red-50 text-red-600 hover:bg-red-100 transition ring-1 ring-red-200" title="Hapus">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-3 py-10 text-center">
                                        <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        <p class="text-slate-500 text-xs font-medium">Belum ada data template pengajuan berulang.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
