<?php
class PasienModel extends BaseModel {
    protected $table = 'tbl_m_pasiens';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode',
        'nik',
        'nama',
        'nama_pgl',
        'no_hp',
        'alamat',
        'alamat_domisili',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'kota',
        'pekerjaan'
    ];

    public function searchPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            $conditions = [];
            $params = [];

            if (!empty($search)) {
                $conditions[] = "(nama LIKE :search OR nik LIKE :search OR kode LIKE :search)";
                $params[':search'] = "%{$search}%";
            }

            $where = empty($conditions) ? "" : "WHERE " . implode(' AND ', $conditions);

            // Get total records
            $sqlCount = "SELECT COUNT(*) as total FROM {$this->table} {$where}";
            $stmtCount = $this->conn->prepare($sqlCount);
            foreach ($params as $key => $value) {
                $stmtCount->bindValue($key, $value);
            }
            $stmtCount->execute();
            $total = $stmtCount->fetch(PDO::FETCH_OBJ)->total;

            // Get paginated records
            $sql = "SELECT * FROM {$this->table} 
                   {$where} 
                   ORDER BY created_at DESC 
                   LIMIT :offset, :limit";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);

            return [
                'data' => $data,
                'total' => $total
            ];

        } catch (PDOException $e) {
            error_log("Database Error in searchPaginate: " . $e->getMessage());
            throw new Exception("Failed to fetch records");
        }
    }

    public function find($id) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_OBJ);
            
        } catch (PDOException $e) {
            error_log("Database Error in find: " . $e->getMessage());
            throw new Exception("Failed to fetch record");
        }
    }

    public function create($data) {
        try {
            $fields = array_intersect_key($data, array_flip($this->fillable));
            
            $columns = implode(', ', array_keys($fields));
            $values = implode(', ', array_map(function($field) {
                return ":$field";
            }, array_keys($fields)));
            
            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
            $stmt = $this->conn->prepare($sql);
            
            foreach ($fields as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Database Error in create: " . $e->getMessage());
            throw new Exception("Failed to create record");
        }
    }

    public function update($id, $data) {
        try {
            $fields = array_intersect_key($data, array_flip($this->fillable));
            
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

    public function delete($id) {
        try {
            $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Database Error in delete: " . $e->getMessage());
            throw new Exception("Failed to delete record");
        }
    }

    public function generateKode() {
        try {
            $year = date('y');
            $month = date('m');
            
            // Get last number from this month
            $sql = "SELECT kode FROM {$this->table} WHERE kode LIKE :prefix ORDER BY kode DESC LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':prefix', "P{$year}{$month}%");
            $stmt->execute();
            
            $data = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($data) {
                $lastNumber = intval(substr($data->kode, -4));
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }
            
            return 'P' . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            
        } catch (PDOException $e) {
            error_log("Database Error in generateKode: " . $e->getMessage());
            throw new Exception("Failed to generate kode");
        }
    }
} 