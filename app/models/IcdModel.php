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
            
            // Basic query
            $query = "SELECT * FROM {$this->table}";
            $params = [];
            
            // Add WHERE conditions
            $conditions = [];
            
            if (!empty($search)) {
                $conditions[] = "(kode LIKE :search OR icd LIKE :search OR diagnosa_en LIKE :search)";
                $params[':search'] = "%{$search}%";
            }
            
            if (!empty($conditions)) {
                $query .= " WHERE " . implode(' AND ', $conditions);
            }
            
            // Count total records first
            $countQuery = str_replace("SELECT *", "SELECT COUNT(*) as total", $query);
            try {
                $stmt = $this->conn->prepare($countQuery);
                foreach ($params as $key => $value) {
                    $stmt->bindValue($key, $value);
                }
                $stmt->execute();
                $total = (int)$stmt->fetch(PDO::FETCH_OBJ)->total;
            } catch (PDOException $e) {
                error_log("Count Query Error: " . $e->getMessage() . "\nQuery: " . $countQuery);
                throw new Exception("Error counting records");
            }
            
            // Then get the paginated data
            $query .= " ORDER BY kode ASC LIMIT :limit OFFSET :offset";
            try {
                $stmt = $this->conn->prepare($query);
                
                // Bind all parameters
                foreach ($params as $key => $value) {
                    $stmt->bindValue($key, $value);
                }
                $stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
                $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
                
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_OBJ);
                
                return [
                    'data' => $data,
                    'total' => $total
                ];
            } catch (PDOException $e) {
                error_log("Data Query Error: " . $e->getMessage() . "\nQuery: " . $query);
                throw new Exception("Error retrieving records");
            }
            
        } catch (Exception $e) {
            error_log("Database Error in searchPaginate: " . $e->getMessage());
            throw new Exception("Failed to fetch ICD data: " . $e->getMessage());
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