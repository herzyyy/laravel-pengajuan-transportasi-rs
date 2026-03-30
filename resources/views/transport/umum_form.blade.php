<x-app-layout>
    <div class="space-y-2">
        <!-- Header -->
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-lg font-bold text-slate-900">
                    Form Pengajuan Mobil Umum
                </h1>
                <p class="text-[10px] text-slate-600 mt-0.5">
                    Lengkapi data untuk pengajuan mobil umum
                </p>
            </div>
            <a href="{{ route('dashboard') }}" 
               class="text-[10px] font-medium text-slate-600 hover:text-slate-900 transition">
                ← Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-2">
                <div class="flex items-start gap-2">
                    <svg class="w-3 h-3 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="font-semibold text-red-900 text-[10px] mb-0.5">Periksa kembali data yang diisi:</div>
                        <ul class="list-disc ml-3 space-y-0.5 text-[10px] text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <form method="POST" action="{{ route('pengajuan.umum.store') }}" class="mt-3 space-y-3">
        @csrf

        <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">

            <!-- Accent Bar -->
            <div class="h-1 bg-emerald-600"></div>

            <div class="p-3 space-y-3">

                <!-- Unit Kerja & Mobil (2 kolom) -->
                <div class="grid md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-700 mb-1">Unit Kerja</label>
                        <input value="{{ auth()->user()->unit_kerja ?? '-' }}" readonly
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 px-2 py-1.5 text-xs text-slate-700 font-medium">
                    </div>

                    <div>
                        <label class="block text-[10px] font-semibold text-slate-700 mb-1">Unit Mobil <span class="text-red-500">*</span></label>
                        <select name="unit_mobil" required
                            class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-xs focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="" disabled {{ count($vehicles) > 1 ? 'selected' : '' }}>Pilih mobil</option>
                            @forelse($vehicles as $vehicle)
                                <option value="{{ $vehicle->name }}" 
                                    @selected(old('unit_mobil') === $vehicle->name || (count($vehicles) === 1))>
                                    {{ $vehicle->name }} - {{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->plate_number }})
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada kendaraan tersedia</option>
                            @endforelse
                        </select>
                        @error('unit_mobil')
                            <div class="mt-0.5 text-[10px] text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Waktu Penggunaan (4 kolom dalam 1 baris) -->
                <div class="bg-slate-50 border border-slate-200 rounded-lg p-2">
                    <div class="text-xs font-semibold text-slate-900 mb-1.5">Waktu Penggunaan</div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-1">Tanggal Dari <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                                class="w-full rounded-lg border border-slate-300 px-2 py-1 text-xs focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-1">Jam Dari <span class="text-red-500">*</span></label>
                            <input type="text" name="jam" value="{{ old('jam') }}" placeholder="00:00" required
                                pattern="^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" maxlength="5" inputmode="numeric"
                                class="w-full rounded-lg border border-slate-300 px-2 py-1 text-xs focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-1">Tanggal Sampai <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_sampai" value="{{ old('tanggal_sampai', date('Y-m-d')) }}" required
                                class="w-full rounded-lg border border-slate-300 px-2 py-1 text-xs focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-1">Jam Sampai <span class="text-red-500">*</span></label>
                            <input type="text" name="jam_sampai" value="{{ old('jam_sampai') }}" placeholder="00:00" required
                                pattern="^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" maxlength="5" inputmode="numeric"
                                class="w-full rounded-lg border border-slate-300 px-2 py-1 text-xs focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>
                    <div class="mt-2 flex items-center gap-2">
                        <button id="checkAvailabilityBtn" type="button"
                            class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 text-[10px] font-semibold transition">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Cek Ketersediaan
                        </button>
                        <div id="availabilityStatus" class="text-[10px] font-semibold"></div>
                    </div>
                </div>

                <!-- Prioritas & Alamat Tujuan (2 kolom) -->
                <div class="grid md:grid-cols-2 gap-3">
                    <!-- Prioritas -->
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-700 mb-1">Tingkat Kebutuhan <span class="text-red-500">*</span></label>
                        <div class="space-y-1.5">
                            <label class="flex items-center gap-2 p-1.5 rounded-lg border-2 border-slate-200 hover:border-cyan-400 hover:bg-cyan-50 transition cursor-pointer">
                                <input type="radio" name="prioritas" value="biasa" class="w-3 h-3 text-cyan-600"
                                    @checked(old('prioritas') === 'biasa')>
                                <div class="flex-1">
                                    <div class="font-semibold text-[10px] text-slate-900">Biasa</div>
                                    <div class="text-[9px] text-slate-600">Kebutuhan rutin / normal</div>
                                </div>
                                <span class="text-[9px] px-1.5 py-0.5 bg-cyan-100 text-cyan-700 rounded-full font-bold">NORMAL</span>
                            </label>

                            <label class="flex items-center gap-2 p-1.5 rounded-lg border-2 border-slate-200 hover:border-red-400 hover:bg-red-50 transition cursor-pointer">
                                <input type="radio" name="prioritas" value="segera" class="w-3 h-3 text-red-600"
                                    @checked(old('prioritas') === 'segera')>
                                <div class="flex-1">
                                    <div class="font-semibold text-[10px] text-slate-900">Segera</div>
                                    <div class="text-[9px] text-slate-600">Kebutuhan mendesak / urgent</div>
                                </div>
                                <span class="text-[9px] px-1.5 py-0.5 bg-red-100 text-red-700 rounded-full font-bold">URGENT</span>
                            </label>
                        </div>
                    </div>

                    <!-- Alamat Tujuan -->
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-700 mb-1">Alamat Tujuan <span class="text-red-500">*</span></label>
                        <textarea name="alamat_tujuan" rows="4" required
                            class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-xs focus:ring-2 focus:ring-emerald-500"
                            placeholder="Alamat lengkap lokasi tujuan">{{ old('alamat_tujuan') }}</textarea>
                    </div>
                </div>

                <!-- Keperluan & Keterangan (2 kolom) -->
                <div class="grid md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-700 mb-1">Keperluan <span class="text-red-500">*</span></label>
                        <input name="keperluan" list="keperluan_list" required
                            value="{{ old('keperluan') }}"
                            class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-xs focus:ring-2 focus:ring-emerald-500"
                            placeholder="Contoh: Ambil obat, Antar dokumen">
                    </div>

                    <div>
                        <label class="block text-[10px] font-semibold text-slate-700 mb-1">Keterangan Tambahan</label>
                        <input name="keterangan"
                            value="{{ old('keterangan') }}"
                            class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-xs focus:ring-2 focus:ring-emerald-500"
                            placeholder="Keterangan tambahan (opsional)">
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="px-3 py-2 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
                <a href="{{ route('dashboard') }}"
                    class="text-[10px] font-medium text-slate-600 hover:text-slate-900 transition">
                    ← Kembali
                </a>
                <button id="submitBtn" type="submit"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 hover:shadow-lg text-white px-4 py-2 text-xs font-semibold transition">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                    </svg>
                    Kirim Pengajuan
                </button>
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
                statusEl.className = 'text-[10px] font-semibold text-slate-600';

                const form = btn.closest('form');
                const unit = form.querySelector('select[name="unit_mobil"]').value;
                const tanggal = form.querySelector('input[name="tanggal"]').value;
                const jam = form.querySelector('input[name="jam"]').value;
                const tanggal_sampai = form.querySelector('input[name="tanggal_sampai"]').value;
                const jam_sampai = form.querySelector('input[name="jam_sampai"]').value;

                if (!unit || !tanggal || !jam || !tanggal_sampai || !jam_sampai) {
                    statusEl.textContent = 'Lengkapi semua kolom terlebih dahulu';
                    statusEl.className = 'text-[10px] font-semibold text-amber-600';
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
                        statusEl.className = 'text-[10px] font-semibold text-emerald-600';
                        if (submitBtn) submitBtn.disabled = false;
                    } else {
                        let msg = '✗ Tidak tersedia';
                        if (data.conflicts && data.conflicts.length > 0) {
                            const conflict = data.conflicts[0];
                            msg += ` - Bentrok dengan ${conflict.jenis} (${conflict.status})`;
                        }
                        statusEl.textContent = msg;
                        statusEl.className = 'text-[10px] font-semibold text-red-600';
                        if (submitBtn) submitBtn.disabled = true;
                    }
                } catch (err) {
                    statusEl.textContent = '⚠ Terjadi kesalahan';
                    statusEl.className = 'text-[10px] font-semibold text-red-600';
                }
            }

            btn.addEventListener('click', check);
        })();

        document.addEventListener('DOMContentLoaded', function() {
            function setupTimeInput(el) {
                el.addEventListener('input', function() {
                    let v = el.value.replace(/[^0-9]/g, '');
                    if (v.length > 2) v = v.slice(0,2) + ':' + v.slice(2,4);
                    el.value = v;
                });
                el.addEventListener('blur', function() {
                    let v = el.value;
                    if (v.length === 4 && !v.includes(':')) v = v.slice(0,2) + ':' + v.slice(2,4);
                    if (v.includes(':')) {
                        let parts = v.split(':');
                        let h = Math.min(parseInt(parts[0]) || 0, 23);
                        let m = Math.min(parseInt(parts[1]) || 0, 59);
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
        });
    </script>
</x-app-layout>
