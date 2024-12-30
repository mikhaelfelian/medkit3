<?php
class PoliController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Poli');
    }
    
    public function index() {
        try {
            $page = (int)$this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = (int)$this->input->get('per_page', 10);
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            
            return $this->view('master/poli/index', [
                'title' => 'Data Poli',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('poli');
        }
    }

    public function create() {
        try {
            return $this->view('master/poli/create', [
                'title' => 'Tambah Poli Baru'
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('poli');
        }
    }

    public function store() {
        try {
            $data = [
                'kode' => $this->model->generateKode(),
                'poli' => $this->input->post('poli'),
                'keterangan' => $this->input->post('keterangan'),
                'status' => $this->input->post('status', '0'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            if (!$this->model->create($data)) {
                throw new Exception('Gagal menyimpan data poli');
            }

            Notification::success('Data poli berhasil disimpan');
            return $this->redirect('poli');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('poli/create');
        }
    }

    private function generateCode() {
        try {
            // Get the latest code from database
            $sql = "SELECT kode FROM {$this->model->getTable()} 
                    WHERE kode LIKE 'PL%' 
                    ORDER BY kode DESC LIMIT 1";
            $stmt = $this->model->getConnection()->prepare($sql);
            $stmt->execute();
            $lastCode = $stmt->fetch(PDO::FETCH_OBJ);

            if ($lastCode) {
                // Extract number from last code and increment
                $number = intval(substr($lastCode->kode, 2)) + 1;
            } else {
                $number = 1;
            }

            // Generate new code with format PL001, PL002, etc
            return 'PL' . str_pad($number, 3, '0', STR_PAD_LEFT);
            
        } catch (Exception $e) {
            error_log("Error generating code: " . $e->getMessage());
            throw new Exception("Gagal generate kode poli");
        }
    }

    public function show($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception('Data poli tidak ditemukan');
            }

            return $this->view('master/poli/show', [
                'title' => 'Detail Poli',
                'data' => $data
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('poli');
        }
    }

    public function edit($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception('Data poli tidak ditemukan');
            }

            return $this->view('master/poli/edit', [
                'title' => 'Edit Poli',
                'data' => $data
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('poli');
        }
    }

    public function update($id) {
        try {
            $data = [
                'poli' => $this->input->post('poli'),
                'keterangan' => $this->input->post('keterangan'),
                'status' => $this->input->post('status', '0')
            ];

            if (!$this->model->update($id, $data)) {
                throw new Exception('Gagal mengupdate data poli');
            }

            Notification::success('Data poli berhasil diupdate');
            return $this->redirect('poli');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('poli/edit/' . $id);
        }
    }

    public function delete($id) {
        try {
            // Check if data exists
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception('Data poli tidak ditemukan');
            }

            // Delete the data
            if (!$this->model->delete($id)) {
                throw new Exception('Gagal menghapus data poli');
            }

            Notification::success('Data poli berhasil dihapus');
            return $this->redirect('poli');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('poli');
        }
    }
} 