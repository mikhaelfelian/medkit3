<?php
class SupplierModel extends BaseModel {
    protected $table = 'tbl_m_suppliers';
    protected $primaryKey = 'id';
    protected $timestamps = true;
    
    protected $fillable = [
        'kode',
        'nama',
        'npwp',
        'alamat',
        'kota',
        'no_tlp',
        'no_hp',
        'cp',
        'status_hps'
    ];

    public function searchPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            $conditions = [];
            $params = [];
            
            if (!empty($search)) {
                $conditions[] = "(kode LIKE :search OR nama LIKE :search OR kota LIKE :search)";
                $params[':search'] = "%{$search}%";
            }
            
            // Only show non-deleted records
            $conditions[] = "deleted_at IS NULL";
            
            $where = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';
            
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

    public function generateKode() {
        try {
            // Get last number from kode
            $sql = "SELECT kode FROM {$this->table} 
                    WHERE kode LIKE 'P-%' 
                    ORDER BY CAST(SUBSTRING(kode, 3) AS UNSIGNED) DESC 
                    LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            $data = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($data) {
                // Extract number from P-XXX format and increment
                $lastNumber = (int)substr($data->kode, 2);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }
            
            // Format with leading zeros (3 digits)
            return 'P-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            
        } catch (PDOException $e) {
            error_log("Database Error in generateKode: " . $e->getMessage());
            throw new Exception("Failed to generate kode");
        }
    }

    public function validateData($data, $id = null) {
        $errors = [];
        
        // Validate required fields
        if (empty($data['nama'])) {
            $errors['nama'] = 'Nama supplier is required';
        }
        
        if (empty($data['kode'])) {
            $errors['kode'] = 'Kode is required';
        } else {
            // Check for duplicate kode
            $sql = "SELECT id FROM {$this->table} WHERE kode = :kode AND id != :id AND deleted_at IS NULL";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':kode', $data['kode']);
            $stmt->bindValue(':id', $id ?? 0);
            $stmt->execute();
            
            if ($stmt->fetch(PDO::FETCH_OBJ)) {
                $errors['kode'] = 'Kode already exists';
            }
        }
        
        // Validate phone numbers
        if (!empty($data['no_tlp']) && !preg_match('/^[0-9\-\+]{8,20}$/', $data['no_tlp'])) {
            $errors['no_tlp'] = 'Invalid phone number format';
        }
        
        if (!empty($data['no_hp']) && !preg_match('/^[0-9\-\+]{10,15}$/', $data['no_hp'])) {
            $errors['no_hp'] = 'Invalid mobile number format';
        }
        
        return $errors;
    }

    public function softDelete($id) {
        try {
            $sql = "UPDATE {$this->table} 
                    SET deleted_at = :deleted_at, status_hps = '1'
                    WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':deleted_at', date('Y-m-d H:i:s'));
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error in softDelete: " . $e->getMessage());
            throw new Exception("Failed to delete record");
        }
    }

    public function getActiveSuppliers() {
        try {
            $sql = "SELECT id, kode, nama 
                    FROM {$this->table} 
                    WHERE deleted_at IS NULL 
                    ORDER BY nama ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database Error in getActiveSuppliers: " . $e->getMessage());
            throw new Exception("Failed to fetch suppliers");
        }
    }
} 