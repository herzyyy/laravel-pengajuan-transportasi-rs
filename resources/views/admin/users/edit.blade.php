<x-app-layout>
    <div class="max-w-3xl mx-auto px-3 sm:px-4 pt-3 pb-4"
         x-data="{ editRole: '{{ old('role', $user->role) }}', editPriorityLevel: '{{ old('priority_level', $user->priority_level ?? 0) }}' }">

        <div class="flex items-center gap-2 mb-3">
            <a href="{{ route('admin.users.index') }}"
               class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-600 hover:text-slate-900 bg-white border border-slate-300 rounded-lg px-3 py-1.5 hover:bg-slate-50 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
            <h1 class="text-sm font-bold text-slate-800">Edit User — <span class="text-slate-500 font-normal">{{ $user->full_name }}</span></h1>
        </div>

        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-4">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-2.5">
                @csrf
                @method('PUT')
                {{-- Baris 1: Nama + NIP --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->full_name) }}" required
                               class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">NIP</label>
                        <input type="text" name="nip" value="{{ old('nip', $user->nip) }}" placeholder="Nomor Induk Pegawai"
                               class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>

                {{-- Baris 2: Password --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Password</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah"
                               class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 @error('password') border-red-400 @enderror">
                        @error('password')<p class="mt-0.5 text-[9px] text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Unit Kerja</label>
                        <input type="text" name="unit_kerja" value="{{ old('unit_kerja', $user->unit_kerja) }}"
                               class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>

                {{-- Baris 3: Posisi + Profesi --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Posisi Pekerjaan</label>
                        <input type="text" name="posisi_pekerjaan" value="{{ old('posisi_pekerjaan', $user->posisi_pekerjaan) }}"
                               class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Profesi</label>
                        <input type="text" name="profesi" value="{{ old('profesi', $user->profesi) }}"
                               class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>

                {{-- Baris 4: Jabatan + Role --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Jabatan</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan', $user->jabatan) }}"
                               class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Role *</label>
                        <select name="role" x-model="editRole" required
                                class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                            <option value="driver">Supir</option>
                        </select>
                    </div>
                </div>

                {{-- Baris 5: Level Prioritas (kondisional) --}}
                <div x-show="editRole === 'user'" class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Level Prioritas</label>
                        <select name="priority_level" x-model="editPriorityLevel"
                                class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="0">Normal</option>
                            <option value="1">Prioritas Tinggi</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-2 border-t border-slate-100">
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700 transition">
                        Update
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                       class="inline-flex items-center justify-center rounded-lg bg-white border border-slate-300 px-4 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
