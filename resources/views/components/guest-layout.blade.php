<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Transportasi RSAzra') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="@if($hideHeader ?? false) h-screen overflow-hidden bg-white @else min-h-screen bg-white text-slate-800 antialiased @endif">
    <div class="@if($hideHeader ?? false) h-screen flex @else min-h-screen flex flex-col @endif">

        @unless($hideHeader ?? false)
            <header class="bg-emerald-700 
                           text-white shadow-lg">
                <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                    <div class="min-w-0">
                        <div class="text-[11px] uppercase tracking-widest text-emerald-100/80 font-semibold">
                            RS Azra
                        </div>
                        <!-- <div class="font-semibold truncate text-base sm:text-lg tracking-tight">
                            Aplikasi Pengajuan Transportasi
                        </div> -->
                    </div>
                </div>
            </header>
        @endunless

        <div class="@if($hideHeader ?? false) flex-1 flex w-full @else flex-1 flex items-center justify-center px-4 sm:px-6 py-8 @endif">
            @if($hideHeader ?? false)
                {{ $slot }}
            @else
                <div class="w-full max-w-md">
                    <div class="mb-8 text-center">
                        <!-- <div class="inline-flex items-center gap-2 rounded-full 
                                    bg-emerald-100 
                                    text-emerald-700 px-4 py-1.5 text-xs font-semibold 
                                    shadow-sm mb-3">
                            Sistem Pengajuan Transportasi
                        </div> -->

                        <!-- <div class="text-2xl font-semibold text-emerald-900 tracking-tight">
                            Pengajuan Transportasi RS
                        </div> -->

                        <!-- <div class="text-sm text-slate-500 mt-2">
                            Silakan login menggunakan akun unit kerja Anda.
                        </div> -->
                    </div>

                    <div class="bg-white/95 backdrop-blur-md 
                                shadow-xl shadow-emerald-900/5 
                                ring-1 ring-slate-200 
                                rounded-2xl p-7 sm:p-8 transition-all duration-300">
                        {{ $slot }}
                    </div>

                    <div class="mt-8 text-center text-xs text-slate-400">
                        {{ config('app.name', 'Laravel') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>