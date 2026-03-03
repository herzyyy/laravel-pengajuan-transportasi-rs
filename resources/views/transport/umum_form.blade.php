<x-app-layout>
    <div class="max-w-4xl mx-auto px-6 pt-8">
        <h1 class="text-xl font-semibold text-emerald-900">
            Form Pengajuan Mobil Umum
        </h1>
        <p class="text-sm text-emerald-800/90 mt-1">
            Lengkapi data berikut untuk pengajuan mobil umum Anda.
        </p>

        @if ($errors->any())
            <div class="mt-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                <div class="font-semibold mb-1">Periksa kembali data yang diisi:</div>
                <ul class="list-disc ml-4 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <form method="POST" action="{{ route('pengajuan.umum.store') }}"
        class="mt-6 max-w-4xl mx-auto px-6 space-y-6">
        @csrf

        <div class="bg-white rounded-2xl ring-1 ring-emerald-100 overflow-hidden">

            <div class="px-6 py-6 space-y-6">

                <!-- Unit Kerja & Unit Mobil (2 Columns) -->
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Unit Kerja -->
                    <div>
                        <label class="block text-sm font-medium text-emerald-900 mb-2">
                            Unit Kerja
                        </label>
                        <input value="{{ auth()->user()->unit_kerja ?? '-' }}" readonly
                            class="w-full rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
                        <p class="mt-1 text-xs text-emerald-800/70">
                            Otomatis sesuai dengan unit kerja Anda
                        </p>
                    </div>

                    <!-- Unit Mobil -->
                    <div>
                        <label class="block text-sm font-medium text-emerald-900 mb-2">
                            Unit Mobil
                        </label>
                        <select name="unit_mobil"
                            class="w-full rounded-xl border border-emerald-200 bg-white px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                            required>
                            <option value="" disabled selected>Pilih unit mobil yang tersedia</option>
                            @forelse($vehicles as $vehicle)
                                <option value="{{ $vehicle->name }}" @selected(old('unit_mobil') === $vehicle->name)>
                                    {{ $vehicle->name }}
                                    @if($vehicle->brand || $vehicle->model)
                                        - {{ $vehicle->brand }} {{ $vehicle->model }}
                                    @endif
                                    ({{ $vehicle->plate_number }})
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada kendaraan tersedia</option>
                            @endforelse
                        </select>
                        @error('unit_mobil')
                            <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                        <p class="mt-1 text-xs text-emerald-800/70">
                            Pilih kendaraan yang akan digunakan
                        </p>
                    </div>
                </div>

                <!-- Waktu Penggunaan -->
                <div class="rounded-xl border border-emerald-100 p-5 bg-emerald-50/40">
                    <div class="text-sm font-medium text-emerald-900 mb-4">
                        Waktu Penggunaan Mobil
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">

                        <!-- Dari -->
                        <div class="space-y-4">
                            <div class="text-xs font-semibold text-emerald-800 uppercase">
                                Dari
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs text-emerald-800 mb-1">Tanggal</label>
                                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                                        class="w-full rounded-lg border border-emerald-200 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        required>
                                </div>
                                <div>
                                    <label class="block text-xs text-emerald-800 mb-1">Jam</label>
                                    <input type="text" name="jam" value="{{ old('jam') }}" placeholder="00:00" pattern="^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" maxlength="5" inputmode="numeric"
                                        class="w-full rounded-lg border border-emerald-200 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Sampai -->
                        <div class="space-y-4">
                            <div class="text-xs font-semibold text-emerald-800 uppercase">
                                Sampai
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs text-emerald-800 mb-1">Tanggal</label>
                                    <input type="date" name="tanggal_sampai" value="{{ old('tanggal_sampai', date('Y-m-d')) }}"
                                        class="w-full rounded-lg border border-emerald-200 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        required>
                                </div>
                                <div>
                                    <label class="block text-xs text-emerald-800 mb-1">Jam</label>
                                    <input type="text" name="jam_sampai" value="{{ old('jam_sampai') }}" placeholder="00:00" pattern="^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" maxlength="5" inputmode="numeric"
                                        class="w-full rounded-lg border border-emerald-200 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        required>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-5 pt-4 border-t border-emerald-200 flex items-center gap-4">
                        <button id="checkAvailabilityBtn" type="button"
                            class="inline-flex items-center rounded-xl bg-emerald-600 text-white px-5 py-2 text-sm font-medium hover:bg-emerald-700 transition">
                            Cek Ketersediaan
                        </button>
                        <div id="availabilityStatus" class="text-sm font-medium"></div>
                    </div>
                </div>

                <!-- Prioritas (Tingkat Kebutuhan - 2 Columns) -->
                <div>
                    <label class="block text-sm font-medium text-emerald-900 mb-3">
                        Tingkat Kebutuhan
                    </label>

                    <div class="grid md:grid-cols-2 gap-4">

                        <label class="flex items-center gap-3 p-4 rounded-xl border border-emerald-100 bg-white hover:border-emerald-300 transition cursor-pointer">
                            <input type="radio" name="prioritas" value="biasa"
                                class="w-4 h-4 text-emerald-600 focus:ring-emerald-500"
                                @checked(old('prioritas') === 'biasa')>
                            <div class="flex-1">
                                <div class="text-sm font-medium text-emerald-900">Biasa</div>
                                <div class="text-xs text-emerald-800/70">Kebutuhan rutin / normal</div>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-4 rounded-xl border border-emerald-100 bg-white hover:border-red-400 transition cursor-pointer">
                            <input type="radio" name="prioritas" value="segera"
                                class="w-4 h-4 text-red-600 focus:ring-red-500"
                                @checked(old('prioritas') === 'segera')>
                            <div class="flex-1">
                                <div class="text-sm font-medium text-emerald-900">Segera</div>
                                <div class="text-xs text-emerald-800/70">Kebutuhan mendesak / urgent</div>
                            </div>
                        </label>

                    </div>
                </div>

                <!-- Alamat -->
                <div>
                    <label class="block text-sm font-medium text-emerald-900 mb-2">
                        Alamat / Lokasi Tujuan *
                    </label>
                    <textarea name="alamat_tujuan" rows="3"
                        class="w-full rounded-xl border border-emerald-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        required>{{ old('alamat_tujuan') }}</textarea>
                </div>

                <!-- Keperluan & Keterangan (2 Columns) -->
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Keperluan -->
                    <div>
                        <label class="block text-sm font-medium text-emerald-900 mb-2">
                            Keperluan *
                        </label>
                        <input name="keperluan" list="keperluan_list"
                            value="{{ old('keperluan') }}"
                            class="w-full rounded-xl border border-emerald-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            required>
                    </div>

                    <!-- Keterangan -->
                    <div>
                        <label class="block text-sm font-medium text-emerald-900 mb-2">
                            Keterangan Tambahan (Opsional)
                        </label>
                        <textarea name="keterangan" rows="2"
                            class="w-full rounded-xl border border-emerald-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('keterangan') }}</textarea>
                    </div>
                </div>

            </div>

            <!-- Action -->
            <div class="px-6 py-5 bg-emerald-50 border-t border-emerald-100 flex items-center gap-4">
                <button id="submitBtn" type="submit"
                    class="inline-flex items-center rounded-xl bg-emerald-600 text-white px-6 py-2.5 text-sm font-semibold hover:bg-emerald-700 transition">
                    Kirim Pengajuan
                </button>

                <a href="{{ route('dashboard') }}"
                    class="text-sm font-medium text-emerald-800 hover:underline">
                    ← Batal
                </a>
            </div>

        </div>
    </form>

    <script>
        (function(){
            const btn = document.getElementById('checkAvailabilityBtn');
            const statusEl = document.getElementById('availabilityStatus');
            const submitBtn = document.getElementById('submitBtn');

            if (!btn) return;

            async function check() {
                statusEl.textContent = 'Memeriksa…';
                statusEl.className = 'text-sm font-medium text-slate-600';

                const form = btn.closest('form');
                const unit = form.querySelector('select[name="unit_mobil"]').value;
                const tanggal = form.querySelector('input[name="tanggal"]').value;
                const jam = form.querySelector('input[name="jam"]').value;
                const tanggal_sampai = form.querySelector('input[name="tanggal_sampai"]').value;
                const jam_sampai = form.querySelector('input[name="jam_sampai"]').value;

                if (!unit || !tanggal || !jam || !tanggal_sampai || !jam_sampai) {
                    statusEl.textContent = 'Lengkapi semua kolom waktu dan unit terlebih dahulu.';
                    statusEl.className = 'text-sm font-medium text-amber-600';
                    return;
                }

                const url = new URL('{{ route('pengajuan.umum.check') }}', window.location.origin);
                url.searchParams.set('unit_mobil', unit);
                url.searchParams.set('tanggal', tanggal);
                url.searchParams.set('jam', jam);
                url.searchParams.set('tanggal_sampai', tanggal_sampai);
                url.searchParams.set('jam_sampai', jam_sampai);

                try {
                    const res = await fetch(url.toString(), { credentials: 'same-origin' });
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    const data = await res.json();

                    if (data.available) {
                        statusEl.textContent = '✓ Tersedia';
                        statusEl.className = 'text-sm font-semibold text-emerald-700';
                        if (submitBtn) submitBtn.disabled = false;
                    } else {
                        let msg = '✗ Tidak tersedia';
                        if (data.conflicts && data.conflicts.length > 0) {
                            const conflict = data.conflicts[0];
                            msg += ` - Bentrok dengan pengajuan ${conflict.jenis} (${conflict.status})`;
                        } else {
                            msg += ` (${data.conflicts_count || 0} konflik)`;
                        }
                        statusEl.textContent = msg;
                        statusEl.className = 'text-sm font-semibold text-red-600';
                        if (submitBtn) submitBtn.disabled = true;
                    }
                } catch (err) {
                    statusEl.textContent = '⚠ Terjadi kesalahan saat memeriksa.';
                    statusEl.className = 'text-sm font-medium text-red-600';
                    console.error('Availability check error:', err);
                }
            }

            btn.addEventListener('click', check);
        })();
        // auto-format and restrict time inputs to digits with fixed colon and valid 24h format
        document.addEventListener('DOMContentLoaded', function() {
            function setupTimeInput(el) {
                el.addEventListener('input', function() {
                    let v = el.value.replace(/[^0-9]/g, '');
                    if (v.length > 2) {
                        v = v.slice(0,2) + ':' + v.slice(2,4);
                    }
                    el.value = v;
                });
                el.addEventListener('blur', function() {
                    let v = el.value;
                    if (v.length === 4 && !v.includes(':')) {
                        v = v.slice(0,2) + ':' + v.slice(2,4);
                        el.value = v;
                    }
                    if (v.includes(':')) {
                        let parts = v.split(':');
                        let h = parseInt(parts[0]) || 0;
                        let m = parseInt(parts[1]) || 0;
                        if (h > 23) h = 23;
                        if (m > 59) m = 59;
                        el.value = (h < 10 ? '0'+h : h) + ':' + (m < 10 ? '0'+m : m);
                    }
                });
                el.addEventListener('keypress', function(e) {
                    if (!/[0-9]/.test(e.key)) e.preventDefault();
                });
            }
            ['jam','jam_sampai'].forEach(name => {
                const input = document.querySelector('input[name="'+name+'"]');
                if (input) setupTimeInput(input);
            });
        });    </script>
</x-app-layout>