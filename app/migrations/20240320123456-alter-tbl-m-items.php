<?php

class Migration_20240320123456_alter_tbl_m_items extends BaseMigration {
    public function up() {
        try {
            // Add status_obat column with comment
            $sql = "ALTER TABLE tbl_m_items 
                   ADD COLUMN status_obat TINYINT(1) DEFAULT NULL 
                   COMMENT '1=obat;2=racikan;3=tindakan;4=lab;5=radiologi;6=bhp'";
            $this->db->query($sql);
            
            // Modify status column to ENUM
            $sql = "ALTER TABLE tbl_m_items 
                   MODIFY COLUMN status ENUM('0','1') DEFAULT '0'";
            $this->db->query($sql);

        } catch (Exception $e) {
            error_log("Migration Error: " . $e->getMessage());
            throw $e;
        }
    }

    public function down() {
        try {
            // Drop status_obat column
            $sql = "ALTER TABLE tbl_m_items DROP COLUMN status_obat";
            $this->db->query($sql);
            
            // Revert status column to original type
            $sql = "ALTER TABLE tbl_m_items 
                   MODIFY COLUMN status INT(11) NULL DEFAULT NULL 
                   COMMENT '2=tindakan;3=lab;4=obat;5=radiologi;6=racikan'";
            $this->db->query($sql);

        } catch (Exception $e) {
            error_log("Migration Error: " . $e->getMessage());
            throw $e;
        }
    }
}

// Run the migration
$migration = new Migration_20240320123456_alter_tbl_m_items();
$migration->up(); 