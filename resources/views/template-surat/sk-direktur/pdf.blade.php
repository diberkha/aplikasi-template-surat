<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $data['judul_surat'] ?? 'Surat Keputusan' }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body { 
            font-family: 'Times New Roman', Times, serif; 
            color: #000; 
            line-height: 1.15; 
            font-size: 12pt; 
            background: white; 
            margin: 0; 
            padding: 20mm 25mm 20mm 25mm; 
        }

        .page { width: 100%; padding: 0; margin: 0; background: white; }
        
        @media print {
            body { background: white; padding: 20mm 25mm 20mm 25mm; }
            .page { box-shadow: none; margin: 0; }
            .header { display: block; }
        }
        
        @page { size: 215.9mm 330.2mm; margin: 0; }

        .header { text-align: center; margin-bottom: 10px; }
        .header table { width: 100%; border-collapse: collapse; }
        .header td { vertical-align: middle; padding: 0; }
        .header-logo { width: 75px; text-align: left; padding-right: 8px; }
        .header-logo img { width: 65px; height: auto; object-fit: contain; }
        .header-logo-right { width: 75px; text-align: right; padding-left: 8px; }
        .header-logo-right img { width: 65px; height: auto; object-fit: contain; }
        .header-text { text-align: center; line-height: 1.3; }
        .header-line1 { font-size: 14pt; font-weight: bold; margin-bottom: 0; letter-spacing: 0.5px; }
        .header-line2 { font-size: 14pt; font-weight: bold; margin-bottom: 2px; letter-spacing: 0.3px; }
        .header-line3 { font-size: 9pt; line-height: 1.4; margin-top: 2px; }
        .header-border { margin-top: 8px; border-bottom: 3px solid #000; padding-bottom: 2px; }
        .header-border-inner { border-bottom: 1px solid #000; }

        .title-section { text-align: center; font-weight: normal; font-size: 11.5pt; margin: 20px 0 8px 0; white-space: nowrap; }
        .meta-info { margin: 8px 0; text-align: center; line-height: 1.4; }
        .meta-info p { margin: 2px 0; font-size: 12pt; line-height: 1.2; }
        .meta-info-tentang { margin: 10px 0 15px 0; text-align: center; }
        .meta-info-tentang p { margin: 2px 0; font-size: 12pt; line-height: 1.3; }

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
        @include('template-surat.sk-direktur.partials.header')

        <div class="title-section">
            KEPUTUSAN DIREKTUR RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG
        </div>

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

        @include('template-surat.sk-direktur.partials.footer')
    </div>
</body>
</html>
