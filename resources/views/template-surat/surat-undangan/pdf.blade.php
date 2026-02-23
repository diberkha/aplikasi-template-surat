<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Undangan</title>
    <style>
        @font-face {
            font-family: 'Times New Roman';
            src: local('Times New Roman');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Times New Roman';
            src: local('Times New Roman Bold');
            font-weight: bold;
            font-style: normal;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            line-height: 1.5;
            font-size: 12pt;
            background: white;
            margin: 0;
            padding: 0;
        }

        .page {
            width: 100%;
            padding: 0;
            margin: 0;
            background: white;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .page {
                box-shadow: none;
                margin: 0;
            }

            .header {
                display: block;
            }
        }

        @page {
            size: 210mm 330.2mm;
            margin-top: 10mm;
            margin-bottom: 10mm;
            margin-left: 15mm;
            margin-right: 15mm;
        }

        .header {
            text-align: center;
            margin-bottom: 8px;
        }

        .header table {
            width: 100%;
            border-collapse: collapse;
        }

        .header td {
            vertical-align: middle;
            padding: 0;
        }

        .header-logo {
            width: 15%;
            text-align: center;
            padding: 0 4px;
            vertical-align: middle;
        }

        .header-logo img {
            width: 0.7in;
            height: auto;
            object-fit: contain;
        }

        .header-text {
            width: 70%;
            text-align: center;
            line-height: 1.0;
            font-family: Arial, Helvetica, sans-serif;
            padding: 0 8px;
        }

        .header-line1 {
            font-size: 13pt;
            margin-bottom: 0;
            letter-spacing: 0.3px;
            font-weight: normal;
        }

        .header-line2 {
            font-size: 17pt;
            margin-bottom: 16px;
            letter-spacing: 0.5px;
            font-weight: bold;
        }

        .header-line3 {
            font-size: 9pt;
            line-height: 1.0;
            margin-top: 2px;
        }

        .header-contact {
            white-space: nowrap;
        }

        .header-link {
            color: #0000FF;
            text-decoration: none;
        }

        .header-border {
            margin-top: 8px;
            border-bottom: 1.5pt solid #000;
            padding-bottom: 0;
        }

        .tanggal-surat {
            text-align: right;
            margin: 20px 0;
            font-size: 12pt;
            font-family: 'Times New Roman', Times, serif;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-family: 'Times New Roman', Times, serif;
        }

        .info-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .info-label {
            width: 100px;
        }

        .info-separator {
            width: 20px;
        }

        .kepada {
            margin: 20px 0;
            line-height: 1.8;
            font-family: 'Times New Roman', Times, serif;
        }

        .content {
            margin: 20px 0;
            text-align: justify;
            line-height: 1.8;
            font-family: 'Times New Roman', Times, serif;
        }

        .acara-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-family: 'Times New Roman', Times, serif;
        }

        .acara-table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .acara-label {
            width: 120px;
        }

        .acara-separator {
            width: 20px;
        }

        .penutup {
            margin: 20px 0;
            text-align: justify;
            line-height: 1.8;
            font-family: 'Times New Roman', Times, serif;
        }

        .signature-section {
            margin-top: 40px;
            font-family: 'Times New Roman', Times, serif;
        }

        .signature-section table {
            width: 100%;
            border-collapse: collapse;
        }

        .signature-left {
            width: 50%;
        }

        .signature-right {
            width: 50%;
            text-align: center;
        }

        .signature-title {
            font-size: 12pt;
            margin-bottom: 10px;
            font-family: 'Times New Roman', Times, serif;
        }

        .signature-space {
            height: 60px;
        }

        .signature-name {
            margin-top: 5px;
        }

        .signature-nip {
            margin-top: 2px;
        }

        table,
        tr,
        td,
        th,
        tbody,
        thead,
        tfoot {
            page-break-inside: auto !important;
        }

        .justify,
        .left-align,
        ol,
        li,
        div {
            page-break-inside: auto !important;
            orphans: 1 !important;
            widows: 1 !important;
        }

        table {
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="header">
            <table>
                <tr>
                    <td class="header-logo">
                        @php
                            $logoLeftPath = public_path('img/logo-sragen-kop.jpg');
                            $logoLeftData = '';
                            if (file_exists($logoLeftPath)) {
                                $logoLeftData = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoLeftPath));
                            }
                        @endphp
                        @if($logoLeftData)
                            <img src="{{ $logoLeftData }}" alt="Logo Sragen">
                        @endif
                    </td>
                    <td class="header-text">
                        <div class="header-line1">PEMERINTAH KABUPATEN SRAGEN</div>
                        <div class="header-line2">RSUD dr. SOERATNO GEMOLONG</div>
                        <div class="header-line3">
                            Jalan R. Ngt. Tjitrosantjoko 10, Gemolong, Sragen, Jawa Tengah 57274<br>
                            <span class="header-contact">Telepon (0271) 6811839, Laman <a href="https://rsudgemolong.sragenkab.go.id" class="header-link">https://rsudgemolong.sragenkab.go.id</a>, Pos-el rsudgemolong@gmail.com</span>
                        </div>
                    </td>
                    <td class="header-logo" style="text-align: right;">
                        @php
                            $logoRightPath = public_path('img/logo-rs-kop.png');
                            $logoRightData = '';
                            if (file_exists($logoRightPath)) {
                                $logoRightData = 'data:image/png;base64,' . base64_encode(file_get_contents($logoRightPath));
                            }
                        @endphp
                        @if($logoRightData)
                            <img src="{{ $logoRightData }}" alt="Logo RSUD">
                        @endif
                    </td>
                </tr>
            </table>
            <div class="header-border"></div>
        </div>

        <div style="line-height: 1.5;"></div>

        <div class="tanggal-surat">
            {{ $data['tempat_dibuat'] ?? 'Gemolong' }}, 
            {{ \Carbon\Carbon::createFromFormat('Y-m-d', $data['tanggal_dibuat'] ?? now()->format('Y-m-d'))->locale('id')->translatedFormat('j F Y') }}
        </div>

        <table class="info-table">
            <tr>
                <td class="info-label">Nomor</td>
                <td class="info-separator">:</td>
                <td>{{ $data['nomor_surat'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="info-label">Lampiran</td>
                <td class="info-separator">:</td>
                <td>{{ $data['lampiran'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="info-label">Hal</td>
                <td class="info-separator">:</td>
                <td>{{ $data['hal'] ?? 'Undangan' }}</td>
            </tr>
        </table>

        <div class="kepada">
            Yth. {{ $data['kepada'] ?? 'Terlampir' }}<br>
            <span style="padding-left: 30px;">di -</span><br>
            <span style="padding-left: 60px;">T E M P A T</span>
        </div>

        <div class="content">
            Dengan hormat,<br>
            Sehubungan dengan pelaksanaan kegiatan {{ $data['nama_kegiatan'] ?? '..........................................................' }}, kami mengundang Bapak/Ibu untuk menghadiri kegiatan dimaksud yang akan dilaksanakan pada:
        </div>

        <table class="acara-table">
            <tr>
                <td class="acara-label">Hari/ Tanggal</td>
                <td class="acara-separator">:</td>
                <td>
                    {{ $data['hari_acara'] ?? 'Jumat' }}, 
                    {{ \Carbon\Carbon::createFromFormat('Y-m-d', $data['tanggal_acara'] ?? now()->format('Y-m-d'))->locale('id')->translatedFormat('j F Y') }}
                </td>
            </tr>
            <tr>
                <td class="acara-label">Jam</td>
                <td class="acara-separator">:</td>
                <td>
                    @php
                        $jamMulai = $data['jam_mulai'] ?? '';
                        $jamSelesai = $data['jam_selesai'] ?? '';
                        $keteranganWaktu = $data['keterangan_waktu'] ?? '';
                        $jamText = $jamMulai;

                        if ($jamSelesai !== '') {
                            $jamText = trim($jamText . ' s.d. ' . $jamSelesai);
                        }

                        if ($keteranganWaktu !== '') {
                            $jamText = trim($jamText . ' ' . $keteranganWaktu);
                        }
                    @endphp
                    {{ $jamText !== '' ? $jamText : '-' }}
                </td>
            </tr>
            <tr>
                <td class="acara-label">Tempat</td>
                <td class="acara-separator">:</td>
                <td>{{ $data['tempat_acara'] ?? '-' }}</td>
            </tr>
            @if(!empty($data['keperluan']))
            <tr>
                <td class="acara-label">Keperluan</td>
                <td class="acara-separator">:</td>
                <td>{{ $data['keperluan'] }}</td>
            </tr>
            @endif
        </table>

        <div class="penutup">
            Demikian undangan ini kami sampaikan. Atas perhatian dan kehadiran Bapak/Ibu, kami ucapkan terima kasih.
        </div>

        <div class="signature-section">
            <table>
                <tr>
                    <td class="signature-left"></td>
                    <td class="signature-right">
                        <div class="signature-title">{{ $data['jabatan_tertanda'] ?? 'Direktur RSUD dr. Soeratno Gemolong' }}</div>
                        <div class="signature-space"></div>
                        <div class="signature-name">{{ $data['nama_tertanda'] ?? 'Dr. dr. Kinik Darsono, M.Pd.Ked.' }}</div>
                        <div class="signature-nip">NIP. {{ $data['nip_tertanda'] ?? '19710415 200903 1 001' }}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
