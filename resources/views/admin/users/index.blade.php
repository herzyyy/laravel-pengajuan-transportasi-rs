<x-app-layout>
    <div class="max-w-7xl mx-auto px-3 sm:px-4 pt-4 pb-6"
         x-data="{
            showCreate: {{ $errors->any() && !session('edit_id') ? 'true' : 'false' }},
            showEdit: {{ session('edit_id') ? 'true' : 'false' }},
            editId: '{{ session('edit_id', '') }}',
            editNamaLengkap: '{{ old('nama_lengkap', session('edit_nama_lengkap', '')) }}',
            editNip: '{{ old('nip', session('edit_nip', '')) }}',
            editUnitKerja: '{{ old('unit_kerja', session('edit_unit_kerja', '')) }}',
            editPosisiPekerjaan: '{{ old('posisi_pekerjaan', session('edit_posisi_pekerjaan', '')) }}',
            editProfesi: '{{ old('profesi', session('edit_profesi', '')) }}',
            editJabatan: '{{ old('jabatan', session('edit_jabatan', '')) }}',
            editRole: '{{ old('role', session('edit_role', 'user')) }}',
            editPriorityLevel: '{{ old('priority_level', session('edit_priority_level', '0')) }}',
            openEdit(id, namaLengkap, nip, unitKerja, posisiPekerjaan, profesi, jabatan, role, priorityLevel) {
                this.editId = id;
                this.editNamaLengkap = namaLengkap;
                this.editNip = nip;
                this.editUnitKerja = unitKerja;
                this.editPosisiPekerjaan = posisiPekerjaan;
                this.editProfesi = profesi;
                this.editJabatan = jabatan;
                this.editRole = role;
                this.editPriorityLevel = priorityLevel;
                this.showEdit = true;
            }
         }">

        <div class="flex items-center justify-between mb-3">
            <div>
                <h1 class="text-lg font-bold text-slate-800">Master User</h1>
                <p class="text-slate-500 text-xs mt-0.5">Kelola data user sistem</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
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

        @if(session('error'))
            <div class="mb-3 p-2.5 bg-red-50 border border-red-200 text-red-700 rounded-lg text-xs font-medium">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filter -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-2.5 mb-3">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari nama, NIP, username, atau unit kerja..."
                           class="w-full rounded-lg border-slate-300 px-2.5 py-1.5 text-xs focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div class="w-full sm:w-40">
                    <select name="role" class="w-full rounded-lg border-slate-300 px-2.5 py-1.5 text-xs focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">Semua Role</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="driver" {{ request('role') == 'driver' ? 'selected' : '' }}>Supir</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-slate-800 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-slate-900 transition">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'role']))
                        <a href="{{ route('admin.users.index') }}" class="bg-slate-100 text-slate-600 px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-slate-200 transition border border-slate-200">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Desktop Table -->
        <div class="hidden md:block bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr class="text-[10px] font-semibold text-slate-600 uppercase tracking-wide">
                            <th class="py-2 px-3 text-left">Nama Lengkap</th>
                            <th class="py-2 px-3 text-left">Username</th>
                            <th class="py-2 px-3 text-left">NIP</th>
                            <th class="py-2 px-3 text-left">Unit Kerja</th>
                            <th class="py-2 px-3 text-left">Posisi</th>
                            <th class="py-2 px-3 text-left">Profesi</th>
                            <th class="py-2 px-3 text-left">Jabatan</th>
                            <th class="py-2 px-3 text-left">Role</th>
                            <th class="py-2 px-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-2 px-3">
                                    <div class="font-medium text-slate-900">{{ $user->first_name }} {{ $user->last_name }}</div>
                                </td>
                                <td class="py-2 px-3 text-slate-600 font-mono text-[11px]">{{ $user->username ?? '-' }}</td>
                                <td class="py-2 px-3 text-slate-700 font-mono">{{ $user->nip ?? '-' }}</td>
                                <td class="py-2 px-3 text-slate-700">{{ $user->unit_kerja ?? '-' }}</td>
                                <td class="py-2 px-3 text-slate-700">{{ $user->posisi_pekerjaan ?? '-' }}</td>
                                <td class="py-2 px-3 text-slate-700">{{ $user->profesi ?? '-' }}</td>
                                <td class="py-2 px-3 text-slate-700">{{ $user->jabatan ?? '-' }}</td>
                                <td class="py-2 px-3">
                                    @if($user->role === 'admin')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-800">Admin</span>
                                    @elseif($user->role === 'driver')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Supir</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-800">User</span>
                                    @endif
                                </td>
                                <td class="py-2 px-3 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="inline-flex items-center justify-center rounded-lg bg-white border border-slate-300 px-2.5 py-1 text-[10px] font-semibold text-slate-700 hover:bg-slate-50 hover:border-blue-500 hover:text-blue-700 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus user ini?')">
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
                                <td colspan="9" class="py-6 text-center text-slate-500 text-xs">Tidak ada data user</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-3 py-2 bg-slate-50 border-t border-slate-200">
                {{ $users->links() }}
            </div>
        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden space-y-2">
            @forelse($users as $user)
                <div class="bg-white rounded-lg shadow-sm ring-1 ring-slate-200 p-3">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-1">
                            <h3 class="font-semibold text-slate-900 text-sm">{{ $user->first_name }} {{ $user->last_name }}</h3>
                            <p class="text-xs text-slate-600 mt-0.5">{{ $user->unit_kerja ?? '-' }}</p>
                        </div>
                        @if($user->role === 'admin')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-800">Admin</span>
                        @elseif($user->role === 'driver')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Supir</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-800">User</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 pt-2 border-t border-slate-100">
                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="flex-1 inline-flex items-center justify-center rounded-lg bg-white border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:border-blue-500 hover:text-blue-700 transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="flex-1"
                              onsubmit="return confirm('Yakin ingin menghapus user ini?')">
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
                    Tidak ada data user
                </div>
            @endforelse
            @if($users->hasPages())
                <div class="pt-2">{{ $users->links() }}</div>
            @endif
        </div>

        <!-- CREATE MODAL -->
        <div x-show="showCreate" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50" @click="showCreate = false"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between px-4 py-3 border-b border-slate-200">
                    <h2 class="text-sm font-bold text-slate-800">Tambah User Baru</h2>
                    <button @click="showCreate = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('admin.users.store') }}" method="POST" class="p-4 space-y-3"
                      x-data="usernameGen()">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap *</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                               x-model="namaLengkap" @input="generateUsername()"
                               placeholder="Contoh: Budi Santoso, S.Kom."
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('nama_lengkap') border-red-400 @enderror">
                        @error('nama_lengkap')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        <p class="mt-1 text-[10px] text-slate-400">Gelar diletakkan di belakang nama, pisahkan dengan koma. Contoh: <span class="font-medium">Budi Santoso, S.Kom.</span></p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Username (otomatis)</label>
                        <input type="text" readonly :value="username"
                               class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-600 font-mono cursor-not-allowed">
                        <p class="mt-1 text-[10px] text-slate-400">Dibuat otomatis dari nama lengkap</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">NIP</label>
                        <input type="text" name="nip" value="{{ old('nip') }}" placeholder="Nomor Induk Pegawai"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('nip')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Password *</label>
                        <input type="password" name="password" required
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('password') border-red-400 @enderror">
                        @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Unit Kerja</label>
                        <input type="text" name="unit_kerja" value="{{ old('unit_kerja') }}"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Posisi Pekerjaan</label>
                        <input type="text" name="posisi_pekerjaan" value="{{ old('posisi_pekerjaan') }}"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Profesi</label>
                            <input type="text" name="profesi" value="{{ old('profesi') }}"
                                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Jabatan</label>
                            <input type="text" name="jabatan" value="{{ old('jabatan') }}"
                                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                    </div>
                    <div x-data="{ createRole: '{{ old('role', 'user') }}' }" class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Role *</label>
                            <select name="role" x-model="createRole" required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="driver">Supir</option>
                            </select>
                        </div>
                        <div x-show="createRole === 'user'">
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Level Prioritas</label>
                            <select name="priority_level"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="0" {{ old('priority_level', 0) == 0 ? 'selected' : '' }}>Normal</option>
                                <option value="1" {{ old('priority_level') == 1 ? 'selected' : '' }}>Prioritas Tinggi</option>
                            </select>
                        </div>
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
                    <h2 class="text-sm font-bold text-slate-800">Edit User</h2>
                    <button @click="showEdit = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form :action="'{{ url('admin/users') }}/' + editId" method="POST" class="p-4 space-y-3">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                        <div class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700" x-text="editNamaLengkap"></div>
                        <input type="hidden" name="nama_lengkap" :value="editNamaLengkap">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">NIP</label>
                        <input type="text" name="nip" :value="editNip" placeholder="Nomor Induk Pegawai"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Password</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('password') border-red-400 @enderror">
                        <p class="mt-1 text-[10px] text-slate-500">Kosongkan jika tidak ingin mengubah password</p>
                        @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Unit Kerja</label>
                        <input type="text" name="unit_kerja" :value="editUnitKerja"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Posisi Pekerjaan</label>
                        <input type="text" name="posisi_pekerjaan" :value="editPosisiPekerjaan"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Profesi</label>
                            <input type="text" name="profesi" :value="editProfesi"
                                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Jabatan</label>
                            <input type="text" name="jabatan" :value="editJabatan"
                                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                    </div>
                    <div x-data="{ get editRoleLocal() { return $root.editRole; }, set editRoleLocal(v) { $root.editRole = v; } }" class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Role *</label>
                            <select name="role" x-model="$root.editRole" required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="driver">Supir</option>
                            </select>
                        </div>
                        <div x-show="$root.editRole === 'user'">
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Level Prioritas</label>
                            <select name="priority_level" x-model="$root.editPriorityLevel"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="0">Normal</option>
                                <option value="1">Prioritas Tinggi</option>
                            </select>
                        </div>
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

    <script>
        function usernameGen() {
            return {
                namaLengkap: '',
                username: '',
                generateUsername() {
                    // Potong gelar setelah koma
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
