<?php

class TindakanModel extends BaseModel {
    protected $table = 'tbl_m_items';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'kode',
        'id_kategori',
        'item',
        'item_alias',
        'harga_jual',
        'status',
        'status_item',
        'status_hps',
        'created_at'
    ];

    public function searchPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            $conditions = ["i.status_hps = '0' AND i.status_item = '2'"]; // Only show active tindakan
            $params = [];
            
            if (!empty($search)) {
                $conditions[] = "(i.kode LIKE :search OR i.item LIKE :search OR k.kategori LIKE :search OR m.merk LIKE :search)";
                $params[':search'] = "%{$search}%";
            }
            
            $where = 'WHERE ' . implode(' AND ', $conditions);
            
            // Get total records with joins
            $countSql = "SELECT COUNT(*) as total 
                         FROM {$this->table} i 
                         LEFT JOIN tbl_m_kategoris k ON i.id_kategori = k.id 
                         LEFT JOIN tbl_m_merks m ON i.id_merk = m.id 
                         {$where}";
            
            $stmt = $this->conn->prepare($countSql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_OBJ)->total;
            
            // Get paginated records with joins
            $sql = "SELECT i.*, 
                           k.kategori as nama_kategori, 
                           m.merk as nama_merk 
                    FROM {$this->table} i 
                    LEFT JOIN tbl_m_kategoris k ON i.id_kategori = k.id 
                    LEFT JOIN tbl_m_merks m ON i.id_merk = m.id 
                    {$where} 
                    ORDER BY i.created_at DESC 
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
                'last_page' => ceil($total / $perPage)
            ];
            
        } catch (PDOException $e) {
            error_log("Database Error in searchPaginate: " . $e->getMessage());
            throw new Exception("Failed to fetch records");
        }
    }

    public function countDeleted() {
        try {
            // Count items that are marked as deleted (status_hps = '1') and are tindakan (status_item = '2')
            $sql = "SELECT COUNT(*) as total 
                    FROM {$this->table} 
                    WHERE status_hps = '1' 
                    AND status_item = '2'";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ)->total;
            
        } catch (PDOException $e) {
            error_log("Database Error in countDeleted: " . $e->getMessage());
            return 0;
        }
    }

    public function getTrash($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            // Update condition to use status_item instead of status_obat
            $conditions = ["i.status_hps = '1' AND i.status_item = '2'"]; 
            $params = [];
            
            if (!empty($search)) {
                $conditions[] = "(i.kode LIKE :search OR i.item LIKE :search OR k.kategori LIKE :search OR m.merk LIKE :search)";
                $params[':search'] = "%{$search}%";
            }
            
            $where = 'WHERE ' . implode(' AND ', $conditions);
            
            // Get total records with joins
            $countSql = "SELECT COUNT(*) as total 
                         FROM {$this->table} i 
                         LEFT JOIN tbl_m_kategoris k ON i.id_kategori = k.id 
                         LEFT JOIN tbl_m_merks m ON i.id_merk = m.id 
                         {$where}";
            
            $stmt = $this->conn->prepare($countSql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_OBJ)->total;
            
            // Get paginated records with joins
            $sql = "SELECT i.*, 
                           k.kategori as nama_kategori, 
                           m.merk as nama_merk 
                    FROM {$this->table} i 
                    LEFT JOIN tbl_m_kategoris k ON i.id_kategori = k.id 
                    LEFT JOIN tbl_m_merks m ON i.id_merk = m.id 
                    {$where} 
                    ORDER BY i.created_at DESC 
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
                'last_page' => ceil($total / $perPage)
            ];
            
        } catch (PDOException $e) {
            error_log("Database Error in getTrash: " . $e->getMessage());
            throw new Exception("Failed to fetch deleted records");
        }
    }

    public function restore($id) {
        try {
            $sql = "UPDATE {$this->table} 
                    SET status_hps = '0', 
                        deleted_at = NULL 
                    WHERE id = :id";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Database Error in restore: " . $e->getMessage());
            throw new Exception("Failed to restore record");
        }
    }

    public function permanentDelete($id) {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = :id AND status_hps = '1'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error in permanentDelete: " . $e->getMessage());
            throw new Exception("Failed to permanently delete record");
        }
    }

    public function validateData($data, $id = null) {
        $errors = [];
        
        // Validate kode
        if (empty($data['kode'])) {
            $errors['kode'] = 'Kode tindakan harus diisi';
        } else {
            // Check for duplicate kode
            $sql = "SELECT id FROM {$this->table} WHERE kode = :kode AND status_item = '2'";
            if ($id) {
                $sql .= " AND id != :id";
            }
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':kode', $data['kode']);
            if ($id) {
                $stmt->bindValue(':id', $id);
            }
            $stmt->execute();
            
            if ($stmt->fetch(PDO::FETCH_OBJ)) {
                $errors['kode'] = 'Kode tindakan sudah digunakan';
            }
        }
        
        // Validate kategori
        if (empty($data['id_kategori'])) {
            $errors['id_kategori'] = 'Kategori harus dipilih';
        }
        
        // Validate item name
        if (empty($data['item'])) {
            $errors['item'] = 'Nama tindakan harus diisi';
        }
        
        // Validate harga_jual
        if (empty($data['harga_jual'])) {
            $errors['harga_jual'] = 'Harga tindakan harus diisi';
        } elseif (!is_numeric($data['harga_jual'])) {
            $errors['harga_jual'] = 'Harga tindakan harus berupa angka';
        }
        
        return $errors;
    }

    public function create($data) {
        try {
            $data['status_item'] = '2'; // Set as tindakan
            $fields = array_intersect_key($data, array_flip($this->fillable));
            
            $columns = array_keys($fields);
            $values = array_map(function($item) { return ":{$item}"; }, $columns);
            
            $sql = "INSERT INTO {$this->table} (`" . implode('`, `', $columns) . "`) 
                    VALUES (" . implode(', ', $values) . ")";
            
            $stmt = $this->conn->prepare($sql);
            
            foreach ($fields as $key => $value) {
                $stmt->bindValue(":{$key}", $value);
            }
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Database Error in create: " . $e->getMessage());
            throw new Exception("Failed to create record");
        }
    }

    public function generateKode() {
        try {
            $year = date('y');
            $month = date('m');
            
            // Get last number from this month for tindakan (TN prefix)
            $sql = "SELECT kode FROM {$this->table} 
                    WHERE kode LIKE :prefix 
                    AND status_item = '2' 
                    ORDER BY kode DESC LIMIT 1";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':prefix', "TN{$year}{$month}%");
            $stmt->execute();
            
            $data = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($data) {
                // Extract the number part and increment
                $lastNumber = intval(substr($data->kode, -4));
                $newNumber = $lastNumber + 1;
            } else {
                // Start from 1 if no existing codes
                $newNumber = 1;
            }
            
            // Format: TN + YY + MM + 4 digit number
            // Example: TN240300001
            return 'TN' . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            
        } catch (PDOException $e) {
            error_log("Database Error in generateKode: " . $e->getMessage());
            throw new Exception("Failed to generate kode");
        }
    }

    public function getWithDetails($id) {
        try {
            $sql = "SELECT i.*, k.kategori as nama_kategori 
                    FROM {$this->table} i 
                    LEFT JOIN tbl_m_kategoris k ON i.id_kategori = k.id 
                    WHERE i.id = :id";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_OBJ);
            
        } catch (PDOException $e) {
            error_log("Database Error in getWithDetails: " . $e->getMessage());
            throw new Exception("Failed to fetch record details");
        }
    }

    /**
     * Get trash items with pagination
     */
    public function getTrashPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            $conditions = ["i.status_hps = '1' AND i.status_item = '2'"]; // Only show deleted tindakan
            $params = [];
            
            if (!empty($search)) {
                $conditions[] = "(i.kode LIKE :search OR i.item LIKE :search OR k.kategori LIKE :search)";
                $params[':search'] = "%{$search}%";
            }
            
            $where = implode(' AND ', $conditions);
            
            // Get total records
            $sql = "SELECT COUNT(*) as total 
                    FROM {$this->table} i 
                    LEFT JOIN tbl_m_kategoris k ON i.id_kategori = k.id 
                    WHERE {$where}";
            $stmt = $this->conn->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_OBJ)->total;
            
            // Get paginated records
            $sql = "SELECT i.*, k.kategori as nama_kategori 
                    FROM {$this->table} i 
                    LEFT JOIN tbl_m_kategoris k ON i.id_kategori = k.id 
                    WHERE {$where} 
                    ORDER BY i.kode ASC 
                    LIMIT :offset, :limit";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
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
            error_log("Database Error in getTrashPaginate: " . $e->getMessage());
            throw new Exception("Failed to fetch trash data");
        }
    }

    /**
     * Permanent delete
     */
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
} 