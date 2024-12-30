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
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('satuan') ?>">Data Satuan</a></li>
                    <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card rounded-0">
            <form action="<?= BaseRouting::url('satuan/store') ?>" method="POST">
                <?= BaseSecurity::getInstance()->csrfField() ?>
                <div class="card-body">
                    <?php Notification::render() ?>
                    
                    <div class="form-group">
                        <label for="satuanKecil">Satuan Kecil <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-0" id="satuanKecil" name="satuanKecil" 
                               value="<?= $this->input->post('satuanKecil') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="satuanBesar">Satuan Besar</label>
                        <input type="text" class="form-control rounded-0" id="satuanBesar" name="satuanBesar"
                               value="<?= $this->input->post('satuanBesar') ?>">
                    </div>

                    <div class="form-group">
                        <label for="jml">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" class="form-control rounded-0" id="jml" name="jml" 
                               value="<?= $this->input->post('jml') ?>" required min="1">
                        <small class="text-muted">Jumlah satuan kecil dalam 1 satuan besar</small>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="status1" name="status" 
                                   value="1" checked>
                            <label for="status1" class="custom-control-label">Aktif</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="status0" name="status" 
                                   value="0">
                            <label for="status0" class="custom-control-label">Non Aktif</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?= BaseRouting::url('satuan') ?>" class="btn btn-default rounded-0">
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
</section> 