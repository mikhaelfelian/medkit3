<?php
class Migration_create_tbl_m_polis extends Migration {
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName('m_polis') . "` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `created_at` DATETIME NULL DEFAULT NULL,
            `updated_at` DATETIME NULL DEFAULT NULL,
            `kode` VARCHAR(64) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
            `poli` VARCHAR(64) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
            `keterangan` TEXT NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
            `post_location` VARCHAR(100) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
            `status` ENUM('0','1') NULL DEFAULT '0' COLLATE 'latin1_swedish_ci',
            PRIMARY KEY (`id`) USING BTREE
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE='latin1_swedish_ci' AUTO_INCREMENT=1
        COMMENT='Untuk menyimpan data poli/unit layanan';";

        return $sql;
    }

    public function down() {
        return "DROP TABLE IF EXISTS `" . $this->getTableName('m_polis') . "`;";
    }

    public function getDescription() {
        return "Create table " . $this->getTableName('m_polis');
    }
} 