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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex flex-col">

        {{-- Header --}}
        <header class="sticky top-0 z-40 bg-white shadow-sm {{ auth()->user()->isAdmin() ? 'lg:pl-64' : (auth()->user()->isDriver() ? '' : 'lg:pl-64') }}" style="border-bottom: 2px solid #007774;">
            <div class="px-4 sm:px-6 py-3 flex items-center justify-between">
                {{-- Mobile Menu Button (hanya untuk admin) --}}
                @if(!auth()->user()->isDriver())
                <button @click="sidebarOpen = !sidebarOpen" class="{{ auth()->user()->isAdmin() ? 'lg:hidden' : 'hidden' }} flex items-center justify-center w-9 h-9 rounded-lg transition" style="background: rgba(0,119,116,0.1); border: 1px solid rgba(0,119,116,0.2);">
                    <svg class="w-5 h-5" style="color: #007774;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                @else
                {{-- tidak ada spacer, logo langsung di kiri --}}
                @endif
                <div class="flex items-center gap-3 min-w-0 {{ auth()->user()->isDriver() ? '' : 'lg:hidden' }}">
                    <div class="rounded-lg p-1.5">
                        <img src="{{ asset('images/logo.png') }}" alt="RS Azra" class="h-10 w-auto">
                    </div>
                    <div>
                        <div class="text-xs font-semibold" style="color: #81BD41;">
                            RS Azra
                        </div>
                        <div class="font-semibold text-base tracking-tight" style="color: #007774;">
                            Sistem Pengajuan Transportasi
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4 ml-auto">
                    @if (auth()->user()->isAdmin())
                        {{-- Notification Dropdown for Admin --}}
                        @php
                            $pendingRequests = \App\Models\TransportRequest::where('status', 'diajukan')
                                ->latest()
                                ->limit(5)
                                ->get();
                            $pendingCount = $pendingRequests->count();
                            
                            $todayReminders = \App\Models\TransportRequest::with(['user', 'driver'])
                                ->where('status', 'diproses')
                                ->whereDate('tanggal', today())
                                ->orderBy('jam', 'asc')
                                ->limit(5)
                                ->get();
                            $reminderCount = $todayReminders->count();
                            
                            $totalNotifications = $pendingCount + $reminderCount;
                        @endphp
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="header-btn relative flex items-center justify-center w-9 h-9 rounded-lg transition group"
                                    style="background: rgba(0,119,116,0.08); border: 1px solid rgba(0,119,116,0.15);">
                                <svg class="w-5 h-5" style="color: #007774;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                @if($totalNotifications > 0)
                                    <span class="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-amber-500 rounded-full shadow-lg">
                                        {{ $totalNotifications > 9 ? '9+' : $totalNotifications }}
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
                                
                                {{-- Reminder Section --}}
                                @if($reminderCount > 0)
                                    <div class="px-4 py-3 bg-blue-50 border-b border-blue-200">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-sm font-semibold text-blue-900">Reminder Hari Ini</h3>
                                            <a href="{{ route('admin.transport.index', ['status' => 'diproses']) }}" 
                                               class="text-xs font-medium text-blue-700 hover:text-blue-800">
                                                Lihat Semua
                                            </a>
                                        </div>
                                    </div>
                                    <div class="max-h-64 overflow-y-auto border-b border-slate-200">
                                        @foreach($todayReminders as $reminder)
                                            <a href="{{ route('admin.transport.show', $reminder) }}" class="block px-4 py-3 border-b border-slate-100 last:border-0 hover:bg-blue-50 transition">
                                                <div class="flex items-start gap-3">
                                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm text-slate-900 font-medium">
                                                            <span class="font-semibold">{{ $reminder->user->full_name ?? $reminder->pemohon_nama }}</span>
                                                        </p>
                                                        <p class="text-xs text-slate-600 mt-0.5">
                                                            {{ ucfirst($reminder->jenis) }} • {{ $reminder->jam }}
                                                            @if($reminder->prioritas === 'segera')
                                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-red-100 text-red-700 ml-1">
                                                                    CITO
                                                                </span>
                                                            @endif
                                                        </p>
                                                        <p class="text-xs text-slate-500 mt-0.5">
                                                            {{ $reminder->unit_mobil ?? 'Menunggu unit' }}
                                                            @if($reminder->driver)
                                                                • {{ $reminder->driver->name }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">
                                                            Disetujui
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Pending Requests Section --}}
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
                                <div class="max-h-64 overflow-y-auto">
                                    @forelse($pendingRequests as $request)
                                        <div class="px-4 py-3 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition">
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

                    @if (!auth()->user()->isAdmin() && !auth()->user()->isDriver())
                        {{-- Notification Dropdown for User --}}
                        @php
                            $approvedRequests = \App\Models\TransportRequest::where('user_id', auth()->id())
                                ->whereIn('status', ['diproses', 'digunakan'])
                                ->whereDate('updated_at', today())
                                ->latest()
                                ->limit(5)
                                ->get();
                            $approvedCount = $approvedRequests->count();
                        @endphp
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="header-btn relative flex items-center justify-center w-9 h-9 rounded-lg transition group"
                                    style="background: rgba(0,119,116,0.08); border: 1px solid rgba(0,119,116,0.15);">
                                <svg class="w-5 h-5" style="color: #007774;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                        <a href="{{ route('pengajuan.index') }}" 
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
                                                @if($request->status === 'digunakan')
                                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-cyan-500 to-teal-600 flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                        </svg>
                                                    </div>
                                                @else
                                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm text-slate-900 font-medium">
                                                        Pengajuan <span class="font-semibold">{{ ucfirst($request->jenis) }}</span> 
                                                        {{ $request->status === 'digunakan' ? 'Sedang Digunakan' : 'Disetujui' }}
                                                    </p>
                                                    <p class="text-xs text-slate-500 mt-0.5">
                                                        {{ $request->tanggal->format('d M Y') }} • {{ $request->unit_mobil ?? 'Menunggu unit' }}
                                                    </p>
                                                    <p class="text-xs text-slate-400 mt-1">
                                                        {{ $request->updated_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    @if($request->status === 'digunakan')
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-cyan-100 text-cyan-800">
                                                            Digunakan
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">
                                                            Disetujui
                                                        </span>
                                                    @endif
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
                    
                    @if(auth()->user()->isDriver())
                        {{-- Tombol Riwayat untuk Supir — hanya tampil di desktop --}}
                        <a href="{{ route('driver.history') }}"
                           class="header-btn hidden lg:flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg transition"
                           style="color: #007774; background: rgba(0,119,116,0.08); border: 1px solid rgba(0,119,116,0.2);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round">
                                <path d="M6 7h12M6 12h12M6 17h8"/>
                            </svg>
                            <span>Riwayat</span>
                        </a>

                        {{-- Info User untuk Supir di Header — hanya desktop --}}
                        <div class="relative hidden lg:flex" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 focus:outline-none" style="color: #007774;">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full" style="background: rgba(0,119,116,0.1); border: 1px solid rgba(0,119,116,0.2);">
                                    <svg class="w-4 h-4" style="color: #007774;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div class="hidden sm:block leading-tight text-left">
                                    <div class="text-xs font-semibold text-slate-800">{{ auth()->user()->full_name }}</div>
                                    <div class="text-[10px]" style="color: #007774;">Supir</div>
                                </div>
                                <svg class="sm:hidden w-3 h-3 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            {{-- Dropdown hanya muncul di mobile (sm ke bawah) --}}
                            <div x-show="open"
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="sm:hidden absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl ring-1 ring-slate-200 z-50 overflow-hidden"
                                 style="display: none;">
                                <div class="px-4 py-3 bg-emerald-50 border-b border-emerald-100">
                                    <div class="text-[10px] uppercase tracking-wider text-emerald-600 font-semibold mb-1">Supir</div>
                                    <div class="text-sm font-semibold text-slate-800 truncate">{{ auth()->user()->full_name }}</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="{{ !auth()->user()->isAdmin() && !auth()->user()->isDriver() ? 'hidden lg:flex' : (auth()->user()->isDriver() ? 'hidden lg:flex' : 'flex') }} header-btn items-center gap-2 px-3 py-1.5 text-xs font-medium rounded-lg transition"
                            style="color: #007774; border: 1px solid rgba(0,119,116,0.3); background: rgba(0,119,116,0.06);">
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

            {{-- Mobile Sidebar Overlay (admin only on mobile) --}}
            @if(!auth()->user()->isDriver())
            <div x-show="sidebarOpen" 
                 @click="sidebarOpen = false"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900/50 z-30 {{ !auth()->user()->isAdmin() ? 'lg:hidden' : 'lg:hidden' }}"
                 style="display: none;">
            </div>

            {{-- Sidebar: selalu tampil di desktop, di mobile hanya untuk admin --}}
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
                   class="fixed left-0 top-0 bottom-0 z-40 w-64 bg-white flex flex-col transition-transform duration-300 ease-in-out overflow-y-auto
                          {{ auth()->user()->isAdmin() ? 'lg:translate-x-0' : 'lg:translate-x-0 hidden lg:flex' }}"
                   style="border-right: 1px solid #e2eded; box-shadow: 2px 0 8px rgba(0,0,0,0.04);">
                @if(!auth()->user()->isDriver())
                {{-- Branding --}}
                <div class="px-4 pt-5 pb-4" style="border-bottom: 1px solid #e8f0ef;">
                    <div class="flex items-center gap-3 mb-1">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto flex-shrink-0 object-contain">
                        <div class="text-lg font-bold leading-tight tracking-wide uppercase" style="color: #007774;">SiPetrans</div>
                    </div>
                    <div class="text-sm font-medium text-slate-500 mb-6 pl-0.5">Sistem Pengajuan Transportasi</div>
                    {{-- Profil --}}
                    <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg" style="background: rgba(0,119,116,0.04);">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0"
                             style="background-color: #007774;">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="text-sm font-semibold text-slate-800 truncate">{{ auth()->user()->full_name }}</div>
                            <div class="text-xs font-medium truncate" style="color: #007774;">
                                {{ auth()->user()->isAdmin() ? 'Administrator' : 'Pegawai' }}
                            </div>
                            @if(auth()->user()->unit_kerja)
                            <div class="text-xs text-slate-400 truncate">{{ auth()->user()->unit_kerja }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <nav class="flex-1 px-2 py-3 space-y-0.5">
                    @if (auth()->user()->isAdmin())
                        {{-- Sidebar untuk Admin --}}
                        <a href="{{ route('admin.dashboard') }}"
                           @click="sidebarOpen = false"
                           class="sidebar-link group flex items-center gap-2.5 px-3 py-2 text-sm rounded-lg transition-all duration-150
                                  {{ request()->routeIs('admin.dashboard') ? 'sidebar-link-active' : '' }}">
                            <span class="sidebar-icon inline-flex w-7 h-7 items-center justify-center rounded-md transition-all duration-150">
                                <svg viewBox="0 0 24 24" class="w-4 h-4">
                                    <path d="M4 11.5 12 5l8 6.5V20H4v-8.5Z" class="fill-none stroke-current" stroke-width="2" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('admin.transport.index') }}"
                           @click="sidebarOpen = false"
                           class="sidebar-link group flex items-center gap-2.5 px-3 py-2 text-sm rounded-lg transition-all duration-150
                                  {{ request()->routeIs('admin.transport.*') ? 'sidebar-link-active' : '' }}">
                            <span class="sidebar-icon inline-flex w-7 h-7 items-center justify-center rounded-md transition-all duration-150">
                                <svg viewBox="0 0 24 24" class="w-4 h-4">
                                    <path d="M6 7h12M6 12h12M6 17h8" class="fill-none stroke-current" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </span>
                            <span class="font-medium">Daftar Pengajuan</span>
                        </a>

                        <a href="{{ route('admin.laporan') }}"
                           @click="sidebarOpen = false"
                           class="sidebar-link group flex items-center gap-2.5 px-3 py-2 text-sm rounded-lg transition-all duration-150
                                  {{ request()->routeIs('admin.laporan') ? 'sidebar-link-active' : '' }}">
                            <span class="sidebar-icon inline-flex w-7 h-7 items-center justify-center rounded-md transition-all duration-150">
                                <svg viewBox="0 0 24 24" class="w-4 h-4">
                                    <path d="M9 17v-2m3 2v-4m3 4v-6M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" class="fill-none stroke-current" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="font-medium">Laporan</span>
                        </a>

                        <div class="px-3 py-2">
                            <div style="border-top: 1px solid #f0f4f4;"></div>
                            <div class="text-[10px] uppercase tracking-widest font-semibold mt-2 mb-1" style="color: #007774;">
                                Master Data
                            </div>
                        </div>

                        <a href="{{ route('admin.users.index') }}"
                           @click="sidebarOpen = false"
                           class="sidebar-link group flex items-center gap-2.5 px-3 py-2 text-sm rounded-lg transition-all duration-150
                                  {{ request()->routeIs('admin.users.*') ? 'sidebar-link-active' : '' }}">
                            <span class="sidebar-icon inline-flex w-7 h-7 items-center justify-center rounded-md transition-all duration-150">
                                <svg viewBox="0 0 24 24" class="w-4 h-4">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" class="fill-none stroke-current" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="font-medium">User / Akun</span>
                        </a>

                        <a href="{{ route('admin.vehicles.index') }}"
                           @click="sidebarOpen = false"
                           class="sidebar-link group flex items-center gap-2.5 px-3 py-2 text-sm rounded-lg transition-all duration-150
                                  {{ request()->routeIs('admin.vehicles.*') ? 'sidebar-link-active' : '' }}">
                            <span class="sidebar-icon inline-flex w-7 h-7 items-center justify-center rounded-md transition-all duration-150">
                                <svg viewBox="0 0 24 24" class="w-4 h-4">
                                    <path d="M5 17h14v-5H5v5Zm0 0v2a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-2M5 17l-2-5h18l-2 5M7 12V7a5 5 0 0 1 10 0v5" class="fill-none stroke-current" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="font-medium">Kendaraan</span>
                        </a>

                        <a href="{{ route('admin.drivers.index') }}"
                           @click="sidebarOpen = false"
                           class="sidebar-link group flex items-center gap-2.5 px-3 py-2 text-sm rounded-lg transition-all duration-150
                                  {{ request()->routeIs('admin.drivers.*') ? 'sidebar-link-active' : '' }}">
                            <span class="sidebar-icon inline-flex w-7 h-7 items-center justify-center rounded-md transition-all duration-150">
                                <svg viewBox="0 0 24 24" class="w-4 h-4">
                                    <circle cx="12" cy="8" r="4" class="fill-none stroke-current" stroke-width="2"/>
                                    <path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2" class="fill-none stroke-current" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </span>
                            <span class="font-medium">Supir</span>
                        </a>
                    @elseif(auth()->user()->isDriver())
                        {{-- Sidebar untuk Supir --}}
                        <a href="{{ route('driver.dashboard') }}"
                           @click="sidebarOpen = false"
                           class="sidebar-link group flex items-center gap-2.5 px-3 py-2 text-sm rounded-lg transition-all duration-150
                                  {{ request()->routeIs('driver.dashboard') ? 'sidebar-link-active' : '' }}">
                            <span class="sidebar-icon inline-flex w-7 h-7 items-center justify-center rounded-md transition-all duration-150">
                                <svg viewBox="0 0 24 24" class="w-4 h-4">
                                    <circle cx="12" cy="8" r="4" class="fill-none stroke-current" stroke-width="2"/>
                                    <path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2" class="fill-none stroke-current" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </span>
                            <span class="font-medium">Tugas Saya</span>
                        </a>

                        <a href="{{ route('driver.history') }}"
                           @click="sidebarOpen = false"
                           class="sidebar-link group flex items-center gap-2.5 px-3 py-2 text-sm rounded-lg transition-all duration-150
                                  {{ request()->routeIs('driver.history') ? 'sidebar-link-active' : '' }}">
                            <span class="sidebar-icon inline-flex w-7 h-7 items-center justify-center rounded-md transition-all duration-150">
                                <svg viewBox="0 0 24 24" class="w-4 h-4">
                                    <path d="M6 7h12M6 12h12M6 17h8" class="fill-none stroke-current" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </span>
                            <span class="font-medium">Riwayat</span>
                        </a>
                    @else
                        {{-- Sidebar untuk User biasa --}}
                        <a href="{{ route('dashboard') }}"
                           @click="sidebarOpen = false"
                           class="sidebar-link group flex items-center gap-2.5 px-3 py-2 text-sm rounded-lg transition-all duration-150
                                  {{ request()->routeIs('dashboard') || request()->routeIs('pengajuan.choose') || request()->routeIs('pengajuan.umum*') || request()->routeIs('pengajuan.ambulance*') ? 'sidebar-link-active' : '' }}">
                            <span class="sidebar-icon inline-flex w-7 h-7 items-center justify-center rounded-md transition-all duration-150">
                                <svg viewBox="0 0 24 24" class="w-4 h-4">
                                    <path d="M4 11.5 12 5l8 6.5V20H4v-8.5Z" class="fill-none stroke-current" stroke-width="2" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="font-medium">Pengajuan</span>
                        </a>

                        <a href="{{ route('pengajuan.index') }}"
                           @click="sidebarOpen = false"
                           class="sidebar-link group flex items-center gap-2.5 px-3 py-2 text-sm rounded-lg transition-all duration-150
                                  {{ request()->routeIs('pengajuan.index') || request()->routeIs('pengajuan.show') || request()->routeIs('pengajuan.success') ? 'sidebar-link-active' : '' }}">
                            <span class="sidebar-icon inline-flex w-7 h-7 items-center justify-center rounded-md transition-all duration-150">
                                <svg viewBox="0 0 24 24" class="w-4 h-4">
                                    <path d="M6 7h12M6 12h12M6 17h8" class="fill-none stroke-current" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </span>
                            <span class="font-medium">Riwayat</span>
                        </a>
                    @endif
                </nav>
            </aside>
            @endif

            {{-- Main Content --}}
            <main class="flex-1 min-w-0 px-3 sm:px-6 py-4 sm:py-6 bg-slate-50 {{ auth()->user()->isAdmin() ? 'lg:pl-64' : (!auth()->user()->isDriver() ? 'lg:pl-64' : '') }} {{ !auth()->user()->isAdmin() ? 'pb-20 lg:pb-6' : '' }}">
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

    {{-- Bottom Navigation Bar — untuk user biasa & driver di mobile --}}
    @if(!auth()->user()->isAdmin())
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-slate-200 shadow-[0_-2px_10px_rgba(0,0,0,0.08)]">
        <div class="flex items-stretch h-16">

            @if(auth()->user()->isDriver())
                {{-- Home --}}
                <a href="{{ route('driver.dashboard') }}"
                   class="flex-1 flex flex-col items-center justify-center gap-0.5 transition-colors relative"
                   style="{{ request()->routeIs('driver.dashboard') ? 'color: #007774;' : 'color: #94a3b8;' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round">
                        <path d="M4 11.5 12 5l8 6.5V20H4v-8.5Z"/>
                    </svg>
                    <span class="text-[10px] font-semibold">Home</span>
                    @if(request()->routeIs('driver.dashboard'))
                        <span class="absolute bottom-0 w-8 h-0.5 rounded-t-full" style="background-color: #007774;"></span>
                    @endif
                </a>

                {{-- Riwayat --}}
                <a href="{{ route('driver.history') }}"
                   class="flex-1 flex flex-col items-center justify-center gap-0.5 transition-colors relative"
                   style="{{ request()->routeIs('driver.history') ? 'color: #007774;' : 'color: #94a3b8;' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M6 7h12M6 12h12M6 17h8"/>
                    </svg>
                    <span class="text-[10px] font-semibold">Riwayat</span>
                    @if(request()->routeIs('driver.history'))
                        <span class="absolute bottom-0 w-8 h-0.5 rounded-t-full" style="background-color: #007774;"></span>
                    @endif
                </a>

                {{-- Profil --}}
                <div class="flex-1 flex flex-col items-center justify-center gap-0.5 relative"
                     x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex flex-col items-center gap-0.5 w-full transition-colors"
                            style="color: #94a3b8;">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/>
                        </svg>
                        <span class="text-[10px] font-semibold">Profil</span>
                    </button>
                    <div x-show="open"
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute bottom-full mb-2 right-0 w-56 bg-white rounded-xl shadow-xl ring-1 ring-slate-200 overflow-hidden"
                         style="display: none;">
                        <div class="px-4 py-3 border-b" style="background: rgba(0,119,116,0.05); border-color: rgba(0,119,116,0.1);">
                            <div class="text-xs font-semibold text-slate-800 truncate">{{ auth()->user()->full_name }}</div>
                            <div class="text-[10px] mt-0.5" style="color: #007774;">Supir</div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-2.5 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>

            @else
                {{-- Pengajuan --}}
                <a href="{{ route('dashboard') }}"
                   class="flex-1 flex flex-col items-center justify-center gap-0.5 transition-colors relative"
                   style="{{ request()->routeIs('dashboard') || request()->routeIs('pengajuan.choose') || request()->routeIs('pengajuan.umum*') || request()->routeIs('pengajuan.ambulance*') ? 'color: #007774;' : 'color: #94a3b8;' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round">
                        <path d="M4 11.5 12 5l8 6.5V20H4v-8.5Z"/>
                    </svg>
                    <span class="text-[10px] font-semibold">Pengajuan</span>
                    @if(request()->routeIs('dashboard') || request()->routeIs('pengajuan.choose') || request()->routeIs('pengajuan.umum*') || request()->routeIs('pengajuan.ambulance*'))
                        <span class="absolute bottom-0 w-8 h-0.5 rounded-t-full" style="background-color: #007774;"></span>
                    @endif
                </a>

                {{-- Riwayat --}}
                <a href="{{ route('pengajuan.index') }}"
                   class="flex-1 flex flex-col items-center justify-center gap-0.5 transition-colors relative"
                   style="{{ request()->routeIs('pengajuan.index') || request()->routeIs('pengajuan.show') || request()->routeIs('pengajuan.success') ? 'color: #007774;' : 'color: #94a3b8;' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M6 7h12M6 12h12M6 17h8"/>
                    </svg>
                    <span class="text-[10px] font-semibold">Riwayat</span>
                    @if(request()->routeIs('pengajuan.index') || request()->routeIs('pengajuan.show') || request()->routeIs('pengajuan.success'))
                        <span class="absolute bottom-0 w-8 h-0.5 rounded-t-full" style="background-color: #007774;"></span>
                    @endif
                </a>

                {{-- Profil --}}
                <div class="flex-1 flex flex-col items-center justify-center gap-0.5 relative"
                     x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex flex-col items-center gap-0.5 w-full transition-colors"
                            style="{{ request()->routeIs('profile.*') ? 'color: #007774;' : 'color: #94a3b8;' }}">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/>
                        </svg>
                        <span class="text-[10px] font-semibold">Profil</span>
                    </button>
                    <div x-show="open"
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute bottom-full mb-2 right-0 w-56 bg-white rounded-xl shadow-xl ring-1 ring-slate-200 overflow-hidden"
                         style="display: none;">
                        <div class="px-4 py-3 border-b" style="background: rgba(0,119,116,0.05); border-color: rgba(0,119,116,0.1);">
                            <div class="text-xs font-semibold text-slate-800 truncate">{{ auth()->user()->full_name }}</div>
                            @if(auth()->user()->unit_kerja)
                            <div class="text-[10px] text-slate-500 truncate mt-0.5">{{ auth()->user()->unit_kerja }}</div>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-2.5 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </nav>
    @endif

    </div>
</body>
</html>