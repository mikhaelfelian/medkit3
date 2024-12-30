<?php
class PasienController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Pasien');
        $this->loadHelper('debug');
        $this->loadHelper('Tanggalan');
    }
    
    public function index() {
        try {
            $page = (int)$this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = (int)$this->input->get('per_page', 10);
            
            // Validate input
            if ($page < 1) $page = 1;
            if ($perPage < 1) $perPage = 10;
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            
            return $this->view('pasien/index', [
                'title' => 'Data Pasien',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
            
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in PasienController::index", [
                'exception' => $e,
                'search' => $search,
                'page' => $page,
                'perPage' => $perPage
            ]);
            throw new Exception("Failed to load patient data: " . $e->getMessage());
        }
    }

    public function create() {
        try {
            return $this->view('pasien/create', [
                'title' => 'Tambah Data Pasien'
            ]);
        } catch (Exception $e) {
            error_log("Error in PasienController::create - " . $e->getMessage());
            throw new Exception("Failed to load create form: " . $e->getMessage());
        }
    }

    public function store() {
        try {
            // Validate CSRF token first
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception("Invalid security token");
            }
            
            // Gelar 
            $gelar      = ViewHelper::loadModel('Gelar')->find($this->input->post('id_gelar'));
            $nama_pgl   = $gelar->gelar . ' ' . $this->input->post('nama');

            // Generate no_rm
            $no_rm      = $this->model->generateKode();

            // Uploads directory path
            $path       = PUBLIC_PATH.'/file/pasien/'.strtolower($no_rm);

            // Get form data
            $data = [
                'id_gelar'          => $this->input->post('id_gelar'),
                'kode'              => $no_rm,
                'nik'               => $this->input->post('nik'),
                'nama'              => strtoupper($this->input->post('nama')),
                'nama_pgl'          => strtoupper($nama_pgl),
                'tmp_lahir'         => $this->input->post('tmp_lahir'),
                'tgl_lahir'         => Tanggalan::formatDB($this->input->post('tgl_lahir')),
                'jns_klm'           => $this->input->post('jns_klm'),
                'alamat'            => $this->input->post('alamat'),
                'alamat_domisili'   => $this->input->post('alamat_domisili'),
                'rt'                => $this->input->post('rt'),
                'rw'                => $this->input->post('rw'),
                'kelurahan'         => $this->input->post('kelurahan'),
                'kecamatan'         => $this->input->post('kecamatan'),
                'kota'              => $this->input->post('kota'),
                'pekerjaan'         => $this->input->post('pekerjaan'),
                'no_hp'             => $this->input->post('no_hp'),
                'status'            => '1'
            ];           

            // Validate required fields
            $errors = $this->model->validate($data);
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    Notification::error($error);
                }
                return $this->redirect('pasien/create');
            }

            // Create uploads directory if not exists
            if(!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // Add timestamps
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');

            // Try to save
            if (!$this->model->create($data)) {
                throw new Exception('Gagal menyimpan data pasien');
            }

            Notification::success('Data pasien berhasil disimpan');
            return $this->redirect('pasien');

        } catch (Exception $e) {
            // Log the error
            error_log("Error in PasienController::store - " . $e->getMessage());
            Notification::error($e->getMessage());
            return $this->redirect('pasien/create');
        }
    }

    public function edit($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception("Patient record not found");
            }
            
            return $this->view('pasien/edit', [
                'title' => 'Edit Data Pasien',
                'data' => $data
            ]);
            
        } catch (Exception $e) {
            error_log("Error in PasienController::edit - " . $e->getMessage());
            throw new Exception("Failed to load edit form: " . $e->getMessage());
        }
    }

    public function update($id) {
        try {
            // Validate CSRF token first
            if (!$this->security->validateCSRFToken($this->input->post('csrf_token'))) {
                throw new Exception("Invalid security token");
            }

            // Validate if record exists
            $existing = $this->model->find($id);
            if (!$existing) {
                throw new Exception("Record not found");
            }

            // Gelar 
            $gelar      = ViewHelper::loadModel('Gelar')->find($this->input->post('id_gelar'));
            $nama_pgl   = $gelar->gelar . ' ' . $this->input->post('nama');

            // Get form data
            $data = [
                'id_gelar'          => $this->input->post('id_gelar'),
                'nik'               => $this->input->post('nik'),
                'nama'              => strtoupper($this->input->post('nama')),
                'nama_pgl'          => strtoupper($nama_pgl),
                'tmp_lahir'         => $this->input->post('tmp_lahir'),
                'tgl_lahir'         => Tanggalan::formatDB($this->input->post('tgl_lahir')),
                'jns_klm'           => $this->input->post('jns_klm'),
                'alamat'            => $this->input->post('alamat'),
                'alamat_domisili'   => $this->input->post('alamat_domisili'),
                'rt'                => $this->input->post('rt'),
                'rw'                => $this->input->post('rw'),
                'kelurahan'         => $this->input->post('kelurahan'),
                'kecamatan'         => $this->input->post('kecamatan'),
                'kota'              => $this->input->post('kota'),
                'pekerjaan'         => $this->input->post('pekerjaan'),
                'no_hp'             => $this->input->post('no_hp')
            ];

            if ($this->model->update($id, $data)) {
                Notification::success('Data pasien berhasil diupdate');
                return $this->redirect('pasien');
            }
            
            throw new Exception("Failed to update record");
            
        } catch (Exception $e) {
            Logger::getInstance()->error("Error in PasienController::update", [
                'id' => $id,
                'exception' => $e
            ]);
            throw new Exception("Failed to update patient data: " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $no_rm      = $this->model->find($id)->kode;
            $path       = PUBLIC_PATH.'/file/pasien/'.strtolower($no_rm);

            if (!$this->model->delete($id)) {
                throw new Exception("Failed to delete record");
            }

            // Delete uploads directory if exists
            if(file_exists($path)) {
                rmdir($path);
            }
            
            Notification::success('Data pasien berhasil dihapus');
            return $this->redirect('pasien');
            
        } catch (Exception $e) {
            error_log("Error in PasienController::delete - " . $e->getMessage());
            throw new Exception("Failed to delete patient data: " . $e->getMessage());
        }
    }

    public function show($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception("Patient record not found");
            }
            
            return $this->view('pasien/show', [
                'title' => 'Detail Pasien',
                'data' => $data
            ]);
            
        } catch (Exception $e) {
            error_log("Error in PasienController::show - " . $e->getMessage());
            throw new Exception("Failed to load patient details: " . $e->getMessage());
        }
    }
} 