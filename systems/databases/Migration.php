<?php
require_once __DIR__ . '/BaseTables.php';

abstract class Migration {
    protected $conn;
    protected $tables;
    protected $prefix = 'tbl_';
    
    public function __construct($conn) {
        $this->conn = $conn;
        $this->tables = new BaseTables($conn);
    }
    
    protected function getTableName($name) {
        return $this->prefix . $name;
    }
    
    /**
     * Get the description of the migration
     * @return string
     */
    abstract public function getDescription();

    /**
     * Run the migrations
     * @return bool
     */
    abstract public function up();

    /**
     * Reverse the migrations
     * @return bool
     */
    abstract public function down();
} 