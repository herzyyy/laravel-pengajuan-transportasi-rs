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
<body class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-teal-50 text-slate-800 antialiased">
    <div class="min-h-screen flex flex-col">

        {{-- Header --}}
        <header class="sticky top-0 z-40 backdrop-blur-md bg-gradient-to-r from-emerald-700 via-emerald-600 to-teal-500 text-white shadow-lg shadow-emerald-900/10">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="bg-white rounded-md p-1">
                        <img src="{{ asset('images/logo.png') }}" alt="RS Azra" class="h-10 w-auto">
                    </div>
                    <div>
                        <div class="text-[11px] uppercase tracking-widest text-emerald-100/80 font-semibold">
                            rs azra
                        </div>
                        <div class="font-semibold truncate text-base sm:text-lg tracking-tight">
                            Sistem Pengajuan Transportasi
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="px-4 py-1.5 text-sm rounded-full 
                                   bg-white/95 text-emerald-700 font-medium 
                                   hover:bg-white transition shadow-md">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <div class="flex flex-1">

            {{-- Sidebar --}}
            <aside class="w-64 bg-white/95 backdrop-blur-md border-r border-emerald-100 flex flex-col shadow-sm">
                <div class="px-4 pt-5 pb-4 border-b border-emerald-50">
                    <div class="rounded-2xl bg-gradient-to-r from-emerald-50 to-teal-50 
                                px-4 py-3 text-xs text-emerald-900 shadow-sm">
                        <div class="text-[10px] uppercase tracking-wider text-emerald-600 font-semibold mb-1">
                            {{ auth()->user()->isAdmin() ? 'Admin Aktif' : 'User Aktif' }}
                        </div>
                        <div class="text-sm font-semibold truncate">
                            {{ auth()->user()->name }}
                        </div>
                        <div class="text-[11px] text-emerald-700 truncate mt-0.5">
                            {{ auth()->user()->unit_kerja ?? '-' }}
                        </div>
                    </div>
                </div>

                <nav class="flex-1 px-3 py-5 space-y-2">
                    @if (auth()->user()->isAdmin())
                        {{-- Sidebar untuk Admin --}}
                        <a href="{{ route('admin.dashboard') }}"
                           class="group flex items-center gap-3 px-4 py-2.5 text-sm 
                                  rounded-xl text-slate-700 
                                  hover:bg-emerald-50 hover:text-emerald-700 
                                  transition-all duration-200">
                            <span class="inline-flex w-8 h-8 items-center justify-center 
                                         rounded-lg bg-emerald-50 text-emerald-600 
                                         group-hover:bg-emerald-100 transition">
                                <svg viewBox="0 0 24 24" class="w-4 h-4">
                                    <path d="M4 11.5 12 5l8 6.5V20H4v-8.5Z"
                                          class="fill-none stroke-current"
                                          stroke-width="1.6"
                                          stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('admin.transport.index') }}"
                           class="group flex items-center gap-3 px-4 py-2.5 text-sm 
                                  rounded-xl text-slate-700 
                                  hover:bg-emerald-50 hover:text-emerald-700 
                                  transition-all duration-200">
                            <span class="inline-flex w-8 h-8 items-center justify-center 
                                         rounded-lg bg-emerald-50 text-emerald-600 
                                         group-hover:bg-emerald-100 transition">
                                <svg viewBox="0 0 24 24" class="w-4 h-4">
                                    <path d="M6 7h12M6 12h12M6 17h8"
                                          class="fill-none stroke-current"
                                          stroke-width="1.6"
                                          stroke-linecap="round" />
                                </svg>
                            </span>
                            <span class="font-medium">Daftar Pengajuan</span>
                        </a>

                        {{-- Divider --}}
                        <div class="px-4 py-2">
                            <div class="border-t border-slate-200"></div>
                            <div class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold mt-3 mb-1">
                                Master Data
                            </div>
                        </div>

                        <a href="{{ route('admin.users.index') }}"
                           class="group flex items-center gap-3 px-4 py-2.5 text-sm 
                                  rounded-xl text-slate-700 
                                  hover:bg-emerald-50 hover:text-emerald-700 
                                  transition-all duration-200">
                            <span class="inline-flex w-8 h-8 items-center justify-center 
                                         rounded-lg bg-emerald-50 text-emerald-600 
                                         group-hover:bg-emerald-100 transition">
                                <svg viewBox="0 0 24 24" class="w-4 h-4">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"
                                          class="fill-none stroke-current"
                                          stroke-width="1.6"
                                          stroke-linecap="round"
                                          stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="font-medium">User / Akun</span>
                        </a>

                        <a href="{{ route('admin.vehicles.index') }}"
                           class="group flex items-center gap-3 px-4 py-2.5 text-sm 
                                  rounded-xl text-slate-700 
                                  hover:bg-emerald-50 hover:text-emerald-700 
                                  transition-all duration-200">
                            <span class="inline-flex w-8 h-8 items-center justify-center 
                                         rounded-lg bg-emerald-50 text-emerald-600 
                                         group-hover:bg-emerald-100 transition">
                                <svg viewBox="0 0 24 24" class="w-4 h-4">
                                    <path d="M5 17h14v-5H5v5Zm0 0v2a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-2M5 17l-2-5h18l-2 5M7 12V7a5 5 0 0 1 10 0v5"
                                          class="fill-none stroke-current"
                                          stroke-width="1.6"
                                          stroke-linecap="round"
                                          stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="font-medium">Kendaraan</span>
                        </a>

                        <a href="{{ route('admin.drivers.index') }}"
                           class="group flex items-center gap-3 px-4 py-2.5 text-sm 
                                  rounded-xl text-slate-700 
                                  hover:bg-emerald-50 hover:text-emerald-700 
                                  transition-all duration-200">
                            <span class="inline-flex w-8 h-8 items-center justify-center 
                                         rounded-lg bg-emerald-50 text-emerald-600 
                                         group-hover:bg-emerald-100 transition">
                                <svg viewBox="0 0 24 24" class="w-4 h-4">
                                    <circle cx="12" cy="8" r="4"
                                            class="fill-none stroke-current"
                                            stroke-width="1.6" />
                                    <path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"
                                          class="fill-none stroke-current"
                                          stroke-width="1.6"
                                          stroke-linecap="round" />
                                </svg>
                            </span>
                            <span class="font-medium">Supir</span>
                        </a>
                    @else
                        {{-- Sidebar untuk User biasa --}}
                        <a href="{{ route('dashboard') }}"
                           class="group flex items-center gap-3 px-4 py-2.5 text-sm 
                                  rounded-xl text-slate-700 
                                  hover:bg-emerald-50 hover:text-emerald-700 
                                  transition-all duration-200">
                            <span class="inline-flex w-8 h-8 items-center justify-center 
                                         rounded-lg bg-emerald-50 text-emerald-600 
                                         group-hover:bg-emerald-100 transition">
                                <svg viewBox="0 0 24 24" class="w-4 h-4">
                                    <path d="M4 11.5 12 5l8 6.5V20H4v-8.5Z"
                                          class="fill-none stroke-current"
                                          stroke-width="1.6"
                                          stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('pengajuan.index') }}"
                           class="group flex items-center gap-3 px-4 py-2.5 text-sm 
                                  rounded-xl text-slate-700 
                                  hover:bg-emerald-50 hover:text-emerald-700 
                                  transition-all duration-200">
                            <span class="inline-flex w-8 h-8 items-center justify-center 
                                         rounded-lg bg-emerald-50 text-emerald-600 
                                         group-hover:bg-emerald-100 transition">
                                <svg viewBox="0 0 24 24" class="w-4 h-4">
                                    <path d="M6 7h12M6 12h12M6 17h8"
                                          class="fill-none stroke-current"
                                          stroke-width="1.6"
                                          stroke-linecap="round" />
                                </svg>
                            </span>
                            <span class="font-medium">Riwayat</span>
                        </a>
                    @endif
                </nav>
            </aside>

            {{-- Main Content --}}
            <main class="flex-1 px-8 py-10">
                <div class="max-w-6xl mx-auto">

                    @if (session('status'))
                        <div class="mb-6 rounded-2xl bg-emerald-50 
                                    text-emerald-800 ring-1 ring-emerald-200 
                                    px-5 py-3 shadow-sm">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-100 p-8">
                        {{ $slot }}
                    </div>

                </div>
            </main>

        </div>
    </div>
</body>
</html>