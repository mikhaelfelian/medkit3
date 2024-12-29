<?php
class MerkModel extends BaseModel {
    protected $table = 'tbl_m_merks';
    protected $primaryKey = 'id';
    protected $timestamps = true;
    
    protected $fillable = [
        'kode',
        'merk',
        'keterangan',
        'status'
    ];

    public function searchPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            $conditions = [];
            $params = [];
            
            if (!empty($search)) {
                $conditions[] = "(merk LIKE :search OR keterangan LIKE :search)";
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

    public function delete($id) {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error in delete: " . $e->getMessage());
            throw new Exception("Failed to delete record");
        }
    }

    public function getActiveMerks() {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE status = '1' ORDER BY merk ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database Error in getActiveMerks: " . $e->getMessage());
            throw new Exception("Failed to fetch active merks");
        }
    }

    public function generateKode() {
        try {
            $year = date('y');
            $month = date('m');
            
            // Get last number from this month
            $sql = "SELECT kode FROM {$this->table} WHERE kode LIKE :prefix ORDER BY kode DESC LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':prefix', "MRK{$year}{$month}%");
            $stmt->execute();
            
            $data = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($data) {
                $lastNumber = intval(substr($data->kode, -4));
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }
            
            return 'MRK' . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            
        } catch (PDOException $e) {
            error_log("Database Error in generateKode: " . $e->getMessage());
            throw new Exception("Failed to generate kode");
        }
    }

    public function validateData($data, $id = null) {
        $errors = [];
        
        // Validate kode
        if (empty($data['kode'])) {
            $errors['kode'] = 'Kode merk is required';
        } else {
            // Check for duplicate kode
            $sql = "SELECT id FROM {$this->table} WHERE kode = :kode AND id != :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':kode', $data['kode']);
            $stmt->bindValue(':id', $id ?? 0);
            $stmt->execute();
            
            if ($stmt->fetch(PDO::FETCH_OBJ)) {
                $errors['kode'] = 'Kode merk already exists';
            }
        }
        
        // Validate merk name
        if (empty($data['merk'])) {
            $errors['merk'] = 'Nama merk is required';
        } else {
            // Check for duplicate merk name
            $sql = "SELECT id FROM {$this->table} WHERE merk = :merk AND id != :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':merk', $data['merk']);
            $stmt->bindValue(':id', $id ?? 0);
            $stmt->execute();
            
            if ($stmt->fetch(PDO::FETCH_OBJ)) {
                $errors['merk'] = 'Nama merk already exists';
            }
        }
        
        // Validate status
        if (!in_array($data['status'], ['0', '1'])) {
            $errors['status'] = 'Invalid status value';
        }
        
        return $errors;
    }

    public function getActiveRecords() {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE status = '1' ORDER BY merk ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database Error in getActiveRecords: " . $e->getMessage());
            return [];
        }
    }
} 