<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 11px; }
        table { border-collapse: collapse; width: 100%; }
        td, th { border: 1px solid #000; padding: 4px 6px; vertical-align: top; }
        .no-border td, .no-border th { border: none; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .underline { text-decoration: underline; }
    </style>
</head>
<body>
    <?php $f = $data['form'] ?? []; ?>
    <table>
        <tr class="no-border">
            <td colspan="4" class="center bold">LAMPIRAN II</td>
        </tr>
        <tr class="no-border">
            <td colspan="4" class="center">PERATURAN BADAN KEPEGAWAIAN NEGARA<br>REPUBLIK INDONESIA NOMOR 7 TAHUN 2021<br>TENTANG<br>TATA CARA PEMBERIAN CUTI PEGAWAI PEMERINTAH<br>DENGAN PERJANJIAN KERJA</td>
        </tr>
        <tr class="no-border">
            <td colspan="4" class="center bold">Formulir Permintaan dan Pemberian Cuti Pegawai Pemerintah Dengan Perjanjian Kerja</td>
        </tr>
        <tr class="no-border"><td colspan="4">&nbsp;</td></tr>

        <tr>
            <td colspan="4" class="bold">I. DATA PEGAWAI</td>
        </tr>
        <tr>
            <td style="width:25%">Nama</td>
            <td style="width:25%"><?= $f['nama'] ?? '' ?></td>
            <td style="width:25%">NIP</td>
            <td style="width:25%"><?= $f['nip'] ?? '' ?></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td colspan="3"><?= $f['jabatan'] ?? '' ?></td>
        </tr>
        <tr>
            <td>Unit Kerja</td>
            <td colspan="3"><?= $f['unit'] ?? '' ?></td>
        </tr>
        <tr>
            <td>Masa Kerja</td>
            <td colspan="3"><?= ($f['masa_kerja_bulan'] ?? '') ? ($f['masa_kerja_bulan'].' bulan') : '' ?></td>
        </tr>

        <tr>
            <td colspan="4" class="bold">II. JENIS CUTI YANG DIAMBIL**</td>
        </tr>
        <tr>
            <td colspan="4">
                <table class="no-border" style="width:100%">
                    <tr class="no-border">
                        <td style="width:50%">1. Cuti Tahunan</td>
                        <td style="width:50%">2. Cuti Sakit</td>
                    </tr>
                    <tr class="no-border">
                        <td>3. Cuti Melahirkan</td>
                        <td>4. Cuti Karena Alasan Penting</td>
                    </tr>
                    <tr class="no-border">
                        <td colspan="2">Jenis yang diambil: <span class="bold underline"><?= $f['jenis_cuti'] ?? '' ?></span></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="4" class="bold">III. ALASAN CUTI</td>
        </tr>
        <tr>
            <td colspan="4"><?= $f['alasan'] ?? '' ?></td>
        </tr>

        <tr>
            <td colspan="4" class="bold">IV. LAMANYA CUTI</td>
        </tr>
        <tr>
            <td style="width:25%">Selama</td>
            <td style="width:25%"><?= $f['lama_cuti'] ?? '' ?> hari</td>
            <td style="width:25%">mulai tanggal</td>
            <td style="width:25%"><?= $f['mulai'] ?? '' ?> s/d <?= $f['sampai'] ?? '' ?></td>
        </tr>

        <tr>
            <td colspan="4" class="bold">V. CATATAN CUTI***</td>
        </tr>
        <tr>
            <td colspan="4"><?= $f['catatan_cuti'] ?? '(Diisi oleh pejabat kepegawaian sesuai ketentuan)' ?></td>
        </tr>

        <tr>
            <td colspan="4" class="bold">VI. ALAMAT SELAMA MENJALANKAN CUTI</td>
        </tr>
        <tr>
            <td colspan="3"><?= $f['alamat'] ?? '' ?></td>
            <td>Telp: <?= $f['telp'] ?? '' ?></td>
        </tr>

        <tr>
            <td colspan="4" class="bold">VII. PERTIMBANGAN ATASAN LANGSUNG****</td>
        </tr>
        <tr>
            <td style="width:25%">DISETUJUI</td>
            <td style="width:25%">PERUBAHAN****</td>
            <td style="width:25%">DITANGGUHKAN****</td>
            <td style="width:25%">TIDAK DISETUJUI****</td>
        </tr>
        <tr>
            <td colspan="4" class="center">
                <div style="margin-bottom: 40px;"><?= $f['atasan_setuju'] ?? '' ?></div>
                <div>Tanggal: <?= $f['tanggal_atasan'] ?? '' ?></div>
            </td>
        </tr>

        <tr>
            <td colspan="4" class="bold">VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI****</td>
        </tr>
        <tr>
            <td style="width:25%">DISETUJUI</td>
            <td style="width:25%">PERUBAHAN****</td>
            <td style="width:25%">DITANGGUHKAN****</td>
            <td style="width:25%">TIDAK DISETUJUI****</td>
        </tr>
        <tr>
            <td colspan="4" class="center">
                <div style="margin-top: 10px;"><?= $f['pejabat_keputusan'] ?? '' ?></div>
                <div style="margin: 10px 0;">KEPALA SEKSI KEPEGAWAIAN DAN<br>PENUNJANG NON MEDIS</div>
                <div style="margin: 40px 0;"><?= $f['nama_pejabat'] ?? 'LILIK SURAGYO, S.Kep.,Ns.' ?></div>
                <div>NIP. <?= $f['nip_pejabat'] ?? '197104151 201903 1 002' ?></div>
                <div style="margin-top: 10px;">Tanggal: <?= $f['tanggal_pejabat'] ?? '' ?></div>
            </td>
        </tr>

        <tr class="no-border">
            <td colspan="4" style="font-size: 9px;">
                <div>Catatan:</div>
                <div>* Coret yang tidak perlu</div>
                <div>** Sesuai dengan jenis cuti yang diberikan tanda centang (√)</div>
                <div>*** Diisi oleh pejabat yang menangani bidang kepegawaian dan sebelum PNS mengajukan cuti diberi tanda centang dan diasosinya.</div>
                <div>**** Sisa cuti 1 tahun sebelumnya</div>
            </td>
        </tr>

        <tr class="no-border">
            <td colspan="4" class="center">Nomor Surat: {{ $data['nomor_surat'] ?? '' }}</td>
        </tr>
    </table>
</body>
</html>