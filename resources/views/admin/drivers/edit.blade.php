<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 sm:px-4 pt-3 pb-4">

        <div class="flex items-center gap-2 mb-3">
            <a href="{{ route('admin.drivers.index') }}"
               class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-600 hover:text-slate-900 bg-white border border-slate-300 rounded-lg px-3 py-1.5 hover:bg-slate-50 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
            <h1 class="text-sm font-bold text-slate-800">Edit Supir — <span class="text-slate-500 font-normal">{{ $driver->name }}</span></h1>
        </div>

        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-4">
            <form action="{{ route('admin.drivers.update', $driver) }}" method="POST" class="space-y-2.5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Nama Lengkap *</label>
                    <input type="text" name="name" value="{{ old('name', $driver->name) }}" required
                           class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-400 @enderror">
                    @error('name')<p class="mt-0.5 text-[9px] text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $driver->phone) }}"
                               class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Nomor SIM</label>
                        <input type="text" name="license_number" value="{{ old('license_number', $driver->license_number) }}"
                               class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Akun Login Supir</label>
                    <select name="user_id"
                            class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">-- Tidak dihubungkan --</option>
                        @foreach($driverUsers as $u)
                            <option value="{{ $u->id }}" {{ old('user_id', $driver->user_id) == $u->id ? 'selected' : '' }}>{{ $u->full_name }}</option>
                        @endforeach
                    </select>
                    <p class="mt-0.5 text-[9px] text-slate-400">Hubungkan ke akun dengan role "driver" agar supir bisa login</p>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Status</label>
                    <div class="flex items-center gap-4 mt-1">
                        <label class="flex items-center gap-1.5 cursor-pointer">
                            <input type="radio" name="is_active" value="1" {{ old('is_active', $driver->is_active ? '1' : '0') === '1' ? 'checked' : '' }} class="w-3.5 h-3.5">
                            <span class="text-xs text-slate-700">Aktif</span>
                        </label>
                        <label class="flex items-center gap-1.5 cursor-pointer">
                            <input type="radio" name="is_active" value="0" {{ old('is_active', $driver->is_active ? '1' : '0') === '0' ? 'checked' : '' }} class="w-3.5 h-3.5">
                            <span class="text-xs text-slate-700">Nonaktif</span>
                        </label>
                    </div>
                </div>
                <div class="flex items-center gap-2 pt-2 border-t border-slate-100">
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700 transition">
                        Update
                    </button>
                    <a href="{{ route('admin.drivers.index') }}"
                       class="inline-flex items-center justify-center rounded-lg bg-white border border-slate-300 px-4 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
