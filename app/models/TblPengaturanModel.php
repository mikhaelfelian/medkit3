<?php
class TblPengaturanModel extends BaseModel {
    protected $table = 'tbl_pengaturan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'judul',
        'judul_app',
        'alamat',
        'kota',
        'url',
        'theme',
        'pagination_limit',
        'favicon',
        'logo'
    ];

    public function __construct($conn) {
        parent::__construct($conn, $this->table);
    }

    /**
     * Get active settings
     */
    public function getSettings() {
        $sql = "SELECT * FROM {$this->table} LIMIT 1";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    /**
     * Update settings with file upload handling
     */
    public function updateSettings($data, $files = []) {
        try {
            // Create upload directory if it doesn't exist
            $uploadDir = ROOT_PATH . '/public/assets/custom/img/';
            if (!file_exists($uploadDir)) {
                if (!mkdir($uploadDir, 0777, true)) {
                    throw new Exception('Failed to create upload directory');
                }
            }

            // Handle logo upload
            if (isset($files['logo']) && $files['logo']['error'] === 0) {
                $logoPath = $this->uploadFile($files['logo'], 'logo');
                if ($logoPath) {
                    $data['logo'] = $logoPath;
                    
                    // Delete old logo if exists
                    $current = $this->getSettings();
                    if ($current && !empty($current['logo'])) {
                        $oldFile = $uploadDir . $current['logo'];
                        if (file_exists($oldFile)) {
                            unlink($oldFile);
                        }
                    }
                }
            }

            // Handle favicon upload
            if (isset($files['favicon']) && $files['favicon']['error'] === 0) {
                $faviconPath = $this->uploadFile($files['favicon'], 'favicon');
                if ($faviconPath) {
                    $data['favicon'] = $faviconPath;
                    
                    // Delete old favicon if exists
                    $current = $this->getSettings();
                    if ($current && !empty($current['favicon'])) {
                        $oldFile = $uploadDir . $current['favicon'];
                        if (file_exists($oldFile)) {
                            unlink($oldFile);
                        }
                    }
                }
            }

            // Get current settings
            $current = $this->getSettings();
            
            if ($current) {
                // Update existing settings
                $success = $this->update($current['id'], $data);
                if (!$success) {
                    throw new Exception("Failed to update settings: " . mysqli_error($this->conn));
                }
                return true;
            } else {
                // Create new settings
                $success = $this->create($data);
                if (!$success) {
                    throw new Exception("Failed to create settings: " . mysqli_error($this->conn));
                }
                return true;
            }

        } catch (Exception $e) {
            if (DEBUG_MODE) {
                error_log("Settings update error: " . $e->getMessage());
                throw $e;
            }
            return false;
        }
    }

    /**
     * Handle file upload
     */
    protected function uploadFile($file, $type) {
        try {
            $uploadDir = ROOT_PATH . '/public/assets/custom/img/';
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/x-icon'];
            
            if (!in_array($file['type'], $allowedTypes)) {
                throw new Exception('Invalid file type: ' . $file['type']);
            }

            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = $type . '_' . time() . '.' . $extension;
            $targetPath = $uploadDir . $filename;

            if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                throw new Exception('Failed to move uploaded file');
            }

            return $filename;
            
        } catch (Exception $e) {
            error_log("File upload error: " . $e->getMessage());
            throw $e;
        }
    }
}
?> 