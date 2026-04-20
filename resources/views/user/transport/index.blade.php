<x-app-layout>
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Riwayat Pengajuan
                </h1>
                <p class="mt-1 text-sm text-slate-600">
                    Daftar pengajuan transportasi yang telah Anda buat
                </p>
            </div>

            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg 
                      bg-emerald-600 text-white 
                      px-4 py-2.5 text-sm font-semibold hover:shadow-lg transition">
                <svg class="w-4 h-4" fill="white" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-white font-semibold">Pengajuan Baru</span>
            </a>
        </div>

        <!-- Filter Form -->
        <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm overflow-hidden">
            <form action="{{ route('pengajuan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3 items-end">
                <div class="w-full min-w-0">
                    <label for="jenis" class="block text-xs font-semibold text-slate-700 mb-1.5">Jenis</label>
                    <select name="jenis" id="jenis" class="w-full rounded-lg border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">Semua</option>
                        <option value="ambulance" {{ request('jenis') == 'ambulance' ? 'selected' : '' }}>Ambulance</option>
                        <option value="umum" {{ request('jenis') == 'umum' ? 'selected' : '' }}>Umum</option>
                    </select>
                </div>

                <div class="flex-1 w-full">
                    <label for="status" class="block text-xs font-semibold text-slate-700 mb-1.5">Status</label>
                    <select name="status" id="status" class="w-full rounded-lg border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">Semua</option>
                        <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Disetujui</option>
                        <option value="digunakan" {{ request('status') == 'digunakan' ? 'selected' : '' }}>Digunakan</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="tidak_disetujui" {{ request('status') == 'tidak_disetujui' ? 'selected' : '' }}>Tidak Disetujui</option>

                    </select>
                </div>
                
                <div class="flex-1 w-full">
                    <label for="tanggal" class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ request('tanggal') }}" 
                           class="w-full rounded-lg border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <div class="flex gap-2 w-full sm:col-span-2 xl:col-span-1">
                    <button type="submit" class="flex-1 sm:flex-none bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition">
                        Filter
                    </button>
                    @if(request()->hasAny(['jenis', 'status', 'tanggal']) && (request('jenis') != '' || request('status') != '' || request('tanggal') != ''))
                        <a href="{{ route('pengajuan.index') }}" class="flex-none bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-lg text-sm font-medium transition border border-slate-200">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table Card (Desktop) / Card List (Mobile) -->
        <div class="bg-white rounded-lg border border-slate-200 shadow-sm">
            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full min-w-[680px] table-fixed text-xs">
                    
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr class="text-left text-[10px] font-semibold uppercase tracking-wide text-slate-600">
                            <th class="w-16 px-2 py-2">ID</th>
                            <th class="w-1/3 px-2 py-2">Jenis & Keperluan</th>
                            <th class="w-1/3 px-2 py-2">Jadwal</th>
                            <th class="w-20 px-2 py-2">Status</th>
                            <th class="w-16 px-2 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($items as $item)
                            <tr class="hover:bg-slate-50 transition">
                                
                                <!-- ID -->
                                <td class="px-2 py-2">
                                    <span class="font-mono text-[11px] font-semibold text-slate-700 bg-slate-100 px-2 py-1 rounded">
                                        {{ $item->nomor_pengajuan }}
                                    </span>
                                </td>

                                <!-- Jenis -->
                                <td class="px-2 py-2">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-2">
                                            @if($item->jenis === 'ambulance')
                                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Ambulance
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3z"></path>
                                                    </svg>
                                                    Umum
                                                </span>
                                            @endif

                                            @if($item->prioritas === 'segera')
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-red-100 text-red-700 border border-red-300">
                                                    ⚡ CITO
                                                </span>
                                            @endif
                                        </div>

                                        @if ($item->keperluan)
                                            <div class="text-xs text-slate-600 font-medium truncate" title="{{ ucfirst($item->keperluan) }}">
                                                {{ ucfirst($item->keperluan) }}
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Jadwal -->
                                <td class="px-2 py-2">
                                    <div class="flex flex-col gap-0.5">
                                        <div class="flex items-center gap-1 text-slate-900 font-medium">
                                            <svg class="w-3 h-3 text-slate-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-[10px] truncate">{{ $item->tanggal?->format('d M Y') }} | {{ substr($item->jam, 0, 5) }}</span>
                                        </div>

                                        @if ($item->tanggal_sampai && $item->jam_sampai)
                                            <div class="text-[9px] text-slate-500 truncate">s/d {{ $item->tanggal_sampai?->format('d M Y') }} | {{ substr($item->jam_sampai, 0, 5) }}</div>
                                        @endif

                                        <div class="text-[9px] text-slate-400 mt-0.5">Dibuat: {{ $item->created_at->format('d M Y, H:i') }}</div>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-2 py-2">
                                    @php
                                        $statusConfig = match($item->status) {
                                            'diajukan' => [
                                                'bg' => 'bg-amber-50',
                                                'text' => 'text-amber-700',
                                                'border' => 'border-amber-200',
                                                'label' => 'Diajukan',
                                                'icon' => '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>'
                                            ],
                                            'diproses' => [
                                                'bg' => 'bg-blue-50',
                                                'text' => 'text-blue-700',
                                                'border' => 'border-blue-200',
                                                'label' => 'Disetujui',
                                                'icon' => '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 16a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 16h-8z"/></svg>'
                                            ],
                                            'digunakan' => [
                                                'bg' => 'bg-cyan-50',
                                                'text' => 'text-cyan-700',
                                                'border' => 'border-cyan-200',
                                                'label' => 'Digunakan',
                                                'icon' => '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/><path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3z"/></svg>'
                                            ],
                                            'selesai' => [
                                                'bg' => 'bg-emerald-50',
                                                'text' => 'text-emerald-700',
                                                'border' => 'border-emerald-200',
                                                'label' => 'Selesai',
                                                'icon' => '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>'
                                            ],
                                            'tidak_disetujui' => [
                                                'bg' => 'bg-red-50',
                                                'text' => 'text-red-700',
                                                'border' => 'border-red-200',
                                                'label' => 'Tidak Disetujui',
                                                'icon' => '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>'
                                            ],
                                            default => [
                                                'bg' => 'bg-slate-50',
                                                'text' => 'text-slate-700',
                                                'border' => 'border-slate-200',
                                                'label' => ucfirst($item->status),
                                                'icon' => '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/></svg>'
                                            ]
                                        };
                                    @endphp

                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 
                                                 rounded-full text-[9px] font-semibold border
                                                 {{ $statusConfig['bg'] }} 
                                                 {{ $statusConfig['text'] }}
                                                 {{ $statusConfig['border'] }}">
                                        {!! $statusConfig['icon'] !!}
                                        {{ $statusConfig['label'] }}
                                    </span>
                                </td>

                                <!-- Aksi -->
                                <td class="px-2 py-2 text-center">
                                    <a href="{{ route('pengajuan.success', $item) }}"
                                       class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600 
                                              hover:text-emerald-700 hover:underline transition">
                                        Detail
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="bg-slate-100 rounded-full p-4">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-900 mb-1">
                                                Belum ada pengajuan
                                            </p>
                                            <p class="text-sm text-slate-600">
                                                Buat pengajuan transportasi untuk memulai
                                            </p>
                                        </div>
                                        <a href="{{ route('dashboard') }}" class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg transition">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            Buat Pengajuan
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="block md:hidden divide-y divide-slate-200 max-w-full overflow-hidden">
                @forelse ($items as $item)
                    <div class="p-3 sm:p-4 hover:bg-slate-50 transition w-full max-w-full overflow-hidden box-border min-w-0">
                        <!-- Header with ID and Status -->
                        <div class="flex flex-wrap items-start justify-between gap-3 mb-3 min-w-0">
                            <span class="font-mono text-xs font-semibold text-slate-700 bg-slate-100 px-2 py-1 rounded">
                                {{ $item->nomor_pengajuan }}
                            </span>
                            @php
                                $statusConfig = match($item->status) {
                                    'diajukan' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'label' => 'Diajukan'],
                                    'diproses' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'label' => 'Disetujui'],
                                    'digunakan' => ['bg' => 'bg-cyan-50', 'text' => 'text-cyan-700', 'border' => 'border-cyan-200', 'label' => 'Digunakan'],
                                    'selesai' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'label' => 'Selesai'],
                                    'tidak_disetujui' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'label' => 'Tidak Disetujui'],
                                    default => ['bg' => 'bg-slate-50', 'text' => 'text-slate-700', 'border' => 'border-slate-200', 'label' => ucfirst($item->status)]
                                };
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold border {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }}">
                                {{ $statusConfig['label'] }}
                            </span>
                        </div>

                        <!-- Jenis & Prioritas -->
                        <div class="flex flex-wrap items-center gap-2 mb-3 min-w-0">
                            @if($item->jenis === 'ambulance')
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-semibold rounded-full flex-shrink-0">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
                                    </svg>
                                    Ambulance
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-amber-100 text-amber-700 text-[10px] font-semibold rounded-full">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3z"></path>
                                    </svg>
                                    Umum
                                </span>
                            @endif
                            
                            @if($item->prioritas === 'segera')
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-red-100 text-red-700 border border-red-300">
                                    ⚡ CITO
                                </span>
                            @endif
                        </div>

                        <!-- Keperluan -->
                        @if ($item->keperluan)
                            <div class="text-xs text-slate-900 font-medium mb-3 break-words overflow-wrap-anywhere max-w-full">
                                {{ ucfirst($item->keperluan) }}
                            </div>
                        @endif

                        <!-- Jadwal -->
                        <div class="space-y-1.5 mb-3 text-xs">
                            <div class="flex items-center gap-2 text-slate-700">
                                <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">{{ $item->tanggal?->format('d/m/Y') }}</span>
                                <span class="text-slate-500">{{ substr($item->jam, 0, 5) }}</span>
                            </div>
                            @if ($item->tanggal_sampai && $item->jam_sampai)
                                <div class="text-[10px] text-slate-500 pl-6">
                                    s/d {{ $item->tanggal_sampai?->format('d/m/Y') }} {{ substr($item->jam_sampai, 0, 5) }}
                                </div>
                            @endif
                            <div class="text-[10px] text-slate-400 pl-6">Dibuat: {{ $item->created_at->format('d/m/Y, H:i') }}</div>
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('pengajuan.success', $item) }}" class="block w-full max-w-full text-center rounded-lg bg-emerald-600 border border-emerald-600 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-700 transition">
                            Lihat Detail
                        </a>
                    </div>

                @empty
                    <div class="p-8 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="bg-slate-100 rounded-full p-4">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900 mb-1">Belum ada pengajuan</p>
                                <p class="text-sm text-slate-600">Buat pengajuan transportasi untuk memulai</p>
                            </div>
                            <a href="{{ route('dashboard') }}" class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                                Buat Pengajuan
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($items->hasPages())
            <div class="px-4 py-3 bg-slate-50 border-t border-slate-200">
                {{ $items->links() }}
            </div>
            @endif
        </div>

    </div>
</x-app-layout>
