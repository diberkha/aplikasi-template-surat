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
        td { 
            border: 1px solid #000; 
            padding: 1px 2px; 
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
            font-size: 10pt;
        }
        .header-right {
            font-size: 10pt;
            line-height: 1.4;
            text-align: left;
        }
    </style>
</head>
<body>
    <?php 
        $f = $data['form'] ?? [];
        
        function formatTanggalIndonesia($tanggal) {
            if (empty($tanggal)) return '';
            
            $namaHari = array(
                0 => 'Minggu', 1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 
                4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu'
            );

            $bulan = array(
                1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            );
            
            $timestamp = strtotime($tanggal);
            $hariKe = date('w', $timestamp);
            $hari = date('d', $timestamp);
            $bulanAngka = date('n', $timestamp);
            $tahun = date('Y', $timestamp);
            
            return $hari . ' ' . $bulan[$bulanAngka] . ' ' . $tahun;
        }
    ?>
    
    <div class="container">
        <!-- Header -->
        <table class="no-border">
            <tr class="no-border">
                <td style="width: 52%"></td>
                <td style="width: 48%" class="header-right">
                    ANAK LAMPIRAN 1.b<br>
                    PERATURAN BADAN KEPEGAWAIAN NEGARA REPUBLIK INDONESIA NOMOR 24 TAHUN 2017<br>
                    TENTANG<br>
                    TATA CARA PEMBERIAN CUTI PEGAWAI NEGERI SIPIL<br><br>
                    <?= $f['tempat_surat'] ?? 'Sragen' ?>, <?= isset($f['tanggal_surat']) ? formatTanggalIndonesia($f['tanggal_surat']) : '.......................' ?><br>
                    kepada :<br>
                    Yth. Direktur RSUD dr. Soeratno Gemolong<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kabupaten Sragen<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;di-<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SRAGEN
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
                <td colspan="4" class="section-header">II. JENIS CUTI YANG DIAMBIL**</td>
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
                <td style="width: 1.5in;">Keterangan</td>
                <td>3. CUTI SAKIT</td>
                <td class="center">
                    <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Sakit') ? 'V' : '' ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: left;">N-2</td>
                <td style="text-align: left;"><?= $f['catatan_n2'] ?? '' ?></td>
                <td style="text-align: left;"><?= $f['catatan_n2_keterangan'] ?? '' ?></td>
                <td>4. CUTI MELAHIRKAN</td>
                <td class="center">
                    <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Melahirkan') ? 'V' : '' ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: left;">N-1</td>
                <td style="text-align: left;"><?= $f['catatan_n1'] ?? '' ?></td>
                <td style="text-align: left;"><?= $f['catatan_n1_keterangan'] ?? '' ?></td>
                <td>5. CUTI KARENA ALASAN PENTING</td>
                <td class="center">
                    <?= (isset($f['jenis_cuti']) && $f['jenis_cuti'] == 'Cuti Karena Alasan Penting') ? 'V' : '' ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: left;">N</td>
                <td style="text-align: left;"><?= $f['catatan_n'] ?? '' ?></td>
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
                <td style="width: 55%; vertical-align: top;">
                    <?= nl2br($f['alamat'] ?? '') ?>
                </td>
                <td style="width: 15%; vertical-align: top;">TELP</td>
                <td style="width: 30%; vertical-align: top;"><?= $f['telp'] ?? '' ?></td>
            </tr>
            <tr>
                <td style="width: 45%; vertical-align: top;"></td>
                <td colspan="2" style="text-align: center; vertical-align: bottom; padding-bottom: 8px;">
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
                <td style="text-align: center; vertical-align: middle; height: 100px;">
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
                            <td style="padding: 1px;">diisi oleh pejabat yang menangani bidang kepegawaian sebelum PNS mengajukan cuti</td>
                        </tr>
                        <tr>
                            <td style="width: 15px; padding: 1px;">****</td>
                            <td style="padding: 1px;">diberi tanda centang dan alasannya...</td>
                        </tr>
                        <tr>
                            <td style="width: 15px; padding: 1px;">N</td>
                            <td style="padding: 1px;">= Cuti tahun berjalan</td>
                        </tr>
                        <tr>
                            <td style="width: 15px; padding: 1px;">N-1</td>
                            <td style="padding: 1px;">= Sisa cuti 1 tahun sebelumnya</td>
                        </tr>
                        <tr>
                            <td style="width: 15px; padding: 1px;">N-2</td>
                            <td style="padding: 1px;">= Sisa cuti 2 tahun sebelumnya</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center; vertical-align: middle;">
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
                        <u>Dr. dr. KINIK DARSONO, M.Pd.Ked.</u><br>
                        NIP. 19710415 200903 1 001
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>