<?php
class RadiologiController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Radiologi');
        $this->loadHelper('angka');
        $this->loadHelper('debug');
    }
    
    public function index() {
        try {
            $page = (int)$this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = (int)$this->input->get('per_page', 10);
            
            if ($page < 1) $page = 1;
            if ($perPage < 1) $perPage = 10;
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            $deletedCount = $this->model->countDeleted();
            
            return $this->view('master/radiologi/index', [
                'title' => 'Data Radiologi',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search,
                'deletedCount' => $deletedCount
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('radiologi');
        }
    }

    public function create() {
        try {
            // Load required models
            $kategoriModel = $this->loadModel('Kategori');
            $merkModel = $this->loadModel('Merk');
            
            return $this->view('master/radiologi/create', [
                'title' => 'Tambah Data Radiologi',
                'kategoris' => $kategoriModel->getActiveRecords(),
                'merks' => $merkModel->getActiveRecords(),
                'kode' => $this->model->generateKode(),
                'csrf_token' => $this->security->getCSRFToken()
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('radiologi');
        }
    }

    public function store() {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception('Invalid security token');
            }

            $data = [
                'id_kategori' 	=> $this->input->post('id_kategori') ?: null,
                'id_merk' 		=> $this->input->post('id_merk') ?: null,
                'kode' 			=> $this->input->post('kode'),
                'item' 			=> $this->input->post('item'),
                'harga_beli' 	=> $this->input->post('harga_beli'),
                'harga_jual' 	=> $this->input->post('harga_jual'),
                'status_stok' 	=> $this->input->post('status_stok') ? '1' : '0',
                'status_item' 	=> '4', // 4 for radiologi
                'status' 		=> '1',
                'created_at' 	=> date('Y-m-d H:i:s')
            ];
			
            // Always save remun_tipe even if empty
            $data['remun_tipe'] = (string)$this->input->post('remun_tipe');

            // If remun_tipe is percentage (1), calculate nominal amount from percentage
            if ($this->input->post('remun_tipe') == '1') {
                $hargaJual = Angka::cleanNumber($this->input->post('harga_jual'));
                $remunPerc = Angka::cleanNumber($this->input->post('remun_perc'));
                
                $data['remun_perc'] = $this->input->post('remun_perc') ? Angka::cleanNumber($this->input->post('remun_perc')) : 0;
                $data['remun_nom'] = round(($hargaJual * $remunPerc) / 100);
            } else if ($this->input->post('remun_tipe') == '2') {
                $hargaJual = Angka::cleanNumber($this->input->post('harga_jual'));
                $remunNom = Angka::cleanNumber($this->input->post('remun_nom'));
                
                $data['remun_nom'] = $this->input->post('remun_nom') ? Angka::cleanNumber($this->input->post('remun_nom')) : 0;
                $data['remun_perc'] = $hargaJual > 0 ? min(round(($remunNom * 100) / $hargaJual), 100) : 0;
            }

            // Always save apres_tipe even if empty
            $data['apres_tipe'] = (string)$this->input->post('apres_tipe');
            
            // If apres_tipe is percentage (1), calculate nominal amount from percentage
            if ($this->input->post('apres_tipe') == '1') {
                $hargaJual = Angka::cleanNumber($this->input->post('harga_jual'));
                $apresPerc = Angka::cleanNumber($this->input->post('apres_perc'));
                
                $data['apres_perc'] = $this->input->post('apres_perc') ? Angka::cleanNumber($this->input->post('apres_perc')) : 0;
                $data['apres_nom']  = round(($hargaJual * $apresPerc) / 100);
            } else if ($this->input->post('apres_tipe') == '2') {
                $hargaJual = Angka::cleanNumber($this->input->post('harga_jual')); 
                $apresNom = Angka::cleanNumber($this->input->post('apres_nom'));
                
                $data['apres_nom'] = $this->input->post('apres_nom') ? Angka::cleanNumber($this->input->post('apres_nom')) : 0;
                $data['apres_perc'] = $hargaJual > 0 ? min(round(($apresNom * 100) / $hargaJual), 100) : 0;
            }

            if (!$this->model->create($data)) {
                throw new Exception('Gagal menyimpan data');
            }

            Notification::success('Data radiologi berhasil ditambahkan');
            return $this->redirect('radiologi');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('radiologi/create');
        }
    }

    public function delete($id) {
        try {
            if (!$this->model->softDelete($id)) {
                throw new Exception('Failed to delete data');
            }

            Notification::success('Data radiologi berhasil dihapus');
            return $this->redirect('radiologi');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('radiologi');
        }
    }

    public function trash() {
        try {
            $page = (int)$this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = (int)$this->input->get('per_page', 10);
            
            if ($page < 1) $page = 1;
            if ($perPage < 1) $perPage = 10;
            
            $result = $this->model->getDeletedPaginate($search, $page, $perPage);
            
            return $this->view('master/radiologi/trash', [
                'title' => 'Data Radiologi Terhapus',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('radiologi');
        }
    }

    public function restore($id) {
        try {
            if (!$this->model->restore($id)) {
                throw new Exception('Failed to restore data');
            }

            Notification::success('Data radiologi berhasil dipulihkan');
            return $this->redirect('radiologi/trash');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('radiologi/trash');
        }
    }

    public function permanentDelete($id) {
        try {
            if (!$this->model->permanentDelete($id)) {
                throw new Exception('Failed to delete data permanently');
            }

            Notification::success('Data radiologi berhasil dihapus permanen');
            return $this->redirect('radiologi/trash');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('radiologi/trash');
        }
    }

    public function edit($id) {
        try {
            // Get radiologi data
            $data = $this->model->find($id);
			
            if (!$data) {
                throw new Exception('Data radiologi tidak ditemukan');
            }

            // Get active kategori list
            $kategoriModel = $this->loadModel('Kategori');
            $kategoris = $kategoriModel->getActiveRecords();

            return $this->view('master/radiologi/edit', [
                'title' => 'Edit Data Radiologi',
                'data' => $data,
                'kategoris' => $kategoris
            ]);

        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('radiologi');
        }
    }

    public function update($id) {
        try {
            // Validate input
            $data = [
                'id_kategori' 	=> $this->input->post('id_kategori'),
                'item' 			=> $this->input->post('item'),
                'harga_jual' 	=> $this->input->post('harga_jual'),
                'remun_tipe' 	=> $this->input->post('remun_tipe') ?: '0',
                'apres_tipe' 	=> $this->input->post('apres_tipe') ?: '0',
                'status_stok' 	=> $this->input->post('status_stok') ? '1' : '0'
            ];	

            // If remun_tipe is percentage (1), calculate nominal amount from percentage
            if ($this->input->post('remun_tipe') == '1') {
                $hargaJual = Angka::cleanNumber($this->input->post('harga_jual'));
                $remunPerc = Angka::cleanNumber($this->input->post('remun_perc'));
                
                $data['remun_perc'] = $this->input->post('remun_perc') ? Angka::cleanNumber($this->input->post('remun_perc')) : 0;
                $data['remun_nom'] = round(($hargaJual * $remunPerc) / 100);
            } else if ($this->input->post('remun_tipe') == '2') {
                $hargaJual = Angka::cleanNumber($this->input->post('harga_jual'));
                $remunNom = Angka::cleanNumber($this->input->post('remun_nom'));
                
                $data['remun_nom'] = $this->input->post('remun_nom') ? Angka::cleanNumber($this->input->post('remun_nom')) : 0;
                $data['remun_perc'] = $hargaJual > 0 ? min(round(($remunNom * 100) / $hargaJual), 100) : 0;
            }
            
            // If apres_tipe is percentage (1), calculate nominal amount from percentage
            if ($this->input->post('apres_tipe') == '1') {
                $hargaJual = Angka::cleanNumber($this->input->post('harga_jual'));
                $apresPerc = Angka::cleanNumber($this->input->post('apres_perc'));
                
                $data['apres_perc'] = $this->input->post('apres_perc') ? Angka::cleanNumber($this->input->post('apres_perc')) : 0;
                $data['apres_nom']  = round(($hargaJual * $apresPerc) / 100);
            } else if ($this->input->post('apres_tipe') == '2') {
                $hargaJual = Angka::cleanNumber($this->input->post('harga_jual')); 
                $apresNom = Angka::cleanNumber($this->input->post('apres_nom'));
                
                $data['apres_nom'] = $this->input->post('apres_nom') ? Angka::cleanNumber($this->input->post('apres_nom')) : 0;
                $data['apres_perc'] = $hargaJual > 0 ? min(round(($apresNom * 100) / $hargaJual), 100) : 0;
            }

            // Validate required fields
            $errors = $this->model->validate($data, $id);
            if (!empty($errors)) {
                throw new Exception(implode('<br>', $errors));
            }

            // Update record
            if (!$this->model->update($id, $data)) {
                throw new Exception('Gagal mengupdate data radiologi');
            }

            Notification::success('Data radiologi berhasil diupdate');
            return $this->redirect('radiologi');
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('radiologi/edit/' . $id);
        }
    }
} 