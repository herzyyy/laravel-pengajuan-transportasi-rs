<x-app-layout title="Tambah Pengguna — SIPETRANS">
    <div class="max-w-3xl mx-auto px-3 sm:px-4 pt-3 pb-4" x-data="usernameGen()">

        <div class="flex items-center gap-2 mb-3">
            <a href="{{ route('admin.users.index') }}"
               class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-600 hover:text-slate-900 bg-white border border-slate-300 rounded-lg px-3 py-1.5 hover:bg-slate-50 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
            <h1 class="text-sm font-bold text-slate-800">Tambah User Baru</h1>
        </div>

        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-4">
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-2.5">
                @csrf

                {{-- Baris 1: Nama + Username --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Nama Lengkap *</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                               x-model="namaLengkap" @input="generateUsername()"
                               placeholder="Budi Santoso, S.Kom."
                               class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 @error('nama_lengkap') border-red-400 @enderror">
                        <p class="mt-0.5 text-[9px] text-slate-400">Gelar belakang dipisah koma. Contoh: Budi, S.Kom.</p>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Username (otomatis)</label>
                        <input type="text" readonly :value="username"
                               class="w-full rounded-md border border-slate-200 bg-slate-50 px-2.5 py-1.5 text-xs text-slate-500 font-mono cursor-not-allowed">
                        <p class="mt-0.5 text-[9px] text-slate-400">Dibuat otomatis dari nama</p>
                    </div>
                </div>

                {{-- Baris 2: NIP + Password --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">NIP</label>
                        <input type="text" name="nip" value="{{ old('nip') }}" placeholder="Nomor Induk Pegawai"
                               class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Password *</label>
                        <input type="password" name="password" required
                               class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 @error('password') border-red-400 @enderror">
                    </div>
                </div>

                {{-- Baris 3: Unit Kerja + Posisi --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Unit Kerja</label>
                        <input type="text" name="unit_kerja" value="{{ old('unit_kerja') }}"
                               class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Posisi Pekerjaan</label>
                        <input type="text" name="posisi_pekerjaan" value="{{ old('posisi_pekerjaan') }}"
                               class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>

                {{-- Baris 4: Profesi + Jabatan --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Profesi</label>
                        <input type="text" name="profesi" value="{{ old('profesi') }}"
                               class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Jabatan</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan') }}"
                               class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>

                {{-- Baris 5: Role + Level Prioritas --}}
                <div x-data="{ createRole: '{{ old('role', 'user') }}' }" class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Role *</label>
                        <select name="role" x-model="createRole" required
                                class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                            <option value="driver">Supir</option>
                        </select>
                    </div>
                    <div x-show="createRole === 'user'">
                        <label class="block text-[11px] font-semibold text-slate-600 mb-0.5">Level Prioritas</label>
                        <select name="priority_level"
                                class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="0" {{ old('priority_level', 0) == 0 ? 'selected' : '' }}>Normal</option>
                            <option value="1" {{ old('priority_level') == 1 ? 'selected' : '' }}>Prioritas Tinggi</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-2 border-t border-slate-100">
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700 transition">
                        Simpan
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                       class="inline-flex items-center justify-center rounded-lg bg-white border border-slate-300 px-4 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function usernameGen() {
            return {
                namaLengkap: '',
                username: '',
                generateUsername() {
                    const raw = (this.namaLengkap.split(',')[0] || '').trim();
                    if (!raw) { this.username = ''; return; }
                    const parts = raw.split(/\s+/);
                    const w1 = (parts[0] || '').toLowerCase().replace(/[^a-z0-9]/g, '');
                    const w2raw = parts[1] ? parts[1].toLowerCase().replace(/[^a-z0-9]/g, '') : null;
                    this.username = (w2raw && w2raw !== '') ? `${w1}.${w2raw}` : w1;
                }
            }
        }
    </script>
</x-app-layout>
