<?php

class Migration_Create_tbl_m_kategoris extends Migration {
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName('m_kategoris') . "` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `created_at` DATETIME NOT NULL DEFAULT current_timestamp(),
            `updated_at` DATETIME NULL DEFAULT '0000-00-00 00:00:00',
            `kode` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
            `kategori` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
            `keterangan` TEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
            `status` ENUM('0','1') NULL DEFAULT '0' COLLATE 'latin1_swedish_ci',
            PRIMARY KEY (`id`) USING BTREE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_general_ci' AUTO_INCREMENT=1
        COMMENT='Untuk menyimpan data kategori obat';";

        return $sql;
    }

    public function down() {
        return "DROP TABLE IF EXISTS `" . $this->getTableName('m_kategoris') . "`;";
    }

    public function getDescription() {
        return "Create table " . $this->getTableName('m_kategoris');
    }
} 