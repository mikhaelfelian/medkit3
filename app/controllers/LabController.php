<?php
class LabController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Lab');
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
            return $this->view('lab/index', [
                'title' => 'Data Lab',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search,
                'deletedCount' => $deletedCount
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab');
        }
    }

    public function create() {
        try {
            // Load required models for dropdowns
            $kategoriModel = $this->loadModel('Kategori');
            $merkModel = $this->loadModel('Merk');
            
            // Get active records for dropdowns
            $kategoris = $kategoriModel->getActiveRecords();
            $merks = $merkModel->getActiveRecords();

            return $this->view('lab/create', [
                'title' => 'Tambah Data Lab',
                'kategoris' => $kategoris,
                'merks' => $merks,
                'csrf_token' => $this->security->getCSRFToken()
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab');
        }
    }

    public function store() {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception('Invalid security token');
            }

            $data = [
                'kode' => $this->model->generateKode(),
                'id_kategori' => $this->input->post('id_kategori'),
                'item' => $this->input->post('item'),
                'item_alias' => $this->input->post('item_alias'),
                'item_kand' => $this->input->post('item_kand'),
                'harga_jual' => Angka::formatDB($this->input->post('harga_jual')),
                'status' => $this->input->post('status', '1'),
                'status_item' => '3', // For Lab items
                'created_at' => date('Y-m-d H:i:s')
            ];

            if (!$this->model->create($data)) {
                throw new Exception('Failed to save data');
            }

            Notification::success('Data lab berhasil disimpan');
            return $this->redirect('lab');

        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab/create');
        }
    }

    public function edit($id) {
        try {
            // Get lab data with details
            $data = $this->model->getWithDetails($id);
            
            // Load required models for dropdowns
            $kategoriModel = $this->loadModel('Kategori');
            $merkModel = $this->loadModel('Merk');
            
            // Get active records for dropdowns
            $kategoris = $kategoriModel->getActiveRecords();
            $merks = $merkModel->getActiveRecords();

            return $this->view('lab/edit', [
                'title' => 'Edit Data Lab',
                'data' => $data,
                'kategoris' => $kategoris,
                'merks' => $merks,
                'csrf_token' => $this->security->getCSRFToken()
            ]);
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab');
        }
    }

    public function update($id) {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception('Invalid security token');
            }

            // Sanitize and prepare data
            $data = [
                'id_kategori' => (int)$this->input->post('id_kategori'),
                'id_merk' => (int)$this->input->post('id_merk'), // Ensure id_merk is properly cast
                'item' => $this->input->post('item'),
                'item_alias' => $this->input->post('item_alias'),
                'item_kand' => $this->input->post('item_kand'),
                'harga_jual' => Angka::formatDB($this->input->post('harga_jual')),
                'status' => $this->input->post('status', '1'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Validate required fields
            if (empty($data['id_kategori'])) {
                throw new Exception('Kategori harus dipilih');
            }
            if (empty($data['id_merk'])) {
                throw new Exception('Merk harus dipilih');
            }
            if (empty($data['item'])) {
                throw new Exception('Nama item harus diisi');
            }

            // Update the record
            if (!$this->model->update($id, $data)) {
                throw new Exception('Gagal mengupdate data');
            }

            Notification::success('Data lab berhasil diupdate');
            return $this->redirect('lab');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab/edit/' . $id);
        }
    }

    public function show($id) {
        try {
            $data = $this->model->getWithDetails($id);
            if (!$data) {
                throw new Exception("Data not found");
            }
            
            return $this->view('lab/show', [
                'title' => 'Detail Lab',
                'data' => $data
            ]);
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab');
        }
    }

    public function trash() {
        try {
            $page = $this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = $this->input->get('per_page', 10);
            
            $result = $this->model->getTrashPaginate($search, $page, $perPage);
            
            return $this->view('lab/trash', [
                'title' => 'Data Lab [Terhapus]',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab');
        }
    }

    public function delete($id) {
        try {
            if (!$this->model->softDelete($id)) {
                throw new Exception('Failed to delete data');
            }

            Notification::success('Data lab berhasil dihapus');
            return $this->redirect('lab');
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab');
        }
    }

    public function restore($id) {
        try {
            if (!$this->model->restore($id)) {
                throw new Exception('Failed to restore data');
            }

            Notification::success('Data lab berhasil dipulihkan');
            return $this->redirect('lab/trash');
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab/trash');
        }
    }

    public function hapus($id) {
        try {
            if (!$this->model->permanentDelete($id)) {
                throw new Exception('Failed to delete data permanently');
            }

            Notification::success('Data lab berhasil dihapus permanen');
            return $this->redirect('lab/trash');
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab/trash');
        }
    }
} 