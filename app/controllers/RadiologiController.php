<?php
class RadiologiController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Radiologi');
        $this->loadHelper('angka');
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
            
            return $this->view('radiologi/index', [
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
            
            return $this->view('radiologi/create', [
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
                'kode' => $this->model->generateKode(),
                'id_kategori' => $this->input->post('id_kategori'),
                'id_merk' => $this->input->post('id_merk'),
                'item' => $this->input->post('item'),
                'item_alias' => $this->input->post('item_alias'),
                'item_kand' => $this->input->post('item_kand'),
                'harga_jual' => Angka::formatDB($this->input->post('harga_jual')),
                'status' => $this->input->post('status', '1'),
                'status_item' => '4', // For Radiologi items
                'created_at' => date('Y-m-d H:i:s')
            ];

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
} 