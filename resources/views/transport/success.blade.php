<x-app-layout>
    <div class="space-y-8 max-w-6xl mx-auto px-6 py-8">

        <!-- Success Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 p-[1px] shadow-xl">
            <div class="bg-white rounded-2xl px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-center w-14 h-14 rounded-xl bg-emerald-50">
                        <svg class="w-7 h-7 text-emerald-600" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                            Pengajuan Berhasil Dikirim
                        </h1>
                        <p class="text-slate-500 mt-1">
                            Nomor referensi:
                            <span class="font-semibold text-emerald-600">#{{ $item->id }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid md:grid-cols-2 gap-6">

            <!-- Card Style Upgrade -->
            <div class="card-accent bg-white border border-slate-200/70 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300">
                <div class="p-6 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold tracking-wide text-slate-700 uppercase">
                            Jenis Pengajuan
                        </span>
                    </div>

                    <div class="space-y-2">
                        <div class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide
                            @if($item->jenis === 'ambulance') 
                                bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200
                            @else 
                                bg-amber-50 text-amber-700 ring-1 ring-amber-200
                            @endif">
                            {{ strtoupper($item->jenis) }}
                        </div>

                        @if ($item->keperluan)
                            <p class="text-sm text-slate-600 leading-relaxed">
                                <span class="font-medium text-slate-800">Keperluan:</span>
                                {{ $item->keperluan }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Jadwal -->
            <div class="card-accent bg-white border border-slate-200/70 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300">
                <div class="p-6 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-teal-50 text-teal-600">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold tracking-wide text-slate-700 uppercase">
                            Jadwal Penggunaan
                        </span>
                    </div>

                    <div class="text-sm space-y-2">
                        <div>
                            <span class="text-slate-400">Dari</span>
                            <p class="font-semibold text-slate-900">
                                {{ $item->tanggal?->format('d/m/Y') }}
                                {{ substr($item->jam, 0, 5) }}
                            </p>
                        </div>

                        @if ($item->tanggal_sampai && $item->jam_sampai)
                        <div>
                            <span class="text-slate-400">Sampai</span>
                            <p class="font-semibold text-slate-900">
                                {{ $item->tanggal_sampai?->format('d/m/Y') }}
                                {{ substr($item->jam_sampai, 0, 5) }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Kontak -->
            <div class="card-accent bg-white border border-slate-200/70 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300">
                <div class="p-6 space-y-3">
                    <span class="text-sm font-semibold tracking-wide text-slate-700 uppercase">
                        Kontak
                    </span>
                    <p class="text-base font-semibold text-slate-900">
                        {{ $item->kontak }}
                    </p>
                </div>
            </div>

            <!-- Rute -->
            <div class="card-accent bg-white border border-slate-200/70 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300">
                <div class="p-6 space-y-3">
                    <span class="text-sm font-semibold tracking-wide text-slate-700 uppercase">
                        Rute Perjalanan
                    </span>

                    <div class="text-sm space-y-2">
                        <p>
                            <span class="text-slate-400">Asal:</span>
                            <span class="font-medium text-slate-800">
                                {{ $item->alamat_asal ?? '-' }}
                            </span>
                        </p>
                        <p>
                            <span class="text-slate-400">Tujuan:</span>
                            <span class="font-medium text-slate-800">
                                {{ $item->alamat_tujuan ?? '-' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Alamat Pasien -->
            @if ($item->jenis === 'ambulance' && $item->alamat_pasien)
                <div class="card-accent md:col-span-2 bg-white border border-slate-200/70 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="p-6 space-y-3">
                        <span class="text-sm font-semibold tracking-wide text-slate-700 uppercase">
                            Alamat Pasien
                        </span>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            {{ $item->alamat_pasien }}
                        </p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Status Section -->
        <div class="rounded-2xl bg-emerald-50 border border-emerald-100 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500 font-medium">
                        Status Pengajuan
                    </p>
                    <p class="text-xl font-bold text-emerald-700 mt-1">
                        {{ ucfirst($item->status) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap items-center gap-4 pt-2">
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-6 py-3 font-semibold shadow-md hover:shadow-lg hover:scale-[1.02] transition-all duration-300">
                Buat Pengajuan Baru
            </a>

            <a href="{{ route('pengajuan.index') }}"
               class="inline-flex items-center rounded-xl border border-slate-300 px-6 py-3 text-slate-700 font-semibold hover:bg-slate-50 hover:border-slate-400 transition-all duration-300">
                Lihat Riwayat
            </a>
        </div>

    </div>
</x-app-layout>