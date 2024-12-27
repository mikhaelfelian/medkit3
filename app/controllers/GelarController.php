<?php
class GelarController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Gelar');
    }
    
    public function index() {
        try {
            $page = (int)$this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = (int)$this->input->get('per_page', 10);
            
            if ($page < 1) $page = 1;
            if ($perPage < 1) $perPage = 10;
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            
            return $this->view('gelar/index', [
                'title' => 'Data Gelar',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
            
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in GelarController::index", [
                'exception' => $e
            ]);
            throw new Exception("Failed to load gelar data: " . $e->getMessage());
        }
    }

    public function create() {
        try {
            return $this->view('gelar/create', [
                'title' => 'Tambah Data Gelar'
            ]);
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in GelarController::create", [
                'exception' => $e
            ]);
            throw new Exception("Failed to load create form: " . $e->getMessage());
        }
    }

    public function store() {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception("Invalid security token");
            }

            $data = [
                'gelar' => $this->input->post('gelar'),
                'keterangan' => $this->input->post('keterangan')
            ];

            $errors = $this->model->validateData($data);
            if (!empty($errors)) {
                throw new Exception(implode(', ', $errors));
            }

            if ($this->model->create($data)) {
                Notification::success('Data gelar berhasil disimpan');
                return $this->redirect('gelar');
            }
            
            throw new Exception("Failed to save gelar data");
            
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in GelarController::store", [
                'exception' => $e,
                'post_data' => $_POST
            ]);
            throw new Exception("Failed to store gelar data: " . $e->getMessage());
        }
    }

    public function edit($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception("Gelar record not found");
            }
            
            return $this->view('gelar/edit', [
                'title' => 'Edit Data Gelar',
                'data' => $data
            ]);
            
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in GelarController::edit", [
                'exception' => $e,
                'id' => $id
            ]);
            throw new Exception("Failed to load edit form: " . $e->getMessage());
        }
    }

    public function update($id) {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception("Invalid security token");
            }

            $data = [
                'gelar' => $this->input->post('gelar'),
                'keterangan' => $this->input->post('keterangan')
            ];

            $errors = $this->model->validateData($data, $id);
            if (!empty($errors)) {
                throw new Exception(implode(', ', $errors));
            }

            if ($this->model->update($id, $data)) {
                Notification::success('Data gelar berhasil diupdate');
                return $this->redirect('gelar');
            }
            
            throw new Exception("Failed to update record");
            
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in GelarController::update", [
                'exception' => $e,
                'id' => $id,
                'post_data' => $_POST
            ]);
            throw new Exception("Failed to update gelar data: " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            if (!$this->model->delete($id)) {
                throw new Exception("Failed to delete record");
            }
            
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