<x-app-layout title="Pengajuan Umum — SIPETRANS">
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

    <form method="POST" action="{{ route('pengajuan.umum.store') }}" class="mt-3 space-y-3" id="umumForm">
        @csrf

        <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">

            <!-- Accent Bar -->
            <div class="h-1 bg-emerald-600"></div>

            <div class="p-3 space-y-3">

                <!-- Unit Kerja -->
                <div>
                    <label class="block text-[10px] font-semibold text-slate-700 mb-1">Unit Kerja</label>
                    <input value="{{ auth()->user()->unit_kerja ?? '-' }}" readonly
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-2 py-1.5 text-xs text-slate-700 font-medium">
                </div>

                <!-- Waktu Penggunaan (4 kolom dalam 1 baris) -->
                <div class="bg-slate-50 border border-slate-200 rounded-lg p-2" x-data="{ sampaiSelesai: {{ old('sampai_selesai') ? 'true' : 'false' }}, isRecurring: {{ old('is_recurring') ? 'true' : 'false' }} }">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-1.5 gap-2">
                        <div class="text-xs font-semibold text-slate-900">Waktu Penggunaan & Pengulangan</div>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer select-none">
                                <input type="checkbox" name="is_recurring" value="1" x-model="isRecurring"
                                    class="w-3.5 h-3.5 rounded text-indigo-600 cursor-pointer"
                                    @change="if($event.target.checked && !confirm('Koordinasikan dengan pengelola transportasi jika ingin membuat pengajuan berulang. Lanjutkan?')) { isRecurring = false; setTimeout(() => $event.target.dispatchEvent(new Event('change')), 10); }"
                                    {{ old('is_recurring') ? 'checked' : '' }}>
                                <span class="text-[10px] font-semibold text-indigo-700">Pengajuan Berulang</span>
                            </label>
                            
                            <label class="flex items-center gap-1.5 cursor-pointer select-none">
                                <input type="checkbox" name="sampai_selesai" value="1" x-model="sampaiSelesai"
                                    class="w-3.5 h-3.5 rounded text-teal-600 cursor-pointer"
                                    {{ old('sampai_selesai') ? 'checked' : '' }}>
                                <span class="text-[10px] font-semibold text-slate-700">Sampai Selesai</span>
                                <span class="text-[9px] text-slate-500">(seharian penuh)</span>
                            </label>
                        </div>
                    </div>
                    <div class="grid gap-2 grid-cols-2" :class="sampaiSelesai ? 'sm:grid-cols-2' : (isRecurring ? 'sm:grid-cols-2' : 'sm:grid-cols-4')">
                        <div x-show="!isRecurring">
                            <label class="block text-[10px] font-semibold text-slate-600 mb-1">Tanggal Dari <span class="text-red-500">*</span></label>
                            <input type="text" id="tanggal_display" placeholder="dd/mm/yyyy" autocomplete="off"
                                class="w-full rounded-lg border border-slate-300 px-2 py-1 text-xs focus:ring-2 focus:ring-slate-300 cursor-pointer">
                            <input type="hidden" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-1">Jam Dari <span class="text-red-500">*</span></label>
                            <input type="text" name="jam" value="{{ old('jam') }}" placeholder="00:00" required
                                pattern="^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" maxlength="5" inputmode="numeric"
                                class="w-full rounded-lg border border-slate-300 px-2 py-1 text-xs focus:ring-2 focus:ring-slate-300">
                        </div>
                        <div x-show="!sampaiSelesai && !isRecurring">
                            <label class="block text-[10px] font-semibold text-slate-600 mb-1">Tanggal Sampai <span class="text-red-500">*</span></label>
                            <input type="text" id="tanggal_sampai_display" placeholder="dd/mm/yyyy" autocomplete="off"
                                class="w-full rounded-lg border border-slate-300 px-2 py-1 text-xs focus:ring-2 focus:ring-slate-300 cursor-pointer">
                            <input type="hidden" name="tanggal_sampai" id="tanggal_sampai" value="{{ old('tanggal_sampai', date('Y-m-d')) }}">
                        </div>
                        <div x-show="!sampaiSelesai">
                            <label class="block text-[10px] font-semibold text-slate-600 mb-1">Jam Sampai <span class="text-red-500">*</span></label>
                            <input type="text" name="jam_sampai" value="{{ old('jam_sampai') }}" placeholder="00:00"
                                pattern="^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" maxlength="5" inputmode="numeric"
                                class="w-full rounded-lg border border-slate-300 px-2 py-1 text-xs focus:ring-2 focus:ring-slate-300">
                        </div>
                    </div>

                    <!-- Info sampai selesai -->
                    <div x-show="sampaiSelesai" class="mt-2 flex items-center gap-1.5 text-[10px] text-teal-700 bg-teal-50 border border-teal-200 rounded-lg px-2 py-1.5">
                        <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Waktu selesai akan dicatat otomatis saat kendaraan kembali
                    </div>

                    <!-- Form Pengulangan -->
                    <div x-show="isRecurring" class="mt-3 pt-3 border-t border-slate-200 space-y-3" style="display: none;">
                        <h4 class="text-[10px] font-semibold text-indigo-800 flex items-center gap-1.5">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Pengaturan Pengajuan Berulang
                        </h4>
                        
                        <div class="mb-3">
                            <label class="block text-[10px] font-semibold text-slate-600 mb-1.5">Pilih Hari <span class="text-red-500">*</span></label>
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $days = [
                                        1 => 'Senin',
                                        2 => 'Selasa',
                                        3 => 'Rabu',
                                        4 => 'Kamis',
                                        5 => 'Jumat',
                                        6 => 'Sabtu',
                                        7 => 'Minggu'
                                    ];
                                    $oldDays = old('recurring_hari', []);
                                @endphp
                                @foreach($days as $num => $day)
                                    <label class="flex items-center gap-1.5 cursor-pointer bg-white border border-slate-200 px-2 py-1 rounded-md hover:bg-slate-50">
                                        <input type="checkbox" name="recurring_hari[]" value="{{ $num }}" 
                                            class="w-3 h-3 rounded text-indigo-600 cursor-pointer"
                                            {{ in_array($num, $oldDays) ? 'checked' : '' }}>
                                        <span class="text-[10px] text-slate-700 font-medium">{{ $day }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Tombol cek ketersediaan -->
                    <div class="mt-2 flex items-center gap-2">
                        <button id="checkAvailabilityBtn" type="button" x-show="!isRecurring"
                            class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 text-[10px] font-semibold transition">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
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
                            class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-xs focus:ring-2 focus:ring-slate-300"
                            placeholder="Alamat lengkap lokasi tujuan">{{ old('alamat_tujuan') }}</textarea>
                    </div>
                </div>

                <!-- Keperluan & Keterangan (2 kolom) -->
                <div class="grid md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-700 mb-1">Keperluan <span class="text-red-500">*</span></label>
                        <input name="keperluan" list="keperluan_list" required
                            value="{{ old('keperluan') }}"
                            class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-xs focus:ring-2 focus:ring-slate-300"
                            placeholder="Pilih atau ketik keperluan...">
                        <datalist id="keperluan_list">
                            <option value="PEMBELIAN DAN PENGAMBILAN OBAT">
                            <option value="PERMINTAAN DARAH">
                            <option value="PENGANTARAN DAN PENGAMBILAN HASIL PA">
                            <option value="PENGAMBILAN ALAT INSTRUMEN OK">
                            <option value="BACA HASIL RONTGEN RADIOLOGI">
                            <option value="PEMERIKSAAN KULTUR">
                            <option value="PEMERIKSAAN ABSTRUB">
                            <option value="CEK KMB">
                            <option value="RS">
                        </datalist>
                    </div>

                    <div>
                        <label class="block text-[10px] font-semibold text-slate-700 mb-1">Keterangan Tambahan</label>
                        <input name="keterangan"
                            value="{{ old('keterangan') }}"
                            class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-xs focus:ring-2 focus:ring-slate-300"
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
                <button id="submitBtn" type="submit" disabled
                    class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 hover:shadow-lg text-white px-4 py-2 text-xs font-semibold transition disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:shadow-none">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                    </svg>
                    <span id="submitBtnText">Kirim Pengajuan</span>
                </button>
            </div>
        </div>
    </form>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        (function(){
            const btn = document.getElementById('checkAvailabilityBtn');
            const statusEl = document.getElementById('availabilityStatus');
            const submitBtn = document.getElementById('submitBtn');

            if (!btn) return;

            function isSampaiSelesai() {
                const cb = document.querySelector('input[name="sampai_selesai"]');
                return cb && cb.checked;
            }

            function resetCheck() {
                const cbRecurring = document.querySelector('input[name="is_recurring"]');
                if (cbRecurring && cbRecurring.checked) {
                    submitBtn.disabled = false;
                    statusEl.textContent = 'Jadwal berulang tidak memerlukan cek ketersediaan';
                    statusEl.className = 'text-[10px] font-semibold text-indigo-600';
                } else {
                    submitBtn.disabled = true;
                    statusEl.textContent = 'Cek ketersediaan diperlukan';
                    statusEl.className = 'text-[10px] font-semibold text-amber-600';
                }
            }

            const form = btn.closest('form');
            ['tanggal', 'jam', 'tanggal_sampai', 'jam_sampai'].forEach(name => {
                const el = form.querySelector(`[name="${name}"]`);
                if (el) { el.addEventListener('change', resetCheck); el.addEventListener('input', resetCheck); }
            });
            const cbSampaiSelesai = form.querySelector('input[name="sampai_selesai"]');
            if (cbSampaiSelesai) cbSampaiSelesai.addEventListener('change', resetCheck);
            
            const cbRecurring = form.querySelector('input[name="is_recurring"]');
            if (cbRecurring) cbRecurring.addEventListener('change', resetCheck);

            btn.addEventListener('click', async function() {
                const tanggal = form.querySelector('input[name="tanggal"]').value;
                const jam = form.querySelector('input[name="jam"]').value;

                // Jika sampai selesai: gunakan tanggal yang sama dengan jam 23:59
                const sampaiSelesai = isSampaiSelesai();
                const tanggal_sampai = sampaiSelesai ? tanggal : form.querySelector('input[name="tanggal_sampai"]').value;
                const jam_sampai = sampaiSelesai ? '23:59' : form.querySelector('input[name="jam_sampai"]').value;

                if (!tanggal || !jam || !tanggal_sampai || !jam_sampai) {
                    statusEl.textContent = 'Lengkapi tanggal dan jam terlebih dahulu';
                    statusEl.className = 'text-[10px] font-semibold text-amber-600';
                    return;
                }

                statusEl.textContent = 'Memeriksa…';
                statusEl.className = 'text-[10px] font-semibold text-slate-600';

                const url = new URL('{{ route('pengajuan.umum.check') }}', window.location.origin);
                url.searchParams.set('tanggal', tanggal);
                url.searchParams.set('jam', jam);
                url.searchParams.set('tanggal_sampai', tanggal_sampai);
                url.searchParams.set('jam_sampai', jam_sampai);

                try {
                    const res = await fetch(url.toString(), { credentials: 'same-origin' });
                    const data = await res.json();
                    if (data.available) {
                        statusEl.textContent = `✓ Tersedia (${data.available_units} dari ${data.total_units} unit)`;
                        statusEl.className = 'text-[10px] font-semibold text-emerald-600';
                        submitBtn.disabled = false;
                    } else {
                        statusEl.textContent = `✗ Tidak tersedia di waktu tersebut (${data.available_units} dari ${data.total_units})`;
                        statusEl.className = 'text-[10px] font-semibold text-red-600';
                        submitBtn.disabled = true;
                    }
                } catch (err) {
                    statusEl.textContent = '⚠ Terjadi kesalahan';
                    statusEl.className = 'text-[10px] font-semibold text-red-600';
                }
            });

            resetCheck();
        })();

        function initFlatpickr() {
            if (typeof flatpickr === 'undefined') {
                setTimeout(initFlatpickr, 50);
                return;
            }
            const today = new Date();
            const fpConfig = {
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'd/m/Y',
                allowInput: false,
                minDate: 'today',
                locale: { firstDayOfWeek: 1 },
            };
            flatpickr('#tanggal_display', {
                ...fpConfig,
                defaultDate: document.getElementById('tanggal').value || today,
                onChange: function(selectedDates, dateStr) {
                    const hidden = document.getElementById('tanggal');
                    hidden.value = dateStr;
                    hidden.dispatchEvent(new Event('change'));
                    // Jika tanggal sampai lebih awal dari tanggal dipilih, reset
                    const fpSampai = document.getElementById('tanggal_sampai_display')._flatpickr;
                    if (fpSampai) fpSampai.set('minDate', dateStr);
                }
            });
            flatpickr('#tanggal_sampai_display', {
                ...fpConfig,
                defaultDate: document.getElementById('tanggal_sampai').value || today,
                onChange: function(selectedDates, dateStr) {
                    const hidden = document.getElementById('tanggal_sampai');
                    hidden.value = dateStr;
                    hidden.dispatchEvent(new Event('change'));
                }
            });
        }

        // Anti double-submit
        document.getElementById('umumForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('submitBtn');
            if (btn.dataset.submitted === '1') {
                e.preventDefault();
                return;
            }
            btn.dataset.submitted = '1';
            btn.disabled = true;
            document.getElementById('submitBtnText').textContent = 'Mengirim…';
        });

        document.addEventListener('DOMContentLoaded', function() {
            initFlatpickr();

            // Kembalikan jam minimal berdasarkan apakah tanggal = hari ini
            function getMinJam(tanggalValue) {
                const today = new Date();
                const todayStr = today.toISOString().slice(0, 10);
                if (tanggalValue === todayStr) {
                    const h = String(today.getHours()).padStart(2, '0');
                    const m = String(today.getMinutes()).padStart(2, '0');
                    return h + ':' + m;
                }
                return null;
            }

            function enforceMinJam(jamInput, tanggalHiddenId) {
                const tanggalHidden = document.getElementById(tanggalHiddenId);
                jamInput.addEventListener('blur', function() {
                    const cbRecurring = document.querySelector('input[name="is_recurring"]');
                    const isRec = cbRecurring && cbRecurring.checked;
                    
                    const minJam = getMinJam(tanggalHidden ? tanggalHidden.value : '');
                    if (!isRec && minJam && jamInput.value && jamInput.value < minJam) {
                        showJamError(jamInput, 'Jam tidak boleh kurang dari jam sekarang');
                        return;
                    } else {
                        clearJamError(jamInput);
                    }

                    // Validasi jam_sampai tidak boleh <= jam jika tanggal sama
                    if (jamInput.name === 'jam_sampai') {
                        const jamDari = document.querySelector('input[name="jam"]');
                        const tanggalDari = document.getElementById('tanggal');
                        const tanggalSampai = document.getElementById('tanggal_sampai');
                        if (jamDari && tanggalDari && tanggalSampai &&
                            tanggalDari.value === tanggalSampai.value &&
                            jamInput.value && jamDari.value &&
                            jamInput.value <= jamDari.value) {
                            showJamError(jamInput, 'Jam sampai harus lebih besar dari jam dari');
                        } else {
                            clearJamError(jamInput);
                        }
                    }
                });

                // Hapus error saat user mulai mengetik ulang
                jamInput.addEventListener('input', function() {
                    clearJamError(jamInput);
                });
            }

            function showJamError(input, msg) {
                clearJamError(input);
                input.classList.add('border-red-400');
                const err = document.createElement('p');
                err.className = 'jam-error-msg mt-1 text-[10px] text-red-600';
                err.textContent = msg;
                input.parentNode.appendChild(err);
                updateCheckBtn();
            }

            function clearJamError(input) {
                input.classList.remove('border-red-400');
                const existing = input.parentNode.querySelector('.jam-error-msg');
                if (existing) existing.remove();
                updateCheckBtn();
            }

            function updateCheckBtn() {
                const hasError = document.querySelectorAll('.jam-error-msg').length > 0;
                const checkBtn = document.getElementById('checkAvailabilityBtn');
                if (checkBtn) checkBtn.disabled = hasError;
                
                const cbRecurring = document.querySelector('input[name="is_recurring"]');
                if (cbRecurring && cbRecurring.checked) {
                    const submitBtn = document.getElementById('submitBtn');
                    if (submitBtn) submitBtn.disabled = hasError;
                }
            }

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
                if (input) {
                    setupTimeInput(input);
                    const tanggalId = name === 'jam' ? 'tanggal' : 'tanggal_sampai';
                    enforceMinJam(input, tanggalId);
                }
            });
        });
    </script>
</x-app-layout>

