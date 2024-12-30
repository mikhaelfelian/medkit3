<?php
class SupplierController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Supplier');
    }
    
    public function index() {
        try {
            $page = $this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = $this->input->get('per_page', 10);
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            
            return $this->view('master/supplier/index', [
                'title' => 'Data Supplier',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('');
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
                    'nama' => $this->input->post('nama'),
                    'npwp' => $this->input->post('npwp'),
                    'alamat' => $this->input->post('alamat'),
                    'kota' => $this->input->post('kota'),
                    'no_tlp' => $this->input->post('no_tlp'),
                    'no_hp' => $this->input->post('no_hp'),
                    'cp' => $this->input->post('cp'),
                    'status_hps' => '0'
                ];

                $errors = $this->model->validateData($data);
                if (!empty($errors)) {
                    throw new Exception(implode(', ', $errors));
                }

                if (!$this->model->create($data)) {
                    throw new Exception('Failed to save data');
                }

                Notification::success('Data supplier berhasil ditambahkan');
                return $this->redirect('supplier');
            }

            return $this->view('master/supplier/create', [
                'title' => 'Tambah Supplier',
                'csrf_token' => $this->security->getCSRFToken()
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('supplier/create');
        }
    }

    public function edit($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception('Data not found');
            }

            return $this->view('master/supplier/edit', [
                'title' => 'Edit Supplier',
                'data' => $data,
                'csrf_token' => $this->security->getCSRFToken()
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('supplier');
        }
    }

    public function update($id) {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception('Invalid security token');
            }

            $data = [
                'kode' => $this->input->post('kode'),
                'nama' => $this->input->post('nama'),
                'npwp' => $this->input->post('npwp'),
                'alamat' => $this->input->post('alamat'),
                'kota' => $this->input->post('kota'),
                'no_tlp' => $this->input->post('no_tlp'),
                'no_hp' => $this->input->post('no_hp'),
                'cp' => $this->input->post('cp')
            ];

            $errors = $this->model->validateData($data, $id);
            if (!empty($errors)) {
                throw new Exception(implode(', ', $errors));
            }

            if (!$this->model->update($id, $data)) {
                throw new Exception('Failed to update data');
            }

            Notification::success('Data supplier berhasil diupdate');
            return $this->redirect('supplier');
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('supplier/edit/' . $id);
        }
    }

    public function show($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception('Data not found');
            }

            return $this->view('master/supplier/show', [
                'title' => 'Detail Supplier',
                'data' => $data
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('supplier');
        }
    }

    public function delete($id) {
        try {
            if (!$this->model->softDelete($id)) {
                throw new Exception('Failed to delete data');
            }

            Notification::success('Data supplier berhasil dihapus');
            return $this->redirect('supplier');
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('supplier');
        }
    }
} 