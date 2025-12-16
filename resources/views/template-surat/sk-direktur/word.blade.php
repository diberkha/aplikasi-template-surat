<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $data['judul_surat'] ?? 'Surat Keputusan' }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Times New Roman', Times, serif; color: #000; line-height: 1.15; font-size: 12pt; background: white; margin: 0; padding: 20mm 25mm 20mm 25mm; }
        @page { size: 215.9mm 330.2mm; margin: 0; }
        .title-section { text-align: center; font-weight: normal; font-size: 11.5pt; margin: 20px 0 8px 0; white-space: nowrap; }
        .meta-info { margin: 8px 0; text-align: center; line-height: 1.4; }
        .meta-info p { margin: 2px 0; font-size: 12pt; line-height: 1.2; }
        .meta-info-tentang { margin: 10px 0 15px 0; text-align: center; }
        .meta-info-tentang p { margin: 2px 0; font-size: 12pt; line-height: 1.3; }
        .content { margin: 22px 0; text-align: justify; line-height: 1.5; }
        .deciding-title { text-align: center; font-weight: normal; font-size: 12.5pt; margin: 18px 0 10px 0; text-transform: uppercase; line-height: 1.5; }
        .deciding-content { margin-top: 8px; line-height: 1.5; }
        .deciding-item { margin-bottom: 12px; line-height: 1.5; }
        .deciding-text { text-align: justify; line-height: 1.5; }
    </style>
</head>
<body>
    @include('template-surat.sk-direktur.partials.header')

    <div class="title-section">KEPUTUSAN DIREKTUR RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG</div>

    <div class="meta-info">
        <p>NOMOR : {{ $data['nomor_surat'] ?? '-' }}</p>
    </div>

    <div class="meta-info-tentang">
        <p>TENTANG</p>
        @php
            $tentangText = strtoupper($data['tentang'] ?? '-');
            $tentangLines = wordwrap($tentangText, 60, "\n", false);
            $tentangArray = explode("\n", $tentangLines);
        @endphp
        @foreach($tentangArray as $line)
            <p>{{ trim($line) }}</p>
        @endforeach
    </div>

    <div style="text-align: center; margin: 12px 0 18px 0;">
        <p>DIREKTUR RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG</p>
    </div>

    <div class="content">
        @include('template-surat.sk-direktur.partials.sections')
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
                $order = [ 'Menetapkan' => 0,'KESATU' => 1,'KEDUA' => 2,'KETIGA' => 3,'KEEMPAT' => 4,'KELIMA' => 5,'KEENAM' => 6,'KETUJUH' => 7,'KEDELAPAN' => 8,'KESEMBILAN' => 9,'KESEPULUH' => 10 ];
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

    @include('template-surat.sk-direktur.partials.footer')
</body>
</html>
