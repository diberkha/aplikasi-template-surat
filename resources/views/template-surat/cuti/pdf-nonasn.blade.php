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
        table { 
            border-collapse: collapse; 
            width: 100%; 
            margin-bottom: 20px;
        }
        td, th { 
            border: 1px solid #000; 
            padding: 0;
            vertical-align: top;
            font-size: 10pt;
        }
        .no-border, .no-border td, .no-border th { 
            border: none !important; 
        }
        .center { text-align: center; }
        .underline { text-decoration: underline; }
        .section-header { 
            padding: 0;
            font-weight: normal;
        }
        .form-title {
            font-weight: normal;
            text-align: center;
            margin: 15px 0;
            font-size: 10pt; 
        }
        .header-right {
            text-align: left;
            margin-left: 100px; 
        }
        .catatan-section td {
             padding: 0;
             vertical-align: top;
        }
    </style>
</head>
<body>
    <?php 
        $f = $data['form'] ?? [];
        
        function formatTanggalIndonesia($tanggal) {
            if (empty($tanggal)) return '';
            
            $bulan = array(
                1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            );
            
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
                <td style="width: 40%"></td>
                <td style="width: 60%">
                    <div class="header-right">
                        <?= $f['tempat_surat'] ?? 'Sragen' ?>, <?= isset($f['tanggal_surat']) ? formatTanggalIndonesia($f['tanggal_surat']) : '.......................' ?><br>
                        Kepada :<br>
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
                <td style="width: 55%"><?= $f['nama'] ?? '' ?></td>
                <td style="width: 15%">Masa Kerja</td>
                <td style="width: 45%">
                    <?php
                        $mkTh = $f['masa_kerja_tahun'] ?? '';
                        $mkBl = $f['masa_kerja_bulan'] ?? '';
                        echo ($mkTh ? $mkTh.' th' : '');
                        echo ($mkBl ? ' '.$mkBl.' bln' : '');
                    ?>
                </td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td colspan="3"><?= $f['jabatan'] ?? '' ?></td>
            </tr>
            <tr>
                <td>Unit Kerja</td>
                <td colspan="3"><?= $f['unit'] ?? 'RSUD dr. Soeratno Gemolong' ?></td>
            </tr>
        </table>

        <!-- II. JENIS CUTI YANG DIAMBIL -->
        <table>
            <tr>
                <td colspan="2" class="section-header">II. JENIS CUTI YANG DIAMBIL**</td>
            </tr>
            <tr>
                <td style="width: 55%">1. Cuti Tahunan</td>
                <td style="width: 45%; text-align: center;">
                    <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Tahunan') ? 'V' : '' ?>
                </td>
            </tr>
            <tr>
                <td>2. Cuti Besar</td>
                <td style="text-align: center;">
                    <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Besar') ? 'V' : '' ?>
                </td>
            </tr>
            <tr>
                <td>3. Cuti Melahirkan</td>
                <td style="text-align: center;">
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
                <td style="min-height: 40px; padding: 2px;">
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
                <td style="width: 10%" class="center">Selama</td>
                <td style="width: 15%" class="center"><?= $f['lama_cuti'] ?? '' ?> hari</td>
                <td style="width: 15%" class="center">mulai tanggal</td>
                <td style="width: 20%"><?= isset($f['mulai']) ? formatTanggalIndonesia($f['mulai']) : '' ?></td>
                <td style="width: 10%" class="center">s/d</td>
                <td style="width: 30%"><?= isset($f['sampai']) ? formatTanggalIndonesia($f['sampai']) : '' ?></td>
            </tr>
        </table>

        <!-- V. CATATAN CUTI -->
        <table>
            <tr>
                <td colspan="5" class="section-header">V. CATATAN CUTI***</td>
            </tr>
            <tr>
                <td colspan="3" style="width: 2.35in">1. CUTI TAHUNAN</td>
                <td style="width: 2.35in">2. CUTI BESAR</td>
                <td style="width: 0.89in" class="center">
                     <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Besar') ? 'V' : '' ?>
                </td>
            </tr>
            <tr>
                <td style="width: 0.5in;">Tahun</td>
                <td style="width: 0.5in;">Sisa</td>
                <td style="width: 1.5in;">Keterangan</td>
                <td>3. CUTI MELAHIRKAN</td>
                <td style="text-align: center;">
                     <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Melahirkan') ? 'V' : '' ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: left;">N</td>
                <td style="text-align: left;"><?= $f['catatan_n'] ?? '' ?></td>
                <td style="text-align: left;"><?= $f['catatan_n_keterangan'] ?? '' ?></td>
                <td></td>
                <td></td>
            </tr>
        </table>

        <!-- VI. ALAMAT SELAMA MENJALANKAN CUTI -->
        <table>
            <tr>
                <td colspan="3" class="section-header">VI. ALAMAT SELAMA MENJALANKAN CUTI :</td>
            </tr>
            <tr>
                <td style="width: 55%; vertical-align: top; border-bottom: none;">
                    <?= nl2br($f['alamat'] ?? '') ?>
                </td>
                <td style="width: 15%; vertical-align: top;">TELP</td>
                <td style="width: 35%; vertical-align: top;">
                    <?= $f['telp'] ?? '' ?>
                </td>
            </tr>
            <tr>
                <td style="width: 45%; vertical-align: top;"></td>
                <td colspan="2" style="text-align: center; vertical-align: bottom; padding-bottom: 8px;">
                    Hormat saya,<br><br><br><br>
                    <span class="underline"><?= $f['nama'] ?? '' ?></span><br>
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
                <td style="text-align: center; height: 20px;">
                    <?= (isset($f['atasan_setuju']) && $f['atasan_setuju'] == 'DISETUJUI') ? 'V' : '' ?>
                </td>
                <td style="text-align: center;">
                    <?= (isset($f['atasan_setuju']) && $f['atasan_setuju'] == 'PERUBAHAN') ? 'V' : '' ?>
                </td>
                <td style="text-align: center;">
                    <?= (isset($f['atasan_setuju']) && $f['atasan_setuju'] == 'DITANGGUHKAN') ? 'V' : '' ?>
                </td>
                <td style="text-align: center;">
                    <?= (isset($f['atasan_setuju']) && $f['atasan_setuju'] == 'TIDAK DISETUJUI') ? 'V' : '' ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border: none;"></td>
                <td style="text-align: center; vertical-align: middle; padding: 8px; height: 100px;">
                    <?php if (!empty($f['jabatan_atasan'])): ?>
                        <?= strtoupper($f['jabatan_atasan']) ?><br><br><br><br>
                    <?php else: ?>
                        KEPALA SEKSI KEPERAWATAN DAN<br>PENUNJANG NON MEDIS<br><br><br><br>
                    <?php endif; ?>
                    <?php if (!empty($f['nama_atasan'])): ?>
                        <u><?= strtoupper($f['nama_atasan']) ?></u><br>
                        <?php if (!empty($f['nip_atasan'])): ?>
                            NIP. <?= $f['nip_atasan'] ?>
                        <?php endif; ?>
                    <?php else: ?>
                        <u>LILIK SUBAGYO, S.Kep. Ns.</u><br>
                        NIP. 19830804 201001 1 016
                    <?php endif; ?>
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
                <td style="text-align: center; height: 20px;">
                    <?= (isset($f['pejabat_keputusan']) && $f['pejabat_keputusan'] == 'DISETUJUI') ? 'V' : '' ?>
                </td>
                <td style="text-align: center;">
                    <?= (isset($f['pejabat_keputusan']) && $f['pejabat_keputusan'] == 'PERUBAHAN') ? 'V' : '' ?>
                </td>
                <td style="text-align: center;">
                    <?= (isset($f['pejabat_keputusan']) && $f['pejabat_keputusan'] == 'DITANGGUHKAN') ? 'V' : '' ?>
                </td>
                <td style="text-align: center;">
                    <?= (isset($f['pejabat_keputusan']) && $f['pejabat_keputusan'] == 'TIDAK DISETUJUI') ? 'V' : '' ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border: none; vertical-align: top;">
                    <table class="no-border" style="font-size: 10pt; line-height: 1.2; width: 100%;">
                        <tr>
                            <td colspan="2" style="padding: 1px;">Catatan:</td>
                        </tr>
                        <tr>
                            <td style="width: 15px; padding: 1px;">*</td>
                            <td style="padding: 1px;">Coret yang tidak perlu</td>
                        </tr>
                        <tr>
                            <td style="width: 15px; padding: 1px;">**</td>
                            <td style="padding: 1px;">Pilih salah satu dengan memberi tanda centang (V)</td>
                        </tr>
                        <tr>
                            <td style="width: 15px; padding: 1px;">***</td>
                            <td style="padding: 1px;">diisi oleh pejabat yang menangani bidang kepegawaian sebelum Non ASN mengajukan cuti</td>
                        </tr>
                        <tr>
                            <td style="width: 15px; padding: 1px;">****</td>
                            <td style="padding: 1px;">diberi tanda centang dan alasannya...</td>
                        </tr>
                        <tr>
                            <td style="width: 15px; padding: 1px;">N</td>
                            <td style="padding: 1px;">= Cuti tahun berjalan</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center; vertical-align: middle; padding: 8px;">
                    KEPUTUSAN PEJABAT YANG<br>
                    BERWENANG MEMBERIKAN CUTI<br>
                    DIREKTUR RSUD dr. SOERATNO GEMOLONG<br>
                    KABUPATEN GEMOLONG<br><br><br><br>
                    <?php if (!empty($f['nama_direktur'])): ?>
                        <u><?= strtoupper($f['nama_direktur']) ?></u><br>
                        <?php if (!empty($f['nip_direktur'])): ?>
                            NIP. <?= $f['nip_direktur'] ?>
                        <?php endif; ?>
                    <?php else: ?>
                        <u>Dr. dr. KINIK DARSONO, M.Pd.Ked.</u><br>
                        NIP. 19710415 200903 1 001
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>