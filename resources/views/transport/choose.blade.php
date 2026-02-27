<x-app-layout>
    <div class="max-w-4xl mx-auto px-6 py-12">

        <!-- Header -->
        <div class="text-center space-y-2 mb-12">
            <h1 class="text-2xl font-semibold text-emerald-900">
                Pilih Jenis Transportasi
            </h1>
            <p class="text-sm text-emerald-800/80">
                Pilih layanan untuk melanjutkan pengajuan.
            </p>
        </div>

        <!-- Options -->
        <div class="grid md:grid-cols-2 gap-8">

            <!-- Ambulance -->
            <a href="{{ route('pengajuan.ambulance.create') }}"
               class="group flex flex-col items-center justify-center
                      rounded-3xl border border-emerald-100 bg-white
                      py-12 transition-all duration-300
                      hover:border-emerald-400 hover:shadow-md">

                <!-- Icon -->
                <div class="flex items-center justify-center
                            w-20 h-20 rounded-2xl
                            bg-emerald-50 text-emerald-600
                            group-hover:bg-emerald-100 transition">

                    <svg viewBox="0 0 24 24" class="w-10 h-10"
                         fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 13v3a2 2 0 0 0 2 2h1"/>
                        <path d="M17 18h2a2 2 0 0 0 2-2v-3"/>
                        <path d="M3 13l2-5a2 2 0 0 1 2-1h6"/>
                        <path d="M13 7h3l3 4v2H3"/>
                        <circle cx="7.5" cy="18" r="1.5"/>
                        <circle cx="16.5" cy="18" r="1.5"/>
                        <path d="M9 4v3M7.5 5.5h3"/>
                    </svg>
                </div>

                <!-- Text -->
                <div class="mt-6 text-lg font-semibold text-emerald-900
                            group-hover:text-emerald-600 transition">
                    Ambulance
                </div>
            </a>


            <!-- Mobil Umum -->
            <a href="{{ route('pengajuan.umum.create') }}"
               class="group flex flex-col items-center justify-center
                      rounded-3xl border border-emerald-100 bg-white
                      py-12 transition-all duration-300
                      hover:border-emerald-400 hover:shadow-md">

                <!-- Icon -->
                <div class="flex items-center justify-center
                            w-20 h-20 rounded-2xl
                            bg-emerald-50 text-emerald-600
                            group-hover:bg-emerald-100 transition">

                    <svg viewBox="0 0 24 24" class="w-10 h-10"
                         fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 13l2-5a2 2 0 0 1 2-1h6a2 2 0 0 1 2 1l2 5"/>
                        <path d="M3 13v3a2 2 0 0 0 2 2h1"/>
                        <path d="M21 13v3a2 2 0 0 1-2 2h-1"/>
                        <circle cx="7.5" cy="18" r="1.5"/>
                        <circle cx="16.5" cy="18" r="1.5"/>
                    </svg>
                </div>

                <!-- Text -->
                <div class="mt-6 text-lg font-semibold text-emerald-900
                            group-hover:text-emerald-600 transition">
                    Mobil Umum
                </div>
            </a>

        </div>

    </div>
</x-app-layout>