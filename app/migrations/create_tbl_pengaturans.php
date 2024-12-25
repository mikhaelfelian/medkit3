<?php
class Migration_create_tbl_pengaturans extends Migration {
    public function up() {
        // Create table SQL
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName('pengaturans') . "` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `updated_at` TIMESTAMP NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            `judul` VARCHAR(100) DEFAULT NULL,
            `judul_app` VARCHAR(100) DEFAULT NULL,
            `alamat` TEXT DEFAULT NULL,
            `deskripsi` TEXT DEFAULT NULL,
            `kota` VARCHAR(100) DEFAULT NULL,
            `url` VARCHAR(255) DEFAULT NULL,
            `theme` VARCHAR(50) DEFAULT NULL,
            `pagination_limit` INT(11) DEFAULT NULL,
            `favicon` VARCHAR(255) DEFAULT NULL,
            `logo` VARCHAR(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

        // Execute table creation
        $this->db->exec($sql);

        // Insert default data
        $insertSql = "INSERT INTO `" . $this->getTableName('pengaturans') . "` 
            (`id`, `judul`, `judul_app`, `alamat`, `deskripsi`, `kota`, `url`, `theme`, `pagination_limit`, `favicon`, `logo`) 
        VALUES
            (1, 'SIMEDIS', 'SIMEDIS', 'Perum Mutiara Pandanaran Blok D11', 'SIMEDIS is an part of SIMRS application', 'KOTA SEMARANG', 'http://localhost/medkit3/', 'default', 10, 'public/file/app/favicon_1735061559.png', 'public/file/app/logo_1735058637.png');";

        $this->db->exec($insertSql);

        return $sql;
    }

    public function down() {
        return "DROP TABLE IF EXISTS `" . $this->getTableName('pengaturans') . "`;";
    }

    public function getDescription() {
        return "Create table " . $this->getTableName('pengaturans');
    }
} 