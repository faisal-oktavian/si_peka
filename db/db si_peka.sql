-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table si_peka.config
CREATE TABLE IF NOT EXISTS `config` (
  `idconfig` int NOT NULL AUTO_INCREMENT,
  `key` varchar(200) DEFAULT NULL,
  `value` text,
  `type` varchar(50) DEFAULT 'text',
  `created` datetime DEFAULT NULL,
  `createdby` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedby` varchar(50) DEFAULT NULL,
  `status` int DEFAULT '1',
  PRIMARY KEY (`idconfig`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table si_peka.config: ~0 rows (approximately)
INSERT INTO `config` (`idconfig`, `key`, `value`, `type`, `created`, `createdby`, `updated`, `updatedby`, `status`) VALUES
	(1, 'app_name', 'Si Peka', 'text', '2022-04-04 02:02:19', NULL, '2022-04-04 02:02:19', NULL, 1);

-- Dumping structure for table si_peka.config_app
CREATE TABLE IF NOT EXISTS `config_app` (
  `idconfig_app` int NOT NULL AUTO_INCREMENT,
  `key` varchar(200) DEFAULT NULL,
  `value` varchar(400) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdby` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedby` varchar(50) DEFAULT NULL,
  `status` int DEFAULT '1',
  PRIMARY KEY (`idconfig_app`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table si_peka.config_app: ~0 rows (approximately)
INSERT INTO `config_app` (`idconfig_app`, `key`, `value`, `created`, `createdby`, `updated`, `updatedby`, `status`) VALUES
	(1, 'disk_space', '20000', '2018-08-29 09:51:31', NULL, '2018-08-29 09:51:31', NULL, 1);

-- Dumping structure for table si_peka.komponen
CREATE TABLE IF NOT EXISTS `komponen` (
  `idkomponen` int NOT NULL AUTO_INCREMENT,
  `nama_komponen` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_kepuasan` varchar(50) DEFAULT NULL COMMENT 'PUAS / TIDAK PUAS',
  `is_unit` varchar(50) DEFAULT NULL COMMENT '0 : tidak wajib pilih unit dan isi keterangannya; \r\n1 : wajib pilih unit dan isi keterangannya',
  `sequence` int DEFAULT NULL,
  `is_active` int DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `createdby` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedby` varchar(50) DEFAULT NULL,
  `status` int DEFAULT '1',
  PRIMARY KEY (`idkomponen`) USING BTREE,
  KEY `sequence` (`sequence`),
  KEY `is_active` (`is_active`),
  KEY `status` (`status`),
  KEY `is_satisfied` (`status_kepuasan`),
  KEY `nama_komponen` (`nama_komponen`) USING BTREE,
  KEY `is_unit` (`is_unit`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table si_peka.komponen: ~6 rows (approximately)
INSERT INTO `komponen` (`idkomponen`, `nama_komponen`, `status_kepuasan`, `is_unit`, `sequence`, `is_active`, `created`, `createdby`, `updated`, `updatedby`, `status`) VALUES
	(1, 'Petugas (Keramahan, Sikap, Penampilan)', 'TIDAK PUAS', '1', 1, 1, '2025-08-23 09:09:05', 'BucinBGMID', '2025-08-23 09:09:05', 'BucinBGMID', 1),
	(2, 'Fasilitas', 'TIDAK PUAS', '1', 2, 1, '2025-08-23 09:10:49', 'BucinBGMID', '2025-08-23 09:10:50', 'BucinBGMID', 1),
	(3, 'Prosedur Layanan', 'TIDAK PUAS', '1', 3, 1, '2025-08-23 09:11:22', 'BucinBGMID', '2025-08-23 09:11:23', 'BucinBGMID', 1),
	(4, 'Waktu Layanan', 'TIDAK PUAS', '1', 4, 1, '2025-08-23 09:11:36', 'BucinBGMID', '2025-08-23 11:20:09', 'BucinBGMID', 1),
	(5, 'Waktu Layanan RS', 'TIDAK PUAS', '1', 4, 1, '2025-08-23 09:12:37', 'BucinBGMID', '2025-08-23 09:12:43', 'BucinBGMID', 0),
	(6, 'Waktu Layanan', 'TIDAK PUAS', '1', 4, 1, '2025-08-23 11:20:12', 'BucinBGMID', '2025-08-23 11:20:15', 'BucinBGMID', 0);

-- Dumping structure for table si_peka.layanan
CREATE TABLE IF NOT EXISTS `layanan` (
  `idlayanan` int NOT NULL AUTO_INCREMENT,
  `nama_layanan` varchar(200) DEFAULT NULL,
  `sequence` int DEFAULT NULL,
  `is_active` int DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `createdby` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedby` varchar(50) DEFAULT NULL,
  `status` int DEFAULT '1',
  PRIMARY KEY (`idlayanan`),
  KEY `nama_layanan` (`nama_layanan`),
  KEY `sequence` (`sequence`),
  KEY `is_active` (`is_active`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table si_peka.layanan: ~14 rows (approximately)
INSERT INTO `layanan` (`idlayanan`, `nama_layanan`, `sequence`, `is_active`, `created`, `createdby`, `updated`, `updatedby`, `status`) VALUES
	(1, 'Pendaftaran', 1, 1, '2025-09-02 19:18:57', 'BucinBGMID', '2025-09-02 19:19:23', 'BucinBGMID', 1),
	(2, 'IGD', 2, 1, '2025-09-02 19:19:29', 'BucinBGMID', '2025-09-02 19:19:29', 'BucinBGMID', 1),
	(3, 'Poli Spesialis', 3, 1, '2025-09-02 19:19:40', 'BucinBGMID', '2025-09-02 19:19:40', 'BucinBGMID', 1),
	(4, 'Kasir', 4, 1, '2025-09-02 19:19:48', 'BucinBGMID', '2025-09-02 19:19:49', 'BucinBGMID', 1),
	(5, 'Laboratorium', 5, 1, '2025-09-02 19:20:02', 'BucinBGMID', '2025-09-02 19:20:02', 'BucinBGMID', 1),
	(6, 'Radiologi', 6, 1, '2025-09-02 19:20:11', 'BucinBGMID', '2025-09-02 19:20:12', 'BucinBGMID', 1),
	(7, 'Penyediaan makanan', 7, 1, '2025-09-02 19:26:49', 'BucinBGMID', '2025-09-02 19:26:49', 'BucinBGMID', 1),
	(8, 'Fisioterapi', 8, 1, '2025-09-02 19:27:03', 'BucinBGMID', '2025-09-02 19:27:04', 'BucinBGMID', 1),
	(9, 'Apotek', 9, 1, '2025-09-02 19:27:27', 'BucinBGMID', '2025-09-02 19:27:27', 'BucinBGMID', 1),
	(10, 'Rawat Inap', 10, 1, '2025-09-02 19:27:48', 'BucinBGMID', '2025-09-02 19:27:49', 'BucinBGMID', 1),
	(11, 'Kamar Operasi', 11, 1, '2025-09-02 19:28:03', 'BucinBGMID', '2025-09-02 19:28:04', 'BucinBGMID', 1),
	(12, 'Ruang Intensif', 12, 1, '2025-09-02 19:28:29', 'BucinBGMID', '2025-09-02 19:28:30', 'BucinBGMID', 1),
	(13, 'Kebersihan', 13, 1, '2025-09-02 19:28:40', 'BucinBGMID', '2025-09-02 19:28:40', 'BucinBGMID', 1),
	(14, 'Keamanan', 14, 1, '2025-09-02 19:28:51', 'BucinBGMID', '2025-09-02 19:28:51', 'BucinBGMID', 1);

-- Dumping structure for table si_peka.responden
CREATE TABLE IF NOT EXISTS `responden` (
  `idresponden` bigint NOT NULL AUTO_INCREMENT,
  `idbilling` bigint DEFAULT NULL COMMENT 'ambil id dari API billing',
  `tanggal_input` datetime DEFAULT NULL,
  `nama_pasien` varchar(100) DEFAULT NULL,
  `no_rm` varchar(50) DEFAULT NULL,
  `idruangan` int DEFAULT NULL,
  `kepuasan` varchar(50) DEFAULT NULL,
  `is_active` int DEFAULT '1',
  PRIMARY KEY (`idresponden`),
  KEY `idbilling` (`idbilling`),
  KEY `tanggal_input` (`tanggal_input`),
  KEY `nama_pasien` (`nama_pasien`),
  KEY `no_rm` (`no_rm`),
  KEY `idruangan` (`idruangan`),
  KEY `kepuasan` (`kepuasan`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table si_peka.responden: ~24 rows (approximately)
INSERT INTO `responden` (`idresponden`, `idbilling`, `tanggal_input`, `nama_pasien`, `no_rm`, `idruangan`, `kepuasan`, `is_active`) VALUES
	(3, NULL, '2025-09-13 12:47:05', 'audia', '24154132', 6, 'puas', 1),
	(4, NULL, '2025-09-13 12:57:56', 'ilmi', '13228312', 1, 'puas', 1),
	(5, NULL, '2025-09-15 13:01:12', 'vivi', '29129129', 3, 'puas', 1),
	(6, NULL, '2025-09-15 13:35:58', 'rizky', '20154136', 7, 'puas', 1),
	(7, NULL, '2025-09-15 13:39:01', 'raka', '21145132', 4, 'puas', 1),
	(8, NULL, '2025-09-16 13:41:09', 'via', '23432154', 2, 'puas', 1),
	(9, NULL, '2025-09-17 13:41:56', 'silvi', '12113425', 5, 'puas', 1),
	(10, NULL, '2025-09-17 13:43:25', 'niken', '22141253', 8, 'puas', 1),
	(11, NULL, '2025-09-17 13:43:55', 'ahmad', '21554654', 3, 'puas', 1),
	(12, NULL, '2025-09-17 12:45:05', 'ilham', '21543321', 6, 'puas', 1),
	(13, NULL, '2025-09-19 13:47:47', 'rendi', '21441132', 1, 'tidak_puas', 1),
	(14, NULL, '2025-09-19 13:48:53', 'ardi', '14222125', 5, 'tidak_puas', 1),
	(15, NULL, '2025-09-19 13:49:43', 'silvi', '24215612', 8, 'tidak_puas', 1),
	(16, NULL, '2025-09-19 15:59:51', 'ilmi', '21545121', 6, 'puas', 1),
	(27, NULL, '2025-09-24 14:41:16', 'sifa', '25149125', 2, 'puas', 1);

-- Dumping structure for table si_peka.responden_detail
CREATE TABLE IF NOT EXISTS `responden_detail` (
  `idresponden_detail` bigint NOT NULL AUTO_INCREMENT,
  `idresponden` bigint DEFAULT NULL,
  `idlayanan_petugas` int DEFAULT NULL,
  `description_layanan_petugas` text,
  `idlayanan_fasilitas` int DEFAULT NULL,
  `description_layanan_fasilitas` text,
  `idlayanan_prosedur` int DEFAULT NULL,
  `description_layanan_prosedur` text,
  `idlayanan_waktu` int DEFAULT NULL,
  `description_layanan_waktu` text,
  PRIMARY KEY (`idresponden_detail`),
  KEY `idresponden` (`idresponden`),
  KEY `idlayanan_petugas` (`idlayanan_petugas`),
  KEY `idlayanan_fasilitas` (`idlayanan_fasilitas`),
  KEY `idlayanan_prosedur` (`idlayanan_prosedur`),
  KEY `idlayanan_waktu` (`idlayanan_waktu`),
  CONSTRAINT `FK_responden_detail_responden` FOREIGN KEY (`idresponden`) REFERENCES `responden` (`idresponden`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table si_peka.responden_detail: ~76 rows (approximately)
INSERT INTO `responden_detail` (`idresponden_detail`, `idresponden`, `idlayanan_petugas`, `description_layanan_petugas`, `idlayanan_fasilitas`, `description_layanan_fasilitas`, `idlayanan_prosedur`, `description_layanan_prosedur`, `idlayanan_waktu`, `description_layanan_waktu`) VALUES
	(1, 3, 1, 'semua petugasnya ramah', NULL, NULL, NULL, NULL, NULL, NULL),
	(2, 3, 3, 'semua petugasnya ramah', NULL, NULL, NULL, NULL, NULL, NULL),
	(3, 3, 4, 'semua petugasnya ramah', NULL, NULL, NULL, NULL, NULL, NULL),
	(4, 3, 9, 'semua petugasnya ramah', NULL, NULL, NULL, NULL, NULL, NULL),
	(5, 3, NULL, NULL, 14, 'aman', NULL, NULL, NULL, NULL),
	(6, 3, NULL, NULL, NULL, NULL, 1, 'sesuai prosedur', NULL, NULL),
	(7, 3, NULL, NULL, NULL, NULL, NULL, NULL, 3, 'pelayanannya cepat'),
	(8, 4, 2, 'ramah', NULL, NULL, NULL, NULL, NULL, NULL),
	(9, 4, NULL, NULL, 2, 'cukup', NULL, NULL, NULL, NULL),
	(10, 4, NULL, NULL, NULL, NULL, 2, 'sesuai', NULL, NULL),
	(11, 4, NULL, NULL, NULL, NULL, NULL, NULL, 2, 'cepat'),
	(12, 5, 4, '-', NULL, NULL, NULL, NULL, NULL, NULL),
	(13, 5, NULL, NULL, 2, '-', NULL, NULL, NULL, NULL),
	(14, 5, NULL, NULL, NULL, NULL, 2, '-', NULL, NULL),
	(15, 5, NULL, NULL, NULL, NULL, NULL, NULL, 4, '-'),
	(16, 6, 2, 'petugas yang berjaga cepat tanggap dan ramah', NULL, NULL, NULL, NULL, NULL, NULL),
	(17, 6, 4, 'petugas yang berjaga cepat tanggap dan ramah', NULL, NULL, NULL, NULL, NULL, NULL),
	(18, 6, 9, 'petugas yang berjaga cepat tanggap dan ramah', NULL, NULL, NULL, NULL, NULL, NULL),
	(19, 6, 10, 'petugas yang berjaga cepat tanggap dan ramah', NULL, NULL, NULL, NULL, NULL, NULL),
	(20, 6, 11, 'petugas yang berjaga cepat tanggap dan ramah', NULL, NULL, NULL, NULL, NULL, NULL),
	(21, 6, NULL, NULL, 2, 'fasilitas di rumah sakit sudah cukup mumpuni', NULL, NULL, NULL, NULL),
	(22, 6, NULL, NULL, 10, 'fasilitas di rumah sakit sudah cukup mumpuni', NULL, NULL, NULL, NULL),
	(23, 6, NULL, NULL, 11, 'fasilitas di rumah sakit sudah cukup mumpuni', NULL, NULL, NULL, NULL),
	(24, 6, NULL, NULL, NULL, NULL, 11, 'prosedurnya sudah dijalankan dengan baik', NULL, NULL),
	(25, 6, NULL, NULL, NULL, NULL, NULL, NULL, 2, 'waktu layanannya cepat'),
	(26, 6, NULL, NULL, NULL, NULL, NULL, NULL, 11, 'waktu layanannya cepat'),
	(27, 7, 5, '-', NULL, NULL, NULL, NULL, NULL, NULL),
	(28, 7, NULL, NULL, 5, '-', NULL, NULL, NULL, NULL),
	(29, 7, NULL, NULL, NULL, NULL, 5, '-', NULL, NULL),
	(30, 7, NULL, NULL, NULL, NULL, NULL, NULL, 5, '-'),
	(32, 8, 1, 'ramah', NULL, NULL, NULL, NULL, NULL, NULL),
	(33, 8, NULL, NULL, 1, '-', NULL, NULL, NULL, NULL),
	(34, 8, NULL, NULL, NULL, NULL, 1, 'sesuai prosedur', NULL, NULL),
	(35, 8, NULL, NULL, NULL, NULL, NULL, NULL, 1, '-'),
	(36, 9, 10, '-', NULL, NULL, NULL, NULL, NULL, NULL),
	(37, 9, NULL, NULL, 10, 'cukup', NULL, NULL, NULL, NULL),
	(38, 9, NULL, NULL, NULL, NULL, 10, 'sesuai prosedur', NULL, NULL),
	(39, 9, NULL, NULL, NULL, NULL, NULL, NULL, 10, '-'),
	(40, 10, 1, 'ramah', NULL, NULL, NULL, NULL, NULL, NULL),
	(41, 10, 2, 'ramah', NULL, NULL, NULL, NULL, NULL, NULL),
	(42, 10, 10, 'ramah', NULL, NULL, NULL, NULL, NULL, NULL),
	(43, 10, NULL, NULL, 10, 'cukup', NULL, NULL, NULL, NULL),
	(44, 10, NULL, NULL, NULL, NULL, 10, '-', NULL, NULL),
	(45, 10, NULL, NULL, NULL, NULL, NULL, NULL, 10, 'waktu layanannya cepat'),
	(46, 11, 3, '-', NULL, NULL, NULL, NULL, NULL, NULL),
	(47, 11, NULL, NULL, 2, 'cukup', NULL, NULL, NULL, NULL),
	(48, 11, NULL, NULL, NULL, NULL, 2, '-', NULL, NULL),
	(49, 11, NULL, NULL, NULL, NULL, NULL, NULL, 3, 'waktu layanannya cepat'),
	(50, 12, 1, 'petugas yang berjaga cepat tanggap dan ramah', NULL, NULL, NULL, NULL, NULL, NULL),
	(51, 12, 5, 'petugas yang berjaga cepat tanggap dan ramah', NULL, NULL, NULL, NULL, NULL, NULL),
	(52, 12, NULL, NULL, 1, 'cukup mumpuni', NULL, NULL, NULL, NULL),
	(53, 12, NULL, NULL, 5, 'cukup mumpuni', NULL, NULL, NULL, NULL),
	(54, 12, NULL, NULL, NULL, NULL, 1, 'sesuai prosedur', NULL, NULL),
	(55, 12, NULL, NULL, NULL, NULL, 5, 'sesuai prosedur', NULL, NULL),
	(56, 12, NULL, NULL, NULL, NULL, NULL, NULL, 5, '-'),
	(57, 13, 1, 'kurang', NULL, NULL, NULL, NULL, NULL, NULL),
	(58, 13, NULL, NULL, 1, 'kurang', NULL, NULL, NULL, NULL),
	(59, 13, NULL, NULL, NULL, NULL, 1, 'kurang', NULL, NULL),
	(60, 13, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'kurang'),
	(61, 14, 1, 'kurang', NULL, NULL, NULL, NULL, NULL, NULL),
	(62, 14, 10, 'kurang', NULL, NULL, NULL, NULL, NULL, NULL),
	(63, 14, NULL, NULL, 10, 'kurang', NULL, NULL, NULL, NULL),
	(64, 14, NULL, NULL, NULL, NULL, 1, 'kurang', NULL, NULL),
	(65, 14, NULL, NULL, NULL, NULL, 10, 'kurang', NULL, NULL),
	(66, 14, NULL, NULL, NULL, NULL, NULL, NULL, 10, 'kurang'),
	(67, 15, 13, 'kurang', NULL, NULL, NULL, NULL, NULL, NULL),
	(68, 15, NULL, NULL, 13, '-', NULL, NULL, NULL, NULL),
	(69, 15, NULL, NULL, NULL, NULL, 13, 'kurang', NULL, NULL),
	(70, 15, NULL, NULL, NULL, NULL, NULL, NULL, 13, 'kurang'),
	(71, 16, 1, '-', NULL, NULL, NULL, NULL, NULL, NULL),
	(72, 16, 2, '-', NULL, NULL, NULL, NULL, NULL, NULL),
	(73, 16, 4, '-', NULL, NULL, NULL, NULL, NULL, NULL),
	(74, 16, NULL, NULL, 1, '-', NULL, NULL, NULL, NULL),
	(75, 16, NULL, NULL, NULL, NULL, 1, '-', NULL, NULL),
	(76, 16, NULL, NULL, NULL, NULL, NULL, NULL, 1, '-'),
	(77, 27, 1, 'ok', NULL, NULL, NULL, NULL, NULL, NULL),
	(78, 27, 4, 'ok', NULL, NULL, NULL, NULL, NULL, NULL),
	(79, 27, 5, 'ok', NULL, NULL, NULL, NULL, NULL, NULL),
	(80, 27, 9, 'ok', NULL, NULL, NULL, NULL, NULL, NULL),
	(81, 27, NULL, NULL, 1, 'ok', NULL, NULL, NULL, NULL),
	(82, 27, NULL, NULL, 4, 'ok', NULL, NULL, NULL, NULL),
	(83, 27, NULL, NULL, 5, 'ok', NULL, NULL, NULL, NULL),
	(84, 27, NULL, NULL, 9, 'ok', NULL, NULL, NULL, NULL),
	(85, 27, NULL, NULL, NULL, NULL, 1, 'ok', NULL, NULL),
	(86, 27, NULL, NULL, NULL, NULL, 4, 'ok', NULL, NULL),
	(87, 27, NULL, NULL, NULL, NULL, 5, 'ok', NULL, NULL),
	(88, 27, NULL, NULL, NULL, NULL, 9, 'ok', NULL, NULL),
	(89, 27, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'ok'),
	(90, 27, NULL, NULL, NULL, NULL, NULL, NULL, 4, 'ok'),
	(91, 27, NULL, NULL, NULL, NULL, NULL, NULL, 5, 'ok'),
	(92, 27, NULL, NULL, NULL, NULL, NULL, NULL, 9, 'ok');

-- Dumping structure for table si_peka.role
CREATE TABLE IF NOT EXISTS `role` (
  `idrole` int NOT NULL AUTO_INCREMENT,
  `parent` int DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdby` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedby` varchar(50) DEFAULT NULL,
  `status` int DEFAULT '1',
  PRIMARY KEY (`idrole`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table si_peka.role: ~2 rows (approximately)
INSERT INTO `role` (`idrole`, `parent`, `name`, `title`, `description`, `created`, `createdby`, `updated`, `updatedby`, `status`) VALUES
	(1, 0, 'administrator', 'Superadmin', 'Superadmin', '2022-04-04 12:00:00', 'superadmin', '2022-04-04 12:00:00', 'superadmin', 1);

-- Dumping structure for table si_peka.ruangan
CREATE TABLE IF NOT EXISTS `ruangan` (
  `idruangan` int NOT NULL AUTO_INCREMENT,
  `nama_ruangan` varchar(200) DEFAULT NULL,
  `is_active` int DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `createdby` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedby` varchar(50) DEFAULT NULL,
  `status` int DEFAULT '1',
  PRIMARY KEY (`idruangan`),
  KEY `nama_ruangan` (`nama_ruangan`),
  KEY `status` (`status`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table si_peka.ruangan: ~10 rows (approximately)
INSERT INTO `ruangan` (`idruangan`, `nama_ruangan`, `is_active`, `created`, `createdby`, `updated`, `updatedby`, `status`) VALUES
	(1, 'Anggrek', 1, '2025-08-22 19:14:08', 'BucinBGMID', '2025-08-22 19:14:08', 'BucinBGMID', 1),
	(2, 'Teratai', 1, '2025-08-22 19:16:04', 'BucinBGMID', '2025-08-22 19:16:04', 'BucinBGMID', 1),
	(3, 'Asoka', 1, '2025-08-22 19:17:32', 'BucinBGMID', '2025-08-22 19:17:33', 'BucinBGMID', 1),
	(4, 'Tulip', 1, '2025-08-22 19:17:37', 'BucinBGMID', '2025-08-22 19:17:38', 'BucinBGMID', 1),
	(5, 'Dahlia', 1, '2025-08-22 19:17:45', 'BucinBGMID', '2025-08-22 19:17:46', 'BucinBGMID', 1),
	(6, 'Wijaya Kusuma', 1, '2025-08-22 19:17:57', 'BucinBGMID', '2025-08-22 19:17:58', 'BucinBGMID', 1),
	(7, 'Melati', 1, '2025-08-22 19:18:05', 'BucinBGMID', '2025-08-22 19:18:05', 'BucinBGMID', 1),
	(8, 'RIK', 1, '2025-08-22 19:18:13', 'BucinBGMID', '2025-08-22 19:18:14', 'BucinBGMID', 1),
	(9, 'Sakura ta', 1, '2025-08-22 19:18:19', 'BucinBGMID', '2025-08-22 19:18:28', 'BucinBGMID', 0),
	(10, 'Sakura', 1, '2025-08-22 19:18:35', 'BucinBGMID', '2025-09-01 16:00:45', 'superadmin', 0),
	(11, 'Sakurasss', 1, '2025-08-23 11:19:03', 'BucinBGMID', '2025-08-23 11:19:06', 'BucinBGMID', 0);

-- Dumping structure for table si_peka.user
CREATE TABLE IF NOT EXISTS `user` (
  `iduser` bigint unsigned NOT NULL AUTO_INCREMENT,
  `idrole` int DEFAULT NULL,
  `username` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `is_active` int DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `createdby` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedby` varchar(50) DEFAULT NULL,
  `status` int DEFAULT '1',
  PRIMARY KEY (`iduser`),
  KEY `FK_user_role` (`idrole`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table si_peka.user: ~3 rows (approximately)
INSERT INTO `user` (`iduser`, `idrole`, `username`, `password`, `name`, `email`, `is_active`, `created`, `createdby`, `updated`, `updatedby`, `status`) VALUES
	(1, NULL, 'BucinBGMID', '5f4dcc3b5aa765d61d8327deb882cf99', 'IT Support', NULL, 1, '2018-04-03 14:14:10', NULL, '2018-04-03 14:14:10', NULL, 1),
	(2, 1, 'superadmin', '5f4dcc3b5aa765d61d8327deb882cf99', 'superadmin', 'superadmin@gmail.com', 1, '2018-08-02 08:38:40', 'superadmin', '2025-06-25 10:24:24', 'BucinBGMID', 1);

-- Dumping structure for table si_peka.user_role
CREATE TABLE IF NOT EXISTS `user_role` (
  `iduser_role` int NOT NULL AUTO_INCREMENT,
  `idrole` int DEFAULT NULL,
  `menu_name` varchar(200) DEFAULT NULL,
  `access` int DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdby` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedby` varchar(50) DEFAULT NULL,
  `status` int DEFAULT '1',
  PRIMARY KEY (`iduser_role`),
  KEY `FK_user_role_role` (`idrole`),
  CONSTRAINT `FK_user_role_role` FOREIGN KEY (`idrole`) REFERENCES `role` (`idrole`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Dumping data for table si_peka.user_role: ~11 rows (approximately)
INSERT INTO `user_role` (`iduser_role`, `idrole`, `menu_name`, `access`, `created`, `createdby`, `updated`, `updatedby`, `status`) VALUES
	(1, 1, 'role_table', 1, '2025-08-22 19:06:22', 'BucinBGMID', '2025-09-11 09:47:52', 'superadmin', 1),
	(2, 1, 'dashboard', 1, '2025-08-22 19:06:22', 'BucinBGMID', '2025-09-11 09:47:52', 'superadmin', 1),
	(3, 1, 'role_view_ruangan', 0, '2025-08-22 19:06:22', 'BucinBGMID', '2025-09-11 09:47:52', 'superadmin', 1),
	(4, 1, 'ruangan', 1, '2025-08-22 19:06:22', 'BucinBGMID', '2025-09-11 09:47:52', 'superadmin', 1),
	(5, 1, 'role_view_komponen', 0, '2025-08-22 19:06:22', 'BucinBGMID', '2025-09-11 09:47:52', 'superadmin', 1),
	(6, 1, 'komponen', 1, '2025-08-22 19:06:22', 'BucinBGMID', '2025-09-11 09:47:52', 'superadmin', 1),
	(7, 1, 'role_view_layanan', 0, '2025-08-22 19:06:22', 'BucinBGMID', '2025-09-11 09:47:52', 'superadmin', 1),
	(8, 1, 'layanan', 1, '2025-08-22 19:06:22', 'BucinBGMID', '2025-09-11 09:47:52', 'superadmin', 1),
	(9, 1, 'user', 1, '2025-08-22 19:06:22', 'BucinBGMID', '2025-09-11 09:47:52', 'superadmin', 1),
	(10, 1, 'user_user', 1, '2025-08-22 19:06:22', 'BucinBGMID', '2025-09-11 09:47:52', 'superadmin', 1),
	(11, 1, 'user_user_role', 1, '2025-08-22 19:06:22', 'BucinBGMID', '2025-09-11 09:47:52', 'superadmin', 1),
	(12, 1, 'role_view_responden', 0, '2025-09-11 09:47:52', 'superadmin', NULL, NULL, 1),
	(13, 1, 'responden', 1, '2025-09-11 09:47:52', 'superadmin', NULL, NULL, 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
