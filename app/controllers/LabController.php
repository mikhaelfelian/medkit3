<?php
class LabController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model                = $this->loadModel('Lab');
        $this->itemReffModel        = $this->loadModel('ItemRef');
        $this->itemRefInputModel = $this->loadModel('ItemRefInput');
    }
    
    public function index() {
        try {
            $page = $this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = $this->input->get('per_page', 10);
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            
            $deletedCount = $this->model->countDeleted();
            return $this->view('master/lab/index', [
                'title' => 'Data Lab',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search,
                'deletedCount' => $deletedCount
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab');
        }
    }

    public function create() {
        try {
            // Load required models for dropdowns
            $kategoriModel = $this->loadModel('Kategori');
            $merkModel = $this->loadModel('Merk');
            
            // Get active records for dropdowns
            $kategoris = $kategoriModel->getActiveRecords();
            $merks = $merkModel->getActiveRecords();

            return $this->view('master/lab/create', [
                'title' => 'Tambah Data Lab',
                'kategoris' => $kategoris,
                'merks' => $merks,
                'csrf_token' => $this->security->getCSRFToken()
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab');
        }
    }

    public function store() {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception('Invalid security token');
            }

            $data = [
                'id_kategori' => $this->input->post('id_kategori'),
                'id_merk' => $this->input->post('id_merk'),
                'kode' => $this->model->generateKode(),
                'item' => $this->input->post('item'),
                'item_alias' => $this->input->post('item_alias'),
                'item_kand' => $this->input->post('item_kand'),
                'harga_beli' => AngkaHelper::formatDB($this->input->post('harga_beli')),
                'harga_jual' => AngkaHelper::formatDB($this->input->post('harga_jual')),
                'status' => $this->input->post('status', '1'),
                'status_item' => '3', // For Lab items
                'created_at' => date('Y-m-d H:i:s')
            ];

            if (!$this->model->create($data)) {
                throw new Exception('Failed to save data');
            }

            Notification::success('Data lab berhasil disimpan');
            return $this->redirect('lab');

        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab/create');
        }
    }

    public function edit($id) {
        try {
            // Load required models
            $kategoriModel = $this->loadModel('Kategori');
            $merkModel = $this->loadModel('Merk');
            
            // Get lab data with details
            $data = $this->model->getWithDetails($id);
            if (!$data) {
                throw new Exception('Data not found');
            }

            // Get item references
            $item_reffs = $this->itemReffModel->getByItemId($id);
            
            // Get reference inputs
            $item_inputs = $this->itemRefInputModel->getByItemId($id);

            return $this->view('master/lab/edit', [
                'title' => 'Edit Lab',
                'data' => $data,
                'kategoris' => $kategoriModel->getActiveRecords(),
                'merks' => $merkModel->getActiveRecords(),
                'item_reffs' => $item_reffs,
                'item_ref_inputs' => $item_inputs,
                'csrf_token' => $this->security->getCSRFToken()
            ]);

        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab');
        }
    }

    public function update($id) {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception('Invalid security token');
            }

            $data = [
                'id_kategori' => $this->input->post('id_kategori'),
                'id_merk' => $this->input->post('id_merk'),
                'kode' => $this->input->post('kode'),
                'item' => $this->input->post('item'),
                'deskripsi' => $this->input->post('deskripsi'),
                'harga_beli' => AngkaHelper::unformat($this->input->post('harga_beli')),
                'harga_jual' => AngkaHelper::unformat($this->input->post('harga_jual')),
                'status_stok' => $this->input->post('status_stok', '0'),
                'status' => $this->input->post('status', '1'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Validate required fields
            if (empty($data['id_kategori'])) {
                throw new Exception('Kategori harus dipilih');
            }
            if (empty($data['id_merk'])) {
                throw new Exception('Merk harus dipilih');
            }
            if (empty($data['item'])) {
                throw new Exception('Nama item harus diisi');
            }

            // Update the record
            if (!$this->model->update($id, $data)) {
                throw new Exception('Gagal mengupdate data');
            }

            Notification::success('Data lab berhasil diupdate');
            return $this->redirect('lab');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab/edit/' . $id);
        }
    }

    public function show($id) {
        try {
            $data = $this->model->getWithDetails($id);
            if (!$data) {
                throw new Exception("Data not found");
            }
            
            return $this->view('master/lab/show', [
                'title' => 'Detail Lab',
                'data' => $data
            ]);
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab');
        }
    }

    public function trash() {
        try {
            $page = $this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = $this->input->get('per_page', 10);
            
            $result = $this->model->getTrashPaginate($search, $page, $perPage);
            
            return $this->view('master/lab/trash', [
                'title' => 'Data Lab [Terhapus]',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab');
        }
    }

    public function delete($id) {
        try {
            if (!$this->model->softDelete($id)) {
                throw new Exception('Failed to delete data');
            }

            Notification::success('Data lab berhasil dihapus');
            return $this->redirect('lab');
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab');
        }
    }

    public function restore($id) {
        try {
            if (!$this->model->restore($id)) {
                throw new Exception('Failed to restore data');
            }

            Notification::success('Data lab berhasil dipulihkan');
            return $this->redirect('lab/trash');
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab/trash');
        }
    }

    public function hapus($id) {
        try {
            if (!$this->model->permanentDelete($id)) {
                throw new Exception('Failed to delete data permanently');
            }

            Notification::success('Data lab berhasil dihapus permanen');
            return $this->redirect('lab/trash');
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab/trash');
        }
    }

    public function search_items() {
        try {
            $term = $this->input->get('term');
            
            if (empty($term)) {
                return $this->json([]);
            }
            
            $items = $this->model->searchActiveItems($term);
            return $this->json($items);
            
        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store_reff() {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception('Invalid security token');
            }

            $id         = $this->input->post('id');           // Parent lab item ID
            $reff_id    = $this->input->post('item_reff_id'); // Selected reference item ID
            $item_reff  = $this->input->post('item_reff');    // Reference item name
            $jml_reff   = (int)$this->input->post('jml_reff');
            $harga_reff = AngkaHelper::formatDB($this->input->post('harga_reff'));

            // Get reference item details using item_reff_id
            $sql_item = $this->model->getDetails($reff_id);

            if (!$sql_item) {
                throw new Exception('Item referensi tidak ditemukan');
            }

            $subtotal = $jml_reff * $harga_reff;

            // Get form data
            $data = [
                'id_item'       => $id,                    // Parent lab item ID
                'id_item_ref'   => $reff_id,              // Reference item ID
                'id_satuan'     => $sql_item->id_satuan ? $sql_item->id_satuan : 0,
                'item'          => $sql_item->item,        // Reference item name
                'jml'           => (int)$jml_reff,
                'harga'         => (float)$harga_reff,
                'subtotal'      => (float)$subtotal,
                'status'        => $sql_item->status ? $sql_item->status : 0,
            ];

            // Validate required fields
            if (empty($id) || empty($reff_id) || empty($jml_reff)) {
                throw new Exception('Semua field harus diisi');
            }

            // Create new reference
            if (!$this->itemReffModel->create($data)) {
                throw new Exception('Gagal menyimpan data referensi');
            }

            Notification::success('Data referensi berhasil ditambahkan');
            return $this->redirect('lab/edit/' . $data['id_item']);
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab/edit/' . $this->input->post('id'));
        }
    }

    public function delete_reff($id) {
        try {
            // Get reference data first to get parent ID for redirect
            $reff = $this->itemReffModel->find($id);
            if (!$reff) {
                throw new Exception('Reference not found');
            }

            if (!$this->itemReffModel->deleteReff($id)) {
                throw new Exception('Failed to delete reference');
            }

            Notification::success('Referensi berhasil dihapus');
            return $this->redirect('lab/edit/' . $reff->id_item);
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab');
        }
    }

    public function store_item() {
        try {
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception('Invalid security token');
            }

            $id = $this->input->post('id'); // Parent lab item ID
            
            // Get form data
            $data = [
                'id_item'       => $id,
                'id_user'       => 0, // Get logged in user ID
                'item_name'     => $this->input->post('item_name'),
                'item_value'    => $this->input->post('item_value'),
                'item_value_l1' => $this->input->post('item_value_l1'),
                'item_value_l2' => $this->input->post('item_value_l2'),
                'item_value_p1' => $this->input->post('item_value_p1'),
                'item_value_p2' => $this->input->post('item_value_p2'),
                'item_satuan'   => $this->input->post('item_satuan')
            ];

            // Validate required fields
            if (empty($data['id_item']) || empty($data['item_name'])) {
                throw new Exception('Item pemeriksaan harus diisi');
            }

            // Create new reference input
            if (!$this->itemRefInputModel->create($data)) {
                throw new Exception('Gagal menyimpan data pemeriksaan');
            }

            Notification::success('Data pemeriksaan berhasil ditambahkan');
            return $this->redirect('lab/edit/' . $data['id_item']);
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab/edit/' . $this->input->post('id'));
        }
    }

    public function delete_item($id) {
        try {
            // Get reference input data first to get parent ID for redirect
            $item = $this->itemRefInputModel->find($id);
            if (!$item) {
                throw new Exception('Item pemeriksaan tidak ditemukan');
            }

            // Delete the reference input
            if (!$this->itemRefInputModel->delete($id)) {
                throw new Exception('Gagal menghapus item pemeriksaan');
            }

            Notification::success('Item pemeriksaan berhasil dihapus');
            return $this->redirect('lab/edit/' . $item->id_item);
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('lab');
        }
    }
} 