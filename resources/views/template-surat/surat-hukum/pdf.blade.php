<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $data['nama_surat'] ?? 'Surat' }}</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #111;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .title {
            font-size: 14px;
            font-weight: bold;
        }

        .meta {
            margin-bottom: 10px;
        }

        .section {
            margin-bottom: 12px;
        }

        .section h4 {
            margin: 0 0 6px 0;
            font-size: 12px;
        }

        .section p {
            margin: 0;
            font-size: 12px;
        }

        .footer {
            margin-top: 30px;
            text-align: left;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">PEMERINTAH KABUPATEN</div>
        <div class="title">RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG</div>
        <div style="margin-top:12px; font-weight: bold;">KEPUTUSAN DIREKTUR</div>
    </div>

    <div class="meta">
        <strong>Nomor:</strong> {{ $data['nomor_surat'] ?? '-' }}<br>
        <strong>Tanggal:</strong> {{ $data['tanggal_dibuat'] ?? '-' }}
    </div>

    <div class="section">
        <h4>Tentang</h4>
        <p>{{ $data['tentang'] ?? '-' }}</p>
    </div>

    <div class="section">
        <h4>Menimbang</h4>
        <p style="white-space:pre-line">{{ $data['menimbang'] ?? '-' }}</p>
    </div>

    <div class="section">
        <h4>Mengingat</h4>
        <p style="white-space:pre-line">{{ $data['mengingat'] ?? '-' }}</p>
    </div>

    <div class="section">
        <h4>Memutuskan</h4>
        <p style="white-space:pre-line">{{ $data['memutuskan'] ?? '-' }}</p>
    </div>

    @if(!empty($data['menetapkan']))
        <div class="section">
            <h4>Menetapkan</h4>
            <p style="white-space:pre-line">{{ $data['menetapkan'] }}</p>
        </div>
    @endif

    <div class="footer">
        <p>Tempat: {{ $data['tempat_dibuat'] ?? '-' }}</p>
        <p>Tanggal: {{ $data['tanggal_dibuat'] ?? '-' }}</p>
        <p style="margin-top:18px;">{{ $data['identitas_penetap'] ?? '' }}</p>
    </div>
</body>

</html>