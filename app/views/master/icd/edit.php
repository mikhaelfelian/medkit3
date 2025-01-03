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
                        <h3 class="card-title">Edit Data ICD</h3>
                        <div class="card-tools">
                            <a href="<?= BaseRouting::url('icd') ?>" class="btn btn-tool">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <form action="<?= BaseRouting::url('icd/update/' . $data->id) ?>" method="POST">
                        <?= BaseForm::csrf() ?>
                        
                        <div class="card-body">
                            <?php Notification::render(); ?>
                            
                            <div class="form-group">
                                <label for="kode">Kode <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" id="kode" name="kode" 
                                       value="<?= $data->kode ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="icd">ICD <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" id="icd" name="icd" 
                                       value="<?= $data->icd ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="diagnosa_en">Diagnosa (EN)</label>
                                <textarea class="form-control rounded-0" id="diagnosa_en" name="diagnosa_en" 
                                          rows="3"><?= $data->diagnosa_en ?></textarea>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="<?= BaseRouting::url('icd') ?>" class="btn btn-default rounded-0">
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