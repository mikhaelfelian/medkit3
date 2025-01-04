<?php
require_once SYSTEM_PATH . '/databases/Migration.php';

class Migration_create_tbl_m_penjamins extends Migration {
    
    public function getDescription() {
        return "Create table tbl_m_penjamins";
    }
    
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName('m_penjamins') . "` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `created_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            `kode` VARCHAR(160) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
            `penjamin` VARCHAR(160) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
            `persen` DECIMAL(10,1) NULL DEFAULT '0.0',
            `status` ENUM('0','1') NULL DEFAULT '0' COLLATE 'utf8mb4_general_ci',
            PRIMARY KEY (`id`) USING BTREE
        ) 
        COMMENT='Tabel master penjamin yang berisi penjamin pelayanan.\r\nYang berupa :\r\n- UMUM (Pasien UMUM / Bayar Duit Cash)\r\n- ASURANSI (Pasien spt Mandiri InHealth, ManuLife, dll)\r\n- BPJS (Pasti sudah tahu semua)'
        COLLATE='utf8mb4_general_ci'
        ENGINE=InnoDB;";

        try {
            $this->conn->exec($sql);
            echo "Table " . $this->getTableName('m_penjamins') . " created successfully\n";
            return true;
        } catch (PDOException $e) {
            echo "Error creating table: " . $e->getMessage() . "\n";
            return false;
        }
    }

    public function down() {
        $sql = "DROP TABLE IF EXISTS `" . $this->getTableName('m_penjamins') . "`;";
        
        try {
            $this->conn->exec($sql);
            echo "Table " . $this->getTableName('m_penjamins') . " dropped successfully\n";
            return true;
        } catch (PDOException $e) {
            echo "Error dropping table: " . $e->getMessage() . "\n";
            return false;
        }
    }
} 