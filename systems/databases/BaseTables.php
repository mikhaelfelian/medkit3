<?php
class BaseTables {
    protected $conn;
    protected $prefix;
    protected $charset;
    protected $collation;
    
    public function __construct() {
        global $conn;
        $this->conn = $conn;
        $this->prefix = $GLOBALS['app_config']['db_prefix'];
        $this->charset = $GLOBALS['app_config']['db_charset'];
        $this->collation = $GLOBALS['app_config']['db_collation'];
    }
    
    /**
     * Create a new table
     */
    public function create($tableName, $callback) {
        $table = new TableBuilder($this->prefix . $tableName);
        $callback($table);
        
        $sql = $table->build($this->charset, $this->collation);
        
        if (mysqli_query($this->conn, $sql)) {
            echo "Table {$this->prefix}{$tableName} created successfully\n";
            return true;
        } else {
            echo "Error creating table: " . mysqli_error($this->conn) . "\n";
            return false;
        }
    }
    
    /**
     * Drop a table if it exists
     */
    public function drop($tableName) {
        $sql = "DROP TABLE IF EXISTS {$this->prefix}{$tableName}";
        
        if (mysqli_query($this->conn, $sql)) {
            echo "Table {$this->prefix}{$tableName} dropped successfully\n";
            return true;
        } else {
            echo "Error dropping table: " . mysqli_error($this->conn) . "\n";
            return false;
        }
    }
    
    /**
     * Check if table exists
     */
    public function hasTable($tableName) {
        $sql = "SHOW TABLES LIKE '{$this->prefix}{$tableName}'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_num_rows($result) > 0;
    }
    
    /**
     * Rename a table
     */
    public function rename($from, $to) {
        $sql = "RENAME TABLE {$this->prefix}{$from} TO {$this->prefix}{$to}";
        
        if (mysqli_query($this->conn, $sql)) {
            echo "Table renamed from {$this->prefix}{$from} to {$this->prefix}{$to} successfully\n";
            return true;
        } else {
            echo "Error renaming table: " . mysqli_error($this->conn) . "\n";
            return false;
        }
    }
}

class TableBuilder {
    protected $name;
    protected $columns = [];
    protected $primary = null;
    protected $foreign = [];
    protected $unique = [];
    protected $index = [];
    protected $engine = 'InnoDB';
    
    public function __construct($name) {
        $this->name = $name;
    }
    
    /**
     * Add an INT column
     */
    public function int($name, $length = 11) {
        $this->columns[$name] = "INT({$length})";
        return $this;
    }
    
    /**
     * Add a VARCHAR column
     */
    public function string($name, $length = 255) {
        $this->columns[$name] = "VARCHAR({$length})";
        return $this;
    }
    
    /**
     * Add a TEXT column
     */
    public function text($name) {
        $this->columns[$name] = "TEXT";
        return $this;
    }
    
    /**
     * Add a DATETIME column
     */
    public function datetime($name) {
        $this->columns[$name] = "DATETIME";
        return $this;
    }
    
    /**
     * Add a TIMESTAMP column
     */
    public function timestamp($name) {
        $this->columns[$name] = "TIMESTAMP";
        return $this;
    }
    
    /**
     * Add auto increment primary key
     */
    public function increments($name = 'id') {
        $this->columns[$name] = "INT(11) AUTO_INCREMENT";
        $this->primary = $name;
        return $this;
    }
    
    /**
     * Make column nullable
     */
    public function nullable() {
        $lastColumn = array_key_last($this->columns);
        $this->columns[$lastColumn] .= " NULL DEFAULT NULL";
        return $this;
    }
    
    /**
     * Add NOT NULL constraint
     */
    public function notNull() {
        $lastColumn = array_key_last($this->columns);
        $this->columns[$lastColumn] .= " NOT NULL";
        return $this;
    }
    
    /**
     * Add default value
     */
    public function default($value) {
        $lastColumn = array_key_last($this->columns);
        if (is_string($value)) {
            $value = "'{$value}'";
        }
        $this->columns[$lastColumn] .= " DEFAULT {$value}";
        return $this;
    }
    
    /**
     * Add unique constraint
     */
    public function unique($columns) {
        if (!is_array($columns)) {
            $columns = [$columns];
        }
        $this->unique[] = $columns;
        return $this;
    }
    
    /**
     * Add index
     */
    public function index($columns) {
        if (!is_array($columns)) {
            $columns = [$columns];
        }
        $this->index[] = $columns;
        return $this;
    }
    
    /**
     * Add foreign key
     */
    public function foreign($column, $reference, $onDelete = 'CASCADE', $onUpdate = 'CASCADE') {
        $this->foreign[] = [
            'column' => $column,
            'reference' => $reference,
            'onDelete' => $onDelete,
            'onUpdate' => $onUpdate
        ];
        return $this;
    }
    
    /**
     * Build the SQL query
     */
    public function build($charset, $collation) {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->name} (\n";
        
        // Add columns
        foreach ($this->columns as $name => $definition) {
            $sql .= "    {$name} {$definition},\n";
        }
        
        // Add primary key
        if ($this->primary) {
            $sql .= "    PRIMARY KEY ({$this->primary}),\n";
        }
        
        // Add unique constraints
        foreach ($this->unique as $columns) {
            $sql .= "    UNIQUE KEY (" . implode(', ', $columns) . "),\n";
        }
        
        // Add indexes
        foreach ($this->index as $columns) {
            $sql .= "    INDEX (" . implode(', ', $columns) . "),\n";
        }
        
        // Add foreign keys
        foreach ($this->foreign as $fk) {
            $sql .= "    FOREIGN KEY ({$fk['column']}) REFERENCES {$fk['reference']} ";
            $sql .= "ON DELETE {$fk['onDelete']} ON UPDATE {$fk['onUpdate']},\n";
        }
        
        // Remove last comma and close parenthesis
        $sql = rtrim($sql, ",\n") . "\n";
        $sql .= ") ENGINE={$this->engine} DEFAULT CHARSET={$charset} COLLATE={$collation};";
        
        return $sql;
    }
}
?> 