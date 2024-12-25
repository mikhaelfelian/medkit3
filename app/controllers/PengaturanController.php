<?php
class PengaturanController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = new PengaturanModel();
    }
    
    public function index() {
        try {
            $data = [
                'title' => 'Pengaturan Aplikasi',
                'data' => $this->model->getSettings()
            ];
            
            return $this->view('pengaturan/index', $data);
            
        } catch (Exception $e) {
            error_log("Error in PengaturanController::index - " . $e->getMessage());
            Notification::error('Gagal memuat pengaturan');
            return $this->redirect('dashboard');
        }
    }

    public function update() {
        try {
            $data = $this->input();
            
            // Handle file uploads if present
            if (!empty($_FILES['logo']['name'])) {
                $data['logo'] = $this->model->uploadFile($_FILES['logo'], 'logo');
            }
            
            if (!empty($_FILES['favicon']['name'])) {
                $data['favicon'] = $this->model->uploadFile($_FILES['favicon'], 'favicon');
            }
            
            if ($this->model->updateSettings($data)) {
                Notification::success('Pengaturan berhasil diupdate');
                return $this->redirect('pengaturan');
            }
            
            throw new Exception("Failed to update settings");
            
        } catch (Exception $e) {
            error_log("Error in PengaturanController::update - " . $e->getMessage());
            Notification::error('Gagal mengupdate pengaturan');
            return $this->redirect('pengaturan');
        }
    }
}
?> 