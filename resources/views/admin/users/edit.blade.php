<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 pt-8 pb-12">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Edit User</h1>
            <p class="text-slate-500 mt-1 text-sm">Update data user</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Depan *</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('first_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Belakang *</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('last_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <p class="mt-1 text-xs text-slate-500">Kosongkan jika tidak ingin mengubah password</p>
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Unit Kerja</label>
                    <input type="text" name="unit_kerja" value="{{ old('unit_kerja', $user->unit_kerja) }}"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Role *</label>
                    <select name="role" required
                            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="user" @selected(old('role', $user->role) === 'user')>User</option>
                        <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Level Prioritas *</label>
                    <select name="priority_level" required
                            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="0" @selected(old('priority_level', $user->priority_level ?? 0) == 0)>Normal</option>
                        <option value="1" @selected(old('priority_level', $user->priority_level ?? 0) == 1)>Prioritas Tinggi (Owner/VIP)</option>
                    </select>
                    <p class="mt-1 text-xs text-slate-500">User dengan prioritas tinggi dapat override pengajuan lain yang bentrok</p>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-slate-200">
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700 transition shadow-sm">
                        Update
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                       class="inline-flex items-center justify-center rounded-xl bg-white border border-slate-300 px-6 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
