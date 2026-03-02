<x-app-layout>
    <div class="space-y-8">
        
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-800">
                    Riwayat Pengajuan
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Daftar pengajuan transportasi yang telah Anda buat.
                </p>
            </div>

            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center gap-2 rounded-xl 
                      bg-emerald-600 text-white px-5 py-2.5 text-sm font-medium
                      hover:bg-emerald-700 transition shadow-sm">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                </svg>
                Pengajuan Baru
            </a>
        </div>

        <!-- Filter Form -->
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4 mb-2">
            <form action="{{ route('pengajuan.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
                <div class="flex-1 w-full">
                    <label for="jenis" class="block text-sm font-medium text-slate-700 mb-1">Jenis Transportasi</label>
                    <select name="jenis" id="jenis" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        <option value="">Semua Jenis</option>
                        <option value="ambulance" {{ request('jenis') == 'ambulance' ? 'selected' : '' }}>Ambulance</option>
                        <option value="umum" {{ request('jenis') == 'umum' ? 'selected' : '' }}>Umum</option>
                    </select>
                </div>
                
                <div class="flex-1 w-full">
                    <label for="tanggal" class="block text-sm font-medium text-slate-700 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ request('tanggal') }}" 
                           class="w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                </div>

                <div class="flex gap-2 w-full sm:w-auto mt-4 sm:mt-0">
                    <button type="submit" class="flex-1 sm:flex-none bg-slate-800 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-900 transition shadow-sm">
                        Filter
                    </button>
                    @if(request()->hasAny(['jenis', 'tanggal']) && (request('jenis') != '' || request('tanggal') != ''))
                        <a href="{{ route('pengajuan.index') }}" class="flex-none bg-slate-100 text-slate-600 px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-200 transition border border-slate-200">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table Card -->
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Jenis</th>
                            <th class="px-6 py-4">Jadwal</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($items as $item)
                            <tr class="hover:bg-slate-50 transition">
                                
                                <!-- No -->
                                <td class="px-6 py-4 font-semibold text-slate-700">
                                    #{{ $item->id }}
                                </td>

                                <!-- Jenis -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full 
                                            {{ $item->jenis === 'ambulance' ? 'bg-emerald-500' : 'bg-amber-500' }}">
                                        </span>
                                        <span class="font-medium text-slate-800">
                                            {{ strtoupper($item->jenis) }}
                                        </span>
                                    </div>

                                    @if ($item->keperluan)
                                        <div class="text-xs text-slate-500 mt-1">
                                            {{ $item->keperluan }}
                                        </div>
                                    @endif
                                </td>

                                <!-- Jadwal -->
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-800">
                                        {{ $item->tanggal?->format('d/m/Y') }} 
                                        {{ substr($item->jam, 0, 5) }}
                                    </div>

                                    @if ($item->tanggal_sampai && $item->jam_sampai)
                                        <div class="text-xs text-slate-500">
                                            s/d {{ $item->tanggal_sampai?->format('d/m/Y') }} 
                                            {{ substr($item->jam_sampai, 0, 5) }}
                                        </div>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    @php
                                        $statusColor = match($item->status) {
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'approved' => 'bg-emerald-100 text-emerald-700',
                                            'rejected' => 'bg-red-100 text-red-700',
                                            default => 'bg-blue-100 text-blue-700'
                                        };
                                    @endphp

                                    <span class="inline-flex items-center px-3 py-1 
                                                 rounded-full text-xs font-medium {{ $statusColor }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>

                                <!-- Aksi -->
                                <td class="px-6 py-4">
                                    <a href="{{ route('pengajuan.success', $item) }}"
                                       class="text-sm font-medium text-emerald-600 
                                              hover:text-emerald-700 transition">
                                        Detail →
                                    </a>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-slate-500">
                                    <div class="space-y-2">
                                        <p class="font-medium text-slate-700">
                                            Belum ada pengajuan
                                        </p>
                                        <p class="text-sm">
                                            Buat pengajuan transportasi untuk mulai.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                {{ $items->links() }}
            </div>
        </div>

    </div>
</x-app-layout>