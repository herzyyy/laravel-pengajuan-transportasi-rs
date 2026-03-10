<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Transportasi RSAzra') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex flex-col">

        {{-- Header --}}
        <header class="sticky top-0 z-40 backdrop-blur-md bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-500 shadow-md">
            <div class="px-4 sm:px-6 py-3 flex items-center justify-between">
                {{-- Mobile Menu Button --}}
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden flex items-center justify-center w-9 h-9 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 hover:bg-white/30 transition">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
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
                    @if (auth()->user()->isAdmin())
                        {{-- Notification Dropdown for Admin --}}
                        @php
                            $pendingRequests = \App\Models\TransportRequest::where('status', 'diajukan')
                                ->latest()
                                ->limit(5)
                                ->get();
                            $pendingCount = $pendingRequests->count();
                        @endphp
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="relative flex items-center justify-center w-9 h-9 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 hover:bg-white/30 transition group">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                @if($pendingCount > 0)
                                    <span class="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-amber-500 rounded-full shadow-lg">
                                        {{ $pendingCount > 9 ? '9+' : $pendingCount }}
                                    </span>
                                @endif
                            </button>

                            {{-- Dropdown --}}
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl ring-1 ring-slate-200 z-50"
                                 style="display: none;">
                                
                                {{-- Header --}}
                                <div class="px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                                    <h3 class="text-sm font-semibold text-slate-800">Pengajuan Baru</h3>
                                    @if($pendingCount > 0)
                                        <a href="{{ route('admin.transport.index', ['status' => 'diajukan']) }}" 
                                           class="text-xs font-medium text-emerald-600 hover:text-emerald-700">
                                            Lihat Semua
                                        </a>
                                    @endif
                                </div>

                                {{-- Notification List --}}
                                <div class="max-h-96 overflow-y-auto">
                                    @forelse($pendingRequests as $request)
                                        <div class="px-4 py-3 border-b border-slate-100 last:border-0">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm text-slate-900 font-medium">
                                                        <span class="font-semibold">{{ $request->user->full_name ?? $request->pemohon_nama }}</span>
                                                    </p>
                                                    <p class="text-xs text-slate-600 mt-0.5">
                                                        Mengajukan {{ ucfirst($request->jenis) }}
                                                        @if($request->prioritas === 'segera')
                                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-red-100 text-red-700 ml-1">
                                                                CITO
                                                            </span>
                                                        @endif
                                                    </p>
                                                    <p class="text-xs text-slate-500 mt-0.5">
                                                        {{ $request->tanggal->format('d M Y') }} • {{ $request->user->unit_kerja ?? $request->pemohon_unit }}
                                                    </p>
                                                    <p class="text-xs text-slate-400 mt-1">
                                                        {{ $request->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                                        Baru
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="px-4 py-8 text-center">
                                            <svg class="w-12 h-12 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <p class="text-sm text-slate-500 font-medium">Tidak ada pengajuan baru</p>
                                            <p class="text-xs text-slate-400 mt-1">Pengajuan yang masuk akan muncul di sini</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (!auth()->user()->isAdmin())
                        {{-- Notification Dropdown for User --}}
                        @php
                            $approvedRequests = \App\Models\TransportRequest::where('user_id', auth()->id())
                                ->where('status', 'diproses')
                                ->latest()
                                ->limit(5)
                                ->get();
                            $approvedCount = $approvedRequests->count();
                        @endphp
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="relative flex items-center justify-center w-9 h-9 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 hover:bg-white/30 transition group">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                @if($approvedCount > 0)
                                    <span class="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-red-500 rounded-full shadow-lg">
                                        {{ $approvedCount > 9 ? '9+' : $approvedCount }}
                                    </span>
                                @endif
                            </button>

                            {{-- Dropdown --}}
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl ring-1 ring-slate-200 z-50"
                                 style="display: none;">
                                
                                {{-- Header --}}
                                <div class="px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                                    <h3 class="text-sm font-semibold text-slate-800">Notifikasi</h3>
                                    @if($approvedCount > 0)
                                        <a href="{{ route('pengajuan.index', ['status' => 'diproses']) }}" 
                                           class="text-xs font-medium text-emerald-600 hover:text-emerald-700">
                                            Lihat Semua
                                        </a>
                                    @endif
                                </div>

                                {{-- Notification List --}}
                                <div class="max-h-96 overflow-y-auto">
                                    @forelse($approvedRequests as $request)
                                        <div class="px-4 py-3 border-b border-slate-100 last:border-0">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm text-slate-900 font-medium">
                                                        Pengajuan <span class="font-semibold">{{ ucfirst($request->jenis) }}</span> Disetujui
                                                    </p>
                                                    <p class="text-xs text-slate-500 mt-0.5">
                                                        {{ $request->tanggal->format('d M Y') }} • {{ $request->unit_mobil ?? 'Menunggu unit' }}
                                                    </p>
                                                    <p class="text-xs text-slate-400 mt-1">
                                                        {{ $request->updated_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">
                                                        Disetujui
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="px-4 py-8 text-center">
                                            <svg class="w-12 h-12 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                            </svg>
                                            <p class="text-sm text-slate-500 font-medium">Tidak ada notifikasi</p>
                                            <p class="text-xs text-slate-400 mt-1">Pengajuan yang disetujui akan muncul di sini</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-lg border border-white/30">
                        <div class="w-2 h-2 rounded-full bg-white shadow-sm"></div>
                        <div class="text-xs">
                            <span class="text-emerald-50">{{ auth()->user()->isAdmin() ? 'Admin' : 'User' }}:</span>
                            <span class="font-semibold text-white ml-1">{{ auth()->user()->full_name }}</span>
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

        <div class="flex flex-1 relative">

            {{-- Mobile Sidebar Overlay --}}
            <div x-show="sidebarOpen" 
                 @click="sidebarOpen = false"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden"
                 style="display: none;">
            </div>

            {{-- Sidebar --}}
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
                   class="fixed lg:static inset-y-0 left-0 z-50 w-64 lg:w-56 bg-gradient-to-b from-emerald-50 to-white border-r border-emerald-100 flex flex-col shadow-lg lg:shadow-none transition-transform duration-300 ease-in-out lg:translate-x-0">
                <div class="px-3 py-4 border-b border-emerald-100">
                    <div class="rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 px-3 py-2.5 shadow-md text-white">
                        <div class="flex items-center gap-2 mb-1.5">
                            <div class="w-1.5 h-1.5 rounded-full bg-white shadow-sm"></div>
                            <div class="text-[10px] uppercase tracking-wider text-emerald-100 font-semibold">
                                {{ auth()->user()->isAdmin() ? 'Administrator' : 'Pegawai' }}
                            </div>
                        </div>
                        <div class="text-sm font-semibold truncate">
                            {{ auth()->user()->full_name }}
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
                            <span class="font-medium">Pengajuan</span>
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
            <main class="flex-1 px-3 sm:px-6 py-4 sm:py-6 bg-slate-50 lg:ml-0">
                <div class="max-w-7xl mx-auto">

                    @if (session('status'))
                        <div class="mb-4 rounded-lg bg-emerald-50 
                                    text-emerald-800 border border-emerald-200 
                                    px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm shadow-sm">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 sm:p-6">
                        {{ $slot }}
                    </div>

                </div>
            </main>

        </div>
    </div>
</body>
</html>