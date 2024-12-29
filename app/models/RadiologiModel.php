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
            $conditions = ["i.status_hps = '0' AND i.status_item = '4'"]; // Only show radiologi items
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
            
            // Get paginated records
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
                'current_page' => $page
            ];
            
        } catch (PDOException $e) {
            error_log("Database Error in searchPaginate: " . $e->getMessage());
            throw new Exception("Failed to fetch radiologi data");
        }
    }

    public function countDeleted() {
        try {
            $sql = "SELECT COUNT(*) as total FROM {$this->table} 
                    WHERE status_hps = '1' AND status_item = '4'";
            $stmt = $this->conn->query($sql);
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
} 