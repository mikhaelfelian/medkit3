<?php
require_once SYSTEM_PATH . '/databases/Migration.php';

class Migration_create_tbl_m_item_reffs extends Migration {
    
    public function getDescription() {
        return "Create table tbl_m_item_reffs";
    }
    
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName('m_item_reffs') . "` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `id_item` INT(11) NULL DEFAULT '0',
            `id_item_reff` INT(11) NULL DEFAULT '0',
            `id_satuan` INT(11) NULL DEFAULT '0',
            `created_at` DATETIME NULL DEFAULT NULL,
            `updated_at` DATETIME NULL DEFAULT NULL,
            `item` VARCHAR(160) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
            `harga` DECIMAL(10,2) NULL DEFAULT '0.00',
            `jml` DECIMAL(10,2) NULL DEFAULT '0.00',
            `jml_satuan` INT(11) NULL DEFAULT '0',
            `satuan` VARCHAR(50) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
            `status` INT(11) NULL DEFAULT '0',
            PRIMARY KEY (`id`) USING BTREE,
            INDEX `fk_item_reffs_items` (`id_item`),
            INDEX `fk_item_reffs_items_reff` (`id_item_reff`),
            CONSTRAINT `fk_item_reffs_items` FOREIGN KEY (`id_item`) 
                REFERENCES `" . $this->getTableName('m_items') . "` (`id`) 
                ON UPDATE CASCADE 
                ON DELETE RESTRICT,
            CONSTRAINT `fk_item_reffs_items_reff` FOREIGN KEY (`id_item_reff`) 
                REFERENCES `" . $this->getTableName('m_items') . "` (`id`) 
                ON UPDATE CASCADE 
                ON DELETE RESTRICT
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;";

        try {
            $this->conn->exec($sql);
            echo "Table " . $this->getTableName('m_item_reffs') . " created successfully\n";
            return true;
            
        } catch (PDOException $e) {
            echo "Error creating table: " . $e->getMessage() . "\n";
            return false;
        }
    }

    public function down() {
        $sql = "DROP TABLE IF EXISTS `" . $this->getTableName('m_item_reffs') . "`;";
        
        try {
            $this->conn->exec($sql);
            echo "Table " . $this->getTableName('m_item_reffs') . " dropped successfully\n";
            return true;
            
        } catch (PDOException $e) {
            echo "Error dropping table: " . $e->getMessage() . "\n";
            return false;
        }
    }
} 