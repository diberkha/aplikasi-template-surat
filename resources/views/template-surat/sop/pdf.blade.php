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
                <div style="text-decoration: underline; margin-bottom: 2px; white-space: nowrap;">Dr. dr. Kinik Darsono,
                    M.Pd.Ked.</div>
                <div>NIP. 19710415 200903 1 001</div>
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
                <ol style="margin:0; padding-left:18px;">
                    @foreach(($data['kebijakan'] ?? []) as $item)
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
            <td class="justify" style="padding: 6px; font-size: 12pt;" colspan="3">{{ $data['unit_terkait'] ?? '' }}
            </td>
        </tr>
    </table>
</body>

</html>