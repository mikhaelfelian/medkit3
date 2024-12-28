<?php
class PengaturanModel extends BaseModel {
    protected $table = 'tbl_pengaturans';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'judul_app',
        'logo',
        'favicon'
    ];

    public function getSettings() {
        try {
            $sql = "SELECT * FROM {$this->table} ORDER BY id DESC LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database Error in getSettings: " . $e->getMessage());
            throw new Exception("Failed to fetch settings");
        }
    }

    public function update($id, $data) {
        try {
            $settings = $this->getSettings();
            
            // Handle file uploads
            if (!empty($_FILES['logo']['name'])) {
                if ($settings && !empty($settings->logo)) {
                    $this->deleteOldFile($settings->logo);
                }
                $data['logo'] = $this->uploadFile($_FILES['logo'], 'logo');
            }
            
            if (!empty($_FILES['favicon']['name'])) {
                if ($settings && !empty($settings->favicon)) {
                    $this->deleteOldFile($settings->favicon);
                }
                $data['favicon'] = $this->uploadFile($_FILES['favicon'], 'favicon');
            }

            // Update database
            $fields = array_intersect_key($data, array_flip($this->fillable));
            
            if (empty($fields)) {
                return true;
            }
            
            $set = implode(', ', array_map(function($field) {
                return "$field = :$field";
            }, array_keys($fields)));
            
            $sql = "UPDATE {$this->table} SET $set WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindValue(':id', $id);
            foreach ($fields as $key => $value) {
                $stmt->bindValue(":{$key}", $value);
            }
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Database Error in update: " . $e->getMessage());
            throw new Exception("Failed to update settings");
        }
    }

    public function validateData($data) {
        $errors = [];
        
        if (empty($data['judul_app'])) {
            $errors['judul_app'] = 'Judul aplikasi harus diisi';
        }
        
        return $errors;
    }

    public function uploadFile($file, $type = 'logo') {
        try {
            if (empty($file['name'])) {
                return null;
            }

            $uploadDir = 'public/file/app/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName = $type . '_' . time() . '.' . $extension;
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                return $targetPath;
            }

            throw new Exception("Failed to upload file");
            
        } catch (Exception $e) {
            error_log("File Upload Error: " . $e->getMessage());
            throw new Exception("Failed to upload file: " . $e->getMessage());
        }
    }

    public function deleteOldFile($path) {
        if (!empty($path) && file_exists($path) && strpos($path, 'public/file/app/') === 0) {
            unlink($path);
        }
    }
} 