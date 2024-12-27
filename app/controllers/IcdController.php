<?php
class IcdController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Icd');
    }
    
    public function index() {
        try {
            $page = (int)$this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = (int)$this->input->get('per_page', 10);
            
            if ($page < 1) $page = 1;
            if ($perPage < 1) $perPage = 10;
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            
            return $this->view('icd/index', [
                'title' => 'Data ICD',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
            
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in IcdController::index", [
                'exception' => $e
            ]);
            throw new Exception("Failed to load ICD data: " . $e->getMessage());
        }
    }

    public function create() {
        try {
            return $this->view('icd/create', [
                'title' => 'Tambah Data ICD'
            ]);
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in IcdController::create", [
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
                'kode' => $this->input->post('kode'),
                'icd' => $this->input->post('icd'),
                'diagnosa_en' => $this->input->post('diagnosa_en')
            ];

            $errors = $this->model->validateData($data);
            if (!empty($errors)) {
                throw new Exception(implode(', ', $errors));
            }

            if ($this->model->create($data)) {
                Notification::success('Data ICD berhasil disimpan');
                return $this->redirect('icd');
            }
            
            throw new Exception("Failed to save ICD data");
            
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in IcdController::store", [
                'exception' => $e,
                'post_data' => $_POST
            ]);
            throw new Exception("Failed to store ICD data: " . $e->getMessage());
        }
    }

    public function edit($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception("ICD record not found");
            }
            
            return $this->view('icd/edit', [
                'title' => 'Edit Data ICD',
                'data' => $data
            ]);
            
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in IcdController::edit", [
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
                'kode' => $this->input->post('kode'),
                'icd' => $this->input->post('icd'),
                'diagnosa_en' => $this->input->post('diagnosa_en')
            ];

            $errors = $this->model->validateData($data, $id);
            if (!empty($errors)) {
                throw new Exception(implode(', ', $errors));
            }

            if ($this->model->update($id, $data)) {
                Notification::success('Data ICD berhasil diupdate');
                return $this->redirect('icd');
            }
            
            throw new Exception("Failed to update record");
            
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in IcdController::update", [
                'exception' => $e,
                'id' => $id,
                'post_data' => $_POST
            ]);
            throw new Exception("Failed to update ICD data: " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            if (!$this->model->delete($id)) {
                throw new Exception("Failed to delete record");
            }
            
            Notification::success('Data ICD berhasil dihapus');
            return $this->redirect('icd');
            
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in IcdController::delete", [
                'exception' => $e,
                'id' => $id
            ]);
            throw new Exception("Failed to delete ICD data: " . $e->getMessage());
        }
    }
} 