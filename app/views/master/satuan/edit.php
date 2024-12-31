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
        <div class="card">
            <form action="<?= BaseRouting::url('satuan/update/' . $data->id) ?>" method="POST">
                <?= $form->csrf() ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Satuan Kecil</label>
                                <input type="text" class="form-control rounded-0" name="satuanKecil" 
                                       value="<?= $data->satuanKecil ?? '' ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Satuan Besar</label>
                                <input type="text" class="form-control rounded-0" name="satuanBesar"
                                       value="<?= $data->satuanBesar ?? '' ?>">
                            </div>
                            <div class="form-group">
                                <label>Jumlah</label>
                                <input type="number" class="form-control rounded-0" name="jml"
                                       value="<?= $data->jml ?? '' ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="status1" name="status" class="custom-control-input" 
                                               value="1" <?= ($data->status ?? '') == '1' ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="status1">Aktif</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="status0" name="status" class="custom-control-input" 
                                               value="0" <?= ($data->status ?? '') == '0' ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="status0">Non-Aktif</label>
                                    </div>
                                </div>
                            </div>
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
                                <i class="fas fa-save mr-2"></i>Update
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section> 