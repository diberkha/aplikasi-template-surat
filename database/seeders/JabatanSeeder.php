<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jabatans = [
            "Direktur",
            "Kepala Bidang Pelayanan dan Penunjang",
            "Kepala Bidang Pengembangan dan Informasi",
            "Kepala Seksi Pelayanan Medis dan Penunjang Medis",
            "Kepala Seksi Pengembangan Kerjasama dan Diklat",
            "Kepala Seksi Informasi dan Pemasaran",
            "Kepala Seksi Keperawatan dan Penunjang Non Medis",
            "Kepala Sub Bagian Perencanaan, Evaluasi dan Pelaporan",
            "Kepala Sub Bagian Umum dan Kepegawaian",
            "Kepala Sub Bagian Keuangan",
            "Dokter",
            "Dokter Umum",
            "Dokter Pertama",
            "Dokter Muda",
            "Dokter Madya",
            "Perawat Ahli Pertama",
            "Perawat Ahli Muda",
            "Perawat Mahir",
            "Perawat Penyelia",
            "Perawat Terampil",
            "Perawat Gigi Penyelia",
            "Perawat Gigi Terampil",
            "Bidan Ahli Pertama",
            "Bidan Mahir",
            "Bidan Penyelia",
            "Bidan Terampil",
            "Apoteker Ahli Pertama",
            "Apoteker Ahli Madya",
            "Asisten Apoteker Penyelia",
            "Asisten Apoteker Pelaksana",
            "Asisten Apoteker Pelaksana Lanjutan",
            "Nutrisionis Madya",
            "Nutrisionis Pelaksana Lanjutan",
            "Sanitarian Muda",
            "Sanitarian Pelaksana",
            "Sanitarian Pelaksana Lanjutan",
            "Epidemiolog Kesehatan Ahli Pertama",
            "Radiografer Pelaksana",
            "Radiografer Pelaksana Lanjutan",
            "Radiografer Muda",
            "Fisioterapis Muda",
            "Fisioterapis Pelaksana Lanjutan",
            "Teknisi Elektromedis Terampil",
            "Teknisi Elektromedis Mahir",
            "Teknisi Elektromedis Penyelia",
            "Pranata Lab. Kes. Penyelia",
            "Pranata Lab. Kes. Pelaksana",
            "Pranata Lab. Kes. Pelaksana Lanjutan",
            "Perekam Medis Muda",
            "Perekam Medis Pelaksana",
            "Perekam Medis Pelaksana Lanjutan",
            "Pranata Komputer Terampil",
            "Pranata Komputer Ahli Muda",
            "Pengadministrasi Umum",
            "Penyusun Laporan Keuangan"
        ];

        foreach ($jabatans as $jabatan) {
            \App\Models\Jabatan::firstOrCreate(['nama_jabatan' => $jabatan]);
        }
    }
}
