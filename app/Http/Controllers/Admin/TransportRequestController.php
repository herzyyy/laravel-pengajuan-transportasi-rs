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
            'ditolak' => $counts['ditolak'] ?? 0,
            'kadaluarsa' => $counts['kadaluarsa'] ?? 0,
        ];

        // Beberapa data terbaru untuk konteks cepat di dashboard
        $latest = TransportRequest::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('summary', 'latest'));
    }

    public function index(Request $request)
    {
        $query = TransportRequest::with('user')->orderBy('created_at', 'asc'); // Urutkan berdasarkan waktu membuat ajuan (FIFO)

        // Filter status: default 'diajukan' hanya jika tidak ada parameter status sama sekali
        // Jika user memilih "Semua Status" (value kosong), jangan filter status
        if ($request->has('status')) {
            // User sudah memilih filter status (bisa kosong untuk "Semua Status" atau value tertentu)
            if ($request->filled('status')) {
                // Ada value status yang dipilih
                $query->where('status', $request->status);
            }
            // Jika status kosong (Semua Status), tidak perlu filter
        } else {
            // Tidak ada parameter status sama sekali (first load), default ke 'diajukan'
            $query->where('status', 'diajukan');
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
        $vehicles = \App\Models\Vehicle::where('is_active', true)->orderBy('name')->get();
        return view('admin.transport.show', compact('transportRequest', 'drivers', 'vehicles'));
    }

    public function update(Request $request, TransportRequest $transportRequest)
    {
        $currentStatus = $transportRequest->status;
        $newStatus = $request->input('status');
        
        // Validasi berdasarkan transisi status
        if ($currentStatus === 'diajukan' && $newStatus === 'diproses') {
            // Diajukan -> Disetujui: Wajib isi unit kendaraan dan supir
            $data = $request->validate([
                'status' => ['required', 'in:diproses,ditolak'],
                'unit_mobil' => ['required', 'string', 'max:100'],
                'plat_nomor' => ['nullable', 'string', 'max:20'],
                'driver_id' => ['required', 'exists:drivers,id'],
            ]);
            
            // Auto-fill plat nomor jika kosong
            if (empty($data['plat_nomor']) && !empty($data['unit_mobil'])) {
                $vehicle = \App\Models\Vehicle::where('name', $data['unit_mobil'])->first();
                if ($vehicle) {
                    $data['plat_nomor'] = $vehicle->plate_number;
                }
            }
            
        } elseif ($currentStatus === 'diproses' && $newStatus === 'digunakan') {
            // Disetujui -> Digunakan: Wajib isi KM keberangkatan
            $data = $request->validate([
                'status' => ['required', 'in:digunakan'],
                'km_awal' => ['required', 'integer', 'min:0'],
            ]);
            
        } elseif ($currentStatus === 'digunakan' && $newStatus === 'selesai') {
            // Digunakan -> Selesai: Wajib isi KM tiba dan jam kedatangan
            $data = $request->validate([
                'status' => ['required', 'in:selesai'],
                'km_akhir' => ['required', 'integer', 'min:0'],
                'jam_kedatangan' => ['required', 'string', 'max:10', 'regex:/^([01][0-9]|2[0-3]):[0-5][0-9]$/'],
            ]);
            
            // Validasi KM akhir harus lebih besar dari KM awal
            if ($data['km_akhir'] <= $transportRequest->km_awal) {
                throw ValidationException::withMessages(['km_akhir' => 'KM tiba harus lebih besar dari KM keberangkatan.']);
            }
            
        } elseif ($currentStatus === 'diajukan' && $newStatus === 'ditolak') {
            // Diajukan -> Ditolak
            $data = $request->validate([
                'status' => ['required', 'in:ditolak'],
            ]);
            
        } else {
            // Transisi status tidak valid
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
