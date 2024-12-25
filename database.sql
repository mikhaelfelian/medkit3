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

-- Dumping structure for table db_medkit3.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) DEFAULT NULL,
  `executed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_medkit3.migrations: ~0 rows (approximately)
DELETE FROM `migrations`;

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
  `status_obat` int(11) DEFAULT 0 COMMENT '1=obat;\r\n2=racikan;\r\n3=tindakan\r\n4=lab;\r\n5=radiologi;\r\n6=bhp;',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table db_medkit3.tbl_m_items: ~0 rows (approximately)
DELETE FROM `tbl_m_items`;

-- Dumping structure for table db_medkit3.tbl_m_pasien
DROP TABLE IF EXISTS `tbl_m_pasien`;
CREATE TABLE IF NOT EXISTS `tbl_m_pasien` (
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table db_medkit3.tbl_m_pasien: ~2 rows (approximately)
DELETE FROM `tbl_m_pasien`;
INSERT INTO `tbl_m_pasien` (`id`, `kode`, `nik`, `nama`, `nama_pgl`, `no_hp`, `alamat`, `alamat_domisili`, `rt`, `rw`, `kelurahan`, `kecamatan`, `kota`, `pekerjaan`, `created_at`, `updated_at`) VALUES
	(4, 'RM-2412-0001', '3374072807190003', 'COSMOS BIN SULEMAN', 'COSMOS', '085741220427', 'Perum Mutiara Pandanaran Blok D11, Mangunharjo, Tembalang, Kota Semarang', 'asas', '11', '1', '1', '1', 'Semarang', '11', '2024-12-23 05:28:38', '2024-12-24 07:44:19'),
	(5, 'RM-2412-0002', '3374071502920002', 'MIKHAEL FELIAN WASKITO, S.Pd', 'Mikess', '085741220427', 'Perum Mutiara Pandanaran Blok D11, Mangunharjo, Tembalang, Kota Semarang', '-', '11', '001', 'MANGUNHARJO', 'TEMBALANG', 'Semarang', '-', '2024-12-23 07:41:46', '2024-12-25 14:08:47');

-- Dumping structure for table db_medkit3.tbl_pengaturan
DROP TABLE IF EXISTS `tbl_pengaturan`;
CREATE TABLE IF NOT EXISTS `tbl_pengaturan` (
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

-- Dumping data for table db_medkit3.tbl_pengaturan: ~1 rows (approximately)
DELETE FROM `tbl_pengaturan`;
INSERT INTO `tbl_pengaturan` (`id`, `updated_at`, `judul`, `judul_app`, `alamat`, `deskripsi`, `kota`, `url`, `theme`, `pagination_limit`, `favicon`, `logo`) VALUES
	(1, '2024-12-24 17:32:39', 'SIMRS Esensia', 'MEDKIT APP', 'MANGUNHARJO, TEMBALANGsss', 'sasa', 'KOTA SEMARANG', 'http://localhost/medkit3/', 'default', 10, 'public/file/app/favicon_1735061559.png', 'public/file/app/logo_1735058637.png');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
