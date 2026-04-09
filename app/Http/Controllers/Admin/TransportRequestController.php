<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransportRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TransportRequestController extends Controller
{
    public function dashboard()
    {
        $counts = TransportRequest::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $summary = [
            'total' => TransportRequest::count(),
            'diajukan' => $counts['diajukan'] ?? 0,
            'diproses' => $counts['diproses'] ?? 0,
            'digunakan' => $counts['digunakan'] ?? 0,
            'selesai' => $counts['selesai'] ?? 0,
            'tidak_disetujui' => $counts['tidak_disetujui'] ?? 0,
        ];

        // Verify total matches sum of all statuses (for data integrity)
        $calculatedTotal = $summary['diajukan'] + $summary['diproses'] + $summary['digunakan'] + $summary['selesai'] + $summary['tidak_disetujui'];
        if ($summary['total'] !== $calculatedTotal) {
            // Log discrepancy for debugging
            \Log::warning('Dashboard total count mismatch', [
                'total_from_count' => $summary['total'],
                'calculated_total' => $calculatedTotal,
                'status_counts' => $counts->toArray()
            ]);
        }

        // Beberapa data terbaru untuk konteks cepat di dashboard
        $latest = TransportRequest::with('user')
            ->latest()
            ->limit(5)
            ->get();

        // Kendaraan yang sedang digunakan
        $activeVehicles = TransportRequest::with('user')
            ->where('status', 'digunakan')
            ->orderByRaw("CONCAT(tanggal, ' ', jam) ASC")
            ->get();

        return view('admin.dashboard', compact('summary', 'latest', 'activeVehicles'));
    }

    public function index(Request $request)
    {
        $query = TransportRequest::with('user');

        // Tentukan sorting berdasarkan status
        $selectedStatus = $request->input('status');
        if ($request->has('status') && $request->filled('status')) {
            // Status tertentu dipilih
            $fifoStatuses = ['diajukan', 'diproses', 'digunakan']; // Status yang menggunakan FIFO berdasarkan waktu pengajuan
            if (in_array($selectedStatus, $fifoStatuses)) {
                // Untuk status menunggu, disetujui, dan digunakan: urutkan dari waktu pengajuan terlebih dahulu (FIFO)
                $query->orderByRaw("CONCAT(tanggal, ' ', jam) ASC");
            } else {
                // Untuk status lain (selesai, tidak_disetujui, dll): urutkan dari yang terbaru dibuat
                $query->orderBy('created_at', 'desc');
            }
            $query->where('status', $selectedStatus);
        } elseif ($request->has('status') && !$request->filled('status')) {
            // "Semua Status" dipilih: urutkan dari yang terbaru dibuat
            $query->orderBy('created_at', 'desc');
        } else {
            // Tidak ada parameter status (first load): default ke 'diajukan' dengan FIFO berdasarkan waktu pengajuan
            $query->where('status', 'diajukan')->orderByRaw("CONCAT(tanggal, ' ', jam) ASC");
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $items = $query->paginate(15)->withQueryString();

        return view('admin.transport.index', compact('items'));
    }

    public function show(TransportRequest $transportRequest)
    {
        $drivers = \App\Models\Driver::where('is_active', true)->orderBy('name')->get();
        $vehicleType = $transportRequest->jenis === 'ambulance' ? 'ambulance' : 'umum';

        // Cari unit yang sedang digunakan pada rentang waktu pengajuan ini
        $mulai = \Carbon\Carbon::parse($transportRequest->tanggal->format('Y-m-d').' '.$transportRequest->jam);
        $sampai = \Carbon\Carbon::parse($transportRequest->tanggal_sampai->format('Y-m-d').' '.$transportRequest->jam_sampai);
        if ($sampai->lte($mulai)) $sampai->addDay();

        $busyVehicleNames = TransportRequest::where('status', 'digunakan')
            ->whereNotNull('unit_mobil')
            ->where('id', '!=', $transportRequest->id)
            ->get()
            ->filter(function ($r) use ($mulai, $sampai) {
                $rMulai = \Carbon\Carbon::parse($r->tanggal->format('Y-m-d').' '.$r->jam);
                $rSampai = ($r->tanggal_sampai && $r->jam_sampai)
                    ? \Carbon\Carbon::parse($r->tanggal_sampai->format('Y-m-d').' '.$r->jam_sampai)
                    : $rMulai->copy()->addHour();
                if ($rSampai->lte($rMulai)) $rSampai->addDay();
                return $mulai->lt($rSampai) && $rMulai->lt($sampai);
            })
            ->pluck('unit_mobil')
            ->unique()
            ->values();

        $vehicles = \App\Models\Vehicle::where('type', $vehicleType)
            ->where('is_active', true)
            ->whereNotIn('name', $busyVehicleNames)
            ->orderBy('name')
            ->get();

        return view('admin.transport.show', compact('transportRequest', 'drivers', 'vehicles'));
    }

    public function update(Request $request, TransportRequest $transportRequest)
    {
        $currentStatus = $transportRequest->status;
        $newStatus = $request->input('status');
        
        if ($currentStatus === 'diajukan' && $newStatus === 'diproses') {
            $data = $request->validate([
                'status' => ['required', 'in:diproses,tidak_disetujui'],
            ]);
            // Auto-sign pengelola_1
            $data['signature_pengelola_1'] = \Illuminate\Support\Str::random(32);
            $data['signature_pengelola_1_at'] = now();
            $data['signature_pengelola_1_name'] = auth()->user()->full_name;

        } elseif ($currentStatus === 'diproses' && $newStatus === 'digunakan') {
            $data = $request->validate([
                'status' => ['required', 'in:digunakan'],
                'unit_mobil' => ['required', 'string', 'max:100'],
                'plat_nomor' => ['nullable', 'string', 'max:20'],
                'driver_id' => ['required', 'exists:drivers,id'],
                'km_awal' => ['required', 'integer', 'min:0'],
            ]);

            if (empty($data['plat_nomor']) && !empty($data['unit_mobil'])) {
                $vehicle = \App\Models\Vehicle::where('name', $data['unit_mobil'])->first();
                if ($vehicle) {
                    $data['plat_nomor'] = $vehicle->plate_number;
                }
            }
            // Auto-sign driver
            $data['signature_driver'] = \Illuminate\Support\Str::random(32);
            $data['signature_driver_at'] = now();

        } elseif ($currentStatus === 'digunakan' && $newStatus === 'selesai') {
            $data = $request->validate([
                'status' => ['required', 'in:selesai'],
                'km_akhir' => ['required', 'integer', 'min:0'],
                'jam_kedatangan' => ['required', 'string', 'max:10', 'regex:/^([01][0-9]|2[0-3]):[0-5][0-9]$/'],
            ]);
            
            if ($data['km_akhir'] <= $transportRequest->km_awal) {
                throw ValidationException::withMessages(['km_akhir' => 'KM tiba harus lebih besar dari KM keberangkatan.']);
            }
            // Auto-sign pengelola_2
            $data['signature_pengelola_2'] = \Illuminate\Support\Str::random(32);
            $data['signature_pengelola_2_at'] = now();
            $data['signature_pengelola_2_name'] = auth()->user()->full_name;

        } elseif ($currentStatus === 'diajukan' && $newStatus === 'tidak_disetujui') {
            $data = $request->validate([
                'status' => ['required', 'in:tidak_disetujui'],
            ]);
        } else {
            return redirect()->back()->withErrors(['status' => 'Transisi status tidak valid.']);
        }

        $transportRequest->update($data);

        return redirect()->route('admin.transport.show', $transportRequest)
            ->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    public function print(TransportRequest $transportRequest)
    {
        $transportRequest->load('driver');
        
        // Jika plat_nomor kosong tapi unit_mobil ada, coba ambil dari master vehicle
        if (empty($transportRequest->plat_nomor) && !empty($transportRequest->unit_mobil)) {
            $vehicle = \App\Models\Vehicle::where('name', $transportRequest->unit_mobil)->first();
            if ($vehicle) {
                $transportRequest->plat_nomor = $vehicle->plate_number;
            }
        }
        
        return view('admin.transport.print', compact('transportRequest'));
    }
}
