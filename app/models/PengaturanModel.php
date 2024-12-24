<?php
class PengaturanModel extends BaseModel {
    protected $table = 'tbl_pengaturan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'judul',
        'judul_app',
        'alamat',
        'deskripsi',
        'kota',
        'url',
        'theme',
        'pagination_limit'
    ];
    
    public function getSettings() {
        try {
            $sql = "SELECT * FROM {$this->table} LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            
            if (!$result) {
                // Create default settings if none exist
                $id = $this->create([
                    'judul' => 'WEB_TITLE',
                    'judul_app' => 'APP_TITLE'
                ]);
                $result = $this->find($id);
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Database Error in getSettings: " . $e->getMessage());
            throw new Exception("Failed to get settings");
        }
    }
    
    public function updateSettings($data) {
        try {
            $settings = $this->getSettings();
            if (!$settings) {
                return $this->create($data);
            }
            
            return $this->update($settings->id, $data);
            
        } catch (Exception $e) {
            error_log("Failed to update settings: " . $e->getMessage());
            throw $e;
        }
    }
} 