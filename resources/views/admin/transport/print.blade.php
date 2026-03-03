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
            font-size: 10pt;
            line-height: 1.3;
            color: #000;
            max-width: 21cm;
            margin: 0 auto;
            padding: 12px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0 0 0;
            font-size: 9pt;
        }

        .title {
            text-align: center;
            margin: 12px 0 10px 0;
        }

        .title h2 {
            margin: 0;
            font-size: 12pt;
            font-weight: bold;
            text-decoration: underline;
        }

        .title p {
            margin: 2px 0 0 0;
            font-size: 9pt;
        }

        .content {
            margin: 10px 0;
        }

        .section {
            margin-bottom: 8px;
            page-break-inside: avoid;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 4px;
            font-size: 10pt;
            border-bottom: 1.5px solid #000;
            padding-bottom: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        table td {
            padding: 2px 6px;
            vertical-align: top;
            font-size: 9.5pt;
        }

        table td:first-child {
            width: 28%;
            font-weight: normal;
        }

        table td:nth-child(2) {
            width: 2%;
        }

        table td:last-child {
            width: 70%;
        }

        /* Two column layout */
        .two-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 8px;
        }

        .column {
            break-inside: avoid;
        }

        .column table td:first-child {
            width: 42%;
        }

        .column table td:last-child {
            width: 55%;
        }

        .signature-section {
            margin-top: 15px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }

        .signature-box {
            text-align: center;
            padding: 0 4px;
        }

        .signature-box p {
            margin: 2px 0;
            font-size: 8.5pt;
        }

        .signature-space {
            height: 45px;
        }

        .footer {
            margin-top: 12px;
            font-size: 8pt;
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
                                    <strong>CITO / SEGERA</strong>
                                @else
                                    BIASA
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Ajuan</td>
                            <td>:</td>
                            <td>{{ $transportRequest->created_at->format('d/m/Y H:i') }}</td>
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
                    </table>
                </div>
                <div class="column">
                    @if($transportRequest->alamat_pasien)
                    <table>
                        <tr>
                            <td>Alamat Pasien</td>
                            <td>:</td>
                            <td>{{ $transportRequest->alamat_pasien }}</td>
                        </tr>
                    </table>
                    @endif
                </div>
            </div>
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
                            <td>Alamat Tujuan</td>
                            <td>:</td>
                            <td>{{ $transportRequest->alamat_tujuan ?? '-' }}</td>
                        </tr>
                        @if($transportRequest->jenis === 'umum' && $transportRequest->keperluan)
                        <tr>
                            <td>Keperluan</td>
                            <td>:</td>
                            <td>{{ $transportRequest->keperluan }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
            @if($transportRequest->keterangan)
            <table>
                <tr>
                    <td style="width: 28%;">Keterangan</td>
                    <td style="width: 2%;">:</td>
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
                                    ({{ $transportRequest->driver->phone }})
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
            <p style="font-weight: bold; margin-bottom: 3px;">Yang Mengajukan</p>
            <div class="signature-space"></div>
            <p style="font-weight: bold; text-decoration: underline; margin: 0;">{{ $transportRequest->user->name ?? $transportRequest->pemohon_nama }}</p>
            <p style="font-size: 7.5pt; margin: 1px 0 0 0;">{{ $transportRequest->user->unit_kerja ?? $transportRequest->pemohon_unit }}</p>
        </div>
        
        <div class="signature-box">
            <p style="font-weight: bold; margin-bottom: 3px;">Diketahui</p>
            <p style="font-size: 8pt; margin: 0 0 3px 0;">Kepala/DO</p>
            <div class="signature-space"></div>
            <p style="font-weight: bold; margin: 0;">(.......................)</p>
        </div>

        <div class="signature-box">
            <p style="font-weight: bold; margin-bottom: 3px;">Pengemudi</p>
            <div class="signature-space"></div>
            <p style="font-weight: bold; text-decoration: underline; margin: 0;">{{ $transportRequest->driver->name ?? '(.....................)' }}</p>
            @if($transportRequest->driver && $transportRequest->driver->phone)
                <p style="font-size: 7.5pt; margin: 1px 0 0 0;">{{ $transportRequest->driver->phone }}</p>
            @endif
        </div>
        
        <div class="signature-box">
            <p style="font-weight: bold; margin-bottom: 3px;">Diketahui</p>
            <p style="font-size: 8pt; margin: 0 0 3px 0;">Keamanan RS Azra</p>
            <div class="signature-space"></div>
            <p style="font-weight: bold; margin: 0;">(.......................)</p>
        </div>
    </div>

    <div class="footer">
        <p>Dokumen dicetak pada {{ now()->format('d/m/Y H:i') }} WIB</p>
    </div>
</body>
</html>
