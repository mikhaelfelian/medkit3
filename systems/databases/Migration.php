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
    
    abstract public function up();
    abstract public function down();
    abstract public function getDescription();
} 