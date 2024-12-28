<?php
class ObatModel extends BaseModel {
    protected $table = 'tbl_m_items';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'kode',
        'id_kategori',
        'id_merk',
        'item',
        'item_alias',
        'item_kand',
        'harga_beli',
        'harga_jual',
        'status',
        'status_stok',
        'status_item',
        'status_hps',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function searchPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            $conditions = ["i.status_hps = '0' AND i.status_item = '1'"];
            $params = [];
            
            if (!empty($search)) {
                $conditions[] = "(i.kode LIKE :search OR i.item LIKE :search OR k.kategori LIKE :search)";
                $params[':search'] = "%{$search}%";
            }
            
            $where = 'WHERE ' . implode(' AND ', $conditions);
            
            // Get total records
            $countSql = "SELECT COUNT(*) as total 
                         FROM {$this->table} i 
                         LEFT JOIN tbl_m_kategoris k ON i.id_kategori = k.id 
                         {$where}";
            
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
            $sql = "SELECT i.*, k.kategori as nama_kategori, m.merk as nama_merk 
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
                'last_page' => $lastPage
            ];
            
        } catch (PDOException $e) {
            error_log("Database Error in searchPaginate: " . $e->getMessage());
            throw new Exception("Failed to fetch records");
        }
    }

    public function create($data) {
        try {
            // Debug incoming data
            error_log("Creating obat with data: " . print_r($data, true));
            
            $fields = array_intersect_key($data, array_flip($this->fillable));
            
            // Ensure required fields
            $fields['status_item'] = '1';  // For obat
            $fields['created_at'] = date('Y-m-d H:i:s');
            
            // Handle empty fields
            $fields['item_kand'] = $fields['item_kand'] ?? '';
            $fields['item_alias'] = $fields['item_alias'] ?? '';
            $fields['status_stok'] = $fields['status_stok'] ?? '0';
            
            $columns = implode(', ', array_keys($fields));
            $values = implode(', ', array_map(function($field) {
                return ":$field";
            }, array_keys($fields)));
            
            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
            error_log("SQL Query: " . $sql);
            
            $stmt = $this->conn->prepare($sql);
            
            foreach ($fields as $key => $value) {
                $stmt->bindValue(":$key", $value);
                error_log("Binding $key = $value");
            }
            
            $result = $stmt->execute();
            error_log("Insert result: " . ($result ? 'true' : 'false'));
            
            if (!$result) {
                error_log("PDO Error Info: " . print_r($stmt->errorInfo(), true));
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Database Error in create: " . $e->getMessage());
            throw new Exception("Failed to create record: " . $e->getMessage());
        }
    }

    public function update($id, $data) {
        try {
            $fields = array_intersect_key($data, array_flip($this->fillable));
            $fields['updated_at'] = date('Y-m-d H:i:s');
            
            // Ensure item_kand is included even if empty
            if (!isset($fields['item_kand'])) {
                $fields['item_kand'] = '';
            }
            
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

    public function generateKode() {
        try {
            $year = date('y');
            $month = date('m');
            
            // Get last number from this month
            $sql = "SELECT kode FROM {$this->table} WHERE kode LIKE :prefix ORDER BY kode DESC LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':prefix', "OB{$year}{$month}%");
            $stmt->execute();
            
            $data = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($data) {
                $lastNumber = intval(substr($data->kode, -4));
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }
            
            return 'OB' . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            
        } catch (PDOException $e) {
            error_log("Database Error in generateKode: " . $e->getMessage());
            throw new Exception("Failed to generate kode");
        }
    }

    public function validateData($data, $id = null) {
        $errors = [];
        
        // Validate kode
        if (empty($data['kode'])) {
            $errors['kode'] = 'Kode obat harus diisi';
        } else {
            // Check for duplicate kode
            $sql = "SELECT id FROM {$this->table} WHERE kode = :kode AND status_item = '1'";
            if ($id) {
                $sql .= " AND id != :id";
            }
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':kode', $data['kode']);
            if ($id) {
                $stmt->bindValue(':id', $id);
            }
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($result) {
                $errors['kode'] = 'Kode obat sudah digunakan';
            }
        }
        
        // Validate kategori
        if (empty($data['id_kategori'])) {
            $errors['id_kategori'] = 'Kategori is required';
        } else {
            // Check if kategori exists and is active
            $sql = "SELECT status FROM tbl_m_kategoris WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $data['id_kategori']);
            $stmt->execute();
            $kategori = $stmt->fetch(PDO::FETCH_OBJ);
            
            if (!$kategori || $kategori->status != '1') {
                $errors['id_kategori'] = 'Invalid kategori selected';
            }
        }
        
        // Validate merk
        if (empty($data['id_merk'])) {
            $errors['id_merk'] = 'Merk is required';
        } else {
            // Check if merk exists and is active
            $sql = "SELECT status FROM tbl_m_merks WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $data['id_merk']);
            $stmt->execute();
            $merk = $stmt->fetch(PDO::FETCH_OBJ);
            
            if (!$merk || $merk->status != '1') {
                $errors['id_merk'] = 'Invalid merk selected';
            }
        }
        
        // Validate required fields
        if (empty($data['item'])) {
            $errors['item'] = 'Nama obat is required';
        }
        
        if (!isset($data['harga_beli']) || $data['harga_beli'] < 0) {
            $errors['harga_beli'] = 'Harga beli must be a positive number';
        }
        
        if (!isset($data['harga_jual']) || $data['harga_jual'] < 0) {
            $errors['harga_jual'] = 'Harga jual must be a positive number';
        }
        
        return $errors;
    }

    public function getWithKategori($id) {
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
            error_log("Database Error in getWithKategori: " . $e->getMessage());
            throw new Exception("Failed to fetch record");
        }
    }

    public function getWithDetails($id) {
        try {
            $sql = "SELECT i.*, k.kategori as nama_kategori, m.merk as nama_merk 
                    FROM {$this->table} i 
                    LEFT JOIN tbl_m_kategoris k ON i.id_kategori = k.id 
                    LEFT JOIN tbl_m_merks m ON i.id_merk = m.id 
                    WHERE i.id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database Error in getWithDetails: " . $e->getMessage());
            throw new Exception("Failed to fetch record");
        }
    }

    public function findByMerk($merkId) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE id_merk = :merk_id LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':merk_id', $merkId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database Error in findByMerk: " . $e->getMessage());
            throw new Exception("Failed to check merk usage");
        }
    }

    public function countDeleted() {
        try {
            $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE status_hps = '1' AND status_item = '1'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ)->total;
        } catch (PDOException $e) {
            error_log("Database Error in countDeleted: " . $e->getMessage());
            return 0;
        }
    }

    public function getTrashPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            $conditions = ["i.status_hps = '1' AND i.status_item = '1'"];
            $params = [];
            
            if (!empty($search)) {
                $conditions[] = "(i.kode LIKE :search OR i.item LIKE :search OR k.kategori LIKE :search OR m.merk LIKE :search)";
                $params[':search'] = "%{$search}%";
            }
            
            $where = implode(' AND ', $conditions);
            
            // Get total records
            $sql = "SELECT COUNT(*) as total 
                    FROM {$this->table} i 
                    LEFT JOIN tbl_m_kategoris k ON i.id_kategori = k.id 
                    LEFT JOIN tbl_m_merks m ON i.id_merk = m.id 
                    WHERE {$where}";
            $stmt = $this->conn->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_OBJ)->total;
            
            // Get paginated records
            $sql = "SELECT i.*, k.kategori as nama_kategori, m.merk as nama_merk 
                    FROM {$this->table} i 
                    LEFT JOIN tbl_m_kategoris k ON i.id_kategori = k.id 
                    LEFT JOIN tbl_m_merks m ON i.id_merk = m.id 
                    WHERE {$where} 
                    ORDER BY i.deleted_at DESC 
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

    public function delete($id) {
        try {
            $data = [
                'status_hps' => '1',
                'deleted_at' => date('Y-m-d H:i:s')
            ];
            
            $sql = "UPDATE {$this->table} 
                    SET status_hps = :status_hps, deleted_at = :deleted_at 
                    WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':status_hps', $data['status_hps']);
            $stmt->bindValue(':deleted_at', $data['deleted_at']);
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Database Error in delete: " . $e->getMessage());
            throw new Exception("Failed to delete record");
        }
    }

    public function restore($id) {
        try {
            $sql = "UPDATE {$this->table} 
                    SET status_hps = '0', deleted_at = NULL 
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
} 