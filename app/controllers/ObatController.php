<?php
class ObatController extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Obat');
    }
    
    public function index() {
        try {
            return $this->view('obat/index', [
                'title' => 'Data Obat',
                'data' => $this->model->get()
            ]);
        } catch (Exception $e) {
            Notification::error('Gagal memuat data obat');
            return $this->redirect('');
        }
    }
} 