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
                margin: 1.5cm 2cm;
            }
            body {
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 9.5pt;
            line-height: 1.3;
            color: #1a1a1a;
            max-width: 21cm;
            margin: 0 auto;
            padding: 10px;
            background: #fff;
        }

        /* Header dengan Logo */
        .letterhead {
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 2.5px solid #10b981;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        .letterhead-logo {
            flex-shrink: 0;
        }

        .letterhead-logo img {
            height: 55px;
            width: auto;
        }

        .letterhead-info {
            flex: 1;
        }

        .letterhead-info h1 {
            margin: 0 0 2px 0;
            font-size: 15pt;
            font-weight: bold;
            color: #10b981;
            letter-spacing: 0.3px;
        }

        .letterhead-info .subtitle {
            margin: 0 0 3px 0;
            font-size: 8.5pt;
            color: #059669;
            font-weight: 600;
        }

        .letterhead-info .contact {
            margin: 0;
            font-size: 7.5pt;
            color: #666;
            line-height: 1.2;
        }

        /* Document Title */
        .document-title {
            text-align: center;
            margin: 10px 0 8px 0;
            padding: 8px 0;
            background: #e6f7f6;
            border-left: 3px solid #007774;
            border-right: 3px solid #007774;
        }

        .document-title h2 {
            margin: 0 0 3px 0;
            font-size: 12pt;
            font-weight: bold;
            color: #065f46;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .document-title .doc-number {
            margin: 0;
            font-size: 8pt;
            color: #047857;
            font-weight: 600;
        }

        /* Content Sections */
        .content {
            margin: 10px 0;
        }

        .section {
            margin-bottom: 8px;
            page-break-inside: avoid;
        }

        .section-header {
            background: #007774;
            color: white;
            padding: 4px 8px;
            font-weight: bold;
            font-size: 9pt;
            margin-bottom: 5px;
            border-radius: 3px;
            letter-spacing: 0.2px;
        }

        .section-content {
            padding: 0 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3px;
        }

        table td {
            padding: 2px 5px;
            vertical-align: top;
            font-size: 9pt;
        }

        table td:first-child {
            width: 32%;
            color: #4b5563;
            font-weight: 500;
        }

        table td:nth-child(2) {
            width: 2%;
            color: #6b7280;
        }

        table td:last-child {
            width: 66%;
            color: #1f2937;
        }

        .value-highlight {
            font-weight: 600;
            color: #065f46;
        }

        .badge-cito {
            display: inline-block;
            background: #dc2626;
            color: white;
            padding: 1px 6px;
            border-radius: 2px;
            font-size: 7.5pt;
            font-weight: bold;
            letter-spacing: 0.3px;
        }

        /* Two Column Layout */
        .two-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 5px;
        }

        .column {
            break-inside: avoid;
        }

        /* Info Box */
        .info-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-left: 2px solid #10b981;
            padding: 6px 8px;
            margin: 4px 0;
            border-radius: 3px;
        }

        .info-box table td:first-child {
            width: 38%;
        }

        .info-box table td:last-child {
            width: 60%;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 15px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            page-break-inside: avoid;
        }

        .signature-box {
            text-align: center;
            padding: 5px;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            background: #fafafa;
        }

        .signature-box .title {
            font-weight: bold;
            font-size: 8.5pt;
            color: #065f46;
            margin: 0 0 1px 0;
        }

        .signature-box .subtitle {
            font-size: 7.5pt;
            color: #6b7280;
            margin: 0 0 5px 0;
        }

        .signature-space {
            height: 40px;
            margin: 5px 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .signature-space img {
            max-width: 50px;
            max-height: 50px;
            width: auto;
            height: auto;
        }

        .signature-box .name {
            font-weight: bold;
            font-size: 8.5pt;
            color: #1f2937;
            margin: 0;
            border-bottom: 1px solid #1f2937;
            display: inline-block;
            padding-bottom: 1px;
        }

        .signature-box .detail {
            font-size: 7pt;
            color: #6b7280;
            margin: 2px 0 0 0;
        }

        /* Footer */
        .document-footer {
            margin-top: 12px;
            padding-top: 8px;
            border-top: 1.5px solid #e5e7eb;
            text-align: center;
        }

        .document-footer p {
            margin: 0;
            font-size: 7pt;
            color: #9ca3af;
            font-style: italic;
        }

        /* Print Button */
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background: #007774;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0, 119, 116, 0.3);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .print-button:hover {
            background: #005a57;
            box-shadow: 0 6px 8px rgba(0, 119, 116, 0.4);
            transform: translateY(-2px);
        }

        .print-button:active {
            transform: translateY(0);
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 3px;
            font-size: 8pt;
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        .status-selesai {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        @media print {
            body {
                padding: 0;
            }
            
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
        🖨️ Cetak Surat
    </button>

    <!-- Letterhead -->
    <div class="letterhead">
        <div class="letterhead-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo RS Azra">
        </div>
        <div class="letterhead-info">
            <h1>rs azra</h1>
            <p class="subtitle">Rumah Sakit Umum</p>
            <p class="contact">
                Jl. Pajajaran No. 219, Bogor 16143<br>
                Telp: (0251) 8324054 | Email: info@rsazra.co.id | www.rsazra.co.id
            </p>
        </div>
    </div>

    <!-- Document Title -->
    <div class="document-title">
        <h2>Surat Pengajuan Transportasi</h2>
        <p class="doc-number">No: {{ str_pad($transportRequest->id, 5, '0', STR_PAD_LEFT) }}/TRANS/RSA/{{ $transportRequest->created_at->format('m/Y') }}</p>
    </div>

    <!-- Content -->
    <div class="content">
        <!-- Section 1: Data Pengajuan & Pemohon -->
        <div class="two-columns">
            <div class="column">
                <div class="section">
                    <div class="section-header">I. DATA PENGAJUAN</div>
                    <div class="section-content">
                        <table>
                            <tr>
                                <td>Jenis Transportasi</td>
                                <td>:</td>
                                <td>
                                    <span class="value-highlight">{{ strtoupper($transportRequest->jenis) }}</span>
                                    @if ($transportRequest->jenis === 'ambulance' && $transportRequest->keperluan)
                                        <span style="color: #6b7280;">({{ ucfirst($transportRequest->keperluan) }})</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Prioritas</td>
                                <td>:</td>
                                <td>
                                    @if($transportRequest->prioritas === 'segera')
                                        <span class="badge-cito">CITO / SEGERA</span>
                                    @else
                                        <span class="value-highlight">BIASA</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal Pengajuan</td>
                                <td>:</td>
                                <td>{{ $transportRequest->created_at->format('d F Y, H:i') }} WIB</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td>
                                    <span class="status-badge status-selesai">
                                        {{ strtoupper($transportRequest->status) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="column">
                <div class="section">
                    <div class="section-header">II. DATA PEMOHON</div>
                    <div class="section-content">
                        <table>
                            <tr>
                                <td>Nama Pemohon</td>
                                <td>:</td>
                                <td class="value-highlight">{{ $transportRequest->user->full_name ?? $transportRequest->pemohon_nama }}</td>
                            </tr>
                            <tr>
                                <td>Unit Kerja</td>
                                <td>:</td>
                                <td>{{ $transportRequest->user->unit_kerja ?? $transportRequest->pemohon_unit }}</td>
                            </tr>
                            @if($transportRequest->jenis === 'umum' && $transportRequest->jumlah_penumpang)
                            <tr>
                                <td>Jumlah Penumpang</td>
                                <td>:</td>
                                <td class="value-highlight">{{ $transportRequest->jumlah_penumpang }} orang</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Data Pasien (jika ambulance) -->
        @if($transportRequest->jenis === 'ambulance')
        <div class="section">
            <div class="section-header">III. DATA PASIEN</div>
            <div class="section-content">
                <div class="info-box">
                    <table>
                        <tr>
                            <td>Nama Pasien</td>
                            <td>:</td>
                            <td class="value-highlight">{{ $transportRequest->pasien_nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>No. Rekam Medis</td>
                            <td>:</td>
                            <td class="value-highlight">{{ $transportRequest->pasien_no_rm ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Ruangan</td>
                            <td>:</td>
                            <td>{{ $transportRequest->ruangan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Kondisi Pasien</td>
                            <td>:</td>
                            <td>{{ $transportRequest->kondisi_pasien ?? '-' }}</td>
                        </tr>
                        @if($transportRequest->pendamping_nama)
                        <tr>
                            <td>Nama Pendamping</td>
                            <td>:</td>
                            <td>{{ $transportRequest->pendamping_nama }}</td>
                        </tr>
                        @endif
                        @if($transportRequest->alamat_pasien)
                        <tr>
                            <td>Alamat Pasien</td>
                            <td>:</td>
                            <td>{{ $transportRequest->alamat_pasien }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Section 4: Jadwal & Tujuan -->
        <div class="section">
            <div class="section-header">{{ $transportRequest->jenis === 'ambulance' ? 'IV' : 'III' }}. JADWAL & TUJUAN PERJALANAN</div>
            <div class="section-content">
                <div class="two-columns">
                    <div class="column">
                        <table>
                            <tr>
                                <td>Tanggal Berangkat</td>
                                <td>:</td>
                                <td class="value-highlight">{{ $transportRequest->tanggal->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td>Jam Berangkat</td>
                                <td>:</td>
                                <td class="value-highlight">{{ substr($transportRequest->jam, 0, 5) }} WIB</td>
                            </tr>
                            <tr>
                                <td>Tanggal Kembali</td>
                                <td>:</td>
                                <td class="value-highlight">{{ $transportRequest->tanggal_sampai->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td>Jam Kembali</td>
                                <td>:</td>
                                <td class="value-highlight">{{ substr($transportRequest->jam_sampai, 0, 5) }} WIB</td>
                            </tr>
                        </table>
                    </div>
                    <div class="column">
                        <table>
                            <tr>
                                <td>Alamat Asal</td>
                                <td>:</td>
                                <td>{{ $transportRequest->alamat_asal ?? 'rs azra' }}</td>
                            </tr>
                            <tr>
                                <td>Alamat Tujuan</td>
                                <td>:</td>
                                <td class="value-highlight">{{ $transportRequest->alamat_tujuan ?? '-' }}</td>
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
                <table style="margin-top: 6px;">
                    <tr>
                        <td style="width: 32%;">Keterangan Tambahan</td>
                        <td style="width: 2%;">:</td>
                        <td style="background: #fef3c7; padding: 6px 8px; border-radius: 3px;">{{ $transportRequest->keterangan }}</td>
                    </tr>
                </table>
                @endif
            </div>
        </div>

        <!-- Section 5: Data Kendaraan & Supir -->
        <div class="section">
            <div class="section-header">{{ $transportRequest->jenis === 'ambulance' ? 'V' : 'IV' }}. DATA KENDARAAN & PENGEMUDI</div>
            <div class="section-content">
                <div class="info-box">
                    <div class="two-columns">
                        <div class="column">
                            <table>
                                <tr>
                                    <td>Unit Kendaraan</td>
                                    <td>:</td>
                                    <td class="value-highlight">{{ $transportRequest->unit_mobil ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Nomor Polisi</td>
                                    <td>:</td>
                                    <td class="value-highlight">{{ $transportRequest->plat_nomor ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Pengemudi</td>
                                    <td>:</td>
                                    <td class="value-highlight">{{ $transportRequest->driver->name ?? '-' }}</td>
                                </tr>
                                @if($transportRequest->driver && $transportRequest->driver->phone)
                                <tr>
                                    <td>Kontak Pengemudi</td>
                                    <td>:</td>
                                    <td>{{ $transportRequest->driver->phone }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="column">
                            <table>
                                <tr>
                                    <td>KM Awal</td>
                                    <td>:</td>
                                    <td class="value-highlight">{{ $transportRequest->km_awal ?? '-' }} km</td>
                                </tr>
                                <tr>
                                    <td>KM Akhir</td>
                                    <td>:</td>
                                    <td class="value-highlight">{{ $transportRequest->km_akhir ?? '-' }} km</td>
                                </tr>
                                @if($transportRequest->km_awal && $transportRequest->km_akhir)
                                <tr>
                                    <td>Total Jarak Tempuh</td>
                                    <td>:</td>
                                    <td style="background: #d1fae5; padding: 4px 8px; border-radius: 3px; font-weight: bold; color: #065f46;">
                                        {{ $transportRequest->km_akhir - $transportRequest->km_awal }} km
                                    </td>
                                </tr>
                                @endif
                                @if($transportRequest->jam_kedatangan)
                                <tr>
                                    <td>Jam Kedatangan</td>
                                    <td>:</td>
                                    <td class="value-highlight">{{ $transportRequest->jam_kedatangan }} WIB</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <p class="title">Yang Mengajukan</p>
            <div class="signature-space">
                @if(isset($transportRequest->signature_pemohon) && $transportRequest->signature_pemohon)
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode(route('signature.verify', $transportRequest->signature_pemohon)) }}" 
                         alt="QR Signature">
                @endif
            </div>
            <p class="name">{{ $transportRequest->user->full_name ?? $transportRequest->pemohon_nama }}</p>
            <p class="detail">{{ $transportRequest->user->unit_kerja ?? $transportRequest->pemohon_unit }}</p>
            @if(isset($transportRequest->signature_pemohon_at) && $transportRequest->signature_pemohon_at)
                <p class="detail" style="font-size: 6.5pt; margin-top: 2px;">
                    {{ is_string($transportRequest->signature_pemohon_at) ? $transportRequest->signature_pemohon_at : $transportRequest->signature_pemohon_at->format('d/m/Y H:i') }}
                </p>
            @endif
        </div>
        
        <div class="signature-box">
            <p class="title">Pengelola Transportasi</p>
            <p class="subtitle">Menyetujui</p>
            <div class="signature-space">
                @if(isset($transportRequest->signature_pengelola_1) && $transportRequest->signature_pengelola_1)
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode(route('signature.verify', $transportRequest->signature_pengelola_1)) }}" 
                         alt="QR Signature">
                @endif
            </div>
            <p class="name">{{ $transportRequest->signature_pengelola_1_name ?? '(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)' }}</p>
            @if(isset($transportRequest->signature_pengelola_1_at) && $transportRequest->signature_pengelola_1_at)
                <p class="detail" style="font-size: 6.5pt; margin-top: 2px;">
                    {{ is_string($transportRequest->signature_pengelola_1_at) ? $transportRequest->signature_pengelola_1_at : $transportRequest->signature_pengelola_1_at->format('d/m/Y H:i') }}
                </p>
            @endif
        </div>

        <div class="signature-box">
            <p class="title">Pengemudi</p>
            <div class="signature-space">
                @if(isset($transportRequest->signature_driver) && $transportRequest->signature_driver)
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode(route('signature.verify', $transportRequest->signature_driver)) }}" 
                         alt="QR Signature">
                @endif
            </div>
            <p class="name">{{ $transportRequest->driver->name ?? '(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)' }}</p>
            @if($transportRequest->driver && $transportRequest->driver->phone)
                <p class="detail">{{ $transportRequest->driver->phone }}</p>
            @endif
            @if(isset($transportRequest->signature_driver_at) && $transportRequest->signature_driver_at)
                <p class="detail" style="font-size: 6.5pt; margin-top: 2px;">
                    {{ is_string($transportRequest->signature_driver_at) ? $transportRequest->signature_driver_at : $transportRequest->signature_driver_at->format('d/m/Y H:i') }}
                </p>
            @endif
        </div>
        
        <div class="signature-box">
            <p class="title">Pengelola Transportasi</p>
            <p class="subtitle">Mengetahui</p>
            <div class="signature-space">
                @if(isset($transportRequest->signature_pengelola_2) && $transportRequest->signature_pengelola_2)
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode(route('signature.verify', $transportRequest->signature_pengelola_2)) }}" 
                         alt="QR Signature">
                @endif
            </div>
            <p class="name">{{ $transportRequest->signature_pengelola_2_name ?? '(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)' }}</p>
            @if(isset($transportRequest->signature_pengelola_2_at) && $transportRequest->signature_pengelola_2_at)
                <p class="detail" style="font-size: 6.5pt; margin-top: 2px;">
                    {{ is_string($transportRequest->signature_pengelola_2_at) ? $transportRequest->signature_pengelola_2_at : $transportRequest->signature_pengelola_2_at->format('d/m/Y H:i') }}
                </p>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <div class="document-footer">
        <p>Dokumen ini dicetak secara otomatis pada {{ now()->format('d F Y, H:i') }} WIB</p>
        <p>rs azra - Sistem Pengajuan Transportasi</p>
    </div>
</body>
</html>
