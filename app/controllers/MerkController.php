<?php
class MerkController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Merk');
    }
    
    public function index() {
        try {
            $page = (int)$this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = (int)$this->input->get('per_page', 10);
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            
            return $this->view('merk/index', [
                'title' => 'Data Merk',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('dashboard');
        }
    }

    public function create() {
        try {
            return $this->view('merk/create', [
                'title' => 'Tambah Data Merk'
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('merk');
        }
    }

    public function store() {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception("Invalid security token");
            }

            $data = [
                'kode' => $this->input->post('kode'),
                'merk' => $this->input->post('merk'),
                'keterangan' => $this->input->post('keterangan'),
                'status' => $this->input->post('status')
            ];

            $errors = $this->model->validateData($data);
            if (!empty($errors)) {
                throw new Exception(implode(', ', $errors));
            }

            if ($this->model->create($data)) {
                Notification::success('Data merk berhasil ditambahkan');
                return $this->redirect('merk');
            }
            
            throw new Exception("Failed to save record");
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('merk/create');
        }
    }

    public function edit($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception("Data not found");
            }
            
            return $this->view('merk/edit', [
                'title' => 'Edit Data Merk',
                'data' => $data
            ]);
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('merk');
        }
    }

    public function update($id) {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception("Invalid security token");
            }

            $data = [
                'kode' => $this->input->post('kode'),
                'merk' => $this->input->post('merk'),
                'keterangan' => $this->input->post('keterangan'),
                'status' => $this->input->post('status')
            ];

            $errors = $this->model->validateData($data, $id);
            if (!empty($errors)) {
                throw new Exception(implode(', ', $errors));
            }

            if ($this->model->update($id, $data)) {
                Notification::success('Data merk berhasil diupdate');
                return $this->redirect('merk');
            }
            
            throw new Exception("Failed to update record");
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('merk/edit/' . $id);
        }
    }

    public function delete($id) {
        try {
            // Check if merk is being used in obat
            $obatModel = $this->loadModel('Obat');
            $usedInObat = $obatModel->findByMerk($id);
            if ($usedInObat) {
                throw new Exception("Merk tidak dapat dihapus karena sedang digunakan");
            }

            // Permanent delete
            if (!$this->model->delete($id)) {
                throw new Exception("Failed to delete record");
            }
            
            Notification::success('Data merk berhasil dihapus');
            return $this->redirect('merk');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('merk');
        }
    }
} 