<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        @page { 
            margin: 1.5cm; 
        }
        body { 
            font-family: 'Times New Roman', serif; 
            font-size: 11pt; 
            line-height: 1.3;
            margin: 0;
            padding: 0;
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
            font-size: 11pt;
        }
        .no-border, .no-border td { 
            border: none !important; 
        }
        .section-header { 
            font-weight: bold; 
            background-color: #f0f0f0;
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
        .center { 
            text-align: center; 
        }
        .right { 
            text-align: right; 
        }
        .left {
            text-align: left;
        }
        .bold { 
            font-weight: bold; 
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
        .signature-section {
            min-height: 100px;
        }
        .signature-box {
            text-align: center;
            margin-top: 30px;
        }
        .catatan-section {
            font-size: 10pt;
            line-height: 1.4;
        }
        .form-title {
            font-weight: bold;
            text-align: center;
            margin: 15px 0;
            font-size: 12pt;
        }
        .header-right {
            font-size: 10pt;
            line-height: 1.4;
        }
        .alamat-row td {
            height: 80px;
            vertical-align: top;
        }
        .checkbox-cell {
            text-align: center;
            padding: 8px 4px !important;
        }
        .keputusan-cell {
            height: 120px;
            vertical-align: top;
        }
    </style>
</head>
<body>
    <?php $f = $data['form'] ?? []; ?>
    
    <div class="container">
        <!-- Header dengan tabel tanpa border -->
        <table class="no-border">
            <tr class="no-border">
                <td style="width: 60%"></td>
                <td style="width: 40%" class="right header-right">
                    ANAK LAMPIRAN I b<br>
                    PERATURAN BADAN KEPEGAWAIAN NEGARA<br>
                    REPUBLIK INDONESIA NOMOR 24 TAHUN 2017<br>
                    TENTANG<br>
                    TATA CARA PEMBERIAN CUTI PEGAWAI NEGERI SIPIL<br>
                    <br>
                    .......................<br>
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
                <td style="width: 33%">1. Cuti Tahunan</td>
                <td style="width: 33%">2. Cuti Besar</td>
                <td style="width: 34%" colspan="2">3. Cuti Sakit</td>
            </tr>
            <tr>
                <td>4. Cuti Melahirkan</td>
                <td>5. Cuti Karena Alasan Penting</td>
                <td colspan="2">6. Cuti di Luar Tanggungan Negara</td>
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
                <td colspan="3" class="section-header">IV. LAMANYA CUTI</td>
            </tr>
            <tr>
                <td style="width: 15%">Selama</td>
                <td style="width: 35%"><?= $f['lama_cuti'] ?? '' ?> hari</td>
                <td style="width: 50%">
                    mulai tanggal <?= isset($f['mulai']) ? date('d-m-Y', strtotime($f['mulai'])) : '' ?> 
                    s/d <?= isset($f['sampai']) ? date('d-m-Y', strtotime($f['sampai'])) : '' ?>
                </td>
            </tr>
        </table>

        <!-- V. CATATAN CUTI -->
        <table>
            <tr>
                <td colspan="3" class="section-header">V. CATATAN CUTI***</td>
            </tr>
            <tr>
                <td style="width: 33%" class="vertical-top">
                    <table class="inner-table">
                        <tr>
                            <td colspan="2" class="bold">1. CUTI TAHUNAN</td>
                        </tr>
                        <tr>
                            <td style="width: 40%"><strong>Tahun</strong></td>
                            <td style="width: 60%">
                                <table class="inner-table">
                                    <tr>
                                        <td style="width: 50%"><strong>Sisa</strong></td>
                                        <td style="width: 50%"><strong>Keterangan</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>N-2</td>
                            <td><?= $f['catatan_n2'] ?? '' ?></td>
                        </tr>
                        <tr>
                            <td>N-1</td>
                            <td><?= $f['catatan_n1'] ?? '' ?></td>
                        </tr>
                        <tr>
                            <td>N</td>
                            <td><?= $f['catatan_n'] ?? '' ?></td>
                        </tr>
                    </table>
                </td>
                <td style="width: 33%" class="vertical-top">
                    <table class="inner-table">
                        <tr>
                            <td class="bold">2. CUTI BESAR</td>
                        </tr>
                        <tr>
                            <td style="height: 60px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="bold">3. CUTI SAKIT</td>
                        </tr>
                        <tr>
                            <td style="height: 40px;">&nbsp;</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 34%" class="vertical-top">
                    <table class="inner-table">
                        <tr>
                            <td class="bold">4. CUTI MELAHIRKAN</td>
                        </tr>
                        <tr>
                            <td style="height: 40px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="bold">5. CUTI KARENA ALASAN PENTING</td>
                        </tr>
                        <tr>
                            <td style="height: 40px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="bold">6. CUTI DI LUAR TANGGUNGAN NEGARA</td>
                        </tr>
                        <tr>
                            <td style="height: 20px;">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- VI. ALAMAT SELAMA MENJALANKAN CUTI -->
        <table>
            <tr>
                <td colspan="2" class="section-header">VI. ALAMAT SELAMA MENJALANKAN CUTI :</td>
            </tr>
            <tr class="alamat-row">
                <td style="width: 70%; padding: 8px; vertical-align: top;">
                    <?= nl2br($f['alamat'] ?? '') ?>
                </td>
                <td style="width: 30%; text-align: center; vertical-align: middle;">
                    <strong>TELP</strong><br>
                    <?= $f['telp'] ?? '' ?><br><br><br>
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
                <td style="width: 25%" class="checkbox-cell">
                    <?= (isset($f['atasan_setuju']) && $f['atasan_setuju'] == 'DISETUJUI') ? '✓' : '☐' ?><br>
                    DISETUJUI
                </td>
                <td style="width: 25%" class="checkbox-cell">
                    <?= (isset($f['atasan_setuju']) && $f['atasan_setuju'] == 'PERUBAHAN') ? '✓' : '☐' ?><br>
                    PERUBAHAN****
                </td>
                <td style="width: 25%" class="checkbox-cell">
                    <?= (isset($f['atasan_setuju']) && $f['atasan_setuju'] == 'DITANGGUHKAN') ? '✓' : '☐' ?><br>
                    DITANGGUHKAN****
                </td>
                <td style="width: 25%" class="checkbox-cell">
                    <?= (isset($f['atasan_setuju']) && $f['atasan_setuju'] == 'TIDAK DISETUJUI') ? '✓' : '☐' ?><br>
                    TIDAK DISETUJUI****
                </td>
            </tr>
            <tr>
                <td colspan="4" class="keputusan-cell">
                    <div class="signature-box">
                        <?php if (!empty($f['jabatan_atasan'])): ?>
                            <?= $f['jabatan_atasan'] ?><br><br><br><br>
                        <?php else: ?>
                            KEPALA SEKSI KEPERAWATAN DAN PENUNJANG NON MEDIS<br><br><br><br>
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
                    </div>
                </td>
            </tr>
        </table>

        <!-- VIII. KEPUTUSAN PEJABAT YANG BERWENANG -->
        <table>
            <tr>
                <td colspan="4" class="section-header">VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI**</td>
            </tr>
            <tr>
                <td style="width: 25%" class="checkbox-cell">
                    <?= (isset($f['pejabat_keputusan']) && $f['pejabat_keputusan'] == 'DISETUJUI') ? '✓' : '☐' ?><br>
                    DISETUJUI
                </td>
                <td style="width: 25%" class="checkbox-cell">
                    <?= (isset($f['pejabat_keputusan']) && $f['pejabat_keputusan'] == 'PERUBAHAN') ? '✓' : '☐' ?><br>
                    PERUBAHAN****
                </td>
                <td style="width: 25%" class="checkbox-cell">
                    <?= (isset($f['pejabat_keputusan']) && $f['pejabat_keputusan'] == 'DITANGGUHKAN') ? '✓' : '☐' ?><br>
                    DITANGGUHKAN****
                </td>
                <td style="width: 25%" class="checkbox-cell">
                    <?= (isset($f['pejabat_keputusan']) && $f['pejabat_keputusan'] == 'TIDAK DISETUJUI') ? '✓' : '☐' ?><br>
                    TIDAK DISETUJUI****
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <div style="display: flex; min-height: 150px;">
                        <div style="width: 50%; padding-right: 10px;" class="catatan-section">
                            <div class="bold">Catatan:</div>
                            <div>* &nbsp;&nbsp;Coret yang tidak perlu</div>
                            <div>** &nbsp;Pilih salah satu dengan memberi tanda centang (V)</div>
                            <div>*** diisi oleh pejabat yang menangani bidang</div>
                            <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;kepegawaian sebelum PNS mengajukan cuti</div>
                            <div>**** diberi tanda centang dan alasannya...</div>
                            <div style="margin-top: 10px;">
                                N&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;= Cuti tahun berjalan<br>
                                N-1 = Sisa cuti 1 tahun sebelumnya<br>
                                N-2 = Sisa cuti 2 tahun sebelumnya
                            </div>
                        </div>
                        <div style="width: 50%; text-align: center;" class="signature-box">
                            <div class="bold">
                                KEPUTUSAN PEJABAT YANG<br>
                                BERWENANG MEMBERIKAN CUTI<br>
                                DIREKTUR RSUD dr. SOERATNO GEMOLONG<br>
                                KABUPATEN GEMOLONG<br><br><br><br>
                            </div>
                            
                            <?php if (!empty($f['nama_pejabat'])): ?>
                                <u><?= strtoupper($f['nama_pejabat']) ?></u><br>
                                <?php if (!empty($f['nip_pejabat'])): ?>
                                    NIP. <?= $f['nip_pejabat'] ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <u>dr. KINIK DARSONO, M.Pd.Ked.</u><br>
                                NIP. 19710415 200903 1 001
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>