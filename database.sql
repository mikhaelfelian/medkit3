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

-- Dumping data for table db_medkit3.tbl_m_pasien: ~3 rows (approximately)
DELETE FROM `tbl_m_pasien`;
INSERT INTO `tbl_m_pasien` (`id`, `kode`, `nik`, `nama`, `nama_pgl`, `no_hp`, `alamat`, `alamat_domisili`, `rt`, `rw`, `kelurahan`, `kecamatan`, `kota`, `pekerjaan`, `created_at`, `updated_at`) VALUES
	(4, 'RM-2412-0001', '3374072807190003', 'COSMOS BIN SULEMAN', 'COSMOS', '085741220427', 'Perum Mutiara Pandanaran Blok D11, Mangunharjo, Tembalang, KOta Semarang', 'asas', '11', '1', '1', '1', 'Semarang', '11', '2024-12-23 05:28:38', '2024-12-23 07:41:14'),
	(5, 'RM-2412-0002', '3374071502920002', 'Mikhael Felian Waskito', 'Mike', '085741220427', 'Perum Mutiara Pandanaran Blok D11, Mangunharjo, Tembalang, KOta Semarang', '-', '11', '001', 'MANGUNHARJO', 'TEMBALANG', 'Semarang', '-', '2024-12-23 07:41:46', '2024-12-23 07:42:44');

-- Dumping structure for table db_medkit3.tbl_pengaturan
DROP TABLE IF EXISTS `tbl_pengaturan`;
CREATE TABLE IF NOT EXISTS `tbl_pengaturan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `judul` varchar(100) DEFAULT NULL,
  `judul_app` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
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
INSERT INTO `tbl_pengaturan` (`id`, `updated_at`, `judul`, `judul_app`, `alamat`, `kota`, `url`, `theme`, `pagination_limit`, `favicon`, `logo`) VALUES
	(1, '2024-12-23 08:25:28', 'PERUM MUTIARA PANDANARAN', 'SIMRS ESENSIA', 'MANGUNHARJO, TEMBALANG', 'KOTA SEMARANG', 'http://localhost/pam/', 'default', 10, '', '');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
