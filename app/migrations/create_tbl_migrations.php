<?php
class Migration_create_tbl_migrations extends Migration {
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName('migrations') . "` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `migration` VARCHAR(255) NOT NULL,
            `executed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `execution_time` FLOAT NULL DEFAULT NULL COMMENT 'Time in seconds',
            `status` ENUM('success','failed') NOT NULL DEFAULT 'success',
            `error_message` TEXT NULL DEFAULT NULL,
            `description` VARCHAR(255) NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

        return $sql;
    }

    public function down() {
        return "DROP TABLE IF EXISTS `" . $this->getTableName('migrations') . "`;";
    }

    public function getDescription() {
        return "Create table " . $this->getTableName('migrations');
    }
} 