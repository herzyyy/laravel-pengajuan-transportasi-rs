<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-3 pb-6 space-y-3">

        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-base font-bold text-slate-900">Tugas Pengemudi</h1>
                <p class="text-[11px] text-slate-500">{{ $driver->name }}</p>
            </div>
            <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold bg-cyan-100 text-cyan-700">
                {{ $activeRequests->count() }} aktif
            </span>
        </div>

        @if(session('success'))
            <div class="p-2 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-xs font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-xs">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        <!-- Tugas Aktif -->
        @forelse($activeRequests as $item)
            <div class="bg-white rounded-xl border border-cyan-200 shadow-sm overflow-hidden"
                 x-data="{ open: false }">
                <!-- Header card -->
                <div class="flex items-center justify-between px-3 py-2 bg-cyan-50 border-b border-cyan-100">
                    <div class="flex items-center gap-2">
                        <span class="font-mono text-[10px] text-slate-400">#{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</span>
                        <span class="text-xs font-bold text-slate-800">{{ $item->unit_mobil ?? '-' }}</span>
                        <span class="text-[10px] text-slate-500">{{ ucfirst($item->jenis) }}</span>
                    </div>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-cyan-100 text-cyan-800">Digunakan</span>
                </div>

                <!-- Info ringkas -->
                <div class="px-3 py-2 grid grid-cols-2 gap-x-4 gap-y-1 text-[10px]">
                    <div class="flex gap-1.5">
                        <span class="text-slate-400 w-14 shrink-0">Pemohon</span>
                        <span class="font-medium text-slate-800 truncate">{{ $item->user->full_name ?? $item->pemohon_nama }}</span>
                    </div>
                    <div class="flex gap-1.5">
                        <span class="text-slate-400 w-14 shrink-0">KM Awal</span>
                        <span class="font-medium text-slate-800">{{ $item->km_awal ? number_format($item->km_awal, 0, ',', '.') : '-' }} km</span>
                    </div>
                    <div class="flex gap-1.5">
                        <span class="text-slate-400 w-14 shrink-0">Jadwal</span>
                        <span class="font-medium text-slate-800">{{ $item->tanggal->format('d/m/Y') }} {{ substr($item->jam, 0, 5) }} – {{ substr($item->jam_sampai, 0, 5) }}</span>
                    </div>
                    <div class="flex gap-1.5">
                        <span class="text-slate-400 w-14 shrink-0">Tujuan</span>
                        <span class="font-medium text-slate-800 truncate">{{ $item->alamat_tujuan ?? '-' }}</span>
                    </div>
                </div>

                <!-- Tombol & Form selesai -->
                <div class="px-3 pb-2.5">
                    <button type="button" @click="open = !open"
                            class="w-full rounded-lg text-xs font-semibold px-3 py-1.5 transition flex items-center justify-center gap-1.5"
                            :class="open ? 'bg-slate-100 text-slate-700' : 'bg-emerald-600 hover:bg-emerald-700 text-white'">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span x-text="open ? 'Batal' : 'Selesaikan Perjalanan'"></span>
                    </button>

                    <div x-show="open" x-transition class="mt-2">
                        <form method="POST" action="{{ route('driver.complete', $item) }}" class="space-y-2">
                            @csrf
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-700 mb-0.5">KM Tiba <span class="text-red-500">*</span></label>
                                    <input type="text" id="km_akhir_display_{{ $item->id }}" placeholder="Masukkan KM"
                                           inputmode="numeric" autocomplete="off"
                                           class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-xs focus:ring-2 focus:ring-emerald-500">
                                    <input type="hidden" name="km_akhir" id="km_akhir_{{ $item->id }}">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-700 mb-0.5">Jam Tiba <span class="text-red-500">*</span></label>
                                    <input type="text" name="jam_kedatangan" placeholder="00:00"
                                           maxlength="5" inputmode="numeric"
                                           class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-xs focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>
                            <button type="submit"
                                    class="w-full rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 text-xs font-semibold transition">
                                Simpan & Selesai
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl border border-slate-200 p-6 text-center">
                <svg class="w-8 h-8 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-xs text-slate-500 font-medium">Tidak ada tugas aktif saat ini</p>
            </div>
        @endforelse

        <!-- Riwayat -->
        @if($historyRequests->isNotEmpty())
            <div>
                <h2 class="text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Riwayat Terakhir</h2>
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="divide-y divide-slate-100">
                        @foreach($historyRequests as $item)
                            <div class="px-3 py-2 text-[10px] flex items-center justify-between gap-2">
                                <div class="min-w-0">
                                    <span class="font-medium text-slate-800">{{ $item->unit_mobil ?? '-' }}</span>
                                    <span class="text-slate-400 mx-1">·</span>
                                    <span class="text-slate-500">{{ $item->tanggal->format('d/m/Y') }}</span>
                                    <span class="text-slate-400 mx-1">·</span>
                                    <span class="text-slate-500 truncate">{{ $item->user->full_name ?? $item->pemohon_nama }}</span>
                                </div>
                                @php $s = $item->status === 'selesai' ? ['bg-emerald-100','text-emerald-800','Selesai'] : ['bg-red-100','text-red-800','Ditolak']; @endphp
                                <span class="inline-flex shrink-0 items-center px-1.5 py-0.5 rounded-full text-[9px] font-bold {{ $s[0] }} {{ $s[1] }}">{{ $s[2] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[id^="km_akhir_display_"]').forEach(function(display) {
                const hidden = document.getElementById('km_akhir_' + display.id.replace('km_akhir_display_', ''));
                display.addEventListener('input', function() {
                    const raw = this.value.replace(/\D/g, '');
                    const cursor = this.selectionStart;
                    const prevLen = this.value.length;
                    this.value = raw ? parseInt(raw).toLocaleString('id-ID') : '';
                    if (hidden) hidden.value = raw;
                    this.setSelectionRange(cursor + (this.value.length - prevLen), cursor + (this.value.length - prevLen));
                });
                display.addEventListener('keypress', e => { if (!/[0-9]/.test(e.key)) e.preventDefault(); });
            });

            document.querySelectorAll('input[name="jam_kedatangan"]').forEach(function(el) {
                el.addEventListener('input', function() {
                    let v = this.value.replace(/[^0-9]/g, '');
                    if (v.length > 2) v = v.slice(0,2) + ':' + v.slice(2,4);
                    this.value = v;
                });
                el.addEventListener('keypress', e => { if (!/[0-9]/.test(e.key)) e.preventDefault(); });
            });
        });
    </script>
</x-app-layout>
