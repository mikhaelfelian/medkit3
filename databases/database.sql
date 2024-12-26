-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table db_medkit3.tbl_migrations
DROP TABLE IF EXISTS `tbl_migrations`;
CREATE TABLE IF NOT EXISTS `tbl_migrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `executed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `execution_time` float DEFAULT NULL COMMENT 'Time in seconds',
  `status` enum('success','failed') NOT NULL DEFAULT 'success',
  `error_message` text DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- Dumping data for table db_medkit3.tbl_migrations: ~21 rows (approximately)
DELETE FROM `tbl_migrations`;
INSERT INTO `tbl_migrations` (`id`, `migration`, `executed_at`, `execution_time`, `status`, `error_message`, `description`) VALUES
	(1, 'Migration_create_tbl_migrations', '2024-12-25 15:05:41', 0.0174, 'success', NULL, 'Create table tbl_migrations'),
	(2, 'Migration_create_tbl_m_items', '2024-12-25 15:05:41', 0.0161, 'success', NULL, 'Create table tbl_m_items'),
	(3, 'Migration_create_tbl_m_pasiens', '2024-12-25 15:05:41', 0.0182, 'success', NULL, 'Create table tbl_m_pasiens'),
	(4, 'Migration_create_tbl_pengaturans', '2024-12-25 15:05:42', 0.0233, 'success', NULL, 'Create table tbl_pengaturans'),
	(5, 'Migration_create_tbl_migrations', '2024-12-26 04:51:47', 0.0005, 'success', NULL, 'Create table tbl_migrations'),
	(6, 'Migration_create_tbl_m_gudangs', '2024-12-26 04:51:47', 0.0216, 'success', NULL, 'Create table tbl_m_gudangs'),
	(7, 'Migration_create_tbl_m_items', '2024-12-26 04:51:47', 0.0001, 'success', NULL, 'Create table tbl_m_items'),
	(8, 'Migration_create_tbl_m_pasiens', '2024-12-26 04:51:47', 0.0001, 'success', NULL, 'Create table tbl_m_pasiens'),
	(9, 'Migration_create_tbl_pengaturans', '2024-12-26 04:51:47', NULL, 'failed', 'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry \'1\' for key \'PRIMARY\'', 'Create table tbl_pengaturans'),
	(10, 'Migration_create_tbl_migrations', '2024-12-26 05:16:32', 0.0003, 'success', NULL, 'Create table tbl_migrations'),
	(11, 'Migration_alter_tbl_m_gudangs_add_status_gd', '2024-12-26 05:16:32', 0.009, 'success', NULL, 'Add status_gd column to tbl_m_gudangs'),
	(12, 'Migration_create_tbl_m_gudangs', '2024-12-26 05:16:32', 0.0004, 'success', NULL, 'Create table tbl_m_gudangs'),
	(13, 'Migration_create_tbl_m_items', '2024-12-26 05:16:32', 0.0003, 'success', NULL, 'Create table tbl_m_items'),
	(14, 'Migration_create_tbl_m_pasiens', '2024-12-26 05:16:32', 0.0002, 'success', NULL, 'Create table tbl_m_pasiens'),
	(15, 'Migration_create_tbl_pengaturans', '2024-12-26 05:16:32', NULL, 'failed', 'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry \'1\' for key \'PRIMARY\'', 'Create table tbl_pengaturans'),
	(16, 'Migration_create_tbl_migrations', '2024-12-26 14:44:40', 0.013, 'success', NULL, 'Create table tbl_migrations'),
	(17, 'Migration_create_tbl_migrations', '2024-12-26 15:47:15', 0.0098, 'success', NULL, 'Create table tbl_migrations'),
	(18, 'Migration_create_tbl_m_gudangs', '2024-12-26 15:47:15', 0.0005, 'success', NULL, 'Create table tbl_m_gudangs'),
	(19, 'Migration_create_tbl_m_items', '2024-12-26 15:47:15', 0.0017, 'success', NULL, 'Create table tbl_m_items'),
	(20, 'Migration_create_tbl_m_pasiens', '2024-12-26 15:47:15', 0.0003, 'success', NULL, 'Create table tbl_m_pasiens'),
	(21, 'Migration_create_tbl_pengaturans', '2024-12-26 15:47:15', NULL, 'failed', 'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry \'1\' for key \'PRIMARY\'', 'Create table tbl_pengaturans');

-- Dumping structure for table db_medkit3.tbl_m_gudangs
DROP TABLE IF EXISTS `tbl_m_gudangs`;
CREATE TABLE IF NOT EXISTS `tbl_m_gudangs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `kode` varchar(160) DEFAULT NULL,
  `gudang` varchar(160) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('0','1','2','3') DEFAULT NULL COMMENT '1 = Gudang aktif\r\n0 = Gudang Non Aktif',
  `status_gd` enum('0','1') DEFAULT '0' COMMENT '1 = Gudang Utama\r\n0 = Bukan Gudang Utama',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table db_medkit3.tbl_m_gudangs: ~2 rows (approximately)
DELETE FROM `tbl_m_gudangs`;
INSERT INTO `tbl_m_gudangs` (`id`, `created_at`, `updated_at`, `kode`, `gudang`, `keterangan`, `status`, `status_gd`) VALUES
	(1, '2024-12-26 12:04:08', NULL, 'SRG-01', 'Gudang Utama', 'ii', '1', '0'),
	(2, '2024-12-26 12:04:33', '2024-12-26 23:25:03', 'SRG-02', 'Gudang Atas', '-', '1', '0');

-- Dumping structure for table db_medkit3.tbl_m_items
DROP TABLE IF EXISTS `tbl_m_items`;
CREATE TABLE IF NOT EXISTS `tbl_m_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_satuan` int(11) DEFAULT 7,
  `id_kategori` int(11) DEFAULT 0,
  `id_kategori_lab` int(11) DEFAULT 0,
  `id_kategori_gol` int(11) DEFAULT 0,
  `id_lokasi` int(11) DEFAULT 0,
  `id_merk` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `kode` varchar(65) DEFAULT NULL,
  `barcode` varchar(65) DEFAULT NULL,
  `item` varchar(160) DEFAULT NULL,
  `item_alias` text DEFAULT NULL COMMENT 'alias',
  `item_kand` text DEFAULT NULL COMMENT 'kandungan',
  `jml` float DEFAULT NULL,
  `jml_limit` float DEFAULT 0,
  `harga_beli` decimal(10,2) DEFAULT NULL,
  `harga_jual` decimal(10,2) DEFAULT NULL,
  `remun_tipe` enum('0','1','2') DEFAULT '0',
  `remun_perc` decimal(10,2) DEFAULT 0.00,
  `remun_nom` decimal(10,2) DEFAULT 0.00,
  `apres_tipe` enum('0','1','2') DEFAULT '0',
  `apres_perc` decimal(10,2) DEFAULT 0.00,
  `apres_nom` decimal(10,2) unsigned DEFAULT 0.00,
  `status` enum('0','1') DEFAULT '0',
  `status_stok` enum('0','1') DEFAULT '0',
  `status_racikan` enum('0','1') DEFAULT '0',
  `status_hps` enum('0','1') DEFAULT '0',
  `status_obat` int(11) DEFAULT 0 COMMENT '1=obat;2=racikan;3=tindakan;4=lab;5=radiologi;6=bhp;',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table db_medkit3.tbl_m_items: ~0 rows (approximately)
DELETE FROM `tbl_m_items`;

-- Dumping structure for table db_medkit3.tbl_m_pasiens
DROP TABLE IF EXISTS `tbl_m_pasiens`;
CREATE TABLE IF NOT EXISTS `tbl_m_pasiens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nama_pgl` varchar(50) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `alamat_domisili` text DEFAULT NULL,
  `rt` varchar(3) DEFAULT NULL,
  `rw` varchar(3) DEFAULT NULL,
  `kelurahan` varchar(50) DEFAULT NULL,
  `kecamatan` varchar(50) DEFAULT NULL,
  `kota` varchar(50) DEFAULT NULL,
  `pekerjaan` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`),
  UNIQUE KEY `nik` (`nik`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table db_medkit3.tbl_m_pasiens: ~1 rows (approximately)
DELETE FROM `tbl_m_pasiens`;
INSERT INTO `tbl_m_pasiens` (`id`, `kode`, `nik`, `nama`, `nama_pgl`, `no_hp`, `alamat`, `alamat_domisili`, `rt`, `rw`, `kelurahan`, `kecamatan`, `kota`, `pekerjaan`, `created_at`, `updated_at`) VALUES
	(1, 'P24120001', '3374072807190003', 'Mikhael Felian Waskito, S.Pd', 'COSMOS', '085741220427', 'Perum Mutiara Pandanaran Blok D11, Mangunharjo, Tembalang, KOta Semarang', '-', '-', '-', '-', '-', 'Semarang', '-', '2024-12-25 15:10:38', '2024-12-25 16:30:54');

-- Dumping structure for table db_medkit3.tbl_pengaturans
DROP TABLE IF EXISTS `tbl_pengaturans`;
CREATE TABLE IF NOT EXISTS `tbl_pengaturans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `judul` varchar(100) DEFAULT NULL,
  `judul_app` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `theme` varchar(50) DEFAULT NULL,
  `pagination_limit` int(11) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table db_medkit3.tbl_pengaturans: ~1 rows (approximately)
DELETE FROM `tbl_pengaturans`;
INSERT INTO `tbl_pengaturans` (`id`, `updated_at`, `judul`, `judul_app`, `alamat`, `deskripsi`, `kota`, `url`, `theme`, `pagination_limit`, `favicon`, `logo`) VALUES
	(1, '2024-12-26 16:25:09', 'SIMRS ESENSIAs', 'SIMEDIS', 'Perum Mutiara Pandanaran Blok D11', 'SIMEDIS is an part of SIMRS application', 'KOTA SEMARANG', 'http://localhost/medkit3/', 'default', 10, 'public/file/app/favicon_1735061559.png', 'public/file/app/logo_1735058637.png');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
