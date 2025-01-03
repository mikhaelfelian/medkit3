<?php
class RadiologiModel extends BaseModel {
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
        'remun_tipe',
        'remun_perc',
        'remun_nom',
        'apres_tipe',
        'apres_perc',
        'apres_nom',
        'status',
        'status_item',
        'status_hps',
        'created_at',
        'updated_at'
    ];

    public function searchPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            
            $query = "SELECT i.*, k.kategori as nama_kategori, m.merk as nama_merk 
                     FROM {$this->table} i 
                     LEFT JOIN tbl_m_kategoris k ON i.id_kategori = k.id 
                     LEFT JOIN tbl_m_merks m ON i.id_merk = m.id 
                     WHERE i.status_hps = '0' AND i.status_item = '4'";
            
            $params = [];
            
            if (!empty($search)) {
                $query .= " AND (i.kode LIKE :search OR i.item LIKE :search OR k.kategori LIKE :search OR m.merk LIKE :search)";
                $params[':search'] = "%{$search}%";
            }
            
            // Count total records
            $countQuery = str_replace("i.*, k.kategori as nama_kategori, m.merk as nama_merk", "COUNT(*) as total", $query);
            $stmt = $this->conn->prepare($countQuery);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_OBJ)->total;
            
            // Get paginated data
            $query .= " ORDER BY i.created_at DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($query);
            
            // Bind all parameters
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            return [
                'data' => $data,
                'total' => $total
            ];
            
        } catch (PDOException $e) {
            error_log("Database Error in searchPaginate: " . $e->getMessage());
            throw new Exception("Failed to fetch radiologi data");
        }
    }

    public function countDeleted() {
        try {
            $sql = "SELECT COUNT(*) as total 
                    FROM {$this->table} 
                    WHERE status_hps = '1' 
                    AND status_item = '4'"; // For radiologi items
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return (int)$stmt->fetch(PDO::FETCH_OBJ)->total;
            
        } catch (PDOException $e) {
            error_log("Database Error in countDeleted: " . $e->getMessage());
            return 0;
        }
    }

    public function generateKode() {
        try {
            $year = date('y');
            $month = date('m');
            
            // Get last number from this month for radiologi (RD prefix)
            $sql = "SELECT kode FROM {$this->table} 
                    WHERE kode LIKE :prefix 
                    AND status_item = '4' 
                    ORDER BY kode DESC LIMIT 1";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':prefix', "RD{$year}{$month}%");
            $stmt->execute();
            
            $data = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($data) {
                // Extract the number part and increment
                $lastNumber = intval(substr($data->kode, -4));
                $newNumber = $lastNumber + 1;
            } else {
                // If no existing code, start with 1
                $newNumber = 1;
            }
            
            // Generate new code with padding
            return "RD{$year}{$month}" . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            
        } catch (PDOException $e) {
            error_log("Database Error in generateKode: " . $e->getMessage());
            throw new Exception("Failed to generate kode");
        }
    }

    public function softDelete($id) {
        try {
            $sql = "UPDATE {$this->table} 
                    SET status_hps = '1', 
                        deleted_at = :deleted_at 
                    WHERE id = :id";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':deleted_at', date('Y-m-d H:i:s'));
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Database Error in softDelete: " . $e->getMessage());
            throw new Exception("Failed to delete record");
        }
    }

    public function getDeletedPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            $conditions = ["status_hps = '1'"];
            
            if (!empty($search)) {
                $conditions[] = "(kode LIKE :search OR item LIKE :search)";
            }
            
            $where = implode(' AND ', $conditions);
            
            // Get total records
            $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE {$where}";
            $stmt = $this->conn->prepare($sql);
            
            if (!empty($search)) {
                $stmt->bindValue(':search', "%{$search}%");
            }
            
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_OBJ)->total;
            
            // Get paginated records
            $sql = "SELECT * FROM {$this->table} WHERE {$where} ORDER BY created_at DESC LIMIT :offset, :limit";
            $stmt = $this->conn->prepare($sql);
            
            if (!empty($search)) {
                $stmt->bindValue(':search', "%{$search}%");
            }
            
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->execute();
            
            return [
                'data' => $stmt->fetchAll(PDO::FETCH_OBJ),
                'total' => $total
            ];
            
        } catch (PDOException $e) {
            error_log("Database Error in getDeletedPaginate: " . $e->getMessage());
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
            // Only allow deletion of items that are already in trash
            $sql = "DELETE FROM {$this->table} 
                    WHERE id = :id 
                    AND status_hps = '1' 
                    AND status_item = '4'"; // Only radiologi items
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Database Error in permanentDelete: " . $e->getMessage());
            throw new Exception("Failed to permanently delete record");
        }
    }

    public function validate($data, $id = null) {
        $errors = [];

        // Validate id_kategori
        if (empty($data['id_kategori'])) {
            $errors['id_kategori'] = 'Kategori harus dipilih';
        }

        // Validate item name
        if (empty($data['item'])) {
            $errors['item'] = 'Nama tindakan harus diisi';
        } else {
            // Check for duplicate item names, excluding current record if updating
            $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE item = :item AND status_hps = '0'";
            if ($id) {
                $sql .= " AND id != :id";
            }
            
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':item', $data['item']);
                if ($id) {
                    $stmt->bindValue(':id', $id);
                }
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_OBJ);
                
                if ($result->count > 0) {
                    $errors['item'] = 'Nama tindakan sudah digunakan';
                }
            } catch (PDOException $e) {
                error_log("Database Error in validate: " . $e->getMessage());
                throw new Exception("Gagal memvalidasi data");
            }
        }

        // Validate harga_jual
        if (empty($data['harga_jual'])) {
            $errors['harga_jual'] = 'Harga harus diisi';
        } else if (!is_numeric(str_replace(['.', ','], '', $data['harga_jual']))) {
            $errors['harga_jual'] = 'Harga harus berupa angka';
        }

        // Validate remun_tipe if set
        if (!empty($data['remun_tipe'])) {
            if ($data['remun_tipe'] == '1') {
                // Percentage type
                if (!empty($data['remun_perc']) && (!is_numeric($data['remun_perc']) || $data['remun_perc'] > 100)) {
                    $errors['remun_perc'] = 'Persentase remunerasi harus antara 0-100';
                }
            } else if ($data['remun_tipe'] == '2') {
                // Nominal type
                if (!empty($data['remun_nom']) && !is_numeric(str_replace(['.', ','], '', $data['remun_nom']))) {
                    $errors['remun_nom'] = 'Nominal remunerasi harus berupa angka';
                }
            }
        }

        // Validate apres_tipe if set
        if (!empty($data['apres_tipe'])) {
            if ($data['apres_tipe'] == '1') {
                // Percentage type
                if (!empty($data['apres_perc']) && (!is_numeric($data['apres_perc']) || $data['apres_perc'] > 100)) {
                    $errors['apres_perc'] = 'Persentase apresiasi harus antara 0-100';
                }
            } else if ($data['apres_tipe'] == '2') {
                // Nominal type
                if (!empty($data['apres_nom']) && !is_numeric(str_replace(['.', ','], '', $data['apres_nom']))) {
                    $errors['apres_nom'] = 'Nominal apresiasi harus berupa angka';
                }
            }
        }

        return $errors;
    }

    public function getTrashPaginate($search = '', $page = 1, $perPage = 10, $filters = []) {
        try {
            $offset = ($page - 1) * $perPage;
            
            $conditions = ["i.status_hps = '1'"]; // Base condition for trash
            $params = [];
            
            // Add status_item filter
            if (isset($filters['status_item'])) {
                $conditions[] = "i.status_item = :status_item";
                $params[':status_item'] = $filters['status_item'];
            }
            
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
                'total' => $total
            ];
            
        } catch (PDOException $e) {
            error_log("Database Error in getTrashPaginate: " . $e->getMessage());
            throw new Exception("Failed to fetch trash records");
        }
    }
} 