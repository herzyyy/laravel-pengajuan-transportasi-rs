<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 sm:px-4 pt-3 pb-6">
        <div class="mb-3">
            <h1 class="text-lg font-bold text-slate-800">Tambah Kendaraan Baru</h1>
            <p class="text-slate-500 mt-0.5 text-xs">Isi form untuk menambahkan kendaraan baru</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <form action="{{ route('admin.vehicles.store') }}" method="POST" class="p-4 space-y-3">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Unit *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               placeholder="Contoh: mobil_umum_1"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis *</label>
                        <select name="type" required
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Pilih Jenis</option>
                            <option value="umum" @selected(old('type') === 'umum')>Umum</option>
                            <option value="ambulance" @selected(old('type') === 'ambulance')>Ambulance</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Polisi *</label>
                    <input type="text" name="plate_number" value="{{ old('plate_number') }}" required
                           placeholder="Contoh: B 1234 CD"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    @error('plate_number')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Merk</label>
                        <input type="text" name="brand" value="{{ old('brand') }}"
                               placeholder="Contoh: Toyota"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('brand')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Model/Tipe</label>
                        <input type="text" name="model" value="{{ old('model') }}"
                               placeholder="Contoh: Avanza"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('model')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Tahun</label>
                        <input type="number" name="year" value="{{ old('year') }}" min="1900" max="{{ date('Y') + 1 }}"
                               placeholder="Contoh: 2020"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('year')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Kapasitas</label>
                        <input type="number" name="capacity" value="{{ old('capacity') }}" min="1"
                               placeholder="Contoh: 7"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('capacity')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Status</label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="is_active" value="1" @checked(old('is_active', '1') === '1')
                                   class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                            <span class="text-sm text-slate-700">Aktif</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="is_active" value="0" @checked(old('is_active') === '0')
                                   class="w-4 h-4 text-slate-600 focus:ring-slate-500">
                            <span class="text-sm text-slate-700">Nonaktif</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan</label>
                    <textarea name="notes" rows="2"
                              class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                              placeholder="Catatan tambahan tentang kendaraan">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-2 pt-3 border-t border-slate-200">
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition shadow-sm">
                        Simpan
                    </button>
                    <a href="{{ route('admin.vehicles.index') }}"
                       class="inline-flex items-center justify-center rounded-lg bg-white border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
