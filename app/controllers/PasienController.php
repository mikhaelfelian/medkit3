<?php
class PasienController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Pasien');
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
            
            return $this->view('pasien/index', [
                'title' => 'Data Pasien',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
            
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in PasienController::index", [
                'exception' => $e,
                'search' => $search,
                'page' => $page,
                'perPage' => $perPage
            ]);
            throw new Exception("Failed to load patient data: " . $e->getMessage());
        }
    }

    public function create() {
        try {
            return $this->view('pasien/create', [
                'title' => 'Tambah Data Pasien'
            ]);
        } catch (Exception $e) {
            error_log("Error in PasienController::create - " . $e->getMessage());
            throw new Exception("Failed to load create form: " . $e->getMessage());
        }
    }

    public function store() {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception("Invalid CSRF token");
            }

            $data = [
                'kode' => $this->model->generateKode(),
                'nik' => $this->input->post('nik'),
                'nama' => $this->input->post('nama'),
                'nama_pgl' => $this->input->post('nama_pgl'),
                'no_hp' => $this->input->post('no_hp'),
                'alamat' => $this->input->post('alamat'),
                'alamat_domisili' => $this->input->post('alamat_domisili'),
                'rt' => $this->input->post('rt'),
                'rw' => $this->input->post('rw'),
                'kelurahan' => $this->input->post('kelurahan'),
                'kecamatan' => $this->input->post('kecamatan'),
                'kota' => $this->input->post('kota'),
                'pekerjaan' => $this->input->post('pekerjaan')
            ];

            if ($this->model->create($data)) {
                Notification::success('Data pasien berhasil disimpan');
                return $this->redirect('pasien');
            }
            
            throw new Exception("Failed to save patient data");
            
        } catch (Exception $e) {
            error_log("Error in PasienController::store - " . $e->getMessage());
            throw new Exception("Failed to store patient data: " . $e->getMessage());
        }
    }

    public function edit($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception("Patient record not found");
            }
            
            return $this->view('pasien/edit', [
                'title' => 'Edit Data Pasien',
                'data' => $data
            ]);
            
        } catch (Exception $e) {
            error_log("Error in PasienController::edit - " . $e->getMessage());
            throw new Exception("Failed to load edit form: " . $e->getMessage());
        }
    }

    public function update($id) {
        try {
            // Validate CSRF token first
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception("Invalid security token");
            }

            // Validate if record exists
            $existing = $this->model->find($id);
            if (!$existing) {
                throw new Exception("Record not found");
            }

            $data = [
                'nik' => $this->input->post('nik'),
                'nama' => $this->input->post('nama'),
                'nama_pgl' => $this->input->post('nama_pgl'),
                'no_hp' => $this->input->post('no_hp'),
                'alamat' => $this->input->post('alamat'),
                'alamat_domisili' => $this->input->post('alamat_domisili'),
                'rt' => $this->input->post('rt'),
                'rw' => $this->input->post('rw'),
                'kelurahan' => $this->input->post('kelurahan'),
                'kecamatan' => $this->input->post('kecamatan'),
                'kota' => $this->input->post('kota'),
                'pekerjaan' => $this->input->post('pekerjaan')
            ];

            if ($this->model->update($id, $data)) {
                Notification::success('Data pasien berhasil diupdate');
                return $this->redirect('pasien');
            }
            
            throw new Exception("Failed to update record");
            
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in PasienController::update", [
                'id' => $id,
                'exception' => $e
            ]);
            throw new Exception("Failed to update patient data: " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            if (!$this->model->delete($id)) {
                throw new Exception("Failed to delete record");
            }
            
            Notification::success('Data pasien berhasil dihapus');
            return $this->redirect('pasien');
            
        } catch (Exception $e) {
            error_log("Error in PasienController::delete - " . $e->getMessage());
            throw new Exception("Failed to delete patient data: " . $e->getMessage());
        }
    }

    public function show($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception("Patient record not found");
            }
            
            return $this->view('pasien/show', [
                'title' => 'Detail Pasien',
                'data' => $data
            ]);
            
        } catch (Exception $e) {
            error_log("Error in PasienController::show - " . $e->getMessage());
            throw new Exception("Failed to load patient details: " . $e->getMessage());
        }
    }
} 