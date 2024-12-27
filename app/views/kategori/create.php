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
                        <h3 class="card-title">Tambah Data Kategori</h3>
                        <div class="card-tools">
                            <a href="<?= BaseRouting::url('kategori') ?>" class="btn btn-tool">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <form action="<?= BaseRouting::url('kategori/store') ?>" method="POST">
                        <?= BaseForm::csrf() ?>
                        
                        <div class="card-body">
                            <?php Notification::render(); ?>
                            
                            <div class="form-group">
                                <label for="kode">Kode <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" id="kode" name="kode" 
                                       value="<?= ViewHelper::loadModel('Kategori')->generateKode() ?>" readonly>
                            </div>
                            
                            <div class="form-group">
                                <label for="kategori">Kategori <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" id="kategori" name="kategori" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control rounded-0" id="keterangan" name="keterangan" 
                                          rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
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
                                    <a href="<?= BaseRouting::url('kategori') ?>" class="btn btn-default rounded-0">
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