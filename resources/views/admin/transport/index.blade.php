<x-app-layout>
    <div class="max-w-7xl mx-auto px-3 sm:px-4 pt-4 sm:pt-6 pb-4">
        <h1 class="text-lg sm:text-xl font-bold text-slate-800">
            Daftar Pengajuan Transportasi
        </h1>
        <p class="text-slate-500 mt-0.5 text-xs">
            Kelola semua pengajuan mobil umum dan ambulance
        </p>

        @if (session('success'))
            <div class="mt-3 p-2.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg font-medium text-xs">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-3 sm:mt-4">
            <!-- Filters -->
            <form method="GET" action="{{ route('admin.transport.index') }}" class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-2.5 mb-3">
                <div class="flex flex-col sm:flex-row flex-wrap gap-2">
                    <select name="jenis" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs focus:ring-2 focus:ring-emerald-500" onchange="this.form.submit()">
                        <option value="">Semua Jenis</option>
                        <option value="umum" @selected(request('jenis') === 'umum')>Mobil Umum</option>
                        <option value="ambulance" @selected(request('jenis') === 'ambulance')>Ambulance</option>
                    </select>

                    <select name="status" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs focus:ring-2 focus:ring-emerald-500" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="diajukan" @selected(!request()->has('status') || request('status') === 'diajukan')>Menunggu (Diajukan)</option>
                        <option value="diproses" @selected(request('status') === 'diproses')>Disetujui</option>
                        <option value="digunakan" @selected(request('status') === 'digunakan')>Digunakan</option>
                        <option value="selesai" @selected(request('status') === 'selesai')>Selesai</option>
                        <option value="tidak_disetujui" @selected(request('status') === 'tidak_disetujui')>Tidak Disetujui</option>
                    </select>

                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
                           class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs focus:ring-2 focus:ring-emerald-500"
                           onchange="this.form.submit()">

                    @if(request()->hasAny(['jenis', 'status', 'tanggal']))
                        <a href="{{ route('admin.transport.index') }}" class="px-3 py-1.5 text-xs font-medium text-slate-600 hover:text-slate-900 rounded-lg hover:bg-slate-100 transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <!-- Table List (Desktop) / Card List (Mobile) -->
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-3 py-2 text-left text-[10px] font-semibold text-slate-700 uppercase tracking-wider">Pemohon</th>
                                <th class="px-3 py-2 text-left text-[10px] font-semibold text-slate-700 uppercase tracking-wider">Jenis</th>
                                <th class="px-3 py-2 text-left text-[10px] font-semibold text-slate-700 uppercase tracking-wider">Tanggal & Waktu</th>
                                <th class="px-3 py-2 text-left text-[10px] font-semibold text-slate-700 uppercase tracking-wider">Kendaraan</th>
                                <th class="px-3 py-2 text-left text-[10px] font-semibold text-slate-700 uppercase tracking-wider">Tujuan</th>
                                <th class="px-3 py-2 text-left text-[10px] font-semibold text-slate-700 uppercase tracking-wider">Status</th>
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-slate-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse($items as $item)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-3 py-2">
                                        <div class="font-semibold text-xs text-slate-900">{{ $item->user->full_name ?? $item->pemohon_nama }}</div>
                                        <div class="text-[10px] text-slate-500">{{ $item->user->unit_kerja ?? $item->pemohon_unit }}</div>
                                    </td>
                                    <td class="px-3 py-2">
                                        <div class="flex items-center gap-1">
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-bold {{ $item->jenis === 'ambulance' ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                                                {{ ucfirst($item->jenis) }}
                                            </span>
                                            @if($item->prioritas === 'segera')
                                                <span class="inline-flex items-center px-1 py-0.5 rounded text-[9px] font-bold bg-red-100 text-red-700">CITO</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-3 py-2">
                                        <div class="text-xs text-slate-700 font-medium whitespace-nowrap">{{ $item->tanggal->format('d/m/Y') }}</div>
                                        <div class="text-[10px] text-slate-500 whitespace-nowrap">{{ substr($item->jam, 0, 5) }} - {{ substr($item->jam_sampai, 0, 5) }}</div>
                                    </td>
                                    <td class="px-3 py-2">
                                        @if($item->unit_mobil)
                                            <div class="text-xs text-slate-700 font-medium capitalize">{{ str_replace('_', ' ', $item->unit_mobil) }}</div>
                                            @if($item->plat_nomor)
                                                <div class="text-[10px] text-slate-500 font-mono">{{ $item->plat_nomor }}</div>
                                            @endif
                                        @else
                                            <span class="text-[10px] text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        @if($item->alamat_tujuan)
                                            <div class="text-xs text-slate-600 line-clamp-2 max-w-xs">{{ $item->alamat_tujuan }}</div>
                                        @else
                                            <span class="text-[10px] text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        @php
                                            $colors = ['diajukan' => 'bg-amber-100 text-amber-800', 'diproses' => 'bg-blue-100 text-blue-800', 'digunakan' => 'bg-cyan-100 text-cyan-800', 'selesai' => 'bg-emerald-100 text-emerald-800', 'tidak_disetujui' => 'bg-red-100 text-red-800'];
                                            $color = $colors[$item->status] ?? 'bg-slate-100 text-slate-800';
                                            $label = match($item->status) {
                                                'diproses' => 'Disetujui',
                                                'digunakan' => 'Digunakan',
                                                default => ucfirst($item->status)
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $color }} whitespace-nowrap">
                                            {{ $label }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <a href="{{ route('admin.transport.show', $item) }}" class="inline-flex items-center gap-1 rounded-lg bg-emerald-600 px-2.5 py-1 text-[10px] font-semibold text-white hover:bg-emerald-700 transition whitespace-nowrap">
                                            <svg class="w-3 h-3" fill="none" stroke="white" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            <span class="text-white font-semibold">Detail</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-3 py-8 text-center">
                                        <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="text-slate-500 text-xs font-medium">Belum ada data pengajuan transportasi.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden divide-y divide-slate-200">
                    @forelse($items as $item)
                        <div class="p-4 hover:bg-slate-50 transition">
                            <!-- Header -->
                            <div class="flex items-start justify-between gap-3 mb-3">
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-sm text-slate-900 truncate">{{ $item->user->full_name ?? $item->pemohon_nama }}</div>
                                    <div class="text-xs text-slate-500 truncate">{{ $item->user->unit_kerja ?? $item->pemohon_unit }}</div>
                                </div>
                                @php
                                    $colors = ['diajukan' => 'bg-amber-100 text-amber-800', 'diproses' => 'bg-blue-100 text-blue-800', 'digunakan' => 'bg-cyan-100 text-cyan-800', 'selesai' => 'bg-emerald-100 text-emerald-800', 'tidak_disetujui' => 'bg-red-100 text-red-800'];
                                    $color = $colors[$item->status] ?? 'bg-slate-100 text-slate-800';
                                    $label = match($item->status) {
                                        'diproses' => 'Disetujui',
                                        'digunakan' => 'Digunakan',
                                        'tidak_disetujui' => 'Tidak Disetujui',
                                        default => ucfirst($item->status)
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold {{ $color }} whitespace-nowrap">
                                    {{ $label }}
                                </span>
                            </div>

                            <!-- Badges -->
                            <div class="flex items-center gap-2 mb-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $item->jenis === 'ambulance' ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                                    {{ ucfirst($item->jenis) }}
                                </span>
                                @if($item->prioritas === 'segera')
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-red-100 text-red-700">CITO</span>
                                @endif
                            </div>

                            <!-- Details -->
                            <div class="space-y-2 text-xs mb-3">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-slate-700 font-medium">{{ $item->tanggal->format('d M Y') }}</span>
                                    <span class="text-slate-500">{{ $item->jam }} - {{ $item->jam_sampai }}</span>
                                </div>

                                @if($item->unit_mobil)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                        <span class="text-slate-700 capitalize">{{ str_replace('_', ' ', $item->unit_mobil) }}</span>
                                        @if($item->plat_nomor)
                                            <span class="text-slate-500 font-mono text-[10px]">({{ $item->plat_nomor }})</span>
                                        @endif
                                    </div>
                                @endif

                                @if($item->alamat_tujuan)
                                    <div class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-slate-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span class="text-slate-600 line-clamp-2 flex-1">{{ $item->alamat_tujuan }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Action Button -->
                            <a href="{{ route('admin.transport.show', $item) }}" class="block w-full text-center rounded-lg bg-emerald-600 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-700 transition">
                                Lihat Detail
                            </a>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-slate-500 text-sm font-medium">Belum ada data pengajuan transportasi.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
