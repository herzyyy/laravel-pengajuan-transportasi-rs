<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pengajuan Transportasi - {{ $transportRequest->id }}</title>
    <style>
        @media print {
            @page {
                size: A4;
                margin: 2cm;
            }
            body {
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
            max-width: 21cm;
            margin: 0 auto;
            padding: 15px;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header p {
            margin: 3px 0 0 0;
            font-size: 10pt;
        }

        .title {
            text-align: center;
            margin: 20px 0 15px 0;
        }

        .title h2 {
            margin: 0;
            font-size: 13pt;
            font-weight: bold;
            text-decoration: underline;
        }

        .title p {
            margin: 3px 0 0 0;
            font-size: 10pt;
        }

        .content {
            margin: 15px 0;
        }

        .section {
            margin-bottom: 12px;
            page-break-inside: avoid;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 6px;
            font-size: 11pt;
            border-bottom: 2px solid #000;
            padding-bottom: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        table td {
            padding: 3px 8px;
            vertical-align: top;
            font-size: 10.5pt;
        }

        table td:first-child {
            width: 30%;
            font-weight: normal;
        }

        table td:nth-child(2) {
            width: 3%;
        }

        table td:last-child {
            width: 67%;
        }

        /* Two column layout */
        .two-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 12px;
        }

        .column {
            break-inside: avoid;
        }

        .column table td:first-child {
            width: 45%;
        }

        .column table td:last-child {
            width: 52%;
        }

        .signature-section {
            margin-top: 25px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 45%;
            text-align: center;
        }

        .signature-box p {
            margin: 3px 0;
            font-size: 10pt;
        }

        .signature-space {
            height: 60px;
        }

        .footer {
            margin-top: 20px;
            font-size: 9pt;
            font-style: italic;
            text-align: center;
            color: #666;
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #10b981;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .print-button:hover {
            background-color: #059669;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9pt;
            font-weight: bold;
        }

        .badge-cito {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .badge-biasa {
            background-color: #f1f5f9;
            color: #475569;
        }

        @media print {
            .two-columns {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">
        🖨️ Print Surat
    </button>

    <div class="header">
        <h1>RUMAH SAKIT [NAMA RUMAH SAKIT]</h1>
        <p>Jl. [Alamat Rumah Sakit] | Telp: [Nomor Telepon] | Email: [Email]</p>
    </div>

    <div class="title">
        <h2>SURAT PENGAJUAN TRANSPORTASI</h2>
        <p>Nomor: {{ str_pad($transportRequest->id, 5, '0', STR_PAD_LEFT) }}/TRANS/{{ $transportRequest->created_at->format('m/Y') }}</p>
    </div>

    <div class="content">
        <!-- Section I & II dalam 2 kolom -->
        <div class="two-columns">
            <!-- Kolom Kiri: Data Pengajuan -->
            <div class="column">
                <div class="section">
                    <div class="section-title">I. DATA PENGAJUAN</div>
                    <table>
                        <tr>
                            <td>Jenis</td>
                            <td>:</td>
                            <td><strong>{{ strtoupper($transportRequest->jenis) }}</strong>
                                @if ($transportRequest->jenis === 'ambulance' && $transportRequest->keperluan)
                                    ({{ ucfirst($transportRequest->keperluan) }})
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Prioritas</td>
                            <td>:</td>
                            <td>
                                @if($transportRequest->prioritas === 'segera')
                                    <span class="badge badge-cito">★ CITO</span>
                                @else
                                    <span class="badge badge-biasa">BIASA</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Ajuan</td>
                            <td>:</td>
                            <td>{{ $transportRequest->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td><strong>{{ strtoupper($transportRequest->status) }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Kolom Kanan: Data Pemohon -->
            <div class="column">
                <div class="section">
                    <div class="section-title">II. DATA PEMOHON</div>
                    <table>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>{{ $transportRequest->user->name ?? $transportRequest->pemohon_nama }}</td>
                        </tr>
                        <tr>
                            <td>Unit Kerja</td>
                            <td>:</td>
                            <td>{{ $transportRequest->user->unit_kerja ?? $transportRequest->pemohon_unit }}</td>
                        </tr>
                        <tr>
                            <td>Kontak</td>
                            <td>:</td>
                            <td>{{ $transportRequest->kontak }}</td>
                        </tr>
                        @if($transportRequest->jenis === 'umum' && $transportRequest->jumlah_penumpang)
                        <tr>
                            <td>Penumpang</td>
                            <td>:</td>
                            <td>{{ $transportRequest->jumlah_penumpang }} orang</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        @if($transportRequest->jenis === 'ambulance')
        <div class="section">
            <div class="section-title">III. DATA PASIEN</div>
            <div class="two-columns">
                <div class="column">
                    <table>
                        <tr>
                            <td>Nama Pasien</td>
                            <td>:</td>
                            <td>{{ $transportRequest->pasien_nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>No. RM</td>
                            <td>:</td>
                            <td>{{ $transportRequest->pasien_no_rm ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Ruangan</td>
                            <td>:</td>
                            <td>{{ $transportRequest->ruangan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="column">
                    <table>
                        <tr>
                            <td>Kondisi</td>
                            <td>:</td>
                            <td>{{ $transportRequest->kondisi_pasien ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Pendamping</td>
                            <td>:</td>
                            <td>{{ $transportRequest->pendamping_nama ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            @if($transportRequest->alamat_pasien)
            <table>
                <tr>
                    <td style="width: 30%;">Alamat Pasien</td>
                    <td style="width: 3%;">:</td>
                    <td>{{ $transportRequest->alamat_pasien }}</td>
                </tr>
            </table>
            @endif
        </div>
        @endif

        <div class="section">
            <div class="section-title">{{ $transportRequest->jenis === 'ambulance' ? 'IV' : 'III' }}. JADWAL & TUJUAN</div>
            <div class="two-columns">
                <div class="column">
                    <table>
                        <tr>
                            <td>Tgl Berangkat</td>
                            <td>:</td>
                            <td>{{ $transportRequest->tanggal->format('d/m/Y') }} {{ $transportRequest->jam }}</td>
                        </tr>
                        <tr>
                            <td>Tgl Kembali</td>
                            <td>:</td>
                            <td>{{ $transportRequest->tanggal_sampai->format('d/m/Y') }} {{ $transportRequest->jam_sampai ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="column">
                    <table>
                        <tr>
                            <td>Alamat Asal</td>
                            <td>:</td>
                            <td>{{ $transportRequest->alamat_asal ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Alamat Tujuan</td>
                            <td>:</td>
                            <td>{{ $transportRequest->alamat_tujuan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            @if($transportRequest->keterangan)
            <table>
                <tr>
                    <td style="width: 30%;">Keterangan</td>
                    <td style="width: 3%;">:</td>
                    <td>{{ $transportRequest->keterangan }}</td>
                </tr>
            </table>
            @endif
        </div>

        <div class="section">
            <div class="section-title">{{ $transportRequest->jenis === 'ambulance' ? 'V' : 'IV' }}. DATA KENDARAAN & SUPIR</div>
            <div class="two-columns">
                <div class="column">
                    <table>
                        <tr>
                            <td>Unit Kendaraan</td>
                            <td>:</td>
                            <td><strong>{{ $transportRequest->unit_mobil ?? '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td>Nomor Polisi</td>
                            <td>:</td>
                            <td><strong>{{ $transportRequest->plat_nomor ?? '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td>Nama Supir</td>
                            <td>:</td>
                            <td><strong>{{ $transportRequest->driver->name ?? '-' }}</strong>
                                @if($transportRequest->driver && $transportRequest->driver->phone)
                                    <br><span style="font-size: 9pt; font-weight: normal;">{{ $transportRequest->driver->phone }}</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="column">
                    <table>
                        <tr>
                            <td>KM Awal</td>
                            <td>:</td>
                            <td>{{ $transportRequest->km_awal ?? '-' }} km</td>
                        </tr>
                        <tr>
                            <td>KM Akhir</td>
                            <td>:</td>
                            <td>{{ $transportRequest->km_akhir ?? '-' }} km</td>
                        </tr>
                        @if($transportRequest->km_awal && $transportRequest->km_akhir)
                        <tr>
                            <td>Total Jarak</td>
                            <td>:</td>
                            <td><strong>{{ $transportRequest->km_akhir - $transportRequest->km_awal }} km</strong></td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <p style="font-size: 10pt;">Pemohon,</p>
            <div class="signature-space"></div>
            <p style="font-weight: bold;">{{ $transportRequest->user->name ?? $transportRequest->pemohon_nama }}</p>
            <p style="font-size: 9pt;">{{ $transportRequest->user->unit_kerja ?? $transportRequest->pemohon_unit }}</p>
        </div>
        <div class="signature-box">
            <p style="font-size: 10pt;">Mengetahui,</p>
            <p style="font-size: 10pt;">Admin Transportasi</p>
            <div class="signature-space"></div>
            <p style="font-weight: bold;">(...........................)</p>
            <p style="font-size: 9pt;">{{ $transportRequest->updated_at->format('d/m/Y') }}</p>
        </div>
    </div>

    <div class="footer">
        <p>Dokumen dicetak pada {{ now()->format('d/m/Y H:i') }} WIB</p>
    </div>
</body>
</html>
