<x-app-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight text-slate-800">
            Ambulance
        </h1>
        <p class="mt-1 text-sm text-slate-500">
            Pilih keperluan ambulance: antar atau jemput.
        </p>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Antar -->
        <a href="{{ route('pengajuan.ambulance.create', ['purpose' => 'antar']) }}"
           class="group block rounded-3xl bg-white border border-slate-200 p-8 
                  hover:border-emerald-400 hover:shadow-lg transition-all duration-300">

            <div class="w-12 h-12 rounded-2xl bg-emerald-50 
                        flex items-center justify-center 
                        text-emerald-600 font-semibold text-sm mb-4 
                        group-hover:bg-emerald-100 transition">
                ANT
            </div>

            <div class="text-lg font-semibold text-slate-800">
                Antar
            </div>

            <div class="mt-2 text-sm text-slate-500 leading-relaxed">
                Mengantar pasien dari rumah sakit ke tujuan.
            </div>

            <div class="mt-6 text-sm font-medium text-emerald-600 
                        group-hover:translate-x-1 transition">
                Lanjut →
            </div>
        </a>

        <!-- Jemput -->
        <a href="{{ route('pengajuan.ambulance.create', ['purpose' => 'jemput']) }}"
           class="group block rounded-3xl bg-white border border-slate-200 p-8 
                  hover:border-emerald-400 hover:shadow-lg transition-all duration-300">

            <div class="w-12 h-12 rounded-2xl bg-emerald-50 
                        flex items-center justify-center 
                        text-emerald-600 font-semibold text-sm mb-4 
                        group-hover:bg-emerald-100 transition">
                JMP
            </div>

            <div class="text-lg font-semibold text-slate-800">
                Jemput
            </div>

            <div class="mt-2 text-sm text-slate-500 leading-relaxed">
                Menjemput pasien dari lokasi menuju rumah sakit.
            </div>

            <div class="mt-6 text-sm font-medium text-emerald-600 
                        group-hover:translate-x-1 transition">
                Lanjut →
            </div>
        </a>
    </div>

    <div class="mt-8">
        <a href="{{ route('dashboard') }}"
           class="text-sm text-slate-500 hover:text-slate-700 transition">
            ← Kembali
        </a>
    </div>
</x-app-layout>