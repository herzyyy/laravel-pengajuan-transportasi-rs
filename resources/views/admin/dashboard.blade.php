<x-app-layout>
    <div class="max-w-7xl mx-auto px-3 sm:px-4 pt-4 pb-6">
        <h1 class="text-lg font-bold text-slate-800">
            Dashboard Admin
        </h1>
        <p class="text-slate-500 text-xs mt-0.5">
            Ringkasan pengajuan berdasarkan status
        </p>

        <!-- Summary Cards -->
        <div class="mt-3 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-7 gap-2">
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 px-3 py-2.5">
                <div class="text-[10px] font-medium text-slate-500 uppercase tracking-wide">Total</div>
                <div class="mt-1 text-2xl font-bold text-slate-900">
                    {{ $summary['total'] }}
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm ring-1 ring-amber-200 px-3 py-2.5">
                <div class="text-[10px] font-medium text-amber-700 uppercase tracking-wide">Diajukan</div>
                <div class="mt-1 text-2xl font-bold text-amber-900">
                    {{ $summary['diajukan'] }}
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm ring-1 ring-blue-200 px-3 py-2.5">
                <div class="text-[10px] font-medium text-blue-700 uppercase tracking-wide">Disetujui</div>
                <div class="mt-1 text-2xl font-bold text-blue-900">
                    {{ $summary['diproses'] }}
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm ring-1 ring-cyan-200 px-3 py-2.5">
                <div class="text-[10px] font-medium text-cyan-700 uppercase tracking-wide">Digunakan</div>
                <div class="mt-1 text-2xl font-bold text-cyan-900">
                    {{ $summary['digunakan'] ?? 0 }}
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm ring-1 ring-emerald-200 px-3 py-2.5">
                <div class="text-[10px] font-medium text-emerald-700 uppercase tracking-wide">Selesai</div>
                <div class="mt-1 text-2xl font-bold text-emerald-900">
                    {{ $summary['selesai'] }}
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm ring-1 ring-red-200 px-3 py-2.5">
                <div class="text-[10px] font-medium text-red-700 uppercase tracking-wide">Ditolak</div>
                <div class="mt-1 text-2xl font-bold text-red-900">
                    {{ $summary['ditolak'] }}
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm ring-1 ring-orange-200 px-3 py-2.5">
                <div class="text-[10px] font-medium text-orange-700 uppercase tracking-wide">Kadaluarsa</div>
                <div class="mt-1 text-2xl font-bold text-orange-900">
                    {{ $summary['kadaluarsa'] }}
                </div>
            </div>
        </div>

        <!-- Latest Requests Table -->
        <div class="mt-4">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-sm font-semibold text-slate-800">
                    Pengajuan Terbaru
                </h2>
                <a href="{{ route('admin.transport.index') }}"
                   class="inline-flex items-center gap-1 text-xs font-medium text-emerald-700 hover:text-emerald-900 transition">
                    Lihat semua
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr class="text-[10px] font-semibold text-slate-600 uppercase tracking-wide">
                                <th class="py-2 px-3">Tanggal</th>
                                <th class="py-2 px-3">Pemohon</th>
                                <th class="py-2 px-3">Jenis</th>
                                <th class="py-2 px-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($latest as $item)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-2 px-3 text-slate-700 whitespace-nowrap">
                                        {{ $item->tanggal->format('d/m/Y') }}
                                    </td>
                                    <td class="py-2 px-3">
                                        <div class="font-medium text-slate-900">
                                            {{ $item->user->full_name ?? $item->pemohon_nama }}
                                        </div>
                                        <div class="text-[10px] text-slate-500">
                                            {{ $item->user->unit_kerja ?? $item->pemohon_unit }}
                                        </div>
                                    </td>
                                    <td class="py-2 px-3 text-slate-700">
                                        <span class="font-medium">{{ ucfirst($item->jenis) }}</span>
                                        @if($item->prioritas === 'segera')
                                            <span class="ml-1 inline-flex items-center px-1 py-0.5 rounded text-[9px] font-bold bg-red-100 text-red-700">
                                                CITO
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-3">
                                        @php
                                            $statusConfig = match($item->status) {
                                                'diajukan' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'label' => 'Diajukan'],
                                                'diproses' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Disetujui'],
                                                'digunakan' => ['bg' => 'bg-cyan-100', 'text' => 'text-cyan-800', 'label' => 'Digunakan'],
                                                'selesai' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'label' => 'Selesai'],
                                                'ditolak' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Ditolak'],
                                                'kadaluarsa' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800', 'label' => 'Kadaluarsa'],
                                                default => ['bg' => 'bg-slate-100', 'text' => 'text-slate-800', 'label' => ucfirst($item->status)]
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                            {{ $statusConfig['label'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-slate-500 text-xs">
                                        <div class="flex flex-col items-center gap-2">
                                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
