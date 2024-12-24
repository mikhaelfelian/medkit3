<?php
class Migration_add_favicon_to_pengaturan {
    public function up() {
        try {
            $tables = new BaseTables();
            
            // Check if column exists
            $sql = "SHOW COLUMNS FROM tbl_pengaturan LIKE 'favicon'";
            $result = mysqli_query($tables->getConnection(), $sql);
            
            if (mysqli_num_rows($result) == 0) {
                // Add favicon column if it doesn't exist
                $sql = "ALTER TABLE tbl_pengaturan 
                        ADD COLUMN favicon VARCHAR(255) NULL DEFAULT NULL AFTER logo";
                mysqli_query($tables->getConnection(), $sql);
                
                echo "Added favicon column to tbl_pengaturan table\n";
            }
            
        } catch (Exception $e) {
            error_log("Migration Error: " . $e->getMessage());
            throw $e;
        }
    }
    
    public function down() {
        try {
            $tables = new BaseTables();
            
            $sql = "ALTER TABLE tbl_pengaturan DROP COLUMN IF EXISTS favicon";
            mysqli_query($tables->getConnection(), $sql);
            
            echo "Removed favicon column from tbl_pengaturan table\n";
            
        } catch (Exception $e) {
            error_log("Migration Error: " . $e->getMessage());
            throw $e;
        }
    }
}

// Run the migration
$migration = new Migration_add_favicon_to_pengaturan();
$migration->up(); 