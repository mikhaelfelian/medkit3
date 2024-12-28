<?php
require_once APP_PATH . '/helpers/DebugHelper.php';

class ObatController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Obat');
        $this->loadHelper('angka');
        $this->loadHelper('debug');
    }
    
    public function index() {
        try {
            $page = $this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = $this->input->get('per_page', 10);
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            
            $deletedCount = $this->model->countDeleted();
            return $this->view('obat/index', [
                'title' => 'Data Obat',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search,
                'deletedCount' => $deletedCount
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('obat');
        }
    }

    public function create() {
        try {
            // Load required models for dropdowns
            $kategoriModel = $this->loadModel('Kategori');
            $merkModel = $this->loadModel('Merk');
            
            return $this->view('obat/create', [
                'title' => 'Tambah Data Obat',
                'kategoris' => $kategoriModel->getActiveKategoris(),
                'merks' => $merkModel->getActiveMerks(),
                'csrf_token' => $this->security->getCSRFToken()
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('obat');
        }
    }

    public function store() {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception('Invalid security token');
            }

            // Debug POST data
            error_log("POST Data: " . print_r($_POST, true));

            $data = [
                'kode'          => $this->model->generateKode(),
                'id_kategori'   => $this->input->post('id_kategori'),
                'id_merk'       => $this->input->post('id_merk'),
                'item'          => $this->input->post('item'),
                'item_alias'    => $this->input->post('item_alias'),
                'item_kand'     => $this->input->post('item_kand'),
                'harga_beli'    => Angka::formatDB($this->input->post('harga_beli')),
                'harga_jual'    => Angka::formatDB($this->input->post('harga_jual')),
                'status'        => '1',
                'status_stok'   => $this->input->post('status_stok', '0'),
                'status_item'   => '1',
                'created_at'    => date('Y-m-d H:i:s')
            ];

            // Debug the data being saved
            error_log("Data to save: " . print_r($data, true));

            // Validate data
            $errors = $this->model->validateData($data);
            if (!empty($errors)) {
                error_log("Validation errors: " . print_r($errors, true));
                throw new Exception(implode('<br>', $errors));
            }

            // Try to save and get result
            $result = $this->model->create($data);
            error_log("Save result: " . ($result ? 'success' : 'failed'));

            if (!$result) {
                throw new Exception('Failed to save data');
            }

            Notification::success('Data obat berhasil disimpan');
            return $this->redirect('obat');

        } catch (Exception $e) {
            error_log("Error in store: " . $e->getMessage());
            Notification::error($e->getMessage());
            return $this->redirect('obat/create');
        }
    }

    public function edit($id) {
        try {
            $data = $this->model->getWithDetails($id);
            if (!$data) {
                throw new Exception("Data not found");
            }
            
            return $this->view('obat/edit', [
                'title' => 'Edit Data Obat',
                'data' => $data,
                'csrf_token' => $this->security->getCSRFToken()
            ]);
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('obat');
        }
    }

    public function update($id) {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception('Invalid security token');
            }

            // First check if record exists
            $existing = $this->model->getWithDetails($id);
            if (!$existing) {
                throw new Exception("Data not found");
            }

            $data = [
                'kode'          => $this->input->post('kode'),
                'id_kategori'   => $this->input->post('id_kategori'),
                'id_merk'       => $this->input->post('id_merk'),
                'item'          => $this->input->post('item'),
                'item_alias'    => $this->input->post('item_alias'),
                'item_kand'     => $this->input->post('item_kand'),
                'harga_beli'    => str_replace('.', '', $this->input->post('harga_beli')),
                'harga_jual'    => str_replace('.', '', $this->input->post('harga_jual')),
                'status_stok'   => $this->input->post('status_stok', '0'),
                'status'        => $this->input->post('status', '1')
            ];

            // Validate data
            $errors = $this->model->validateData($data, $id);
            if (!empty($errors)) {
                throw new Exception(implode(', ', $errors));
            }

            if (!$this->model->update($id, $data)) {
                throw new Exception('Gagal mengupdate data');
            }

            Notification::success('Data obat berhasil diupdate');
            return $this->redirect('obat');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('obat/edit/' . $id);
        }
    }

    public function delete($id) {
        try {
            if ($this->model->delete($id)) {
                Notification::success('Data obat berhasil dihapus');
            } else {
                throw new Exception('Gagal menghapus data');
            }
        } catch (Exception $e) {
            Notification::error('Gagal menghapus data obat');
        }
        return $this->redirect('obat');
    }

    public function show($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception("Record not found");
            }
            
            return $this->view('obat/show', [
                'title' => 'Detail Obat',
                'data' => $data
            ]);
            
        } catch (Exception $e) {
            error_log("Error in ObatController::show - " . $e->getMessage());
            Notification::error('Data obat tidak ditemukan');
            return $this->redirect('obat');
        }
    }

    public function trash() {
        try {
            $page = $this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = $this->input->get('per_page', 10);
            
            $result = $this->model->getTrashPaginate($search, $page, $perPage);
            
            return $this->view('obat/trash', [
                'title' => 'Data Obat [Terhapus]',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('obat');
        }
    }

    public function restore($id) {
        try {
            if (!$this->model->restore($id)) {
                throw new Exception('Failed to restore data');
            }

            Notification::success('Data obat berhasil dipulihkan');
            return $this->redirect('obat/trash');
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('obat/trash');
        }
    }

    public function hapus($id) {
        try {
            if (!$this->model->permanentDelete($id)) {
                throw new Exception('Failed to delete data permanently');
            }

            Notification::success('Data obat berhasil dihapus permanen');
            return $this->redirect('obat/trash');
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('obat/trash');
        }
    }
} 