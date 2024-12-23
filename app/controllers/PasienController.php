<?php
class PasienController extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->loadModel('Pasien');
    }
    
    /**
     * Display a listing of patients
     */
    public function index() {
        try {
            // Get current page from URL, default to 1
            $page = max(1, intval($this->input('page', 1)));
            $perPage = 10;
            
            // Get paginated data
            $result = $this->model->paginate($page, $perPage);
            
            // Convert data to array if it's not already
            $data = json_decode(json_encode($result['data']), true);
            
            return $this->view('pasien/index', [
                'title' => 'Data Pasien',
                'data' => $data,
                'pagination' => [
                    'current_page' => $page,
                    'per_page' => $perPage,
                    'total_pages' => ceil($result['total'] / $perPage),
                    'total' => $result['total']
                ]
            ]);
            
        } catch (Exception $e) {
            Notification::error('Gagal memuat data pasien');
            return $this->redirect('');
        }
    }
    
    /**
     * Show the form for creating a new patient
     */
    public function create() {
        return $this->view('pasien/create', [
            'title' => 'Tambah Pasien'
        ]);
    }
    
    /**
     * Store a newly created patient
     */
    public function store() {
        try {
            // Verify CSRF token
            $form = BaseForm::getInstance();
            $token = $_POST['csrf_token'] ?? null;
            if (!$form->verifyCsrfToken($token)) {
                throw new Exception("Invalid CSRF token");
            }
            
            // Set old input
            $form->setOld($_POST);
            
            // Validate input
            $validation = $this->validate([
                'nik' => ['required', 'min:16'],
                'nama' => ['required'],
                'alamat' => ['required']
            ]);
            
            if ($validation !== true) {
                $form->setErrors($validation);
                return $this->view('pasien/create');
            }
            
            // Generate RM number
            $rmGenerator = new GenerateNoRM();
            $kode = $rmGenerator->generate();
            
            // Prepare data
            $data = [
                'kode' => $kode,
                'nik' => $this->input('nik'),
                'nama' => $this->input('nama'),
                'nama_pgl' => $this->input('nama_pgl'),
                'no_hp' => $this->input('no_hp'),
                'alamat' => $this->input('alamat'),
                'alamat_domisili' => $this->input('alamat_domisili'),
                'rt' => $this->input('rt'),
                'rw' => $this->input('rw'),
                'kelurahan' => $this->input('kelurahan'),
                'kecamatan' => $this->input('kecamatan'),
                'kota' => $this->input('kota'),
                'pekerjaan' => $this->input('pekerjaan')
            ];
            
            // Save data
            if ($this->model->create($data)) {
                Notification::success('Data pasien berhasil disimpan');
                return $this->redirect('pasien');
            }
            
            throw new Exception("Failed to save data");
            
        } catch (Exception $e) {
            error_log("Error in store: " . $e->getMessage());
            Notification::error(DEBUG_MODE ? $e->getMessage() : 'Gagal menyimpan data');
            return $this->view('pasien/create');
        }
    }
    
    /**
     * Show the form for editing the specified patient
     */
    public function edit($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception("Patient not found");
            }
            
            return $this->view('pasien/edit', [
                'title' => 'Edit Pasien',
                'data' => $data
            ]);
            
        } catch (Exception $e) {
            if (DEBUG_MODE) {
                die("Error: " . $e->getMessage());
            }
            return $this->redirect('pasien');
        }
    }
    
    /**
     * Update the specified patient
     */
    public function update($id) {
        $security = BaseSecurity::getInstance();
        $form = BaseForm::getInstance();
        
        try {
            // Set old input
            $form->setOld($_POST);
            
            // Validate input
            $validation = $this->validate([
                'nik' => 'required|min:16',
                'nama' => 'required',
                'alamat' => 'required'
            ]);
            
            if ($validation !== true) {
                $form->setErrors($validation);
                return $this->view('pasien/edit', [
                    'title' => 'Edit Pasien',
                    'data' => $this->model->find($id)
                ]);
            }
            
            // Sanitize and prepare data
            $data = [
                'nik' => $security->sanitizeInput($this->input('nik')),
                'nama' => $security->sanitizeInput($this->input('nama')),
                'nama_pgl' => $security->sanitizeInput($this->input('nama_pgl')),
                'no_hp' => $security->sanitizeInput($this->input('no_hp')),
                'alamat' => $security->sanitizeInput($this->input('alamat')),
                'alamat_domisili' => $security->sanitizeInput($this->input('alamat_domisili')),
                'rt' => $security->sanitizeInput($this->input('rt')),
                'rw' => $security->sanitizeInput($this->input('rw')),
                'kelurahan' => $security->sanitizeInput($this->input('kelurahan')),
                'kecamatan' => $security->sanitizeInput($this->input('kecamatan')),
                'kota' => $security->sanitizeInput($this->input('kota')),
                'pekerjaan' => $security->sanitizeInput($this->input('pekerjaan'))
            ];
            
            // Update data
            if ($this->model->update($id, $data)) {
                Notification::success('Data pasien berhasil diperbarui');
                return $this->redirect('pasien');
            }
            
            throw new Exception("Failed to update data");
            
        } catch (Exception $e) {
            Notification::error(DEBUG_MODE ? $e->getMessage() : 'Gagal memperbarui data');
            return $this->view('pasien/edit', [
                'title' => 'Edit Pasien',
                'data' => $this->model->find($id)
            ]);
        }
    }
    
    /**
     * Show the specified patient
     */
    public function show($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception("Patient not found");
            }
            
            return $this->view('pasien/show', [
                'title' => 'Detail Pasien',
                'data' => $data
            ]);
            
        } catch (Exception $e) {
            if (DEBUG_MODE) {
                die("Error: " . $e->getMessage());
            }
            return $this->redirect('pasien');
        }
    }
    
    /**
     * Delete the specified patient
     */
    public function delete($id) {
        try {
            if ($this->model->delete($id)) {
                Notification::success('Data pasien berhasil dihapus');
                return $this->redirect('pasien');
            }
            throw new Exception("Failed to delete data");
            
        } catch (Exception $e) {
            Notification::error(DEBUG_MODE ? $e->getMessage() : 'Gagal menghapus data');
            return $this->redirect('pasien');
        }
    }
}
?> 