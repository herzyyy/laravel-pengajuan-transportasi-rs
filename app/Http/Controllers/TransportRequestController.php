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
        $items = $request->user()
            ->transportRequests()
            ->latest()
            ->paginate(10);

        return view('transport.index', compact('items'));
    }

    public function createUmum()
    {
        return view('transport.umum_form');
    }

    public function storeUmum(Request $request)
    {
        $data = $request->validate([
            'unit_mobil' => ['required', 'string', 'in:mobil_umum_1,mobil_umum_2,ambulans,taksi,lainnya'],
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
        if ($sampai->lt($mulai)) {
            $sampai->addDay();
            // also update tanggal_sampai so saved model reflects next-day date
            $data['tanggal_sampai'] = Carbon::parse($data['tanggal_sampai'])->addDay()->toDateString();
        }

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

        return redirect()->route('pengajuan.success', $transportRequest);
    }

    public function checkAvailability(Request $request)
    {
        $data = $request->validate([
            'unit_mobil' => ['required', 'string', 'in:mobil_umum_1,mobil_umum_2,ambulans,taksi,lainnya'],
            'tanggal' => ['required', 'date'],
            'jam' => ['required', 'date_format:H:i'],
            'tanggal_sampai' => ['required', 'date'],
            'jam_sampai' => ['required', 'date_format:H:i'],
        ]);

        $mulai = Carbon::parse($data['tanggal'].' '.$data['jam']);
        $sampai = Carbon::parse($data['tanggal_sampai'].' '.$data['jam_sampai']);
        // Support overnight: if sampai less than mulai, assume next day
        if ($sampai->lt($mulai)) {
            $sampai->addDay();
        }

        $conflicts = TransportRequest::where('jenis', 'umum')
            ->where('unit_mobil', $data['unit_mobil'])
            ->where('status', 'diproses') // only consider approved/ongoing requests
            ->get()
            ->filter(function ($r) use ($mulai, $sampai) {
                $rMulai = Carbon::parse($r->tanggal.' '.$r->jam);
                $rSampai = ($r->tanggal_sampai && $r->jam_sampai)
                    ? Carbon::parse($r->tanggal_sampai.' '.$r->jam_sampai)
                    : $rMulai;

                if ($rSampai->lt($rMulai)) {
                    $rSampai->addDay();
                }

                // consider intervals overlapping only when they truly intersect
                // allow back-to-back bookings where one ends exactly when another starts
                return $mulai->lt($rSampai) && $rMulai->lt($sampai);
            });

        return response()->json([
            'available' => $conflicts->isEmpty(),
            'conflicts_count' => $conflicts->count(),
        ]);
    }

    public function createAmbulance()
    {
        // Default ke "antar", tapi tetap mempertahankan pilihan terakhir user (old input)
        $purpose = old('purpose', 'antar');

        return view('transport.ambulance_form', [
            'purpose' => $purpose,
        ]);
    }

    public function storeAmbulance(Request $request)
    {
        $data = $request->validate([
            'purpose' => ['required', 'in:antar,jemput'],
            'unit_mobil' => ['required', 'string', 'in:ambulans,lainnya'],
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
        if ($sampai->lt($mulai)) {
            $sampai->addDay();
            $data['tanggal_sampai'] = Carbon::parse($data['tanggal_sampai'])->addDay()->toDateString();
        }

        $alamatAsal = $purpose === 'antar' ? 'RS' : ($data['alamat_asal'] ?? 'RS');
        $alamatTujuan = $purpose === 'antar' ? ($data['alamat_tujuan'] ?? 'RS') : 'RS';

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

        return redirect()->route('pengajuan.success', $transportRequest);
    }

    public function checkAmbulanceAvailability(Request $request)
    {
        $data = $request->validate([
            'unit_mobil' => ['required', 'string', 'in:ambulans,lainnya'],
            'tanggal' => ['required', 'date'],
            'jam' => ['required', 'date_format:H:i'],
            'tanggal_sampai' => ['required', 'date'],
            'jam_sampai' => ['required', 'date_format:H:i'],
        ]);

        $mulai = Carbon::parse($data['tanggal'].' '.$data['jam']);
        $sampai = Carbon::parse($data['tanggal_sampai'].' '.$data['jam_sampai']);
        if ($sampai->lt($mulai)) {
            $sampai->addDay();
        }

        $conflicts = TransportRequest::where('jenis', 'ambulance')
            ->where('unit_mobil', $data['unit_mobil'])
            ->where('status', 'diproses')
            ->get()
            ->filter(function ($r) use ($mulai, $sampai) {
                $rMulai = Carbon::parse($r->tanggal.' '.$r->jam);
                $rSampai = ($r->tanggal_sampai && $r->jam_sampai)
                    ? Carbon::parse($r->tanggal_sampai.' '.$r->jam_sampai)
                    : $rMulai;

                if ($rSampai->lt($rMulai)) {
                    $rSampai->addDay();
                }

                // consider intervals overlapping only when they truly intersect
                // allow back-to-back bookings where one ends exactly when another starts
                return $mulai->lt($rSampai) && $rMulai->lt($sampai);
            });

        return response()->json([
            'available' => $conflicts->isEmpty(),
            'conflicts_count' => $conflicts->count(),
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

