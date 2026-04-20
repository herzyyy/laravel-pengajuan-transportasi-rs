<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Tanda Tangan - RS Azra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-primary   { background-color: #007774; }
        .bg-secondary { background-color: #5C8727; }
        .text-primary   { color: #007774; }
        .text-secondary { color: #5C8727; }
        .border-primary   { border-color: #007774; }
        .border-secondary { border-color: #5C8727; }
        .bg-primary-light   { background-color: #e6f4f4; }
        .bg-secondary-light { background-color: #eef4e6; }
        .ring-primary { --tw-ring-color: #007774; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-3" style="background-color: #f0f7f7;">
    <div class="w-full max-w-sm">

        <!-- Header -->
        <div class="flex items-center gap-2.5 mb-3">
            <img src="{{ asset('images/logo.png') }}" alt="RS Azra" class="h-9 w-auto">
            <div>
                <div class="text-[10px] text-slate-500 leading-none">rs azra</div>
                <div class="text-xs font-bold leading-tight" style="color: #007774;">Verifikasi Tanda Tangan</div>
            </div>
        </div>

        @if(!$found)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden" style="border: 1px solid #fca5a5;">
                <div class="px-4 py-3 flex items-center gap-2.5" style="background-color: #ef4444;">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: rgba(255,255,255,0.2);">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white">Tidak Valid</p>
                        <p class="text-[10px]" style="color: #fecaca;">Tanda tangan tidak ditemukan</p>
                    </div>
                </div>
                <div class="p-3">
                    <p class="text-xs text-slate-600">QR Code ini tidak terdaftar. Dokumen mungkin tidak sah atau QR Code telah rusak.</p>
                </div>
            </div>

        @else
            <div class="bg-white rounded-xl shadow-sm overflow-hidden" style="border: 1px solid #b2d8d8;">

                <!-- Status Bar -->
                <div class="px-3 py-2.5 flex items-center gap-2.5 bg-primary">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: rgba(255,255,255,0.2);">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white">Tanda Tangan Valid</p>
                        <p class="text-[10px]" style="color: #b2e0df;">Dokumen telah ditandatangani secara sah</p>
                    </div>
                </div>

                <div class="p-3 space-y-2.5">

                    <!-- Penandatangan -->
                    <div class="rounded-lg p-2.5 bg-primary-light" style="border: 1px solid #b2d8d8;">
                        <p class="text-[9px] font-bold uppercase tracking-wider mb-1.5 text-primary">Penandatangan</p>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 bg-primary">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-900 truncate">{{ $signatureInfo['name'] }}</p>
                                <p class="text-[10px] text-slate-500 truncate">{{ $signatureInfo['unit'] }}</p>
                                <p class="text-[10px] font-semibold text-secondary">{{ $signatureInfo['role'] }}</p>
                            </div>
                        </div>
                        @if($signatureInfo['signed_at'])
                            <div class="mt-2 pt-2 flex items-center gap-1" style="border-top: 1px solid #b2d8d8;">
                                <svg class="w-3 h-3 flex-shrink-0 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-[10px] text-primary">{{ $signatureInfo['signed_at']->format('d M Y, H:i') }} WIB</p>
                            </div>
                        @endif
                    </div>

                    <!-- Info Dokumen -->
                    <div class="bg-slate-50 rounded-lg p-2.5" style="border: 1px solid #e2e8f0;">
                        <p class="text-[9px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Detail Dokumen</p>
                        <div class="grid grid-cols-2 gap-x-3 gap-y-1.5">
                            <div>
                                <p class="text-[9px] text-slate-400">No. Pengajuan</p>
                                <p class="text-xs font-mono font-bold text-slate-800">{{ $transportRequest->nomor_pengajuan }}</p>
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

        <p class="text-center text-[9px] text-slate-400 mt-3">rs azra &bull; Sistem Pengajuan Transportasi</p>
    </div>
</body>
</html>
