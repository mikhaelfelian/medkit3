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
            Notification::error($e->getMessage());
            return $this->redirect('satuan');
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
            Notification::error($e->getMessage());
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
                return $this->view('master/satuan/edit', [
                    'title' => 'Edit Satuan',
                    'data' => (object)array_merge(['id' => $id], $data),
                    'errors' => $errors,
                    'form' => $form
                ]);
            }

            if (!$this->model->update($id, $data)) {
                throw new Exception('Gagal mengupdate data satuan');
            }

            Notification::success('Data satuan berhasil diupdate');
            return $this->redirect('satuan');

        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('satuan/edit/' . $id);
        }
    }

    public function delete($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception('Data satuan tidak ditemukan');
            }

            if (!$this->model->delete($id)) {
                throw new Exception('Gagal menghapus data satuan');
            }

            Notification::success('Data satuan berhasil dihapus');
            return $this->redirect('satuan');

        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('satuan');
        }
    }
} 