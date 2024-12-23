<?php
class HomeController extends BaseController {
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        try {
            // Get total patients count if needed
            $totalPatients = 0;
            if (class_exists('PasienModel')) {
                $pasienModel = new PasienModel($this->conn);
                $totalPatients = $pasienModel->count();
            }
            
            return $this->view('dashboard/index', [
                'title' => 'Dashboard',
                'totalPatients' => $totalPatients
            ]);
        } catch (Exception $e) {
            error_log("Dashboard Error: " . $e->getMessage());
            return $this->view('dashboard/index', [
                'title' => 'Dashboard',
                'totalPatients' => 0
            ]);
        }
    }
} 