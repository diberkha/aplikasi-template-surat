<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $data['judul_surat'] ?? 'Surat Keputusan' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Times New Roman', serif;
            color: #000;
            line-height: 1.5;
            font-size: 11pt;
        }

        .page {
            width: 210mm;
            height: 297mm;
            padding: 20mm;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header-top {
            font-size: 10pt;
            margin-bottom: 5px;
        }

        .header-logo {
            display: inline-block;
            width: 40px;
            height: 40px;
            margin-right: 10px;
            vertical-align: middle;
        }

        .header-title {
            display: inline-block;
            text-align: center;
            vertical-align: middle;
        }

        .header-title h1 {
            font-size: 11pt;
            font-weight: bold;
            margin: 0;
            padding: 0;
        }

        .header-title p {
            font-size: 10pt;
            margin: 2px 0 0 0;
            padding: 0;
        }

        .header-contact {
            font-size: 9pt;
            margin-top: 5px;
            line-height: 1.3;
        }

        .title-section {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            margin: 15px 0 5px 0;
            text-decoration: underline;
        }

        .subtitle {
            text-align: center;
            font-size: 11pt;
            margin: 5px 0 15px 0;
        }

        .meta-info {
            margin-bottom: 15px;
        }

        .meta-info p {
            margin: 3px 0;
            font-size: 11pt;
        }

        .content {
            margin: 15px 0;
        }

        .section {
            margin-bottom: 12px;
        }

        .section-title {
            font-weight: bold;
            font-size: 11pt;
            margin: 10px 0 5px 0;
        }

        .section-content {
            font-size: 11pt;
            line-height: 1.6;
            text-align: justify;
            white-space: pre-wrap;
            word-wrap: break-word;
            margin-left: 0;
        }

        .memutuskan-item {
            margin-bottom: 8px;
            text-align: justify;
        }

        .memutuskan-label {
            font-weight: bold;
            display: inline;
        }

        .footer {
            margin-top: 30px;
        }

        .footer-place {
            float: left;
            width: 45%;
        }

        .footer-sign {
            float: right;
            width: 45%;
            text-align: center;
        }

        .footer-content {
            clear: both;
            margin-top: 100px;
        }

        .signature-line {
            margin-top: 50px;
            text-align: center;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>

<body>
    <div class="page">
        <!-- HEADER -->
        <div class="header" style="padding-bottom:0; border-bottom:none;">
            <table style="width:100%; border:none;">
                <tr>
                    <td style="width:70px; vertical-align:top; text-align:center;">
                        <img src="{{ public_path('img/logo-sragen.png') }}" alt="Logo" style="width:62px; height:77px;">
                    </td>
                    <td style="text-align:center;">
                        <div style="font-size:13pt; font-weight:normal;">PEMERINTAH KABUPATEN SRAGEN</div>
                        <div style="font-size:15pt; font-weight:bold;">RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG</div>
                        <div style="font-size:10pt; margin-top:2px;">
                            Jl. R.Ngt. Tjitrosantjoko No. 10 Gemolong Telp. (0271) 6811839 Fax : (0271) 6811439<br>
                            E-mail : rsudgemolong@gmail.com Website : https://rsudgemolong.sragenkab.go.id<br>
                            SRAGEN - Kode Pos 57274
                        </div>
                    </td>
                </tr>
            </table>
            <div style="margin-top:4px;">
                <hr style="border:2px solid #000; margin:0;">
                <hr style="border:1px solid #000; margin-top:2px;">
            </div>
        </div>

        <!-- TITLE -->
        <div class="title-section">KEPUTUSAN DIREKTUR RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG</div>

        <!-- META INFO -->
        <div class="meta-info">
            <p><strong>NOMOR</strong> : {{ $data['nomor_surat'] ?? '-' }}</p>
        </div>

        <div class="meta-info">
            <p style="text-align: center;"><strong>TENTANG</strong></p>
            <p style="text-align: center;"><strong>{{ strtoupper($data['tentang'] ?? '-') }}</strong></p>
        </div>

        <!-- CONTENT -->
        <div class="content">
            <!-- MENIMBANG -->
            <div class="section">
                <div class="section-title">Menimbang</div>
                <div class="section-content">{{ $data['menimbang'] ?? '-' }}</div>
            </div>

            <!-- MENGINGAT -->
            <div class="section">
                <div class="section-title">Mengingat</div>
                <div class="section-content">{{ $data['mengingat'] ?? '-' }}</div>
            </div>

            <!-- MEMUTUSKAN -->
            <div class="section">
                <div class="section-title">Memutuskan</div>
                <div class="section-content">
                    {!! nl2br($data['memutuskan'] ?? '-') !!}
                </div>
            </div>

            <!-- MENETAPKAN -->
            @if(!empty($data['menetapkan']))
            <div class="section">
                <div class="section-title">Menetapkan</div>
                <div class="section-content">{{ $data['menetapkan'] }}</div>
            </div>
            @endif
        </div>

        <!-- FOOTER -->
        <div class="footer clearfix">
            <div class="footer-place">
                <p><strong>Ditetapkan di</strong> {{ $data['tempat_dibuat'] ?? '-' }}</p>
                <p><strong>pada tanggal</strong> {{ \Carbon\Carbon::parse($data['tanggal_dibuat'] ?? '')->locale('id')->translatedFormat('j F Y') ?? '-' }}</p>
            </div>

            <div class="footer-sign">
                <p><strong>{{ $data['identitas_penetap'] ?? 'DIREKTUR' }}</strong></p>
                <div class="signature-line"></div>
                <p><strong>{{ $data['nama_pembuat'] ?? '' }}</strong></p>
                @if(!empty($data['jabatan_pembuat']))
                    <p style="font-size: 10pt;">{{ $data['jabatan_pembuat'] }}</p>
                @endif
            </div>
        </div>
    </div>
</body>

</html>