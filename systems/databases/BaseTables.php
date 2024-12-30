<?php
/**
 * Base Tables Class
 * 
 * Provides common methods for table creation
 */
class BaseTables {
    protected $conn;
    protected $prefix;
    
    public function __construct($conn) {
        $this->conn = $conn;
        $this->prefix = 'tbl_';
    }

    /**
     * Create a new table
     */
    public function create($tableName, $callback) {
        $table = new TableBuilder($this->prefix . $tableName);
        $callback($table);
        return $table->build();
    }

    /**
     * Get table name with prefix
     */
    protected function getTableName($name) {
        return $this->prefix . $name;
    }
}

/**
 * Table Builder Class
 */
class TableBuilder {
    private $tableName;
    private $columns = [];
    private $primaryKey;
    private $foreignKeys = [];
    private $engine = 'InnoDB';
    private $charset = 'utf8mb4';
    private $collation = 'utf8mb4_general_ci';
    private $currentColumn;

    public function __construct($tableName) {
        $this->tableName = $tableName;
    }

    // Add method chaining support
    public function nullable() {
        $this->columns[count($this->columns) - 1] = str_replace('NOT NULL', 'NULL DEFAULT NULL', $this->columns[count($this->columns) - 1]);
        return $this;
    }

    public function notNull() {
        $this->columns[count($this->columns) - 1] = str_replace('NULL DEFAULT NULL', 'NOT NULL', $this->columns[count($this->columns) - 1]);
        return $this;
    }

    public function default($value) {
        if (is_string($value)) {
            $value = "'$value'";
        }
        $this->columns[count($this->columns) - 1] = preg_replace('/DEFAULT.*?(?=,|$)/', "DEFAULT $value", $this->columns[count($this->columns) - 1]);
        return $this;
    }

    public function increments($column) {
        $this->columns[] = "`$column` INT(11) NOT NULL AUTO_INCREMENT";
        $this->primaryKey = $column;
        return $this;
    }

    public function bigIncrements($column) {
        $this->columns[] = "`$column` BIGINT(20) NOT NULL AUTO_INCREMENT";
        $this->primaryKey = $column;
        return $this;
    }

    public function string($column, $length = 255) {
        $this->columns[] = "`$column` VARCHAR($length) NOT NULL";
        return $this;
    }

    public function text($column) {
        $this->columns[] = "`$column` TEXT NOT NULL";
        return $this;
    }

    public function integer($column) {
        $this->columns[] = "`$column` INT(11) NOT NULL";
        return $this;
    }

    public function bigInteger($column) {
        $this->columns[] = "`$column` BIGINT(20) NOT NULL";
        return $this;
    }

    public function boolean($column) {
        $this->columns[] = "`$column` TINYINT(1) NOT NULL DEFAULT '0'";
        return $this;
    }

    public function datetime($column) {
        $this->columns[] = "`$column` DATETIME NOT NULL";
        return $this;
    }

    public function timestamp($column, $default = 'CURRENT_TIMESTAMP') {
        $this->columns[] = "`$column` TIMESTAMP NOT NULL DEFAULT $default";
        return $this;
    }

    public function enum($column, $values) {
        $values = array_map(function($value) {
            return "'$value'";
        }, $values);
        $this->columns[] = "`$column` ENUM(" . implode(',', $values) . ") NOT NULL";
        return $this;
    }

    public function foreign($column, $reference) {
        $this->foreignKeys[] = "FOREIGN KEY (`$column`) REFERENCES $reference";
        return $this;
    }

    public function build() {
        $sql = "CREATE TABLE IF NOT EXISTS `{$this->tableName}` (\n";
        $sql .= implode(",\n", $this->columns);
        
        if ($this->primaryKey) {
            $sql .= ",\nPRIMARY KEY (`{$this->primaryKey}`)";
        }
        
        if (!empty($this->foreignKeys)) {
            $sql .= ",\n" . implode(",\n", $this->foreignKeys);
        }
        
        $sql .= "\n) ENGINE={$this->engine} DEFAULT CHARSET={$this->charset} COLLATE={$this->collation};";
        
        return $sql;
    }
}
?> 