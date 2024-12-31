<?php
class SatuanModel extends BaseModel {
    protected $table = 'tbl_m_satuans';
    protected $primaryKey = 'id';
    protected $timestamps = true;
    
    protected $fillable = [
        'satuanKecil',
        'satuanBesar',
        'jml',
        'status',
        'created_at',
        'updated_at'
    ];

    public function validate($data, $id = null) {
        $errors = [];
        
        // Validate satuanKecil
        if (empty($data['satuanKecil'])) {
            $errors['satuanKecil'] = 'Satuan Kecil harus diisi';
        }
        
        // Validate jml
        if (empty($data['jml'])) {
            $errors['jml'] = 'Jumlah harus diisi';
        } else if (!is_numeric($data['jml'])) {
            $errors['jml'] = 'Jumlah harus berupa angka';
        }
        
        return $errors;
    }

    public function getActiveRecords() {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE status = '1' ORDER BY satuanKecil ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database Error in getActiveRecords: " . $e->getMessage());
            return [];
        }
    }

    public function searchPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            $conditions = ["1=1"];
            $params = [];
            
            if (!empty($search)) {
                $conditions[] = "(satuanKecil LIKE :search OR satuanBesar LIKE :search)";
                $params[':search'] = "%{$search}%";
            }
            
            $where = implode(' AND ', $conditions);
            
            // Get total records
            $countSql = "SELECT COUNT(*) as total FROM {$this->table} WHERE {$where}";
            $stmt = $this->conn->prepare($countSql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_OBJ)->total;
            
            // Get paginated records
            $sql = "SELECT * FROM {$this->table} 
                   WHERE {$where} 
                   ORDER BY created_at DESC 
                   LIMIT :limit OFFSET :offset";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            $stmt->execute();
            
            return [
                'data' => $stmt->fetchAll(PDO::FETCH_OBJ),
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $page
            ];
            
        } catch (PDOException $e) {
            error_log("Database Error in searchPaginate: " . $e->getMessage());
            throw new Exception("Failed to fetch records");
        }
    }
} 