<?php
class MigrationRunner {
    protected $migrationPath;
    protected $migrationTable = 'migrations';
    protected $conn;
    
    public function __construct() {
        global $conn;
        $this->conn = $conn;
        $this->migrationPath = ROOT_PATH . '/app/migrations/';
        $this->initMigrationTable();
    }
    
    /**
     * Initialize migrations tracking table
     */
    protected function initMigrationTable() {
        $tables = new BaseTables();
        if (!$tables->hasTable($this->migrationTable)) {
            $tables->create($this->migrationTable, function($table) {
                $table->increments('id');
                $table->string('migration', 255)->notNull();
                $table->timestamp('executed_at')->notNull()->default('CURRENT_TIMESTAMP');
            });
        }
    }
    
    /**
     * Create a new migration file
     */
    public function create($name) {
        $timestamp = date('YmdHis');
        $filename = $timestamp . '-' . strtolower($name) . '-migration.php';
        $filepath = $this->migrationPath . $filename;
        
        if (!is_dir($this->migrationPath)) {
            mkdir($this->migrationPath, 0755, true);
        }
        
        $template = $this->getMigrationTemplate($name);
        
        if (file_put_contents($filepath, $template)) {
            echo "Created Migration: {$filename}\n";
            return true;
        }
        
        echo "Failed to create migration file\n";
        return false;
    }
    
    /**
     * Run pending migrations
     */
    public function run() {
        $files = glob($this->migrationPath . '*.php');
        sort($files);
        
        foreach ($files as $file) {
            $migration = basename($file);
            if (!$this->hasRun($migration)) {
                echo "Running migration: {$migration}\n";
                
                // Create new instance for each migration
                $tables = new BaseTables();
                
                // Include the migration file
                require_once $file;
                
                // Mark as run
                $this->markAsRun($migration);
            }
        }
    }
    
    /**
     * Check if migration has been run
     */
    protected function hasRun($migration) {
        $prefix = $GLOBALS['app_config']['db_prefix'];
        $sql = "SELECT COUNT(*) as count FROM {$prefix}{$this->migrationTable} WHERE migration = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $migration);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        return $row['count'] > 0;
    }
    
    /**
     * Mark migration as run
     */
    protected function markAsRun($migration) {
        $prefix = $GLOBALS['app_config']['db_prefix'];
        $sql = "INSERT INTO {$prefix}{$this->migrationTable} (migration) VALUES (?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $migration);
        mysqli_stmt_execute($stmt);
    }
    
    /**
     * Get migration file template
     */
    protected function getMigrationTemplate($name) {
        $className = 'Migration_' . str_replace(['-', ' '], '_', $name);
        
        return "<?php
class {$className} {
    public function up() {
        \$tables = new BaseTables();
        
        \$tables->create('" . strtolower($name) . "', function(\$table) {
            \$table->increments('id');
            // Add your columns here
            \$table->timestamp('created_at')->notNull()->default('CURRENT_TIMESTAMP');
            \$table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down() {
        \$tables = new BaseTables();
        \$tables->drop('" . strtolower($name) . "');
    }
}

// Run the migration
\$migration = new {$className}();
\$migration->up();
";
    }
}
?> 