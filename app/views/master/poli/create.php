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
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('poli') ?>">Data Poli</a></li>
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
            <form action="<?= BaseRouting::url('poli/store') ?>" method="POST">
                <?= BaseSecurity::getInstance()->csrfField() ?>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode</label>
                                <input type="text" class="form-control rounded-0" value="<?= $this->model->generateKode() ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nama Poli <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" name="poli" required 
                                       placeholder="Masukkan nama poli...">
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea class="form-control rounded-0" name="keterangan" rows="3" 
                                          placeholder="Masukkan keterangan..."></textarea>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="status1" name="status" class="custom-control-input" 
                                               value="1" checked>
                                        <label class="custom-control-label" for="status1">Aktif</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="status0" name="status" class="custom-control-input" 
                                               value="0">
                                        <label class="custom-control-label" for="status0">Non-Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        <div class="card-footer text-right">
                            <a href="<?= BaseRouting::url('poli') ?>" class="btn btn-default rounded-0 float-left">
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