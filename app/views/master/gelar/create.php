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
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('gelar') ?>">Data Gelar</a></li>
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
            <form action="<?= BaseRouting::url('gelar/store') ?>" method="POST">
                <?= BaseForm::csrf() ?>
                <div class="card-body">
                    <div class="form-group">
                        <label for="gelar">Gelar</label>
                        <input type="text" class="form-control rounded-0 <?= isset($errors['gelar']) ? 'is-invalid' : '' ?>" 
                            id="gelar" name="gelar" value="<?= $data['gelar'] ?? '' ?>">
                        <?php if (isset($errors['gelar'])): ?>
                            <div class="invalid-feedback"><?= $errors['gelar'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control rounded-0 <?= isset($errors['keterangan']) ? 'is-invalid' : '' ?>" 
                            id="keterangan" name="keterangan" rows="3"><?= $data['keterangan'] ?? '' ?></textarea>
                        <?php if (isset($errors['keterangan'])): ?>
                            <div class="invalid-feedback"><?= $errors['keterangan'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?= BaseRouting::url('gelar') ?>" class="btn btn-default rounded-0">
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