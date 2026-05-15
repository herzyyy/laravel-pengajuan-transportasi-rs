<x-app-layout title="Manajemen Pengguna — SIPETRANS">
    <div class="container-fluid px-3 pt-4 pb-6">

        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h1 class="fw-bold text-slate-800 mb-0" style="font-size:1.1rem;">Master User</h1>
                <p class="text-slate-500 text-xs mt-1 mb-0">Kelola data user sistem</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
               class="btn btn-sp-primary d-inline-flex align-items-center gap-2 text-xs">
                <svg class="w-3.5 h-3.5" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="fw-600">Tambah</span>
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-sp-success border border-emerald-200 rounded px-3 py-2 mb-3 text-xs fw-500">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-sp-danger border border-red-200 rounded px-3 py-2 mb-3 text-xs fw-500">
                {{ session('error') }}
            </div>
        @endif

        <!-- Desktop Table -->
        <form method="GET" action="{{ route('admin.users.index') }}" id="users-filter-form">
        <div class="d-none d-md-block sp-card overflow-hidden mb-3">
            <div class="overflow-x-auto">
                <table class="sp-table w-100 text-xs">
                    <thead>
                        {{-- Baris 1: Filter --}}
                        <tr class="bg-slate-50 border-bottom border-slate-200">
                            <th class="py-2 px-3">
                                <input type="text" name="nama" value="{{ request('nama') }}" placeholder="Cari nama..."
                                       class="form-control form-control-sm text-xxs border-slate-300">
                            </th>
                            <th class="py-2 px-3">
                                <input type="text" name="username" value="{{ request('username') }}" placeholder="Cari username..."
                                       class="form-control form-control-sm text-xxs border-slate-300">
                            </th>
                            <th class="py-2 px-3">
                                <input type="text" name="nip" value="{{ request('nip') }}" placeholder="Cari NIP..."
                                       class="form-control form-control-sm text-xxs border-slate-300">
                            </th>
                            <th class="py-2 px-3">
                                <input type="text" name="unit_kerja" value="{{ request('unit_kerja') }}" placeholder="Cari unit..."
                                       class="form-control form-control-sm text-xxs border-slate-300">
                            </th>
                            <th class="py-2 px-3">
                                <input type="text" name="posisi" value="{{ request('posisi') }}" placeholder="Cari posisi..."
                                       class="form-control form-control-sm text-xxs border-slate-300">
                            </th>
                            <th class="py-2 px-3">
                                <input type="text" name="profesi" value="{{ request('profesi') }}" placeholder="Cari profesi..."
                                       class="form-control form-control-sm text-xxs border-slate-300">
                            </th>
                            <th class="py-2 px-3">
                                <input type="text" name="jabatan" value="{{ request('jabatan') }}" placeholder="Cari jabatan..."
                                       class="form-control form-control-sm text-xxs border-slate-300">
                            </th>
                            <th class="py-2 px-3">
                                <select name="role" class="form-select form-select-sm text-xxs border-slate-300">
                                    <option value="">Semua</option>
                                    <option value="user" @selected(request('role') === 'user')>User</option>
                                    <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                                    <option value="driver" @selected(request('role') === 'driver')>Supir</option>
                                </select>
                            </th>
                            <th class="py-2 px-3"></th>
                        </tr>
                        {{-- Baris 2: Header --}}
                        <tr class="text-start text-xxs fw-600 text-white text-uppercase" style="background: linear-gradient(to right, #007774, #009e9a);">
                            <th class="py-2 px-3">Nama Lengkap</th>
                            <th class="py-2 px-3">Username</th>
                            <th class="py-2 px-3">NIP</th>
                            <th class="py-2 px-3">Unit Kerja</th>
                            <th class="py-2 px-3">Posisi</th>
                            <th class="py-2 px-3">Profesi</th>
                            <th class="py-2 px-3">Jabatan</th>
                            <th class="py-2 px-3">Role</th>
                            <th class="py-2 px-3 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $user)
                            <tr>
                                <td class="py-2 px-3">
                                    <div class="fw-600 text-slate-900">{{ $user->first_name }} {{ $user->last_name }}</div>
                                </td>
                                <td class="py-2 px-3 text-slate-600 font-monospace text-xxs">{{ $user->username ?? '-' }}</td>
                                <td class="py-2 px-3 text-slate-700 font-monospace">{{ $user->nip ?? '-' }}</td>
                                <td class="py-2 px-3 text-slate-700">{{ $user->unit_kerja ?? '-' }}</td>
                                <td class="py-2 px-3 text-slate-700">{{ $user->posisi_pekerjaan ?? '-' }}</td>
                                <td class="py-2 px-3 text-slate-700">{{ $user->profesi ?? '-' }}</td>
                                <td class="py-2 px-3 text-slate-700">{{ $user->jabatan ?? '-' }}</td>
                                <td class="py-2 px-3">
                                    @if($user->role === 'admin')
                                        <span class="badge-indigo">Admin</span>
                                    @elseif($user->role === 'driver')
                                        <span class="badge-amber">Supir</span>
                                    @else
                                        <span class="badge-slate">User</span>
                                    @endif
                                </td>
                                <td class="py-2 px-3 text-end">
                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="btn btn-sp-outline text-xxs fw-600 px-2 py-1">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm border border-slate-300 text-xxs fw-600 text-danger bg-white px-2 py-1">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-5 text-center text-slate-500 text-xs">Tidak ada data user</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-3 py-2 bg-slate-50 border-top border-slate-200">
                {{ $users->links() }}
            </div>
        </div>
        </form>

        <!-- Mobile Cards -->
        <div class="d-md-none">
            @forelse($users as $user)
                <div class="sp-card p-3 mb-2">
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <div class="flex-grow-1">
                            <h3 class="fw-600 text-slate-900 text-sm mb-0">{{ $user->first_name }} {{ $user->last_name }}</h3>
                            <p class="text-xs text-slate-600 mt-1 mb-0">{{ $user->unit_kerja ?? '-' }}</p>
                        </div>
                        @if($user->role === 'admin')
                            <span class="badge-indigo">Admin</span>
                        @elseif($user->role === 'driver')
                            <span class="badge-amber">Supir</span>
                        @else
                            <span class="badge-slate">User</span>
                        @endif
                    </div>
                    <div class="d-flex align-items-center gap-2 pt-2 border-top border-slate-100">
                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="flex-fill btn btn-sp-outline text-xs fw-600 text-center">
                            Edit
                        </a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="flex-fill"
                              onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn w-100 border border-slate-300 text-xs fw-600 text-danger bg-white">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="sp-card p-5 text-center text-slate-500 text-xs">
                    Tidak ada data user
                </div>
            @endforelse
            @if($users->hasPages())
                <div class="pt-2">{{ $users->links() }}</div>
            @endif
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

        // Realtime filter
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('users-filter-form');
            if (!form) return;
            let timer;

            function submitClean() {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    // Hapus param kosong dari URL
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
</x-app-layout>
