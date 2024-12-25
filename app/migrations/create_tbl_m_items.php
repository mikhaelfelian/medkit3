<?php
class Migration_create_tbl_m_items extends Migration {
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName('m_items') . "` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `id_satuan` INT(11) NULL DEFAULT 7,
            `id_kategori` INT(11) NULL DEFAULT 0,
            `id_kategori_lab` INT(11) NULL DEFAULT 0,
            `id_kategori_gol` INT(11) NULL DEFAULT 0,
            `id_lokasi` INT(11) NULL DEFAULT 0,
            `id_merk` INT(11) NULL DEFAULT 0,
            `id_user` INT(11) NULL DEFAULT 0,
            `created_at` DATETIME NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            `deleted_at` DATETIME NULL DEFAULT NULL,
            `kode` VARCHAR(65) NULL DEFAULT NULL,
            `barcode` VARCHAR(65) NULL DEFAULT NULL,
            `item` VARCHAR(160) NULL DEFAULT NULL,
            `item_alias` TEXT NULL DEFAULT NULL COMMENT 'alias',
            `item_kand` TEXT NULL DEFAULT NULL COMMENT 'kandungan',
            `jml` FLOAT NULL DEFAULT NULL,
            `jml_limit` FLOAT NULL DEFAULT 0,
            `harga_beli` DECIMAL(10,2) NULL DEFAULT NULL,
            `harga_jual` DECIMAL(10,2) NULL DEFAULT NULL,
            `remun_tipe` ENUM('0','1','2') NULL DEFAULT '0',
            `remun_perc` DECIMAL(10,2) NULL DEFAULT 0.00,
            `remun_nom` DECIMAL(10,2) NULL DEFAULT 0.00,
            `apres_tipe` ENUM('0','1','2') NULL DEFAULT '0',
            `apres_perc` DECIMAL(10,2) NULL DEFAULT 0.00,
            `apres_nom` DECIMAL(10,2) UNSIGNED NULL DEFAULT 0.00,
            `status` ENUM('0','1') NULL DEFAULT '0',
            `status_stok` ENUM('0','1') NULL DEFAULT '0',
            `status_racikan` ENUM('0','1') NULL DEFAULT '0',
            `status_hps` ENUM('0','1') NULL DEFAULT '0',
            `status_obat` INT(11) NULL DEFAULT 0 COMMENT '1=obat;2=racikan;3=tindakan;4=lab;5=radiologi;6=bhp;',
            PRIMARY KEY (`id`) USING BTREE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

        return $sql;
    }

    public function down() {
        return "DROP TABLE IF EXISTS `" . $this->getTableName('m_items') . "`;";
    }

    public function getDescription() {
        return "Create table " . $this->getTableName('m_items');
    }
} 