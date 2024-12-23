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
            $data = [
                'judul_app' => $this->input('judul_app'),
                'deskripsi' => $this->input('deskripsi')
            ];
            
            // Log the initial data
            error_log("Initial update data: " . json_encode($data));
            
            // Handle logo upload
            if (!empty($_FILES['logo']['name'])) {
                $logo = $this->uploadFile('logo', 'images/');
                if ($logo) {
                    $data['logo'] = $logo;
                    error_log("Logo uploaded: " . $logo);
                }
            }
            
            // Handle favicon upload
            if (!empty($_FILES['favicon']['name'])) {
                $favicon = $this->uploadFile('favicon', 'images/');
                if ($favicon) {
                    $data['favicon'] = $favicon;
                    error_log("Favicon uploaded: " . $favicon);
                }
            }
            
            // Log final data before update
            error_log("Final update data: " . json_encode($data));
            
            $result = $this->model->updateSettings($data);
            
            if ($result) {
                Notification::success('Pengaturan berhasil disimpan');
            } else {
                throw new Exception("Update returned false");
            }
            
            return $this->redirect('pengaturan');
            
        } catch (Exception $e) {
            error_log("Settings update error: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            Notification::error(DEBUG_MODE ? $e->getMessage() : 'Gagal menyimpan pengaturan');
            return $this->redirect('pengaturan');
        }
    }

    protected function uploadFile($field, $path) {
        if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        
        $file = $_FILES[$field];
        $filename = time() . '_' . basename($file['name']);
        $upload_path = ROOT_PATH . '/public/assets/' . $path;
        
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