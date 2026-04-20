<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-6 sm:py-10 space-y-6">

        <!-- Stats Cards -->
        @php
            $total    = auth()->user()->transportRequests()->count();
            $pending  = auth()->user()->transportRequests()->where('status', 'diajukan')->count();
            $approved = auth()->user()->transportRequests()->where('status', 'diproses')->count();
            $inuse    = auth()->user()->transportRequests()->where('status', 'digunakan')->count();
            $done     = auth()->user()->transportRequests()->where('status', 'selesai')->count();
            $rejected = auth()->user()->transportRequests()->where('status', 'tidak_disetujui')->count();
        @endphp
        <div class="grid grid-cols-2 sm:grid-cols-6 gap-3">
            @foreach([
                ['label'=>'Total',     'value'=>$total,    'color'=>'slate',   'path'=>'M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5z'],
                ['label'=>'Menunggu',  'value'=>$pending,  'color'=>'amber',   'path'=>'M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z'],
                ['label'=>'Disetujui', 'value'=>$approved, 'color'=>'blue',    'path'=>'M5.5 16a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 16h-8z'],
                ['label'=>'Digunakan', 'value'=>$inuse,    'color'=>'cyan',    'path'=>'M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3z'],
                ['label'=>'Selesai',   'value'=>$done,     'color'=>'emerald', 'path'=>'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z'],
                ['label'=>'Ditolak',   'value'=>$rejected, 'color'=>'red',     'path'=>'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z'],
            ] as $stat)
            <div class="bg-white border border-{{ $stat['color'] }}-200 rounded-lg px-4 py-4 flex items-center gap-3 shadow-sm hover:shadow-md transition">
                <div class="shrink-0 rounded-lg p-2.5 bg-{{ $stat['color'] }}-100">
                    <svg class="w-6 h-6 text-{{ $stat['color'] }}-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="{{ $stat['path'] }}" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-medium text-slate-500">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-bold text-slate-900 leading-none mt-0.5">{{ $stat['value'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Header -->
        <div class="text-center space-y-1">
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
