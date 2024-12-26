<?php
class GudangModel extends BaseModel {
    protected $table = 'tbl_m_gudangs';
    
    protected $fillable = [
        'kode',
        'gudang',
        'keterangan',
        'status',
        'status_gd',
        'created_at',
        'updated_at'
    ];

    public function searchPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            $conditions = [];
            $params = [];
            
            if (!empty($search)) {
                $conditions[] = "(kode LIKE :search OR gudang LIKE :search)";
                $params[':search'] = "%{$search}%";
            }
            
            $where = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';
            
            // Get total records
            $sql = "SELECT COUNT(*) as total FROM {$this->table} {$where}";
            $stmt = $this->conn->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_OBJ)->total;
            
            // Get paginated records
            $sql = "SELECT * FROM {$this->table} {$where} ORDER BY id DESC LIMIT {$perPage} OFFSET {$offset}";
            $stmt = $this->conn->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            return [
                'data' => $data,
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $page,
                'last_page' => ceil($total / $perPage)
            ];
            
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            throw new Exception("Failed to fetch records");
        }
    }

    public function togglePrimaryStatus($id) {
        try {
            // First, set all records to non-primary
            $sql = "UPDATE {$this->table} SET status_gd = '0'";
            $this->conn->exec($sql);
            
            // Then set the selected record as primary
            $sql = "UPDATE {$this->table} SET status_gd = '1' WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error in togglePrimaryStatus: " . $e->getMessage());
            throw new Exception("Failed to update primary status");
        }
    }

    public function unsetAllPrimary() {
        try {
            $sql = "UPDATE {$this->table} SET status_gd = '0'";
            return $this->conn->exec($sql);
        } catch (PDOException $e) {
            error_log("Database Error in unsetAllPrimary: " . $e->getMessage());
            throw new Exception("Failed to update primary status");
        }
    }
} 