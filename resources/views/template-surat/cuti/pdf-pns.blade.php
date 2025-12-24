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
            line-height: 1.3;
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
            margin-bottom: 10px;
        }
        td { 
            border: 1px solid #000; 
            padding: 4px 6px; 
            vertical-align: top;
            font-size: 10pt;
        }
        .no-border, .no-border td { 
            border: none !important; 
        }
        .section-header { 
            padding: 5px 8px !important;
        }
        .inner-table { 
            width: 100%; 
            border: none !important; 
            margin: 0; 
        }
        .inner-table td { 
            border: none !important; 
            padding: 2px 4px; 
        }
        .inner-table-bordered {
            width: 100%;
            border: none !important;
            margin: 0;
        }
        .inner-table-bordered td {
            border: 1px solid #000 !important;
            padding: 2px 4px;
        }
        .center { 
            text-align: center; 
        }
        .right { 
            text-align: right; 
        }
        .left {
            text-align: left;
        }
        .underline { 
            text-decoration: underline; 
        }
        .vertical-top {
            vertical-align: top;
        }
        .vertical-middle {
            vertical-align: middle;
        }
        .form-title {
            font-weight: normal;
            text-align: center;
            margin: 15px 0;
            font-size: 11pt;
        }
        .header-right {
            font-size: 9pt;
            line-height: 1.4;
            text-align: left;
        }
    </style>
</head>
<body>
    <?php 
        $f = $data['form'] ?? [];
        
        // Fungsi untuk format tanggal Indonesia
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
        <!-- Header dengan tabel tanpa border -->
        <table class="no-border">
            <tr class="no-border">
                <td style="width: 45%"></td>
                <td style="width: 55%" class="header-right">
                    ANAK LAMPIRAN I b<br>
                    PERATURAN BADAN KEPEGAWAIAN NEGARA REPUBLIK INDONESIA NOMOR 24 TAHUN 2017<br>
                    TENTANG<br>
                    TATA CARA PEMBERIAN CUTI PEGAWAI NEGERI SIPIL<br>
                    <?= isset($f['tanggal_surat']) ? formatTanggalIndonesia($f['tanggal_surat']) : '.......................' ?><br>
                    kepada :<br>
                    Yth. Direktur RSUD dr. Soeratno Gemolong<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kabupaten Sragen<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;di-<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SRAGEN
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
                <td style="width: 35%"><?= $f['nama'] ?? '' ?></td>
                <td style="width: 15%">NIP</td>
                <td style="width: 35%"><?= $f['nip'] ?? '' ?></td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td><?= $f['jabatan'] ?? '' ?></td>
                <td>Masa Kerja</td>
                <td>
                    <?php
                        $mkTh = $f['masa_kerja_tahun'] ?? '';
                        $mkBl = $f['masa_kerja_bulan'] ?? '';
                        echo ($mkTh ? $mkTh.' th' : '');
                        echo ($mkBl ? ' '.$mkBl.' bln' : '');
                    ?>
                </td>
            </tr>
            <tr>
                <td>Unit Kerja</td>
                <td colspan="3"><?= $f['unit'] ?? 'RSUD dr. Soeratno Gemolong' ?></td>
            </tr>
        </table>

        <!-- II. JENIS CUTI YANG DIAMBIL -->
        <table>
            <tr>
                <td colspan="4" class="section-header">II. JENIS CUTI YANG DIAMBIL **</td>
            </tr>
            <tr>
                <td style="width: 2.35in">1. Cuti Tahunan</td>
                <td style="width: 0.89in" class="center">
                    <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Tahunan') ? 'V' : '' ?>
                </td>
                <td style="width: 2.35in">2. Cuti Besar</td>
                <td style="width: 0.89in" class="center">
                    <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Besar') ? 'V' : '' ?>
                </td>
            </tr>
            <tr>
                <td>3. Cuti Sakit</td>
                <td class="center">
                    <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Sakit') ? 'V' : '' ?>
                </td>
                <td>4. Cuti Melahirkan</td>
                <td class="center">
                    <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Melahirkan') ? 'V' : '' ?>
                </td>
            </tr>
            <tr>
                <td>5. Cuti Karena Alasan Penting</td>
                <td class="center">
                    <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Karena Alasan Penting') ? 'V' : '' ?>
                </td>
                <td>6. Cuti di Luar Tanggungan Negara</td>
                <td class="center">
                    <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti di Luar Tanggungan Negara') ? 'V' : '' ?>
                </td>
            </tr>
        </table>

        <!-- III. ALASAN CUTI -->
        <table>
            <tr>
                <td class="section-header">III. ALASAN CUTI</td>
            </tr>
            <tr>
                <td style="min-height: 40px; padding: 8px;">
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
                <td style="width: 15%"><?= $f['lama_cuti'] ?? '' ?> hari</td>
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
                <td style="width: 1.20in;">Keterangan</td>
                <td>3. CUTI SAKIT</td>
                <td class="center">
                    <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Sakit') ? 'V' : '' ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: left;">N-2</td>
                <td style="text-align: center;"><?= $f['catatan_n2'] ?? '' ?></td>
                <td style="text-align: left;"><?= $f['catatan_n2_keterangan'] ?? '' ?></td>
                <td>4. CUTI MELAHIRKAN</td>
                <td class="center">
                    <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Melahirkan') ? 'V' : '' ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: left;">N-1</td>
                <td style="text-align: center;"><?= $f['catatan_n1'] ?? '' ?></td>
                <td style="text-align: left;"><?= $f['catatan_n1_keterangan'] ?? '' ?></td>
                <td>5. CUTI KARENA ALASAN PENTING</td>
                <td class="center">
                    <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Karena Alasan Penting') ? 'V' : '' ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: left;">N</td>
                <td style="text-align: center;"><?= $f['catatan_n'] ?? '' ?></td>
                <td style="text-align: left;"><?= $f['catatan_n_keterangan'] ?? '' ?></td>
                <td>6. CUTI DI LUAR TANGGUNGAN NEGARA</td>
                <td class="center">
                    <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti di Luar Tanggungan Negara') ? 'V' : '' ?>
                </td>
            </tr>
        </table>



        <!-- VI. ALAMAT SELAMA MENJALANKAN CUTI -->
        <table>
            <tr>
                <td colspan="3" class="section-header">VI. ALAMAT SELAMA MENJALANKAN CUTI :</td>
            </tr>
            <tr>
                <td style="width: 55%; padding: 8px; vertical-align: top;" rowspan="2">
                    <?= nl2br($f['alamat'] ?? '') ?>
                </td>
                <td style="width: 15%; padding: 4px;">TELP</td>
                <td style="width: 30%; padding: 4px;"><?= $f['telp'] ?? '' ?></td>
            </tr>
            <tr>
                <td colspan="2" style="width: 50%; text-align: center; vertical-align: bottom; padding-bottom: 8px;">
                    Hormat saya,<br><br><br><br>
                    <span class="underline">(<?= $f['nama'] ?? '' ?>)</span><br>
                    NIP <?= $f['nip'] ?? '' ?>
                </td>
            </tr>
        </table>

        <!-- VII. PERTIMBANGAN ATASAN LANGSUNG -->
        <table>
            <tr>
                <td colspan="4" class="section-header">VII. PERTIMBANGAN ATASAN LANGSUNG**</td>
            </tr>
            <tr>
                <td style="width: 16%; padding: 8px;">DISETUJUI</td>
                <td style="width: 17%; padding: 8px;">PERUBAHAN****</td>
                <td style="width: 17%; padding: 8px;">DITANGGUHKAN****</td>
                <td style="width: 50%; padding: 8px;">TIDAK DISETUJUI****</td>
            </tr>
            <tr>
                <td style="text-align: center; padding: 4px; height: 25px;">
                    <?= (isset($f['atasan_setuju']) && $f['atasan_setuju'] == 'DISETUJUI') ? 'V' : '' ?>
                </td>
                <td style="text-align: center; padding: 4px;">
                    <?= (isset($f['atasan_setuju']) && $f['atasan_setuju'] == 'PERUBAHAN') ? 'V' : '' ?>
                </td>
                <td style="text-align: center; padding: 4px;">
                    <?= (isset($f['atasan_setuju']) && $f['atasan_setuju'] == 'DITANGGUHKAN') ? 'V' : '' ?>
                </td>
                <td style="text-align: center; padding: 4px;">
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
                <td style="width: 16%; padding: 8px;">DISETUJUI</td>
                <td style="width: 17%; padding: 8px;">PERUBAHAN****</td>
                <td style="width: 17%; padding: 8px;">DITANGGUHKAN****</td>
                <td style="width: 50%; padding: 8px;">TIDAK DISETUJUI****</td>
            </tr>
            <tr>
                <td style="text-align: center; padding: 4px; height: 25px;">
                    <?= (isset($f['pejabat_keputusan']) && $f['pejabat_keputusan'] == 'DISETUJUI') ? 'V' : '' ?>
                </td>
                <td style="text-align: center; padding: 4px;">
                    <?= (isset($f['pejabat_keputusan']) && $f['pejabat_keputusan'] == 'PERUBAHAN') ? 'V' : '' ?>
                </td>
                <td style="text-align: center; padding: 4px;">
                    <?= (isset($f['pejabat_keputusan']) && $f['pejabat_keputusan'] == 'DITANGGUHKAN') ? 'V' : '' ?>
                </td>
                <td style="text-align: center; padding: 4px;">
                    <?= (isset($f['pejabat_keputusan']) && $f['pejabat_keputusan'] == 'TIDAK DISETUJUI') ? 'V' : '' ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border: none; padding: 8px; vertical-align: top;">
                    <div style="font-size: 9pt; line-height: 1.4;">
                        Catatan:<br>
                        * &nbsp;&nbsp;Coret yang tidak perlu<br>
                        ** &nbsp;Pilih salah satu dengan memberi tanda centang (V)<br>
                        *** diisi oleh pejabat yang menangani bidang<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;kepegawaian sebelum PNS mengajukan cuti<br>
                        **** diberi tanda centang dan alasannya...<br>
                        <br>
                        N&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;= Cuti tahun berjalan<br>
                        N-1 = Sisa cuti 1 tahun sebelumnya<br>
                        N-2 = Sisa cuti 2 tahun sebelumnya
                    </div>
                </td>
                <td style="text-align: center; vertical-align: middle; padding: 8px;">
                    KEPUTUSAN PEJABAT YANG<br>
                    BERWENANG MEMBERIKAN CUTI<br>
                    DIREKTUR RSUD dr. SOERATNO GEMOLONG<br>
                    KABUPATEN GEMOLONG<br><br><br><br>
                    
                    <?php if (!empty($f['nama_pejabat'])): ?>
                        <u><?= strtoupper($f['nama_pejabat']) ?></u><br>
                        <?php if (!empty($f['nip_pejabat'])): ?>
                            NIP. <?= $f['nip_pejabat'] ?>
                        <?php endif; ?>
                    <?php else: ?>
                        <u>dr. KINIK DARSONO, M.Pd.Ked.</u><br>
                        NIP. 19710415 200903 1 001
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>