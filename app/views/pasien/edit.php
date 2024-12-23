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
                    <h1>Edit Pasien</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo BaseRouting::url(''); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo BaseRouting::url('pasien'); ?>">Data Pasien</a></li>
                        <li class="breadcrumb-item active">Edit Pasien</li>
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
                    <h3 class="card-title">Form Edit Pasien</h3>
                </div>
                <form action="<?php echo BaseRouting::url('pasien/update/' . $data->id); ?>" method="POST">
                    <?php $form = BaseForm::getInstance(); ?>
                    <?php echo $form->csrf(); ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No. RM</label>
                                    <input type="text" class="form-control" value="<?php echo $data->kode; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="nik">NIK <span class="text-danger">*</span></label>
                                    <input type="text" name="nik" id="nik" 
                                           class="form-control <?php echo $form->inputClass('nik'); ?>"
                                           value="<?php echo $form->old('nik', $data->nik); ?>" 
                                           placeholder="Masukkan NIK"
                                           required>
                                    <?php if ($form->hasError('nik')): ?>
                                        <div class="invalid-feedback"><?php echo $form->error('nik'); ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" id="nama" 
                                           class="form-control <?php echo $form->inputClass('nama'); ?>"
                                           value="<?php echo $form->old('nama', $data->nama); ?>" 
                                           placeholder="Masukkan Nama Lengkap"
                                           required>
                                    <?php if ($form->hasError('nama')): ?>
                                        <div class="invalid-feedback"><?php echo $form->error('nama'); ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="nama_pgl">Nama Panggilan</label>
                                    <input type="text" name="nama_pgl" id="nama_pgl" 
                                           class="form-control"
                                           value="<?php echo $form->old('nama_pgl', $data->nama_pgl); ?>" 
                                           placeholder="Masukkan Nama Panggilan">
                                </div>
                                <div class="form-group">
                                    <label for="no_hp">No HP</label>
                                    <input type="text" name="no_hp" id="no_hp" 
                                           class="form-control"
                                           value="<?php echo $form->old('no_hp', $data->no_hp); ?>" 
                                           placeholder="Masukkan No HP">
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                    <textarea name="alamat" id="alamat" 
                                              class="form-control <?php echo $form->inputClass('alamat'); ?>"
                                              rows="3" 
                                              placeholder="Masukkan Alamat"
                                              required><?php echo $form->old('alamat', $data->alamat); ?></textarea>
                                    <?php if ($form->hasError('alamat')): ?>
                                        <div class="invalid-feedback"><?php echo $form->error('alamat'); ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="alamat_domisili">Alamat Domisili</label>
                                    <textarea name="alamat_domisili" id="alamat_domisili" 
                                              class="form-control"
                                              rows="3" 
                                              placeholder="Masukkan Alamat Domisili"><?php echo $form->old('alamat_domisili', $data->alamat_domisili); ?></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rt">RT</label>
                                            <input type="text" name="rt" id="rt" 
                                                   class="form-control"
                                                   value="<?php echo $form->old('rt', $data->rt); ?>" 
                                                   placeholder="RT">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rw">RW</label>
                                            <input type="text" name="rw" id="rw" 
                                                   class="form-control"
                                                   value="<?php echo $form->old('rw', $data->rw); ?>" 
                                                   placeholder="RW">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kelurahan">Kelurahan</label>
                                    <input type="text" name="kelurahan" id="kelurahan" 
                                           class="form-control"
                                           value="<?php echo $form->old('kelurahan', $data->kelurahan); ?>" 
                                           placeholder="Masukkan Kelurahan">
                                </div>
                                <div class="form-group">
                                    <label for="kecamatan">Kecamatan</label>
                                    <input type="text" name="kecamatan" id="kecamatan" 
                                           class="form-control"
                                           value="<?php echo $form->old('kecamatan', $data->kecamatan); ?>" 
                                           placeholder="Masukkan Kecamatan">
                                </div>
                                <div class="form-group">
                                    <label for="kota">Kota</label>
                                    <input type="text" name="kota" id="kota" 
                                           class="form-control"
                                           value="<?php echo $form->old('kota', $data->kota); ?>" 
                                           placeholder="Masukkan Kota">
                                </div>
                                <div class="form-group">
                                    <label for="pekerjaan">Pekerjaan</label>
                                    <input type="text" name="pekerjaan" id="pekerjaan" 
                                           class="form-control"
                                           value="<?php echo $form->old('pekerjaan', $data->pekerjaan); ?>" 
                                           placeholder="Masukkan Pekerjaan">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?php echo BaseRouting::url('pasien'); ?>" class="btn btn-default">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div> 