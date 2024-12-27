<?php
class PengaturanModel extends BaseModel {
    protected $table = 'tbl_pengaturans';
    protected $primaryKey = 'id';
    protected $timestamps = true;
    
    protected $fillable = [
        'judul_app',
        'logo',
        'favicon',
        'footer_app'
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

    public function validateData($data, $id = null) {
        $errors = [];
        
        // Validate judul_app
        if (empty($data['judul_app'])) {
            $errors['judul_app'] = 'Judul aplikasi is required';
        }
        
        // Validate logo file if uploaded
        if (!empty($_FILES['logo']['name'])) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['logo']['type'], $allowedTypes)) {
                $errors['logo'] = 'Logo must be an image (JPG, PNG, or GIF)';
            }
        }
        
        // Validate favicon file if uploaded
        if (!empty($_FILES['favicon']['name'])) {
            $allowedTypes = ['image/x-icon', 'image/png'];
            if (!in_array($_FILES['favicon']['type'], $allowedTypes)) {
                $errors['favicon'] = 'Favicon must be an ICO or PNG file';
            }
        }
        
        return $errors;
    }

    public function uploadFile($file, $type = 'logo') {
        try {
            if (empty($file['name'])) {
                return null;
            }

            $uploadDir = 'uploads/' . $type . '/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = time() . '_' . basename($file['name']);
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
        if (!empty($path) && file_exists($path)) {
            unlink($path);
        }
    }
} 