<?php
class Migration_pengaturan {
    public function up() {
        try {
            $tables = new BaseTables();
            
            // Create table
            $tables->create('pengaturan', function($table) {
                $table->increments('id');
                $table->string('judul_app', 100)->notNull();
                $table->string('logo', 255)->nullable();
                $table->string('favicon', 255)->nullable();
                $table->timestamps();
            });
            
            // Insert default settings
            $tables->insert('pengaturan', [
                'judul_app' => 'Sistem Pasien Dev',
                'logo' => 'theme/admin-lte-3/dist/img/AdminLTELogo.png',
                'favicon' => 'theme/admin-lte-3/dist/img/AdminLTELogo.png',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
        } catch (Exception $e) {
            error_log("Migration Error: " . $e->getMessage());
            throw $e;
        }
    }
    
    public function down() {
        $tables = new BaseTables();
        $tables->drop('pengaturan');
    }
}
?>