<x-app-layout title="Konfirmasi Tanda Tangan — SIPETRANS">
    <div class="max-w-md mx-auto px-3 py-4">
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">

            <!-- Header -->
            <div class="bg-emerald-600 px-4 py-4 text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-white/20 mb-2">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                </div>
                <h1 class="text-base font-bold text-white">Konfirmasi Tanda Tangan</h1>
                <p class="text-xs text-emerald-100 mt-0.5">
                    @if($signatureType === 'pemohon') Tanda Tangan Pemohon
                    @elseif($signatureType === 'pengelola_1') Pengelola - Menyetujui
                    @elseif($signatureType === 'driver') Tanda Tangan Pengemudi
                    @elseif($signatureType === 'pengelola_2') Pengelola - Mengetahui
                    @endif
                </p>
            </div>

            <div class="p-4 space-y-4">
                <!-- Info Pengajuan -->
                <div class="bg-slate-50 rounded-lg p-3 space-y-2">
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">No. Pengajuan</span>
                        <span class="font-mono font-semibold text-slate-800">{{ $transportRequest->nomor_pengajuan }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Jenis</span>
                        <span class="font-semibold text-slate-800">{{ ucfirst($transportRequest->jenis) }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Pemohon</span>
                        <span class="font-semibold text-slate-800">{{ $transportRequest->user->full_name ?? $transportRequest->pemohon_nama }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Tanggal</span>
                        <span class="font-semibold text-slate-800">{{ $transportRequest->tanggal->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Tujuan</span>
                        <span class="font-semibold text-slate-800 text-right max-w-[60%]">{{ $transportRequest->alamat_tujuan ?? '-' }}</span>
                    </div>
                </div>

                <!-- Peringatan -->
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 flex gap-2">
                    <svg class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p class="text-xs text-amber-800">
                        Dengan menandatangani, Anda mengonfirmasi kebenaran data pengajuan ini. Tanda tangan tidak dapat dibatalkan.
                    </p>
                </div>

                <!-- Penanda tangan -->
                <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-3 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-emerald-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-emerald-900">{{ auth()->user()->full_name }}</p>
                        <p class="text-[10px] text-emerald-700">{{ auth()->user()->unit_kerja ?? 'Pengelola Transportasi' }}</p>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="grid grid-cols-2 gap-2 pt-1">
                    <form method="POST" action="{{ route('signature.sign', $transportRequest) }}">
                        @csrf
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Tanda Tangan
                        </button>
                    </form>
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.transport.show', $transportRequest) : route('pengajuan.index') }}"
                       class="inline-flex items-center justify-center gap-1.5 rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
