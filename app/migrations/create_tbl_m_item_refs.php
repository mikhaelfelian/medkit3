<?php
require_once SYSTEM_PATH . '/databases/Migration.php';

class Migration_create_tbl_m_item_refs extends Migration {
    
    public function getDescription() {
        return "Create table tbl_m_item_refs";
    }
    
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName('m_item_refs') . "` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `id_item` INT(11) NULL DEFAULT 0,
            `id_item_ref` INT(11) NULL DEFAULT 0,
            `id_satuan` INT(11) NULL DEFAULT 0,
            `id_user` INT(11) NULL DEFAULT 0,
            `created_at` DATETIME NULL DEFAULT NULL,
            `updated_at` DATETIME NULL DEFAULT NULL,
            `item` VARCHAR(160) NULL DEFAULT NULL,
            `harga` DECIMAL(10,2) NULL DEFAULT 0.00,
            `jml` DECIMAL(10,2) NULL DEFAULT 0.00,
            `jml_satuan` INT(11) NULL DEFAULT 0,
            `subtotal` DECIMAL(10,2) NULL DEFAULT 0.00,
            `status` INT(11) NULL DEFAULT 0,
            PRIMARY KEY (`id`),
            INDEX `fk_item_refs_items` (`id_item`),
            INDEX `fk_item_refs_items_ref` (`id_item_ref`),
            CONSTRAINT `fk_item_refs_items` FOREIGN KEY (`id_item`) 
                REFERENCES `" . $this->getTableName('m_items') . "` (`id`) 
                ON UPDATE CASCADE 
                ON DELETE RESTRICT,
            CONSTRAINT `fk_item_refs_items_ref` FOREIGN KEY (`id_item_ref`) 
                REFERENCES `" . $this->getTableName('m_items') . "` (`id`) 
                ON UPDATE CASCADE 
                ON DELETE RESTRICT
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

        try {
            $this->conn->exec($sql);
            echo "Table " . $this->getTableName('m_item_refs') . " created successfully\n";
            return true;
            
        } catch (PDOException $e) {
            echo "Error creating table: " . $e->getMessage() . "\n";
            return false;
        }
    }

    public function down() {
        $sql = "DROP TABLE IF EXISTS `" . $this->getTableName('m_item_refs') . "`;";
        
        try {
            $this->conn->exec($sql);
            echo "Table " . $this->getTableName('m_item_refs') . " dropped successfully\n";
            return true;
            
        } catch (PDOException $e) {
            echo "Error dropping table: " . $e->getMessage() . "\n";
            return false;
        }
    }
}