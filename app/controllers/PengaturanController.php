<?php
class PengaturanController extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->loadModel('PengaturanModel');
    }
    
    public function index() {
        $pengaturan = $this->model->first();
        return $this->view('pengaturan/index', [
            'title' => 'Pengaturan Aplikasi',
            'pengaturan' => $pengaturan
        ]);
    }
    
    public function update() {
        $data = [
            'judul_app' => $this->input('judul_app'),
        ];
        
        // Handle logo upload
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === 0) {
            $logo = $this->uploadFile('logo', 'uploads/settings/');
            if ($logo) {
                $data['logo'] = $logo;
            }
        }
        
        // Handle favicon upload
        if (isset($_FILES['favicon']) && $_FILES['favicon']['error'] === 0) {
            $favicon = $this->uploadFile('favicon', 'uploads/settings/');
            if ($favicon) {
                $data['favicon'] = $favicon;
            }
        }
        
        if ($this->model->update(1, $data)) {
            Notification::success('Pengaturan berhasil diperbarui');
        } else {
            Notification::error('Gagal memperbarui pengaturan');
        }
        
        return $this->redirect('pengaturan');
    }

    protected function uploadFile($field, $path) {
        if (!isset($_FILES[$field])) return false;
        
        $file = $_FILES[$field];
        $filename = time() . '_' . $file['name'];
        $upload_path = ROOT_PATH . '/public/' . $path;
        
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }
        
        if (move_uploaded_file($file['tmp_name'], $upload_path . $filename)) {
            return $path . $filename;
        }
        
        return false;
    }
}
?> 