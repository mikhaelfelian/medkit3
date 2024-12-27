<?php
class GelarModel extends BaseModel {
    protected $table = 'tbl_m_gelars';
    protected $primaryKey = 'id';
    protected $timestamps = true;
    
    protected $fillable = [
        'gelar',
        'keterangan'
    ];

    public function searchPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            $conditions = [];
            $params = [];
            
            if (!empty($search)) {
                $conditions[] = "(gelar LIKE :search OR keterangan LIKE :search)";
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
                'current_page' => $page,
                'last_page' => $lastPage
            ];
            
        } catch (PDOException $e) {
            error_log("Database Error in searchPaginate: " . $e->getMessage());
            throw new Exception("Failed to fetch records: " . $e->getMessage());
        }
    }

    public function getAll() {
        try {
            $sql = "SELECT * FROM {$this->table} ORDER BY gelar ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database Error in getAll: " . $e->getMessage());
            throw new Exception("Failed to fetch gelar list");
        }
    }

    public function findByGelar($gelar) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE gelar = :gelar LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':gelar', $gelar);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database Error in findByGelar: " . $e->getMessage());
            throw new Exception("Failed to fetch gelar");
        }
    }

    public function validateData($data, $id = null) {
        $errors = [];
        
        // Validate gelar
        if (empty($data['gelar'])) {
            $errors['gelar'] = 'Gelar is required';
        } else {
            // Check for duplicate gelar
            $existing = $this->findByGelar($data['gelar']);
            if ($existing && (!$id || $existing->id != $id)) {
                $errors['gelar'] = 'Gelar already exists';
            }
        }
        
        return $errors;
    }
} 