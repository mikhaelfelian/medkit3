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
                        <h3 class="card-title">Edit Data Merk</h3>
                        <div class="card-tools">
                            <a href="<?= BaseRouting::url('merk') ?>" class="btn btn-tool">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <form action="<?= BaseRouting::url('merk/update/' . $data->id) ?>" method="POST">
                        <?= BaseForm::csrf() ?>
                        
                        <div class="card-body">
                            <?php Notification::render(); ?>
                            
                            <div class="form-group">
                                <label for="merk">Nama Merk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" id="merk" name="merk" 
                                       value="<?= $data->merk ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control rounded-0" id="keterangan" name="keterangan" 
                                          rows="3"><?= $data->keterangan ?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control rounded-0" id="status" name="status">
                                    <option value="1" <?= $data->status == '1' ? 'selected' : '' ?>>Aktif</option>
                                    <option value="0" <?= $data->status == '0' ? 'selected' : '' ?>>Tidak Aktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="<?= BaseRouting::url('merk') ?>" class="btn btn-default rounded-0">
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