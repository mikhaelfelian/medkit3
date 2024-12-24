<?php
class PasienController extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->loadModel('Pasien');
    }
    
    public function index() {

        try {
            $search = $this->input('search');
            $page = max(1, intval($this->input('page', 1)));
            $per_page = 10;

            $result = $this->model->searchPaginate($search, $page, $per_page);
            $total = $result['total'];
            $total_pages = ceil($total / $per_page);
            
            // Calculate showing entries
            $from = ($page - 1) * $per_page + 1;
            $to = min($from + $per_page - 1, $total);
            
            // Build search params for pagination links
            $search_params = $search ? '&search=' . urlencode($search) : '';

            return $this->view('pasien/index', [
                'title' => 'Data Pasien',
                'data' => $result['data'],
                'page' => $page,
                'per_page' => $per_page,
                'total' => $total,
                'total_pages' => $total_pages,
                'from' => $from,
                'to' => $to,
                'search_params' => $search_params
            ]);
        } catch (Exception $e) {
            error_log("Error in PasienController::index - " . $e->getMessage());
            Notification::error('Gagal memuat data pasien');
            return $this->redirect('');
        }
    }

    public function create() {
        return $this->view('pasien/create', [
            'title' => 'Tambah Pasien'
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
                'data' => $data
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
?>