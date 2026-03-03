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

        <div class="mt-6">
            <!-- Filters -->
            <form method="GET" action="{{ route('admin.transport.index') }}" class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-4 mb-4">
                <div class="flex flex-wrap gap-3">
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
                </div>
            </form>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                @forelse($items as $item)
                    <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 hover:shadow-md transition overflow-hidden">
                        <!-- Card Header -->
                        <div class="px-4 py-3 border-b border-slate-100 bg-slate-50">
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <div class="flex items-center gap-1.5">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold
                                        {{ $item->jenis === 'ambulance' ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                                        {{ ucfirst($item->jenis) }}
                                    </span>
                                    @if($item->prioritas === 'segera')
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-red-100 text-red-700">
                                            CITO
                                        </span>
                                    @endif
                                </div>
                                @php
                                    $colors = [
                                        'diajukan' => 'bg-amber-100 text-amber-800',
                                        'diproses' => 'bg-blue-100 text-blue-800',
                                        'selesai' => 'bg-emerald-100 text-emerald-800',
                                        'ditolak' => 'bg-red-100 text-red-800'
                                    ];
                                    $color = $colors[$item->status] ?? 'bg-slate-100 text-slate-800';
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $color }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </div>
                            <div class="font-semibold text-sm text-slate-900 truncate">
                                {{ $item->user->name ?? $item->pemohon_nama }}
                            </div>
                            <div class="text-[11px] text-slate-500 truncate">
                                {{ $item->user->unit_kerja ?? $item->pemohon_unit }}
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="px-4 py-3 space-y-2 text-xs">
                            <div class="flex items-start gap-2">
                                <svg class="w-3.5 h-3.5 text-slate-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div class="flex-1 min-w-0">
                                    <div class="text-slate-700 font-medium">
                                        {{ $item->tanggal->format('d M Y') }}, {{ $item->jam }}
                                    </div>
                                    <div class="text-[10px] text-slate-500">
                                        s/d {{ $item->tanggal_sampai->format('d M Y') }} {{ $item->jam_sampai }}
                                    </div>
                                </div>
                            </div>

                            @if($item->unit_mobil)
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    <div class="flex-1 min-w-0 truncate">
                                        <span class="text-slate-700 font-medium capitalize">
                                            {{ str_replace('_', ' ', $item->unit_mobil) }}
                                        </span>
                                        @if($item->plat_nomor)
                                            <span class="text-slate-500 font-mono ml-1">
                                                ({{ $item->plat_nomor }})
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($item->alamat_tujuan)
                                <div class="flex items-start gap-2">
                                    <svg class="w-3.5 h-3.5 text-slate-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <div class="flex-1 min-w-0 text-slate-600 line-clamp-2">
                                        {{ $item->alamat_tujuan }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Card Footer -->
                        <div class="px-4 py-2.5 bg-slate-50 border-t border-slate-100">
                            <a href="{{ route('admin.transport.show', $item) }}"
                               class="block w-full text-center rounded-lg bg-emerald-600 px-3 py-1.5 text-[11px] font-semibold text-white hover:bg-emerald-700 transition">
                                Proses / Lihat Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-8 text-center">
                            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-slate-500 text-sm font-medium">Belum ada data pengajuan transportasi.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
