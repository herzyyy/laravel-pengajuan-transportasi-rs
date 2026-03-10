<x-app-layout>
    <div class="max-w-7xl mx-auto px-3 sm:px-4 pt-4 pb-6">
        <div class="flex items-center justify-between mb-3">
            <div>
                <h1 class="text-lg font-bold text-slate-800">Master Supir</h1>
                <p class="text-slate-500 text-xs mt-0.5">Kelola data supir/pengemudi</p>
            </div>
            <a href="{{ route('admin.drivers.create') }}"
               class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 text-white px-3 py-2 text-xs font-medium hover:bg-emerald-700 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah
            </a>
        </div>

        @if(session('success'))
            <div class="mb-3 p-2.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-xs font-medium">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-2.5 mb-3">
            <form action="{{ route('admin.drivers.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nama, telepon, atau nomor SIM..."
                           class="w-full rounded-lg border-slate-300 px-2.5 py-1.5 text-xs focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div class="w-full sm:w-32">
                    <select name="is_active" class="w-full rounded-lg border-slate-300 px-2.5 py-1.5 text-xs focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-slate-800 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-slate-900 transition">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'is_active']))
                        <a href="{{ route('admin.drivers.index') }}" class="bg-slate-100 text-slate-600 px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-slate-200 transition border border-slate-200">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr class="text-[10px] font-semibold text-slate-600 uppercase tracking-wide">
                            <th class="py-2 px-3 text-left">Nama</th>
                            <th class="py-2 px-3 text-left">Telepon</th>
                            <th class="py-2 px-3 text-left">Nomor SIM</th>
                            <th class="py-2 px-3 text-left">Status</th>
                            <th class="py-2 px-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($drivers as $driver)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-2 px-3">
                                    <div class="font-medium text-slate-900">{{ $driver->name }}</div>
                                </td>
                                <td class="py-2 px-3 text-slate-700">{{ $driver->phone ?? '-' }}</td>
                                <td class="py-2 px-3 text-slate-700">{{ $driver->license_number ?? '-' }}</td>
                                <td class="py-2 px-3">
                                    @if($driver->is_active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-800">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2 px-3 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.drivers.edit', $driver) }}"
                                           class="inline-flex items-center justify-center rounded-lg bg-white border border-slate-300 px-2.5 py-1 text-[10px] font-semibold text-slate-700 hover:bg-slate-50 hover:border-blue-500 hover:text-blue-700 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.drivers.destroy', $driver) }}" method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus supir ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center justify-center rounded-lg bg-white border border-slate-300 px-2.5 py-1 text-[10px] font-semibold text-red-700 hover:bg-red-50 hover:border-red-500 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-500 text-xs">
                                    Tidak ada data supir
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-3 py-2 bg-slate-50 border-t border-slate-200">
                {{ $drivers->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
