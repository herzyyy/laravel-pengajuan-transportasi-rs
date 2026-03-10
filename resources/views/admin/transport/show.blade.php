<x-app-layout>
    <div class="max-w-5xl mx-auto px-3 sm:px-4 pt-4">
        <div class="flex items-center justify-between gap-3 border-b border-slate-200 pb-3">
            <div>
                <h1 class="text-lg font-bold text-slate-800">
                    Detail Pengajuan Transportasi
                </h1>
                <p class="text-slate-500 text-xs mt-0.5">
                    ID: #{{ str_pad($transportRequest->id, 4, '0', STR_PAD_LEFT) }}
                </p>
            </div>

            <div class="flex items-center gap-2">
                @if($transportRequest->status === 'selesai')
                    <a href="{{ route('admin.transport.print', $transportRequest) }}"
                       target="_blank"
                       class="inline-flex items-center rounded-lg bg-emerald-600 px-2.5 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Print
                    </a>
                @endif
                <a href="{{ route('admin.transport.index') }}"
                   class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                    Kembali
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="mt-3 p-2.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-xs font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mt-3 p-2.5 bg-red-50 border border-red-200 text-red-700 rounded-lg text-xs">
                <div class="font-semibold mb-1">Periksa kembali data yang diisi:</div>
                <ul class="list-disc ml-4 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-3 grid grid-cols-1 lg:grid-cols-2 gap-3">
            {{-- Card 1: Pengajuan oleh User --}}
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200">
                <div class="border-b border-slate-200 px-3 py-2 flex items-center justify-between">
                    <div>
                        <h2 class="text-xs font-semibold text-slate-800">
                            Data Pengajuan
                        </h2>
                    </div>
                    @php
                        $colors = [
                            'diajukan' => 'bg-amber-100 text-amber-800',
                            'diproses' => 'bg-blue-100 text-blue-800',
                            'digunakan' => 'bg-cyan-100 text-cyan-800',
                            'selesai' => 'bg-emerald-100 text-emerald-800',
                            'ditolak' => 'bg-red-100 text-red-800',
                            'kadaluarsa' => 'bg-orange-100 text-orange-800'
                        ];
                        $color = $colors[$transportRequest->status] ?? 'bg-slate-100 text-slate-800';
                        $label = match($transportRequest->status) {
                            'diproses' => 'Disetujui',
                            'digunakan' => 'Digunakan',
                            'kadaluarsa' => 'Kadaluarsa',
                            default => ucfirst($transportRequest->status)
                        };
                    @endphp
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $color }}">
                        {{ $label }}
                    </span>
                </div>

                <div class="px-3 py-2.5 text-xs">
                    <dl class="space-y-1.5">
                        <div class="flex">
                            <dt class="w-24 text-slate-500">Tanggal</dt>
                            <dd class="flex-1 text-slate-800 font-medium">
                                {{ $transportRequest->tanggal->format('d/m/Y') }} {{ substr($transportRequest->jam, 0, 5) }} - {{ $transportRequest->tanggal_sampai->format('d/m/Y') }} {{ substr($transportRequest->jam_sampai, 0, 5) }}
                            </dd>
                        </div>

                        <div class="flex">
                            <dt class="w-24 text-slate-500">Pemohon</dt>
                            <dd class="flex-1 text-slate-800">
                                <span class="font-medium">{{ $transportRequest->user->full_name ?? $transportRequest->pemohon_nama }}</span>
                                <span class="text-slate-500"> • {{ $transportRequest->user->unit_kerja ?? $transportRequest->pemohon_unit }}</span>
                            </dd>
                        </div>

                        <div class="flex">
                            <dt class="w-24 text-slate-500">Jenis</dt>
                            <dd class="flex-1 text-slate-800">
                                <span class="font-medium">{{ ucfirst($transportRequest->jenis) }}</span>
                                @if ($transportRequest->jenis === 'ambulance' && $transportRequest->keperluan)
                                    <span class="text-slate-500">({{ ucfirst($transportRequest->keperluan) }})</span>
                                @endif
                                @if($transportRequest->prioritas === 'segera')
                                    <span class="inline-flex items-center text-[9px] font-bold text-red-600 bg-red-50 px-1.5 py-0.5 rounded ml-1">CITO</span>
                                @endif
                            </dd>
                        </div>

                        <div class="flex">
                            <dt class="w-24 text-slate-500">Tujuan</dt>
                            <dd class="flex-1 text-slate-800">
                                {{ $transportRequest->alamat_tujuan ?? '-' }}
                            </dd>
                        </div>

                        @if($transportRequest->driver_id)
                            <div class="border-t border-slate-200 pt-1.5 mt-1"></div>
                            <div class="flex">
                                <dt class="w-24 text-slate-500">Supir</dt>
                                <dd class="flex-1 text-slate-800">
                                    <span class="font-medium">{{ $transportRequest->driver->name ?? '-' }}</span>
                                    @if($transportRequest->driver && $transportRequest->driver->phone)
                                        <span class="text-slate-500"> • {{ $transportRequest->driver->phone }}</span>
                                    @endif
                                </dd>
                            </div>
                        @endif

                        @if ($transportRequest->jenis === 'ambulance')
                            <div class="border-t border-slate-200 pt-1.5 mt-1"></div>
                            <div class="flex">
                                <dt class="w-24 text-slate-500">Pasien</dt>
                                <dd class="flex-1 text-slate-800">
                                    <span class="font-medium">{{ $transportRequest->pasien_nama ?? '-' }}</span>
                                    <span class="text-slate-500"> • RM: {{ $transportRequest->pasien_no_rm ?? '-' }}</span>
                                </dd>
                            </div>
                            <div class="flex">
                                <dt class="w-24 text-slate-500">Ruangan</dt>
                                <dd class="flex-1 text-slate-800">
                                    {{ $transportRequest->ruangan ?? '-' }}
                                </dd>
                            </div>
                            @if($transportRequest->pendamping_nama)
                            <div class="flex">
                                <dt class="w-24 text-slate-500">Pendamping</dt>
                                <dd class="flex-1 text-slate-800">
                                    {{ $transportRequest->pendamping_nama }}
                                </dd>
                            </div>
                            @endif
                        @endif

                        @if ($transportRequest->keterangan)
                            <div class="border-t border-slate-200 pt-1.5 mt-1"></div>
                            <div class="flex">
                                <dt class="w-24 text-slate-500">Keterangan</dt>
                                <dd class="flex-1 text-slate-800">
                                    {{ $transportRequest->keterangan }}
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            {{-- Card 2: Form Eksekusi Admin --}}
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200">
                <div class="border-b border-slate-200 px-3 py-2">
                    <h2 class="text-xs font-semibold text-slate-800">
                        Form Eksekusi Admin
                    </h2>
                </div>

                <form method="POST"
                      action="{{ route('admin.transport.update', $transportRequest) }}"
                      class="px-3 py-2.5 space-y-2.5 text-xs"
                      x-data="{ currentStatus: '{{ $transportRequest->status }}' }">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[10px] font-semibold text-slate-700 mb-1">
                            Status Pengajuan
                        </label>
                        <select name="status" x-model="currentStatus"
                                class="w-full rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            @if($transportRequest->status === 'diajukan')
                                <option value="diajukan" selected>Diajukan (Menunggu)</option>
                                <option value="diproses">Disetujui</option>
                                <option value="ditolak">Ditolak</option>
                            @elseif($transportRequest->status === 'diproses')
                                <option value="diproses" selected>Disetujui</option>
                                <option value="digunakan">Digunakan</option>
                            @elseif($transportRequest->status === 'digunakan')
                                <option value="digunakan" selected>Digunakan</option>
                                <option value="selesai">Selesai</option>
                            @elseif($transportRequest->status === 'selesai')
                                <option value="selesai" selected>Selesai</option>
                            @elseif($transportRequest->status === 'ditolak')
                                <option value="ditolak" selected>Ditolak</option>
                            @elseif($transportRequest->status === 'kadaluarsa')
                                <option value="kadaluarsa" selected>Kadaluarsa</option>
                            @endif
                        </select>
                        <p class="text-[9px] text-slate-500 mt-0.5">
                            <span x-show="currentStatus === 'diajukan'">Pilih <strong>Disetujui</strong> untuk menyetujui</span>
                            <span x-show="currentStatus === 'diproses'">Pilih <strong>Digunakan</strong> saat mulai digunakan</span>
                            <span x-show="currentStatus === 'digunakan'">Pilih <strong>Selesai</strong> saat kendaraan kembali</span>
                            <span x-show="currentStatus === 'selesai'">Status sudah selesai</span>
                            <span x-show="currentStatus === 'ditolak'">Pengajuan ditolak</span>
                            <span x-show="currentStatus === 'kadaluarsa'">Pengajuan kadaluarsa</span>
                        </p>
                    </div>

                    <!-- Form untuk Diajukan -> Disetujui: Unit Kendaraan & Supir -->
                    <div x-show="currentStatus === 'diproses' && '{{ $transportRequest->status }}' === 'diajukan'" class="space-y-2">
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-700 mb-0.5">
                                Unit Kendaraan <span class="text-red-500">*</span>
                            </label>
                            <select name="unit_mobil" id="unit_mobil"
                                    class="w-full rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">-- Pilih Unit --</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->name }}" 
                                            data-plate="{{ $vehicle->plate_number }}"
                                            @selected(old('unit_mobil', $transportRequest->unit_mobil) == $vehicle->name)>
                                        {{ $vehicle->name }} ({{ $vehicle->plate_number }})
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="plat_nomor" id="plat_nomor" value="{{ old('plat_nomor', $transportRequest->plat_nomor) }}">
                        </div>

                        <div>
                            <label class="block text-[10px] font-semibold text-slate-700 mb-0.5">
                                Nama Supir <span class="text-red-500">*</span>
                            </label>
                            <select name="driver_id"
                                    class="w-full rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">-- Pilih Supir --</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}" 
                                            @selected(old('driver_id', $transportRequest->driver_id) == $driver->id)>
                                        {{ $driver->name }}@if($driver->phone) ({{ $driver->phone }})@endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Form untuk Disetujui -> Digunakan: KM Keberangkatan -->
                    <div x-show="currentStatus === 'digunakan' && '{{ $transportRequest->status }}' === 'diproses'">
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-700 mb-0.5">
                                KM Keberangkatan <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="km_awal"
                                   value="{{ old('km_awal', $transportRequest->km_awal) }}"
                                   class="w-full rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                   placeholder="Masukkan KM">
                        </div>
                    </div>

                    <!-- Form untuk Digunakan -> Selesai: KM Tiba & Jam Kedatangan -->
                    <div x-show="currentStatus === 'selesai' && '{{ $transportRequest->status }}' === 'digunakan'" class="space-y-2">
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-700 mb-0.5">
                                KM Tiba <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="km_akhir"
                                   value="{{ old('km_akhir', $transportRequest->km_akhir) }}"
                                   class="w-full rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                   placeholder="Masukkan KM">
                        </div>

                        <div>
                            <label class="block text-[10px] font-semibold text-slate-700 mb-0.5">
                                Jam Kedatangan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="jam_kedatangan" id="jam_kedatangan"
                                   value="{{ old('jam_kedatangan', $transportRequest->jam_kedatangan) }}"
                                   class="w-full rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                   placeholder="00:00"
                                   pattern="^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$"
                                   maxlength="5"
                                   inputmode="numeric">
                        </div>
                    </div>

                    <!-- Info Data yang Sudah Diisi -->
                    <div x-show="'{{ $transportRequest->status }}' !== 'diajukan'" class="bg-slate-50 rounded-lg p-2 text-[10px] space-y-1">
                        <div class="font-semibold text-slate-700 mb-1">Data Terisi:</div>
                        
                        @if($transportRequest->unit_mobil)
                            <div class="flex justify-between gap-2">
                                <span class="text-slate-500">Unit:</span>
                                <span class="text-slate-900 font-medium text-right">{{ $transportRequest->unit_mobil }} ({{ $transportRequest->plat_nomor }})</span>
                            </div>
                        @endif
                        
                        @if($transportRequest->driver_id)
                            <div class="flex justify-between gap-2">
                                <span class="text-slate-500">Supir:</span>
                                <span class="text-slate-900 font-medium">{{ $transportRequest->driver->name ?? '-' }}</span>
                            </div>
                        @endif
                        
                        @if($transportRequest->km_awal)
                            <div class="flex justify-between gap-2">
                                <span class="text-slate-500">KM Awal:</span>
                                <span class="text-slate-900 font-medium">{{ $transportRequest->km_awal }} km</span>
                            </div>
                        @endif
                        
                        @if($transportRequest->km_akhir)
                            <div class="flex justify-between gap-2">
                                <span class="text-slate-500">KM Akhir:</span>
                                <span class="text-slate-900 font-medium">{{ $transportRequest->km_akhir }} km</span>
                            </div>
                        @endif
                        
                        @if($transportRequest->km_awal && $transportRequest->km_akhir)
                            <div class="flex justify-between gap-2 border-t border-slate-200 pt-1 mt-1">
                                <span class="text-slate-500">Total:</span>
                                <span class="text-emerald-600 font-bold">{{ $transportRequest->km_akhir - $transportRequest->km_awal }} km</span>
                            </div>
                        @endif
                        
                        @if($transportRequest->jam_kedatangan)
                            <div class="flex justify-between gap-2">
                                <span class="text-slate-500">Jam Tiba:</span>
                                <span class="text-slate-900 font-medium">{{ $transportRequest->jam_kedatangan }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="pt-2 border-t border-slate-200 flex items-center justify-end gap-2">
                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            Simpan
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
            const jamKedatanganInput = document.getElementById('jam_kedatangan');
            
            if (jamKedatanganInput) {
                // Format input as user types
                jamKedatanganInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/[^0-9]/g, '');
                    
                    if (value.length >= 2) {
                        value = value.slice(0, 2) + ':' + value.slice(2, 4);
                    }
                    
                    e.target.value = value;
                });

                // Validate and format on blur
                jamKedatanganInput.addEventListener('blur', function(e) {
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
                jamKedatanganInput.addEventListener('keypress', function(e) {
                    if (!/[0-9]/.test(e.key)) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
</x-app-layout>