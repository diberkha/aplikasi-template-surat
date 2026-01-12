<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KEPUTUSAN DIREKTUR RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            line-height: 1.15;
            font-size: 12pt;
            background: white;
            margin: 0;
            padding: 8.4mm 9.9mm 4.8mm 12.4mm;
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
                padding: 8.4mm 9.9mm 4.8mm 12.4mm;
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
            size: 215.9mm 330.2mm;
            margin: 0;
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
            width: 75px;
            text-align: left;
            padding-right: 8px;
        }

        .header-logo img {
            width: 0.8in;
            height: auto;
            object-fit: contain;
        }

        .header-text {
            text-align: center;
            line-height: 1.3;
        }

        .header-text {
            text-align: center;
            line-height: 1.3;
            font-family: Arial, sans-serif;
        }

        .header-line1 {
            font-size: 12pt;
            margin-bottom: 0;
            letter-spacing: 0.3px;
            font-weight: normal;
        }

        .header-line2 {
            font-size: 16pt;
            margin-bottom: 2px;
            letter-spacing: 0.5px;
            font-weight: bold;
        }

        .header-line3 {
            font-size: 10pt;
            line-height: 1.4;
            margin-top: 2px;
        }

        .header-contact {
            white-space: nowrap;
        }

        .header-border {
            margin-top: 8px;
            border-bottom: 3px solid #000;
            padding-bottom: 2px;
        }

        .header-border-inner {
            border-bottom: 1px solid #000;
        }

        .title-section {
            text-align: center;
            font-weight: normal;
            font-size: 11.5pt;
            margin: 14px 0 10px 0;
            white-space: nowrap;
        }

        .meta-info {
            margin: 12px 0 16px 0;
            text-align: center;
            line-height: 1.5;
        }

        .meta-info p {
            margin: 6px 0;
            font-size: 12pt;
            line-height: 1.3;
        }

        .meta-info-tentang {
            margin: 16px 0 18px 0;
            text-align: center;
        }

        .meta-info-tentang p {
            margin: 6px 0;
            font-size: 12pt;
            line-height: 1.35;
        }

        .content {
            margin: 22px 0;
            text-align: justify;
            line-height: 1.5;
        }

        .section {
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .section table {
            width: 100%;
            border-collapse: collapse;
        }

        .section-label {
            font-size: 12pt;
            width: 100px;
            vertical-align: top;
            padding-right: 8px;
            line-height: 1.5;
            word-wrap: break-word;
        }

        .section-separator {
            width: 18px;
            vertical-align: top;
            text-align: center;
            line-height: 1.5;
        }

        .section-content {
            font-size: 12pt;
            line-height: 1.5;
            text-align: justify;
            vertical-align: top;
            word-wrap: break-word;
        }

        .section-content ol {
            margin: 0 0 0 22px;
            padding-left: 0;
            list-style-position: outside;
        }

        .section-content li {
            margin-bottom: 6px;
            text-align: justify;
            line-height: 1.5;
        }

        .deciding-title {
            text-align: center;
            font-weight: normal;
            font-size: 12.5pt;
            margin: 18px 0 10px 0;
            text-transform: uppercase;
            line-height: 1.5;
        }

        .deciding-content {
            margin-top: 8px;
            line-height: 1.5;
        }

        .deciding-item {
            margin-bottom: 12px;
            line-height: 1.5;
        }

        .deciding-text {
            text-align: justify;
            line-height: 1.5;
        }

        .footer {
            margin-top: 46px;
            line-height: 1.5;
        }

        .footer table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-left {
            width: 55%;
            vertical-align: top;
            text-align: left;
            line-height: 1.5;
        }

        .footer-right {
            width: 45%;
            vertical-align: top;
            text-align: left;
            padding-left: 20mm;
            line-height: 1.5;
        }

        .footer-title {
            font-size: 12pt;
            font-weight: normal;
            white-space: nowrap;
        }

        .signature-wrapper {
            margin: 18px 0 10px 0;
            min-height: 90px;
        }

        .signature-wrapper img {
            max-height: 90px;
            object-fit: contain;
        }

        .signature-name {
            font-weight: normal;
            margin-top: 6px;
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
                            <span class="header-contact">Telp. (0271) 6811839, Laman rsudgemolong.sragenkab.go.id,
                                Pos-el <a href="mailto:rsudgemolong@gmail.com"
                                    style="color: #000; text-decoration: underline;">rsudgemolong@gmail.com</a></span>
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
            <div class="header-border">
                <div class="header-border-inner"></div>
            </div>
        </div>

        <div class="title-section">
            KEPUTUSAN DIREKTUR RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG<br>
            KABUPATEN SRAGEN
        </div>

        <div class="meta-info">
            <p>NOMOR : {{ $data['nomor_surat'] ?? '-' }}</p>
        </div>

        <div class="meta-info-tentang">
            <p>TENTANG</p>
            <br>
            @php
                $tentangText = strtoupper($data['tentang'] ?? '-');
                $tentangLines = wordwrap($tentangText, 60, "\n", false);
                $tentangArray = explode("\n", $tentangLines);
            @endphp
            @foreach($tentangArray as $line)
                <p>{{ trim($line) }}</p>
            @endforeach
        </div>

        <div style="text-align: center; margin: 32px 0 18px 0;">
            <p>DIREKTUR RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG</p>
        </div>

        <div class="content">
            <div class="section">
                <table>
                    <tr>
                        <td class="section-label">Menimbang</td>
                        <td class="section-separator">:</td>
                        <td class="section-content">
                            @php
                                $menimbang = $data['menimbang'] ?? [];
                                if (is_string($menimbang)) {
                                    $menimbang = array_filter(explode("\n", $menimbang));
                                }
                                $menimbang = array_map(function ($line) {
                                    return preg_replace('/^[a-z]\.\s*/', '', trim($line)); }, $menimbang);
                                $menimbang = array_values(array_filter($menimbang));
                            @endphp
                            @if(count($menimbang) <= 1)
                                {{ $menimbang[0] ?? '' }}
                            @else
                                <ol type="a">
                                    @foreach($menimbang as $line)
                                        <li>{{ trim($line) }}</li>
                                    @endforeach
                                </ol>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="section">
                <table>
                    <tr>
                        <td class="section-label">Mengingat</td>
                        <td class="section-separator">:</td>
                        <td class="section-content">
                            @php
                                $rawMengingat = trim($data['mengingat'] ?? '');
                                $mengingatLines = [];

                                $lines = preg_split('/\r\n|\r|\n/', $rawMengingat);
                                $lines = array_filter($lines, function ($line) {
                                    return trim($line) !== ''; });

                                $allAreIds = true;
                                $ids = [];

                                foreach ($lines as $line) {
                                    $cleaned = preg_replace('/^\d+\.\s*/', '', trim($line));

                                    if (preg_match('/^\d+$/', $cleaned)) {
                                        $ids[] = (int) $cleaned;
                                    } else {
                                        $allAreIds = false;
                                        break;
                                    }
                                }

                                if ($allAreIds && count($ids) > 0) {
                                    $regulasis = \App\Models\Regulasi::whereIn('id_regulasi', $ids)
                                        ->orderByRaw('FIELD(id_regulasi, ' . implode(',', $ids) . ')')
                                        ->get();

                                    if ($regulasis->count() > 0) {
                                        $mengingatLines = $regulasis->pluck('isi_regulasi')->toArray();
                                    } else {
                                        $mengingatLines = ['Data regulasi tidak ditemukan'];
                                    }
                                } else {
                                    foreach ($lines as $line) {
                                        $cleaned = preg_replace('/^\d+\.\s*/', '', trim($line));
                                        if ($cleaned !== '') {
                                            $mengingatLines[] = $cleaned;
                                        }
                                    }
                                }
                            @endphp
                            <ol type="1">
                                @foreach($mengingatLines as $line)
                                    <li>{{ trim($line) }}</li>
                                @endforeach
                            </ol>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="deciding-title">MEMUTUSKAN</div>

        <div class="deciding-content">
            @php
                $memutuskanText = $data['memutuskan'] ?? '';
                $lines = explode("\n", $memutuskanText);
                $currentLabel = '';
                $currentText = '';
                $items = [];
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (empty($line))
                        continue;
                    if (preg_match('/^(MENETAPKAN|KESATU|KEDUA|KETIGA|KEEMPAT|KELIMA|KEENAM|KETUJUH|KEDELAPAN|KESEMBILAN|KESEPULUH)$/i', $line)) {
                        if ($currentLabel) {
                            $items[] = ['label' => $currentLabel, 'text' => trim($currentText)];
                        }
                        $currentLabel = $line;
                        $currentText = '';
                    } else {
                        $currentText .= ' ' . $line;
                    }
                }
                if ($currentLabel) {
                    $items[] = ['label' => $currentLabel, 'text' => trim($currentText)];
                }

                usort($items, function ($a, $b) {
                    $order = [
                        'Menetapkan' => 0,
                        'KESATU' => 1,
                        'KEDUA' => 2,
                        'KETIGA' => 3,
                        'KEEMPAT' => 4,
                        'KELIMA' => 5,
                        'KEENAM' => 6,
                        'KETUJUH' => 7,
                        'KEDELAPAN' => 8,
                        'KESEMBILAN' => 9,
                        'KESEPULUH' => 10,
                    ];
                    return ($order[strtoupper($a['label'])] ?? 99) <=> ($order[strtoupper($b['label'])] ?? 99);
                });
            @endphp

            <div class="deciding-item">
                <table>
                    <tr>
                        <td class="section-label">Menetapkan</td>
                        <td class="section-separator">:</td>
                        <td class="deciding-text">{{ trim($data['menetapkan'] ?? '') }}</td>
                    </tr>
                </table>
            </div>

            @foreach($items as $item)
                <div class="deciding-item">
                    <table>
                        <tr>
                            <td class="section-label">{{ strtoupper($item['label']) }}</td>
                            <td class="section-separator">:</td>
                            <td class="deciding-text">{{ $item['text'] }}</td>
                        </tr>
                    </table>
                </div>
            @endforeach
        </div>

        <div class="footer">
            <table>
                <tr>
                    <td class="footer-left">
                    </td>
                    <td class="footer-right">
                        <p style="text-align: left;">Ditetapkan di {{ $data['tempat_surat'] ?? 'Gemolong' }}</p>
                        <p style="text-align: left;">pada tanggal
                            {{ \Carbon\Carbon::parse($data['tanggal_dibuat'] ?? now())->locale('id')->translatedFormat('j F Y') }}
                        </p>
                        <div style="margin-left: -15mm;">
                            <p class="footer-title" style="margin-top: 10px; text-align: center;">DIREKTUR RSUD dr.
                                SOERATNO GEMOLONG</p>
                            <p class="footer-title" style="text-align: center;">KABUPATEN SRAGEN</p>

                            <div class="signature-wrapper">
                                @if(!empty($data['ttd_image']))
                                    <img src="{{ public_path($data['ttd_image']) }}" alt="Tanda tangan">
                                @else
                                    <div style="height: 90px"></div>
                                @endif
                            </div>
                            @php
                                $pejabatNama = trim($data['pejabat_nama'] ?? '') ?: 'KINIK DARSONO';
                            @endphp

                            <p class="signature-name" style="text-align: center;">{{ $pejabatNama }}</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>