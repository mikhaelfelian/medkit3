<?php
require_once 'systems/databases/BaseTables.php';

$tables = new BaseTables();

// Create users table
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

// Create user_roles table with foreign key
$tables->create('user_roles', function($table) {
    $table->increments('id');
    $table->int('user_id')->notNull();
    $table->string('role', 50)->notNull();
    $table->timestamp('created_at')->notNull()->default('CURRENT_TIMESTAMP');
    $table->foreign('user_id', 'tbl_users(id)');
});
?> 