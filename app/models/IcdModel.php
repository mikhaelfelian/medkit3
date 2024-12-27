<?php
class IcdModel extends BaseModel {
    protected $table = 'tbl_m_icds';
    protected $primaryKey = 'id';
    protected $timestamps = true;
    
    protected $fillable = [
        'kode',
        'icd',
        'diagnosa_en'
    ];

    public function searchPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            $conditions = [];
            $params = [];
            
            if (!empty($search)) {
                $conditions[] = "(kode LIKE :search OR icd LIKE :search OR diagnosa_en LIKE :search)";
                $params[':search'] = "%{$search}%";
            }
            
            // Build WHERE clause
            $where = '';
            if (!empty($conditions)) {
                $where = 'WHERE ' . implode(' AND ', $conditions);
            }
            
            // Get total records
            $countSql = "SELECT COUNT(*) as total FROM {$this->table} {$where}";
            $stmt = $this->conn->prepare($countSql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_OBJ)->total;
            
            // Calculate last page
            $lastPage = ceil($total / $perPage);
            
            // Ensure current page is valid
            $page = max(1, min($page, $lastPage));
            
            // Get paginated records
            $sql = "SELECT * FROM {$this->table} 
                   {$where} 
                   ORDER BY kode ASC 
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
                'current_page' => $page,
                'last_page' => $lastPage
            ];
            
        } catch (PDOException $e) {
            error_log("Database Error in searchPaginate: " . $e->getMessage());
            throw new Exception("Failed to fetch records: " . $e->getMessage());
        }
    }

    public function findByKode($kode) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE kode = :kode LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':kode', $kode);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database Error in findByKode: " . $e->getMessage());
            throw new Exception("Failed to fetch ICD");
        }
    }

    public function validateData($data, $id = null) {
        $errors = [];
        
        // Validate kode
        if (empty($data['kode'])) {
            $errors['kode'] = 'Kode ICD is required';
        } else {
            // Check for duplicate kode
            $existing = $this->findByKode($data['kode']);
            if ($existing && (!$id || $existing->id != $id)) {
                $errors['kode'] = 'Kode ICD already exists';
            }
        }
        
        // Validate icd
        if (empty($data['icd'])) {
            $errors['icd'] = 'ICD is required';
        }
        
        return $errors;
    }

    public function getAll() {
        try {
            $sql = "SELECT * FROM {$this->table} ORDER BY kode ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database Error in getAll: " . $e->getMessage());
            throw new Exception("Failed to fetch ICD list");
        }
    }
} 