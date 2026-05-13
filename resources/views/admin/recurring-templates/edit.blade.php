<x-app-layout title="Edit Template Pengajuan Berulang — SIPETRANS">
    <div class="max-w-2xl mx-auto px-4 py-6">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('admin.recurring-templates.index') }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-slate-800">Edit Template Berulang</h1>
                <p class="text-sm text-slate-500">Ubah jadwal atau status pengajuan otomatis</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                <ul class="list-disc ml-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="p-4 sm:p-6 border-b border-slate-100 bg-slate-50/50">
                <div class="space-y-1">
                    <div class="text-xs text-slate-500">Pemohon: <span class="font-semibold text-slate-700">{{ $recurring_template->pemohon_nama }}</span> ({{ $recurring_template->pemohon_unit }})</div>
                    <div class="text-xs text-slate-500">Jenis: <span class="font-semibold text-slate-700">{{ ucfirst($recurring_template->jenis) }}</span> — {{ $recurring_template->keperluan }}</div>
                    <div class="text-xs text-slate-500">Waktu: <span class="font-semibold text-slate-700" id="preview-waktu">{{ substr($recurring_template->jam, 0, 5) }} {{ $recurring_template->jam_sampai ? '- '.substr($recurring_template->jam_sampai, 0, 5) : '- Selesai' }}</span></div>
                </div>
            </div>

            <form action="{{ route('admin.recurring-templates.update', $recurring_template) }}" method="POST" class="p-4 sm:p-6 space-y-5" x-data="{ sampaiSelesai: {{ $recurring_template->jam_sampai ? 'false' : 'true' }} }">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Jam Berangkat <span class="text-red-500">*</span></label>
                        <input type="text" name="jam" id="jam_input"
                            value="{{ old('jam', substr($recurring_template->jam, 0, 5)) }}"
                            placeholder="00:00" maxlength="5" inputmode="numeric"
                            pattern="^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Jam Selesai</label>
                        <div x-show="!sampaiSelesai">
                            <input type="text" name="jam_sampai" id="jam_sampai_input"
                                value="{{ old('jam_sampai', $recurring_template->jam_sampai ? substr($recurring_template->jam_sampai, 0, 5) : '') }}"
                                placeholder="00:00" maxlength="5" inputmode="numeric"
                                pattern="^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div x-show="sampaiSelesai" class="flex items-center h-[42px] px-3 rounded-lg border border-slate-200 bg-slate-50 text-xs text-slate-500">
                            Dicatat saat kendaraan kembali
                        </div>
                    </div>
                </div>

                <div>
                    <label class="flex items-center gap-2 cursor-pointer select-none w-fit">
                        <input type="checkbox" name="sampai_selesai" value="1" x-model="sampaiSelesai"
                            class="w-4 h-4 rounded text-teal-600 focus:ring-teal-500 cursor-pointer"
                            {{ old('sampai_selesai', !$recurring_template->jam_sampai) ? 'checked' : '' }}>
                        <span class="text-sm font-semibold text-slate-700">Sampai Selesai</span>
                        <span class="text-xs text-slate-500">(seharian penuh)</span>
                    </label>
                    <p class="text-[10px] text-slate-400 mt-1 ml-6">Centang jika waktu selesai tidak ditentukan</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Hari Aktif</label>
                    <div class="flex flex-wrap gap-3">
                        @php
                            $days = [1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu'];
                            $currentDays = old('hari', $recurring_template->hari ?? []);
                        @endphp
                        @foreach($days as $num => $day)
                            <label class="flex items-center gap-2 cursor-pointer p-2 rounded-lg border border-slate-200 hover:bg-slate-50 transition">
                                <input type="checkbox" name="hari[]" value="{{ $num }}" 
                                    class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500"
                                    {{ in_array($num, $currentDays) ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-slate-700">{{ $day }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status Template</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer p-2 px-3 rounded-lg border border-slate-200 hover:border-emerald-400 hover:bg-emerald-50 transition">
                            <input type="radio" name="is_active" value="1" 
                                class="w-4 h-4 text-emerald-600 focus:ring-emerald-500"
                                {{ old('is_active', $recurring_template->is_active) == 1 ? 'checked' : '' }}>
                            <span class="text-sm font-semibold text-slate-800">Aktif</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer p-2 px-3 rounded-lg border border-slate-200 hover:border-slate-400 hover:bg-slate-50 transition">
                            <input type="radio" name="is_active" value="0" 
                                class="w-4 h-4 text-slate-600 focus:ring-slate-500"
                                {{ old('is_active', $recurring_template->is_active) == 0 ? 'checked' : '' }}>
                            <span class="text-sm font-semibold text-slate-800">Nonaktif</span>
                        </label>
                    </div>
                    <p class="text-[10px] text-slate-500 mt-1">Template nonaktif tidak akan menghasilkan pengajuan otomatis, namun data tetap tersimpan.</p>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg px-6 py-2.5 text-sm font-semibold text-white transition hover:shadow-lg" style="background: linear-gradient(to right, #007774, #009e9a);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jamInput      = document.getElementById('jam_input');
            const jamSampaiInput = document.getElementById('jam_sampai_input');
            const sampaiSelesaiCb = document.querySelector('input[name="sampai_selesai"]');
            const previewWaktu  = document.getElementById('preview-waktu');

            // Auto-format HH:MM saat mengetik
            function setupTimeInput(el) {
                el.addEventListener('input', function () {
                    let v = el.value.replace(/[^0-9]/g, '');
                    if (v.length > 2) v = v.slice(0, 2) + ':' + v.slice(2, 4);
                    el.value = v;
                });
                el.addEventListener('blur', function () {
                    let v = el.value;
                    if (v.length === 4 && !v.includes(':')) v = v.slice(0, 2) + ':' + v.slice(2, 4);
                    if (v.includes(':')) {
                        let parts = v.split(':');
                        let h = Math.min(parseInt(parts[0]) || 0, 23);
                        let m = Math.min(parseInt(parts[1]) || 0, 59);
                        el.value = (h < 10 ? '0' + h : h) + ':' + (m < 10 ? '0' + m : m);
                    }
                    updatePreview();
                });
                el.addEventListener('keypress', function (e) {
                    if (!/[0-9]/.test(e.key)) e.preventDefault();
                });
                el.addEventListener('input', updatePreview);
            }

            function updatePreview() {
                const jam = jamInput.value || '--:--';
                const selesai = sampaiSelesaiCb && sampaiSelesaiCb.checked;
                const jamSampai = selesai ? 'Selesai' : (jamSampaiInput && jamSampaiInput.value ? jamSampaiInput.value : 'Selesai');
                previewWaktu.textContent = jam + ' - ' + jamSampai;
            }

            if (jamInput) setupTimeInput(jamInput);
            if (jamSampaiInput) setupTimeInput(jamSampaiInput);
            if (sampaiSelesaiCb) sampaiSelesaiCb.addEventListener('change', updatePreview);
        });
    </script>
</x-app-layout>
