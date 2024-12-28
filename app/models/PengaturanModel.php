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
     * @param mixed $id ID or data array
     * @param array|null $data Data to update (optional if $id is array)
     */
    public function update($id, $data = null) {
        try {
            // Handle case where only data is passed
            if (is_array($id) && $data === null) {
                $data = $id;
                $id = null;
            }

            // Ensure data is an array
            if (!is_array($data)) {
                throw new Exception("Update data must be an array");
            }

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
            if (file_exists($fullPath) && is_writable($fullPath)) {
                unlink($fullPath);
            } else {
                error_log("Cannot delete file or file not found: " . $fullPath);
            }
        }
    }

    public function uploadFile($file, $type = 'logo') {
        try {
            $uploadDir = PUBLIC_PATH . '/file/app/';
            
            // Create directory structure if it doesn't exist
            if (!file_exists($uploadDir)) {
                if (!mkdir($uploadDir, 0755, true)) {
                    error_log("Failed to create directory: " . $uploadDir);
                    throw new Exception("Failed to create upload directory");
                }
                
                // Set proper permissions on created directory
                chmod($uploadDir, 0755);
            }

            // Validate directory is writable
            if (!is_writable($uploadDir)) {
                error_log("Upload directory not writable: " . $uploadDir);
                throw new Exception("Upload directory not writable");
            }

            // Generate unique filename with type prefix
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $fileName = $type . '_' . uniqid() . '.' . $extension;
            $uploadFile = $uploadDir . $fileName;

            // Move uploaded file
            if (!move_uploaded_file($file['tmp_name'], $uploadFile)) {
                error_log("Failed to move uploaded file to: " . $uploadFile);
                throw new Exception("Failed to save uploaded file");
            }

            // Set proper permissions on uploaded file
            chmod($uploadFile, 0644);

            return 'file/app/' . $fileName;

        } catch (Exception $e) {
            error_log("Error uploading file: " . $e->getMessage());
            return false;
        }
    }
} 