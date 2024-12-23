<?php
class PasienModel extends BaseModel {
    protected $table = 'tbl_m_pasien';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode', 'nik', 'nama', 'nama_pgl', 'no_hp',
        'alamat', 'alamat_domisili', 'rt', 'rw',
        'kelurahan', 'kecamatan', 'kota', 'pekerjaan'
    ];
    
    public function __construct($conn) {
        parent::__construct($conn, $this->table);
    }
    
    public function search($conditions = [], $keyword = '', $page = 1, $perPage = 10) {
        try {
            // Build base query
            $sql = "SELECT * FROM {$this->table} WHERE 1=1";
            $params = [];
            
            // Add search conditions
            if ($keyword) {
                $sql .= " AND (
                    kode LIKE :keyword OR 
                    nik LIKE :keyword OR 
                    nama LIKE :keyword OR 
                    alamat LIKE :keyword OR 
                    no_hp LIKE :keyword
                )";
                $params[':keyword'] = "%{$keyword}%";
            }
            
            // Add other conditions
            foreach ($conditions as $field => $value) {
                $sql .= " AND {$field} = :{$field}";
                $params[":{$field}"] = $value;
            }
            
            // Count total records
            $countSql = "SELECT COUNT(*) as total FROM ({$sql}) as t";
            $stmt = $this->conn->prepare($countSql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_OBJ)->total;
            
            // Add pagination
            $offset = ($page - 1) * $perPage;
            $sql .= " ORDER BY id DESC LIMIT {$perPage} OFFSET {$offset}";
            
            // Execute final query
            $stmt = $this->conn->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            // Calculate pagination info
            $lastPage = ceil($total / $perPage);
            
            return [
                'data' => $data,
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $page,
                'last_page' => $lastPage
            ];
            
        } catch (PDOException $e) {
            error_log("Database Error in PasienModel::search - " . $e->getMessage());
            return [
                'data' => [],
                'total' => 0,
                'per_page' => $perPage,
                'current_page' => $page,
                'last_page' => 1
            ];
        }
    }
    
    public function create($data) {
        try {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            return parent::create($data);
        } catch (PDOException $e) {
            error_log("Database Error in PasienModel::create - " . $e->getMessage());
            throw new Exception("Gagal menyimpan data pasien");
        }
    }
    
    public function update($id, $data) {
        try {
            $data['updated_at'] = date('Y-m-d H:i:s');
            return parent::update($id, $data);
        } catch (PDOException $e) {
            error_log("Database Error in PasienModel::update - " . $e->getMessage());
            throw new Exception("Gagal memperbarui data pasien");
        }
    }
} 