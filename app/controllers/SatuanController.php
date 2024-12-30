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
            
            return $this->view('satuan/index', [
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

    public function create() {
        return $this->view('satuan/create', [
            'title' => 'Tambah Data Satuan'
        ]);
    }

    public function store() {
        try {
            $data = [
                'satuanKecil' => $this->input->post('satuanKecil'),
                'satuanBesar' => $this->input->post('satuanBesar'),
                'jml' => $this->input->post('jml'),
                'status' => $this->input->post('status')
            ];

            // Validate data
            $errors = $this->model->validate($data);
            if (!empty($errors)) {
                throw new Exception(implode('<br>', $errors));
            }

            // Save data
            if (!$this->model->create($data)) {
                throw new Exception('Gagal menyimpan data satuan');
            }

            Notification::success('Data satuan berhasil disimpan');
            return $this->redirect('satuan');

        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('satuan/create');
        }
    }

    public function edit($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception('Data satuan tidak ditemukan');
            }

            return $this->view('satuan/edit', [
                'title' => 'Edit Data Satuan',
                'data' => $data
            ]);

        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('satuan');
        }
    }

    public function update($id) {
        try {
            $data = [
                'satuanKecil' => $this->input->post('satuanKecil'),
                'satuanBesar' => $this->input->post('satuanBesar'),
                'jml' => $this->input->post('jml'),
                'status' => $this->input->post('status')
            ];

            // Validate data
            $errors = $this->model->validate($data, $id);
            if (!empty($errors)) {
                throw new Exception(implode('<br>', $errors));
            }

            // Update data
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