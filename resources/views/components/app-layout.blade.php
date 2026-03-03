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
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
    <div class="min-h-screen flex flex-col">

        {{-- Header --}}
        <header class="sticky top-0 z-40 backdrop-blur-md bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-500 shadow-md">
            <div class="px-6 py-3 flex items-center justify-between">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="bg-white rounded-lg p-1.5 shadow-lg">
                        <img src="{{ asset('images/logo.png') }}" alt="RS Azra" class="h-7 w-auto">
                    </div>
                    <div>
                        <div class="text-xs text-emerald-100 font-medium">
                            RS Azra Bogor
                        </div>
                        <div class="font-semibold text-white text-sm tracking-tight">
                            Sistem Pengajuan Transportasi
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-lg border border-white/30">
                        <div class="w-2 h-2 rounded-full bg-white shadow-sm"></div>
                        <div class="text-xs">
                            <span class="text-emerald-50">{{ auth()->user()->isAdmin() ? 'Admin' : 'User' }}:</span>
                            <span class="font-semibold text-white ml-1">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2 px-3 py-1.5 text-xs font-medium rounded-lg 
                                   bg-white text-emerald-700 hover:bg-emerald-50 
                                   shadow-md transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <div class="flex flex-1">

            {{-- Sidebar --}}
            <aside class="w-56 bg-gradient-to-b from-emerald-50 to-white border-r border-emerald-100 flex flex-col">
                <div class="px-3 py-4 border-b border-emerald-100">
                    <div class="rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 px-3 py-2.5 shadow-md text-white">
                        <div class="flex items-center gap-2 mb-1.5">
                            <div class="w-1.5 h-1.5 rounded-full bg-white shadow-sm"></div>
                            <div class="text-[10px] uppercase tracking-wider text-emerald-100 font-semibold">
                                {{ auth()->user()->isAdmin() ? 'Administrator' : 'Pegawai' }}
                            </div>
                        </div>
                        <div class="text-sm font-semibold truncate">
                            {{ auth()->user()->name }}
                        </div>
                        @if(auth()->user()->unit_kerja)
                        <div class="text-xs text-emerald-100 truncate mt-0.5">
                            {{ auth()->user()->unit_kerja }}
                        </div>
                        @endif
                    </div>
                </div>

                <nav class="flex-1 px-2 py-3 space-y-1">
                    @if (auth()->user()->isAdmin())
                        {{-- Sidebar untuk Admin --}}
                        <a href="{{ route('admin.dashboard') }}"
                           class="group flex items-center gap-2.5 px-3 py-2 text-sm 
                                  rounded-lg text-slate-700 
                                  hover:bg-emerald-50 hover:text-emerald-700 hover:shadow-sm
                                  transition-all duration-150">
                            <svg viewBox="0 0 24 24" class="w-4 h-4 text-emerald-500 group-hover:text-emerald-600 transition">
                                <path d="M4 11.5 12 5l8 6.5V20H4v-8.5Z"
                                      class="fill-none stroke-current"
                                      stroke-width="2"
                                      stroke-linejoin="round" />
                            </svg>
                            <span class="font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('admin.transport.index') }}"
                           class="group flex items-center gap-2.5 px-3 py-2 text-sm 
                                  rounded-lg text-slate-700 
                                  hover:bg-emerald-50 hover:text-emerald-700 hover:shadow-sm
                                  transition-all duration-150">
                            <svg viewBox="0 0 24 24" class="w-4 h-4 text-emerald-500 group-hover:text-emerald-600 transition">
                                <path d="M6 7h12M6 12h12M6 17h8"
                                      class="fill-none stroke-current"
                                      stroke-width="2"
                                      stroke-linecap="round" />
                            </svg>
                            <span class="font-medium">Daftar Pengajuan</span>
                        </a>

                        {{-- Divider --}}
                        <div class="px-3 py-2">
                            <div class="border-t border-emerald-200"></div>
                            <div class="text-[10px] uppercase tracking-wider text-emerald-600 font-semibold mt-2 mb-1">
                                Master Data
                            </div>
                        </div>

                        <a href="{{ route('admin.users.index') }}"
                           class="group flex items-center gap-2.5 px-3 py-2 text-sm 
                                  rounded-lg text-slate-700 
                                  hover:bg-emerald-50 hover:text-emerald-700 hover:shadow-sm
                                  transition-all duration-150">
                            <svg viewBox="0 0 24 24" class="w-4 h-4 text-emerald-500 group-hover:text-emerald-600 transition">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"
                                      class="fill-none stroke-current"
                                      stroke-width="2"
                                      stroke-linecap="round"
                                      stroke-linejoin="round" />
                            </svg>
                            <span class="font-medium">User / Akun</span>
                        </a>

                        <a href="{{ route('admin.vehicles.index') }}"
                           class="group flex items-center gap-2.5 px-3 py-2 text-sm 
                                  rounded-lg text-slate-700 
                                  hover:bg-emerald-50 hover:text-emerald-700 hover:shadow-sm
                                  transition-all duration-150">
                            <svg viewBox="0 0 24 24" class="w-4 h-4 text-emerald-500 group-hover:text-emerald-600 transition">
                                <path d="M5 17h14v-5H5v5Zm0 0v2a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-2M5 17l-2-5h18l-2 5M7 12V7a5 5 0 0 1 10 0v5"
                                      class="fill-none stroke-current"
                                      stroke-width="2"
                                      stroke-linecap="round"
                                      stroke-linejoin="round" />
                            </svg>
                            <span class="font-medium">Kendaraan</span>
                        </a>

                        <a href="{{ route('admin.drivers.index') }}"
                           class="group flex items-center gap-2.5 px-3 py-2 text-sm 
                                  rounded-lg text-slate-700 
                                  hover:bg-emerald-50 hover:text-emerald-700 hover:shadow-sm
                                  transition-all duration-150">
                            <svg viewBox="0 0 24 24" class="w-4 h-4 text-emerald-500 group-hover:text-emerald-600 transition">
                                <circle cx="12" cy="8" r="4"
                                        class="fill-none stroke-current"
                                        stroke-width="2" />
                                <path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"
                                      class="fill-none stroke-current"
                                      stroke-width="2"
                                      stroke-linecap="round" />
                            </svg>
                            <span class="font-medium">Supir</span>
                        </a>
                    @else
                        {{-- Sidebar untuk User biasa --}}
                        <a href="{{ route('dashboard') }}"
                           class="group flex items-center gap-2.5 px-3 py-2 text-sm 
                                  rounded-lg text-slate-700 
                                  hover:bg-emerald-50 hover:text-emerald-700 hover:shadow-sm
                                  transition-all duration-150">
                            <svg viewBox="0 0 24 24" class="w-4 h-4 text-emerald-500 group-hover:text-emerald-600 transition">
                                <path d="M4 11.5 12 5l8 6.5V20H4v-8.5Z"
                                      class="fill-none stroke-current"
                                      stroke-width="2"
                                      stroke-linejoin="round" />
                            </svg>
                            <span class="font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('pengajuan.index') }}"
                           class="group flex items-center gap-2.5 px-3 py-2 text-sm 
                                  rounded-lg text-slate-700 
                                  hover:bg-emerald-50 hover:text-emerald-700 hover:shadow-sm
                                  transition-all duration-150">
                            <svg viewBox="0 0 24 24" class="w-4 h-4 text-emerald-500 group-hover:text-emerald-600 transition">
                                <path d="M6 7h12M6 12h12M6 17h8"
                                      class="fill-none stroke-current"
                                      stroke-width="2"
                                      stroke-linecap="round" />
                            </svg>
                            <span class="font-medium">Riwayat</span>
                        </a>
                    @endif
                </nav>
            </aside>

            {{-- Main Content --}}
            <main class="flex-1 px-6 py-6 bg-slate-50">
                <div class="max-w-7xl mx-auto">

                    @if (session('status'))
                        <div class="mb-4 rounded-lg bg-emerald-50 
                                    text-emerald-800 border border-emerald-200 
                                    px-4 py-3 text-sm shadow-sm">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        {{ $slot }}
                    </div>

                </div>
            </main>

        </div>
    </div>
</body>
</html>