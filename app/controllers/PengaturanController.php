<?php
class PengaturanController extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->loadModel('Pengaturan');
    }
    
    public function index() {
        try {
            $data = $this->model->getSettings();
            return $this->view('pengaturan/index', [
                'title' => 'Pengaturan Aplikasi',
                'data' => $data
            ]);
        } catch (Exception $e) {
            Notification::error('Gagal memuat pengaturan');
            return $this->redirect('');
        }
    }
    
    public function update() {
        try {
            // Get form data
            $data = [
                'judul' => $this->input('judul'),
                'judul_app' => $this->input('judul_app'),
                'alamat' => $this->input('alamat'),
                'deskripsi' => $this->input('deskripsi'),
                'kota' => $this->input('kota'),
                'url' => $this->input('url'),
                'theme' => $this->input('theme'),
                'pagination_limit' => $this->input('pagination_limit')
            ];
            
            // Handle logo upload
            if (!empty($_FILES['logo']['name'])) {
                $logoPath = $this->handleFileUpload('logo', ['jpg', 'jpeg', 'png', 'gif']);
                if ($logoPath) {
                    $data['logo'] = $logoPath;
                    
                    // Delete old logo if exists
                    $oldSettings = $this->model->getSettings();
                    if (!empty($oldSettings->logo)) {
                        $this->deleteOldFile($oldSettings->logo);
                    }
                }
            }
            
            // Handle favicon upload
            if (!empty($_FILES['favicon']['name'])) {
                $faviconPath = $this->handleFileUpload('favicon', ['ico', 'png']);
                if ($faviconPath) {
                    $data['favicon'] = $faviconPath;
                    
                    // Delete old favicon if exists
                    $oldSettings = $this->model->getSettings();
                    if (!empty($oldSettings->favicon)) {
                        $this->deleteOldFile($oldSettings->favicon);
                    }
                }
            }
            
            if ($this->model->updateSettings($data)) {
                Notification::success('Pengaturan berhasil diupdate');
            } else {
                throw new Exception('Gagal mengupdate pengaturan');
            }
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
        }
        
        return $this->redirect('pengaturan');
    }
    
    protected function handleFileUpload($field, $allowedExtensions = []) {
        try {
            if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
                return false;
            }
            
            $file = $_FILES[$field];
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            
            // Validate extension
            if (!in_array($extension, $allowedExtensions)) {
                throw new Exception("Invalid file type. Allowed: " . implode(', ', $allowedExtensions));
            }
            
            // Generate unique filename
            $filename = $field . '_' . time() . '.' . $extension;
            $uploadDir = PUBLIC_PATH . '/file/app/';
            
            // Create directory if not exists
            if (!file_exists($uploadDir)) {
                if (!mkdir($uploadDir, 0755, true)) {
                    throw new Exception("Failed to create upload directory");
                }
            }
            
            $targetPath = $uploadDir . $filename;
            
            // Move uploaded file
            if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                throw new Exception("Failed to move uploaded file");
            }
            
            return 'file/app/' . $filename;
            
        } catch (Exception $e) {
            error_log("File upload error: " . $e->getMessage());
            throw $e;
        }
    }
    
    protected function deleteOldFile($path) {
        $fullPath = PUBLIC_PATH . '/' . $path;
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}
?> 