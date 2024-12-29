<?php

class TindakanModel extends BaseModel {
    protected $table = 'tbl_m_items';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'kode',
        'id_kategori',
        'item',
        'harga_jual',
        'remun_tipe',
        'remun_perc',
        'remun_nom',
        'apres_tipe',
        'apres_perc',
        'apres_nom',
        'status',
        'status_item',
        'created_at',
        'updated_at'
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

    public function validateData($data) {
        $errors = [];
        
        // Validate required fields
        if (empty($data['id_kategori'])) {
            $errors[] = 'Kategori harus dipilih';
        }
        
        if (empty($data['item'])) {
            $errors[] = 'Nama tindakan harus diisi';
        }
        
        if (empty($data['harga_jual'])) {
            $errors[] = 'Harga harus diisi';
        }

        // Validate remunerasi if type is selected
        if (!empty($data['remun_tipe'])) {
            if ($data['remun_tipe'] == '1' && empty($data['remun_perc'])) {
                $errors[] = 'Persentase remunerasi harus diisi';
            }
            if ($data['remun_tipe'] == '2' && empty($data['remun_nom'])) {
                $errors[] = 'Nominal remunerasi harus diisi';
            }
        }

        // Validate apresiasi if type is selected
        if (!empty($data['apres_tipe'])) {
            if ($data['apres_tipe'] == '1' && empty($data['apres_perc'])) {
                $errors[] = 'Persentase apresiasi harus diisi';
            }
            if ($data['apres_tipe'] == '2' && empty($data['apres_nom'])) {
                $errors[] = 'Nominal apresiasi harus diisi';
            }
        }
        
        return $errors;
    }

    public function create($data) {
        try {
            // Clean numeric values
            $data['harga_jual'] = Angka::cleanNumber($data['harga_jual']);
            
            // Clean remun values
            $data['remun_perc'] = !empty($data['remun_perc']) ? floatval($data['remun_perc']) : 0;
            $data['remun_nom'] = !empty($data['remun_nom']) ? Angka::cleanNumber($data['remun_nom']) : 0;
            
            // Clean apres values
            $data['apres_perc'] = !empty($data['apres_perc']) ? floatval($data['apres_perc']) : 0;
            $data['apres_nom'] = !empty($data['apres_nom']) ? Angka::cleanNumber($data['apres_nom']) : 0;

            // Ensure tipe fields are set
            $data['remun_tipe'] = $data['remun_tipe'] ?: '0';
            $data['apres_tipe'] = $data['apres_tipe'] ?: '0';

            // Insert the record
            $fields = array_intersect_key($data, array_flip($this->fillable));
            
            $columns = array_keys($fields);
            $values = array_map(function($item) { return ":{$item}"; }, $columns);
            
            $sql = "INSERT INTO {$this->table} (`" . implode('`, `', $columns) . "`) 
                    VALUES (" . implode(', ', $values) . ")";
            
            $stmt = $this->conn->prepare($sql);
            
            foreach ($fields as $key => $value) {
                if ($key === 'remun_tipe' || $key === 'apres_tipe') {
                    // Handle ENUM fields
                    $stmt->bindValue(":{$key}", $value, PDO::PARAM_STR);
                } else {
                    $stmt->bindValue(":{$key}", $value);
                }
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

    public function update($id, $data) {
        try {
            // Clean numeric values
            $data['harga_jual'] = Angka::cleanNumber($data['harga_jual']);
            $data['remun_nom'] = Angka::cleanNumber($data['remun_nom']);
            $data['apres_nom'] = Angka::cleanNumber($data['apres_nom']);
            
            // Set updated timestamp
            $data['updated_at'] = date('Y-m-d H:i:s');
            
            return parent::update($id, $data);
            
        } catch (Exception $e) {
            error_log("Error in TindakanModel::update - " . $e->getMessage());
            throw new Exception("Failed to update tindakan");
        }
    }
} 