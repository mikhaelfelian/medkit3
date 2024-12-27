<?php
class Migration_create_tbl_m_merks extends Migration {
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName('m_merks') . "` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `created_at` DATETIME NULL DEFAULT NULL,
            `updated_at` DATETIME NULL DEFAULT NULL,
            `merk` VARCHAR(160) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
            `keterangan` TEXT NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
            `status` ENUM('0','1') NULL DEFAULT '0' COLLATE 'latin1_swedish_ci',
            `status_hps` ENUM('0','1') NULL DEFAULT '0' COLLATE 'latin1_swedish_ci',
            PRIMARY KEY (`id`) USING BTREE
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE='latin1_swedish_ci' AUTO_INCREMENT=1;";

        return $sql;
    }

    public function down() {
        return "DROP TABLE IF EXISTS `" . $this->getTableName('m_merks') . "`;";
    }

    public function getDescription() {
        return "Create table " . $this->getTableName('m_merks');
    }
} 