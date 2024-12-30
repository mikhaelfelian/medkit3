<?php
class GelarController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Gelar');
    }
    
    public function index() {
        try {
            $page = $this->input->get('page', 1);
            $perPage = 10;
            $search = $this->input->get('search');
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            
            return $this->view('master/gelar/index', [
                'title' => 'Data Gelar',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('gelar');
        }
    }
    
    public function create() {
        return $this->view('master/gelar/create', [
            'title' => 'Tambah Gelar'
        ]);
    }
    
    public function store() {
        try {
            $data = [
                'gelar' => $this->input->post('gelar'),
                'keterangan' => $this->input->post('keterangan')
            ];
            
            // Validate input
            $errors = $this->model->validate($data);
            if (!empty($errors)) {
                return $this->view('master/gelar/create', [
                    'title' => 'Tambah Gelar',
                    'errors' => $errors
                ]);
            }
            
            // Save data
            $this->model->create($data);
            
            Notification::success('Data gelar berhasil ditambahkan');
            return $this->redirect('gelar');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('gelar/create');
        }
    }
    
    public function edit($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception('Data gelar tidak ditemukan');
            }
            
            return $this->view('master/gelar/edit', [
                'title' => 'Edit Gelar',
                'data' => $data
            ]);
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('gelar');
        }
    }
    
    public function update($id) {
        try {
            $data = [
                'gelar' => $this->input->post('gelar'),
                'keterangan' => $this->input->post('keterangan')
            ];
            
            // Validate input
            $errors = $this->model->validate($data, $id);
            if (!empty($errors)) {
                return $this->view('master/gelar/edit', [
                    'title' => 'Edit Gelar',
                    'data' => (object)array_merge(['id' => $id], $data),
                    'errors' => $errors
                ]);
            }
            
            // Update data
            $this->model->update($id, $data);
            
            Notification::success('Data gelar berhasil diupdate');
            return $this->redirect('gelar');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('gelar/edit/' . $id);
        }
    }
    
    public function delete($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception('Data gelar tidak ditemukan');
            }
            
            $this->model->delete($id);
            
            Notification::success('Data gelar berhasil dihapus');
            return $this->redirect('gelar');
            
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in GelarController::delete", [
                'exception' => $e,
                'id' => $id
            ]);
            throw new Exception("Failed to delete gelar data: " . $e->getMessage());
        }
    }
} 