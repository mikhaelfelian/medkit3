<?php
$form = BaseForm::getInstance();
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Pasien</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BaseRouting::url('') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= BaseRouting::url('pasien') ?>">Data Pasien</a></li>
                        <li class="breadcrumb-item active">Tambah Pasien</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Flash Messages -->
            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Pasien</h3>
                </div>
                <form action="<?= BaseRouting::url('pasien/store') ?>" method="POST">
                    <?= $form->csrfField() ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik">NIK <span class="text-danger">*</span></label>
                                    <?= $form->input('text', 'nik', '', [
                                        'class' => 'form-control',
                                        'id' => 'nik',
                                        'maxlength' => 16,
                                        'required' => true,
                                        'placeholder' => 'Masukkan NIK'
                                    ]) ?>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama <span class="text-danger">*</span></label>
                                    <?= $form->input('text', 'nama', '', [
                                        'class' => 'form-control',
                                        'id' => 'nama',
                                        'required' => true,
                                        'placeholder' => 'Masukkan Nama Lengkap'
                                    ]) ?>
                                </div>
                                <div class="form-group">
                                    <label for="nama_pgl">Nama Panggilan</label>
                                    <?= $form->input('text', 'nama_pgl', '', [
                                        'class' => 'form-control',
                                        'id' => 'nama_pgl',
                                        'placeholder' => 'Masukkan Nama Panggilan'
                                    ]) ?>
                                </div>
                                <div class="form-group">
                                    <label for="no_hp">No HP</label>
                                    <?= $form->input('text', 'no_hp', '', [
                                        'class' => 'form-control',
                                        'id' => 'no_hp',
                                        'placeholder' => 'Masukkan No HP'
                                    ]) ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                    <?= $form->textarea('alamat', '', [
                                        'class' => 'form-control',
                                        'id' => 'alamat',
                                        'rows' => 3,
                                        'required' => true,
                                        'placeholder' => 'Masukkan Alamat'
                                    ]) ?>
                                </div>
                                <div class="form-group">
                                    <label for="alamat_domisili">Alamat Domisili</label>
                                    <?= $form->textarea('alamat_domisili', '', [
                                        'class' => 'form-control',
                                        'id' => 'alamat_domisili',
                                        'rows' => 3,
                                        'placeholder' => 'Masukkan Alamat Domisili'
                                    ]) ?>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rt">RT</label>
                                            <?= $form->input('text', 'rt', '', [
                                                'class' => 'form-control',
                                                'id' => 'rt',
                                                'maxlength' => 3,
                                                'placeholder' => 'RT'
                                            ]) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rw">RW</label>
                                            <?= $form->input('text', 'rw', '', [
                                                'class' => 'form-control',
                                                'id' => 'rw',
                                                'maxlength' => 3,
                                                'placeholder' => 'RW'
                                            ]) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kelurahan">Kelurahan</label>
                                    <?= $form->input('text', 'kelurahan', '', [
                                        'class' => 'form-control',
                                        'id' => 'kelurahan',
                                        'placeholder' => 'Masukkan Kelurahan'
                                    ]) ?>
                                </div>
                                <div class="form-group">
                                    <label for="kecamatan">Kecamatan</label>
                                    <?= $form->input('text', 'kecamatan', '', [
                                        'class' => 'form-control',
                                        'id' => 'kecamatan',
                                        'placeholder' => 'Masukkan Kecamatan'
                                    ]) ?>
                                </div>
                                <div class="form-group">
                                    <label for="kota">Kota</label>
                                    <?= $form->input('text', 'kota', '', [
                                        'class' => 'form-control',
                                        'id' => 'kota',
                                        'placeholder' => 'Masukkan Kota'
                                    ]) ?>
                                </div>
                                <div class="form-group">
                                    <label for="pekerjaan">Pekerjaan</label>
                                    <?= $form->input('text', 'pekerjaan', '', [
                                        'class' => 'form-control',
                                        'id' => 'pekerjaan',
                                        'placeholder' => 'Masukkan Pekerjaan'
                                    ]) ?>
                                </div>
                            </div>
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
            </div>
        </div>
    </section>
</div> 