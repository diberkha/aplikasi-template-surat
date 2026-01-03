<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use Carbon\Carbon;

class PegawaiSeeder extends Seeder
{
    public function run()
    {
        Pegawai::truncate();

        /**
         * =====================
         * PNS
         * =====================
         */
        Pegawai::create([
            'nama' => 'Dr. dr. Kinik Darsono, M.Pd.Ked.',
            'nip' => '197104152009031001',
            'jenis_pegawai' => 'PNS',
            'jabatan' => 'Direktur',
            'tanggal_masuk' => Carbon::create(2009, 3, 1), 
            'sisa_cuti_tahunan' => 12,
            'sisa_cuti_n' => 12, 'sisa_cuti_n1' => 6, 'sisa_cuti_n2' => 0,
        ]);

        Pegawai::create([
            'nama' => 'dr. Budi Santosa, Sp.PD., FINASIM',
            'nip' => '197508202005011005',
            'jenis_pegawai' => 'PNS',
            'jabatan' => 'Dokter Spesialis Penyakit Dalam',
            'tanggal_masuk' => Carbon::create(2005, 1, 1),
            'sisa_cuti_tahunan' => 12,
            'sisa_cuti_n' => 12, 'sisa_cuti_n1' => 12, 'sisa_cuti_n2' => 6,
        ]);

        Pegawai::create([
            'nama' => 'Hj. Siti Aminah, S.Kep., Ns., M.Kes.',
            'nip' => '198002152003122003',
            'jenis_pegawai' => 'PNS',
            'jabatan' => 'Kepala Bidang Keperawatan',
            'tanggal_masuk' => Carbon::create(2003, 12, 1),
            'sisa_cuti_tahunan' => 12,
            'sisa_cuti_n' => 12, 'sisa_cuti_n1' => 0, 'sisa_cuti_n2' => 0,
        ]);

        Pegawai::create([
            'nama' => 'Drs. H. Ahmad Wijaya, M.M.',
            'nip' => '197806102006041002',
            'jenis_pegawai' => 'PNS',
            'jabatan' => 'Kepala Bagian Tata Usaha',
            'tanggal_masuk' => Carbon::create(2006, 4, 1),
            'sisa_cuti_tahunan' => 9,
            'sisa_cuti_n' => 9, 'sisa_cuti_n1' => 3, 'sisa_cuti_n2' => 0,
        ]);
        
        Pegawai::create([
            'nama' => 'Andi Prasetyo, S.Kom',
            'nip' => '199005102019031004',
            'jenis_pegawai' => 'PNS',
            'jabatan' => 'Pranata Komputer Ahli Pertama',
            'tanggal_masuk' => Carbon::create(2019, 3, 1),
            'sisa_cuti_tahunan' => 6,
            'sisa_cuti_n' => 6, 'sisa_cuti_n1' => 0, 'sisa_cuti_n2' => 0,
        ]);

        Pegawai::create([
            'nama' => 'Rina Wulandari, A.Md.Keb.',
            'nip' => '199511152020122005',
            'jenis_pegawai' => 'PNS',
            'jabatan' => 'Bidan Pelaksana',
            'tanggal_masuk' => Carbon::create(2020, 12, 1),
            'sisa_cuti_tahunan' => 12,
            'sisa_cuti_n' => 12, 'sisa_cuti_n1' => 0, 'sisa_cuti_n2' => 0,
        ]);

        Pegawai::create([
            'nama' => 'Bambang Suryono, S.E.',
            'nip' => '198807222014021003',
            'jenis_pegawai' => 'PNS',
            'jabatan' => 'Bendahara Pengeluaran',
            'tanggal_masuk' => Carbon::create(2014, 2, 1),
            'sisa_cuti_tahunan' => 0,
            'sisa_cuti_n' => 0, 'sisa_cuti_n1' => 0, 'sisa_cuti_n2' => 0,
        ]);

        /**
         * =====================
         * PPPK 
         * =====================
         */
        Pegawai::create([
            'nama' => 'Ns. Ratna Sari, S.Kep.',
            'nip' => '199203102022212001',
            'jenis_pegawai' => 'PPPK',
            'jabatan' => 'Perawat Ahli Pertama',
            'tanggal_masuk' => Carbon::create(2022, 1, 1),
            'sisa_cuti_tahunan' => 12,
            'sisa_cuti_n' => 12, 'sisa_cuti_n1' => 0, 'sisa_cuti_n2' => 0,
        ]);

        Pegawai::create([
            'nama' => 'Eko Prasetyo, A.Md.Rad.',
            'nip' => '199408152023211002',
            'jenis_pegawai' => 'PPPK',
            'jabatan' => 'Radiografer',
            'tanggal_masuk' => Carbon::create(2023, 3, 1),
            'sisa_cuti_tahunan' => 12,
            'sisa_cuti_n' => 12, 'sisa_cuti_n1' => 0, 'sisa_cuti_n2' => 0,
        ]);

        Pegawai::create([
            'nama' => 'Dewi Sartika, S.Farm., Apt.',
            'nip' => '199105202022212003',
            'jenis_pegawai' => 'PPPK',
            'jabatan' => 'Apoteker',
            'tanggal_masuk' => Carbon::create(2022, 5, 1),
            'sisa_cuti_tahunan' => 5,
            'sisa_cuti_n' => 5, 'sisa_cuti_n1' => 0, 'sisa_cuti_n2' => 0,
        ]);

        /**
         * =====================
         * NON ASN 
         * =====================
         */
        Pegawai::create([
            'nama' => 'Joko Susilio',
            'nip' => null, 
            'jenis_pegawai' => 'NON ASN',
            'jabatan' => 'Petugas Keamanan',
            'tanggal_masuk' => Carbon::now()->subYears(5),
            'sisa_cuti_tahunan' => 12,
            'sisa_cuti_n' => 12, 'sisa_cuti_n1' => 0, 'sisa_cuti_n2' => 0,
        ]);

        Pegawai::create([
            'nama' => 'Sri Wahyuni, A.Md.',
            'nip' => null,
            'jenis_pegawai' => 'NON ASN',
            'jabatan' => 'Staf Administrasi',
            'tanggal_masuk' => Carbon::now()->subYears(3),
            'sisa_cuti_tahunan' => 6,
            'sisa_cuti_n' => 6, 'sisa_cuti_n1' => 0, 'sisa_cuti_n2' => 0,
        ]);

        Pegawai::create([
            'nama' => 'Agus Setiawan',
            'nip' => null,
            'jenis_pegawai' => 'NON ASN',
            'jabatan' => 'Driver',
            'tanggal_masuk' => Carbon::now()->subMonths(10), 
            'sisa_cuti_tahunan' => 0, 
            'sisa_cuti_n' => 0, 'sisa_cuti_n1' => 0, 'sisa_cuti_n2' => 0,
        ]);
        
        Pegawai::create([
            'nama' => 'Lestari Indah, S.E.',
            'nip' => null,
            'jenis_pegawai' => 'NON ASN',
            'jabatan' => 'Staf Keuangan',
            'tanggal_masuk' => Carbon::now()->subYears(8), 
            'sisa_cuti_tahunan' => 12, 
            'sisa_cuti_n' => 12, 'sisa_cuti_n1' => 0, 'sisa_cuti_n2' => 0,
        ]);
    }
}
