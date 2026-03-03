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
            'selesai' => $counts['selesai'] ?? 0,
            'ditolak' => $counts['ditolak'] ?? 0,
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
        $query = TransportRequest::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $items = $query->paginate(15)->withQueryString();

        return view('admin.transport.index', compact('items'));
    }

    public function show(TransportRequest $transportRequest)
    {
        $drivers = \App\Models\Driver::where('is_active', true)->orderBy('name')->get();
        return view('admin.transport.show', compact('transportRequest', 'drivers'));
    }

    public function update(Request $request, TransportRequest $transportRequest)
    {
        $data = $request->validate([
            'status' => ['required', 'in:diproses,selesai,ditolak'],
            'unit_mobil' => ['nullable', 'string', 'max:100'],
            'driver_id' => ['nullable', 'exists:drivers,id'],
            'plat_nomor' => ['nullable', 'string', 'max:20'],
            'km_awal' => ['nullable', 'integer', 'min:0'],
            'km_akhir' => ['nullable', 'integer', 'min:0'],
            'jam_sampai' => ['nullable', 'string', 'max:10', 'regex:/^([01][0-9]|2[0-3]):[0-5][0-9]$/'],
        ]);

        if ($data['status'] === 'diproses') {
            if (empty($data['unit_mobil'])) {
                throw ValidationException::withMessages(['unit_mobil' => 'Unit kendaraan wajib diisi saat disetujui / sedang digunakan.']);
            }
            if (empty($data['plat_nomor'])) {
                throw ValidationException::withMessages(['plat_nomor' => 'Plat nomor wajib diisi saat diproses.']);
            }
            if (! isset($data['km_awal'])) {
                throw ValidationException::withMessages(['km_awal' => 'KM Awal wajib diisi saat diproses.']);
            }
        }

        if ($data['status'] === 'selesai') {
            if (! isset($data['km_akhir'])) {
                throw ValidationException::withMessages(['km_akhir' => 'KM Akhir wajib diisi saat selesai.']);
            }
            if (empty($data['jam_sampai'])) {
                throw ValidationException::withMessages(['jam_sampai' => 'Jam kedatangan wajib diisi saat selesai.']);
            }
        }

        $transportRequest->update($data);

        return redirect()->route('admin.transport.show', $transportRequest)
            ->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    public function print(TransportRequest $transportRequest)
    {
        $transportRequest->load('driver');
        return view('admin.transport.print', compact('transportRequest'));
    }
}
