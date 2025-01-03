<?php
class SatuanController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Satuan');
    }
    
    public function index() {
        try {
            $page = (int)$this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = 10;
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            
            return $this->view('master/satuan/index', [
                'title' => 'Data Satuan',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
        } catch (Exception $e) {
            ToastrHelper::error($e->getMessage(), 'Error!');
            return $this->redirect('satuan');
        }
    }

    public function create() {
        try {
            // Initialize form object
            $form = BaseForm::getInstance();

            return $this->view('master/satuan/create', [
                'title' => 'Edit Satuan',
                'form' => $form
            ]);

        } catch (Exception $e) {
            ToastrHelper::error($e->getMessage(), 'Error!');
            return $this->redirect('satuan');
        }
    }

    public function store() {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception('Invalid security token');
            }

            $data = [
                'satuanKecil' => $this->input->post('satuanKecil'),
                'satuanBesar' => $this->input->post('satuanBesar'), 
                'jml' => $this->input->post('jml'),
                'status' => $this->input->post('status', '1'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Validate data
            $errors = $this->model->validate($data);
            if (!empty($errors)) {
                ToastrHelper::warning('Silakan periksa form input', 'Peringatan!');
                return $this->view('master/satuan/create', [
                    'title' => 'Tambah Satuan',
                    'data' => (object)$data,
                    'errors' => $errors,
                    'form' => BaseForm::getInstance()
                ]);
            }

            // Save data
            if ($this->model->create($data)) {
                ToastrHelper::success('Data satuan berhasil disimpan', 'Berhasil!');
                return $this->redirect('satuan');
            }
            
            ToastrHelper::error('Gagal menyimpan data satuan', 'Error!');
            return $this->redirect('satuan/create');

        } catch (Exception $e) {
            ToastrHelper::error($e->getMessage(), 'Error!');
            return $this->redirect('satuan/create');
        }
    }

    public function edit($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception('Data satuan tidak ditemukan');
            }

            // Initialize form object
            $form = BaseForm::getInstance();

            return $this->view('master/satuan/edit', [
                'title' => 'Edit Satuan',
                'data' => $data,
                'form' => $form
            ]);

        } catch (Exception $e) {
            ToastrHelper::error($e->getMessage(), 'Error!');
            return $this->redirect('satuan');
        }
    }

    public function update($id) {
        try {
            // Initialize form object
            $form = BaseForm::getInstance();

            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception('Invalid security token');
            }

            $data = [
                'satuanKecil' => $this->input->post('satuanKecil'),
                'satuanBesar' => $this->input->post('satuanBesar'),
                'jml' => $this->input->post('jml'),
                'status' => $this->input->post('status', '1')
            ];

            // Validate data
            $errors = $this->model->validate($data, $id);
            if (!empty($errors)) {
                ToastrHelper::warning('Silakan periksa form input', 'Peringatan!');
                return $this->view('master/satuan/edit', [
                    'title' => 'Edit Satuan',
                    'data' => (object)array_merge(['id' => $id], $data),
                    'errors' => $errors,
                    'form' => $form
                ]);
            }

            if ($this->model->update($id, $data)) {
                ToastrHelper::success('Data satuan berhasil diupdate', 'Berhasil!');
                return $this->redirect('satuan');
            }
            
            ToastrHelper::error('Gagal mengupdate data satuan', 'Error!');
            return $this->redirect('satuan/edit/' . $id);

        } catch (Exception $e) {
            ToastrHelper::error($e->getMessage(), 'Error!');
            return $this->redirect('satuan/edit/' . $id);
        }
    }

    public function delete($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception('Data satuan tidak ditemukan');
            }

            if ($this->model->delete($id)) {
                ToastrHelper::success('Data satuan berhasil dihapus', 'Berhasil!');
            } else {
                ToastrHelper::error('Gagal menghapus data satuan', 'Error!');
            }
            return $this->redirect('satuan');

        } catch (Exception $e) {
            ToastrHelper::error($e->getMessage(), 'Error!');
            return $this->redirect('satuan');
        }
    }
} 