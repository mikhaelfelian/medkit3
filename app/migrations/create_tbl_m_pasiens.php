<?php
class Migration_create_tbl_m_pasiens extends Migration {
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName('m_pasiens') . "` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `id_gelar` INT(11) DEFAULT NULL,
            `id_pekerjaan` INT(11) DEFAULT NULL,            
            `id_user` INT(11) DEFAULT NULL,
            `kode` VARCHAR(20) NOT NULL,
            `nik` VARCHAR(16) DEFAULT NULL,
            `nama` VARCHAR(100) NOT NULL,
            `nama_pgl` VARCHAR(20) DEFAULT NULL,
            `jns_klm` ENUM('L', 'P') DEFAULT NULL,
            `tmp_lahir` VARCHAR(50) DEFAULT NULL,
            `tgl_lahir` DATE DEFAULT NULL,
            `no_hp` VARCHAR(15) DEFAULT NULL,
            `alamat` TEXT DEFAULT NULL,
            `alamat_domisili` TEXT DEFAULT NULL,
            `rt` VARCHAR(3) DEFAULT NULL,
            `rw` VARCHAR(3) DEFAULT NULL,
            `kelurahan` VARCHAR(50) DEFAULT NULL,
            `kecamatan` VARCHAR(50) DEFAULT NULL,
            `kota` VARCHAR(50) DEFAULT NULL,
            `pekerjaan` VARCHAR(50) DEFAULT NULL,
            `file_foto` VARCHAR(160) DEFAULT NULL,
            `file_ktp` VARCHAR(160) DEFAULT NULL,
            `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `kode` (`kode`),
            KEY `nik` (`nik`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        return $sql;
    }

    public function down() {
        return "DROP TABLE IF EXISTS `" . $this->getTableName('m_pasiens') . "`;";
    }

    public function getDescription() {
        return "Create table " . $this->getTableName('m_pasiens');
    }
} 