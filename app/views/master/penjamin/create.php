<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?= $title ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('penjamin') ?>">Data Penjamin</a></li>
                    <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card rounded-0">
            <form action="<?= BaseRouting::url('penjamin/store') ?>" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                
                <div class="card-body">
                    <?= Notification::render() ?>
                    
                    <div class="form-group">
                        <label for="penjamin">Nama Penjamin <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-0" id="penjamin" name="penjamin" 
                               value="<?= $this->input->post('penjamin') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="persen">Persentase <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control rounded-0" id="persen" name="persen" 
                                   value="<?= $this->input->post('persen') ?>" required min="0" max="100" step="0.1">
                            <div class="input-group-append">
                                <span class="input-group-text rounded-0">%</span>
                            </div>
                        </div>
                        <small class="text-muted">Masukkan angka antara 0 - 100</small>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="status1" name="status" 
                                   value="1" <?= $this->input->post('status') === '1' ? 'checked' : '' ?>>
                            <label for="status1" class="custom-control-label">Aktif</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="status0" name="status" 
                                   value="0" <?= $this->input->post('status') === '0' ? 'checked' : 'checked' ?>>
                            <label for="status0" class="custom-control-label">Non-Aktif</label>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?= BaseRouting::url('penjamin') ?>" class="btn btn-default rounded-0">
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