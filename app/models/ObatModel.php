<?php
class ObatModel extends BaseModel {
    protected $table = 'tbl_m_items';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode',
        'nama',
        'id_kategori',
        'barcode',
        'item',
        'jml',
        'harga_jual',
        'status_obat',
    ];

    public function searchPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            $conditions = [];
            $params = [];
            
            if (!empty($search)) {
                $conditions[] = "(i.kode LIKE :search OR i.nama LIKE :search OR k.kategori LIKE :search)";
                $params[':search'] = "%{$search}%";
            }
            
            $where = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';
            
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
            $sql = "SELECT i.*, k.kategori as nama_kategori 
                    FROM {$this->table} i 
                    LEFT JOIN tbl_m_kategoris k ON i.id_kategori = k.id 
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
            $fields = array_intersect_key($data, array_flip($this->fillable));
            $fields['created_at'] = date('Y-m-d H:i:s');
            $fields['status_obat'] = 1; // Changed from 4 to 1 for Obat
            
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
            $fields['updated_at'] = date('Y-m-d H:i:s');
            
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
        
        // ... existing validations ...
        
        // Validate kategori
        if (empty($data['id_kategori'])) {
            $errors['id_kategori'] = 'Kategori is required';
        } else {
            // Check if kategori exists and is active
            $kategoriModel = $this->loadModel('Kategori');
            $kategori = $kategoriModel->find($data['id_kategori']);
            if (!$kategori || $kategori->status != 1) {
                $errors['id_kategori'] = 'Invalid kategori selected';
            }
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
} 