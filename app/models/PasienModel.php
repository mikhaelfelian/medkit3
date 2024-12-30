<?php
class PasienModel extends BaseModel {
    protected $table = 'tbl_m_pasiens';
    protected $primaryKey = 'id';
    protected $timestamps = true;
    
    protected $fillable = [
        'no_rm',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'status'
    ];

    public function searchPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            
            // Debug query
            Logger::getInstance()->error("Debug SQL", [
                'table' => $this->table,
                'search' => $search,
                'page' => $page,
                'perPage' => $perPage,
                'offset' => $offset
            ]);
            
            $conditions = [];
            $params = [];
            
            if (!empty($search)) {
                $conditions[] = "(kode LIKE :search OR nik LIKE :search OR nama LIKE :search OR no_hp LIKE :search)";
                $params[':search'] = "%{$search}%";
            }
            
            // Build WHERE clause
            $where = '';
            if (!empty($conditions)) {
                $where = 'WHERE ' . implode(' AND ', $conditions);
            }
            
            // Get total records with debug
            $countSql = "SELECT COUNT(*) as total FROM {$this->table} {$where}";
            Logger::getInstance()->error("Count SQL: " . $countSql);
            
            $stmt = $this->conn->prepare($countSql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_OBJ)->total;
            
            Logger::getInstance()->error("Total records: " . $total);
            
            // Calculate last page
            $lastPage = ceil($total / $perPage);
            
            // Ensure current page is valid
            $page = max(1, min($page, $lastPage));
            
            // Get paginated records with debug
            $sql = "SELECT * FROM {$this->table} 
                   {$where} 
                   ORDER BY created_at DESC 
                   LIMIT :limit OFFSET :offset";
                   
            Logger::getInstance()->error("Main SQL: " . $sql);
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            Logger::getInstance()->error("Fetched records: " . count($data));
            
            return [
                'data' => $data,
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $page,
                'last_page' => $lastPage
            ];
            
        } catch (PDOException $e) {
            error_log("Database Error in searchPaginate: " . $e->getMessage());
            throw new Exception("Failed to fetch records: " . $e->getMessage());
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

    public function validate($data, $id = null) {
        $errors = [];

        // // Validate required fields
        // if (empty($data['kode'])) {
        //     $errors[] = 'Nomor RM harus diisi';
        // }
        
        if (empty($data['nama'])) {
            $errors[] = 'Nama harus diisi';
        }
        
        if (empty($data['jns_klm'])) {
            $errors[] = 'Jenis kelamin harus dipilih';
        }

        // // Check for duplicate no_rm
        // if (!empty($data['kode'])) {
        //     $sql = "SELECT id FROM {$this->table} WHERE kode = :kode";
        //     if ($id) {
        //         $sql .= " AND id != :id";
        //     }
            
        //     $stmt = $this->conn->prepare($sql);
        //     $stmt->bindValue(':kode', $data['kode']);
        //     if ($id) {
        //         $stmt->bindValue(':id', $id);
        //     }
        //     $stmt->execute();
            
        //     if ($stmt->fetch()) {
        //         $errors[] = 'Nomor RM sudah digunakan';
        //     }
        // }

        return $errors;
    }

    public function create($data) {
        try {
            // Begin transaction
            $this->conn->beginTransaction();

            $columns = implode(', ', array_keys($data));
            $values = ':' . implode(', :', array_keys($data));
            
            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
            $stmt = $this->conn->prepare($sql);
            
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            
            $result = $stmt->execute();
            
            // Commit transaction
            $this->conn->commit();
            
            return $result;
            
        } catch (PDOException $e) {
            // Rollback transaction on error
            $this->conn->rollBack();
            error_log("Database Error in create: " . $e->getMessage());
            throw new Exception("Gagal menyimpan data");
        }
    }
} 