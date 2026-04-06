<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 sm:px-4 pt-3 pb-6">
        <div class="mb-3">
            <h1 class="text-lg font-bold text-slate-800">Tambah User Baru</h1>
            <p class="text-slate-500 mt-0.5 text-xs">Isi form untuk menambahkan user baru</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <form action="{{ route('admin.users.store') }}" method="POST" class="p-4 space-y-3">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Depan *</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" required
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('first_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Belakang *</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" required
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('last_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Password *</label>
                    <input type="password" name="password" required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                           placeholder="Minimal 8 karakter">
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Unit Kerja</label>
                    <input type="text" name="unit_kerja" value="{{ old('unit_kerja') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    @error('unit_kerja')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Role *</label>
                        <select name="role" id="role" required
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="user" @selected(old('role') === 'user')>User</option>
                            <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="priority-field" class="{{ old('role', 'user') === 'admin' ? 'hidden' : '' }}">
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Level Prioritas *</label>
                        <select name="priority_level" id="priority_level"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="0" @selected(old('priority_level', 0) == 0)>Normal</option>
                            <option value="1" @selected(old('priority_level') == 1)>Prioritas Tinggi</option>
                        </select>
                        @error('priority_level')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <script>
                    document.getElementById('role').addEventListener('change', function () {
                        const priorityField = document.getElementById('priority-field');
                        const prioritySelect = document.getElementById('priority_level');
                        if (this.value === 'admin') {
                            priorityField.classList.add('hidden');
                            prioritySelect.removeAttribute('required');
                        } else {
                            priorityField.classList.remove('hidden');
                            prioritySelect.setAttribute('required', 'required');
                        }
                    });
                </script>

                <div class="flex items-center gap-2 pt-3 border-t border-slate-200">
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition shadow-sm">
                        Simpan
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                       class="inline-flex items-center justify-center rounded-lg bg-white border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
