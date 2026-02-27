<x-app-layout>
    <div class="max-w-5xl space-y-8">
        <!-- Welcome Header -->
        <div class="section-divider">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="space-y-3">
                    <h1 class="text-3xl md:text-4xl font-bold">
                        <span class="text-gradient">Selamat datang</span>
                        <span class="text-slate-900 block">di Aplikasi Pengajuan Transportasi</span>
                    </h1>
                    <p class="text-base text-slate-600">
                        Aplikasi ini membantu unit kerja mengajukan kebutuhan 
                        <span class="font-semibold text-slate-800">Mobil Umum</span> dan
                        <span class="font-semibold text-slate-800">Ambulance</span> secara terencana, tercatat, dan mudah dipantau.
                    </p>
                </div>
                <div class="shrink-0">
                    <div class="card-left-accent card-left-accent-green p-5 max-w-xs">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="icon-wrapper">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                                </svg>
                            </div>
                            <div class="font-semibold text-slate-900">Status Akun</div>
                        </div>
                        <div class="text-sm space-y-1">
                            <div>
                                <span class="font-medium text-slate-900">{{ auth()->user()->name }}</span>
                            </div>
                            <div class="text-slate-600 text-xs">
                                📍 {{ auth()->user()->unit_kerja ?? 'Unit kerja belum diisi' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Cards -->
        <div class="grid md:grid-cols-3 gap-5">
            <!-- Mobil Umum Card -->
            <div class="card-accent overflow-hidden group">
                <div class="p-5 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="icon-wrapper-yellow">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.22.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm11 0c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zM5 11l1.5-4.5h11L19 11H5z"/>
                            </svg>
                        </div>
                        <div class="font-semibold text-slate-900">Mobil Umum</div>
                    </div>
                    <p class="text-sm text-slate-600">Untuk keperluan seperti pembelian/pengambilan obat, permintaan darah, pengantaran dokumen, dan logistik lainnya.</p>
                    <div class="pt-2">
                        <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 text-xs font-medium rounded-full">Umum</span>
                    </div>
                </div>
            </div>

            <!-- Ambulance Card -->
            <div class="card-accent overflow-hidden group">
                <div class="p-5 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="icon-wrapper-teal">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M22 10.5V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v4.5H0v3h2v7c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2v-7h2v-3h-2zM4 6h16v4.5H4V6zm8 15c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm8 0c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                            </svg>
                        </div>
                        <div class="font-semibold text-slate-900">Ambulance</div>
                    </div>
                    <p class="text-sm text-slate-600">Untuk antar / jemput pasien dari dan ke rumah sakit sesuai prosedur medis yang berlaku.</p>
                    <div class="pt-2">
                        <span class="inline-block px-3 py-1 bg-teal-100 text-teal-800 text-xs font-medium rounded-full">Medis</span>
                    </div>
                </div>
            </div>

            <!-- Riwayat Card -->
            <div class="card-accent overflow-hidden group">
                <div class="p-5 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="icon-wrapper">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M11 17c0 .55-.45 1-1 1H8c-.55 0-1-.45-1-1v-4c0-.55.45-1 1-1h2c.55 0 1 .45 1 1v4zm-2-3h-2v3h2v-3zm3-5h2c.55 0 1 .45 1 1v7c0 .55-.45 1-1 1h-2c-.55 0-1-.45-1-1v-7c0-.55.45-1 1-1zm2 6h-2v-5h2v5zm3-9h2c.55 0 1 .45 1 1v10c0 .55-.45 1-1 1h-2c-.55 0-1-.45-1-1v-10c0-.55.45-1 1-1zm2 9h-2v-8h2v8zM5 5h2v2H5V5zm0 4h2v2H5V9z"/>
                            </svg>
                        </div>
                        <div class="font-semibold text-slate-900">Riwayat Pengajuan</div>
                    </div>
                    <p class="text-sm text-slate-600">Melihat daftar pengajuan transportasi yang pernah diajukan oleh unit kerja Anda.</p>
                    <div class="pt-2">
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">Laporan</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap items-center gap-3 pt-4">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-lg bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-6 py-3 text-sm font-medium hover:shadow-lg hover:opacity-90 transition-all">
                <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                </svg>
                Dashboard Pengajuan
            </a>
            <a href="{{ route('pengajuan.index') }}" class="text-sm text-emerald-700 hover:text-emerald-900 font-medium hover:underline decoration-2 underline-offset-2">
                Lihat Riwayat Pengajuan →
            </a>
        </div>
    </div>
</x-app-layout>

