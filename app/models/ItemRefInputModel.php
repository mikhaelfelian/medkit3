<?php
class ItemRefInputModel extends BaseModel {
    protected $table = 'tbl_m_item_ref_inputs';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id_item',
        'id_user',
        'created_at',
        'updated_at',
        'item_name',
        'item_value',
        'item_value_l1',
        'item_value_l2',
        'item_value_p1',
        'item_value_p2',
        'item_satuan'
    ];

    public function getByItemId($itemId) {
        try {
            $sql = "SELECT r.*, i.kode as kode_item, i.item as nama_item 
                    FROM {$this->table} r
                    LEFT JOIN tbl_m_items i ON r.id_item = i.id
                    WHERE r.id_item = :id_item
                    ORDER BY r.created_at DESC";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id_item', $itemId);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_OBJ);
            
        } catch (PDOException $e) {
            error_log("Database Error in getByItemId: " . $e->getMessage());
            throw new Exception("Failed to fetch item reference inputs");
        }
    }

    public function create($data) {
        try {
            // Set timestamps
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            
            return parent::create($data);
            
        } catch (Exception $e) {
            error_log("Error in ItemRefInputModel::create - " . $e->getMessage());
            throw new Exception("Failed to create item reference input");
        }
    }

    public function update($id, $data) {
        try {
            // Set updated timestamp
            $data['updated_at'] = date('Y-m-d H:i:s');
            
            return parent::update($id, $data);
            
        } catch (Exception $e) {
            error_log("Error in ItemRefInputModel::update - " . $e->getMessage());
            throw new Exception("Failed to update item reference input");
        }
    }

    public function delete($id) {
        try {
            return parent::delete($id);
            
        } catch (PDOException $e) {
            error_log("Database Error in delete: " . $e->getMessage());
            throw new Exception("Failed to delete reference input");
        }
    }
} 