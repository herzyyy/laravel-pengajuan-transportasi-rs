<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 sm:px-4 pt-3 pb-6">
        <div class="mb-3">
            <h1 class="text-lg font-bold text-slate-800">Tambah Supir Baru</h1>
            <p class="text-slate-500 mt-0.5 text-xs">Isi form untuk menambahkan supir baru</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <form action="{{ route('admin.drivers.store') }}" method="POST" class="p-4 space-y-3">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               placeholder="Contoh: 081234567890"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('phone')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor SIM</label>
                        <input type="text" name="license_number" value="{{ old('license_number') }}"
                               placeholder="Contoh: A-1234-5678-9012"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('license_number')
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

                <div class="flex items-center gap-2 pt-3 border-t border-slate-200">
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition shadow-sm">
                        Simpan
                    </button>
                    <a href="{{ route('admin.drivers.index') }}"
                       class="inline-flex items-center justify-center rounded-lg bg-white border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
