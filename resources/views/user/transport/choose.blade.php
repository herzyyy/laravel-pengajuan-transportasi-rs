<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-8 sm:py-12">

        <!-- Header -->
        <div class="text-center space-y-1 mb-6">
            <h1 class="text-lg sm:text-xl font-bold text-slate-800">
                Pilih Jenis Transportasi
            </h1>
            <p class="text-xs sm:text-sm text-slate-500">
                Pilih layanan yang sesuai dan lanjutkan pengajuan dalam satu klik.
            </p>
        </div>

        <!-- Options -->
        <div class="grid sm:grid-cols-2 gap-3 max-w-2xl mx-auto">

            <!-- Ambulance -->
            <a href="{{ route('pengajuan.ambulance.create') }}"
               class="group relative overflow-hidden
                      flex flex-col items-center justify-center
                      rounded-xl border border-red-200 bg-red-50/70
                      px-4 py-5 sm:px-5 sm:py-6 transition-all duration-200
                      hover:border-red-300 hover:shadow-lg hover:-translate-y-0.5">

                <!-- Icon + Label -->
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 rounded-xl bg-white/90 border border-red-200 flex items-center justify-center shadow-sm">
                        <img src="{{ asset('images/ambulance-icon.png') }}" 
                            alt="Ambulance Icon" 
                            class="w-8 h-8 object-contain">
                    </div>
                    <div class="text-left">
                        <div class="text-base font-semibold text-red-700">Ambulance</div>
                        <p class="text-[11px] text-red-600 mt-0.5">Layanan darurat medis</p>
                    </div>
                </div>

                <span class="absolute top-2 right-2 text-xs font-medium text-red-600">Pilih</span>
            </a>


            <!-- Mobil Umum -->
            <a href="{{ route('pengajuan.umum.create') }}"
               class="group relative overflow-hidden
                      flex flex-col items-center justify-center
                      rounded-xl border border-blue-200 bg-blue-50/70
                      px-4 py-5 sm:px-5 sm:py-6 transition-all duration-200
                      hover:border-blue-300 hover:shadow-lg hover:-translate-y-0.5">

                <!-- Icon + Label -->
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 rounded-xl bg-white/90 border border-blue-200 flex items-center justify-center shadow-sm">
                        <img src="{{ asset('images/umum-icon.png') }}" 
                            alt="Mobil Umum Icon" 
                            class="w-8 h-8 object-contain">
                    </div>
                    <div class="text-left">
                        <div class="text-base font-semibold text-blue-700">Mobil Umum</div>
                        <p class="text-[11px] text-blue-600 mt-0.5">Transportasi umum</p>
                    </div>
                </div>

                <span class="absolute top-2 right-2 text-xs font-medium text-blue-600">Pilih</span>
            </a>

        </div>

    </div>
</x-app-layout>