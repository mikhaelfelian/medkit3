<?php
class PengaturanModel extends BaseModel {
    protected $table = 'pengaturan';
    protected $primaryKey = 'id';
    protected $fillable = ['judul_app', 'logo', 'favicon'];
    
    public function __construct($conn) {
        parent::__construct($conn, $this->table);
    }
    
    public function first() {
        return $this->findOne();
    }
} 