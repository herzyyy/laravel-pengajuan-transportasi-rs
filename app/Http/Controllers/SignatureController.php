<?php

namespace App\Http\Controllers;

use App\Models\TransportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SignatureController extends Controller
{
    public function show(TransportRequest $transportRequest)
    {
        // Tentukan siapa yang harus tanda tangan berdasarkan status
        $signatureType = $this->determineSignatureType($transportRequest);
        
        if (!$signatureType) {
            return redirect()->back()->with('error', 'Tidak ada tanda tangan yang diperlukan saat ini.');
        }
        
        return view('signature.show', compact('transportRequest', 'signatureType'));
    }
    
    public function sign(Request $request, TransportRequest $transportRequest)
    {
        $signatureType = $this->determineSignatureType($transportRequest);
        
        if (!$signatureType) {
            return redirect()->back()->with('error', 'Tidak ada tanda tangan yang diperlukan saat ini.');
        }
        
        // Generate unique signature code
        $signatureCode = Str::random(32);
        
        // Update signature berdasarkan tipe
        switch ($signatureType) {
            case 'pemohon':
                $transportRequest->update([
                    'signature_pemohon' => $signatureCode,
                    'signature_pemohon_at' => now(),
                ]);
                $message = 'Tanda tangan pemohon berhasil disimpan.';
                $redirect = auth()->user()->isAdmin() 
                    ? route('admin.transport.index') 
                    : route('pengajuan.index');
                break;
                
            case 'pengelola_1':
                $transportRequest->update([
                    'signature_pengelola_1' => $signatureCode,
                    'signature_pengelola_1_at' => now(),
                    'signature_pengelola_1_name' => auth()->user()->full_name,
                ]);
                $message = 'Tanda tangan pengelola (menyetujui) berhasil disimpan.';
                $redirect = route('admin.transport.show', $transportRequest);
                break;
                
            case 'driver':
                $transportRequest->update([
                    'signature_driver' => $signatureCode,
                    'signature_driver_at' => now(),
                ]);
                $message = 'Tanda tangan pengemudi berhasil disimpan.';
                $redirect = route('admin.transport.show', $transportRequest);
                break;
                
            case 'pengelola_2':
                $transportRequest->update([
                    'signature_pengelola_2' => $signatureCode,
                    'signature_pengelola_2_at' => now(),
                    'signature_pengelola_2_name' => auth()->user()->full_name,
                ]);
                $message = 'Tanda tangan pengelola (mengetahui) berhasil disimpan.';
                $redirect = route('admin.transport.show', $transportRequest);
                break;
                
            default:
                return redirect()->back()->with('error', 'Tipe tanda tangan tidak valid.');
        }
        
        return redirect($redirect)->with('success', $message);
    }
    
    private function determineSignatureType(TransportRequest $transportRequest)
    {
        $user = auth()->user();
        
        // Pemohon: setelah mengajukan (status diajukan) dan belum tanda tangan
        if ($transportRequest->status === 'diajukan' && 
            (!isset($transportRequest->signature_pemohon) || !$transportRequest->signature_pemohon) && 
            $transportRequest->user_id === $user->id) {
            return 'pemohon';
        }
        
        // Pengelola 1: setelah disetujui (status diproses) dan belum tanda tangan
        if ($transportRequest->status === 'diproses' && 
            (!isset($transportRequest->signature_pengelola_1) || !$transportRequest->signature_pengelola_1) && 
            $user->isAdmin()) {
            return 'pengelola_1';
        }
        
        // Driver: setelah digunakan (status digunakan) dan belum tanda tangan
        if ($transportRequest->status === 'digunakan' && 
            (!isset($transportRequest->signature_driver) || !$transportRequest->signature_driver) && 
            ($user->isAdmin() || $transportRequest->driver_id === $user->id)) {
            return 'driver';
        }
        
        // Pengelola 2: setelah selesai (status selesai) dan belum tanda tangan
        if ($transportRequest->status === 'selesai' && 
            (!isset($transportRequest->signature_pengelola_2) || !$transportRequest->signature_pengelola_2) && 
            $user->isAdmin()) {
            return 'pengelola_2';
        }
        
        return null;
    }
}
