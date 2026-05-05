<x-app-layout>
    <div class="max-w-7xl mx-auto px-3 sm:px-4 pt-4 pb-6"
         x-data="{
            showCreate: {{ $errors->any() && !session('edit_id') ? 'true' : 'false' }},
            showEdit: {{ session('edit_id') ? 'true' : 'false' }},
            editId: '{{ session('edit_id', '') }}',
            editName: '{{ old('name', session('edit_name', '')) }}',
            editPhone: '{{ old('phone', session('edit_phone', '')) }}',
            editLicenseNumber: '{{ old('license_number', session('edit_license_number', '')) }}',
            editUserId: '{{ old('user_id', session('edit_user_id', '')) }}',
            editIsActive: '{{ old('is_active', session('edit_is_active', '1')) }}',
            openEdit(id, name, phone, licenseNumber, userId, isActive) {
                this.editId = id;
                this.editName = name;
                this.editPhone = phone;
                this.editLicenseNumber = licenseNumber;
                this.editUserId = userId;
                this.editIsActive = isActive;
                this.showEdit = true;
            }
         }">

        <div class="flex items-center justify-between mb-3">
            <div>
                <h1 class="text-lg font-bold text-slate-800">Master Supir</h1>
                <p class="text-slate-500 text-xs mt-0.5">Kelola data supir/pengemudi</p>
            </div>
            <a href="{{ route('admin.drivers.create') }}"
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

        <!-- Desktop Table -->
        <form method="GET" action="{{ route('admin.drivers.index') }}" id="drivers-filter-form">
        <div class="hidden md:block bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead>
                        {{-- Filter row --}}
                        <tr class="bg-slate-50/80 border-b border-slate-200">
                            <th class="py-2 px-3">
                                <input type="text" name="nama" value="{{ request('nama') }}" placeholder="Cari nama..."
                                       class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-[10px] font-normal focus:ring-2 focus:ring-teal-400 focus:border-teal-400 bg-white">
                            </th>
                            <th class="py-2 px-3">
                                <input type="text" name="telepon" value="{{ request('telepon') }}" placeholder="Cari telepon..."
                                       class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-[10px] font-normal focus:ring-2 focus:ring-teal-400 focus:border-teal-400 bg-white">
                            </th>
                            <th class="py-2 px-3">
                                <input type="text" name="sim" value="{{ request('sim') }}" placeholder="Cari SIM..."
                                       class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-[10px] font-normal focus:ring-2 focus:ring-teal-400 focus:border-teal-400 bg-white">
                            </th>
                            <th class="py-2 px-3">
                                <select name="is_active" class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-[10px] font-normal focus:ring-2 focus:ring-teal-400 focus:border-teal-400 bg-white">
                                    <option value="">Semua</option>
                                    <option value="1" @selected(request('is_active') === '1')>Aktif</option>
                                    <option value="0" @selected(request('is_active') === '0')>Nonaktif</option>
                                </select>
                            </th>
                            <th class="py-2 px-3"></th>
                        </tr>
                        {{-- Header row --}}
                        <tr class="text-left text-[10px] font-semibold text-white uppercase tracking-wider" style="background: linear-gradient(to right, #007774, #009e9a);">
                            <th class="py-2.5 px-3">Nama</th>
                            <th class="py-2.5 px-3">Telepon</th>
                            <th class="py-2.5 px-3">Nomor SIM</th>
                            <th class="py-2.5 px-3">Status</th>
                            <th class="py-2.5 px-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($drivers as $driver)
                            <tr class="hover:bg-teal-50/40 transition-colors">
                                <td class="py-2.5 px-3">
                                    <div class="font-semibold text-slate-900">{{ $driver->name }}</div>
                                </td>
                                <td class="py-2.5 px-3 text-slate-700">{{ $driver->phone ?? '-' }}</td>
                                <td class="py-2.5 px-3 text-slate-700 font-mono">{{ $driver->license_number ?? '-' }}</td>
                                <td class="py-2.5 px-3">
                                    @if($driver->is_active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">Aktif</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="py-2.5 px-3 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.drivers.edit', $driver) }}"
                                            class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-2.5 py-1 text-[10px] font-semibold text-slate-700 hover:bg-blue-50 hover:border-blue-400 hover:text-blue-700 transition bg-white">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.drivers.destroy', $driver) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus supir ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-2.5 py-1 text-[10px] font-semibold text-red-600 hover:bg-red-50 hover:border-red-400 transition bg-white">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500 text-xs">Tidak ada data supir</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-3 py-2.5 bg-slate-50 border-t border-slate-200">
                {{ $drivers->links() }}
            </div>
        </div>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('drivers-filter-form');
                if (!form) return;
                let timer;

                function submitClean() {
                    clearTimeout(timer);
                    timer = setTimeout(() => {
                        form.querySelectorAll('input, select').forEach(el => {
                            if (el.value === '') el.disabled = true;
                        });
                        form.submit();
                    }, 400);
                }

                form.querySelectorAll('input[type="text"]').forEach(el => {
                    el.addEventListener('input', submitClean);
                });
                form.querySelectorAll('select').forEach(el => {
                    el.addEventListener('change', () => {
                        clearTimeout(timer);
                        form.querySelectorAll('input, select').forEach(e => {
                            if (e.value === '') e.disabled = true;
                        });
                        form.submit();
                    });
                });
            });
        </script>

        <!-- Mobile Cards -->
        <div class="md:hidden space-y-2">
            @forelse($drivers as $driver)
                <div class="bg-white rounded-lg shadow-sm ring-1 ring-slate-200 p-3">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-1">
                            <h3 class="font-semibold text-slate-900 text-sm">{{ $driver->name }}</h3>
                            <p class="text-xs text-slate-600 mt-0.5">{{ $driver->phone ?? '-' }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">SIM: {{ $driver->license_number ?? '-' }}</p>
                        </div>
                        @if($driver->is_active)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Aktif</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-800">Nonaktif</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 pt-2 border-t border-slate-100">
                        <a href="{{ route('admin.drivers.edit', $driver) }}"
                            class="flex-1 inline-flex items-center justify-center rounded-lg bg-white border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:border-blue-500 hover:text-blue-700 transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.drivers.destroy', $driver) }}" method="POST" class="flex-1"
                              onsubmit="return confirm('Yakin ingin menghapus supir ini?')">
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
                    Tidak ada data supir
                </div>
            @endforelse
            @if($drivers->hasPages())
                <div class="pt-2">{{ $drivers->links() }}</div>
            @endif
        </div>

        <!-- CREATE MODAL -->
        <div x-show="showCreate" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50" @click="showCreate = false"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between px-4 py-3 border-b border-slate-200">
                    <h2 class="text-sm font-bold text-slate-800">Tambah Supir Baru</h2>
                    <button @click="showCreate = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('admin.drivers.store') }}" method="POST" class="p-4 space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-400 @enderror">
                        @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="081234567890"
                                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor SIM</label>
                            <input type="text" name="license_number" value="{{ old('license_number') }}" placeholder="A-1234-5678"
                                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            @error('license_number')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Akun Login Supir</label>
                        <select name="user_id"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">-- Tidak dihubungkan --</option>
                            @foreach($driverUsers as $u)
                                <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>{{ $u->full_name }}</option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-[10px] text-slate-500">Hubungkan ke akun dengan role "driver" agar supir bisa login</p>
                        @error('user_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Status</label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="is_active" value="1" {{ old('is_active', '1') === '1' ? 'checked' : '' }}
                                       class="w-4 h-4 text-slate-600 focus:ring-slate-500">
                                <span class="text-sm text-slate-700">Aktif</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="is_active" value="0" {{ old('is_active') === '0' ? 'checked' : '' }}
                                       class="w-4 h-4 text-slate-600 focus:ring-slate-500">
                                <span class="text-sm text-slate-700">Nonaktif</span>
                            </label>
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
                    <h2 class="text-sm font-bold text-slate-800">Edit Supir</h2>
                    <button @click="showEdit = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form :action="'{{ url('admin/drivers') }}/' + editId" method="POST" class="p-4 space-y-3">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap *</label>
                        <input type="text" name="name" :value="editName" required
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-400 @enderror">
                        @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Telepon</label>
                            <input type="text" name="phone" :value="editPhone"
                                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor SIM</label>
                            <input type="text" name="license_number" :value="editLicenseNumber"
                                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            @error('license_number')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Akun Login Supir</label>
                        <select name="user_id"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">-- Tidak dihubungkan --</option>
                            @foreach($driverUsers as $u)
                                <option value="{{ $u->id }}" :selected="editUserId == '{{ $u->id }}'">{{ $u->full_name }}</option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-[10px] text-slate-500">Hubungkan ke akun dengan role "driver" agar supir bisa login</p>
                        @error('user_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Status</label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="is_active" value="1" :checked="editIsActive === '1'"
                                       class="w-4 h-4 text-slate-600 focus:ring-slate-500">
                                <span class="text-sm text-slate-700">Aktif</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="is_active" value="0" :checked="editIsActive === '0'"
                                       class="w-4 h-4 text-slate-600 focus:ring-slate-500">
                                <span class="text-sm text-slate-700">Nonaktif</span>
                            </label>
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
</x-app-layout>
