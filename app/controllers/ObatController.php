<?php
class ObatController extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Obat');
    }
    
    public function index() {
        try {
            $page = $this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = $this->input->get('per_page', 10);
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            
            return $this->view('obat/index', [
                'title' => 'Data Obat',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
        } catch (Exception $e) {
            Notification::error('Gagal memuat data obat');
            return $this->redirect('');
        }
    }

    public function add() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                    throw new Exception('Invalid security token');
                }

                $data = [
                    'kode' => $this->input->post('kode'),
                    'id_kategori' => $this->input->post('id_kategori'),
                    'id_merk' => $this->input->post('id_merk'),
                    'barcode' => $this->input->post('barcode'),
                    'item' => $this->input->post('item'),
                    'item_alias' => $this->input->post('item_alias'),
                    'item_kand' => $this->input->post('item_kand'),
                    'harga_beli' => str_replace('.', '', $this->input->post('harga_beli')),
                    'harga_jual' => str_replace('.', '', $this->input->post('harga_jual')),
                    'status_stok' => $this->input->post('status_stok', '0'),
                    'status_obat' => 1,
                    'status' => $this->input->post('status', '1')
                ];

                // Validate data
                $errors = $this->model->validateData($data);
                if (!empty($errors)) {
                    throw new Exception(implode(', ', $errors));
                }

                if (!$this->model->create($data)) {
                    throw new Exception('Gagal menyimpan data ke database');
                }

                Notification::success('Data obat berhasil ditambahkan');
                return $this->redirect('obat');
            }
            
            return $this->view('obat/form', [
                'title' => 'Tambah Data Obat',
                'data' => null,
                'csrf_token' => $this->security->getCSRFToken()
            ]);
        } catch (Exception $e) {
            error_log("Error in ObatController::add - " . $e->getMessage());
            Notification::error($e->getMessage());
            return $this->redirect('obat/add');
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
                'kode' => $this->input->post('kode'),
                'id_kategori' => $this->input->post('id_kategori'),
                'id_merk' => $this->input->post('id_merk'),
                'barcode' => $this->input->post('barcode'),
                'item' => $this->input->post('item'),
                'item_alias' => $this->input->post('item_alias'),
                'item_kand' => $this->input->post('item_kand'),
                'harga_beli' => str_replace('.', '', $this->input->post('harga_beli')),
                'harga_jual' => str_replace('.', '', $this->input->post('harga_jual')),
                'status_stok' => $this->input->post('status_stok', '0'),
                'status' => $this->input->post('status', '1')
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
} 