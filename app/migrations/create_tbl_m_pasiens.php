<?php
class Migration_create_tbl_m_pasiens extends Migration {
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName('m_pasiens') . "` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `kode` VARCHAR(20) NOT NULL,
            `nik` VARCHAR(16) NOT NULL,
            `nama` VARCHAR(100) NOT NULL,
            `nama_pgl` VARCHAR(50) NULL DEFAULT NULL,
            `no_hp` VARCHAR(15) NULL DEFAULT NULL,
            `alamat` TEXT NULL DEFAULT NULL,
            `alamat_domisili` TEXT NULL DEFAULT NULL,
            `rt` VARCHAR(3) NULL DEFAULT NULL,
            `rw` VARCHAR(3) NULL DEFAULT NULL,
            `kelurahan` VARCHAR(50) NULL DEFAULT NULL,
            `kecamatan` VARCHAR(50) NULL DEFAULT NULL,
            `kota` VARCHAR(50) NULL DEFAULT NULL,
            `pekerjaan` VARCHAR(100) NULL DEFAULT NULL,
            `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `kode` (`kode`),
            UNIQUE KEY `nik` (`nik`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

        return $sql;
    }

    public function down() {
        return "DROP TABLE IF EXISTS `" . $this->getTableName('m_pasiens') . "`;";
    }

    public function getDescription() {
        return "Create table " . $this->getTableName('m_pasiens');
    }
} 