<?php

class TindakanController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Tindakan');
    }
    
    public function index() {
        try {
            $page = $this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = $this->input->get('per_page', 10);
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            $deletedCount = $this->model->countDeleted();
            
            return $this->view('tindakan/index', [
                'title' => 'Data Tindakan',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search,
                'deletedCount' => $deletedCount
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('');
        }
    }

    public function trash() {
        try {
            $page = $this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = $this->input->get('per_page', 10);
            
            $result = $this->model->getTrash($search, $page, $perPage);
            
            return $this->view('tindakan/trash', [
                'title' => 'Data Tindakan Terhapus',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('tindakan');
        }
    }

    public function restore($id) {
        try {
            // Check if record exists
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception("Data not found");
            }

            if (!$this->model->restore($id)) {
                throw new Exception("Failed to restore record");
            }

            Notification::success('Data tindakan berhasil dipulihkan');
            return $this->redirect('tindakan/trash');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('tindakan/trash');
        }
    }

    public function permanentDelete($id) {
        try {
            // Check if record exists
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception("Data not found");
            }

            if (!$this->model->permanentDelete($id)) {
                throw new Exception("Failed to delete record permanently");
            }

            Notification::success('Data tindakan berhasil dihapus permanen');
            return $this->redirect('tindakan/trash');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('tindakan/trash');
        }
    }

    public function create() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                    throw new Exception('Invalid security token');
                }

                $data = [
                    'kode' => $this->input->post('kode'),
                    'id_kategori' => $this->input->post('id_kategori'),
                    'item' => $this->input->post('item'),
                    'item_alias' => $this->input->post('item_alias'),
                    'harga_jual' => str_replace('.', '', $this->input->post('harga_jual')),
                    'status' => $this->input->post('status', '1'),
                    'status_item' => '2',
                    'status_hps' => '0',
                    'created_at' => date('Y-m-d H:i:s')
                ];

                // Validate data
                $errors = $this->model->validateData($data);
                if (!empty($errors)) {
                    throw new Exception(implode(', ', $errors));
                }

                if (!$this->model->create($data)) {
                    throw new Exception('Gagal menyimpan data');
                }

                Notification::success('Data tindakan berhasil ditambahkan');
                return $this->redirect('tindakan');
            }

            return $this->view('tindakan/create', [
                'title' => 'Tambah Data Tindakan',
                'csrf_token' => $this->security->getCSRFToken(),
                'data' => null
            ]);

        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('tindakan/create');
        }
    }

    public function show($id) {
        try {
            $data = $this->model->getWithDetails($id);
            if (!$data) {
                throw new Exception('Data not found');
            }

            return $this->view('tindakan/show', [
                'title' => 'Detail Tindakan',
                'data' => $data
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('tindakan');
        }
    }

    public function edit($id) {
        try {
            $data = $this->model->getWithDetails($id);
            if (!$data) {
                throw new Exception('Data not found');
            }

            return $this->view('tindakan/edit', [
                'title' => 'Edit Tindakan',
                'data' => $data,
                'csrf_token' => $this->security->getCSRFToken()
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('tindakan');
        }
    }

    public function update($id) {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception('Invalid security token');
            }

            $data = [
                'kode' => $this->input->post('kode'),
                'id_kategori' => $this->input->post('id_kategori'),
                'item' => $this->input->post('item'),
                'item_alias' => $this->input->post('item_alias'),
                'harga_jual' => str_replace('.', '', $this->input->post('harga_jual')),
                'status' => $this->input->post('status'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Validate data
            $errors = $this->model->validateData($data, $id);
            if (!empty($errors)) {
                throw new Exception(implode(', ', $errors));
            }

            if (!$this->model->update($id, $data)) {
                throw new Exception('Failed to update data');
            }

            Notification::success('Data tindakan berhasil diupdate');
            return $this->redirect('tindakan');

        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('tindakan/edit/' . $id);
        }
    }

    public function delete($id) {
        try {
            // Soft delete - set status_hps to 1
            $data = [
                'status_hps' => '1',
                'deleted_at' => date('Y-m-d H:i:s')
            ];

            if (!$this->model->update($id, $data)) {
                throw new Exception('Failed to delete data');
            }

            Notification::success('Data tindakan berhasil dihapus');
            return $this->redirect('tindakan');
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('tindakan');
        }
    }
} 