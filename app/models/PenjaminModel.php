<?php
class PenjaminModel extends BaseModel {
    protected $table = 'tbl_m_penjamins';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'kode',
        'penjamin',
        'persen',
        'status',
        'created_at',
        'updated_at'
    ];

    public function generateKode() {
        try {
            // Get the last code from database
            $sql = "SELECT kode FROM {$this->table} 
                   WHERE kode LIKE 'PJM%' 
                   ORDER BY kode DESC LIMIT 1";
            $stmt       = $this->conn->prepare($sql);
            $stmt->execute();
            $lastCode   = $stmt->fetch(PDO::FETCH_OBJ);

            if ($lastCode) {
                // Extract number from last code
                $number = (int) substr($lastCode->kode, 3);
                $newNumber = $number + 1;
            } else {
                $newNumber = 1;
            }

            // Generate new code with padding
            return 'PJM' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        } catch (PDOException $e) {
            error_log("Error generating kode: " . $e->getMessage());
            throw new Exception("Failed to generate kode");
        }
    }

    public function create($data) {
        try {
            // Generate kode if not provided
            if (empty($data['kode'])) {
                $data['kode'] = $this->generateKode();
            }

            // Set timestamps with correct column names
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');

            // Prepare columns and values for insert
            $columns = implode(', ', array_keys($data));
            $values = ':' . implode(', :', array_keys($data));
            
            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
            $stmt = $this->conn->prepare($sql);
            
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            
            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("Error in PenjaminModel::create - " . $e->getMessage());
            throw new Exception("Failed to create penjamin: " . $e->getMessage());
        }
    }

    public function update($id, $data) {
        try {
            // Set updated timestamp
            $data['updated_date'] = date('Y-m-d H:i:s');
            
            return parent::update($id, $data);
            
        } catch (Exception $e) {
            error_log("Error in PenjaminModel::update - " . $e->getMessage());
            throw new Exception("Failed to update penjamin");
        }
    }

    public function validate($data, $id = null) {
        $errors = [];

        // Validate penjamin
        if (empty($data['penjamin'])) {
            $errors[] = 'Nama penjamin harus diisi';
        }

        // Validate persen
        if (!isset($data['persen']) || !is_numeric($data['persen'])) {
            $errors[] = 'Persentase harus berupa angka';
        } else if ($data['persen'] < 0 || $data['persen'] > 100) {
            $errors[] = 'Persentase harus antara 0 dan 100';
        }

        return $errors;
    }

    public function getActivePenjamins() {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE status = '1' ORDER BY penjamin ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database Error in getActivePenjamins: " . $e->getMessage());
            return [];
        }
    }

    public function searchPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            $conditions = ["1=1"];
            $params = [];
            
            if (!empty($search)) {
                $conditions[] = "(kode LIKE :search OR penjamin LIKE :search)";
                $params[':search'] = "%{$search}%";
            }
            
            $where = implode(' AND ', $conditions);
            
            // Get total records
            $countSql = "SELECT COUNT(*) as total FROM {$this->table} WHERE {$where}";
            $stmt = $this->conn->prepare($countSql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_OBJ)->total;
            
            // Get paginated records
            $sql = "SELECT * FROM {$this->table} 
                   WHERE {$where} 
                   ORDER BY created_at DESC 
                   LIMIT :limit OFFSET :offset";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            $stmt->execute();
            
            return [
                'data' => $stmt->fetchAll(PDO::FETCH_OBJ),
                'total' => (int)$total
            ];
            
        } catch (PDOException $e) {
            error_log("Database Error in searchPaginate: " . $e->getMessage());
            throw new Exception("Failed to fetch records: " . $e->getMessage());
        }
    }

    public function softDelete($id) {
        try {
            $sql = "UPDATE {$this->table} SET status = '0' WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error in softDelete: " . $e->getMessage());
            throw new Exception("Failed to delete record");
        }
    }
} 