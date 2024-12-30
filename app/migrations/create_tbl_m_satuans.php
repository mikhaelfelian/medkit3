<?php
class Migration_create_tbl_m_satuans extends Migration {
    public function up() {
        return $this->tables->create('m_satuans', function($table) {
            $table->bigIncrements('id');
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->string('satuanKecil', 100)->notNull();
            $table->string('satuanBesar', 100)->nullable();
            $table->integer('jml')->notNull();
            $table->enum('status', ['1', '0'])->nullable();
        });
    }

    public function down() {
        return "DROP TABLE IF EXISTS `" . $this->getTableName('m_satuans') . "`;";
    }

    public function getDescription() {
        return "Create table " . $this->getTableName('m_satuans');
    }
} 