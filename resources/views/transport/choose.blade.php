<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-8 sm:py-12">

        <!-- Header -->
        <div class="text-center space-y-2 mb-8 sm:mb-12">
            <h1 class="text-xl sm:text-2xl font-bold text-slate-800">
                Pilih Jenis Transportasi
            </h1>
            <p class="text-sm text-slate-600">
                Pilih layanan untuk melanjutkan pengajuan
            </p>
        </div>

        <!-- Options -->
        <div class="grid sm:grid-cols-2 gap-4 sm:gap-6 max-w-3xl mx-auto">

            <!-- Ambulance -->
            <a href="{{ route('pengajuan.ambulance.create') }}"
               class="group relative overflow-hidden
                      flex flex-col items-center justify-center
                      rounded-2xl border-2 border-red-100 bg-gradient-to-br from-white to-red-50/30
                      p-8 sm:p-10 transition-all duration-300
                      hover:border-red-300 hover:shadow-lg hover:shadow-red-100/50 hover:-translate-y-1">

                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute inset-0" style="background-image: radial-gradient(circle, #ef4444 1px, transparent 1px); background-size: 20px 20px;"></div>
                </div>

                <!-- Icon Container -->
                <div class="relative flex items-center justify-center
                            w-28 h-28 sm:w-32 sm:h-32 rounded-3xl
                            bg-white shadow-md
                            group-hover:shadow-xl group-hover:scale-105 transition-all duration-300">
                    <img src="{{ asset('images/ambulance-icon.png') }}" 
                         alt="Ambulance Icon" 
                         class="w-16 h-16 sm:w-20 sm:h-20 object-contain drop-shadow-sm">
                </div>

                <!-- Text -->
                <div class="relative mt-6 text-center">
                    <div class="text-lg sm:text-xl font-bold text-red-600
                                group-hover:text-red-700 transition">
                        Ambulance
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Layanan darurat medis
                    </p>
                </div>

                <!-- Arrow Icon -->
                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>


            <!-- Mobil Umum -->
            <a href="{{ route('pengajuan.umum.create') }}"
               class="group relative overflow-hidden
                      flex flex-col items-center justify-center
                      rounded-2xl border-2 border-blue-100 bg-gradient-to-br from-white to-blue-50/30
                      p-8 sm:p-10 transition-all duration-300
                      hover:border-blue-300 hover:shadow-lg hover:shadow-blue-100/50 hover:-translate-y-1">

                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute inset-0" style="background-image: radial-gradient(circle, #3b82f6 1px, transparent 1px); background-size: 20px 20px;"></div>
                </div>

                <!-- Icon Container -->
                <div class="relative flex items-center justify-center
                            w-28 h-28 sm:w-32 sm:h-32 rounded-3xl
                            bg-white shadow-md
                            group-hover:shadow-xl group-hover:scale-105 transition-all duration-300">
                    <img src="{{ asset('images/umum-icon.png') }}" 
                         alt="Mobil Umum Icon" 
                         class="w-16 h-16 sm:w-20 sm:h-20 object-contain drop-shadow-sm">
                </div>

                <!-- Text -->
                <div class="relative mt-6 text-center">
                    <div class="text-lg sm:text-xl font-bold text-blue-600
                                group-hover:text-blue-700 transition">
                        Mobil Umum
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Transportasi umum
                    </p>
                </div>

                <!-- Arrow Icon -->
                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

        </div>

    </div>
</x-app-layout>