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
               class="group relative overflow-hidden flex flex-col items-center justify-center
                      rounded-xl px-4 py-5 sm:px-5 sm:py-6 transition-all duration-200
                      hover:shadow-lg hover:-translate-y-0.5"
               style="border: 1.5px solid #00685E; background-color: #e6f2f1;">

                <!-- Icon + Label -->
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 rounded-xl bg-white/90 flex items-center justify-center shadow-sm"
                         style="border: 1px solid #00685E;">
                        <img src="{{ asset('images/ambulance-icon.png') }}"
                            alt="Ambulance Icon"
                            class="w-8 h-8 object-contain">
                    </div>
                    <div class="text-left">
                        <div class="text-base font-semibold" style="color: #00685E;">Ambulance</div>
                        <p class="text-[11px] mt-0.5" style="color: #00685E;">Layanan darurat medis</p>
                    </div>
                </div>
            </a>

            <!-- Mobil Umum -->
            <a href="{{ route('pengajuan.umum.create') }}"
               class="group relative overflow-hidden flex flex-col items-center justify-center
                      rounded-xl px-4 py-5 sm:px-5 sm:py-6 transition-all duration-200
                      hover:shadow-lg hover:-translate-y-0.5"
               style="border: 1.5px solid #00685E; background-color: #e8f4e0;">

                <!-- Icon + Label -->
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 rounded-xl bg-white/90 flex items-center justify-center shadow-sm"
                         style="border: 1px solid #00685E;">
                        <img src="{{ asset('images/umum-icon.png') }}"
                            alt="Mobil Umum Icon"
                            class="w-8 h-8 object-contain">
                    </div>
                    <div class="text-left">
                        <div class="text-base font-semibold" style="color: #00685E;">Mobil Umum</div>
                        <p class="text-[11px] mt-0.5" style="color: #00685E;">Transportasi umum</p>
                    </div>
                </div>
            </a>

        </div>

    </div>
</x-app-layout>
