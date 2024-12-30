<?php
class KaryawanController extends BaseController {
    protected $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = $this->loadModel('Karyawan');
    }
    
    public function index() {
        try {
            $page = (int)$this->input->get('page', 1);
            $search = $this->input->get('search', '');
            $perPage = (int)$this->input->get('per_page', 10);
            
            $result = $this->model->searchPaginate($search, $page, $perPage);
            
            return $this->view('master/karyawan/index', [
                'title' => 'Data Karyawan',
                'data' => $result['data'],
                'total' => $result['total'],
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search
            ]);
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('karyawan');
        }
    }

    public function create() {
        try {
            return $this->view('master/karyawan/create', [
                'title' => 'Tambah Karyawan Baru',
                'poli_list' => $this->model->getPoliList()
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('karyawan');
        }
    }

    public function store() {
        try {
            $data = [
                'kode' => $this->model->generateKode(),
                'id_poli' => $this->input->post('id_poli'),
                'nik' => $this->input->post('nik'),
                'sip' => $this->input->post('sip'),
                'str' => $this->input->post('str'),
                'no_ijin' => $this->input->post('no_ijin'),
                'tgl_lahir' => $this->input->post('tgl_lahir'),
                'tmp_lahir' => $this->input->post('tmp_lahir'),
                'nama_dpn' => $this->input->post('nama_dpn'),
                'nama' => $this->input->post('nama'),
                'nama_blk' => $this->input->post('nama_blk'),
                'nama_pgl' => $this->input->post('nama_pgl'),
                'alamat' => $this->input->post('alamat'),
                'alamat_domisili' => $this->input->post('alamat_domisili'),
                'rt' => $this->input->post('rt'),
                'rw' => $this->input->post('rw'),
                'kelurahan' => $this->input->post('kelurahan'),
                'kecamatan' => $this->input->post('kecamatan'),
                'kota' => $this->input->post('kota'),
                'jns_klm' => $this->input->post('jns_klm'),
                'jabatan' => $this->input->post('jabatan'),
                'no_hp' => $this->input->post('no_hp'),
                'status' => $this->input->post('status'),
                'status_aps' => $this->input->post('status_aps', '0')
            ];

            if (!$this->model->create($data)) {
                throw new Exception('Gagal menyimpan data karyawan');
            }

            Notification::success('Data karyawan berhasil disimpan');
            return $this->redirect('karyawan');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('karyawan/create');
        }
    }

    public function edit($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception('Data karyawan tidak ditemukan');
            }

            return $this->view('master/karyawan/edit', [
                'title' => 'Edit Karyawan',
                'data' => $data,
                'poli_list' => $this->model->getPoliList()
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('karyawan');
        }
    }

    public function update($id) {
        try {
            $data = [
                'id_poli' => $this->input->post('id_poli'),
                'nik' => $this->input->post('nik'),
                'sip' => $this->input->post('sip'),
                'str' => $this->input->post('str'),
                'no_ijin' => $this->input->post('no_ijin'),
                'tgl_lahir' => $this->input->post('tgl_lahir'),
                'tmp_lahir' => $this->input->post('tmp_lahir'),
                'nama_dpn' => $this->input->post('nama_dpn'),
                'nama' => $this->input->post('nama'),
                'nama_blk' => $this->input->post('nama_blk'),
                'nama_pgl' => $this->input->post('nama_pgl'),
                'alamat' => $this->input->post('alamat'),
                'alamat_domisili' => $this->input->post('alamat_domisili'),
                'rt' => $this->input->post('rt'),
                'rw' => $this->input->post('rw'),
                'kelurahan' => $this->input->post('kelurahan'),
                'kecamatan' => $this->input->post('kecamatan'),
                'kota' => $this->input->post('kota'),
                'jns_klm' => $this->input->post('jns_klm'),
                'jabatan' => $this->input->post('jabatan'),
                'no_hp' => $this->input->post('no_hp'),
                'status' => $this->input->post('status'),
                'status_aps' => $this->input->post('status_aps', '0')
            ];

            if (!$this->model->update($id, $data)) {
                throw new Exception('Gagal mengupdate data karyawan');
            }

            Notification::success('Data karyawan berhasil diupdate');
            return $this->redirect('karyawan');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('karyawan/edit/' . $id);
        }
    }

    public function show($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception('Data karyawan tidak ditemukan');
            }

            return $this->view('master/karyawan/show', [
                'title' => 'Detail Karyawan',
                'data' => $data
            ]);
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('karyawan');
        }
    }

    public function delete($id) {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                throw new Exception('Data karyawan tidak ditemukan');
            }

            if (!$this->model->delete($id)) {
                throw new Exception('Gagal menghapus data karyawan');
            }

            Notification::success('Data karyawan berhasil dihapus');
            return $this->redirect('karyawan');
            
        } catch (Exception $e) {
            Notification::error($e->getMessage());
            return $this->redirect('karyawan');
        }
    }
} 