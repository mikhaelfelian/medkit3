<?php
class SatuanController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Satuan');
    }
    
    public function index() {
        try {
            $page = (int)$this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = 10;
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            
            return $this->view('satuan/index', [
                'title' => 'Data Satuan',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('satuan');
        }
    }
} 