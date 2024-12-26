<?php
class ObatController extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Obat');
    }
    
    public function index() {
        try {
            $page = $this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = $this->input->get('per_page', 10);
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            
            return $this->view('obat/index', [
                'title' => 'Data Obat',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
        } catch (Exception $e) {
            Notification::error('Gagal memuat data obat');
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
                    'barcode' => $this->input->post('barcode'),
                    'item' => $this->input->post('item'),
                    'jml' => $this->input->post('jml'),
                    'harga_jual' => $this->input->post('harga_jual'),
                    'status' => 4,
                    'tgl_simpan' => date('Y-m-d H:i:s'),
                    'id_user' => $_SESSION['user_id'] ?? 0,
                    'id_satuan' => 7,
                    'id_kategori' => 0,
                    // Set default values for required fields
                    'id_kategori_lab' => 0,
                    'id_kategori_gol' => 0,
                    'id_lokasi' => 0,
                    'id_merk' => 0,
                    'jml_display' => 0,
                    'jml_limit' => 0,
                    'status_promo' => '0',
                    'status_subt' => '0',
                    'status_lab' => '0',
                    'status_brg_dep' => '0',
                    'status_stok' => '0',
                    'status_racikan' => '0',
                    'status_etiket' => '0',
                    'status_hps' => '0',
                    'sl' => '0',
                    'sp' => '0',
                    'so' => '0'
                ];

                if (!$this->model->create($data)) {
                    throw new Exception('Gagal menyimpan data ke database');
                }

                Notification::success('Data obat berhasil ditambahkan');
                return $this->redirect('obat');
            }
            
            return $this->view('obat/form', [
                'title' => 'Tambah Data Obat',
                'data' => null,
                'csrf_token' => $this->security->getCSRFToken()
            ]);
        } catch (Exception $e) {
            error_log("Error in ObatController::add - " . $e->getMessage());
            Notification::error('Gagal menambahkan data obat');
            return $this->redirect('obat');
        }
    }

    public function edit($id) {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'kode' => $_POST['kode'],
                    'barcode' => $_POST['barcode'],
                    'item' => $_POST['item'],
                    'jml' => $_POST['jml'],
                    'harga_jual' => $_POST['harga_jual'],
                    'tgl_modif' => date('Y-m-d H:i:s')
                ];

                if ($this->model->update($id, $data)) {
                    Notification::success('Data obat berhasil diperbarui');
                    return $this->redirect('obat');
                }
                throw new Exception('Gagal memperbarui data');
            }
            
            return $this->view('obat/form', [
                'title' => 'Edit Data Obat',
                'data' => $this->model->find($id),
                'csrf_token' => $this->security->getCSRFToken()
            ]);
        } catch (Exception $e) {
            Notification::error('Gagal memperbarui data obat');
            return $this->redirect('obat');
        }
    }

    public function delete($id) {
        try {
            if ($this->model->delete($id)) {
                Notification::success('Data obat berhasil dihapus');
            } else {
                throw new Exception('Gagal menghapus data');
            }
        } catch (Exception $e) {
            Notification::error('Gagal menghapus data obat');
        }
        return $this->redirect('obat');
    }
} 