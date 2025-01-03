<?php
require_once SYSTEM_PATH . '/databases/Migration.php';

class Migration_create_tbl_m_item_ref_inputs extends Migration {
    
    public function getDescription() {
        return "Create table tbl_m_item_ref_inputs";
    }
    
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName('m_item_ref_inputs') . "` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `id_item` INT(11) NOT NULL DEFAULT 0,
            `id_user` INT(11) NOT NULL DEFAULT 0,
            `created_at` DATETIME NULL DEFAULT NULL,
            `updated_at` DATETIME NULL DEFAULT NULL,
            `item_name` VARCHAR(160) NULL DEFAULT NULL,
            `item_value` TEXT NULL DEFAULT NULL,
            `item_value_l1` TEXT NULL DEFAULT NULL,
            `item_value_l2` TEXT NULL DEFAULT NULL,
            `item_value_p1` TEXT NULL DEFAULT NULL,
            `item_value_p2` TEXT NULL DEFAULT NULL,
            `item_satuan` VARCHAR(100) NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            INDEX `fk_item_ref_inputs_items` (`id_item`),
            CONSTRAINT `fk_item_ref_inputs_items` FOREIGN KEY (`id_item`) 
                REFERENCES `" . $this->getTableName('m_items') . "` (`id`) 
                ON UPDATE CASCADE 
                ON DELETE RESTRICT
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;";

        try {
            $this->conn->exec($sql);
            echo "Table " . $this->getTableName('m_item_ref_inputs') . " created successfully\n";
            return true;
            
        } catch (PDOException $e) {
            echo "Error creating table: " . $e->getMessage() . "\n";
            return false;
        }
    }

    public function down() {
        $sql = "DROP TABLE IF EXISTS `" . $this->getTableName('m_item_ref_inputs') . "`;";
        
        try {
            $this->conn->exec($sql);
            echo "Table " . $this->getTableName('m_item_ref_inputs') . " dropped successfully\n";
            return true;
            
        } catch (PDOException $e) {
            echo "Error dropping table: " . $e->getMessage() . "\n";
            return false;
        }
    }
} 