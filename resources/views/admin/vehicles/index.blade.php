<x-app-layout>
    <div class="max-w-7xl mx-auto px-3 sm:px-4 pt-4 pb-6"
         x-data="{
            showCreate: {{ $errors->any() && !session('edit_id') ? 'true' : 'false' }},
            showEdit: {{ session('edit_id') ? 'true' : 'false' }},
            editId: '{{ session('edit_id', '') }}',
            editName: '{{ old('name', session('edit_name', '')) }}',
            editType: '{{ old('type', session('edit_type', 'umum')) }}',
            editPlateNumber: '{{ old('plate_number', session('edit_plate_number', '')) }}',
            editBrand: '{{ old('brand', session('edit_brand', '')) }}',
            editModel: '{{ old('model', session('edit_model', '')) }}',
            editIsActive: '{{ old('is_active', session('edit_is_active', '1')) }}',
            editNotes: '{{ old('notes', session('edit_notes', '')) }}',
            openEdit(id, name, type, plateNumber, brand, model, isActive, notes) {
                this.editId = id;
                this.editName = name;
                this.editType = type;
                this.editPlateNumber = plateNumber;
                this.editBrand = brand;
                this.editModel = model;
                this.editIsActive = isActive;
                this.editNotes = notes;
                this.showEdit = true;
            }
         }">

        <div class="flex items-center justify-between mb-3">
            <div>
                <h1 class="text-lg font-bold text-slate-800">Master Kendaraan</h1>
                <p class="text-slate-500 text-xs mt-0.5">Kelola data kendaraan transportasi</p>
            </div>
            <a href="{{ route('admin.vehicles.create') }}"
               class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 text-white px-3 py-2 text-xs font-medium hover:bg-emerald-700 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="text-white font-semibold">Tambah</span>
            </a>
        </div>

        @if(session('success'))
            <div class="mb-3 p-2.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-xs font-medium">
                {{ session('success') }}
            </div>
        @endif

        <!-- Desktop Table -->
        <form method="GET" action="{{ route('admin.vehicles.index') }}" id="vehicles-filter-form">
        <div class="hidden lg:block bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        {{-- Filter row --}}
                        <tr class="bg-white border-b border-slate-100">
                            <th class="py-1.5 px-2">
                                <input type="text" name="nama" value="{{ request('nama') }}" placeholder="Cari..."
                                       class="w-full rounded border border-slate-300 px-1.5 py-1 text-[10px] font-normal focus:ring-1 focus:ring-teal-400">
                            </th>
                            <th class="py-1.5 px-2">
                                <select name="type" class="w-full rounded border border-slate-300 px-1.5 py-1 text-[10px] font-normal focus:ring-1 focus:ring-teal-400">
                                    <option value="">Semua</option>
                                    <option value="umum" @selected(request('type') === 'umum')>Umum</option>
                                    <option value="ambulance" @selected(request('type') === 'ambulance')>Ambulance</option>
                                </select>
                            </th>
                            <th class="py-1.5 px-2">
                                <input type="text" name="plat" value="{{ request('plat') }}" placeholder="Cari..."
                                       class="w-full rounded border border-slate-300 px-1.5 py-1 text-[10px] font-normal focus:ring-1 focus:ring-teal-400">
                            </th>
                            <th class="py-1.5 px-2">
                                <input type="text" name="merk" value="{{ request('merk') }}" placeholder="Cari..."
                                       class="w-full rounded border border-slate-300 px-1.5 py-1 text-[10px] font-normal focus:ring-1 focus:ring-teal-400">
                            </th>
                            <th class="py-1.5 px-2"></th>
                            <th class="py-1.5 px-2">
                                <select name="is_active" class="w-full rounded border border-slate-300 px-1.5 py-1 text-[10px] font-normal focus:ring-1 focus:ring-teal-400">
                                    <option value="">Semua</option>
                                    <option value="1" @selected(request('is_active') === '1')>Aktif</option>
                                    <option value="0" @selected(request('is_active') === '0')>Nonaktif</option>
                                </select>
                            </th>
                            <th class="py-1.5 px-2"></th>
                        </tr>
                        {{-- Header row --}}
                        <tr class="text-[10px] font-semibold text-slate-600 uppercase tracking-wide">
                            <th class="py-2 px-3 text-left">Nama Unit</th>
                            <th class="py-2 px-3 text-left">Jenis</th>
                            <th class="py-2 px-3 text-left">Plat Nomor</th>
                            <th class="py-2 px-3 text-left">Merk/Model</th>
                            <th class="py-2 px-3 text-left">KM Terkini</th>
                            <th class="py-2 px-3 text-left">Status</th>
                            <th class="py-2 px-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($vehicles as $vehicle)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-2 px-3">
                                    <div class="font-medium text-slate-900">{{ $vehicle->name }}</div>
                                </td>
                                <td class="py-2 px-3">
                                    @if($vehicle->type === 'ambulance')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-800">Ambulance</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">Umum</span>
                                    @endif
                                </td>
                                <td class="py-2 px-3 text-slate-700 font-medium">{{ $vehicle->plate_number }}</td>
                                <td class="py-2 px-3 text-slate-700">
                                    {{ $vehicle->brand ?? '-' }}
                                    @if($vehicle->model)<span class="text-slate-500">/ {{ $vehicle->model }}</span>@endif
                                </td>
                                <td class="py-2 px-3">
                                    @if($vehicle->last_km !== null)
                                        <span class="font-semibold text-slate-800">{{ number_format($vehicle->last_km, 0, ',', '.') }}</span>
                                        <span class="text-slate-400 text-[10px]"> km</span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="py-2 px-3">
                                    @if($vehicle->is_active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Aktif</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-800">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="py-2 px-3 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.vehicles.edit', $vehicle) }}"
                                            class="inline-flex items-center justify-center rounded-lg bg-white border border-slate-300 px-2.5 py-1 text-[10px] font-semibold text-slate-700 hover:bg-slate-50 hover:border-blue-500 hover:text-blue-700 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?')">
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
                                <td colspan="7" class="py-6 text-center text-slate-500 text-xs">Tidak ada data kendaraan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-3 py-2 bg-slate-50 border-t border-slate-200">
                {{ $vehicles->links() }}
            </div>
        </div>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('vehicles-filter-form');
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
        <div class="lg:hidden space-y-2">
            @forelse($vehicles as $vehicle)
                <div class="bg-white rounded-lg shadow-sm ring-1 ring-slate-200 p-3">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="font-semibold text-slate-900 text-sm">{{ $vehicle->name }}</h3>
                                @if($vehicle->type === 'ambulance')
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-red-100 text-red-800">Ambulance</span>
                                @else
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-blue-100 text-blue-800">Umum</span>
                                @endif
                            </div>
                            <p class="text-xs font-medium text-slate-700">{{ $vehicle->plate_number }}</p>
                            <p class="text-xs text-slate-600 mt-0.5">
                                {{ $vehicle->brand ?? '-' }}
                                @if($vehicle->model) / {{ $vehicle->model }}@endif
                                @if($vehicle->year) ({{ $vehicle->year }})@endif
                            </p>
                            @if($vehicle->last_km !== null)
                                <p class="text-xs text-slate-700 mt-1 font-medium">
                                    KM Terkini: <span class="font-semibold">{{ number_format($vehicle->last_km, 0, ',', '.') }} km</span>
                                </p>
                            @endif
                        </div>
                        @if($vehicle->is_active)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Aktif</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-800">Nonaktif</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 pt-2 border-t border-slate-100">
                        <a href="{{ route('admin.vehicles.edit', $vehicle) }}"
                            class="flex-1 inline-flex items-center justify-center rounded-lg bg-white border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:border-blue-500 hover:text-blue-700 transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST" class="flex-1"
                              onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center rounded-lg bg-white border border-slate-300 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50 hover:border-red-500 transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-sm ring-1 ring-slate-200 p-6 text-center text-slate-500 text-xs">
                    Tidak ada data kendaraan
                </div>
            @endforelse
            @if($vehicles->hasPages())
                <div class="pt-2">{{ $vehicles->links() }}</div>
            @endif
        </div>

        <!-- CREATE MODAL -->
        <div x-show="showCreate" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50" @click="showCreate = false"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between px-4 py-3 border-b border-slate-200">
                    <h2 class="text-sm font-bold text-slate-800">Tambah Kendaraan Baru</h2>
                    <button @click="showCreate = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('admin.vehicles.store') }}" method="POST" class="p-4 space-y-3">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Unit *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="mobil_umum_1"
                                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-400 @enderror">
                            @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis *</label>
                            <select name="type" required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('type') border-red-400 @enderror">
                                <option value="">Pilih Jenis</option>
                                <option value="umum" {{ old('type') === 'umum' ? 'selected' : '' }}>Umum</option>
                                <option value="ambulance" {{ old('type') === 'ambulance' ? 'selected' : '' }}>Ambulance</option>
                            </select>
                            @error('type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Polisi *</label>
                        <input type="text" name="plate_number" value="{{ old('plate_number') }}" required placeholder="B 1234 CD"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('plate_number') border-red-400 @enderror">
                        @error('plate_number')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Merk</label>
                            <input type="text" name="brand" value="{{ old('brand') }}" placeholder="Toyota"
                                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Model/Tipe</label>
                            <input type="text" name="model" value="{{ old('model') }}" placeholder="Avanza"
                                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Status</label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="is_active" value="1" {{ old('is_active', '1') === '1' ? 'checked' : '' }}
                                       class="w-4 h-4 text-slate-600 focus:ring-slate-500">
                                <span class="text-sm text-slate-700">Aktif</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="is_active" value="0" {{ old('is_active') === '0' ? 'checked' : '' }}
                                       class="w-4 h-4 text-slate-600 focus:ring-slate-500">
                                <span class="text-sm text-slate-700">Nonaktif</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan</label>
                        <textarea name="notes" rows="2" placeholder="Catatan tambahan tentang kendaraan"
                                  class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('notes') }}</textarea>
                    </div>
                    <div class="flex items-center gap-2 pt-3 border-t border-slate-200">
                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                            Simpan
                        </button>
                        <button type="button" @click="showCreate = false"
                                class="inline-flex items-center justify-center rounded-lg bg-white border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- EDIT MODAL -->
        <div x-show="showEdit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50" @click="showEdit = false"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between px-4 py-3 border-b border-slate-200">
                    <h2 class="text-sm font-bold text-slate-800">Edit Kendaraan</h2>
                    <button @click="showEdit = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form :action="'{{ url('admin/vehicles') }}/' + editId" method="POST" class="p-4 space-y-3">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Unit *</label>
                            <input type="text" name="name" :value="editName" required
                                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-400 @enderror">
                            @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis *</label>
                            <select name="type" x-model="editType" required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('type') border-red-400 @enderror">
                                <option value="umum">Umum</option>
                                <option value="ambulance">Ambulance</option>
                            </select>
                            @error('type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Polisi *</label>
                        <input type="text" name="plate_number" :value="editPlateNumber" required
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('plate_number') border-red-400 @enderror">
                        @error('plate_number')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Merk</label>
                            <input type="text" name="brand" :value="editBrand"
                                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Model/Tipe</label>
                            <input type="text" name="model" :value="editModel"
                                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Status</label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="is_active" value="1" :checked="editIsActive === '1'"
                                       class="w-4 h-4 text-slate-600 focus:ring-slate-500">
                                <span class="text-sm text-slate-700">Aktif</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="is_active" value="0" :checked="editIsActive === '0'"
                                       class="w-4 h-4 text-slate-600 focus:ring-slate-500">
                                <span class="text-sm text-slate-700">Nonaktif</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan</label>
                        <textarea name="notes" rows="2" x-text="editNotes"
                                  class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                    </div>
                    <div class="flex items-center gap-2 pt-3 border-t border-slate-200">
                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                            Update
                        </button>
                        <button type="button" @click="showEdit = false"
                                class="inline-flex items-center justify-center rounded-lg bg-white border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
