<?php
class PenjaminController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Penjamin');
        $this->loadHelper('debug');
    }
    
    public function index() {
        try {
            $page = $this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = $this->input->get('per_page', 10);
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            
            // Validate that we got valid result data
            if (!isset($result['data']) || !isset($result['total'])) {
                throw new Exception('Invalid data structure returned from model');
            }
            
            return $this->view('master/penjamin/index', [
                'title' => 'Data Penjamin',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
        } catch (Exception $e) {
            Notification::error('Gagal mengambil data penjamin: ' . $e->getMessage());
            // Return view with empty data instead of redirecting
            return $this->view('master/penjamin/index', [
                'title'     => 'Data Penjamin',
                'data'      => [],
                'total'     => 0,
                'page'      => 1,
                'perPage'   => 10,
                'search'    => ''
            ]);
        }
    }

    public function create() {
        try {
            return $this->view('master/penjamin/create', [
                'title' => 'Tambah Penjamin',
                'csrf_token' => $this->security->getCSRFToken()
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('penjamin');
        }
    }

    public function store() {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception('Invalid security token');
            }

            $data = [
                'penjamin'  => $this->input->post('penjamin'),
                'persen'    => $this->input->post('persen'), 
                'status'    => $this->input->post('status', '0')
            ];

            // Validate the data first
            $errors = $this->model->validate($data);
            if (!empty($errors)) {
                throw new Exception(implode(', ', $errors));
            }

            // Try to save the data
            $result = $this->model->create($data);
            if (!$result) {
                throw new Exception('Failed to save data');
            }

            Notification::success('Data penjamin berhasil ditambahkan');
            return $this->redirect('penjamin');            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('penjamin/create');
        }
    }

    public function edit($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception('Data not found');
            }

            return $this->view('master/penjamin/edit', [
                'title' => 'Edit Penjamin',
                'data' => $data,
                'csrf_token' => $this->security->getCSRFToken()
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('penjamin');
        }
    }

    public function update($id) {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception('Invalid security token');
            }

            $data = [
                'penjamin' => $this->input->post('penjamin'),
                'persen' => $this->input->post('persen'),
                'status' => $this->input->post('status', '0')
            ];

            $errors = $this->model->validate($data, $id);
            if (!empty($errors)) {
                throw new Exception(implode(', ', $errors));
            }

            if (!$this->model->update($id, $data)) {
                throw new Exception('Failed to update data');
            }

            Notification::success('Data penjamin berhasil diupdate');
            return $this->redirect('penjamin');
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('penjamin/edit/' . $id);
        }
    }

    public function delete($id) {
        try {
            // First check if record exists
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception('Data not found');
            }

            // Perform soft delete
            if (!$this->model->softDelete($id)) {
                throw new Exception('Failed to delete data');
            }

            Notification::success('Data penjamin berhasil dihapus');
            return $this->redirect('penjamin');
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('penjamin');
        }
    }
} 