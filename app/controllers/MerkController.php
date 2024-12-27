<?php
class MerkController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Merk');
    }
    
    public function index() {
        try {
            $page = (int)$this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = (int)$this->input->get('per_page', 10);
            
            // Validate input
            if ($page < 1) $page = 1;
            if ($perPage < 1) $perPage = 10;
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            
            return $this->view('merk/index', [
                'title' => 'Data Merk',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
            
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in MerkController::index", [
                'exception' => $e,
                'search' => $search,
                'page' => $page,
                'perPage' => $perPage
            ]);
            throw new Exception("Failed to load merk data: " . $e->getMessage());
        }
    }

    public function create() {
        try {
            return $this->view('merk/create', [
                'title' => 'Tambah Data Merk'
            ]);
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in MerkController::create", [
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
                'merk' => $this->input->post('merk'),
                'keterangan' => $this->input->post('keterangan'),
                'status' => $this->input->post('status', '0')
            ];

            if ($this->model->create($data)) {
                Notification::success('Data merk berhasil disimpan');
                return $this->redirect('merk');
            }
            
            throw new Exception("Failed to save merk data");
            
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in MerkController::store", [
                'exception' => $e,
                'post_data' => $_POST
            ]);
            throw new Exception("Failed to store merk data: " . $e->getMessage());
        }
    }

    public function edit($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception("Merk record not found");
            }
            
            return $this->view('merk/edit', [
                'title' => 'Edit Data Merk',
                'data' => $data
            ]);
            
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in MerkController::edit", [
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
                'merk' => $this->input->post('merk'),
                'keterangan' => $this->input->post('keterangan'),
                'status' => $this->input->post('status', '0')
            ];

            if ($this->model->update($id, $data)) {
                Notification::success('Data merk berhasil diupdate');
                return $this->redirect('merk');
            }
            
            throw new Exception("Failed to update record");
            
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in MerkController::update", [
                'exception' => $e,
                'id' => $id,
                'post_data' => $_POST
            ]);
            throw new Exception("Failed to update merk data: " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            if (!$this->model->softDelete($id)) {
                throw new Exception("Failed to delete record");
            }
            
            Notification::success('Data merk berhasil dihapus');
            return $this->redirect('merk');
            
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in MerkController::delete", [
                'exception' => $e,
                'id' => $id
            ]);
            throw new Exception("Failed to delete merk data: " . $e->getMessage());
        }
    }
} 