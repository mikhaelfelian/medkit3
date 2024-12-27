<?php

class KategoriModel extends BaseModel {
    protected $table = 'tbl_m_kategoris';
    protected $primaryKey = 'id';
    protected $timestamps = true;
    
    protected $fillable = [
        'kode',
        'kategori',
        'keterangan',
        'status'
    ];

    public function searchPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            $conditions = [];
            $params = [];
            
            if (!empty($search)) {
                $conditions[] = "(kode LIKE :search OR kategori LIKE :search OR keterangan LIKE :search)";
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
            throw new Exception("Failed to fetch records");
        }
    }

    public function validateData($data, $id = null) {
        $errors = [];
        
        // Validate kode
        if (empty($data['kode'])) {
            $errors['kode'] = 'Kode kategori is required';
        } else {
            // Check for duplicate kode
            $existing = $this->findByKode($data['kode']);
            if ($existing && (!$id || $existing->id != $id)) {
                $errors['kode'] = 'Kode kategori already exists';
            }
        }
        
        // Validate kategori
        if (empty($data['kategori'])) {
            $errors['kategori'] = 'Nama kategori is required';
        }
        
        return $errors;
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
            throw new Exception("Failed to fetch kategori");
        }
    }

    public function getActiveKategoris() {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE status = '1' ORDER BY kategori ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database Error in getActiveKategoris: " . $e->getMessage());
            throw new Exception("Failed to fetch active kategoris");
        }
    }

    public function generateKode() {
        try {
            $year = date('y');
            $month = date('m');
            
            // Get last number from this month
            $sql = "SELECT kode FROM {$this->table} WHERE kode LIKE :prefix ORDER BY kode DESC LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':prefix', "KTG{$year}{$month}%");
            $stmt->execute();
            
            $data = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($data) {
                $lastNumber = intval(substr($data->kode, -4));
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }
            
            return 'KTG' . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            
        } catch (PDOException $e) {
            error_log("Database Error in generateKode: " . $e->getMessage());
            throw new Exception("Failed to generate kode");
        }
    }

    public function update($id, $data) {
        try {
            $fields = array_intersect_key($data, array_flip($this->fillable));
            $fields['updated_at'] = date('Y-m-d H:i:s');
            
            error_log("Updating kategori with data: " . print_r($fields, true)); // Debug log
            
            $set = implode(', ', array_map(function($field) {
                return "$field = :$field";
            }, array_keys($fields)));
            
            $sql = "UPDATE {$this->table} SET $set WHERE {$this->primaryKey} = :id";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindValue(':id', $id);
            foreach ($fields as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Database Error in update: " . $e->getMessage());
            throw new Exception("Failed to update record");
        }
    }
} 