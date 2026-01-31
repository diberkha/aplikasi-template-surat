-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 31, 2026 at 02:34 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-office`
--

-- --------------------------------------------------------

--
-- Table structure for table `cuti_bersama`
--

CREATE TABLE `cuti_bersama` (
  `id` bigint UNSIGNED NOT NULL,
  `jenis_cuti_bersama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` year NOT NULL,
  `jumlah_hari` int NOT NULL,
  `is_perhitungan_cuti_tahunan` tinyint(1) NOT NULL DEFAULT '1',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jabatans`
--

CREATE TABLE `jabatans` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jabatans`
--

INSERT INTO `jabatans` (`id`, `nama_jabatan`, `created_at`, `updated_at`) VALUES
(1, 'Direktur', '2026-01-31 14:32:36', '2026-01-31 14:32:36'),
(2, 'Kepala Bidang Pelayanan dan Penunjang', '2026-01-31 14:32:36', '2026-01-31 14:32:36'),
(3, 'Kepala Bidang Pengembangan dan Informasi', '2026-01-31 14:32:36', '2026-01-31 14:32:36'),
(4, 'Kepala Seksi Pelayanan Medis dan Penunjang Medis', '2026-01-31 14:32:36', '2026-01-31 14:32:36'),
(5, 'Kepala Seksi Pengembangan Kerjasama dan Diklat', '2026-01-31 14:32:36', '2026-01-31 14:32:36'),
(6, 'Kepala Seksi Informasi dan Pemasaran', '2026-01-31 14:32:36', '2026-01-31 14:32:36'),
(7, 'Kepala Seksi Keperawatan dan Penunjang Non Medis', '2026-01-31 14:32:36', '2026-01-31 14:32:36'),
(8, 'Kepala Sub Bagian Perencanaan, Evaluasi dan Pelaporan', '2026-01-31 14:32:36', '2026-01-31 14:32:36'),
(9, 'Kepala Sub Bagian Umum dan Kepegawaian', '2026-01-31 14:32:36', '2026-01-31 14:32:36'),
(10, 'Kepala Sub Bagian Keuangan', '2026-01-31 14:32:36', '2026-01-31 14:32:36'),
(11, 'Dokter', '2026-01-31 14:32:36', '2026-01-31 14:32:36'),
(12, 'Dokter Umum', '2026-01-31 14:32:36', '2026-01-31 14:32:36'),
(13, 'Dokter Pertama', '2026-01-31 14:32:36', '2026-01-31 14:32:36'),
(14, 'Dokter Muda', '2026-01-31 14:32:36', '2026-01-31 14:32:36'),
(15, 'Dokter Madya', '2026-01-31 14:32:36', '2026-01-31 14:32:36'),
(16, 'Perawat Ahli Pertama', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(17, 'Perawat Ahli Muda', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(18, 'Perawat Mahir', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(19, 'Perawat Penyelia', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(20, 'Perawat Terampil', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(21, 'Perawat Gigi Penyelia', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(22, 'Perawat Gigi Terampil', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(23, 'Bidan Ahli Pertama', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(24, 'Bidan Mahir', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(25, 'Bidan Penyelia', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(26, 'Bidan Terampil', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(27, 'Apoteker Ahli Pertama', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(28, 'Apoteker Ahli Madya', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(29, 'Asisten Apoteker Penyelia', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(30, 'Asisten Apoteker Pelaksana', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(31, 'Asisten Apoteker Pelaksana Lanjutan', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(32, 'Nutrisionis Madya', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(33, 'Nutrisionis Pelaksana Lanjutan', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(34, 'Sanitarian Muda', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(35, 'Sanitarian Pelaksana', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(36, 'Sanitarian Pelaksana Lanjutan', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(37, 'Epidemiolog Kesehatan Ahli Pertama', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(38, 'Radiografer Pelaksana', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(39, 'Radiografer Pelaksana Lanjutan', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(40, 'Radiografer Muda', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(41, 'Fisioterapis Muda', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(42, 'Fisioterapis Pelaksana Lanjutan', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(43, 'Teknisi Elektromedis Terampil', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(44, 'Teknisi Elektromedis Mahir', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(45, 'Teknisi Elektromedis Penyelia', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(46, 'Pranata Lab. Kes. Penyelia', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(47, 'Pranata Lab. Kes. Pelaksana', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(48, 'Pranata Lab. Kes. Pelaksana Lanjutan', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(49, 'Perekam Medis Muda', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(50, 'Perekam Medis Pelaksana', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(51, 'Perekam Medis Pelaksana Lanjutan', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(52, 'Pranata Komputer Terampil', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(53, 'Pranata Komputer Ahli Muda', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(54, 'Pengadministrasi Umum', '2026-01-31 14:32:37', '2026-01-31 14:32:37'),
(55, 'Penyusun Laporan Keuangan', '2026-01-31 14:32:37', '2026-01-31 14:32:37');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_01_01_000000_create_all_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pegawais`
--

CREATE TABLE `pegawais` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PNS',
  `masa_kerja` date NOT NULL,
  `sisa_cuti_tahunan` int NOT NULL DEFAULT '12',
  `sisa_cuti_n` int NOT NULL DEFAULT '12',
  `sisa_cuti_n1` int NOT NULL DEFAULT '0',
  `sisa_cuti_n2` int NOT NULL DEFAULT '0',
  `is_n_postponed` tinyint(1) NOT NULL DEFAULT '0',
  `is_n1_postponed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pegawais`
--

INSERT INTO `pegawais` (`id`, `nama`, `nip`, `jabatan`, `jenis_pegawai`, `masa_kerja`, `sisa_cuti_tahunan`, `sisa_cuti_n`, `sisa_cuti_n1`, `sisa_cuti_n2`, `is_n_postponed`, `is_n1_postponed`, `created_at`, `updated_at`) VALUES
(1, 'Aris Prihantoro', NULL, 'Administrasi', 'NON ASN', '2011-03-07', 12, 12, 0, 0, 0, 0, NULL, NULL),
(2, 'Aris Wijanarko', NULL, 'Perawat', 'NON ASN', '2011-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(3, 'BAGAS PRASETYO, A.Md.SI.', NULL, 'Administrasi', 'NON ASN', '2020-01-14', 12, 12, 0, 0, 0, 0, NULL, NULL),
(4, 'Bagus Riyadi', NULL, 'Staff IT', 'NON ASN', '2018-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(5, 'Bendung Santoso', NULL, 'Administrasi', 'NON ASN', '2019-10-14', 12, 12, 0, 0, 0, 0, NULL, NULL),
(6, 'Candra Asruria', NULL, 'Staff Kebersihan', 'NON ASN', '2013-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(7, 'DARTI', NULL, 'Administrasi', 'NON ASN', '2008-03-05', 12, 12, 0, 0, 0, 0, NULL, NULL),
(8, 'Devi Novitasari, SE', NULL, 'Administrasi', 'NON ASN', '2019-07-08', 12, 12, 0, 0, 0, 0, NULL, NULL),
(9, 'dr.YOSSI REZA GIMAWAN', NULL, '', 'NON ASN', '2021-03-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(10, 'Dwi Astuti Handayani', NULL, 'Administrasi', 'NON ASN', '2020-02-10', 12, 12, 0, 0, 0, 0, NULL, NULL),
(11, 'Eka Widiyana Puspitasari, A.Md', NULL, 'Administrasi', 'NON ASN', '2011-01-05', 12, 12, 0, 0, 0, 0, NULL, NULL),
(12, 'Else Julfani Desti', NULL, 'Administrasi', 'NON ASN', '2018-09-10', 12, 12, 0, 0, 0, 0, NULL, NULL),
(13, 'ENI HERMAWATI, SE, MM.', NULL, 'Administrasi', 'NON ASN', '2016-06-07', 12, 12, 0, 0, 0, 0, NULL, NULL),
(14, 'Eny Verryastuti Indriani, A.Md.Keb', NULL, 'Bidan', 'NON ASN', '2019-08-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(15, 'Erna Andriyani, Amd.Keb', NULL, 'Bidan', 'NON ASN', '2017-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(16, 'FENI RAHMAWATI', NULL, 'Administrasi', 'NON ASN', '2019-07-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(17, 'HANDOKO BUDI SANTOSO', NULL, 'Administrasi', 'NON ASN', '2014-05-05', 12, 12, 0, 0, 0, 0, NULL, NULL),
(18, 'HENI HERAWATI SE', NULL, 'Administrasi', 'NON ASN', '2010-03-12', 12, 12, 0, 0, 0, 0, NULL, NULL),
(19, 'HERI PURNAMA', NULL, 'Staff IPSRS', 'NON ASN', '2011-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(20, 'HERVI HILDA JUNISTIAN, A.Md.Keb', NULL, 'Bidan', 'NON ASN', '2015-05-05', 12, 12, 0, 0, 0, 0, NULL, NULL),
(21, 'IKA DIYASTUTI, SH', NULL, 'Administrasi', 'NON ASN', '2011-09-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(22, 'IKA PURNAMASARI, Amd.Keb', NULL, 'Bidan', 'NON ASN', '2015-07-29', 12, 12, 0, 0, 0, 0, NULL, NULL),
(23, 'INDRIYANI', NULL, 'Perawat', 'NON ASN', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(24, 'ISNAINY FUTIKHAT JANNAH Amd.Kom', NULL, 'Administrasi', 'NON ASN', '2013-06-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(25, 'Ita Rahayu Aprilia AMd,keb', NULL, 'Bidan', 'NON ASN', '2017-03-23', 12, 12, 0, 0, 0, 0, NULL, NULL),
(26, 'Joko Prayitno', NULL, 'Administrasi', 'NON ASN', '2013-01-07', 12, 12, 0, 0, 0, 0, NULL, NULL),
(27, 'JULIARTO,S.Kom', NULL, 'Staff IT', 'NON ASN', '2011-02-28', 12, 12, 0, 0, 0, 0, NULL, NULL),
(28, 'Kadek Cici Puspitasari, Am.d', NULL, '', 'NON ASN', '2011-02-14', 12, 12, 0, 0, 0, 0, NULL, NULL),
(29, 'Lina Retno Widi Andayani, A.Md', NULL, 'Administrasi', 'NON ASN', '2014-04-21', 12, 12, 0, 0, 0, 0, NULL, NULL),
(30, 'Mega Oktavia, Amd.Keb', NULL, 'Bidan', 'NON ASN', '1994-10-02', 12, 12, 0, 0, 0, 0, NULL, NULL),
(31, 'MUHAMMAD THOUFIQ ABDULLAH,A.Md.Kep', NULL, 'Perawat', 'NON ASN', '2020-08-25', 12, 12, 0, 0, 0, 0, NULL, NULL),
(32, 'Nova Lusiana, AMd. Keb', NULL, 'Bidan', 'NON ASN', '2013-11-19', 12, 12, 0, 0, 0, 0, NULL, NULL),
(33, 'Novia Nur Handayani, A.Md.Kep', NULL, 'Perawat', 'NON ASN', '2014-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(34, 'PARTI,Amd.keb', NULL, 'Bidan', 'NON ASN', '2015-02-25', 12, 12, 0, 0, 0, 0, NULL, NULL),
(35, 'Paryoto', NULL, 'Perawat', 'NON ASN', '2010-03-08', 12, 12, 0, 0, 0, 0, NULL, NULL),
(36, 'Putri Herning Hermawati , AMd.Keb', NULL, 'Perawat', 'NON ASN', '2019-02-19', 12, 12, 0, 0, 0, 0, NULL, NULL),
(37, 'Reka Ambar Julita Saputri, Amd.Kes', NULL, 'Administrasi', 'NON ASN', '2018-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(38, 'Retno Wulandari', NULL, 'Administrasi', 'NON ASN', '2019-06-24', 12, 12, 0, 0, 0, 0, NULL, NULL),
(39, 'RYZMA WULAN UTAMI, AMd.Keb', NULL, 'Bidan', 'NON ASN', '2017-08-21', 12, 12, 0, 0, 0, 0, NULL, NULL),
(40, 'Sri Widodo', NULL, 'Administrasi', 'NON ASN', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(41, 'Sumarno', NULL, 'Driver', 'NON ASN', '2010-08-23', 12, 12, 0, 0, 0, 0, NULL, NULL),
(42, 'Supatno Wibowo', NULL, 'Staff Kebersihan', 'NON ASN', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(43, 'SUTARTI', NULL, 'Pramusaji', 'NON ASN', '2019-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(44, 'TARI WIDIASTUTI', NULL, 'Pramusaji', 'NON ASN', '2008-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(45, 'Tri Wijayanto', NULL, 'Staff IPSRS', 'NON ASN', '2013-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(46, 'Ullin Nuhasari ,Amd.Keb', NULL, 'Bidan', 'NON ASN', '2015-07-26', 12, 12, 0, 0, 0, 0, NULL, NULL),
(47, 'Wiwik Wulandari, AMd.Keb', NULL, 'Perawat', 'NON ASN', '2020-01-04', 12, 12, 0, 0, 0, 0, NULL, NULL),
(48, 'Annisa Febri Kusuma Wardani, A.Md. RMIK', NULL, 'Administrasi', 'NON ASN', '2017-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(49, 'Aziz Nur Rohman', NULL, 'CSSD', 'NON ASN', '2018-01-05', 12, 12, 0, 0, 0, 0, NULL, NULL),
(50, 'CAHYO PONCO NUGROHO', NULL, '', 'NON ASN', '2020-11-10', 12, 12, 0, 0, 0, 0, NULL, NULL),
(51, 'dr.AULIYA ROHMANI', NULL, '', 'NON ASN', '2021-11-22', 12, 12, 0, 0, 0, 0, NULL, NULL),
(52, 'DWI HASTONO', NULL, 'Driver', 'NON ASN', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(53, 'Dwi Indah Wulansari,SE', NULL, 'Perawat', 'NON ASN', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(54, 'EKA RAHMARIM SUCI MANAR., A.Md. Kep', NULL, 'Perawat', 'NON ASN', '2020-04-11', 12, 12, 0, 0, 0, 0, NULL, NULL),
(55, 'HERTA NURJAYANTI', NULL, 'Pramusaji', 'NON ASN', '2021-01-04', 12, 12, 0, 0, 0, 0, NULL, NULL),
(56, 'Nila Fitri Wulandari, A.Md, Keb', NULL, 'Bidan', 'NON ASN', '2017-07-05', 12, 12, 0, 0, 0, 0, NULL, NULL),
(57, 'Riandika Prihantoro', NULL, '', 'NON ASN', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(58, 'Salminah', NULL, 'Pramusaji', 'NON ASN', '2012-05-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(59, 'Sella Elvida Sari, A.Md.Keb', NULL, 'Bidan', 'NON ASN', '2019-10-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(60, 'SUNARSIH', NULL, '', 'NON ASN', '2018-04-08', 12, 12, 12, 0, 0, 0, NULL, NULL),
(61, 'Tri Nuryani, Amd.Keb', NULL, 'Bidan', 'NON ASN', '2017-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(62, 'Vila Hening Qur\'ana, SE', NULL, '', 'NON ASN', '2018-04-09', 12, 12, 0, 0, 0, 0, NULL, NULL),
(63, 'dr. SENO AJI SAPUTRO, Sp. THTKL', NULL, 'Dokter', 'NON ASN', '2022-08-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(64, 'ALESSANDRO JUVE PURBA WIJAYA, A.Md. Kes', NULL, 'Teknologi Bank Darah', 'NON ASN', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(65, 'dr. YUSA AMIN NURHUDA, Sp.J.P', NULL, 'Perawat', 'NON ASN', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(66, 'NURUL LAILI KHOIRUT TABI\'ATIN', NULL, '', 'NON ASN', '2023-02-02', 12, 12, 12, 0, 0, 0, NULL, NULL),
(67, 'dr. HANDIKA ZULIMARTIN, S.PoG', NULL, 'Dokter', 'NON ASN', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(68, 'MUHAMMAD FAHMI IDRIZ', NULL, 'Perawat', 'NON ASN', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(69, 'Yudiyanti Lestari Handayani, AMK', '197802222021212007', 'Perawat Terampil', 'PPPK', '2021-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(70, 'ANIK DIANISTANTI, S.Kep. Ns', '3314036702920004', 'Perawat Ahli Pertama', 'PPPK', '2024-05-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(71, 'BIMA FITRI ANDAYANI DWI KARTIKA Amd', '3314134510740000', 'Kepala Seksi Pelayanan Medis dan Penunjang Medis', 'PPPK', '2001-10-11', 12, 12, 0, 0, 0, 0, NULL, NULL),
(72, 'Novie Prawesti Ningtyas, S.Kep. Ns', '3314097011970004', '', 'PPPK', '2020-10-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(73, 'SEPI SUMYARNI', '3314135102840680', 'Kepala Seksi Pelayanan Medis dan Penunjang Medis', 'PPPK', '2015-02-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(74, 'Sri Lestari Spd', '3314104305820000', 'Kepala Seksi Pelayanan Medis dan Penunjang Medis', 'PPPK', '2001-03-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(75, 'Umi Zainah, AMK', '3314125906850006', '', 'PPPK', '2015-02-25', 12, 12, 0, 0, 0, 0, NULL, NULL),
(76, 'Winarsih, A.Md', '3314036807850046', '', 'PPPK', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(77, 'Mei Candra Satria MJ, A.Md.Rad', '3522030905930001', 'Kepala Sub Bagian Keuangan', 'PPPK', '2020-05-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(78, 'dr. SRI MARTUNJUNG PURUSATAMA.', '198105012023211001', 'Dokter Pertama', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(79, 'dr. ANTONIUS NIRMALA, SpB.', '197808142023211002', 'Dokter Pertama', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(80, 'PUTEH NOER MAHLAWI, S.Kep., Ns.', '198910112023211003', 'Perawat Ahli Pertama', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(81, 'ADILIA TRI PRASETYA, S.Kep., Ns.', '199309182023211002', 'Perawat Ahli Pertama', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(82, 'DIDIT GISTAMA, S.Kep., Ns.', '199309122023211002', 'Perawat Ahli Pertama', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(83, 'YUSTIAN ADI NUGROHO, S.Kep., Ners.', '198807212023211001', 'Perawat Ahli Pertama', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(84, 'ENDAR ROHMAWATI, S.K.M', '199108252023212007', 'Administrator Kesehatan Ahli Pertama', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(85, 'HAFIDZOH NAJWATI, S.K.M.', '199504122023212005', 'Administrator Kesehatan Ahli Pertama', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(86, 'NUR ROHMAWATI, S.K.M.', '199502022023212009', '', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(87, 'IMA FERAWATI MAHMUDAH, A.Md.', '199601262023212003', 'Asisten Apoteker Pelaksana', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(88, 'ROHMAD JATI PRAMONO, A.Md.Farm.', '199504272023211002', '', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(89, 'RATNA FITRIA SUMINAR, A.Md.', '199005052023212008', 'Asisten Apoteker Pelaksana', 'PPPK', '2023-06-17', 12, 12, 0, 0, 0, 0, NULL, NULL),
(90, 'ANJARYATI, A.Md.Farm.', '199607062023212005', 'Asisten Apoteker Pelaksana', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(91, 'AZZHARA CANDRA NUR AULIA, A.Md.Kes.', '199702192023212009', '', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(92, 'BUDIASIH DWIYANTI, A.Md.Kep.', '199401312023212009', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(93, 'ERNA AMBARWATI, A.Md.Kep.', '199502232023212006', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(94, 'AGUNG BUDI NUGROHO, AMK.', '198208212023211001', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(95, 'RISKI UTAMI, AMd.Kep.', '199210092023212006', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(96, 'RIYANTO, A.Md.Kep.', '199402152023211001', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(97, 'FAISHAL DWI PRASTYA, AMK.', '199509022023211003', 'Perawat Terampil', 'PPPK', '2023-06-17', 12, 12, 0, 0, 0, 0, NULL, NULL),
(98, 'RINA PUJI MULYATI, AMK.', '198308142023212005', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(99, 'DIYANA TRI WAHYU WIDIASTUTI, AMK.', '198509102023212003', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(100, 'DINA NUR HIDAYATI, A.Md.Kep.', '199410232023212010', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(101, 'HASTIN NUR AINI, A.Md.Kep.', '199103032023212005', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(102, 'ERLIN SARININGDYAH, A.Md.TW.', '199404242023212012', '', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(103, 'apt. TRIANA DAMAYANTI, S.Farm.', '198110092023212003', 'Apoteker Ahli Pertama', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(104, 'MAULIDA AINURRAHMA, S.Kep., Ns.', '199508052023212005', 'Perawat Ahli Pertama', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(105, 'PARLAN, S.Kep., Ns .', '198012282023211003', 'Perawat Ahli Pertama', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(106, 'UMI ROSIDAH SETYOWATI, S.Kep., Ns.', '198503152023212002', 'Perawat Ahli Pertama', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(107, 'ARIYANTI, S.Kep., Ns.', '198801152023212007', 'Perawat Ahli Pertama', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(108, 'ALLAN MAULANA AZMI, S.Kep., Ns.', '199409042023211002', 'Perawat Ahli Pertama', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(109, 'TITIA KUSUMA WIJAYANTI, S.Tr.Kep., Ns.', '199509092023212005', 'Perawat Ahli Pertama', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(110, 'RAJENDRA PRIMA ARIYANTO, S.KM', '198308152023211003', 'Administrator Kesehatan Ahli Pertama', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(111, 'ANIS SETYANINGSIH, A.Md.Farm.', '199311062023212006', 'Asisten Apoteker Pelaksana', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(112, 'YULIA KUS ARIFAH, A.Md.', '198707112023212008', 'Fisioterapis Pelaksana', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(113, 'BAYU ARIEF HARNAWAN, A.Md.Kep', '199105162023211004', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(114, 'SUTARTI, AMK.', '198304172023212001', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(115, 'UMI ZAINAH, AMK.', '198506192023212002', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(116, 'ENNY SULISTIYORINI, A.Md.Kep.', '199801062023212002', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(117, 'ANITA PUSPITASARI, A.Md.Kep.', '199603222023212010', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(118, 'TITIK SUMARTININGSIH, A.Md.Kep.', '199704022023212002', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(119, 'KRISTI WIDOWATI, AMK.', '198412242023212001', 'Perawat Terampil', 'PPPK', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(120, 'PUJI HASTUTI, AMK.', '198209162023212003', 'Perawat Terampil', 'PPPK', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(121, 'ERNAWATI, AMK.', '198708062023212005', 'Perawat Terampil', 'PPPK', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(122, 'NANI ENDANG KUSNINGSIH, AMK.', '198701202023212002', 'Perawat Terampil', 'PPPK', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(123, 'SURATMI, A.Md.Kep.', '198707282023212004', 'Perawat Terampil', 'PPPK', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(124, 'ENNY WIDIYATSIH, AMK.', '198704282023212004', 'Perawat Terampil', 'PPPK', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(125, 'CATUR SUTRISNO, AMK.', '198301112023211001', 'Perawat Terampil', 'PPPK', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(126, 'GALIH RAKASIWI SURAYA, A.Md.Kep.', '198701192023211002', 'Perawat Terampil', 'PPPK', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(127, 'DEVI SARWANTI, A.Md.Kep', '199212092023212014', 'Perawat Terampil', 'PPPK', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(128, 'HENY WINDARTI, A.Md.Kep.', '199504052028212001', 'Perawat Terampil', 'PPPK', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(129, 'GURUH ADHI PUTRO, A.Md.Kep.', '199510252023211004', '', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(130, 'WINARTI, AMK.', '198307222023212003', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(131, 'ALIFA ALIM AMBARWATI, A.Md.Kep.', '199503142023212005', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(132, 'PUPUT LESTARI, A.Md.Kep.', '199603072023212003', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(133, 'EDGAR LESTYA NALA PRAYA, AMK.', '199504082023211002', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(134, 'ENDANG NARWANTI, A.Md.Kep.', '199611082023212005', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(135, 'PIPIN ZUKHRUF ISTIQOMAH, A.Md.Kep.', '199506072023212006', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(136, 'NUR HIDAYAH, A.Md.Kep.', '199509172023212009', 'Perawat Terampil', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(137, 'FERI NIKE WIJAYANTI, A.Md.RMIK.', '199501072023212008', 'Perekam Medis Pelaksana', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(138, 'SRI WAHYUNI, A.Md.PK.', '198510262023212004', 'Perekam Medis Pelaksana', 'PPPK', '2023-06-17', 12, 12, 0, 0, 0, 0, NULL, NULL),
(139, 'FAJAR RINA, A.Md.Kes.', '199712132023212003', 'Perekam Medis Pelaksana', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(140, 'VIVI ANGGRAINI, A.Md.PK.', '198803042023212002', 'Perekam Medis Pelaksana', 'PPPK', '2023-06-17', 12, 12, 0, 0, 0, 0, NULL, NULL),
(141, 'TRI MULYONO A.Md.RMIK.', '199405032023211003', 'Perekam Medis Pelaksana', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(142, 'ANA LISTIANA, A.Md.', '198312202023212003', '', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(143, 'SABILA ROSYIDA SUJADI, A.Md.A.K.', '199502192023212008', '', 'PPPK', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(144, 'AYU WULANDARI, A.Md.A.K.', '198612192023212007', 'Pranata Laboratorium Kesehatan Pelaksana', 'PPPK', '2018-10-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(145, 'Dr. dr. KINIK DARSONO, M.Pd.Ked.', '197104152009031001', 'Direktur', 'PNS', '2009-03-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(146, 'dr. MAYASARI AYU HENDRAWATI, M.M', '198105172010012026', 'Kepala Bidang Pelayanan dan Penunjang', 'PNS', '2023-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(147, 'IMAS WULANDARI, S.Kom., M.Eng.', '198403302008042003', 'Kepala Bidang Pengembangan dan Informasi', 'PNS', '2008-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(148, 'dr. NOFI KUSUMANINGRUM', '197608282005022003', 'Kepala Seksi Pelayanan Medis dan Penunjang Medis', 'PNS', '2005-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(149, 'SURAMIN, SKM.,S.Kep.,Ns', '197011021995021002', 'Kepala Seksi Pengembangan Kerjasama dan Diklat', 'PNS', '1995-01-02', 12, 12, 0, 0, 0, 0, NULL, NULL),
(150, 'BEKTI NUGROHO,S.Kom. M.Eng.', '198004022008041001', 'Kepala Seksi Informasi dan Pemasaran', 'PNS', '2008-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(151, 'ANDREAS HASTA RIAWAN, AMF', '198212182009031006', 'Kepala Sub Bagian Perencanaan, Evaluasi dan Pelaporan', 'PNS', '2009-03-31', 12, 12, 0, 0, 0, 0, NULL, NULL),
(152, 'ERLIA ANDISETYANA P, S.Kep.Ns', '198206132006042010', 'Perawat Ahli Pertama', 'PNS', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(153, 'dr. SUMARJI,Sp.N', '197709042006041007', 'Dokter', 'PNS', '2006-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(154, 'Drs. J. SENO TJAHJADI, Apt', '196807071995031002', 'Apoteker Ahli Madya', 'PNS', '2021-01-10', 12, 12, 0, 0, 0, 0, NULL, NULL),
(155, 'dr. LISYATI KHOIRIYAH', '196909252007012008', 'Dokter Madya', 'PNS', '2007-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(156, 'dr. PUDJI SETYAWAN', '197201222006041014', 'Dokter Madya', 'PNS', '2006-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(157, 'SITI WARDANI, S.Kep', '196601031988032007', 'Perawat Penyelia', 'PNS', '1990-03-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(158, 'SUJIMAN, A.Md.Kep', '196606151988031023', '', 'PNS', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(159, 'SUPARMI, A.Md.Kep', '196701251988032006', 'Perawat Penyelia', 'PNS', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(160, 'ENDANG NURWATI, A.Md.Keb', '196703171988032011', 'Bidan Penyelia', 'PNS', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(161, 'YOHANES ADI K., A.Md.kep', '196803101988031004', 'Perawat Penyelia', 'PNS', '1988-03-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(162, 'TRI ANDAYANI, Amd', '196804241990122002', 'Pranata Lab. Kes. Penyelia', 'PNS', '2018-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(163, 'SRI SULASTRI, SKM', '196911111993032006', 'Sanitarian Muda', 'PNS', '1993-03-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(164, 'KELIK SURYANTO, Skep.ns', '197302271997031001', 'Perawat Penyelia', 'PNS', '1997-03-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(165, 'ENDANG SRI SULASTRI, Amd.Keb', '197401271993012003', 'Bidan Mahir', 'PNS', '2018-10-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(166, 'ANUNG INDRAS S, S.Kep.Ns', '197809282003121005', 'Perawat Ahli Muda', 'PNS', '2003-12-31', 12, 12, 0, 0, 0, 0, NULL, NULL),
(167, 'SITI ROCHANI, AMKG', '198204232003122004', 'Perawat Gigi Penyelia', 'PNS', '2003-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(168, 'ENY FATIMAH, S.Kep.,Ns', '197902232003122009', 'Perawat Ahli Muda', 'PNS', '2003-12-12', 12, 12, 0, 0, 0, 0, NULL, NULL),
(169, 'WINDARYATI, AMd.Keb.', '198005192003122009', 'Bidan Penyelia', 'PNS', '2003-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(170, 'AMBAR RUSMINI, S. Sit', '198104262006042014', 'Bidan Penyelia', 'PNS', '2018-10-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(171, 'dr. HENDY PRIMA SETYAWAN, SpB', '198105092011011009', 'Dokter', 'PNS', '2011-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(172, 'ENDANG FAJAR WAHYUNINGSIH, S.Kep.,Ns', '197501252006042010', 'Perawat Ahli Muda', 'PNS', '2006-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(173, 'NINIK WURYANTINI. A.Md.Keb', '197302112006042009', 'Bidan Mahir', 'PNS', '2006-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(174, 'MULYATI, AMd.Keb', '197503302007012008', 'Bidan Terampil', 'PNS', '2007-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(175, 'DWI AGUSTIN, AMD', '198608292009032004', 'Fisioterapis Pelaksana Lanjutan', 'PNS', '2021-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(176, 'NINA FAJARINI, Amd. Keb', '197409281993032002', 'Bidan Penyelia', 'PNS', '2014-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(177, 'VIVIN ARIYANTI, S.Gz', '198212232009032006', 'Nutrisionis Pelaksana Lanjutan', 'PNS', '2009-07-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(178, 'SUPARNI', '197005162007012015', 'Pengadministrasi Umum', 'PNS', '2007-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(179, 'WASINEM', '196606052007012030', 'Pengadministrasi Umum', 'PNS', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(180, 'AGUS DWIYANTO, S.Farm, Apt', '197612112006041008', 'Apoteker Ahli Pertama', 'PNS', '2007-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(181, 'PARMI, S.Gz', '197801182011012003', 'Nutrisionis Pelaksana Lanjutan', 'PNS', '2011-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(182, 'LILIK SUBAGYO, S.Kep, Ns', '198308042010011016', 'Kepala Seksi Keperawatan dan Penunjang Non Medis', 'PNS', '2010-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(183, 'WAHYU BETI HANDAYANI, S.Kep, Ns', '198610212010012013', 'Perawat Mahir', 'PNS', '2010-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(184, 'FITRIA PURNAMAWATI,S.Kep.,M.Kep', '198407152010012040', 'Perawat Ahli Muda', 'PNS', '2010-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(185, 'MELLI NUR INDAH SARI, S.Kep, Ns', '198803062010012010', 'Perawat Mahir', 'PNS', '2015-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(186, 'NINING RUSMAWATI, S.Kep, Ns', '197909022010012010', 'Perawat Mahir', 'PNS', '2010-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(187, 'DEWI ISJIATI, S.Kep', '197907272010012019', 'Perawat Mahir', 'PNS', '2010-06-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(188, 'HENI TRI HASTUTI, S.Kep, Ns', '198303302010012018', 'Perawat Mahir', 'PNS', '2010-07-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(189, 'HETTY PURWANINGSIH, S.Kep, Ns', '197602282010012007', 'Perawat Mahir', 'PNS', '2010-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(190, 'EKO SUJIANTO, S.Kep., Ns.', '198705052010011013', 'Perawat Ahli Pertama', 'PNS', '2010-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(191, 'DEWI SULASMI, AMK', '198712052010012015', 'Perawat Mahir', 'PNS', '2018-10-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(192, 'SRI SULISTYOWATI, AMK', '198504052010012033', 'Perawat Mahir', 'PNS', '2010-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(193, 'NURYATI,S.Tr.Keb, Bdn', '197812192010012011', 'Bidan Ahli Pertama', 'PNS', '2010-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(194, 'RAHMAWATI PUTRI EKA S, Amd. Keb', '198006192010012012', 'Bidan Mahir', 'PNS', '2010-06-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(195, 'ISTIQOMAH NURUL LAILI, AMd Keb.', '198509212010012031', 'Bidan Mahir', 'PNS', '2018-10-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(196, 'PUJI RAHAYU', '198702262010012020', 'Bidan Mahir', 'PNS', '2018-10-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(197, 'ERNI TRI YUNIATI, SKM', '198206162010012023', 'Sanitarian Pelaksana Lanjutan', 'PNS', '2010-06-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(198, 'BAGUS PRASETYA UTAMA, AMTE', '198712062010011003', 'Teknisi Elektromedis Mahir', 'PNS', '2010-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(199, 'TOMIK WIDAYANTO, Amd. Kep', '198105272011011006', 'Perawat Mahir', 'PNS', '2011-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(200, 'RISTU SETYAMURTI, S.Fis', '198501012011012016', 'Fisioterapis Muda', 'PNS', '2011-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(201, 'ETI FERIATI, A.Md', '197205281992032005', 'Pranata Lab. Kes. Penyelia', 'PNS', '2018-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(202, 'ANFANG GLORIAWATI, S.Tr', '198203172008012013', 'Radiografer Pelaksana', 'PNS', '2008-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(203, 'dr. ARI DWI RATNA K., M.Sc.SpA', '197809122005012013', 'Dokter', 'PNS', '2005-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(204, 'PURWANTO, AMAF.', '197504142009011009', 'Asisten Apoteker Penyelia', 'PNS', '2020-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(205, 'MAIMUNAH NUR ENDAH,S.Kep.,Ns', '197305072010012003', 'Perawat Terampil', 'PNS', '2010-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(206, 'dr. RUSNITA, Sp.PA', '197803122006042001', 'Dokter Madya', 'PNS', '2013-10-18', 12, 12, 0, 0, 0, 0, NULL, NULL),
(207, 'NUR A\'INI, Amd.Keb', '198011022005012018', 'Bidan Penyelia', 'PNS', '2005-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(208, 'WAHYU TRI WIDAYANTI, SE', '198307022006042006', 'Penyusun Laporan Keuangan', 'PNS', '2006-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(209, 'dr. SUGENG UTOMO', '197312302006041009', 'Dokter Muda', 'PNS', '2006-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(210, 'SRIYONO, SE', '196801011990031020', 'Penyusun Laporan Keuangan', 'PNS', '1990-03-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(211, 'DIDIK SETIYO HARTONO, S.T', '197110281992031008', '', 'PNS', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(212, 'dr. AYYUB ISWAHYUDI, Sp.OG', '198306032015021001', 'Dokter Pertama', 'PNS', '2015-02-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(213, 'dr. ABDULLOH ABBAS', '198808262015021001', 'Dokter Pertama', 'PNS', '2015-02-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(214, 'WINDI HAPSIDANA,A.Md.Rad.', '198912102015022003', 'Radiografer Pelaksana', 'PNS', '2015-03-05', 12, 12, 0, 0, 0, 0, NULL, NULL),
(215, 'ARTHA TRI HANDAYANI,A.MK', '197804042014092002', 'Perawat Mahir', 'PNS', '2014-09-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(216, 'ENIK PUJIASTUTI,S.kep.Ns', '197609112014092002', 'Perawat Mahir', 'PNS', '2015-03-05', 12, 12, 0, 0, 0, 0, NULL, NULL),
(217, 'CANDRA NUGRAHENI,S.ST', '198912272011012003', 'Bidan Ahli Pertama', 'PNS', '2011-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(218, 'NGATINI, S.kep', '198002242011012005', 'Perawat Mahir', 'PNS', '2011-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(219, 'KISTI RIAWATI, A.Md.', '198706142011012014', 'Pranata Lab. Kes. Pelaksana Lanjutan', 'PNS', '2015-10-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(220, 'JANURIADI FARUDIN, A.Md', '198101192006041007', 'Perekam Medis Pelaksana Lanjutan', 'PNS', '2006-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(221, 'dr. WIDAYANTO, SpP. M.kes, FISR', '197507292007011006', 'Dokter Muda', 'PNS', '2007-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(222, 'dr. ANITA WIJAYANTI, SpPD, M.Kes', '197801152005012010', 'Dokter', 'PNS', '2005-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(223, 'dr. ARIS GUNAWAN, SpA, M,kes', '197604052005011011', 'Dokter Madya', 'PNS', '2005-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(224, 'Apt. SEPTYANITA DWIANGGA, S.Farm', '198709302011012016', 'Apoteker Ahli Pertama', 'PNS', '2011-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(225, 'dr. AGUS GIYARTO, SpPD', '197904062006041027', 'Dokter Madya', 'PNS', '2006-01-04', 12, 12, 0, 0, 0, 0, NULL, NULL),
(226, 'ENDAH HARIS STYOWATI, AMK', '198304012006042003', 'Perawat Mahir', 'PNS', '2006-01-04', 12, 12, 0, 0, 0, 0, NULL, NULL),
(227, 'HARTONO, AMTE', '196901122000031007', 'Teknisi Elektromedis Penyelia', 'PNS', '2000-03-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(228, 'A.M. TYAS OKTARINA INDAH RIMBAWATI, A.Md.Keb.', '198110222008012006', 'Bidan Penyelia', 'PNS', '2017-10-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(229, 'drg. BETY HERLINAWATI', '198505102011012013', 'Dokter', 'PNS', '2014-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(230, 'dr. SRI WAHYUNI, Sp.KJ', '197210172006042004', 'Dokter', 'PNS', '2006-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(231, 'DESIYANA RACHMAWATI.,Amd.Rad', '198812032010012008', 'Radiografer Pelaksana Lanjutan', 'PNS', '2010-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(232, 'ASRI PRATIWI HIDAYANTI, AMd.Farm', '198707022010012023', 'Asisten Apoteker Pelaksana Lanjutan', 'PNS', '2010-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(233, 'dr. AISYAH UMMU FAHMA', '199212272019032011', 'Dokter Pertama', 'PNS', '2019-03-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(234, 'Drg. ITA ARAFATIS SYARIFAH', '198807242019032008', 'Dokter Pertama', 'PNS', '2019-03-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(235, 'dr. PAKSI SURYO BAWONO', '199205242019031008', 'Dokter Pertama', 'PNS', '2019-03-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(236, 'CANDRA ROSANTI, SKM', '198805012011012014', 'Epidemiolog Kesehatan Ahli Pertama', 'PNS', '2011-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(237, 'SUHONO, SKM', '196508301990011001', 'Nutrisionis Madya', 'PNS', '1990-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(238, 'dr. YULIA RATNA UTAMI, Sp.Rad', '198307052011012015', 'Dokter Muda', 'PNS', '2020-06-02', 12, 12, 0, 0, 0, 0, NULL, NULL),
(239, 'drg. DINA LISTYOWATI, Sp.Ort', '198303012009032007', 'Dokter Pertama', 'PNS', '2018-10-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(240, 'dr. ODDIE BUDI SANTOSA, Sp.An', '198208142020121002', 'Dokter Pertama', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(241, 'ADI TRIWISNU, Amd E.M', '198507182020121003', 'Teknisi Elektromedis Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(242, 'FARIDA KURNIAWATI, S.Farm.,Apt.', '198606282020122006', 'Apoteker Ahli Pertama', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(243, 'MUSTAQIM, S.Farm., Apt', '198507272020121009', 'Apoteker Ahli Pertama', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(244, 'AHTMI WARDHANI, A.Md Farm', '199209242020122017', 'Asisten Apoteker Pelaksana', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(245, 'DANANG SAPUTRO M Y W, A.Md.Farm', '199806142020121010', 'Asisten Apoteker Pelaksana', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(246, 'WULANDARI, A.Md.Farm', '199306262020122025', 'Asisten Apoteker Pelaksana', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(247, 'PRANAR MAYA EKA PRADINA, A.Md.', '199805062020122013', 'Asisten Apoteker Pelaksana', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(248, 'ANA SAFITRI DEWI, A. Md. Kep', '199804092020122016', 'Perawat Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(249, 'DEVINTA RISWANDARI, A.Md. Kep.', '199503282020122019', 'Perawat Terampil', 'PNS', '2021-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(250, 'DEVY NUR FARADILLA, A.Md.Kep', '199112032020122017', 'Perawat Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(251, 'DODY FIRMANSYAH, AMK', '198504032020121010', 'Perawat Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(252, 'EKA MUTYA, AMK', '199612062020122022', 'Perawat Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(253, 'EKO SETIANTO, A.Md.Kep', '199211192020121008', 'Perawat Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(254, 'RISA MAELANI, A.Md.Kep', '198908202020122014', 'Perawat Terampil', 'PNS', '2021-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(255, 'YULAIKHA WIDYASTUTI, A.Md.Kep', '198507262020122007', 'Perawat Terampil', 'PNS', '2019-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(256, 'ALIFIA SATRIANING HUTARI, A.Md.Kep', '199805022020122008', 'Perawat Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(257, 'ANNISA RATNA PUDYASTUTI, A.Md. Kep', '199508102020122019', 'Perawat Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(258, 'NOORA CHUMAIROH, A.Md.Kep.', '199211142020122020', 'Perawat Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(259, 'NOVI AYU KINASIH, A.Md.Kep', '199502162020122022', 'Pengatur / IIc', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(260, 'NOVIA TRISTUGINARIYANTI, A.Md.Keb.', '198911022020122010', 'Bidan Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(261, 'NUR ARIFIN, A.Md.Kep.', '199612242020121010', 'Perawat Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(262, 'RINA PUJIATI, AMK', '198910172020122022', 'Perawat Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(263, 'RONI FADHALI, Amd. Kep', '199202152020121014', 'Perawat Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(264, 'SANSAVERA NUR FATIMAH, A.Md.Kep', '199401122020122024', 'Perawat Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(265, 'TITO SRI RAHMANSYAH, A.Md. Kep', '199410312020121013', 'Perawat Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(266, 'TRIAS WULANJARI, AMKG', '199401062020122027', 'Perawat Gigi Terampil', 'PNS', '1970-01-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(267, 'AMELIA RIFKI SUMADI, A.Md.Kep', '199709242020122014', 'Perawat Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(268, 'ANI MARYUTIK, A.Md.Keb', '199311242020122014', 'Bidan Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(269, 'ANDIKA DEWI WULANDARI, A.Md.Keb', '198901212020122011', 'Bidan Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(270, 'APRILIA SINTA DEWI, A.Md.Keb.', '199704252020122016', 'Bidan Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(271, 'DIAN CHANDRAWATI, Amd.Keb', '199502062020122020', 'Bidan Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(272, 'DINDA FITRI BADRIAH, A.Md.Keb.', '199901212020122003', 'Bidan Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(273, 'EVA EVI ANA M, AMd.Keb.', '199501212020122023', 'Bidan Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(274, 'KARTIKA HARIANJA, Amd.Keb', '198912272020122017', 'Perekam Medis Muda', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(275, 'KHOIRIYAH EKA RAMADHANI,A.Md.Keb', '199502042020122027', 'Bidan Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(276, 'LUSIANA INDRA PRATIWI, Amd. Keb', '199207242020122017', 'Bidan Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(277, 'NUGRAHENI NGESTI UTAMI, A.Md.', '199510302020122023', 'Bidan Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(278, 'NUR INDAH KUSUMAWATI,A.Md.Keb.', '199002112020122016', 'Bidan Terampil', 'PNS', '2020-12-21', 12, 12, 0, 0, 0, 0, NULL, NULL),
(279, 'RINA KARTIKASARI, A.Md.Keb.', '199610062020122023', 'Bidan Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(280, 'RINI WULANDARI, A.Md. Keb', '199104092020122021', 'Bidan Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(281, 'SETIAWATI, A.Md. Keb', '199111302020122019', 'Pranata Komputer Ahli Muda', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(282, 'DIAN INTAN PANDINI, A.Md.KL', '199511262020122025', 'Sanitarian Pelaksana', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(283, 'LAILATUL QOMARIAH, A.md.Gz', '199407122020122025', 'Kepala Seksi Pelayanan Medis dan Penunjang Medis', 'PNS', '2021-02-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(284, 'MOHAMAD YASIR, A.Md.', '198907232020121010', 'Perawat Terampil', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(285, 'TULUS WAHYUNO, A.Md', '199601142020121007', 'Pranata Komputer Terampil', 'PNS', '2008-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(286, 'EVA ZULIYANA, A.Md.RMIK', '199407052020122025', 'Perekam Medis Pelaksana', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(287, 'NINDY AYU NINGRUM, A.Md.Kes.', '199607162020122016', 'Perekam Medis Pelaksana', 'PNS', '2020-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(288, 'SUKMA ARIYATI, A.Md.AK', '199610122020122030', 'Pranata Lab. Kes. Pelaksana', 'PNS', '2021-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(289, 'YUWONO LAKSITO, A.Md', '197106121999031007', 'Kepala Sub Bagian Umum dan Kepegawaian', 'PNS', '1999-01-03', 12, 12, 0, 0, 0, 0, NULL, NULL),
(290, 'NUNUNG AGUS DWI HARYANTO, SE, M.Si', '198308052009031007', 'Kepala Sub Bagian Keuangan', 'PNS', '2009-03-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(291, 'dr. ENDAH SRI PUJI HASTUTI, MKes, M.Gz.', '197102192003122005', 'Dokter Madya', 'PNS', '2019-04-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(292, 'dr. R.rr. Ervina Kusuma Wardani', '199506152022032015', 'Dokter Umum', 'PNS', '2022-03-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(293, 'dr. Faris Budiyanto', '199409282022031006', 'Dokter Pertama', 'PNS', '2022-03-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(294, 'SUTRISNO, S.ST', '197901092003121003', 'Radiografer Muda', 'PNS', '2003-12-01', 12, 12, 0, 0, 0, 0, NULL, NULL),
(295, 'dr. DANANG YOGA WIGUNA, Sp. M, M. Ked. Klin.', '198607092020121012', 'Dokter Pertama', 'PNS', '2021-02-01', 12, 12, 0, 0, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `regulasi`
--

CREATE TABLE `regulasi` (
  `id_regulasi` bigint UNSIGNED NOT NULL,
  `isi_regulasi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `regulasi`
--

INSERT INTO `regulasi` (`id_regulasi`, `isi_regulasi`, `created_at`, `updated_at`) VALUES
(1, 'Undang-Undang Nomor 40 Tahun 2004 tentang Sistem Jaminan Sosial Nasional (SJSN)', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(2, 'Undang-Undang Nomor 29 Tahun 2004 tentang Praktik Kedokteran', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(3, 'Undang-Undang Nomor 44 Tahun 2009 tentang Rumah Sakit', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(4, 'Undang-Undang Nomor 24 Tahun 2011 tentang Badan Penyelenggara Jaminan Sosial (BPJS)', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(5, 'Undang-Undang Nomor 11 Tahun 2020 tentang Cipta Kerja', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(6, 'Undang-Undang Nomor 17 Tahun 2023 tentang Kesehatan', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(7, 'Peraturan Pemerintah Nomor 40 Tahun 2019 tentang Pelaksanaan Undang-Undang Nomor 23 Tahun 2006 tentang Administrasi Kependudukan', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(8, 'Peraturan Pemerintah Nomor 5 Tahun 2021 tentang Penyelenggaraan Perizinan Berusaha Berbasis Risiko', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(9, 'Peraturan Pemerintah Republik Indonesia Nomor 47 Tahun 2021 tentang Penyelenggaraan Bidang Perumahsakitan', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(10, 'Peraturan Presiden Nomor 12 Tahun 2013 tentang Jaminan Kesehatan', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(11, 'Peraturan Presiden Nomor 111 Tahun 2013 tentang Perubahan atas Peraturan Presiden Nomor 12 Tahun 2013 tentang Jaminan Kesehatan', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(12, 'Peraturan Presiden Nomor 77 Tahun 2015 tentang Pedoman Organisasi Rumah Sakit', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(13, 'Peraturan Presiden Nomor 96 Tahun 2018 tentang Persyaratan dan Tata Cara Pendaftaran Penduduk dan Catatan Sipil', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(14, 'Peraturan Menteri Dalam Negeri Nomor 19 Tahun 2016 tentang Pedoman Pengelolaan Barang Milik Daerah', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(15, 'Peraturan Menteri Dalam Negeri Nomor 79 Tahun 2018 tentang Badan Layanan Umum Daerah', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(16, 'Peraturan Menteri Dalam Negeri Nomor 7 Tahun 2019 tentang Pelayanan Administrasi Kependudukan secara daring', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(17, 'Peraturan Menteri Kesehatan Nomor 129 Tahun 2008 tentang Standar Pelayanan Minimal Rumah Sakit', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(18, 'Peraturan Menteri Kesehatan Nomor 71 Tahun 2013 tentang Pelayanan Kesehatan pada Jaminan Kesehatan Nasional', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(19, 'Peraturan Menteri Kesehatan Nomor 27 Tahun 2017 tentang Pedoman Pencegahan dan Pengendalian Infeksi', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(20, 'Peraturan Menteri Kesehatan Nomor 3 Tahun 2020 tentang Klasifikasi dan Perizinan Rumah Sakit', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(21, 'Peraturan Menteri Kesehatan Nomor 14 Tahun 2021 tentang Standar Kegiatan Usaha dan Produk pada Penyelenggaraan Perizinan Berusaha Berbasis Risiko Sektor Kesehatan', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(22, 'Peraturan Menteri Kesehatan Nomor 26 Tahun 2021 tentang Pedoman Indonesian Case Base Groups (INA-CBG)', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(23, 'Peraturan Menteri Kesehatan Nomor 26 Tahun 2021 tentang Pencegahan dan Penanganan Kecurangan (Fraud) dalam Program Jaminan Kesehatan', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(24, 'Peraturan Menteri Kesehatan Nomor 40 Tahun 2022 tentang Persyaratan Teknis Bangunan, Prasarana, dan Peralatan', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(25, 'Peraturan BPJS Kesehatan Nomor 1 Tahun 2014 tentang Penyelenggaraan Jaminan Kesehatan', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(26, 'Peraturan Daerah Kabupaten Sragen Nomor 15 Tahun 2008 tentang Organisasi dan Tata Kerja Lembaga Teknis Daerah', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(27, 'Peraturan Daerah Kabupaten Sragen Nomor 2 Tahun 2009 tentang Pokok-Pokok Pengelolaan Keuangan Daerah', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(28, 'Peraturan Daerah Kabupaten Sragen Nomor 5 Tahun 2023 tentang APBD Kabupaten Sragen Tahun Anggaran 2023', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(29, 'Peraturan Bupati Sragen Nomor 10 Tahun 2011 tentang Penjabaran Tugas dan Fungsi RSUD dr. Soeratno Gemolong', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(30, 'Peraturan Bupati Sragen Nomor 10 Tahun 2015 tentang Pedoman Pengelolaan Keuangan BLUD RSUD dr. Soeratno Gemolong', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(31, 'Peraturan Bupati Sragen Nomor 67 Tahun 2021 tentang Pembentukan RSUD dr. Soeratno Gemolong Kelas C', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(32, 'Peraturan Bupati Sragen Nomor 8 Tahun 2023 tentang Tata Kelola RSUD dr. Soeratno Gemolong', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(33, 'Peraturan Bupati Sragen Nomor 20 Tahun 2024 tentang Pedoman Pelaksanaan Inventarisasi Barang Milik Daerah', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(34, 'Keputusan Direktur Jenderal Pencegahan dan Pengendalian Penyakit Kementerian Kesehatan RI Nomor HK.02.02/1/1811/2022 tentang Petunjuk Teknis Kesiapan Sarana Prasarana Rumah Sakit dalam Penerapan Kelas Rawat Inap Standar JKN', '2026-01-31 14:33:43', '2026-01-31 14:33:43'),
(35, 'Keputusan Bupati Sragen Nomor 900/441/002/2014 tentang Penerapan Pola Pengelolaan Keuangan BLUD secara Penuh pada RSUD dr. Soeratno Gemolong', '2026-01-31 14:33:43', '2026-01-31 14:33:43');

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` bigint UNSIGNED NOT NULL,
  `nama_ruangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `nama_ruangan`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, NULL),
(2, 'Direktur', NULL, NULL),
(3, 'Tata Usaha', NULL, NULL),
(4, 'Pelayanan', NULL, NULL),
(5, 'Pengembangan', NULL, NULL),
(6, 'Pengadaan', NULL, NULL),
(7, 'Keuangan', NULL, NULL),
(8, 'Keperawatan', NULL, NULL),
(9, 'Farmasi', NULL, NULL),
(10, 'IT RSUD', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sk_direktur`
--

CREATE TABLE `sk_direktur` (
  `id_sk_direktur` bigint UNSIGNED NOT NULL,
  `judul_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tentang` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `menimbang` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `mengingat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `memutuskan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `menetapkan` text COLLATE utf8mb4_unicode_ci,
  `tempat_dibuat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_dibuat` date NOT NULL,
  `id_surat` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sop`
--

CREATE TABLE `sop` (
  `id_sop` bigint UNSIGNED NOT NULL,
  `id_surat` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sop_contents`
--

CREATE TABLE `sop_contents` (
  `id_sop_page` bigint UNSIGNED NOT NULL,
  `id_sop` bigint UNSIGNED NOT NULL,
  `judul_sop` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_dokumen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_revisi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `halaman` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_terbit` date NOT NULL,
  `pengertian` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tujuan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kebijakan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `prosedur` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_terkait` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `id_surat` bigint UNSIGNED NOT NULL,
  `nama_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_dibuat` date NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_template_surat` bigint UNSIGNED DEFAULT NULL,
  `id_regulasi` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `is_draft` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_izin_cuti`
--

CREATE TABLE `surat_izin_cuti` (
  `id_cuti` bigint UNSIGNED NOT NULL,
  `id_surat` bigint UNSIGNED DEFAULT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PNS',
  `form_data` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_surat`
--

CREATE TABLE `template_surat` (
  `id_template_surat` bigint UNSIGNED NOT NULL,
  `nama_template_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `template_surat`
--

INSERT INTO `template_surat` (`id_template_surat`, `nama_template_surat`, `created_at`, `updated_at`) VALUES
(1, 'Surat Keputusan Direktur', '2026-01-31 14:32:38', '2026-01-31 14:32:38'),
(2, 'Standar Operasional Prosedur (SOP)', '2026-01-31 14:32:38', '2026-01-31 14:32:38'),
(3, 'Surat Izin Cuti PNS', '2026-01-31 14:32:38', '2026-01-31 14:32:38'),
(4, 'Surat Izin Cuti PPPK', '2026-01-31 14:32:38', '2026-01-31 14:32:38'),
(5, 'Surat Izin Cuti Non ASN', '2026-01-31 14:32:38', '2026-01-31 14:32:38');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id_unit` bigint UNSIGNED NOT NULL,
  `nama_unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id_unit`, `nama_unit`, `created_at`, `updated_at`) VALUES
(1, 'Instalasi Gawat Darurat', '2026-01-31 14:32:36', '2026-01-31 14:32:36'),
(2, 'Instalasi Rawat Inap', '2026-01-31 14:32:36', '2026-01-31 14:32:36'),
(3, 'Instalasi Rawat Jalan', '2026-01-31 14:32:36', '2026-01-31 14:32:36'),
(4, 'Instalasi Penunjang Medis', '2026-01-31 14:32:36', '2026-01-31 14:32:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_ruangan` bigint UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `id_ruangan`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$US5IJ5kWTt2pJkuEj6oeze.Xy3R42lBlzB7Ks6CzXVLWVHEsFEJYW', 1, NULL, '2026-01-31 14:32:38', '2026-01-31 14:32:38'),
(2, 'direktur', '$2y$10$1jdv6PfAUUbRjBFcPl6JrOtdq2n3Bn5USuWGTDx.DrULz0o3/KI.G', 2, NULL, '2026-01-31 14:32:38', '2026-01-31 14:32:38'),
(3, 'tatausaha', '$2y$10$DidVNoEF4dsO0QH.tTJtY.t5hLyMX8DWc/UKAVV2cxZy8m5yuc1WG', 3, NULL, '2026-01-31 14:32:38', '2026-01-31 14:32:38'),
(4, 'pelayanan', '$2y$10$im9hRym7G41NKE/AhuJ7Ue9KosvJ/7e2SGbAMeGTMja7.80z6A4LS', 4, NULL, '2026-01-31 14:32:38', '2026-01-31 14:32:38'),
(5, 'pengembangan', '$2y$10$YPCw4M/IHVpZoOscU2vy7.utELNgM2IhsaMQRPhAW3EbyyOrMeS2K', 5, NULL, '2026-01-31 14:32:38', '2026-01-31 14:32:38'),
(6, 'pengadaan', '$2y$10$2iIRqfac0VC/A3jRwqvHo.N/0/pzmRqWqTsbo4q37G8iUODgicX..', 6, NULL, '2026-01-31 14:32:38', '2026-01-31 14:32:38'),
(7, 'keuangan', '$2y$10$DgkcmfHHg.JjD8.1nI/wc.Bs95Y/5SyqRXQHyobRqXTk.2JVWUiey', 7, NULL, '2026-01-31 14:32:38', '2026-01-31 14:32:38'),
(8, 'keperawatan', '$2y$10$cpZUYUSbYA/pvRySvcPkoOvJp5Ll2oZCsD/Z5Dy1EiXSxO3L.0BpC', 8, NULL, '2026-01-31 14:32:38', '2026-01-31 14:32:38'),
(9, 'farmasi', '$2y$10$JST2OOEL.Q.vX/6akraGIOBzpv1SDQK67Na6u6pVmJWZ4xHfxPk2e', 9, NULL, '2026-01-31 14:32:38', '2026-01-31 14:32:38'),
(10, 'itrsud', '$2y$10$0KYvmNd7ByudoGCIdjsiOe34B1731E11ik4rV.Hj5t/wyyS3Vdury', 10, NULL, '2026-01-31 14:32:38', '2026-01-31 14:32:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cuti_bersama`
--
ALTER TABLE `cuti_bersama`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jabatans`
--
ALTER TABLE `jabatans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jabatans_nama_jabatan_unique` (`nama_jabatan`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pegawais`
--
ALTER TABLE `pegawais`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pegawais_nip_unique` (`nip`);

--
-- Indexes for table `regulasi`
--
ALTER TABLE `regulasi`
  ADD PRIMARY KEY (`id_regulasi`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`);

--
-- Indexes for table `sk_direktur`
--
ALTER TABLE `sk_direktur`
  ADD PRIMARY KEY (`id_sk_direktur`),
  ADD KEY `sk_direktur_id_surat_foreign` (`id_surat`);

--
-- Indexes for table `sop`
--
ALTER TABLE `sop`
  ADD PRIMARY KEY (`id_sop`),
  ADD KEY `sop_id_surat_foreign` (`id_surat`);

--
-- Indexes for table `sop_contents`
--
ALTER TABLE `sop_contents`
  ADD PRIMARY KEY (`id_sop_page`),
  ADD KEY `sop_contents_id_sop_foreign` (`id_sop`);

--
-- Indexes for table `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id_surat`),
  ADD UNIQUE KEY `surat_nomor_surat_id_template_surat_unique` (`nomor_surat`,`id_template_surat`),
  ADD KEY `surat_id_template_surat_foreign` (`id_template_surat`),
  ADD KEY `surat_created_by_foreign` (`created_by`),
  ADD KEY `surat_id_regulasi_foreign` (`id_regulasi`);

--
-- Indexes for table `surat_izin_cuti`
--
ALTER TABLE `surat_izin_cuti`
  ADD PRIMARY KEY (`id_cuti`),
  ADD KEY `surat_izin_cuti_id_surat_foreign` (`id_surat`);

--
-- Indexes for table `template_surat`
--
ALTER TABLE `template_surat`
  ADD PRIMARY KEY (`id_template_surat`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id_unit`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_id_ruangan_foreign` (`id_ruangan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cuti_bersama`
--
ALTER TABLE `cuti_bersama`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jabatans`
--
ALTER TABLE `jabatans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pegawais`
--
ALTER TABLE `pegawais`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=296;

--
-- AUTO_INCREMENT for table `regulasi`
--
ALTER TABLE `regulasi`
  MODIFY `id_regulasi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id_ruangan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sk_direktur`
--
ALTER TABLE `sk_direktur`
  MODIFY `id_sk_direktur` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sop`
--
ALTER TABLE `sop`
  MODIFY `id_sop` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sop_contents`
--
ALTER TABLE `sop_contents`
  MODIFY `id_sop_page` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id_surat` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_izin_cuti`
--
ALTER TABLE `surat_izin_cuti`
  MODIFY `id_cuti` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_surat`
--
ALTER TABLE `template_surat`
  MODIFY `id_template_surat` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id_unit` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sk_direktur`
--
ALTER TABLE `sk_direktur`
  ADD CONSTRAINT `sk_direktur_id_surat_foreign` FOREIGN KEY (`id_surat`) REFERENCES `surat` (`id_surat`) ON DELETE CASCADE;

--
-- Constraints for table `sop`
--
ALTER TABLE `sop`
  ADD CONSTRAINT `sop_id_surat_foreign` FOREIGN KEY (`id_surat`) REFERENCES `surat` (`id_surat`) ON DELETE CASCADE;

--
-- Constraints for table `sop_contents`
--
ALTER TABLE `sop_contents`
  ADD CONSTRAINT `sop_contents_id_sop_foreign` FOREIGN KEY (`id_sop`) REFERENCES `sop` (`id_sop`) ON DELETE CASCADE;

--
-- Constraints for table `surat`
--
ALTER TABLE `surat`
  ADD CONSTRAINT `surat_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `surat_id_regulasi_foreign` FOREIGN KEY (`id_regulasi`) REFERENCES `regulasi` (`id_regulasi`) ON DELETE SET NULL,
  ADD CONSTRAINT `surat_id_template_surat_foreign` FOREIGN KEY (`id_template_surat`) REFERENCES `template_surat` (`id_template_surat`) ON DELETE SET NULL;

--
-- Constraints for table `surat_izin_cuti`
--
ALTER TABLE `surat_izin_cuti`
  ADD CONSTRAINT `surat_izin_cuti_id_surat_foreign` FOREIGN KEY (`id_surat`) REFERENCES `surat` (`id_surat`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_id_ruangan_foreign` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
