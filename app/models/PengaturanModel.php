<?php
class PengaturanModel extends BaseModel {
    protected $table = 'tbl_pengaturans';
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
        'favicon',
        'logo',
        'updated_at'
    ];

    public function get() {
        try {
            $sql = "SELECT * FROM {$this->table} LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database Error in get: " . $e->getMessage());
            throw new Exception("Failed to fetch settings");
        }
    }

    public function getSettings() {
        return $this->get();
    }

    /**
     * Update settings
     * @param int|null $id ID is optional, will use first record if not provided
     * @param array $data Data to update
     */
    public function update($id = null, $data = null) {
        try {
            $fields = array_intersect_key($data, array_flip($this->fillable));
            $fields['updated_at'] = date('Y-m-d H:i:s');
            
            $set = implode(', ', array_map(function($field) {
                return "$field = :$field";
            }, array_keys($fields)));
            
            // If no ID provided, get the first record's ID
            if (!$id) {
                $current = $this->get();
                if (!$current) {
                    throw new Exception("Settings record not found");
                }
                $id = $current->id;
            }
            
            $sql = "UPDATE {$this->table} SET $set WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindValue(':id', $id);
            foreach ($fields as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Database Error in update: " . $e->getMessage());
            throw new Exception("Failed to update settings");
        }
    }

    public function deleteFile($path) {
        if (!empty($path)) {
            $fullPath = PUBLIC_PATH . '/file/app/' . basename($path);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }

    public function uploadFile($file, $type = 'logo') {
        try {
            $uploadDir = PUBLIC_PATH . '/file/app/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Generate unique filename with type prefix
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName = $type . '_' . uniqid() . '.' . $extension;
            $uploadFile = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                return 'file/app/' . $fileName;
            }

            return false;
        } catch (Exception $e) {
            error_log("Error uploading file: " . $e->getMessage());
            return false;
        }
    }
} 