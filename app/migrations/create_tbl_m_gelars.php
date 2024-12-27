<?php
class Migration_create_tbl_m_gelars extends Migration {
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName('m_gelars') . "` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `created_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
            `updated_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
            `gelar` VARCHAR(50) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
            `keterangan` VARCHAR(50) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
            PRIMARY KEY (`id`) USING BTREE
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE='latin1_swedish_ci' AUTO_INCREMENT=1;";

        return $sql;
    }

    public function down() {
        return "DROP TABLE IF EXISTS `" . $this->getTableName('m_gelars') . "`;";
    }

    public function getDescription() {
        return "Create table " . $this->getTableName('m_gelars');
    }
} 