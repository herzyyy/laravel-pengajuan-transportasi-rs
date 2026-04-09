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
        return view('transport.umum_form');
    }

    public function storeUmum(Request $request)
    {
        $data = $request->validate([
            'tanggal' => ['required', 'date'],
            'jam' => ['required', 'date_format:H:i'],
            'tanggal_sampai' => ['required', 'date'],
            'jam_sampai' => ['required', 'date_format:H:i'],
            'prioritas' => ['required', 'in:segera,biasa'],
            'alamat_tujuan' => ['required', 'string', 'max:2000'],
            'keperluan' => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string', 'max:2000'],
        ]);

        $data['kontak'] = $request->user()->phone ?? '';

        $mulai = Carbon::parse($data['tanggal'].' '.$data['jam']);
        $sampai = Carbon::parse($data['tanggal_sampai'].' '.$data['jam_sampai']);
        if ($sampai->lte($mulai)) {
            $sampai->addDay();
            $data['tanggal_sampai'] = Carbon::parse($data['tanggal_sampai'])->addDay()->toDateString();
        }

        $transportRequest = TransportRequest::create([
            'user_id' => $request->user()->id,
            'jenis' => 'umum',
            'unit_mobil' => null,
            'keperluan' => $data['keperluan'],
            'prioritas' => $data['prioritas'],
            'pemohon_nama' => $request->user()->name,
            'pemohon_unit' => $request->user()->unit_kerja,
            'jumlah_penumpang' => null,
            // Auto-sign pemohon
            'signature_pemohon' => \Illuminate\Support\Str::random(32),
            'signature_pemohon_at' => now(),
            ...collect($data)->except(['keperluan', 'prioritas'])->all(),
        ]);

        return redirect()->route('pengajuan.success', $transportRequest)
            ->with('success', 'Pengajuan berhasil dibuat.');
    }

    public function checkAvailability(Request $request)
    {
        $data = $request->validate([
            'tanggal' => ['required', 'date'],
            'jam' => ['required', 'date_format:H:i'],
            'tanggal_sampai' => ['required', 'date'],
            'jam_sampai' => ['required', 'date_format:H:i'],
        ]);

        $mulai = Carbon::parse($data['tanggal'].' '.$data['jam']);
        $sampai = Carbon::parse($data['tanggal_sampai'].' '.$data['jam_sampai']);
        if ($sampai->lte($mulai)) $sampai->addDay();

        // Total unit umum aktif
        $totalUnits = \App\Models\Vehicle::where('type', 'umum')->where('is_active', true)->count();

        // Unit umum yang sedang digunakan pada rentang waktu ini
        $umumVehicleNames = \App\Models\Vehicle::where('type', 'umum')->where('is_active', true)->pluck('name');

        $usedUnits = TransportRequest::where('status', 'digunakan')
            ->whereNotNull('unit_mobil')
            ->whereIn('unit_mobil', $umumVehicleNames)
            ->get()
            ->filter(function ($r) use ($mulai, $sampai) {
                $rMulai = Carbon::parse($r->tanggal->format('Y-m-d').' '.$r->jam);
                $rSampai = ($r->tanggal_sampai && $r->jam_sampai)
                    ? Carbon::parse($r->tanggal_sampai->format('Y-m-d').' '.$r->jam_sampai)
                    : $rMulai->copy()->addHour();
                if ($rSampai->lte($rMulai)) $rSampai->addDay();
                return $mulai->lt($rSampai) && $rMulai->lt($sampai);
            })
            ->pluck('unit_mobil')
            ->unique()
            ->count();

        $available = $usedUnits < $totalUnits;

        return response()->json([
            'available' => $available,
            'total_units' => $totalUnits,
            'used_units' => $usedUnits,
            'available_units' => max(0, $totalUnits - $usedUnits),
        ]);
    }

    public function createAmbulance()
    {
        $purpose = old('purpose', 'antar');
        return view('transport.ambulance_form', compact('purpose'));
    }

    public function storeAmbulance(Request $request)
    {
        $data = $request->validate([
            'purpose' => ['required', 'in:antar,jemput'],
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

        $purpose = $data['purpose'];
        if ($purpose === 'antar' && empty($data['alamat_tujuan'])) {
            throw ValidationException::withMessages(['alamat_tujuan' => 'Alamat tujuan harus diisi.']);
        }
        if ($purpose === 'jemput' && empty($data['alamat_asal'])) {
            throw ValidationException::withMessages(['alamat_asal' => 'Alamat asal harus diisi.']);
        }

        $data['kontak'] = '';

        $mulai = Carbon::parse($data['tanggal'].' '.$data['jam']);
        $sampai = Carbon::parse($data['tanggal_sampai'].' '.$data['jam_sampai']);
        if ($sampai->lte($mulai)) {
            $sampai->addDay();
            $data['tanggal_sampai'] = Carbon::parse($data['tanggal_sampai'])->addDay()->toDateString();
        }

        $alamatAsal = $purpose === 'antar' ? 'RS' : ($data['alamat_asal'] ?? 'RS');
        $alamatTujuan = $purpose === 'antar' ? ($data['alamat_tujuan'] ?? 'RS') : 'RS';

        $transportRequest = TransportRequest::create([
            'user_id' => $request->user()->id,
            'jenis' => 'ambulance',
            'unit_mobil' => null,
            'keperluan' => $purpose,
            'prioritas' => $data['prioritas'],
            ...collect($data)->except(['prioritas'])->all(),
            'alamat_asal' => $alamatAsal,
            'alamat_tujuan' => $alamatTujuan,
            'ruangan' => null,
            'pendamping_nama' => null,
            'kondisi_pasien' => null,
            // Auto-sign pemohon
            'signature_pemohon' => \Illuminate\Support\Str::random(32),
            'signature_pemohon_at' => now(),
        ]);

        return redirect()->route('pengajuan.success', $transportRequest)
            ->with('success', 'Pengajuan berhasil dibuat.');
    }

    public function checkAmbulanceAvailability(Request $request)
    {
        $data = $request->validate([
            'tanggal' => ['required', 'date'],
            'jam' => ['required', 'date_format:H:i'],
            'tanggal_sampai' => ['required', 'date'],
            'jam_sampai' => ['required', 'date_format:H:i'],
        ]);

        $mulai = Carbon::parse($data['tanggal'].' '.$data['jam']);
        $sampai = Carbon::parse($data['tanggal_sampai'].' '.$data['jam_sampai']);
        if ($sampai->lte($mulai)) $sampai->addDay();

        // Total unit ambulance aktif
        $totalUnits = \App\Models\Vehicle::where('type', 'ambulance')->where('is_active', true)->count();

        // Unit ambulance yang sedang digunakan pada rentang waktu ini
        $ambulanceVehicleNames = \App\Models\Vehicle::where('type', 'ambulance')->where('is_active', true)->pluck('name');

        $usedUnits = TransportRequest::where('status', 'digunakan')
            ->whereNotNull('unit_mobil')
            ->whereIn('unit_mobil', $ambulanceVehicleNames)
            ->get()
            ->filter(function ($r) use ($mulai, $sampai) {
                $rMulai = Carbon::parse($r->tanggal->format('Y-m-d').' '.$r->jam);
                $rSampai = ($r->tanggal_sampai && $r->jam_sampai)
                    ? Carbon::parse($r->tanggal_sampai->format('Y-m-d').' '.$r->jam_sampai)
                    : $rMulai->copy()->addHour();
                if ($rSampai->lte($rMulai)) $rSampai->addDay();
                return $mulai->lt($rSampai) && $rMulai->lt($sampai);
            })
            ->pluck('unit_mobil')
            ->unique()
            ->count();

        $available = $usedUnits < $totalUnits;

        return response()->json([
            'available' => $available,
            'total_units' => $totalUnits,
            'used_units' => $usedUnits,
            'available_units' => max(0, $totalUnits - $usedUnits),
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

