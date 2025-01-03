<?php
class ItemReffModel extends BaseModel {
    protected $table = 'tbl_m_item_reffs';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id_item',
        'id_item_reff',
        'id_satuan',
        'item',
        'harga',
        'jml',
        'jml_satuan',
        'satuan',
        'status',
        'created_at',
        'updated_at'
    ];

    public function getByItemId($itemId) {
        try {
            $sql = "SELECT r.*, i.kode as kode_reff, i.item as nama_item_reff 
                    FROM {$this->table} r
                    LEFT JOIN tbl_m_items i ON r.id_item_reff = i.id
                    WHERE r.id_item = :id_item
                    AND r.status = '1'
                    ORDER BY r.created_at DESC";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id_item', $itemId);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_OBJ);
            
        } catch (PDOException $e) {
            error_log("Database Error in getByItemId: " . $e->getMessage());
            throw new Exception("Failed to fetch item references");
        }
    }

    public function create($data) {
        try {
            // Set timestamps
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            
            return parent::create($data);
            
        } catch (Exception $e) {
            error_log("Error in ItemReffModel::create - " . $e->getMessage());
            throw new Exception("Failed to create item reference");
        }
    }

    public function update($id, $data) {
        try {
            // Set updated timestamp
            $data['updated_at'] = date('Y-m-d H:i:s');
            
            return parent::update($id, $data);
            
        } catch (Exception $e) {
            error_log("Error in ItemReffModel::update - " . $e->getMessage());
            throw new Exception("Failed to update item reference");
        }
    }

    public function deleteReff($id) {
        try {
            $sql = "UPDATE {$this->table} 
                    SET status = '0', 
                        updated_at = :updated_at 
                    WHERE id = :id";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'));
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Database Error in deleteReff: " . $e->getMessage());
            throw new Exception("Failed to delete reference");
        }
    }
} 