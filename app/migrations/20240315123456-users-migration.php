<?php
class Migration_users {
    public function up() {
        $tables = new BaseTables();
        
        $tables->create('users', function($table) {
            $table->increments('id');
            $table->string('username', 50)->notNull()->unique('username');
            $table->string('email', 100)->notNull()->unique('email');
            $table->string('password', 255)->notNull();
            $table->string('name', 100)->notNull();
            $table->text('address')->nullable();
            $table->timestamp('created_at')->notNull()->default('CURRENT_TIMESTAMP');
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down() {
        $tables = new BaseTables();
        $tables->drop('users');
    }
}

// Run the migration
$migration = new Migration_users();
$migration->up(); 