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
        'pagination_limit',
        'logo',
        'favicon'
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
    
    protected function uploadFile($file, $type) {
        try {
            $uploadDir = ROOT_PATH . '/public/file/app/';
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/x-icon'];
            
            if (!in_array($file['type'], $allowedTypes)) {
                throw new Exception('Invalid file type: ' . $file['type']);
            }

            // Create directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0755, true)) {
                    throw new Exception("Failed to create upload directory");
                }
            }

            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = $type . '_' . time() . '.' . $extension;
            $targetPath = $uploadDir . $filename;

            if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                throw new Exception('Failed to move uploaded file');
            }

            return 'file/app/' . $filename;
            
        } catch (Exception $e) {
            error_log("File upload error: " . $e->getMessage());
            throw $e;
        }
    }
} 