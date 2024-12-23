<?php
class DashboardController extends BaseController {
    public function index() {
        return $this->view('dashboard/index', [
            'title' => 'Dashboard'
        ]);
    }
} 