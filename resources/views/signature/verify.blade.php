<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Tanda Tangan - RS Azra</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center p-3">
    <div class="w-full max-w-sm">

        <!-- Header -->
        <div class="flex items-center gap-2.5 mb-3">
            <div class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">RS</div>
            <div>
                <div class="text-[10px] text-slate-500 leading-none">RS Azra Bogor</div>
                <div class="text-xs font-bold text-slate-800 leading-tight">Verifikasi Tanda Tangan</div>
            </div>
        </div>

        @if(!$found)
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-red-200 overflow-hidden">
                <div class="bg-red-500 px-4 py-3 flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white">Tidak Valid</p>
                        <p class="text-[10px] text-red-100">Tanda tangan tidak ditemukan</p>
                    </div>
                </div>
                <div class="p-3">
                    <p class="text-xs text-slate-600">QR Code ini tidak terdaftar. Dokumen mungkin tidak sah atau QR Code telah rusak.</p>
                </div>
            </div>

        @else
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-emerald-200 overflow-hidden">

                <!-- Status Bar -->
                <div class="bg-emerald-600 px-3 py-2.5 flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white">Tanda Tangan Valid</p>
                        <p class="text-[10px] text-emerald-100">Dokumen telah ditandatangani secara sah</p>
                    </div>
                </div>

                <div class="p-3 space-y-2.5">

                    <!-- Penandatangan -->
                    <div class="bg-emerald-50 border border-emerald-100 rounded-lg p-2.5">
                        <p class="text-[9px] font-bold text-emerald-600 uppercase tracking-wider mb-1.5">Penandatangan</p>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-emerald-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-900 truncate">{{ $signatureInfo['name'] }}</p>
                                <p class="text-[10px] text-slate-500 truncate">{{ $signatureInfo['unit'] }}</p>
                                <p class="text-[10px] font-semibold text-emerald-700">{{ $signatureInfo['role'] }}</p>
                            </div>
                        </div>
                        @if($signatureInfo['signed_at'])
                            <div class="mt-2 pt-2 border-t border-emerald-200 flex items-center gap-1">
                                <svg class="w-3 h-3 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-[10px] text-emerald-700">{{ $signatureInfo['signed_at']->format('d M Y, H:i') }} WIB</p>
                            </div>
                        @endif
                    </div>

                    <!-- Info Dokumen -->
                    <div class="bg-slate-50 rounded-lg p-2.5">
                        <p class="text-[9px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Detail Dokumen</p>
                        <div class="grid grid-cols-2 gap-x-3 gap-y-1">
                            <div>
                                <p class="text-[9px] text-slate-400">No. Pengajuan</p>
                                <p class="text-xs font-mono font-bold text-slate-800">#{{ str_pad($transportRequest->id, 4, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] text-slate-400">Jenis</p>
                                <p class="text-xs font-semibold text-slate-800">{{ ucfirst($transportRequest->jenis) }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] text-slate-400">Pemohon</p>
                                <p class="text-xs font-semibold text-slate-800 truncate">{{ $transportRequest->user->full_name ?? $transportRequest->pemohon_nama }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] text-slate-400">Tanggal</p>
                                <p class="text-xs font-semibold text-slate-800">{{ $transportRequest->tanggal->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endif

        <p class="text-center text-[9px] text-slate-400 mt-3">RS Azra Bogor &bull; Sistem Pengajuan Transportasi</p>
    </div>
</body>
</html>
