<?php

class TindakanController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Tindakan');
        // Load Angka helper
        $this->loadHelper('angka');
        $this->loadHelper('debug');
    }
    
    public function index() {
        try {
            $page = $this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = $this->input->get('per_page', 10);
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            $deletedCount = $this->model->countDeleted();
            
            return $this->view('tindakan/index', [
                'title' => 'Data Tindakan',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search,
                'deletedCount' => $deletedCount
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('');
        }
    }

    public function trash() {
        try {
            $page = $this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = $this->input->get('per_page', 10);
            
            $result = $this->model->getTrashPaginate($search, $page, $perPage);
            
            return $this->view('tindakan/trash', [
                'title' => 'Data Tindakan [Terhapus]',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('tindakan');
        }
    }

    public function restore($id) {
        try {
            $data = [
                'status_hps' => '0',
                'deleted_at' => null
            ];

            if (!$this->model->update($id, $data)) {
                throw new Exception('Failed to restore data');
            }

            Notification::success('Data tindakan berhasil dipulihkan');
            return $this->redirect('tindakan/trash');
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('tindakan/trash');
        }
    }

    public function hapus($id) {
        try {
            // Check if record exists and is in trash
            $data = $this->model->find($id);
            if (!$data || $data->status_hps != '1') {
                throw new Exception('Data not found in trash');
            }

            if (!$this->model->permanentDelete($id)) {
                throw new Exception('Failed to delete data permanently');
            }

            Notification::success('Data tindakan berhasil dihapus permanen');
            return $this->redirect('tindakan/trash');
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('tindakan/trash');
        }
    }

    public function create() {
        try {
            return $this->view('tindakan/create', [
                'title' => 'Tambah Data Tindakan',
                'csrf_token' => $this->security->getCSRFToken(),
                'data' => null
            ]);

        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('tindakan/create');
        }
    }

    public function show($id) {
        try {
            $data = $this->model->getWithDetails($id);
            if (!$data) {
                throw new Exception('Data not found');
            }

            return $this->view('tindakan/show', [
                'title' => 'Detail Tindakan',
                'data' => $data
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('tindakan');
        }
    }

    public function edit($id) {
        try {
            // Load the Kategori model
            $kategoriModel = ViewHelper::loadModel('Kategori');
            
            // Get tindakan data with details
            $data = $this->model->getWithDetails($id);
            if (!$data) {
                throw new Exception('Data not found');
            }

            return $this->view('tindakan/edit', [
                'title' => 'Edit Tindakan',
                'data' => $data,
                'kategoris' => $kategoriModel->getActiveKategoris(), // Get active categories
                'csrf_token' => $this->security->getCSRFToken()
            ]);

        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('tindakan');
        }
    }

    public function update($id) {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception('Invalid security token');
            }

            $data = [
                'kode' => $this->input->post('kode'),
                'id_kategori' => $this->input->post('id_kategori'),
                'item' => $this->input->post('item'),
                'item_alias' => $this->input->post('item_alias'),
                'harga_jual' => Angka::cleanNumber($this->input->post('harga_jual')),
                'status' => $this->input->post('status'),
                'updated_at' => date('Y-m-d H:i:s')
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

            // Validate data
            $errors = $this->model->validateData($data, $id);
            if (!empty($errors)) {
                throw new Exception(implode(', ', $errors));
            }

            if (!$this->model->update($id, $data)) {
                throw new Exception('Failed to update data');
            }

            Notification::success('Data tindakan berhasil diupdate');
            return $this->redirect('tindakan');

        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('tindakan/edit/' . $id);
        }
    }

    public function delete($id) {
        try {
            $data = [
                'status_hps' => '1',
                'deleted_at' => date('Y-m-d H:i:s')
            ];

            if (!$this->model->update($id, $data)) {
                throw new Exception('Failed to delete data');
            }

            Notification::success('Data tindakan berhasil dihapus');
            return $this->redirect('tindakan');
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('tindakan');
        }
    }

    public function store() {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception('Invalid security token');
            }

            // Base data
            $data = [
                'kode' => $this->model->generateKode(),
                'id_kategori' => $this->input->post('id_kategori'),
                'item' => $this->input->post('item'),
                'harga_jual' => Angka::cleanNumber($this->input->post('harga_jual')),
                'status' => $this->input->post('status', '1'),
                'status_item' => '2',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
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

            // Validate data
            $errors = $this->model->validateData($data);
            if (!empty($errors)) {
                throw new Exception(implode(', ', $errors));
            }

            // Create record
            if (!$this->model->create($data)) {
                throw new Exception('Gagal menyimpan data');
            }

            Notification::success('Data tindakan berhasil ditambahkan');
            return $this->redirect('tindakan');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('tindakan/create');
        }
    }
} 