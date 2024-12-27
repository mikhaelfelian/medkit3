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
                <div class="card rounded-0">
                    <div class="card-header">
                        <h3 class="card-title">Edit Data Pasien</h3>
                        <div class="card-tools">
                            <a href="<?= BaseRouting::url('pasien') ?>" class="btn btn-tool">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <form action="<?= BaseRouting::url('pasien/update/' . $data->id) ?>" method="POST">
                        <?= BaseForm::csrf() ?>
                        
                        <div class="card-body">
                            <?php Notification::render(); ?>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nik">NIK</label>
                                        <input type="text" class="form-control rounded-0" id="nik" name="nik" 
                                               value="<?= $data->nik ?>" maxlength="16">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control rounded-0" id="nama" name="nama" 
                                               value="<?= $data->nama ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_pgl">Nama Panggilan</label>
                                        <input type="text" class="form-control rounded-0" id="nama_pgl" name="nama_pgl" 
                                               value="<?= $data->nama_pgl ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_hp">No HP</label>
                                        <input type="text" class="form-control rounded-0" id="no_hp" name="no_hp" 
                                               value="<?= $data->no_hp ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control rounded-0" id="alamat" name="alamat" 
                                          rows="3"><?= $data->alamat ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="alamat_domisili">Alamat Domisili</label>
                                <textarea class="form-control rounded-0" id="alamat_domisili" name="alamat_domisili" 
                                          rows="3"><?= $data->alamat_domisili ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rt">RT</label>
                                        <input type="text" class="form-control rounded-0" id="rt" name="rt" 
                                               value="<?= $data->rt ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rw">RW</label>
                                        <input type="text" class="form-control rounded-0" id="rw" name="rw" 
                                               value="<?= $data->rw ?>">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="kelurahan">Kelurahan</label>
                                        <input type="text" class="form-control rounded-0" id="kelurahan" name="kelurahan" 
                                               value="<?= $data->kelurahan ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kecamatan">Kecamatan</label>
                                        <input type="text" class="form-control rounded-0" id="kecamatan" name="kecamatan" 
                                               value="<?= $data->kecamatan ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kota">Kota</label>
                                        <input type="text" class="form-control rounded-0" id="kota" name="kota" 
                                               value="<?= $data->kota ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="pekerjaan">Pekerjaan</label>
                                <input type="text" class="form-control rounded-0" id="pekerjaan" name="pekerjaan" 
                                       value="<?= $data->pekerjaan ?>">
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="<?= BaseRouting::url('pasien') ?>" class="btn btn-default rounded-0">
                                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-primary rounded-0">
                                        <i class="fas fa-save mr-2"></i>Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> 