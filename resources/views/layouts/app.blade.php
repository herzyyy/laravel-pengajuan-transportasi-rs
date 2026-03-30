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
<body class="min-h-screen bg-white text-slate-800 antialiased">

    <!-- Header Bar Accent -->
    <div class="h-1 bg-accent-teal shadow-sm"></div>
    
    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <aside class="w-64 bg-white/95 backdrop-blur-md border-r border-emerald-100 flex flex-col shadow-sm">
            
            <div class="px-5 py-5 border-b border-emerald-100 bg-white/80">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 rounded-xl bg-emerald-600 
                                flex items-center justify-center text-white text-sm font-semibold shadow-md">
                        RS
                    </div>
                    <div class="font-semibold text-emerald-900 truncate tracking-tight">
                        RS Azra
                    </div>
                </div>
                <div class="text-xs text-slate-500 truncate">
                    {{ auth()->user()->name }}
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-5 space-y-2">

                @if(request()->routeIs('admin.*'))
                    <!-- Menu Admin -->
                    <div class="px-2 mb-2 text-xs font-semibold text-emerald-800/70 uppercase tracking-wider">
                        Panel Admin
                    </div>

                    <a href="{{ route('admin.transport.index') }}"
                       class="group flex items-center gap-3 px-4 py-2.5 text-sm rounded-xl 
                              transition-all duration-200
                              {{ request()->routeIs('admin.transport.*') 
                                  ? 'bg-emerald-50 text-emerald-700 shadow-sm' 
                                  : 'hover:bg-emerald-50/70 text-slate-600' }}">

                        <span class="inline-flex w-8 h-8 items-center justify-center rounded-lg 
                                     {{ request()->routeIs('admin.transport.*') 
                                         ? 'bg-emerald-100 text-emerald-600' 
                                         : 'bg-slate-100 text-slate-500 group-hover:bg-emerald-100 group-hover:text-emerald-600' }}">
                            <svg viewBox="0 0 24 24" class="w-4 h-4">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"
                                      class="fill-none stroke-current" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="font-medium">Daftar Pengajuan</span>
                    </a>

                    <div class="my-4 border-t border-slate-100"></div>
                    
                    <div class="px-2 mb-2 text-xs font-semibold text-emerald-800/70 uppercase tracking-wider">
                        Lainnya
                    </div>

                    <a href="{{ route('dashboard') }}"
                       class="group flex items-center gap-3 px-4 py-2.5 text-sm rounded-xl 
                              transition-all duration-200 hover:bg-slate-50 text-slate-600">
                        <span class="inline-flex w-8 h-8 items-center justify-center rounded-lg bg-slate-100 text-slate-500 group-hover:bg-slate-200 group-hover:text-slate-700">
                            <svg viewBox="0 0 24 24" class="w-4 h-4">
                                <path d="M10 19l-7-7m0 0l7-7m-7 7h18" class="fill-none stroke-current" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="font-medium">Kembali ke User</span>
                    </a>

                @else
                    <!-- Menu User -->
                    <div class="px-2 mb-2 text-xs font-semibold text-emerald-800/70 uppercase tracking-wider">
                        Menu Utama
                    </div>

                    <a href="{{ route('dashboard') }}"
                       class="group flex items-center gap-3 px-4 py-2.5 text-sm rounded-xl 
                              transition-all duration-200
                              {{ request()->routeIs('dashboard') 
                                  ? 'bg-emerald-50 text-emerald-700 shadow-sm' 
                                  : 'hover:bg-emerald-50/70 text-slate-600' }}">

                        <span class="inline-flex w-8 h-8 items-center justify-center rounded-lg 
                                     {{ request()->routeIs('dashboard') 
                                         ? 'bg-emerald-100 text-emerald-600' 
                                         : 'bg-slate-100 text-slate-500 group-hover:bg-emerald-100 group-hover:text-emerald-600' }}">
                            <svg viewBox="0 0 24 24" class="w-4 h-4">
                                <path d="M4 11.5 12 5l8 6.5V20H4v-8.5Z"
                                      class="fill-none stroke-current" stroke-width="1.6" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <a href="{{ route('pengajuan.index') }}"
                       class="group flex items-center gap-3 px-4 py-2.5 text-sm rounded-xl 
                              transition-all duration-200
                              {{ request()->routeIs('pengajuan.*') 
                                  ? 'bg-emerald-50 text-emerald-700 shadow-sm' 
                                  : 'hover:bg-emerald-50/70 text-slate-600' }}">

                        <span class="inline-flex w-8 h-8 items-center justify-center rounded-lg 
                                     {{ request()->routeIs('pengajuan.*') 
                                         ? 'bg-emerald-100 text-emerald-600' 
                                         : 'bg-slate-100 text-slate-500 group-hover:bg-emerald-100 group-hover:text-emerald-600' }}">
                            <svg viewBox="0 0 24 24" class="w-4 h-4">
                                <path d="M6 7h12M6 12h12M6 17h8"
                                      class="fill-none stroke-current" stroke-width="1.6" stroke-linecap="round" />
                            </svg>
                        </span>
                        <span class="font-medium">Riwayat Pengajuan</span>
                    </a>

                    @if(auth()->user() && auth()->user()->isAdmin())
                    <div class="my-4 border-t border-slate-100"></div>
                    
                    <div class="px-2 mb-2 text-xs font-semibold text-emerald-800/70 uppercase tracking-wider">
                        Administrator
                    </div>

                    <a href="{{ route('admin.transport.index') }}"
                       class="group flex items-center gap-3 px-4 py-2.5 text-sm rounded-xl 
                              transition-all duration-200
                              {{ request()->routeIs('admin.transport.*') 
                                  ? 'bg-emerald-50 text-emerald-700 shadow-sm' 
                                  : 'hover:bg-emerald-50/70 text-slate-600' }}">

                        <span class="inline-flex w-8 h-8 items-center justify-center rounded-lg 
                                     {{ request()->routeIs('admin.transport.*') 
                                         ? 'bg-emerald-100 text-emerald-600' 
                                         : 'bg-slate-100 text-slate-500 group-hover:bg-emerald-100 group-hover:text-emerald-600' }}">
                            <svg viewBox="0 0 24 24" class="w-4 h-4">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"
                                      class="fill-none stroke-current" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="font-medium">Panel Admin</span>
                    </a>
                    @endif
                @endif

            </nav>

            <!-- Logout -->
            <div class="px-4 py-5 border-t border-emerald-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full px-4 py-2.5 text-sm rounded-xl 
                               bg-emerald-600 
                               text-white font-medium 
                               hover:bg-emerald-700 
                               active:scale-[0.99] transition-all shadow-md shadow-emerald-500/20">
                        Keluar (Logout)
                    </button>
                </form>
            </div>

        </aside>

        <!-- Main Content -->
        <main class="flex-1 px-10 py-10 overflow-auto">
            <div class="max-w-6xl mx-auto">

                <!-- Status Alert -->
                @if (session('status'))
                    <div class="mb-6 rounded-2xl bg-emerald-50 
                                border border-emerald-200 
                                px-5 py-4 shadow-sm flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-600 mt-0.5" 
                             viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                        </svg>
                        <p class="text-sm text-emerald-800">
                            {{ session('status') }}
                        </p>
                    </div>
                @endif

                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-100 p-8">
                    {{ $slot }}
                </div>

            </div>
        </main>

    </div>
</body>
</html>