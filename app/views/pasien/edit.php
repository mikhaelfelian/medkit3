<?php
/**
 * Pasien Edit View
 * 
 * @package NUSANTARA HMVC
 */
$form = BaseForm::getInstance();
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Pasien</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <?= Notification::render() ?>
            <div class="card">
                <?= $form->open(BaseRouting::url('pasien/update/' . $data->id), 'POST') ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nik">NIK</label>
                                <?= $form->input('text', 'nik', $data->nik ?? '', [
                                    'id' => 'nik',
                                    'required' => true
                                ]) ?>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <?= $form->input('text', 'nama', $data->nama ?? '', [
                                    'id' => 'nama',
                                    'required' => true
                                ]) ?>
                            </div>
                            <div class="form-group">
                                <label for="nama_pgl">Nama Panggilan</label>
                                <?= $form->input('text', 'nama_pgl', $data->nama_pgl ?? '', [
                                    'id' => 'nama_pgl'
                                ]) ?>
                            </div>
                            <div class="form-group">
                                <label for="no_hp">No. HP</label>
                                <?= $form->input('text', 'no_hp', $data->no_hp ?? '', [
                                    'id' => 'no_hp'
                                ]) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <?= $form->textarea('alamat', $data->alamat ?? '', [
                                    'id' => 'alamat',
                                    'rows' => 3,
                                    'required' => true
                                ]) ?>
                            </div>
                            <div class="form-group">
                                <label for="alamat_domisili">Alamat Domisili</label>
                                <?= $form->textarea('alamat_domisili', $data->alamat_domisili ?? '', [
                                    'id' => 'alamat_domisili',
                                    'rows' => 3
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= BaseRouting::url('pasien') ?>" class="btn btn-default">Batal</a>
                </div>
                <?= $form->close() ?>
            </div>
        </div>
    </section>
</div> 