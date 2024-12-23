<?php
class MigrationController extends BaseController {
    protected $runner;
    
    public function __construct() {
        parent::__construct();
        
        // Only allow in development
        if (ENVIRONMENT !== 'development') {
            die('Migrations are only available in development environment');
        }
        
        require_once ROOT_PATH . '/systems/databases/MigrationRunner.php';
        $this->runner = new MigrationRunner();
    }
    
    /**
     * Create a new migration
     */
    public function create($name = null) {
        if (empty($name)) {
            die("Migration name is required\n");
        }
        
        $this->runner->create($name);
        echo "Migration created successfully\n";
    }
    
    /**
     * Run pending migrations
     */
    public function run() {
        $this->runner->run();
        echo "All migrations completed\n";
    }
}
?> 