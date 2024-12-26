<?php
class Migration_alter_tbl_m_gudangs_add_status_gd extends Migration {
    public function up() {
        $sql = "ALTER TABLE `" . $this->getTableName('m_gudangs') . "` 
                ADD COLUMN `status_gd` ENUM('0','1') NULL DEFAULT '0' 
                COMMENT '1 = Gudang Utama\r\n0 = Bukan Gudang Utama' 
                COLLATE 'latin1_swedish_ci' 
                AFTER `status`;";

        return $sql;
    }

    public function down() {
        return "ALTER TABLE `" . $this->getTableName('m_gudangs') . "` 
                DROP COLUMN `status_gd`;";
    }

    public function getDescription() {
        return "Add status_gd column to " . $this->getTableName('m_gudangs');
    }
} 