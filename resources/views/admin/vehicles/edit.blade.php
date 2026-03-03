<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 pt-8 pb-12">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Edit Kendaraan</h1>
            <p class="text-slate-500 mt-1 text-sm">Update data kendaraan</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <form action="{{ route('admin.vehicles.update', $vehicle) }}" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Unit *</label>
                        <input type="text" name="name" value="{{ old('name', $vehicle->name) }}" required
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis *</label>
                        <select name="type" required
                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="umum" @selected(old('type', $vehicle->type) === 'umum')>Umum</option>
                            <option value="ambulance" @selected(old('type', $vehicle->type) === 'ambulance')>Ambulance</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Polisi *</label>
                    <input type="text" name="plate_number" value="{{ old('plate_number', $vehicle->plate_number) }}" required
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    @error('plate_number')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Merk</label>
                        <input type="text" name="brand" value="{{ old('brand', $vehicle->brand) }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Model/Tipe</label>
                        <input type="text" name="model" value="{{ old('model', $vehicle->model) }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun</label>
                        <input type="number" name="year" value="{{ old('year', $vehicle->year) }}" min="1900" max="{{ date('Y') + 1 }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kapasitas Penumpang</label>
                        <input type="number" name="capacity" value="{{ old('capacity', $vehicle->capacity) }}" min="1"
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="is_active" value="1" @checked(old('is_active', $vehicle->is_active) == 1)
                                   class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                            <span class="text-sm text-slate-700">Aktif</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="is_active" value="0" @checked(old('is_active', $vehicle->is_active) == 0)
                                   class="w-4 h-4 text-slate-600 focus:ring-slate-500">
                            <span class="text-sm text-slate-700">Nonaktif</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan</label>
                    <textarea name="notes" rows="3"
                              class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('notes', $vehicle->notes) }}</textarea>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-slate-200">
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700 transition shadow-sm">
                        Update
                    </button>
                    <a href="{{ route('admin.vehicles.index') }}"
                       class="inline-flex items-center justify-center rounded-xl bg-white border border-slate-300 px-6 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
