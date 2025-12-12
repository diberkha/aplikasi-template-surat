<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $data['judul_surat'] ?? 'Surat Keputusan' }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body { font-family: 'Times New Roman', Times, serif; color: #000; line-height: 1.15; font-size: 12pt; background: #e5e7eb; }

        .page { width: 210mm; min-height: 297mm; padding: 10mm 15mm 10mm 10mm; margin: 20px auto; background: white; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        
        @media print {
            body { background: white; }
            .page { box-shadow: none; margin: 0 auto; }
            .header { display: block; }
        }
        
        @page { size: A4; margin: 10mm 15mm 10mm 10mm; }

        .header { text-align: center; margin-bottom: 16px; }
        .header table { width: 100%; border-collapse: collapse; }
        .header td { vertical-align: top; padding: 0; }
        .header-logo { width: 70px; text-align: center; }
        .header-logo img { width: 62px; height: 77px; object-fit: contain; }
        .header-text { text-align: center; line-height: 1.4; }
        .header-line1 { font-size: 15pt; margin-bottom: 2px; letter-spacing: 0.2px; }
        .header-line2 { font-size: 15pt; font-weight: normal; margin-bottom: 3px; letter-spacing: 0.2px; }
        .header-line3 { font-size: 10.5pt; line-height: 1.35; }
        .header-border { margin-top: 6px; }
        .header-border hr:first-child { border: none; border-top: 3px solid #000; margin: 0; }
        .header-border hr:last-child { border: none; border-top: 1px solid #000; margin-top: 2px; }

        .title-section { text-align: center; font-weight: normal; font-size: 12.5pt; margin: 24px 0 12px 0; }
        .meta-info { margin: 15px 0; text-align: center; line-height: 1.5; }
        .meta-info p { margin: 3px 0; font-size: 12.5pt; line-height: 1.0; }

        .content { margin: 22px 0; text-align: justify; line-height: 1.5; }
        .section { margin-bottom: 16px; line-height: 1.5; }
        .section table { width: 100%; border-collapse: collapse; }
        .section-label { font-size: 12pt; width: 100px; vertical-align: top; padding-right: 8px; line-height: 1.5; word-wrap: break-word; }
        .section-separator { width: 18px; vertical-align: top; text-align: center; line-height: 1.5; }
        .section-content { font-size: 12pt; line-height: 1.5; text-align: justify; vertical-align: top; word-wrap: break-word; }
        .section-content ol { margin: 0 0 0 22px; padding-left: 0; list-style-position: outside; }
        .section-content li { margin-bottom: 6px; text-align: justify; line-height: 1.5; }

        .deciding-title { text-align: center; font-weight: normal; font-size: 12.5pt; margin: 18px 0 10px 0; text-transform: uppercase; line-height: 1.5; }
        .deciding-content { margin-top: 8px; line-height: 1.5; }
        .deciding-item { margin-bottom: 12px; line-height: 1.5; }
        .deciding-text { text-align: justify; line-height: 1.5; }

        .footer { margin-top: 46px; line-height: 1.5; }
        .footer table { width: 100%; border-collapse: collapse; }
        .footer-left { width: 55%; vertical-align: top; text-align: left; line-height: 1.5; }
        .footer-right { width: 45%; vertical-align: top; text-align: center; padding-left: 10mm; line-height: 1.5; }
        .footer-title { font-size: 12pt; font-weight: normal; }
        .signature-wrapper { margin: 18px 0 10px 0; min-height: 90px; }
        .signature-wrapper img { max-height: 90px; object-fit: contain; }
        .signature-name { font-weight: normal; text-decoration: underline; margin-top: 6px; }
        .signature-nip { font-size: 12.5pt; margin-top: 2px; }
    </style>
</head>

<body>
    <div class="page">
        <div class="header">
            <table>
                <tr>
                    <td class="header-logo">
                        <img src="{{ public_path('img/logo-sragen.png') }}" alt="Logo Sragen">
                    </td>
                    <td class="header-text">
                        <div class="header-line1">PEMERINTAH KABUPATEN SRAGEN</div>
                        <div class="header-line2">RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG</div>
                        <div class="header-line3">
                            Jl. R.Ngt. Tjitrosantjoko No. 10 Gemolong Telp. (0271) 6811839 Fax : (0271) 6811439<br>
                            E-mail : rsudgemolong@gmail.com Website : https://rsudgemolong.sragenkab.go.id<br>
                            SRAGEN - Kode Pos 57274
                        </div>
                    </td>
                </tr>
            </table>
            <div class="header-border">
                <hr>
                <hr>
            </div>
        </div>

        <div class="title-section">
            KEPUTUSAN DIREKTUR RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG
        </div>

        <div class="meta-info">
            <p>NOMOR : {{ $data['nomor_surat'] ?? '-' }}</p>
        </div>

        <div class="meta-info">
            <p>TENTANG</p>
            <p style="margin-top: 5px;">{{ strtoupper($data['tentang'] ?? '-') }}</p>
        </div>

        <div style="text-align: center; margin: 15px 0;">
            <p>DIREKTUR RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG,</p>
        </div>

        <div class="content">
            <div class="section">
                <table>
                    <tr>
                        <td class="section-label">Menimbang</td>
                        <td class="section-separator">:</td>
                        <td class="section-content">
                            @php
                                $menimbangLines = preg_split('/\r\n|\r|\n/', trim($data['menimbang'] ?? ''));
                                $menimbangLines = array_filter($menimbangLines, fn($line) => trim($line) !== '');
                            @endphp
                            <ol type="a">
                                @foreach($menimbangLines as $line)
                                    <li>{{ trim($line) }}</li>
                                @endforeach
                            </ol>
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
                                $normalized = str_replace(' ', '', $rawMengingat);
                                $mengingatLines = [];
                                if($normalized !== '' && preg_match('/^\d+(,\d+)*$/', $normalized)) {
                                    $ids = array_filter(array_map('trim', explode(',', $normalized)));
                                    try {
                                        $mtexts = \App\Models\Regulasi::whereIn('id_regulasi', $ids)->pluck('isi_regulasi')->toArray();
                                        $mengingatLines = $mtexts;
                                    } catch (\Exception $e) {
                                        $mengingatLines = $ids;
                                    }
                                } else {
                                    $mengingatLines = preg_split('/\r\n|\r|\n/', $rawMengingat);
                                    $mengingatLines = array_filter($mengingatLines, fn($line) => trim($line) !== '');
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
                    if (empty($line)) continue;
                    if (preg_match('/^(MENETAPKAN|KESATU|KEDUA|KETIGA|KEEMPAT|KELIMA|KEENAM|KETUJUH|KEDELAPAN|KESEMBILAN|KESEPULUH)$/i', $line)) {
                        if ($currentLabel) { $items[] = ['label' => $currentLabel, 'text' => trim($currentText)]; }
                        $currentLabel = $line; $currentText = '';
                    } else { $currentText .= ' ' . $line; }
                }
                if ($currentLabel) { $items[] = ['label' => $currentLabel, 'text' => trim($currentText)]; }

                usort($items, function($a, $b) {
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

            @if(!empty($data['menetapkan']))
            <div class="deciding-item">
                <table>
                    <tr>
                        <td class="section-label">Menetapkan</td>
                        <td class="section-separator">:</td>
                        <td class="deciding-text">{{ $data['menetapkan'] }}</td>
                    </tr>
                </table>
            </div>
            @endif

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
                        <p>Ditetapkan di {{ $data['lokasi_surat'] ?? 'Gemolong' }}</p>
                        <p>Pada tanggal {{ \Carbon\Carbon::parse($data['tanggal_dibuat'] ?? now())->locale('id')->translatedFormat('j F Y') }}</p>
                        <p class="footer-title" style="margin-top: 10px;">DIREKTUR RSUD dr. SOERATNO GEMOLONG</p>
                        <p class="footer-title">KABUPATEN SRAGEN</p>

                        <div class="signature-wrapper">
                            @if(!empty($data['ttd_image']))
                                <img src="{{ public_path($data['ttd_image']) }}" alt="Tanda tangan">
                            @else
                                <div style="height: 90px"></div>
                            @endif
                        </div>

                        <p class="signature-name">{{ $data['pejabat_nama'] ?? 'KINIK DARSONO' }}</p>
                        @if(!empty($data['pejabat_nip']))
                            <p class="signature-nip">NIP. {{ $data['pejabat_nip'] }}</p>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
