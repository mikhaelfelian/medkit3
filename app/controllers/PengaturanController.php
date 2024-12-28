<?php
class PengaturanController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Pengaturan');
    }
    
    public function index() {
        try {
            return $this->view('pengaturan/index', [
                'title' => 'Pengaturan Aplikasi',
                'data' => $this->model->getSettings(),
                'csrf_token' => $this->security->getCSRFToken()
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('');
        }
    }

    public function update() {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception('Invalid security token');
            }

            $data = [
                'judul_app' => $this->input->post('judul_app')
            ];

            // Validate input data
            $errors = $this->model->validateData($data);
            if (!empty($errors)) {
                throw new Exception(implode(', ', $errors));
            }

            // Handle logo upload
            if (!empty($_FILES['logo']['name'])) {
                $oldSettings = $this->model->getSettings();
                if ($oldSettings && !empty($oldSettings->logo)) {
                    $this->model->deleteOldFile($oldSettings->logo);
                }
                $data['logo'] = $this->model->uploadFile($_FILES['logo'], 'logo');
            }

            // Handle favicon upload
            if (!empty($_FILES['favicon']['name'])) {
                $oldSettings = $this->model->getSettings();
                if ($oldSettings && !empty($oldSettings->favicon)) {
                    $this->model->deleteOldFile($oldSettings->favicon);
                }
                $data['favicon'] = $this->model->uploadFile($_FILES['favicon'], 'favicon');
            }

            // Update settings
            if (!$this->model->update($data)) {
                throw new Exception('Gagal mengupdate pengaturan');
            }

            Notification::success('Pengaturan berhasil diupdate');
            return $this->redirect('pengaturan');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('pengaturan');
        }
    }
}
?> 