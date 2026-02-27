<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Transportasi RSAzra') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-teal-50 text-slate-800 antialiased @if($hideHeader ?? false) overflow-hidden @endif">
    <div class="min-h-screen flex flex-col @if($hideHeader ?? false) h-screen @endif">

        @unless($hideHeader ?? false)
            <header class="bg-gradient-to-r from-emerald-700 via-emerald-600 to-teal-500 
                           text-white shadow-lg shadow-emerald-900/10">
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

        <div class="flex-1 flex items-center justify-center px-4 sm:px-6 @if($hideHeader ?? false) py-0 @else py-8 @endif">
            <div class="w-full max-w-md">

                @unless($hideHeader ?? false)
                    <div class="mb-8 text-center">
                        <!-- <div class="inline-flex items-center gap-2 rounded-full 
                                    bg-gradient-to-r from-emerald-100 to-teal-100 
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
                @endunless

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
        </div>
    </div>
</body>
</html>