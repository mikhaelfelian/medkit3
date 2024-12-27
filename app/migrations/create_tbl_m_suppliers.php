<?php
class Migration_create_tbl_m_suppliers extends Migration {
    public function getDescription() {
        return "Create suppliers table";
    }

    public function up() {
        $sql = "CREATE TABLE `tbl_m_suppliers` (
            `id` INT(4) NOT NULL AUTO_INCREMENT,
            `created_at` DATETIME NULL DEFAULT NULL,
            `deleted_at` DATETIME NULL DEFAULT NULL,
            `kode` VARCHAR(10) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
            `nama` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
            `npwp` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
            `alamat` TEXT NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
            `kota` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
            `no_tlp` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
            `no_hp` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
            `cp` VARCHAR(20) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
            `status_hps` ENUM('0','1') NULL DEFAULT '0',
            PRIMARY KEY (`id`) USING BTREE
        )
        COLLATE='latin1_swedish_ci'
        ENGINE=InnoDB
        AUTO_INCREMENT=1;";

        return $sql;
    }

    public function down() {
        return "DROP TABLE IF EXISTS `tbl_m_suppliers`;";
    }
} 