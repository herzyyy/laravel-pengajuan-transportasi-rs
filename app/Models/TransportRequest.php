<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis', // umum | ambulance
        'keperluan', // umum: aktivitas; ambulance: antar|jemput
        'prioritas', // biasa|segera

        // umum
        'pemohon_nama',
        'pemohon_unit',
        'jumlah_penumpang',

        'unit_mobil',
        'driver_id',
        'plat_nomor',
        'km_awal',
        'km_akhir',

        // umum + ambulance (umum dipakai untuk tujuan)
        'tanggal',
        'tanggal_sampai',
        'jam',
        'jam_sampai',
        'jam_kedatangan',
        'kontak',
        'alamat_asal',
        'alamat_tujuan',
        'keterangan',

        // ambulance
        'pasien_nama',
        'pasien_no_rm',
        'ruangan',
        'kondisi_pasien',
        'alamat_pasien',
        'pendamping_nama',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_sampai' => 'date',
        'jumlah_penumpang' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}

