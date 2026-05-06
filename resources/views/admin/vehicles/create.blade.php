<x-app-layout title="Tambah Kendaraan — SIPETRANS">
    <div class="max-w-2xl mx-auto px-3 sm:px-4 pt-3 pb-4">

        <div class="flex items-center gap-2 mb-3">
            <a href="{{ route('admin.vehicles.index') }}"
               class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-600 hover:text-slate-900 bg-white border border-slate-300 rounded-lg px-3 py-1.5 hover:bg-slate-50 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
            <h1 class="text-sm font-bold text-slate-800">Tambah Kendaraan Baru</h1>
        </div>

        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-4">
            <form action="{{ route('admin.vehicles.store') }}" method="POST" class="space-y-2.5">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Nama Unit *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="mobil_umum_1"
                               class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-400 @enderror">
                        @error('name')<p class="mt-0.5 text-[9px] text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Jenis *</label>
                        <select name="type" required
                                class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 @error('type') border-red-400 @enderror">
                            <option value="">Pilih Jenis</option>
                            <option value="umum" {{ old('type') === 'umum' ? 'selected' : '' }}>Umum</option>
                            <option value="ambulance" {{ old('type') === 'ambulance' ? 'selected' : '' }}>Ambulance</option>
                        </select>
                        @error('type')<p class="mt-0.5 text-[9px] text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Nomor Polisi *</label>
                        <input type="text" name="plate_number" value="{{ old('plate_number') }}" required placeholder="B 1234 CD"
                               class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 @error('plate_number') border-red-400 @enderror">
                        @error('plate_number')<p class="mt-0.5 text-[9px] text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Merk</label>
                        <input type="text" name="brand" value="{{ old('brand') }}" placeholder="Toyota"
                               class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Model/Tipe</label>
                        <input type="text" name="model" value="{{ old('model') }}" placeholder="Avanza"
                               class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Status</label>
                        <div class="flex items-center gap-4 mt-1.5">
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="is_active" value="1" {{ old('is_active', '1') === '1' ? 'checked' : '' }} class="w-3.5 h-3.5">
                                <span class="text-xs text-slate-700">Aktif</span>
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="is_active" value="0" {{ old('is_active') === '0' ? 'checked' : '' }} class="w-3.5 h-3.5">
                                <span class="text-xs text-slate-700">Nonaktif</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Catatan</label>
                    <textarea name="notes" rows="2" placeholder="Catatan tambahan tentang kendaraan"
                              class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">{{ old('notes') }}</textarea>
                </div>
                <div class="flex items-center gap-2 pt-2 border-t border-slate-100">
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700 transition">
                        Simpan
                    </button>
                    <a href="{{ route('admin.vehicles.index') }}"
                       class="inline-flex items-center justify-center rounded-lg bg-white border border-slate-300 px-4 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
