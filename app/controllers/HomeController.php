<?php
class HomeController extends BaseController {
    protected $pengaturanModel;
    
    public function __construct() {
        parent::__construct();
        $this->pengaturanModel = $this->loadModel('Pengaturan');
    }
    
    public function index() {
        try {
            $data = [
                'title' => 'Dashboard',
                'settings' => $this->pengaturanModel->getSettings()
            ];
            
            return $this->view('dashboard/index', $data);
            
        } catch (Exception $e) {
            error_log("Dashboard Error: " . $e->getMessage());
            return $this->view('dashboard/index', [
                'title' => 'Dashboard'
            ]);
        }
    }
} 