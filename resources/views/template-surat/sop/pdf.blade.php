<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin-top: 0.39in;
            margin-bottom: 0.79in;
            margin-left: 1.18in;
            margin-right: 0.98in;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .left-align {
            text-align: left;
        }

        .justify {
            text-align: justify;
        }

        .v-middle {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td class="center bold v-middle"
                style="width:1.87in; border-right: 1px solid #000; border-bottom: 1px solid #000; padding: 6px;"
                rowspan="2">
                @php
                    $logoPath = public_path('img/logo-sragen.png');
                    $logoData = '';
                    if (file_exists($logoPath)) {
                        $logoData = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
                    }
                @endphp
                @if($logoData)
                    <img src="{{ $logoData }}" alt="Logo Sragen" style="width: 0.81in; height: 0.99in; margin-bottom: 6px;">
                @endif
                <div>RSUD dr. SOERATNO<br>GEMOLONG</div>
            </td>
            <td class="center bold v-middle" style="border-bottom: 1px solid #000; padding: 6px; font-size: 12pt;"
                colspan="3">
                {{ $data['judul_sop'] ?? '' }}
            </td>
        </tr>
        <tr>
            <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; padding: 0;">
                <table style="width:100%; border-collapse: collapse; border: none;">
                    <tr>
                        <td class="center" style="border: none; padding: 3px 6px; font-size: 12pt;">No. Dokumen</td>
                    </tr>
                    <tr>
                        <td class="center" style="border: none; padding: 3px 6px; font-size: 12pt;">
                            {{ $data['nomor_dokumen'] ?? '' }}</td>
                    </tr>
                </table>
            </td>
            <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; padding: 0;">
                <table style="width:100%; border-collapse: collapse; border: none;">
                    <tr>
                        <td class="center" style="border: none; padding: 3px 6px; font-size: 12pt;">No. Revisi</td>
                    </tr>
                    <tr>
                        <td class="center" style="border: none; padding: 3px 6px; font-size: 12pt;">
                            {{ $data['nomor_revisi'] ?? '' }}</td>
                    </tr>
                </table>
            </td>
            <td style="border-bottom: 1px solid #000; padding: 0;">
                <table style="width:100%; border-collapse: collapse; border: none;">
                    <tr>
                        <td class="center" style="border: none; padding: 3px 6px; font-size: 12pt;">Halaman</td>
                    </tr>
                    <tr>
                        <td class="center" style="border: none; padding: 3px 6px; font-size: 12pt;">
                            {{ $data['halaman'] ?? '1/1' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="center bold v-middle"
                style="width:1.87in; border-right: 1px solid #000; border-bottom: 1px solid #000; padding: 6px; font-size: 12pt;">
                STANDAR<br>PROSEDUR<br>OPERASIONAL
            </td>
            <td class="center v-middle"
                style="width:1.5in; border-right: 1px solid #000; border-bottom: 1px solid #000; padding: 6px; font-size: 12pt;">
                <div>Tanggal Terbit</div>
                <div>
                    @php
                        $bulanIndonesia = [
                            'January' => 'Januari',
                            'February' => 'Februari',
                            'March' => 'Maret',
                            'April' => 'April',
                            'May' => 'Mei',
                            'June' => 'Juni',
                            'July' => 'Juli',
                            'August' => 'Agustus',
                            'September' => 'September',
                            'October' => 'Oktober',
                            'November' => 'November',
                            'December' => 'Desember'
                        ];
                        $tanggal = \Carbon\Carbon::parse($data['tanggal_terbit']);
                        $bulan = $bulanIndonesia[$tanggal->format('F')];
                        $tanggalFormatted = $tanggal->format('j') . ' ' . $bulan . ' ' . $tanggal->format('Y');
                    @endphp
                    {{ $tanggalFormatted }}
                </div>
            </td>
            <td class="center v-middle" colspan="2"
                style="border-bottom: 1px solid #000; padding: 12px 6px; font-size: 12pt;">
                <div style="margin-bottom: 8px;">Ditetapkan,</div>
                <div style="margin-bottom: 8px;">Direktur RSUD dr. Soeratno<br>Gemolong Kabupaten Sragen</div>
                <div style="min-height: 60px; margin-bottom: 8px;"></div>
                @php
                    $direkturNama = $data['direktur_nama'] ?? 'Dr. dr. Kinik Darsono, M.Pd.Ked.';
                    $direkturNip = $data['direktur_nip'] ?? '19710415 200903 1 001';
                    $namaLength = mb_strlen($direkturNama);
                    $fontSize = '12pt';
                    if ($namaLength > 45) {
                        $fontSize = '7pt';
                    } elseif ($namaLength > 38) {
                        $fontSize = '8pt';
                    } elseif ($namaLength > 33) {
                        $fontSize = '9pt';
                    } elseif ($namaLength > 28) {
                        $fontSize = '10pt';
                    } elseif ($namaLength > 25) {
                        $fontSize = '11pt';
                    }
                @endphp
                <div style="text-decoration: underline; margin-bottom: 2px; white-space: nowrap; font-size: {{ $fontSize }}; overflow: hidden; text-overflow: clip;">{{ $direkturNama }}</div>
                <div>NIP. {{ $direkturNip }}</div>
            </td>
        </tr>
        <tr>
            <td class="left-align" style="width:1.87in; padding: 6px; font-size: 12pt;">Pengertian</td>
            <td class="justify" style="padding: 6px; font-size: 12pt;" colspan="3">{{ $data['pengertian'] ?? '' }}</td>
        </tr>
        <tr>
            <td class="left-align" style="width:1.87in; padding: 6px; font-size: 12pt;">Tujuan</td>
            <td class="justify" style="padding: 6px; font-size: 12pt;" colspan="3">
                @php
                    $tujuan = $data['tujuan'] ?? [];
                    if (is_string($tujuan)) {
                        $tujuan = array_filter(explode("\n", $tujuan));
                    }
                @endphp
                @if(count($tujuan) <= 1)
                    {{ $tujuan[0] ?? ($data['tujuan'] ?? '') }}
                @else
                    <ol style="margin:0; padding-left:18px;">
                        @foreach($tujuan as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ol>
                @endif
            </td>
        </tr>
        <tr>
            <td class="left-align" style="width:1.87in; padding: 6px; font-size: 12pt;">Kebijakan</td>
            <td class="justify" style="padding: 6px; font-size: 12pt;" colspan="3">
                @php
                    $rawKebijakan = trim($data['kebijakan'] ?? '');
                    $kebijakanItems = [];
                    
                    $lines = preg_split('/\r\n|\r|\n/', $rawKebijakan);
                    $lines = array_filter($lines, function ($line) { return trim($line) !== ''; });
                    
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
                        $kebijakanItems = $regulasis->count() > 0
                            ? $regulasis->pluck('isi_regulasi')->toArray()
                            : ['Data regulasi tidak ditemukan'];
                    } else {
                        foreach ($lines as $line) {
                            $cleaned = preg_replace('/^\d+\.\s*/', '', trim($line));
                            if ($cleaned !== '') { $kebijakanItems[] = $cleaned; }
                        }
                    }
                @endphp
                <ol style="margin:0; padding-left:18px;">
                    @foreach($kebijakanItems as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ol>
            </td>
        </tr>
        <tr>
            <td class="left-align" style="width:1.87in; padding: 6px; font-size: 12pt;">Prosedur</td>
            <td class="justify" style="padding: 6px; font-size: 12pt;" colspan="3">
                <ol style="margin:0; padding-left:18px;">
                    @foreach(($data['prosedur'] ?? []) as $item)
                        <li>{!! $item !!}</li>
                    @endforeach
                </ol>
            </td>
        </tr>
        <tr>
            <td class="left-align" style="width:1.87in; padding: 6px; font-size: 12pt;">Unit Terkait</td>
            <td class="justify" style="padding: 6px; font-size: 12pt;" colspan="3">
                @php
                    $rawUnit = trim($data['unit_terkait'] ?? '');
                    $unitText = $rawUnit;
                    
                    $lines = preg_split('/\r\n|\r|\n/', $rawUnit);
                    $lines = array_filter($lines, function ($line) { return trim($line) !== ''; });
                    
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
                        $units = \App\Models\Unit::whereIn('id_unit', $ids)
                            ->orderByRaw('FIELD(id_unit, ' . implode(',', $ids) . ')')
                            ->get();
                        $names = $units->pluck('nama_unit')->toArray();
                        $unitText = implode(', ', $names);
                    }
                @endphp
                {{ $unitText }}
            </td>
        </tr>
    </table>
</body>

</html>