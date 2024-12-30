<?php
class PoliModel extends BaseModel {
    protected $table = 'tbl_m_polis';
    protected $primaryKey = 'id';
    protected $timestamps = true;
    
    protected $fillable = [
        'kode',
        'poli',
        'keterangan',
        'post_location',
        'status'
    ];

    public function searchPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            
            // Base query
            $sql = "SELECT * FROM {$this->table} WHERE 1=1";
            $countSql = "SELECT COUNT(*) as total FROM {$this->table} WHERE 1=1";
            
            // Add search condition if search is not empty
            if (!empty($search)) {
                $searchCondition = " AND (kode LIKE :search OR poli LIKE :search OR keterangan LIKE :search)";
                $sql .= $searchCondition;
                $countSql .= $searchCondition;
            }
            
            // Add order by
            $sql .= " ORDER BY created_at DESC";
            
            // Add limit
            $sql .= " LIMIT :offset, :perPage";
            
            // Prepare and execute count query
            $countStmt = $this->conn->prepare($countSql);
            if (!empty($search)) {
                $countStmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
            }
            $countStmt->execute();
            $total = $countStmt->fetch(PDO::FETCH_OBJ)->total;
            
            // Prepare and execute main query
            $stmt = $this->conn->prepare($sql);
            if (!empty($search)) {
                $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
            }
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
            $stmt->execute();
            
            return [
                'data' => $stmt->fetchAll(PDO::FETCH_OBJ),
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $page
            ];
            
        } catch (PDOException $e) {
            error_log("Database Error in searchPaginate: " . $e->getMessage());
            throw new Exception("Failed to fetch records");
        }
    }

    public function getActiveRecords() {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE status = '1' ORDER BY poli ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database Error in getActiveRecords: " . $e->getMessage());
            return [];
        }
    }

    public function generateKode() {
        try {
            // Get current year and month
            $yearMonth = date('ym');
            
            // Get latest code from database for current year/month
            $sql = "SELECT kode FROM {$this->table} 
                    WHERE kode LIKE 'PL{$yearMonth}%' 
                    ORDER BY kode DESC LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $lastCode = $stmt->fetch(PDO::FETCH_OBJ);

            if ($lastCode) {
                // Extract sequence number and increment
                $sequence = intval(substr($lastCode->kode, -4)) + 1;
            } else {
                // Start new sequence
                $sequence = 1;
            }

            // Generate new code with format PLYYMMxxxx
            // PL = Poli prefix
            // YYMM = Year and Month
            // xxxx = 4 digit sequence padded with zeros
            return 'PL' . $yearMonth . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        } catch (PDOException $e) {
            error_log("Database Error in generateKode: " . $e->getMessage());
            throw new Exception("Failed to generate kode");
        }
    }

    public function find($id) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database Error in find: " . $e->getMessage());
            throw new Exception("Failed to fetch record");
        }
    }

    public function update($id, $data) {
        try {
            $data['updated_at'] = date('Y-m-d H:i:s');
            
            $fields = [];
            $values = [];
            
            foreach ($data as $key => $value) {
                if (in_array($key, $this->fillable) || $key === 'updated_at') {
                    $fields[] = "{$key} = :{$key}";
                    $values[":{$key}"] = $value;
                }
            }
            
            $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            
            foreach ($values as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->bindValue(':id', $id);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error in update: " . $e->getMessage());
            throw new Exception("Failed to update record");
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
} 