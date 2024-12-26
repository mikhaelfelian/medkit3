<?php
class PasienController extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Pasien');
    }
    
    public function index() {
        try {
            $page = $this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = $this->input->get('per_page', 10);
            
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
            Notification::error('Gagal memuat data pasien');
            return $this->redirect('');
        }
    }

    public function create() {
        return $this->view('pasien/create', [
            'title' => 'Tambah Pasien',
            'csrf_token' => $_SESSION['csrf_token']
        ]);
    }

    public function store() {
        try {
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