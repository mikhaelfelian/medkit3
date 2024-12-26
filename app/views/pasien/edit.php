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
                        <h3 class="card-title">Edit Data Pasien</h3>
                        <div class="card-tools">
                            <a href="<?= BaseRouting::url('pasien') ?>" class="btn btn-tool">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <form action="<?= BaseRouting::url('pasien/update/' . $data->id) ?>" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        
                        <div class="card-body">
                            <?php Notification::render(); ?>
                            
                            <div class="form-group">
                                <label>Kode</label>
                                <input type="text" class="form-control" value="<?= $data->kode ?>" readonly>
                            </div>
                            
                            <div class="form-group">
                                <label for="nik">NIK</label>
                                <input type="text" class="form-control rounded-0" id="nik" name="nik" value="<?= htmlspecialchars((string)$data->nik) ?>" maxlength="16">
                            </div>
                            
                            <div class="form-group">
                                <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" id="nama" name="nama" value="<?= htmlspecialchars((string)$data->nama) ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="nama_pgl">Nama Panggilan</label>
                                <input type="text" class="form-control rounded-0" id="nama_pgl" name="nama_pgl" value="<?= htmlspecialchars((string)$data->nama_pgl) ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="no_hp">No HP</label>
                                <input type="text" class="form-control rounded-0" id="no_hp" name="no_hp" value="<?= htmlspecialchars((string)$data->no_hp) ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control rounded-0" id="alamat" name="alamat" rows="3"><?= htmlspecialchars((string)$data->alamat) ?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="alamat_domisili">Alamat Domisili</label>
                                <textarea class="form-control rounded-0" id="alamat_domisili" name="alamat_domisili" rows="3"><?= htmlspecialchars((string)$data->alamat_domisili) ?></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rt">RT</label>
                                        <input type="text" class="form-control" id="rt" name="rt" value="<?= $data->rt ?>" maxlength="3">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rw">RW</label>
                                        <input type="text" class="form-control" id="rw" name="rw" value="<?= $data->rw ?>" maxlength="3">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="kelurahan">Kelurahan</label>
                                        <input type="text" class="form-control" id="kelurahan" name="kelurahan" value="<?= $data->kelurahan ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kecamatan">Kecamatan</label>
                                        <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="<?= $data->kecamatan ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kota">Kota</label>
                                        <input type="text" class="form-control" id="kota" name="kota" value="<?= $data->kota ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="pekerjaan">Pekerjaan</label>
                                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="<?= $data->pekerjaan ?>">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="<?= BaseRouting::url('pasien') ?>" class="btn btn-default">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> 