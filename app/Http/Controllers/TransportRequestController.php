<?php

namespace App\Http\Controllers;

use App\Models\TransportRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TransportRequestController extends Controller
{
    public function choose()
    {
        return view('transport.choose');
    }

    public function index(Request $request)
    {
        $query = $request->user()->transportRequests()->latest();

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $items = $query->paginate(10)->withQueryString();

        return view('transport.index', compact('items'));
    }

    public function createUmum()
    {
        $vehicles = \App\Models\Vehicle::where('type', 'umum')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        
        return view('transport.umum_form', compact('vehicles'));
    }

    public function storeUmum(Request $request)
    {
        $data = $request->validate([
            'unit_mobil' => ['required', 'string', 'exists:vehicles,name'],
            'tanggal' => ['required', 'date'],
            'jam' => ['required', 'date_format:H:i'],
            'tanggal_sampai' => ['required', 'date'],
            'jam_sampai' => ['required', 'date_format:H:i'],
            'prioritas' => ['required', 'in:segera,biasa'],
            'alamat_tujuan' => ['required', 'string', 'max:2000'],
            'keperluan' => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string', 'max:2000'],
        ]);

        // Kontak otomatis diset dari nomor HP user atau kosong
        $data['kontak'] = $request->user()->phone ?? '';

        $mulai = Carbon::parse($data['tanggal'].' '.$data['jam']);
        $sampai = Carbon::parse($data['tanggal_sampai'].' '.$data['jam_sampai']);
        // If sampai is before mulai, interpret sampai as next day (support overnight trips)
        if ($sampai->lte($mulai)) {
            $sampai->addDay();
            // also update tanggal_sampai so saved model reflects next-day date
            $data['tanggal_sampai'] = Carbon::parse($data['tanggal_sampai'])->addDay()->toDateString();
        }

        // Check availability before creating
        // Untuk user priority, hanya cek yang status 'digunakan'
        // Untuk user biasa, cek yang status 'diajukan', 'diproses', 'digunakan'
        $statusToCheck = $request->user()->isPriority() 
            ? ['digunakan'] 
            : ['diajukan', 'diproses', 'digunakan'];
            
        $conflicts = TransportRequest::where('unit_mobil', $data['unit_mobil'])
            ->whereIn('status', $statusToCheck)
            ->get()
            ->filter(function ($r) use ($mulai, $sampai) {
                $rMulai = Carbon::parse($r->tanggal->format('Y-m-d').' '.$r->jam);
                $rSampai = ($r->tanggal_sampai && $r->jam_sampai)
                    ? Carbon::parse($r->tanggal_sampai->format('Y-m-d').' '.$r->jam_sampai)
                    : $rMulai->copy()->addHour();

                if ($rSampai->lte($rMulai)) {
                    $rSampai->addDay();
                }

                return $mulai->lt($rSampai) && $rMulai->lt($sampai);
            });

        if ($conflicts->isNotEmpty()) {
            throw ValidationException::withMessages([
                'unit_mobil' => 'Unit mobil tidak tersedia pada waktu yang dipilih. Silakan pilih waktu lain atau unit mobil lain.'
            ]);
        }

        // Buat pengajuan baru
        $transportRequest = TransportRequest::create([
            'user_id' => $request->user()->id,
            'jenis' => 'umum',
            'unit_mobil' => $data['unit_mobil'],
            'keperluan' => $data['keperluan'],
            'prioritas' => $data['prioritas'],
            'pemohon_nama' => $request->user()->name,
            'pemohon_unit' => $request->user()->unit_kerja,
            'jumlah_penumpang' => null,
            ...collect($data)->except(['keperluan', 'prioritas'])->all(),
        ]);

        // Jika user priority, auto-reject pengajuan lain yang bentrok (KECUALI pengajuan yang baru dibuat)
        if ($request->user()->isPriority()) {
            $conflictingRequests = TransportRequest::where('unit_mobil', $data['unit_mobil'])
                ->where('id', '!=', $transportRequest->id) // PENTING: Exclude pengajuan yang baru dibuat
                ->whereIn('status', ['diajukan', 'diproses'])
                ->get()
                ->filter(function ($r) use ($mulai, $sampai) {
                    $rMulai = Carbon::parse($r->tanggal->format('Y-m-d').' '.$r->jam);
                    $rSampai = ($r->tanggal_sampai && $r->jam_sampai)
                        ? Carbon::parse($r->tanggal_sampai->format('Y-m-d').' '.$r->jam_sampai)
                        : $rMulai->copy()->addHour();

                    if ($rSampai->lte($rMulai)) {
                        $rSampai->addDay();
                    }

                    return $mulai->lt($rSampai) && $rMulai->lt($sampai);
                });

            foreach ($conflictingRequests as $conflict) {
                $conflict->update([
                    'status' => 'ditolak',
                    'keterangan' => ($conflict->keterangan ? $conflict->keterangan . "\n\n" : '') . 
                                    'Ditolak otomatis: Bentrok dengan pengajuan prioritas tinggi.'
                ]);
            }
        }

        return redirect()->route('signature.show', $transportRequest)
            ->with('success', 'Pengajuan berhasil dibuat. Silakan tanda tangan untuk melanjutkan.');
    }

    public function checkAvailability(Request $request)
    {
        $data = $request->validate([
            'unit_mobil' => ['required', 'string', 'exists:vehicles,name'],
            'tanggal' => ['required', 'date'],
            'jam' => ['required', 'date_format:H:i'],
            'tanggal_sampai' => ['required', 'date'],
            'jam_sampai' => ['required', 'date_format:H:i'],
        ]);

        $mulai = Carbon::parse($data['tanggal'].' '.$data['jam']);
        $sampai = Carbon::parse($data['tanggal_sampai'].' '.$data['jam_sampai']);
        
        // Support overnight: if sampai less than mulai, assume next day
        if ($sampai->lte($mulai)) {
            $sampai->addDay();
        }

        // Check all transport requests (both umum and ambulance) that use the same unit_mobil
        // Untuk user priority, hanya cek yang status 'digunakan'
        // Untuk user biasa, cek yang status 'diajukan', 'diproses', 'digunakan'
        $statusToCheck = $request->user()->isPriority() 
            ? ['digunakan'] 
            : ['diajukan', 'diproses', 'digunakan'];
            
        $allRequests = TransportRequest::where('unit_mobil', $data['unit_mobil'])
            ->whereIn('status', $statusToCheck)
            ->get();

        $conflicts = $allRequests->filter(function ($r) use ($mulai, $sampai) {
            // Parse existing request time range
            $rMulai = Carbon::parse($r->tanggal->format('Y-m-d').' '.$r->jam);
            $rSampai = ($r->tanggal_sampai && $r->jam_sampai)
                ? Carbon::parse($r->tanggal_sampai->format('Y-m-d').' '.$r->jam_sampai)
                : $rMulai->copy()->addHour(); // default 1 hour if no end time

            // Handle overnight for existing request
            if ($rSampai->lte($rMulai)) {
                $rSampai->addDay();
            }

            // Check if time ranges overlap
            // Two ranges overlap if: start1 < end2 AND start2 < end1
            $overlaps = $mulai->lt($rSampai) && $rMulai->lt($sampai);

            return $overlaps;
        });

        return response()->json([
            'available' => $conflicts->isEmpty(),
            'conflicts_count' => $conflicts->count(),
            'is_priority' => $request->user()->isPriority(),
            'conflicts' => $conflicts->map(function($r) {
                return [
                    'id' => $r->id,
                    'jenis' => $r->jenis,
                    'status' => $r->status,
                    'tanggal' => $r->tanggal->format('Y-m-d'),
                    'jam' => $r->jam,
                    'tanggal_sampai' => $r->tanggal_sampai ? $r->tanggal_sampai->format('Y-m-d') : null,
                    'jam_sampai' => $r->jam_sampai,
                ];
            })->values(),
        ]);
    }

    public function createAmbulance()
    {
        // Default ke "antar", tapi tetap mempertahankan pilihan terakhir user (old input)
        $purpose = old('purpose', 'antar');
        
        $vehicles = \App\Models\Vehicle::where('type', 'ambulance')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('transport.ambulance_form', [
            'purpose' => $purpose,
            'vehicles' => $vehicles,
        ]);
    }

    public function storeAmbulance(Request $request)
    {
        $data = $request->validate([
            'purpose' => ['required', 'in:antar,jemput'],
            'unit_mobil' => ['required', 'string', 'exists:vehicles,name'],
            'pasien_nama' => ['required', 'string', 'max:255'],
            'pasien_no_rm' => ['nullable', 'string', 'max:50'],
            'alamat_pasien' => ['required', 'string', 'max:2000'],
            'tanggal' => ['required', 'date'],
            'jam' => ['required', 'date_format:H:i'],
            'tanggal_sampai' => ['required', 'date'],
            'jam_sampai' => ['required', 'date_format:H:i'],
            'prioritas' => ['required', 'in:segera,biasa'],
            'alamat_tujuan' => ['nullable', 'string', 'max:2000'],
            'alamat_asal' => ['nullable', 'string', 'max:2000'],
        ]);

        // Validate that the required alamat field is filled based on purpose
        $purpose = $data['purpose'];
        if ($purpose === 'antar' && empty($data['alamat_tujuan'])) {
            throw ValidationException::withMessages(['alamat_tujuan' => 'Alamat tujuan harus diisi.']);
        }
        if ($purpose === 'jemput' && empty($data['alamat_asal'])) {
            throw ValidationException::withMessages(['alamat_asal' => 'Alamat asal harus diisi.']);
        }

        // Kolom kontak di database tetap diisi, tapi tidak perlu diinput user
        $data['kontak'] = '';

        $mulai = Carbon::parse($data['tanggal'].' '.$data['jam']);
        $sampai = Carbon::parse($data['tanggal_sampai'].' '.$data['jam_sampai']);
        if ($sampai->lte($mulai)) {
            $sampai->addDay();
            $data['tanggal_sampai'] = Carbon::parse($data['tanggal_sampai'])->addDay()->toDateString();
        }

        // Check availability before creating
        // Untuk user priority, hanya cek yang status 'digunakan'
        // Untuk user biasa, cek yang status 'diajukan', 'diproses', 'digunakan'
        $statusToCheck = $request->user()->isPriority() 
            ? ['digunakan'] 
            : ['diajukan', 'diproses', 'digunakan'];
            
        $conflicts = TransportRequest::where('unit_mobil', $data['unit_mobil'])
            ->whereIn('status', $statusToCheck)
            ->get()
            ->filter(function ($r) use ($mulai, $sampai) {
                $rMulai = Carbon::parse($r->tanggal->format('Y-m-d').' '.$r->jam);
                $rSampai = ($r->tanggal_sampai && $r->jam_sampai)
                    ? Carbon::parse($r->tanggal_sampai->format('Y-m-d').' '.$r->jam_sampai)
                    : $rMulai->copy()->addHour();

                if ($rSampai->lte($rMulai)) {
                    $rSampai->addDay();
                }

                return $mulai->lt($rSampai) && $rMulai->lt($sampai);
            });

        if ($conflicts->isNotEmpty()) {
            throw ValidationException::withMessages([
                'unit_mobil' => 'Ambulans tidak tersedia pada waktu yang dipilih. Silakan pilih waktu lain.'
            ]);
        }

        $alamatAsal = $purpose === 'antar' ? 'RS' : ($data['alamat_asal'] ?? 'RS');
        $alamatTujuan = $purpose === 'antar' ? ($data['alamat_tujuan'] ?? 'RS') : 'RS';

        // Buat pengajuan baru
        $transportRequest = TransportRequest::create([
            'user_id' => $request->user()->id,
            'jenis' => 'ambulance',
            'unit_mobil' => $data['unit_mobil'],
            'keperluan' => $purpose,
            'prioritas' => $data['prioritas'],
            ...collect($data)->except(['prioritas'])->all(),
            'alamat_asal' => $alamatAsal,
            'alamat_tujuan' => $alamatTujuan,
            'ruangan' => null,
            'pendamping_nama' => null,
            'kondisi_pasien' => null,
        ]);

        // Jika user priority, auto-reject pengajuan lain yang bentrok (KECUALI pengajuan yang baru dibuat)
        if ($request->user()->isPriority()) {
            $conflictingRequests = TransportRequest::where('unit_mobil', $data['unit_mobil'])
                ->where('id', '!=', $transportRequest->id) // PENTING: Exclude pengajuan yang baru dibuat
                ->whereIn('status', ['diajukan', 'diproses'])
                ->get()
                ->filter(function ($r) use ($mulai, $sampai) {
                    $rMulai = Carbon::parse($r->tanggal->format('Y-m-d').' '.$r->jam);
                    $rSampai = ($r->tanggal_sampai && $r->jam_sampai)
                        ? Carbon::parse($r->tanggal_sampai->format('Y-m-d').' '.$r->jam_sampai)
                        : $rMulai->copy()->addHour();

                    if ($rSampai->lte($rMulai)) {
                        $rSampai->addDay();
                    }

                    return $mulai->lt($rSampai) && $rMulai->lt($sampai);
                });

            foreach ($conflictingRequests as $conflict) {
                $conflict->update([
                    'status' => 'ditolak',
                    'keterangan' => ($conflict->keterangan ? $conflict->keterangan . "\n\n" : '') . 
                                    'Ditolak otomatis: Bentrok dengan pengajuan prioritas tinggi.'
                ]);
            }
        }

        return redirect()->route('signature.show', $transportRequest)
            ->with('success', 'Pengajuan berhasil dibuat. Silakan tanda tangan untuk melanjutkan.');
    }

    public function checkAmbulanceAvailability(Request $request)
    {
        $data = $request->validate([
            'unit_mobil' => ['required', 'string', 'exists:vehicles,name'],
            'tanggal' => ['required', 'date'],
            'jam' => ['required', 'date_format:H:i'],
            'tanggal_sampai' => ['required', 'date'],
            'jam_sampai' => ['required', 'date_format:H:i'],
        ]);

        $mulai = Carbon::parse($data['tanggal'].' '.$data['jam']);
        $sampai = Carbon::parse($data['tanggal_sampai'].' '.$data['jam_sampai']);
        
        // Support overnight: if sampai less than or equal to mulai, assume next day
        if ($sampai->lte($mulai)) {
            $sampai->addDay();
        }

        // Check all transport requests (both umum and ambulance) that use the same unit_mobil
        // Untuk user priority, hanya cek yang status 'digunakan'
        // Untuk user biasa, cek yang status 'diajukan', 'diproses', 'digunakan'
        $statusToCheck = $request->user()->isPriority() 
            ? ['digunakan'] 
            : ['diajukan', 'diproses', 'digunakan'];
            
        $allRequests = TransportRequest::where('unit_mobil', $data['unit_mobil'])
            ->whereIn('status', $statusToCheck)
            ->get();

        $conflicts = $allRequests->filter(function ($r) use ($mulai, $sampai) {
            // Parse existing request time range
            $rMulai = Carbon::parse($r->tanggal->format('Y-m-d').' '.$r->jam);
            $rSampai = ($r->tanggal_sampai && $r->jam_sampai)
                ? Carbon::parse($r->tanggal_sampai->format('Y-m-d').' '.$r->jam_sampai)
                : $rMulai->copy()->addHour(); // default 1 hour if no end time

            // Handle overnight for existing request
            if ($rSampai->lte($rMulai)) {
                $rSampai->addDay();
            }

            // Check if time ranges overlap
            // Two ranges overlap if: start1 < end2 AND start2 < end1
            $overlaps = $mulai->lt($rSampai) && $rMulai->lt($sampai);

            return $overlaps;
        });

        return response()->json([
            'available' => $conflicts->isEmpty(),
            'conflicts_count' => $conflicts->count(),
            'is_priority' => $request->user()->isPriority(),
            'conflicts' => $conflicts->map(function($r) {
                return [
                    'id' => $r->id,
                    'jenis' => $r->jenis,
                    'status' => $r->status,
                    'tanggal' => $r->tanggal->format('Y-m-d'),
                    'jam' => $r->jam,
                    'tanggal_sampai' => $r->tanggal_sampai ? $r->tanggal_sampai->format('Y-m-d') : null,
                    'jam_sampai' => $r->jam_sampai,
                ];
            })->values(),
        ]);
    }

    public function success(Request $request, TransportRequest $transportRequest)
    {
        abort_unless($transportRequest->user_id === $request->user()->id, 403);

        return view('transport.success', [
            'item' => $transportRequest,
        ]);
    }
}

