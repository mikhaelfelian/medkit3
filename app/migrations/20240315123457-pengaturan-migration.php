<?php
class Migration_pengaturan {
    public function up() {
        $tables = new BaseTables();
        
        $tables->create('pengaturan', function($table) {
            $table->increments('id');
            $table->string('judul_app', 100)->notNull();
            $table->string('logo', 255)->nullable();
            $table->string('favicon', 255)->nullable();
            $table->timestamp('created_at')->notNull()->default('CURRENT_TIMESTAMP');
            $table->timestamp('updated_at')->nullable();
        });

        // Insert default settings
        $tables->insert('pengaturan', [
            'judul_app' => 'Sistem Pasien Dev',
            'logo' => 'public/assets/theme/admin-lte-3/dist/img/AdminLTELogo.png',
            'favicon' => 'public/assets/theme/admin-lte-3/dist/img/AdminLTELogo.png'
        ]);
    }
    
    public function down() {
        $tables = new BaseTables();
        $tables->drop('pengaturan');
    }
} 