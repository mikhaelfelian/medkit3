<?php
class ObatController extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Obat');
    }
    
    public function index() {
        try {
            return $this->view('obat/index', [
                'title' => 'Data Obat',
                'data' => $this->model->get()
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
                    'id_satuan' => 7,
                    'id_kategori' => 0,
                    'id_kategori_lab' => 0,
                    'id_kategori_gol' => 0,
                    'id_lokasi' => 0,
                    'id_merk' => 0,
                    'id_user' => $_SESSION['user_id'] ?? 0,
                    'tgl_simpan' => date('Y-m-d H:i:s'),
                    'kode' => $this->input->post('kode'),
                    'barcode' => $this->input->post('barcode'),
                    'item' => $this->input->post('item'),
                    'item_alias' => $this->input->post('item_alias'),
                    'item_kand' => $this->input->post('item_kand'),
                    'item_kand2' => null,
                    'jml' => 0,
                    'jml_limit' => 0,
                    'harga_beli' => str_replace('.', '', $this->input->post('harga_beli')),
                    'harga_jual' => str_replace('.', '', $this->input->post('harga_jual')),
                    'remun_tipe' => '0',
                    'remun_perc' => 0.00,
                    'remun_nom' => 0.00,
                    'apres_tipe' => '0',
                    'apres_perc' => 0.00,
                    'apres_nom' => 0.00,
                    'status' => '0',
                    'status_stok' => '0',
                    'status_racikan' => '0',
                    'status_hps' => '0',
                    'status_obat' => $this->input->post('status_obat')
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
                    'item_alias' => $_POST['item_alias'],
                    'item_kand' => $_POST['item_kand'],
                    'harga_beli' => str_replace('.', '', $_POST['harga_beli']),
                    'harga_jual' => str_replace('.', '', $_POST['harga_jual']),
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