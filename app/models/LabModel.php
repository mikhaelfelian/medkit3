<?php
class LabModel extends BaseModel {
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
        'status_item',
        'status_hps',
        'created_at',
        'updated_at'
    ];

    public function searchPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            $conditions = ["i.status_hps = '0' AND i.status_item = '3'"]; // Only show lab items
            $params = [];
            
            if (!empty($search)) {
                $conditions[] = "(i.kode LIKE :search OR i.item LIKE :search OR k.kategori LIKE :search OR m.merk LIKE :search)";
                $params[':search'] = "%{$search}%";
            }
            
            $where = 'WHERE ' . implode(' AND ', $conditions);
            
            // Get total records
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
            
            // Calculate last page
            $lastPage = ceil($total / $perPage);
            $page = max(1, min($page, $lastPage));
            
            // Get paginated records with both kategori and merk joins
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
                'last_page' => $lastPage
            ];
            
        } catch (PDOException $e) {
            error_log("Database Error in searchPaginate: " . $e->getMessage());
            throw new Exception("Failed to fetch records");
        }
    }

    public function countDeleted() {
        try {
            $sql = "SELECT COUNT(*) as total FROM {$this->table} 
                    WHERE status_hps = '1' AND status_item = '3'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ)->total;
        } catch (PDOException $e) {
            error_log("Database Error in countDeleted: " . $e->getMessage());
            return 0;
        }
    }

    public function generateKode() {
        try {
            $year = date('y');
            $month = date('m');
            
            // Get last number from this month for lab items (LB prefix)
            $sql = "SELECT kode FROM {$this->table} 
                    WHERE kode LIKE :prefix 
                    AND status_item = '3' 
                    ORDER BY kode DESC LIMIT 1";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':prefix', "LB{$year}{$month}%");
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
            
            // Format: LB + YY + MM + 4 digit number
            // Example: LB240300001
            return 'LB' . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            
        } catch (PDOException $e) {
            error_log("Database Error in generateKode: " . $e->getMessage());
            throw new Exception("Failed to generate kode");
        }
    }

    public function getWithDetails($id) {
        try {
            $sql = "SELECT i.*, 
                       k.kategori as nama_kategori,
                       m.merk as nama_merk
                FROM {$this->table} i 
                LEFT JOIN tbl_m_kategoris k ON i.id_kategori = k.id 
                LEFT JOIN tbl_m_merks m ON i.id_merk = m.id 
                WHERE i.id = :id 
                AND i.status_item = '3'";
                
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            
            $data = $stmt->fetch(PDO::FETCH_OBJ);
            
            if (!$data) {
                throw new Exception("Record not found");
            }
            
            return $data;
            
        } catch (PDOException $e) {
            error_log("Database Error in getWithDetails: " . $e->getMessage());
            throw new Exception("Failed to fetch record details");
        }
    }

    public function softDelete($id) {
        try {
            $sql = "UPDATE {$this->table} 
                    SET status_hps = '1', 
                        deleted_at = :deleted_at 
                    WHERE id = :id 
                    AND status_item = '3'";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':deleted_at', date('Y-m-d H:i:s'));
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Database Error in softDelete: " . $e->getMessage());
            throw new Exception("Failed to delete record");
        }
    }

    public function getTrashPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            $conditions = ["i.status_hps = '1' AND i.status_item = '3'"]; // Only show deleted lab items
            $params = [];
            
            if (!empty($search)) {
                $conditions[] = "(i.kode LIKE :search OR i.item LIKE :search OR k.kategori LIKE :search OR m.merk LIKE :search)";
                $params[':search'] = "%{$search}%";
            }
            
            $where = 'WHERE ' . implode(' AND ', $conditions);
            
            // Get total records
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
            
            // Calculate last page
            $lastPage = ceil($total / $perPage);
            $page = max(1, min($page, $lastPage));
            
            // Get paginated records
            $sql = "SELECT i.*, 
                       k.kategori as nama_kategori,
                       m.merk as nama_merk
                FROM {$this->table} i 
                LEFT JOIN tbl_m_kategoris k ON i.id_kategori = k.id 
                LEFT JOIN tbl_m_merks m ON i.id_merk = m.id 
                {$where} 
                ORDER BY i.deleted_at DESC 
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
            error_log("Database Error in getTrashPaginate: " . $e->getMessage());
            throw new Exception("Failed to fetch trash records");
        }
    }

    public function restore($id) {
        try {
            $sql = "UPDATE {$this->table} 
                    SET status_hps = '0', 
                        deleted_at = NULL 
                    WHERE id = :id 
                    AND status_item = '3'";
                    
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
            $sql = "DELETE FROM {$this->table} 
                    WHERE id = :id 
                    AND status_item = '3' 
                    AND status_hps = '1'";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Database Error in permanentDelete: " . $e->getMessage());
            throw new Exception("Failed to permanently delete record");
        }
    }
} 