<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><?= $title ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('karyawan') ?>">Data Karyawan</a></li>
                    <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <?= Notification::render() ?>
        
        <div class="card rounded-0">
            <form action="<?= BaseRouting::url('karyawan/store') ?>" method="POST">
                <?= BaseSecurity::getInstance()->csrfField() ?>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Basic Information -->
                            <div class="form-group">
                                <label>Kode</label>
                                <input type="text" class="form-control rounded-0" value="<?= $this->model->generateKode() ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>NIK <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" name="nik" required maxlength="16" 
                                       placeholder="Masukkan NIK...">
                            </div>
                            <div class="form-group">
                                <label>Unit/Poli</label>
                                <select name="id_poli" class="form-control rounded-0">
                                    <option value="">Pilih Unit/Poli</option>
                                    <?php foreach ($poli_list as $poli): ?>
                                        <option value="<?= $poli->id ?>"><?= $poli->poli ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control rounded-0" required>
                                    <option value="">Pilih Status</option>
                                    <option value="1">Perawat</option>
                                    <option value="2">Dokter</option>
                                    <option value="3">Kasir</option>
                                    <option value="4">Analis</option>
                                    <option value="5">Radiografer</option>
                                    <option value="6">Farmasi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jabatan</label>
                                <input type="text" class="form-control rounded-0" name="jabatan" 
                                       placeholder="Masukkan jabatan...">
                            </div>
                            
                            <!-- Professional Information -->
                            <div class="form-group">
                                <label>SIP</label>
                                <input type="text" class="form-control rounded-0" name="sip" 
                                       placeholder="Masukkan nomor SIP...">
                            </div>
                            <div class="form-group">
                                <label>STR</label>
                                <input type="text" class="form-control rounded-0" name="str" 
                                       placeholder="Masukkan nomor STR...">
                            </div>
                            <div class="form-group">
                                <label>No. Ijin</label>
                                <input type="text" class="form-control rounded-0" name="no_ijin" 
                                       placeholder="Masukkan nomor ijin...">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <!-- Personal Information -->
                            <div class="form-group">
                                <label>Nama Depan</label>
                                <input type="text" class="form-control rounded-0" name="nama_dpn" 
                                       placeholder="Masukkan nama depan...">
                            </div>
                            <div class="form-group">
                                <label>Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" name="nama" required 
                                       placeholder="Masukkan nama...">
                            </div>
                            <div class="form-group">
                                <label>Nama Belakang</label>
                                <input type="text" class="form-control rounded-0" name="nama_blk" 
                                       placeholder="Masukkan nama belakang...">
                            </div>
                            <div class="form-group">
                                <label>Nama Panggilan</label>
                                <input type="text" class="form-control rounded-0" name="nama_pgl" 
                                       placeholder="Masukkan nama panggilan...">
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jns_klm" class="form-control rounded-0" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tempat Lahir</label>
                                <input type="text" class="form-control rounded-0" name="tmp_lahir" 
                                       placeholder="Masukkan tempat lahir...">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" class="form-control rounded-0" name="tgl_lahir">
                            </div>
                            <div class="form-group">
                                <label>No. HP</label>
                                <input type="text" class="form-control rounded-0" name="no_hp" 
                                       placeholder="Masukkan nomor HP...">
                            </div>
                            
                            <!-- Address Information -->
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control rounded-0" name="alamat" rows="2" 
                                          placeholder="Masukkan alamat..."></textarea>
                            </div>
                            <div class="form-group">
                                <label>Alamat Domisili</label>
                                <textarea class="form-control rounded-0" name="alamat_domisili" rows="2" 
                                          placeholder="Masukkan alamat domisili..."></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>RT</label>
                                        <input type="text" class="form-control rounded-0" name="rt" maxlength="3" 
                                               placeholder="RT...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>RW</label>
                                        <input type="text" class="form-control rounded-0" name="rw" maxlength="3" 
                                               placeholder="RW...">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Kelurahan</label>
                                <input type="text" class="form-control rounded-0" name="kelurahan" 
                                       placeholder="Masukkan kelurahan...">
                            </div>
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <input type="text" class="form-control rounded-0" name="kecamatan" 
                                       placeholder="Masukkan kecamatan...">
                            </div>
                            <div class="form-group">
                                <label>Kota</label>
                                <input type="text" class="form-control rounded-0" name="kota" 
                                       placeholder="Masukkan kota...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="<?= BaseRouting::url('karyawan') ?>" class="btn btn-default rounded-0 float-left">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary rounded-0">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</section> 