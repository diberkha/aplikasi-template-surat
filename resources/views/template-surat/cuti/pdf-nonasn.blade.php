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
            <td colspan="4" class="center">
                <div>Kepada</div>
                <div>Yth. Direktur RSUD dr. Soeratno Gemolong</div>
                <div>Kabupaten Sragen</div>
                <div>di-</div>
                <div class="bold">SRAGEN</div>
            </td>
        </tr>
        <tr class="no-border"><td colspan="4">&nbsp;</td></tr>
        <tr class="no-border">
            <td colspan="4" class="center bold">FORMULIR PERMINTAAN DAN PEMBERIAN CUTI</td>
        </tr>
        <tr class="no-border"><td colspan="4">&nbsp;</td></tr>

        <tr>
            <td colspan="4" class="bold">I. DATA PEGAWAI</td>
        </tr>
        <tr>
            <td style="width:25%">Nama</td>
            <td style="width:25%"><?= $f['nama'] ?? '' ?></td>
            <td style="width:25%">Masa Kerja</td>
            <td style="width:25%">: th bln</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td colspan="3"><?= $f['jabatan'] ?? '' ?></td>
        </tr>
        <tr>
            <td>Unit Kerja</td>
            <td colspan="3"><?= $f['unit'] ?? 'RSUD dr. Soeratno Gemolong' ?></td>
        </tr>

        <tr>
            <td colspan="4" class="bold">II. JENIS CUTI YANG DIAMBIL **</td>
        </tr>
        <tr>
            <td colspan="4">
                <table class="no-border" style="width:100%">
                    <tr class="no-border">
                        <td>1. Cuti Tahunan</td>
                        <td>2. Cuti Besar</td>
                    </tr>
                    <tr class="no-border">
                        <td colspan="2">3. Cuti Melahirkan</td>
                    </tr>
                    <tr class="no-border">
                        <td colspan="2">Jenis yang diambil: <span class="bold"><?= $f['jenis_cuti'] ?? '' ?></span></td>
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
            <td>Selama</td>
            <td><?= $f['lama_cuti'] ?? '' ?> hari</td>
            <td>mulai tanggal</td>
            <td><?= $f['mulai'] ?? '' ?> s.d <?= $f['sampai'] ?? '' ?></td>
        </tr>

        <tr>
            <td colspan="4" class="bold">V. CATATAN CUTI***</td>
        </tr>
        <tr>
            <td colspan="4"><?= $f['catatan_cuti'] ?? '' ?></td>
        </tr>

        <tr>
            <td colspan="4" class="bold">VI. ALAMAT SELAMA MENJALANKAN CUTI :</td>
        </tr>
        <tr>
            <td colspan="3"><?= $f['alamat'] ?? '' ?></td>
            <td style="vertical-align: top;">
                <div>TELP</div>
                <div style="margin: 20px 0;">Hormat saya,</div>
                <div style="margin: 40px 0;"><?= $f['hormat_saya'] ?? '(..............................)' ?></div>
            </td>
        </tr>

        <tr>
            <td colspan="4" class="bold">VII. PERTIMBANGAN ATASAN LANGSUNG**</td>
        </tr>
        <tr>
            <td style="width:25%">DISETUJUI</td>
            <td style="width:25%">PERUBAHAN****</td>
            <td style="width:25%">DITANGGUHKAN****</td>
            <td style="width:25%">TIDAK DISETUJUI****</td>
        </tr>
        <tr>
            <td colspan="4" class="center">
                <div style="margin: 10px 0;"><?= $f['atasan_setuju'] ?? '' ?></div>
                <div style="margin: 5px 0;">KEPALA SEKSI KEPEGAWAIAN DAN<br>PENUNJANG NON MEDIS</div>
                <div style="margin: 40px 0;"><?= $f['nama_atasan'] ?? 'LILIK SURAGYO, S.Kep.,Ns.' ?></div>
                <div>NIP. <?= $f['nip_atasan'] ?? '19851804 201903 1 016' ?></div>
            </td>
        </tr>

        <tr>
            <td colspan="4" class="bold">VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI**</td>
        </tr>
        <tr>
            <td style="width:25%">DISETUJUI</td>
            <td style="width:25%">PERUBAHAN****</td>
            <td style="width:25%">DITANGGUHKAN****</td>
            <td style="width:25%">TIDAK DISETUJUI****</td>
        </tr>
        <tr>
            <td colspan="4">
                <table class="no-border" style="width:100%">
                    <tr class="no-border">
                        <td style="width:50%">
                            <div>Catatan :</div>
                            <div>* Coret yang tidak perlu</div>
                            <div>** Pilih salah satu dengan tanda centang (√)</div>
                            <div>*** Diisi oleh pejabat yang menangani bidang kepegawaian dan sebelum PNS mengajukan cuti diberi tanda centang dan diasosinya.</div>
                        </td>
                        <td style="width:50%; text-align: center;">
                            <div style="margin: 10px 0;"><?= $f['pejabat_keputusan'] ?? '' ?></div>
                            <div style="margin: 5px 0;">KEPUTUSAN PEJABAT YANG<br>BERWENANG MEMBERIKAN CUTI<br>DIREKTUR RSUD dr. SOERATNO GEMOLONG<br>KABUPATEN GEMOLONG</div>
                            <div style="margin: 40px 0;"><?= $f['nama_direktur'] ?? 'dr. KINIK DARSONO, M.Pd.Ked.' ?></div>
                            <div>NIP. <?= $f['nip_direktur'] ?? '19710415 200903 1 001' ?></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="no-border">
            <td colspan="4" style="font-size: 9px;">
                <div>N = Cuti tahun lalu/.....</div>
            </td>
        </tr>

        <tr class="no-border">
            <td colspan="4" class="center">Nomor Surat: {{ $data['nomor_surat'] ?? '' }}</td>
        </tr>
    </table>
</body>
</html>