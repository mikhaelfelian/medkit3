<?php
class PengaturanController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Pengaturan');
    }
    
    public function index() {
        try {
            $data = $this->model->get();
            
            return $this->view('pengaturan/index', [
                'title' => 'Pengaturan',
                'data' => $data,
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
                'judul' => $this->input->post('judul'),
                'judul_app' => $this->input->post('judul_app'),
                'alamat' => $this->input->post('alamat'),
                'deskripsi' => $this->input->post('deskripsi'),
                'kota' => $this->input->post('kota'),
                'url' => $this->input->post('url'),
                'theme' => $this->input->post('theme'),
                'pagination_limit' => $this->input->post('pagination_limit')
            ];

            // Handle logo upload
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                $current = $this->model->get();
                if ($current && $current->logo) {
                    $this->model->deleteFile($current->logo);
                }
                $logo = $this->model->uploadFile($_FILES['logo'], 'logo');
                if ($logo) {
                    $data['logo'] = 'public/'.$logo;
                }
            }

            // Handle favicon upload
            if (isset($_FILES['favicon']) && $_FILES['favicon']['error'] === UPLOAD_ERR_OK) {
                $current = $this->model->get();
                if ($current && $current->favicon) {
                    $this->model->deleteFile($current->favicon);
                }
                $favicon = $this->model->uploadFile($_FILES['favicon'], 'favicon');
                if ($favicon) {
                    $data['favicon'] = 'public/'.$favicon;
                }
            }

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