<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin-top: 0.35in;
            margin-bottom: 0.35in;
            margin-left: 0.5in;
            margin-right: 0.5in;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 10pt;
            line-height: 1.1;
            margin: 0;
            padding: 0;
            font-weight: normal;
        }

        .container {
            width: 100%;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 1px 2px !important;
            vertical-align: top;
            font-size: 10pt;
        }

        .no-border,
        .no-border td {
            border: none !important;
        }

        .center {
            text-align: center;
        }

        .underline {
            text-decoration: underline;
        }

        .section-header {
            padding: 2px 4px !important;
        }

        .header-right {
            font-size: 10pt;
            line-height: 1.4;
            text-align: left;
            margin-left: 20px;
        }

        .form-title {
            font-weight: normal;
            text-align: center;
            margin: 15px 0;
            font-size: 10pt;
            text-transform: uppercase;
        }

        .catatan-section td {
            padding: 1px;
            vertical-align: top;
            font-size: 10pt;
            line-height: 1.2;
        }
    </style>
</head>

<body>
    <?php 
        $f = $data['form'] ?? [];
function formatTanggalIndonesia($tanggal)
{
    if (empty($tanggal))
        return '';
    $bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $timestamp = strtotime($tanggal);
    $hari = date('d', $timestamp);
    $bulanAngka = date('n', $timestamp);
    $tahun = date('Y', $timestamp);
    return $hari . ' ' . $bulan[$bulanAngka] . ' ' . $tahun;
}
    ?>
    <div class="container">
        <!-- Header -->
        <table class="no-border" style="margin-bottom: 0;">
            <tr class="no-border">
                <td style="width: 45%"></td>
                <td style="width: 55%">
                    <div class="header-right">
                        <!-- LAMPIRAN II<br> -->
                        PERATURAN BADAN KEPEGAWAIAN NEGARA REPUBLIK INDONESIA NOMOR 7 TAHUN 2022<br>
                        TENTANG<br>
                        TATA CARA PEMBERIAN CUTI PEGAWAI PEMERINTAH DENGAN PERJANJIAN KERJA<br><br>
                    </div>
                </td>
            </tr>
        </table>

        <div class="center" style="font-size: 10pt; margin-bottom: 5px; margin-top: 5px;">
            Formulir Permintaan dan Pemberian Cuti Pegawai Pemerintah Dengan Perjanjian Kerja
        </div>

        <table class="no-border">
            <tr class="no-border">
                <td style="width: 45%"></td>
                <td style="width: 55%">
                    <div class="header-right">
                        <?= $f['tempat_surat'] ?? 'Sragen' ?>,
                        <?= isset($f['tanggal_surat']) ? formatTanggalIndonesia($f['tanggal_surat']) : '.......................' ?><br>
                        kepada :<br>
                        Yth. Direktur RSUD dr. Soeratno Gemolong<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kabupaten Sragen<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;di-<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SRAGEN
                    </div>
                </td>
            </tr>
        </table>

        <div class="form-title">
            FORMULIR PERMINTAAN DAN PEMBERIAN CUTI
        </div>

        <!-- I. DATA PEGAWAI -->
        <table>
            <tr>
                <td colspan="4" class="section-header">I. DATA PEGAWAI</td>
            </tr>
            <tr>
                <td style="width: 15%">Nama</td>
                <td style="width: 40%"><?= $f['nama'] ?? '' ?></td>
                <td style="width: 15%">NIP</td>
                <td style="width: 30%"><?= $f['nip'] ?? '' ?></td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td><?= $f['jabatan'] ?? '' ?></td>
                <td>Masa Kerja</td>
                <td>
                    <?php
$mkTh = isset($f['masa_kerja_tahun']) && $f['masa_kerja_tahun'] !== '' ? $f['masa_kerja_tahun'] : 0;
$mkBl = isset($f['masa_kerja_bulan']) && $f['masa_kerja_bulan'] !== '' ? $f['masa_kerja_bulan'] : 0;
echo $mkTh . ' th ' . $mkBl . ' bln';
                    ?>
                </td>
            </tr>
            <tr>
                <td>Unit Kerja</td>
                <td colspan="3"><?= $f['unit'] ?? '' ?></td>
            </tr>
        </table>

        <!-- II. JENIS CUTI YANG DIAMBIL -->
        <table>
            <tr>
                <td colspan="2" class="section-header">II. JENIS CUTI YANG DIAMBIL**</td>
            </tr>
            <tr>
                <td style="width: 55%">1. Cuti Tahunan</td>
                <td style="width: 45%" class="center">
                    <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Tahunan') ? 'V' : '' ?>
                </td>
            </tr>
            <tr>
                <td>2. Cuti Sakit</td>
                <td class="center">
                    <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Sakit') ? 'V' : '' ?>
                </td>
            </tr>
            <tr>
                <td>3. Cuti Melahirkan</td>
                <td class="center">
                    <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Melahirkan') ? 'V' : '' ?>
                </td>
            </tr>
        </table>

        <!-- III. ALASAN CUTI -->
        <table>
            <tr>
                <td class="section-header">III. ALASAN CUTI</td>
            </tr>
            <tr>
                <td style="min-height: 40px;">
                    <?= nl2br($f['alasan'] ?? '') ?>
                </td>
            </tr>
        </table>

        <!-- IV. LAMANYA CUTI -->
        <table>
            <tr>
                <td colspan="6" class="section-header">IV. LAMANYA CUTI</td>
            </tr>
            <tr>
                <td style="width: 10%">Selama</td>
                <td style="width: 15%"><?= $f['lama_cuti'] ?? '' ?> hari</td>
                <td style="width: 15%">mulai tanggal</td>
                <td style="width: 20%"><?= isset($f['mulai']) ? formatTanggalIndonesia($f['mulai']) : '' ?></td>
                <td style="width: 10%">s/d</td>
                <td style="width: 30%"><?= isset($f['sampai']) ? formatTanggalIndonesia($f['sampai']) : '' ?></td>
            </tr>
        </table>

        <!-- V. CATATAN CUTI -->
        <table>
            <tr>
                <td colspan="2" class="section-header">V. CATATAN CUTI***</td>
            </tr>
            <tr>
                <td style="width: 55%">1. CUTI TAHUNAN</td>
                <td style="width: 45%" class="center">
                    <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Tahunan') ? 'V' : '' ?></td>
            </tr>
            <tr>
                <td>2. CUTI SAKIT</td>
                <td class="center"><?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Sakit') ? 'V' : '' ?></td>
            </tr>
            <tr>
                <td>3. CUTI MELAHIRKAN</td>
                <td class="center"><?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Melahirkan') ? 'V' : '' ?>
                </td>
            </tr>
        </table>

        <!-- VI. ALAMAT SELAMA MENJALANKAN CUTI -->
        <table>
            <tr>
                <td colspan="3" class="section-header">VI. ALAMAT SELAMA MENJALANKAN CUTI</td>
            </tr>
            <tr>
                <td style="width: 55%;">
                    <?= nl2br($f['alamat'] ?? '') ?>
                </td>
                <td style="width: 15%;">TELP</td>
                <td style="width: 30%;"><?= $f['telp'] ?? '' ?></td>
            </tr>
            <tr>
                <td style="width: 55%;"></td>
                <td colspan="2" class="center" style="vertical-align: middle; padding: 8px;">
                    Hormat saya,<br><br><br><br>
                    <span class="underline"><?= $f['nama'] ?? '' ?></span><br>
                    NIP. <?= $f['nip'] ?? '' ?>
                </td>
            </tr>
        </table>

        <!-- VII. PERTIMBANGAN ATASAN LANGSUNG -->
        <table>
            <tr>
                <td colspan="4" class="section-header">VII. PERTIMBANGAN ATASAN LANGSUNG**</td>
            </tr>
            <tr>
                <td style="width: 16%;">DISETUJUI</td>
                <td style="width: 17%;">PERUBAHAN****</td>
                <td style="width: 17%;">DITANGGUHKAN****</td>
                <td style="width: 50%;">TIDAK DISETUJUI****</td>
            </tr>
            <tr>
                <td class="center" style="height: 20px;">
                    <?= (isset($f['atasan_setuju']) && $f['atasan_setuju'] == 'DISETUJUI') ? 'V' : '' ?>
                </td>
                <td class="center">
                    <?= (isset($f['atasan_setuju']) && $f['atasan_setuju'] == 'PERUBAHAN') ? 'V' : '' ?>
                </td>
                <td class="center">
                    <?= (isset($f['atasan_setuju']) && $f['atasan_setuju'] == 'DITANGGUHKAN') ? 'V' : '' ?>
                </td>
                <td class="center">
                    <?= (isset($f['atasan_setuju']) && $f['atasan_setuju'] == 'TIDAK DISETUJUI') ? 'V' : '' ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border: none; width: 100%;"></td>
                <td class="center" style="vertical-align: middle; padding: 8px;">
                    <?= strtoupper($f['jabatan_atasan'] ?? 'Atasan') ?><br><br><br><br>
                    <u><?= strtoupper($f['nama_atasan'] ?? '') ?></u><br>
                    NIP. <?= $f['nip_atasan'] ?? '' ?>
                </td>
            </tr>
        </table>

        <!-- VIII. KEPUTUSAN PEJABAT YANG BERWENANG -->
        <table>
            <tr>
                <td colspan="4" class="section-header">VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI**</td>
            </tr>
            <tr>
                <td style="width: 16%;">DISETUJUI</td>
                <td style="width: 17%;">PERUBAHAN****</td>
                <td style="width: 17%;">DITANGGUHKAN****</td>
                <td style="width: 50%;">TIDAK DISETUJUI****</td>
            </tr>
            <tr>
                <td class="center" style="height: 20px;">
                    <?= (isset($f['pejabat_keputusan']) && $f['pejabat_keputusan'] == 'DISETUJUI') ? 'V' : '' ?>
                </td>
                <td class="center">
                    <?= (isset($f['pejabat_keputusan']) && $f['pejabat_keputusan'] == 'PERUBAHAN') ? 'V' : '' ?>
                </td>
                <td class="center">
                    <?= (isset($f['pejabat_keputusan']) && $f['pejabat_keputusan'] == 'DITANGGUHKAN') ? 'V' : '' ?>
                </td>
                <td class="center">
                    <?= (isset($f['pejabat_keputusan']) && $f['pejabat_keputusan'] == 'TIDAK DISETUJUI') ? 'V' : '' ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border: none;">
                    <table class="no-border catatan-section" style="width: 100%;">
                        <tr>
                            <td colspan="2" style="padding: 1px;">Catatan:</td>
                        </tr>
                        <tr>
                            <td style="width: 15px; padding: 1px;">*</td>
                            <td>Coret yang tidak perlu</td>
                        </tr>
                        <tr>
                            <td style="width: 15px; padding: 1px;">**</td>
                            <td>Pilih salah satu dengan memberi tanda centang (V)</td>
                        </tr>
                        <tr>
                            <td style="width: 15px; padding: 1px;">***</td>
                            <td>diisi oleh pejabat yang menangani bidang kepegawaian sebelum PPPK mengajukan cuti</td>
                        </tr>
                        <tr>
                            <td style="width: 15px; padding: 1px;">****</td>
                            <td>diberi tanda centang dan alasannya</td>
                        </tr>
                    </table>
                </td>
                <td class="center" style="vertical-align: middle; padding: 8px;">
                    KEPUTUSAN PEJABAT YANG<br>
                    BERWENANG MEMBERIKAN CUTI<br>
                    DIREKTUR RSUD dr. SOERATNO GEMOLONG<br>
                    KABUPATEN SRAGEN<br><br><br><br>
                    <u>Dr. dr. KINIK DARSONO, M.Pd.Ked.</u><br>
                    NIP. 19710415 200903 1 001
                </td>
            </tr>
        </table>
    </div>
</body>

</html>