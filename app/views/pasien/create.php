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
                        <li class="breadcrumb-item"><a href="<?php echo BaseRouting::url(''); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo BaseRouting::url('pasien'); ?>">Data Pasien</a></li>
                        <li class="breadcrumb-item active">Tambah Pasien</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?php echo Notification::render(); ?>

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Pasien</h3>
                </div>
                <?php echo $form->open(BaseRouting::url('pasien/store'), 'POST'); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nik">NIK <span class="text-danger">*</span></label>
                                <?php echo $form->input('text', 'nik', '', [
                                    'id' => 'nik',
                                    'required' => true
                                ]); ?>
                                <?php if ($form->hasError('nik')): ?>
                                    <div class="invalid-feedback"><?php echo $form->getError('nik'); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama <span class="text-danger">*</span></label>
                                <?php echo $form->input('text', 'nama', '', [
                                    'id' => 'nama',
                                    'required' => true
                                ]); ?>
                                <?php if ($form->hasError('nama')): ?>
                                    <div class="invalid-feedback"><?php echo $form->getError('nama'); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="nama_pgl">Nama Panggilan</label>
                                <?php echo $form->input('text', 'nama_pgl', '', [
                                    'id' => 'nama_pgl'
                                ]); ?>
                            </div>
                            <div class="form-group">
                                <label for="no_hp">No HP</label>
                                <?php echo $form->input('text', 'no_hp', '', [
                                    'id' => 'no_hp'
                                ]); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                <?php echo $form->textarea('alamat', '', [
                                    'id' => 'alamat',
                                    'rows' => 3,
                                    'required' => true
                                ]); ?>
                                <?php if ($form->hasError('alamat')): ?>
                                    <div class="invalid-feedback"><?php echo $form->getError('alamat'); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="alamat_domisili">Alamat Domisili</label>
                                <?php echo $form->textarea('alamat_domisili', '', [
                                    'id' => 'alamat_domisili',
                                    'rows' => 3
                                ]); ?>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rt">RT</label>
                                        <?php echo $form->input('text', 'rt', '', [
                                            'id' => 'rt'
                                        ]); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rw">RW</label>
                                        <?php echo $form->input('text', 'rw', '', [
                                            'id' => 'rw'
                                        ]); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="kelurahan">Kelurahan</label>
                                <?php echo $form->input('text', 'kelurahan', '', [
                                    'id' => 'kelurahan'
                                ]); ?>
                            </div>
                            <div class="form-group">
                                <label for="kecamatan">Kecamatan</label>
                                <?php echo $form->input('text', 'kecamatan', '', [
                                    'id' => 'kecamatan'
                                ]); ?>
                            </div>
                            <div class="form-group">
                                <label for="kota">Kota</label>
                                <?php echo $form->input('text', 'kota', '', [
                                    'id' => 'kota'
                                ]); ?>
                            </div>
                            <div class="form-group">
                                <label for="pekerjaan">Pekerjaan</label>
                                <?php echo $form->input('text', 'pekerjaan', '', [
                                    'id' => 'pekerjaan'
                                ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?php echo BaseRouting::url('pasien'); ?>" class="btn btn-default">Batal</a>
                </div>
                <?php echo $form->close(); ?>
            </div>
        </div>
    </section>
</div> 