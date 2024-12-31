<?php
class StockItemsModel extends BaseModel {
    protected $table = 'tbl_m_items';
    protected $primaryKey = 'id';
    
    public function searchPaginate($search = '', $page = 1, $perPage = 10) {
        try {
            $offset = ($page - 1) * $perPage;
            
            // Base query to get items with stock status
            $sql = "SELECT i.*, 
                    COALESCE((
                        SELECT SUM(s.jml) 
                        FROM tbl_m_item_stoks s 
                        WHERE s.id_item = i.id
                    ), 0) as total_stock
                    FROM {$this->table} i 
                    WHERE i.status_stok = '1'";
            
            // Add search condition if search term provided
            if (!empty($search)) {
                $sql .= " AND (i.kode LIKE :search 
                         OR i.item LIKE :search 
                         OR i.item_alias LIKE :search)";
            }
            
            // Get total count
            $countSql = str_replace("i.*, COALESCE", "COUNT(*) as total", $sql);
            $stmt = $this->conn->prepare($countSql);
            
            if (!empty($search)) {
                $stmt->bindValue(':search', "%{$search}%");
            }
            
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_OBJ)->total;
            
            // Add pagination to main query
            $sql .= " ORDER BY i.item ASC LIMIT :limit OFFSET :offset";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            
            if (!empty($search)) {
                $stmt->bindValue(':search', "%{$search}%");
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
            throw new Exception("Failed to fetch stock items");
        }
    }
} 