<?php
class Migration_create_tbl_pengaturans extends Migration {
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName('pengaturans') . "` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `updated_at` TIMESTAMP NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            `judul_app` VARCHAR(100) NULL DEFAULT NULL,
            `nama_instansi` VARCHAR(100) NULL DEFAULT NULL,
            `alamat` TEXT NULL DEFAULT NULL,
            `telepon` VARCHAR(20) NULL DEFAULT NULL,
            `email` VARCHAR(100) NULL DEFAULT NULL,
            `logo` VARCHAR(255) NULL DEFAULT NULL,
            `favicon` VARCHAR(255) NULL DEFAULT NULL,
            `footer_text` VARCHAR(255) NULL DEFAULT NULL,
            PRIMARY KEY (`id`) USING BTREE
        ) COLLATE='utf8mb4_general_ci' ENGINE=InnoDB AUTO_INCREMENT=1;";

        // Insert default settings
        $sql .= "\n\nINSERT IGNORE INTO `" . $this->getTableName('pengaturans') . "` 
            (`id`, `judul_app`, `nama_instansi`) VALUES 
            (1, 'MEDKIT3', 'Klinik Nusantara');";

        try {
            $this->conn->exec($sql);
            return true;
        } catch (PDOException $e) {
            error_log("Migration Error: " . $e->getMessage());
            return false;
        }
    }

    public function down() {
        return "DROP TABLE IF EXISTS `" . $this->getTableName('pengaturans') . "`;";
    }

    public function getDescription() {
        return "Create table " . $this->getTableName('pengaturans');
    }
} 