<?php
class Migration_create_tbl_m_gudangs extends Migration {
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName('m_gudangs') . "` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `created_at` DATETIME NULL DEFAULT NULL,
            `updated_at` DATETIME NULL DEFAULT NULL,
            `kode` VARCHAR(160) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
            `gudang` VARCHAR(160) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
            `keterangan` TEXT NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
            `status` ENUM('0','1') NULL DEFAULT NULL COMMENT '1 = aktif\r\n0 = Non Aktif' COLLATE 'latin1_swedish_ci',
            `status_gd` ENUM('0','1') NULL DEFAULT '0' COMMENT '1 = Gudang Utama\r\n0 = Bukan Gudang Utama' COLLATE 'latin1_swedish_ci',
            PRIMARY KEY (`id`) USING BTREE
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;";

        return $sql;
    }

    public function down() {
        return "DROP TABLE IF EXISTS `" . $this->getTableName('m_gudangs') . "`;";
    }

    public function getDescription() {
        return "Create table " . $this->getTableName('m_gudangs');
    }
} 