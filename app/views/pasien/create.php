<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><?= $title ?></h1>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Data Pasien</h3>
                        <div class="card-tools">
                            <a href="<?= BaseRouting::url('pasien') ?>" class="btn btn-tool">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <form action="<?= BaseRouting::url('pasien/store') ?>" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        
                        <div class="card-body">
                            <?php Notification::render(); ?>
                            
                            <div class="form-group">
                                <label for="nik">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik" maxlength="16">
                            </div>
                            
                            <div class="form-group">
                                <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="nama_pgl">Nama Panggilan</label>
                                <input type="text" class="form-control" id="nama_pgl" name="nama_pgl">
                            </div>
                            
                            <div class="form-group">
                                <label for="no_hp">No HP</label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp">
                            </div>
                            
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="alamat_domisili">Alamat Domisili</label>
                                <textarea class="form-control" id="alamat_domisili" name="alamat_domisili" rows="3"></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rt">RT</label>
                                        <input type="text" class="form-control" id="rt" name="rt" maxlength="3">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rw">RW</label>
                                        <input type="text" class="form-control" id="rw" name="rw" maxlength="3">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="kelurahan">Kelurahan</label>
                                        <input type="text" class="form-control" id="kelurahan" name="kelurahan">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kecamatan">Kecamatan</label>
                                        <input type="text" class="form-control" id="kecamatan" name="kecamatan">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kota">Kota</label>
                                        <input type="text" class="form-control" id="kota" name="kota">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="pekerjaan">Pekerjaan</label>
                                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="<?= BaseRouting::url('pasien') ?>" class="btn btn-default">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> 