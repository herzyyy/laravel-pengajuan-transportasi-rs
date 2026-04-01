<x-app-layout>
    <div class="max-w-3xl mx-auto px-3 py-2">
        <div class="bg-white rounded-lg shadow-sm ring-1 ring-slate-200 p-3">
            <div class="text-center mb-2">
                <h1 class="text-lg font-bold text-slate-800">Tanda Tangan Digital</h1>
                <p class="text-xs text-slate-600">Scan QR Code untuk menandatangani dokumen</p>
            </div>

            <div class="bg-white rounded-lg p-3 mb-2">
                <div class="text-center">
                    <div class="inline-block bg-white p-2 rounded-lg shadow-md mb-1">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ urlencode(route('signature.confirm', $transportRequest)) }}" 
                             alt="QR Code" 
                             class="w-[160px] h-[160px]">
                    </div>
                    <p class="text-xs font-semibold text-slate-700">
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
                    <p class="text-[10px] text-slate-500">
                        Pengajuan #{{ str_pad($transportRequest->id, 4, '0', STR_PAD_LEFT) }}
                    </p>
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-2 mb-2">
                <div class="flex items-start gap-1.5">
                    <svg class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-[10px] text-blue-800 leading-tight">
                        <p class="font-semibold mb-0.5">Cara Tanda Tangan:</p>
                        <ol class="list-decimal ml-3 space-y-0">
                            <li>Scan QR Code menggunakan kamera smartphone</li>
                            <li>Atau klik tombol "Tanda Tangan Sekarang"</li>
                            <li>Tanda tangan akan tersimpan otomatis</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2 mb-2">
                <div class="text-[10px]">
                    <span class="text-slate-500">Jenis:</span>
                    <span class="font-medium text-slate-900 ml-1">{{ ucfirst($transportRequest->jenis) }}</span>
                </div>
                <div class="text-[10px]">
                    <span class="text-slate-500">Tanggal:</span>
                    <span class="font-medium text-slate-900 ml-1">{{ $transportRequest->tanggal->format('d/m/Y') }}</span>
                </div>
                <div class="text-[10px] col-span-2">
                    <span class="text-slate-500">Pemohon:</span>
                    <span class="font-medium text-slate-900 ml-1">{{ $transportRequest->user->full_name ?? $transportRequest->pemohon_nama }}</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <form method="POST" action="{{ route('signature.sign', $transportRequest) }}">
                    @csrf
                    <button type="submit" 
                            class="w-full inline-flex items-center justify-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white hover:bg-emerald-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Tanda Tangan
                    </button>
                </form>

                <a href="{{ auth()->user()->isAdmin() ? route('admin.transport.show', $transportRequest) : route('pengajuan.index') }}"
                   class="w-full inline-flex items-center justify-center gap-1.5 rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
