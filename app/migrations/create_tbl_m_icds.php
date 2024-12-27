<?php
class Migration_create_tbl_m_icds extends Migration {
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName('m_icds') . "` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `created_at` DATETIME NOT NULL DEFAULT current_timestamp(),
            `updated_at` DATETIME NULL DEFAULT '0000-00-00 00:00:00',
            `kode` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
            `icd` TEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
            `diagnosa_en` TEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
            PRIMARY KEY (`id`) USING BTREE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_general_ci' AUTO_INCREMENT=1
        COMMENT='Untuk menyimpan data tentang ICD 10 (Daftar Penyakit).\r\nsesuai satu sehat';";

        return $sql;
    }

    public function down() {
        return "DROP TABLE IF EXISTS `" . $this->getTableName('m_icds') . "`;";
    }

    public function getDescription() {
        return "Create table " . $this->getTableName('m_icds');
    }
} 