<x-app-layout title="Manajemen Supir — SIPETRANS">
    <div class="container-fluid px-3 pt-4 pb-6">

        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h1 class="fw-bold text-slate-800 mb-0" style="font-size:1.1rem;">Master Supir</h1>
                <p class="text-slate-500 text-xs mt-1 mb-0">Kelola data supir/pengemudi</p>
            </div>
            <a href="{{ route('admin.drivers.create') }}"
               class="btn btn-sp-primary d-inline-flex align-items-center gap-2 text-xs">
                <svg class="w-3.5 h-3.5" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="fw-600">Tambah</span>
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-sp-success border border-emerald-200 rounded px-3 py-2 mb-3 text-xs fw-500">
                {{ session('success') }}
            </div>
        @endif

        <!-- Desktop Table -->
        <form method="GET" action="{{ route('admin.drivers.index') }}" id="drivers-filter-form">
        <div class="d-none d-md-block sp-card overflow-hidden mb-3">
            <div class="overflow-x-auto">
                <table class="sp-table w-100 text-xs">
                    <thead>
                        {{-- Filter row --}}
                        <tr class="bg-slate-50 border-bottom border-slate-200">
                            <th class="py-2 px-3">
                                <input type="text" name="nama" value="{{ request('nama') }}" placeholder="Cari nama..."
                                       class="form-control form-control-sm text-xxs border-slate-300">
                            </th>
                            <th class="py-2 px-3">
                                <input type="text" name="telepon" value="{{ request('telepon') }}" placeholder="Cari telepon..."
                                       class="form-control form-control-sm text-xxs border-slate-300">
                            </th>
                            <th class="py-2 px-3">
                                <input type="text" name="sim" value="{{ request('sim') }}" placeholder="Cari SIM..."
                                       class="form-control form-control-sm text-xxs border-slate-300">
                            </th>
                            <th class="py-2 px-3">
                                <select name="is_active" class="form-select form-select-sm text-xxs border-slate-300">
                                    <option value="">Semua</option>
                                    <option value="1" @selected(request('is_active') === '1')>Aktif</option>
                                    <option value="0" @selected(request('is_active') === '0')>Nonaktif</option>
                                </select>
                            </th>
                            <th class="py-2 px-3"></th>
                        </tr>
                        {{-- Header row --}}
                        <tr class="text-start text-xxs fw-600 text-white text-uppercase" style="background: linear-gradient(to right, #007774, #009e9a);">
                            <th class="py-2 px-3">Nama</th>
                            <th class="py-2 px-3">Telepon</th>
                            <th class="py-2 px-3">Nomor SIM</th>
                            <th class="py-2 px-3">Status</th>
                            <th class="py-2 px-3 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($drivers as $driver)
                            <tr>
                                <td class="py-2 px-3">
                                    <div class="fw-600 text-slate-900">{{ $driver->name }}</div>
                                </td>
                                <td class="py-2 px-3 text-slate-700">{{ $driver->phone ?? '-' }}</td>
                                <td class="py-2 px-3 text-slate-700 font-monospace">{{ $driver->license_number ?? '-' }}</td>
                                <td class="py-2 px-3">
                                    @if($driver->is_active)
                                        <span class="badge-emerald">Aktif</span>
                                    @else
                                        <span class="badge-slate">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="py-2 px-3 text-end">
                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                        <a href="{{ route('admin.drivers.edit', $driver) }}"
                                            class="btn btn-sp-outline text-xxs fw-600 px-2 py-1">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.drivers.destroy', $driver) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus supir ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm border border-slate-300 text-xxs fw-600 text-danger bg-white px-2 py-1">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-5 text-center text-slate-500 text-xs">Tidak ada data supir</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-3 py-2 bg-slate-50 border-top border-slate-200">
                {{ $drivers->links() }}
            </div>
        </div>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('drivers-filter-form');
                if (!form) return;
                let timer;

                function submitClean() {
                    clearTimeout(timer);
                    timer = setTimeout(() => {
                        form.querySelectorAll('input, select').forEach(el => {
                            if (el.value === '') el.disabled = true;
                        });
                        form.submit();
                    }, 400);
                }

                form.querySelectorAll('input[type="text"]').forEach(el => {
                    el.addEventListener('input', submitClean);
                });
                form.querySelectorAll('select').forEach(el => {
                    el.addEventListener('change', () => {
                        clearTimeout(timer);
                        form.querySelectorAll('input, select').forEach(e => {
                            if (e.value === '') e.disabled = true;
                        });
                        form.submit();
                    });
                });
            });
        </script>

        <!-- Mobile Cards -->
        <div class="d-md-none">
            @forelse($drivers as $driver)
                <div class="sp-card p-3 mb-2">
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <div class="flex-grow-1">
                            <h3 class="fw-600 text-slate-900 text-sm mb-0">{{ $driver->name }}</h3>
                            <p class="text-xs text-slate-600 mt-1 mb-0">{{ $driver->phone ?? '-' }}</p>
                            <p class="text-xs text-slate-500 mt-1 mb-0">SIM: {{ $driver->license_number ?? '-' }}</p>
                        </div>
                        @if($driver->is_active)
                            <span class="badge-emerald">Aktif</span>
                        @else
                            <span class="badge-slate">Nonaktif</span>
                        @endif
                    </div>
                    <div class="d-flex align-items-center gap-2 pt-2 border-top border-slate-100">
                        <a href="{{ route('admin.drivers.edit', $driver) }}"
                            class="flex-fill btn btn-sp-outline text-xs fw-600 text-center">
                            Edit
                        </a>
                        <form action="{{ route('admin.drivers.destroy', $driver) }}" method="POST" class="flex-fill"
                              onsubmit="return confirm('Yakin ingin menghapus supir ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn w-100 border border-slate-300 text-xs fw-600 text-danger bg-white">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="sp-card p-5 text-center text-slate-500 text-xs">
                    Tidak ada data supir
                </div>
            @endforelse
            @if($drivers->hasPages())
                <div class="pt-2">{{ $drivers->links() }}</div>
            @endif
        </div>

    </div>
</x-app-layout>
