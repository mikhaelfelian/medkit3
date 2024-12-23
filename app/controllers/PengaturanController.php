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
                $data['logo'] = $this->uploadFile('logo', 'images/');
            }
            
            // Handle favicon upload
            if (!empty($_FILES['favicon']['name'])) {
                $data['favicon'] = $this->uploadFile('favicon', 'images/');
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
    
    protected function uploadFile($field, $path) {
        if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        
        $file = $_FILES[$field];
        $filename = time() . '_' . basename($file['name']);
        $upload_path = PUBLIC_PATH . '/assets/' . $path;
        
        // Create directory if it doesn't exist
        if (!is_dir($upload_path)) {
            if (!mkdir($upload_path, 0755, true)) {
                throw new Exception("Failed to create upload directory");
            }
        }
        
        $filepath = $upload_path . $filename;
        
        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            throw new Exception("Failed to move uploaded file");
        }
        
        return $path . $filename;
    }
}
?> 