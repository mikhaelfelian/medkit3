<?php
class PasienController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = new PasienModel();
    }
    
    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
        
        $result = $this->model->searchPaginate($search, $page, $perPage);
        
        $data = [
            'title' => 'Data Pasien',
            'pasiens' => $result['data'],
            'total' => $result['total'],
            'page' => $page,
            'perPage' => $perPage,
            'search' => $search
        ];
        
        return $this->view('pasien/index', $data);
    }

    public function create() {
        return $this->view('pasien/create', [
            'title' => 'Tambah Pasien',
            'csrf_token' => $_SESSION['csrf_token']
        ]);
    }

    public function store() {
        try {
            $data = $this->input();
            
            // Generate kode pasien
            $data['kode'] = $this->model->generateKode();
            
            if ($this->model->create($data)) {
                Notification::success('Data pasien berhasil ditambahkan');
                return $this->redirect('pasien');
            }
            
            throw new Exception("Failed to create record");
            
        } catch (Exception $e) {
            error_log("Error in PasienController::store - " . $e->getMessage());
            Notification::error('Gagal menambahkan data pasien');
            return $this->redirect('pasien/create');
        }
    }

    public function edit($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception("Record not found");
            }
            
            return $this->view('pasien/edit', [
                'title' => 'Edit Pasien',
                'data' => $data,
                'csrf_token' => $_SESSION['csrf_token']
            ]);
            
        } catch (Exception $e) {
            error_log("Error in PasienController::edit - " . $e->getMessage());
            Notification::error('Data pasien tidak ditemukan');
            return $this->redirect('pasien');
        }
    }

    public function update($id) {
        try {
            $data = $this->input();
            
            if ($this->model->update($id, $data)) {
                Notification::success('Data pasien berhasil diupdate');
                return $this->redirect('pasien');
            }
            
            throw new Exception("Failed to update record");
            
        } catch (Exception $e) {
            error_log("Error in PasienController::update - " . $e->getMessage());
            Notification::error('Gagal mengupdate data pasien');
            return $this->redirect('pasien/edit/' . $id);
        }
    }

    public function delete($id) {
        try {
            if ($this->model->delete($id)) {
                Notification::success('Data pasien berhasil dihapus');
                return $this->redirect('pasien');
            }
            
            throw new Exception("Failed to delete record");
            
        } catch (Exception $e) {
            error_log("Error in PasienController::delete - " . $e->getMessage());
            Notification::error('Gagal menghapus data pasien');
            return $this->redirect('pasien');
        }
    }

    public function show($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception("Record not found");
            }
            
            return $this->view('pasien/show', [
                'title' => 'Detail Pasien',
                'data' => $data
            ]);
            
        } catch (Exception $e) {
            error_log("Error in PasienController::show - " . $e->getMessage());
            Notification::error('Data pasien tidak ditemukan');
            return $this->redirect('pasien');
        }
    }
} 