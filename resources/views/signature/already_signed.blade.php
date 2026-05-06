<x-app-layout title="Sudah Ditandatangani — SIPETRANS">
    <div class="max-w-md mx-auto px-3 py-4">
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="bg-slate-600 px-4 py-4 text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-white/20 mb-2">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h1 class="text-base font-bold text-white">Sudah Ditandatangani</h1>
                <p class="text-xs text-slate-200 mt-0.5">Pengajuan {{ $transportRequest->nomor_pengajuan }}</p>
            </div>
            <div class="p-4 text-center space-y-3">
                <p class="text-sm text-slate-600">Tidak ada tanda tangan yang diperlukan untuk pengajuan ini saat ini.</p>
                <a href="{{ auth()->user()->isAdmin() ? route('admin.transport.show', $transportRequest) : route('pengajuan.index') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
