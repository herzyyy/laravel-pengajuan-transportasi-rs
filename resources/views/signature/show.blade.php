<x-app-layout>
    <div class="max-w-4xl mx-auto px-3 sm:px-4 pt-4 pb-6">
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-4">
            <div class="text-center mb-4">
                <h1 class="text-xl font-bold text-slate-800">Tanda Tangan Digital</h1>
                <p class="text-sm text-slate-600 mt-1">
                    Scan QR Code untuk menandatangani dokumen
                </p>
            </div>

            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-lg p-6 mb-4">
                <div class="text-center">
                    <div class="inline-block bg-white p-4 rounded-lg shadow-md mb-3">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode(route('signature.sign', $transportRequest)) }}" 
                             alt="QR Code" 
                             class="w-[200px] h-[200px]">
                    </div>
                    <p class="text-sm font-semibold text-slate-700">
                        @if($signatureType === 'pemohon')
                            Tanda Tangan Pemohon
                        @elseif($signatureType === 'pengelola_1')
                            Tanda Tangan Pengelola (Menyetujui)
                        @elseif($signatureType === 'driver')
                            Tanda Tangan Pengemudi
                        @elseif($signatureType === 'pengelola_2')
                            Tanda Tangan Pengelola (Mengetahui)
                        @endif
                    </p>
                    <p class="text-xs text-slate-500 mt-1">
                        Pengajuan #{{ str_pad($transportRequest->id, 4, '0', STR_PAD_LEFT) }}
                    </p>
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-xs text-blue-800">
                        <p class="font-semibold mb-1">Cara Tanda Tangan:</p>
                        <ol class="list-decimal ml-4 space-y-0.5">
                            <li>Scan QR Code menggunakan kamera smartphone</li>
                            <li>Atau klik tombol "Tanda Tangan Sekarang" di bawah</li>
                            <li>Tanda tangan akan tersimpan secara otomatis</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <form method="POST" action="{{ route('signature.sign', $transportRequest) }}">
                    @csrf
                    <button type="submit" 
                            class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-4 py-3 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Tanda Tangan Sekarang
                    </button>
                </form>

                <a href="{{ auth()->user()->isAdmin() ? route('admin.transport.show', $transportRequest) : route('pengajuan.index') }}"
                   class="w-full inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Kembali
                </a>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-200">
                <h3 class="text-sm font-semibold text-slate-700 mb-2">Detail Pengajuan</h3>
                <dl class="grid grid-cols-2 gap-2 text-xs">
                    <div>
                        <dt class="text-slate-500">Jenis</dt>
                        <dd class="font-medium text-slate-900">{{ ucfirst($transportRequest->jenis) }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Tanggal</dt>
                        <dd class="font-medium text-slate-900">{{ $transportRequest->tanggal->format('d/m/Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Pemohon</dt>
                        <dd class="font-medium text-slate-900">{{ $transportRequest->user->full_name ?? $transportRequest->pemohon_nama }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Status</dt>
                        <dd class="font-medium text-slate-900">{{ ucfirst($transportRequest->status) }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>
