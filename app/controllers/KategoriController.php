<?php
class KategoriController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Kategori');
    }
    
    public function index() {
        try {
            $page = (int)$this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = (int)$this->input->get('per_page', 10);
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            
            return $this->view('kategori/index', [
                'title' => 'Data Kategori',
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
            return $this->view('kategori/create', [
                'title' => 'Tambah Data Kategori'
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('kategori');
        }
    }

    public function store() {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception("Invalid security token");
            }

            $data = [
                'kode' => $this->input->post('kode'),
                'kategori' => $this->input->post('kategori'),
                'keterangan' => $this->input->post('keterangan'),
                'status' => $this->input->post('status')
            ];

            $errors = $this->model->validateData($data);
            if (!empty($errors)) {
                throw new Exception(implode(', ', $errors));
            }

            if ($this->model->create($data)) {
                Notification::success('Data kategori berhasil ditambahkan');
                return $this->redirect('kategori');
            }
            
            throw new Exception("Failed to save record");
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('kategori/create');
        }
    }

    public function edit($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception("Data not found");
            }
            
            return $this->view('kategori/edit', [
                'title' => 'Edit Data Kategori',
                'data' => $data
            ]);
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('kategori');
        }
    }

    public function update($id) {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception("Invalid security token");
            }

            $data = [
                'kode' => $this->input->post('kode'),
                'kategori' => $this->input->post('kategori'),
                'keterangan' => $this->input->post('keterangan'),
                'status' => $this->input->post('status')
            ];

            $errors = $this->model->validateData($data, $id);
            if (!empty($errors)) {
                throw new Exception(implode(', ', $errors));
            }

            if ($this->model->update($id, $data)) {
                Notification::success('Data kategori berhasil diupdate');
                return $this->redirect('kategori');
            }
            
            throw new Exception("Failed to update record");
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('kategori/edit/' . $id);
        }
    }

    public function delete($id) {
        try {
            if (!$this->model->delete($id)) {
                throw new Exception("Failed to delete record");
            }
            
            Notification::success('Data kategori berhasil dihapus');
            return $this->redirect('kategori');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('kategori');
        }
    }
} 