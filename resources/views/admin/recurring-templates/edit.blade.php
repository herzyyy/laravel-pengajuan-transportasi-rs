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
                    <div class="text-xs text-slate-500">Waktu: <span class="font-semibold text-slate-700">{{ substr($recurring_template->jam, 0, 5) }} {{ $recurring_template->jam_sampai ? '- '.substr($recurring_template->jam_sampai, 0, 5) : '- Selesai' }}</span></div>
                </div>
            </div>

            <form action="{{ route('admin.recurring-templates.update', $recurring_template) }}" method="POST" class="p-4 sm:p-6 space-y-5">
                @csrf
                @method('PUT')

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
</x-app-layout>
