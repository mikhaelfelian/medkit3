<?php
// At the top of your view, get form instance
$form = BaseForm::getInstance();
?>

<form action="<?= BaseRouting::url('pasien/store') ?>" method="POST">
    <?= BaseSecurity::getInstance()->csrfField() ?>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>NIK</label>
                <?= $form->input('text', 'nik', '', ['maxlength' => 16, 'required' => true]) ?>
            </div>
            <div class="form-group">
                <label>Nama</label>
                <?= $form->input('text', 'nama', '', ['required' => true]) ?>
            </div>
            <div class="form-group">
                <label>Nama Panggilan</label>
                <?= $form->input('text', 'nama_pgl') ?>
            </div>
            <div class="form-group">
                <label>No HP</label>
                <?= $form->input('text', 'no_hp') ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Alamat</label>
                <?= $form->textarea('alamat', '', ['rows' => 3, 'required' => true]) ?>
            </div>
            <div class="form-group">
                <label>Alamat Domisili</label>
                <?= $form->textarea('alamat_domisili', '', ['rows' => 3]) ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>RT</label>
                        <?= $form->input('text', 'rt', '', ['maxlength' => 3]) ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>RW</label>
                        <?= $form->input('text', 'rw', '', ['maxlength' => 3]) ?>
                    </div>
                </div>
            </div>
            <!-- ... other fields ... -->
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan
        </button>
        <a href="<?= BaseRouting::url('pasien') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</form> 