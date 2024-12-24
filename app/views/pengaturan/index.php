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
                    <h1>Pengaturan Aplikasi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BaseRouting::url('') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Pengaturan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?= Notification::render() ?>
            
            <div class="card">
                <?= $form->open(BaseRouting::url('pengaturan/update'), 'POST', ['enctype' => 'multipart/form-data']) ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="judul">Judul</label>
                                <?= $form->input('text', 'judul', $data->judul ?? '', ['class' => 'form-control']) ?>
                                <?php if ($form->hasError('judul')): ?>
                                    <div class="invalid-feedback"><?= $form->getError('judul') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="judul_app">Judul Aplikasi</label>
                                <?= $form->input('text', 'judul_app', $data->judul_app ?? '', ['required' => true]) ?>
                                <?php if ($form->hasError('judul_app')): ?>
                                    <div class="invalid-feedback"><?= $form->getError('judul_app') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <?= $form->textarea('alamat', $data->alamat ?? '', ['rows' => 3]) ?>
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <?= $form->textarea('deskripsi', $data->deskripsi ?? '', ['rows' => 3]) ?>
                            </div>

                            <div class="form-group">
                                <label for="kota">Kota</label>
                                <?= $form->input('text', 'kota', $data->kota ?? '') ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="url">URL</label>
                                <?= $form->input('url', 'url', $data->url ?? '') ?>
                            </div>

                            <div class="form-group">
                                <label for="theme">Theme</label>
                                <?= $form->select('theme', [
                                    'default' => 'Default',
                                    'dark' => 'Dark',
                                    'light' => 'Light'
                                ], $data->theme ?? 'default') ?>
                            </div>

                            <div class="form-group">
                                <label for="pagination_limit">Batas Pagination</label>
                                <?= $form->input('number', 'pagination_limit', $data->pagination_limit ?? 10, [
                                    'min' => 5,
                                    'max' => 100
                                ]) ?>
                            </div>

                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <div class="custom-file">
                                    <?= $form->input('file', 'logo', '', [
                                        'class' => 'custom-file-input',
                                        'accept' => 'image/*'
                                    ]) ?>
                                    <label class="custom-file-label">Choose file</label>
                                </div>
                                <?php if (!empty($data->logo)): ?>
                                    <img src="<?= BaseRouting::url($data->logo) ?>" alt="Current Logo" class="mt-2" style="max-height: 50px;">
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="favicon">Favicon</label>
                                <div class="custom-file">
                                    <?= $form->input('file', 'favicon', '', [
                                        'class' => 'custom-file-input',
                                        'accept' => 'image/*'
                                    ]) ?>
                                    <label class="custom-file-label">Choose file</label>
                                </div>
                                <?php if (!empty($data->favicon)): ?>
                                    <img src="<?= BaseRouting::url($data->favicon) ?>" alt="Current Favicon" class="mt-2" style="max-height: 32px;">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                <?= $form->close() ?>
            </div>
        </div>
    </section>
</div>

<!-- bs-custom-file-input -->
<script>
$(function() {
    bsCustomFileInput.init();
});
</script> 