<?php
require_once 'systems/models/BaseModel.php';

class TblMPasienModel extends BaseModel {
    protected $table = 'tbl_m_pasien';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode',
        'nik',
        'nama',
        'nama_pgl',
        'no_hp',
        'alamat',
        'alamat_domisili',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'kota',
        'pekerjaan'
    ];

    public function __construct($conn) {
        parent::__construct($conn, $this->table);
    }

    public function searchPasien($keyword, $page = 1, $perPage = 10) {
        $searchColumns = ['kode', 'nik', 'nama', 'no_hp', 'alamat'];
        return $this->search($searchColumns, $keyword, $page, $perPage);
    }

    // Add custom methods specific to Pasien here
    public function generateKode() {
        $year = date('Y');
        $month = date('m');
        
        // Get last code
        $sql = "SELECT kode FROM {$this->table} 
                WHERE kode LIKE 'P{$year}{$month}%' 
                ORDER BY kode DESC LIMIT 1";
        $result = mysqli_query($this->conn, $sql);
        $data = mysqli_fetch_assoc($result);
        
        if ($data) {
            $lastNumber = intval(substr($data['kode'], -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return 'P' . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
?> 