<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: 215.9mm 330.2mm;
            margin-top: 10mm;
            margin-bottom: 20mm;
            margin-left: 30mm;
            margin-right: 25mm;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            margin: 0;
            padding: 0;
        }

        thead {
            display: table-header-group;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #000;
            -webkit-box-decoration-break: clone;
            box-decoration-break: clone;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
            -webkit-box-decoration-break: clone;
            box-decoration-break: clone;
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


        table {
            page-break-inside: auto;
        }

        tr {
            page-break-inside: auto;
        }

        thead tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        td,
        th,
        tbody,
        thead,
        tfoot {
            page-break-inside: auto;
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
    </style>
</head>

<body>
    <table>
        <thead>
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
                        <img src="{{ $logoData }}" alt="Logo Sragen"
                            style="width: 0.81in; height: 0.99in; margin-bottom: 6px;">
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
                                {{ $data['nomor_dokumen'] ?? '' }}
                            </td>
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
                                {{ $data['nomor_revisi'] ?? '' }}
                            </td>
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
                                {{ $data['halaman'] ?? '1/1' }}
                            </td>
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
                            $tanggal = \Carbon\Carbon::parse($data['tanggal_terbit'] ?? now(), config('app.timezone'));
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
                    <div
                        style="text-decoration: underline; margin-bottom: 2px; white-space: nowrap; font-size: {{ $fontSize }}; overflow: hidden; text-overflow: clip;">
                        {{ $direkturNama }}
                    </div>
                    <div>NIP. {{ $direkturNip }}</div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="left-align" style="width:1.87in; padding: 6px; font-size: 12pt;">Pengertian</td>
                <td class="justify" style="padding: 6px; font-size: 12pt;" colspan="3">{{ $data['pengertian'] ?? '' }}
                </td>
            </tr>
            @php
                $tujuan = $data['tujuan'] ?? [];
                if (is_string($tujuan)) {
                    $tujuan = array_filter(explode("\n", $tujuan));
                }
                $tujuan = array_map(function ($item) {
                    return preg_replace('/^\d+\.\s*/', '', trim($item));
                }, array_values($tujuan));
            @endphp
            @if(count($tujuan) > 0)
                <tr>
                    <td class="left-align"
                        style="width:1.87in; padding: 6px; font-size: 11pt; border-bottom: 1px solid #000; line-height: 1.15;">
                        Tujuan</td>
                    <td class="justify"
                        style="padding: 6px; font-size: 11pt; border-bottom: 1px solid #000; line-height: 1.15;"
                        colspan="3">
                        @if(count($tujuan) > 1)
                            @foreach($tujuan as $index => $item)
                                <table style="width: 100%; border: none; margin-bottom: 2px;">
                                    <tr style="border: none;">
                                        <td
                                            style="width: 25px; border: none; padding: 0 5px 0 0; vertical-align: top; font-size: 11pt;">
                                            {{ $index + 1 }}.
                                        </td>
                                        <td
                                            style="border: none; padding: 0; vertical-align: top; font-size: 11pt; text-align: justify;">
                                            {{ $item }}
                                        </td>
                                    </tr>
                                </table>
                            @endforeach
                        @else
                            {{ $tujuan[0] }}
                        @endif
                    </td>
                </tr>
            @endif

            @php
                $kebijakanItems = is_array($data['kebijakan'] ?? null) ? $data['kebijakan'] : [];
            @endphp
            @if(count($kebijakanItems) > 0)
                <tr>
                    <td class="left-align"
                        style="width:1.87in; padding: 6px; font-size: 11pt; border-bottom: 1px solid #000; line-height: 1.15;">
                        Kebijakan</td>
                    <td class="justify"
                        style="padding: 6px; font-size: 11pt; border-bottom: 1px solid #000; line-height: 1.15;"
                        colspan="3">
                        @foreach($kebijakanItems as $index => $item)
                            <table style="width: 100%; border: none; margin-bottom: 2px;">
                                <tr style="border: none;">
                                    <td
                                        style="width: 25px; border: none; padding: 0 5px 0 0; vertical-align: top; font-size: 11pt;">
                                        {{ $index + 1 }}.
                                    </td>
                                    <td
                                        style="border: none; padding: 0; vertical-align: top; font-size: 11pt; text-align: justify;">
                                        {{ $item }}
                                    </td>
                                </tr>
                            </table>
                        @endforeach
                    </td>
                </tr>
            @endif

            @php
                $prosedur = array_values($data['prosedur'] ?? []);
                $prosedur = array_map(function ($item) {
                    return preg_replace('/^\d+\.\s*/', '', trim($item));
                }, $prosedur);
            @endphp
            @if(count($prosedur) > 0)
                <tr>
                    <td class="left-align"
                        style="width:1.87in; padding: 6px; font-size: 11pt; border-bottom: 1px solid #000; line-height: 1.15;">
                        Prosedur</td>
                    <td class="justify"
                        style="padding: 6px; font-size: 11pt; border-bottom: 1px solid #000; line-height: 1.15;"
                        colspan="3">
                        @foreach($prosedur as $index => $item)
                            <table style="width: 100%; border: none; margin-bottom: 2px;">
                                <tr style="border: none;">
                                    <td
                                        style="width: 25px; border: none; padding: 0 5px 0 0; vertical-align: top; font-size: 11pt;">
                                        {{ $index + 1 }}.
                                    </td>
                                    <td
                                        style="border: none; padding: 0; vertical-align: top; font-size: 11pt; text-align: justify;">
                                        {!! $item !!}
                                    </td>
                                </tr>
                            </table>
                        @endforeach
                    </td>
                </tr>
            @endif

            <tr>
                <td class="left-align" style="width:1.87in; padding: 6px; font-size: 12pt;">Unit Terkait</td>
                <td class="justify" style="padding: 6px; font-size: 12pt;" colspan="3">
                    @php
                        $unitItems = is_array($data['unit_terkait'] ?? null) ? $data['unit_terkait'] : [];
                        $unitText = implode(', ', $unitItems);
                    @endphp
                    {{ $unitText }}
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>