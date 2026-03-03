<x-app-layout>
    <div class="space-y-6">
        <!-- Welcome Header -->
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-5 h-5 text-emerald-100" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                        </svg>
                        <span class="text-sm font-medium text-emerald-100">Dashboard Pengajuan</span>
                    </div>
                    <h1 class="text-2xl font-bold mb-2">
                        Selamat Datang, {{ auth()->user()->name }}!
                    </h1>
                    <p class="text-emerald-50 text-sm leading-relaxed">
                        Kelola pengajuan transportasi Mobil Umum dan Ambulance dengan mudah, terencana, dan terpantau.
                    </p>
                </div>
                <div class="hidden sm:block">
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-3 border border-white/30">
                        <div class="text-xs text-emerald-100 mb-1">Unit Kerja</div>
                        <div class="text-sm font-semibold">{{ auth()->user()->unit_kerja ?? 'Belum diisi' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg border border-slate-200 p-4 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs text-slate-500 font-medium mb-1">Total Pengajuan</div>
                        <div class="text-2xl font-bold text-slate-900">{{ auth()->user()->transportRequests()->count() }}</div>
                    </div>
                    <div class="bg-slate-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-slate-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-amber-200 p-4 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs text-amber-600 font-medium mb-1">Menunggu</div>
                        <div class="text-2xl font-bold text-amber-700">{{ auth()->user()->transportRequests()->where('status', 'diajukan')->count() }}</div>
                    </div>
                    <div class="bg-amber-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-emerald-200 p-4 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs text-emerald-600 font-medium mb-1">Selesai</div>
                        <div class="text-2xl font-bold text-emerald-700">{{ auth()->user()->transportRequests()->where('status', 'selesai')->count() }}</div>
                    </div>
                    <div class="bg-emerald-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Cards -->
        <div>
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Pilih Jenis Transportasi</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <!-- Mobil Umum Card -->
                <a href="{{ route('pengajuan.choose', ['jenis' => 'umum']) }}" 
                   class="group bg-white rounded-xl border-2 border-slate-200 hover:border-amber-400 p-6 transition-all hover:shadow-lg">
                    <div class="flex items-start gap-4">
                        <div class="bg-amber-100 rounded-xl p-3 group-hover:bg-amber-200 transition">
                            <svg class="w-8 h-8 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-amber-700 transition">Mobil Umum</h3>
                            <p class="text-sm text-slate-600 leading-relaxed mb-3">
                                Untuk keperluan pembelian/pengambilan obat, permintaan darah, pengantaran dokumen, dan logistik lainnya.
                            </p>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center px-2.5 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full">
                                    Umum
                                </span>
                                <span class="text-xs text-slate-500">• Non-medis</span>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-amber-600 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <!-- Ambulance Card -->
                <a href="{{ route('pengajuan.choose', ['jenis' => 'ambulance']) }}" 
                   class="group bg-white rounded-xl border-2 border-slate-200 hover:border-emerald-400 p-6 transition-all hover:shadow-lg">
                    <div class="flex items-start gap-4">
                        <div class="bg-emerald-100 rounded-xl p-3 group-hover:bg-emerald-200 transition">
                            <svg class="w-8 h-8 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-emerald-700 transition">Ambulance</h3>
                            <p class="text-sm text-slate-600 leading-relaxed mb-3">
                                Untuk antar/jemput pasien dari dan ke rumah sakit sesuai prosedur medis yang berlaku.
                            </p>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center px-2.5 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full">
                                    Medis
                                </span>
                                <span class="text-xs text-slate-500">• Prioritas tinggi</span>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-emerald-600 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('pengajuan.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition border border-slate-200">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                </svg>
                Lihat Semua Riwayat
            </a>
        </div>
    </div>
</x-app-layout>
