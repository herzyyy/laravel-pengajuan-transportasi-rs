<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 pt-8">
        <h1 class="text-2xl font-bold text-slate-800">
            Daftar Pengajuan Transportasi (Admin)
        </h1>
        <p class="text-slate-500 mt-1">
            Kelola semua pengajuan mobil umum dan ambulance.
        </p>

        @if (session('success'))
            <div class="mt-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-6 bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="p-6">
                <!-- Filters -->
                <form method="GET" action="{{ route('admin.transport.index') }}" class="flex flex-wrap gap-4 mb-6">
                    <select name="jenis" class="rounded-xl border border-slate-300 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-500" onchange="this.form.submit()">
                        <option value="">Semua Jenis</option>
                        <option value="umum" @selected(request('jenis') === 'umum')>Mobil Umum</option>
                        <option value="ambulance" @selected(request('jenis') === 'ambulance')>Ambulance</option>
                    </select>

                    <select name="status" class="rounded-xl border border-slate-300 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-500" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="diajukan" @selected(request('status') === 'diajukan')>Menunggu (Diajukan)</option>
                        <option value="diproses" @selected(request('status') === 'diproses')>Diproses</option>
                        <option value="selesai" @selected(request('status') === 'selesai')>Selesai</option>
                        <option value="ditolak" @selected(request('status') === 'ditolak')>Ditolak</option>
                    </select>

                    <a href="{{ route('admin.transport.index') }}" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900 rounded-xl hover:bg-slate-100 transition">
                        Reset
                    </a>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-sm font-semibold text-slate-600">
                                <th class="py-3 px-4">Tanggal & Waktu</th>
                                <th class="py-3 px-4">Pemohon</th>
                                <th class="py-3 px-4">Jenis</th>
                                <th class="py-3 px-4">Prioritas</th>
                                <th class="py-3 px-4">Unit Mobil</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($items as $item)
                                <tr class="hover:bg-slate-50 transition text-sm text-slate-700">
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        <div class="font-medium">
                                            {{ $item->tanggal->format('d M Y') }}
                                        </div>
                                        <div class="text-xs text-slate-500">
                                            {{ $item->jam }} s/d <br>
                                            {{ $item->tanggal_sampai->format('d M Y') }} {{ $item->jam_sampai }}
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="font-medium text-slate-900">{{ $item->user->name ?? $item->pemohon_nama }}</div>
                                        <div class="text-xs text-slate-500">{{ $item->user->unit_kerja ?? $item->pemohon_unit }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                            {{ $item->jenis === 'ambulance' ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                                            {{ ucfirst($item->jenis) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($item->prioritas === 'segera')
                                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-red-600 bg-red-50 px-2.5 py-1 rounded-full">
                                                ★ Cito
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-xs font-medium text-slate-600 bg-slate-100 px-2.5 py-1 rounded-full">
                                                Biasa
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="capitalize">{{ str_replace('_', ' ', $item->unit_mobil) }}</div>
                                        @if($item->plat_nomor)
                                            <div class="text-xs font-semibold text-slate-500">{{ $item->plat_nomor }}</div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @php
                                            $colors = [
                                                'diajukan' => 'bg-amber-100 text-amber-800',
                                                'diproses' => 'bg-blue-100 text-blue-800',
                                                'selesai' => 'bg-emerald-100 text-emerald-800',
                                                'ditolak' => 'bg-red-100 text-red-800'
                                            ];
                                            $color = $colors[$item->status] ?? 'bg-slate-100 text-slate-800';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('admin.transport.show', $item) }}"
                                           class="inline-flex items-center justify-center rounded-lg bg-white border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-emerald-700 transition shadow-sm">
                                            Proses / Lihat
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-slate-500 text-sm">
                                        Belum ada data pengajuan transportasi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
