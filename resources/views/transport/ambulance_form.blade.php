<x-app-layout>
    <div class="space-y-3">
        <h1 class="text-3xl font-bold tracking-tight text-slate-800">
            Form Pengajuan Ambulance
        </h1>
        <p class="text-slate-500 leading-relaxed max-w-2xl">
            Pilih apakah ambulance untuk 
            <span class="font-semibold text-emerald-600">antar</span> atau 
            <span class="font-semibold text-teal-600">jemput</span> pasien,
            kemudian lengkapi semua data yang diperlukan.
        </p>
    </div>

    <form method="POST" action="{{ route('pengajuan.ambulance.store') }}" class="mt-10 space-y-8">
        @csrf

        <div class="bg-white rounded-3xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            
            <!-- Top Accent -->
            <div class="h-1.5 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500"></div>

            <div class="px-8 py-8 space-y-8">

                <div class="grid md:grid-cols-2 gap-4 items-start">
                    <!-- Unit Kerja -->
                    <div class="bg-emerald-50/70 border border-emerald-100 rounded-xl p-5">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Unit Kerja
                        </label>
                        <input value="{{ auth()->user()->unit_kerja ?? '-' }}" readonly
                            class="w-full rounded-xl border border-emerald-200 px-4 py-2.5 bg-white text-slate-700 font-medium shadow-sm">
                        <p class="mt-2 text-xs text-slate-500">
                            Otomatis sesuai dengan unit kerja Anda
                        </p>
                    </div>

                    <!-- Unit Mobil -->
                    <div class="bg-emerald-50/70 border border-emerald-100 rounded-xl p-5">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Unit Mobil
                        </label>
                        <input type="text" value="Ambulans" readonly
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 bg-white text-slate-700 font-medium shadow-sm">
                        <!-- hidden field to ensure value submitted -->
                        <input type="hidden" name="unit_mobil" value="ambulans">
                    </div>
                </div>

                <!-- Jenis Layanan (Antar/Jemput) -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-4">
                        Jenis Layanan
                    </label>
                    <div class="grid md:grid-cols-2 gap-4">
                        <label class="flex items-center gap-4 p-4 rounded-xl border border-slate-200 hover:border-emerald-400 hover:bg-emerald-50 transition cursor-pointer">
                            <input type="radio" name="purpose" value="antar" class="w-4 h-4"
                                @checked(old('purpose') === 'antar')
                                onchange="updateAlamatForm('antar')">
                            <div class="flex-1">
                                <div class="font-medium text-slate-800">Antar Pasien</div>
                                <div class="text-xs text-slate-500">Dari RS ke lokasi tujuan</div>
                            </div>
                        </label>

                        <label class="flex items-center gap-4 p-4 rounded-xl border border-slate-200 hover:border-emerald-400 hover:bg-emerald-50 transition cursor-pointer">
                            <input type="radio" name="purpose" value="jemput" class="w-4 h-4"
                                @checked(old('purpose') === 'jemput')
                                onchange="updateAlamatForm('jemput')">
                            <div class="flex-1">
                                <div class="font-medium text-slate-800">Jemput Pasien</div>
                                <div class="text-xs text-slate-500">Dari lokasi asal ke RS</div>
                            </div>
                        </label>
                    </div>
                    @error('purpose')
                        <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Waktu Penggunaan -->
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-100 rounded-2xl p-6">
                    <div class="text-sm font-semibold text-slate-800 mb-5">
                        Waktu Penggunaan Ambulance
                    </div>

                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Dari -->
                        <div>
                            <div class="text-xs font-semibold text-slate-500 uppercase mb-3">
                                Dari
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <input type="date" name="tanggal" required value="{{ old('tanggal', date('Y-m-d')) }}"
                                    class="rounded-xl border border-slate-300 px-3 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-emerald-400">
                                <input type="text" name="jam" placeholder="00:00" required
                                    pattern="^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" maxlength="5" inputmode="numeric"
                                    class="rounded-xl border border-slate-300 px-3 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-emerald-400">
                            </div>
                        </div>

                        <!-- Sampai -->
                        <div>
                            <div class="text-xs font-semibold text-slate-500 uppercase mb-3">
                                Sampai
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <input type="date" name="tanggal_sampai" required value="{{ old('tanggal_sampai', date('Y-m-d')) }}"
                                    class="rounded-xl border border-slate-300 px-3 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-emerald-400">
                                <input type="text" name="jam_sampai" placeholder="00:00" required
                                    pattern="^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" maxlength="5" inputmode="numeric"
                                    class="rounded-xl border border-slate-300 px-3 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-emerald-400">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-4">
                        <button id="checkAmbulanceAvailabilityBtn" type="button"
                            class="inline-flex items-center rounded-xl 
                                   bg-gradient-to-r from-emerald-600 to-teal-600 
                                   text-white px-5 py-2.5 text-sm font-medium 
                                   hover:shadow-lg transition">
                            Cek Ketersediaan
                        </button>
                        <div id="ambulanceAvailabilityStatus" class="text-sm font-medium"></div>
                    </div>
                </div>

                <!-- Alamat Tujuan / Asal (Dynamic) -->
                <div id="alamatSection">
                    <!-- Antar: Alamat Tujuan -->
                    <div id="alamatTujuanDiv" style="display: none;">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Alamat / Lokasi Tujuan
                        </label>
                        <textarea name="alamat_tujuan" rows="3"
                            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 shadow-sm"
                            placeholder="Alamat lengkap lokasi tujuan pengiriman pasien">{{ old('alamat_tujuan') }}</textarea>
                        @error('alamat_tujuan')
                            <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jemput: Alamat Asal -->
                    <div id="alamatAsalDiv" style="display: none;">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Alamat / Lokasi Asal (Jemput)
                        </label>
                        <textarea name="alamat_asal" rows="3"
                            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 shadow-sm"
                            placeholder="Alamat lengkap lokasi awal untuk menjemput pasien">{{ old('alamat_asal') }}</textarea>
                        @error('alamat_asal')
                            <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Prioritas -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-4">
                        Tingkat Kebutuhan
                    </label>
                    <div class="grid md:grid-cols-2 gap-4">
                        <label class="flex items-center gap-4 p-4 rounded-xl border border-slate-200 hover:border-red-400 hover:bg-red-50 transition cursor-pointer">
                            <input type="radio" name="prioritas" value="segera" class="w-4 h-4" @checked(old('prioritas') === 'segera')>
                            <div class="flex-1">
                                <div class="font-medium text-slate-800">Cito / Segera</div>
                                <div class="text-xs text-slate-500">Emergency</div>
                            </div>
                            <span class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded-full font-semibold">
                                URGENT
                            </span>
                        </label>

                        <label class="flex items-center gap-4 p-4 rounded-xl border border-slate-200 hover:border-emerald-400 hover:bg-emerald-50 transition cursor-pointer">
                            <input type="radio" name="prioritas" value="biasa" class="w-4 h-4" @checked(old('prioritas') === 'biasa')>
                            <div class="flex-1">
                                <div class="font-medium text-slate-800">Biasa</div>
                                <div class="text-xs text-slate-500">Normal</div>
                            </div>
                            <span class="text-xs px-2 py-1 bg-slate-100 text-slate-600 rounded-full font-semibold">
                                NORMAL
                            </span>
                        </label>
                    </div>
                    @error('prioritas')
                        <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Identitas -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6">
                    <div class="text-sm font-semibold text-slate-800 mb-4">
                        Identitas Pasien
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <input name="pasien_no_rm"
                            class="rounded-xl border border-slate-300 px-4 py-2.5 shadow-sm"
                            placeholder="No. Rekam Medis (Opsional)"
                            value="{{ old('pasien_no_rm') }}">
                        <input name="pasien_nama" required
                            class="rounded-xl border border-slate-300 px-4 py-2.5 shadow-sm font-medium"
                            placeholder="Nama Pasien"
                            value="{{ old('pasien_nama') }}">
                    </div>

                    <textarea name="alamat_pasien" rows="2" required
                        class="mt-4 w-full rounded-xl border border-slate-300 px-4 py-2.5 shadow-sm"
                        placeholder="Alamat lengkap pasien">{{ old('alamat_pasien') }}</textarea>

                    @error('pasien_nama')
                        <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                    @error('alamat_pasien')
                        <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <!-- Footer Action -->
            <div class="px-8 py-6 bg-slate-50 border-t border-slate-200 flex items-center gap-4">
                <button id="submitAmbulanceBtn" type="submit"
                    class="inline-flex items-center rounded-xl 
                           bg-gradient-to-r from-emerald-600 to-teal-600 
                           text-white px-6 py-2.5 font-medium 
                           hover:shadow-xl transition">
                    Kirim Pengajuan
                </button>

                <a href="{{ route('pengajuan.choose') }}"
                    class="text-sm font-medium text-slate-600 hover:text-slate-800 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </form>

    <script>
        // Handle alamat form visibility based on purpose
        function updateAlamatForm(purpose) {
            const alamatSection = document.getElementById('alamatSection');
            const alamatTujuanDiv = document.getElementById('alamatTujuanDiv');
            const alamatAsalDiv = document.getElementById('alamatAsalDiv');
            
            if (purpose === 'antar') {
                alamatTujuanDiv.style.display = 'block';
                alamatAsalDiv.style.display = 'none';
            } else if (purpose === 'jemput') {
                alamatTujuanDiv.style.display = 'none';
                alamatAsalDiv.style.display = 'block';
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const purpose = document.querySelector('input[name="purpose"]:checked');
            if (purpose) {
                updateAlamatForm(purpose.value);
            }
        });

        (function(){
            const btn = document.getElementById('checkAmbulanceAvailabilityBtn');
            const statusEl = document.getElementById('ambulanceAvailabilityStatus');
            const submitBtn = document.getElementById('submitAmbulanceBtn');

            if (!btn) return;

            async function check() {
                statusEl.textContent = 'Memeriksa…';
                statusEl.className = 'text-sm font-medium text-slate-600';

                const form = btn.closest('form');
                // unit_mobil is now a readonly input instead of a select
                const unit = form.querySelector('input[name="unit_mobil"]').value;
                const tanggal = form.querySelector('input[name="tanggal"]').value;
                const jam = form.querySelector('input[name="jam"]').value;
                const tanggal_sampai = form.querySelector('input[name="tanggal_sampai"]').value;
                const jam_sampai = form.querySelector('input[name="jam_sampai"]').value;

                if (!unit || !tanggal || !jam || !tanggal_sampai || !jam_sampai) {
                    statusEl.textContent = 'Lengkapi semua kolom waktu dan unit terlebih dahulu.';
                    statusEl.className = 'text-sm font-medium text-amber-600';
                    return;
                }

                const url = new URL('{{ route('pengajuan.ambulance.check') }}', window.location.origin);
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
                        statusEl.textContent = 'Tersedia';
                        statusEl.className = 'text-sm font-semibold text-emerald-700';
                        if (submitBtn) submitBtn.disabled = false;
                    } else {
                        statusEl.textContent = 'Tidak tersedia (' + (data.conflicts_count || 0) + ' konflik)';
                        statusEl.className = 'text-sm font-semibold text-red-600';
                        if (submitBtn) submitBtn.disabled = true;
                    }
                } catch (err) {
                    statusEl.textContent = 'Terjadi kesalahan saat memeriksa.';
                    statusEl.className = 'text-sm font-medium text-red-600';
                }
            }

            btn.addEventListener('click', check);
        })();

        // auto-format and restrict time fields to digits with fixed colon and valid 24h format
        document.addEventListener('DOMContentLoaded', function() {
            function setupTimeInput(el) {
                el.addEventListener('input', function(e) {
                    // remove non-digits
                    let v = el.value.replace(/[^0-9]/g, '');
                    if (v.length > 2) {
                        v = v.slice(0,2) + ':' + v.slice(2,4);
                    }
                    el.value = v;
                });
                el.addEventListener('blur', function(e) {
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
                    // allow only digits
                    if (!/[0-9]/.test(e.key)) {
                        e.preventDefault();
                    }
                });
            }

            ['jam','jam_sampai'].forEach(name => {
                const input = document.querySelector('input[name="'+name+'"]');
                if (input) setupTimeInput(input);
            });
        });
    </script>
</x-app-layout>