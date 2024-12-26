<?php
class GudangController extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Gudang');
    }
    
    public function index() {
        try {
            $page = $this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = $this->input->get('per_page', 10);
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            
            return $this->view('gudang/index', [
                'title' => 'Data Gudang',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
        } catch (BaseException $e) {
            Handler::render($e);
        } catch (Exception $e) {
            Notification::error('Gagal memuat data gudang');
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
                    'gudang' => $this->input->post('gudang'),
                    'keterangan' => $this->input->post('keterangan'),
                    'status' => $this->input->post('status', '1'),
                    'status_gd' => $this->input->post('status_gd', '0'),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                if ($data['status_gd'] == '1') {
                    $this->model->unsetAllPrimary();
                }

                if (!$this->model->create($data)) {
                    throw new Exception('Gagal menyimpan data ke database');
                }

                Notification::success('Data gudang berhasil ditambahkan');
                return $this->redirect('gudang');
            }
            
            return $this->view('gudang/form', [
                'title' => 'Tambah Data Gudang',
                'data' => null,
                'csrf_token' => $this->security->getCSRFToken()
            ]);
        } catch (Exception $e) {
            error_log("Error in GudangController::add - " . $e->getMessage());
            Notification::error('Gagal menambahkan data gudang');
            return $this->redirect('gudang');
        }
    }

    public function edit($id) {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'kode' => $this->input->post('kode'),
                    'gudang' => $this->input->post('gudang'),
                    'keterangan' => $this->input->post('keterangan'),
                    'status' => $this->input->post('status', '1'),
                    'status_gd' => $this->input->post('status_gd', '0'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if ($data['status_gd'] == '1') {
                    $this->model->unsetAllPrimary();
                }

                if ($this->model->update($id, $data)) {
                    Notification::success('Data gudang berhasil diperbarui');
                    return $this->redirect('gudang');
                }
                throw new Exception('Gagal memperbarui data');
            }
            
            return $this->view('gudang/form', [
                'title' => 'Edit Data Gudang',
                'data' => $this->model->find($id),
                'csrf_token' => $this->security->getCSRFToken()
            ]);
        } catch (Exception $e) {
            Notification::error('Gagal memperbarui data gudang');
            return $this->redirect('gudang');
        }
    }

    public function delete($id) {
        try {
            if ($this->model->delete($id)) {
                Notification::success('Data gudang berhasil dihapus');
            } else {
                throw new Exception('Gagal menghapus data');
            }
        } catch (Exception $e) {
            Notification::error('Gagal menghapus data gudang');
        }
        return $this->redirect('gudang');
    }

    public function show($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception("Record not found");
            }
            
            return $this->view('gudang/show', [
                'title' => 'Detail Gudang',
                'data' => $data
            ]);
            
        } catch (Exception $e) {
            error_log("Error in GudangController::show - " . $e->getMessage());
            Notification::error('Data gudang tidak ditemukan');
            return $this->redirect('gudang');
        }
    }

    public function togglePrimary($id) {
        try {
            if (!$this->model->togglePrimaryStatus($id)) {
                throw new Exception('Failed to update primary status');
            }
            return json_encode(['success' => true]);
        } catch (Exception $e) {
            return json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updateStatus()
    {
        try {
            $id = $_POST['id'] ?? null;
            $status = $_POST['status'] ?? null;

            if (!$id || !isset($status)) {
                throw new BaseException('Invalid parameters', 400);
            }

            $gudang = new GudangModel();
            $result = $gudang->update([
                'status_gd' => $status
            ], $id);

            if (!$result) {
                throw new BaseException('Failed to update status', 500);
            }

            echo json_encode(['success' => true]);
            
        } catch (BaseException $e) {
            Handler::render($e);
        }
    }

    public function set_primary() {
        header('Content-Type: application/json');
        try {
            // Get and validate input
            $id = $this->input->post('id');
            $status_gd = $this->input->post('status_gd');
            
            if (!$id || !isset($status_gd)) {
                throw new Exception('Invalid parameters');
            }
            
            // Get database connection from model
            $db = $this->model->getConnection();
            
            try {
                // Start transaction
                $db->beginTransaction();
                
                // If setting as primary, unset all others first
                if ($status_gd === '1') {
                    $this->model->unsetAllPrimary();
                }
                
                // Update the selected gudang
                $result = $this->model->update($id, ['status_gd' => $status_gd]);
                
                if (!$result) {
                    throw new Exception('Failed to update status');
                }
                
                // Commit transaction
                $db->commit();
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Status berhasil diperbarui',
                    'status_gd' => $status_gd
                ]);
                
            } catch (Exception $e) {
                // Rollback on error
                if ($db->inTransaction()) {
                    $db->rollBack();
                }
                throw $e;
            }
            
        } catch (Exception $e) {
            error_log("Error in set_primary: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }
} 