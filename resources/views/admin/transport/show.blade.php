<x-app-layout>
    <div class="max-w-5xl mx-auto px-6 pt-8">
        <div class="flex items-start justify-between gap-4 border-b border-dashed border-slate-200 pb-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Surat Pengajuan Transportasi
                </h1>
                <p class="text-slate-500 mt-1 text-sm">
                    Ringkasan singkat pengajuan dan proses oleh admin dalam satu lembar.
                </p>
            </div>

            <div class="flex items-center gap-2">
                @if($transportRequest->status === 'selesai')
                    <a href="{{ route('admin.transport.print', $transportRequest) }}"
                       target="_blank"
                       class="inline-flex items-center rounded-lg border border-emerald-600 bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700 shadow-sm">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Print Surat
                    </a>
                @endif
                <a href="{{ route('admin.transport.index') }}"
                   class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 shadow-sm">
                    Kembali ke daftar
                </a>
            </div>v>
        </div>

        @if (session('success'))
            <div class="mt-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mt-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                <div class="font-semibold mb-1">Periksa kembali data yang diisi:</div>
                <ul class="list-disc ml-4 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Card 1: Pengajuan oleh User --}}
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200">
                <div class="border-b border-slate-200 px-5 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-semibold text-slate-800">
                            Diajukan oleh Pemohon
                        </h2>
                        <p class="text-xs text-slate-500">
                            Data asli yang diisi oleh user.
                        </p>
                    </div>
                    @php
                        $colors = [
                            'diajukan' => 'bg-amber-100 text-amber-800',
                            'diproses' => 'bg-blue-100 text-blue-800',
                            'selesai' => 'bg-emerald-100 text-emerald-800',
                            'ditolak' => 'bg-red-100 text-red-800'
                        ];
                        $color = $colors[$transportRequest->status] ?? 'bg-slate-100 text-slate-800';
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $color }}">
                        Status: {{ $transportRequest->status === 'diproses' ? 'Disetujui' : ucfirst($transportRequest->status) }}
                    </span>
                </div>

                <div class="px-5 py-4 text-sm">
                    <dl class="space-y-2.5">
                        <div class="flex">
                            <dt class="w-32 text-slate-500">Tanggal</dt>
                            <dd class="flex-1 text-slate-800">
                                {{ $transportRequest->tanggal->format('d M Y') }},
                                {{ $transportRequest->jam }} s/d
                                {{ $transportRequest->tanggal_sampai->format('d M Y') }}
                                {{ $transportRequest->jam_sampai }}
                            </dd>
                        </div>

                        <div class="flex">
                            <dt class="w-32 text-slate-500">Pemohon</dt>
                            <dd class="flex-1 text-slate-800">
                                {{ $transportRequest->user->full_name ?? $transportRequest->pemohon_nama }}
                                <div class="text-xs text-slate-500">
                                    {{ $transportRequest->user->unit_kerja ?? $transportRequest->pemohon_unit }}
                                </div>
                            </dd>
                        </div>

                        <div class="flex">
                            <dt class="w-32 text-slate-500">Jenis</dt>
                            <dd class="flex-1 text-slate-800">
                                {{ ucfirst($transportRequest->jenis) }}
                                @if ($transportRequest->jenis === 'ambulance' && $transportRequest->keperluan)
                                    <span class="text-xs text-slate-500">
                                        ({{ ucfirst($transportRequest->keperluan) }})
                                    </span>
                                @endif
                            </dd>
                        </div>

                        <div class="flex">
                            <dt class="w-32 text-slate-500">Prioritas</dt>
                            <dd class="flex-1 text-slate-800">
                                @if($transportRequest->prioritas === 'segera')
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">
                                        Cito
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[11px] font-medium text-slate-600 bg-slate-100 px-2 py-0.5 rounded-full">
                                        Biasa
                                    </span>
                                @endif
                            </dd>
                        </div>

                        <div class="flex">
                            <dt class="w-32 text-slate-500">Alamat Tujuan</dt>
                            <dd class="flex-1 text-slate-800">
                                {{ $transportRequest->alamat_tujuan ?? '-' }}
                            </dd>
                        </div>

                        @if($transportRequest->driver_id)
                            <div class="border-t border-dashed border-slate-200 pt-3 mt-1"></div>
                            <div class="flex">
                                <dt class="w-32 text-slate-500">Supir</dt>
                                <dd class="flex-1 text-slate-800">
                                    <span class="font-medium">{{ $transportRequest->driver->name ?? '-' }}</span>
                                    @if($transportRequest->driver && $transportRequest->driver->phone)
                                        <div class="text-xs text-slate-500">
                                            {{ $transportRequest->driver->phone }}
                                        </div>
                                    @endif
                                </dd>
                            </div>
                        @endif

                        @if ($transportRequest->jenis === 'ambulance')
                            <div class="border-t border-dashed border-slate-200 pt-3 mt-1"></div>

                            <div class="flex">
                                <dt class="w-32 text-slate-500">Nama Pasien</dt>
                                <dd class="flex-1 text-slate-800">
                                    {{ $transportRequest->pasien_nama ?? '-' }}
                                </dd>
                            </div>
                            <div class="flex">
                                <dt class="w-32 text-slate-500">No. RM</dt>
                                <dd class="flex-1 text-slate-800">
                                    {{ $transportRequest->pasien_no_rm ?? '-' }}
                                </dd>
                            </div>
                            <div class="flex">
                                <dt class="w-32 text-slate-500">Ruangan</dt>
                                <dd class="flex-1 text-slate-800">
                                    {{ $transportRequest->ruangan ?? '-' }}
                                </dd>
                            </div>
                            <div class="flex">
                                <dt class="w-32 text-slate-500">Pendamping</dt>
                                <dd class="flex-1 text-slate-800">
                                    {{ $transportRequest->pendamping_nama ?? '-' }}
                                </dd>
                            </div>
                        @endif

                        @if ($transportRequest->keterangan)
                            <div class="border-t border-dashed border-slate-200 pt-3 mt-1"></div>
                            <div class="flex">
                                <dt class="w-32 text-slate-500">Keterangan</dt>
                                <dd class="flex-1 text-slate-800">
                                    {{ $transportRequest->keterangan }}
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            {{-- Card 2: Disetujui oleh Admin --}}
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200">
                <div class="border-b border-slate-200 px-5 py-4">
                    <h2 class="text-sm font-semibold text-slate-800">
                        Disetujui oleh Admin
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Pilih status dan lengkapi data kendaraan secara singkat.
                    </p>
                </div>

                <form method="POST"
                      action="{{ route('admin.transport.update', $transportRequest) }}"
                      class="px-5 py-4 space-y-4 text-sm">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Status Pengajuan
                        </label>
                        <select name="status"
                                class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="diproses" @selected($transportRequest->status === 'diproses')>
                                Disetujui / Sedang digunakan
                            </option>
                            <option value="selesai" @selected($transportRequest->status === 'selesai')>
                                Selesai
                            </option>
                            <option value="ditolak" @selected($transportRequest->status === 'ditolak')>
                                Ditolak
                            </option>
                        </select>
                        <p class="text-[11px] text-slate-500 mt-1">
                            Saat diset ke <span class="font-semibold">Disetujui / Sedang digunakan</span>, isi kendaraan, nomor polisi, dan KM keberangkatan.
                            Saat diset ke <span class="font-semibold">Selesai</span>, isi jam kedatangan dan KM tiba.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">
                                Unit Kendaraan
                            </label>
                            <select name="unit_mobil" id="unit_mobil"
                                    class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">-- Pilih Unit Kendaraan --</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->name }}" 
                                            data-plate="{{ $vehicle->plate_number }}"
                                            @selected(old('unit_mobil', $transportRequest->unit_mobil) == $vehicle->name)>
                                        {{ $vehicle->name }} ({{ $vehicle->plate_number }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-[10px] text-slate-500 mt-1">Pilih unit kendaraan yang akan digunakan</p>
                            <input type="hidden" name="plat_nomor" id="plat_nomor" value="{{ old('plat_nomor', $transportRequest->plat_nomor) }}">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">
                                Nama Supir
                            </label>
                            <select name="driver_id"
                                    class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">-- Pilih Supir --</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}" 
                                            @selected(old('driver_id', $transportRequest->driver_id) == $driver->id)>
                                        {{ $driver->name }}
                                        @if($driver->phone)
                                            ({{ $driver->phone }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-[10px] text-slate-500 mt-1">Pilih supir yang bertugas</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">
                                KM Keberangkatan
                            </label>
                            <input type="number" name="km_awal"
                                   value="{{ old('km_awal', $transportRequest->km_awal) }}"
                                   class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                   placeholder="Isi saat berangkat">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">
                                KM Tiba / Selesai
                            </label>
                            <input type="number" name="km_akhir"
                                   value="{{ old('km_akhir', $transportRequest->km_akhir) }}"
                                   class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                   placeholder="Isi saat selesai">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">
                                Jam Kedatangan
                            </label>
                            <input type="text" name="jam_sampai" id="jam_sampai"
                                   value="{{ old('jam_sampai', '') }}"
                                   class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                   placeholder="Kosongkan jika belum selesai"
                                   pattern="^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$"
                                   maxlength="5"
                                   inputmode="numeric">
                            <p class="text-[10px] text-slate-500 mt-1">Format: 00:00 (24 jam)</p>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-dashed border-slate-200 mt-1 flex items-center justify-between gap-3">
                        <p class="text-[11px] text-slate-500">
                            Pastikan data sudah sesuai sebelum menyimpan.
                        </p>
                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto-fill nomor polisi saat unit kendaraan dipilih
        document.addEventListener('DOMContentLoaded', function() {
            const unitMobilSelect = document.getElementById('unit_mobil');
            const platNomorInput = document.getElementById('plat_nomor');
            
            if (unitMobilSelect && platNomorInput) {
                unitMobilSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const plateNumber = selectedOption.getAttribute('data-plate');
                    
                    if (plateNumber) {
                        platNomorInput.value = plateNumber;
                    } else {
                        platNomorInput.value = '';
                    }
                });
            }
            
            // Auto-format jam kedatangan input
            const jamSampaiInput = document.getElementById('jam_sampai');
            
            if (jamSampaiInput) {
                // Format input as user types
                jamSampaiInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/[^0-9]/g, '');
                    
                    if (value.length >= 2) {
                        value = value.slice(0, 2) + ':' + value.slice(2, 4);
                    }
                    
                    e.target.value = value;
                });

                // Validate and format on blur
                jamSampaiInput.addEventListener('blur', function(e) {
                    let value = e.target.value;
                    
                    // If empty, leave it empty
                    if (!value) return;
                    
                    // Remove non-digits
                    let digits = value.replace(/[^0-9]/g, '');
                    
                    if (digits.length === 4) {
                        let hours = parseInt(digits.slice(0, 2));
                        let minutes = parseInt(digits.slice(2, 4));
                        
                        // Validate hours (0-23)
                        if (hours > 23) hours = 23;
                        
                        // Validate minutes (0-59)
                        if (minutes > 59) minutes = 59;
                        
                        // Format with leading zeros
                        e.target.value = String(hours).padStart(2, '0') + ':' + String(minutes).padStart(2, '0');
                    } else if (digits.length === 3) {
                        // Handle 3 digits (e.g., 930 -> 09:30)
                        let hours = parseInt(digits.slice(0, 1));
                        let minutes = parseInt(digits.slice(1, 3));
                        
                        if (minutes > 59) minutes = 59;
                        
                        e.target.value = String(hours).padStart(2, '0') + ':' + String(minutes).padStart(2, '0');
                    }
                });

                // Prevent non-numeric input
                jamSampaiInput.addEventListener('keypress', function(e) {
                    if (!/[0-9]/.test(e.key)) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
</x-app-layout>