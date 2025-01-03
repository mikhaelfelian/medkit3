<?php
class RadiologiController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Radiologi');
        $this->loadHelper('Angka');
    }
    
    public function index() {
        try {
            $page = (int)$this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = 10;
            
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
            ToastrHelper::error($e->getMessage(), 'Error!');
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
                $hargaJual = AngkaHelper::unformat($this->input->post('harga_jual'));
                $remunPerc = AngkaHelper::unformat($this->input->post('remun_perc'));
                
                $data['remun_perc'] = $this->input->post('remun_perc') ? AngkaHelper::unformat($this->input->post('remun_perc')) : 0;
                $data['remun_nom'] = round(($hargaJual * $remunPerc) / 100);
            } else if ($this->input->post('remun_tipe') == '2') {
                $hargaJual = AngkaHelper::unformat($this->input->post('harga_jual'));
                $remunNom = AngkaHelper::unformat($this->input->post('remun_nom'));
                
                $data['remun_nom'] = $this->input->post('remun_nom') ? AngkaHelper::unformat($this->input->post('remun_nom')) : 0;
                $data['remun_perc'] = $hargaJual > 0 ? min(round(($remunNom * 100) / $hargaJual), 100) : 0;
            }

            // Always save apres_tipe even if empty
            $data['apres_tipe'] = (string)$this->input->post('apres_tipe');
            
            // If apres_tipe is percentage (1), calculate nominal amount from percentage
            if ($this->input->post('apres_tipe') == '1') {
                $hargaJual = AngkaHelper::unformat($this->input->post('harga_jual'));
                $apresPerc = AngkaHelper::unformat($this->input->post('apres_perc'));
                
                $data['apres_perc'] = $this->input->post('apres_perc') ? AngkaHelper::unformat($this->input->post('apres_perc')) : 0;
                $data['apres_nom']  = round(($hargaJual * $apresPerc) / 100);
            } else if ($this->input->post('apres_tipe') == '2') {
                $hargaJual = AngkaHelper::unformat($this->input->post('harga_jual')); 
                $apresNom = AngkaHelper::unformat($this->input->post('apres_nom'));
                
                $data['apres_nom'] = $this->input->post('apres_nom') ? AngkaHelper::unformat($this->input->post('apres_nom')) : 0;
                $data['apres_perc'] = $hargaJual > 0 ? min(round(($apresNom * 100) / $hargaJual), 100) : 0;
            }

            if (!$this->model->create($data)) {
                throw new Exception('Gagal menyimpan data');
            }

            Notification::success('Data radiologi berhasil ditambahkan');
            return $this->redirect('radiologi');
            
        } catch (Exception $e) {
            ToastrHelper::error($e->getMessage(), 'Error!');
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
            $page = $this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = $this->input->get('per_page', 10);
            
            // Add status_item filter for radiologi
            $filters = [
                'status_item' => '4' // For radiologi items
            ];
            
            $result = $this->model->getTrashPaginate($search, $page, $perPage, $filters);
            
            return $this->view('master/radiologi/trash', [
                'title' => 'Data Radiologi [Terhapus]',
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
                'remun_tipe' 	=> $this->input->post('remun_tipe'),
                'remun_perc' 	=> $this->input->post('remun_perc'),
                'remun_nom' 	=> $this->input->post('remun_nom'),
                'apres_tipe' 	=> $this->input->post('apres_tipe'),
                'apres_perc' 	=> $this->input->post('apres_perc'),
                'apres_nom' 	=> $this->input->post('apres_nom')
            ];
			
            // Always save remun_tipe even if empty
            $data['remun_tipe'] = (string)$this->input->post('remun_tipe');

            // If remun_tipe is percentage (1), calculate nominal amount from percentage
            if ($this->input->post('remun_tipe') == '1') {
                $hargaJual = AngkaHelper::unformat($this->input->post('harga_jual'));
                $remunPerc = AngkaHelper::unformat($this->input->post('remun_perc'));
                
                $data['remun_perc'] = $this->input->post('remun_perc') ? AngkaHelper::unformat($this->input->post('remun_perc')) : 0;
                $data['remun_nom'] = round(($hargaJual * $remunPerc) / 100);
            } else if ($this->input->post('remun_tipe') == '2') {
                $hargaJual = AngkaHelper::unformat($this->input->post('harga_jual'));
                $remunNom = AngkaHelper::unformat($this->input->post('remun_nom'));
                
                $data['remun_nom'] = $this->input->post('remun_nom') ? AngkaHelper::unformat($this->input->post('remun_nom')) : 0;
                $data['remun_perc'] = $hargaJual > 0 ? min(round(($remunNom * 100) / $hargaJual), 100) : 0;
            }

            // Always save apres_tipe even if empty
            $data['apres_tipe'] = (string)$this->input->post('apres_tipe');
            
            // If apres_tipe is percentage (1), calculate nominal amount from percentage
            if ($this->input->post('apres_tipe') == '1') {
                $hargaJual = AngkaHelper::unformat($this->input->post('harga_jual'));
                $apresPerc = AngkaHelper::unformat($this->input->post('apres_perc'));
                
                $data['apres_perc'] = $this->input->post('apres_perc') ? AngkaHelper::unformat($this->input->post('apres_perc')) : 0;
                $data['apres_nom']  = round(($hargaJual * $apresPerc) / 100);
            } else if ($this->input->post('apres_tipe') == '2') {
                $hargaJual = AngkaHelper::unformat($this->input->post('harga_jual')); 
                $apresNom = AngkaHelper::unformat($this->input->post('apres_nom'));
                
                $data['apres_nom'] = $this->input->post('apres_nom') ? AngkaHelper::unformat($this->input->post('apres_nom')) : 0;
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
            ToastrHelper::error($e->getMessage(), 'Error!');
            return $this->redirect('radiologi/edit/' . $id);
        }
    }

    public function countDeleted() {
        try {
            // Count items that are marked as deleted (status_hps = '1') and are radiologi (status_item = '4')
            $sql = "SELECT COUNT(*) as total 
                    FROM {$this->table} 
                    WHERE status_hps = '1' 
                    AND status_item = '4'";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ)->total;
            
        } catch (PDOException $e) {
            error_log("Database Error in countDeleted: " . $e->getMessage());
            return 0;
        }
    }
} 