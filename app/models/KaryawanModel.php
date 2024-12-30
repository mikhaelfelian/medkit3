<?php
class KaryawanModel extends BaseModel {
    protected $table = 'tbl_m_karyawans';
    protected $primaryKey = 'id';
    protected $timestamps = true;
    
    protected $fillable = [
        'id_user',
        'id_poli',
        'id_user_group',
        'kode',
        'nik',
        'sip',
        'str',
        'no_ijin',
        'tgl_lahir',
        'tmp_lahir',
        'nama_dpn',
        'nama',
        'nama_blk',
        'nama_pgl',
        'alamat',
        'alamat_domisili',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'kota',
        'jns_klm',
        'jabatan',
        'no_hp',
        'file_foto',
        'status',
        'status_aps'
    ];

    public function searchPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            
            // Base query with JOIN to poli table
            $sql = "SELECT k.*, p.poli as nama_poli 
                   FROM {$this->table} k 
                   LEFT JOIN tbl_m_polis p ON k.id_poli = p.id 
                   WHERE 1=1";
            $countSql = "SELECT COUNT(*) as total FROM {$this->table} k WHERE 1=1";
            
            // Add search condition if search is not empty
            if (!empty($search)) {
                $searchCondition = " AND (k.kode LIKE :search OR k.nama LIKE :search OR k.nik LIKE :search)";
                $sql .= $searchCondition;
                $countSql .= $searchCondition;
            }
            
            // Add order by
            $sql .= " ORDER BY k.created_at DESC";
            
            // Add limit
            $sql .= " LIMIT :offset, :perPage";
            
            // Get total records
            $countStmt = $this->conn->prepare($countSql);
            if (!empty($search)) {
                $countStmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
            }
            $countStmt->execute();
            $total = $countStmt->fetch(PDO::FETCH_OBJ)->total;
            
            // Execute main query
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

    public function getStatusLabel($status) {
        $labels = [
            1 => 'Perawat',
            2 => 'Dokter',
            3 => 'Kasir',
            4 => 'Analis',
            5 => 'Radiografer',
            6 => 'Farmasi'
        ];
        return $labels[$status] ?? '-';
    }

    public function generateKode() {
        try {
            // Get current year and month
            $yearMonth = date('ym');
            
            // Get latest code from database for current year/month
            $sql = "SELECT kode FROM {$this->table} 
                    WHERE kode LIKE 'KR{$yearMonth}%' 
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

            // Generate new code with format KRYYMMxxxx
            return 'KR' . $yearMonth . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        } catch (PDOException $e) {
            error_log("Database Error in generateKode: " . $e->getMessage());
            throw new Exception("Failed to generate kode");
        }
    }

    public function find($id) {
        try {
            $sql = "SELECT k.*, p.poli as nama_poli 
                    FROM {$this->table} k 
                    LEFT JOIN tbl_m_polis p ON k.id_poli = p.id 
                    WHERE k.id = :id";
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
            $data['created_at'] = date('Y-m-d H:i:s');
            
            $fields = [];
            $values = [];
            $placeholders = [];
            
            foreach ($data as $key => $value) {
                if (in_array($key, $this->fillable) || $key === 'created_at') {
                    $fields[] = $key;
                    $placeholders[] = ":{$key}";
                    $values[":{$key}"] = $value;
                }
            }
            
            $sql = "INSERT INTO {$this->table} (" . implode(', ', $fields) . ") 
                    VALUES (" . implode(', ', $placeholders) . ")";
            $stmt = $this->conn->prepare($sql);
            
            foreach ($values as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error in create: " . $e->getMessage());
            throw new Exception("Failed to create record");
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

    public function getPoliList() {
        try {
            $sql = "SELECT id, poli FROM tbl_m_polis WHERE status = '1' ORDER BY poli ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database Error in getPoliList: " . $e->getMessage());
            return [];
        }
    }
} 