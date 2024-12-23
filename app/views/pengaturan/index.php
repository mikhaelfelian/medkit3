<?php
$form = BaseForm::getInstance();
$data = $data ?? [];
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
            <!-- Flash Messages -->
            <?= Notification::render() ?>
            
            <div class="card">
                <form action="<?= BaseRouting::url('pengaturan/update') ?>" method="POST" enctype="multipart/form-data">
                    <?= $form->csrf() ?>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Judul</label>
                                    <input type="text" 
                                           name="judul" 
                                           class="<?= $form->inputClass('judul') ?>" 
                                           value="<?= $data['judul'] ?? '' ?>">
                                    <?= $form->error('judul') ?>
                                </div>
                                
                                <div class="form-group">
                                    <label>Judul Aplikasi</label>
                                    <input type="text" 
                                           name="judul_app" 
                                           class="<?= $form->inputClass('judul_app') ?>" 
                                           value="<?= $data['judul_app'] ?? '' ?>">
                                    <?= $form->error('judul_app') ?>
                                </div>
                                
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="alamat" 
                                              class="<?= $form->inputClass('alamat') ?>" 
                                              rows="3"><?= $data['alamat'] ?? '' ?></textarea>
                                    <?= $form->error('alamat') ?>
                                </div>
                                
                                <div class="form-group">
                                    <label>Kota</label>
                                    <input type="text" 
                                           name="kota" 
                                           class="<?= $form->inputClass('kota') ?>" 
                                           value="<?= $data['kota'] ?? '' ?>">
                                    <?= $form->error('kota') ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>URL</label>
                                    <input type="text" 
                                           name="url" 
                                           class="<?= $form->inputClass('url') ?>" 
                                           value="<?= $data['url'] ?? '' ?>">
                                    <?= $form->error('url') ?>
                                </div>
                                
                                <div class="form-group">
                                    <label>Theme</label>
                                    <select name="theme" class="<?= $form->inputClass('theme') ?>">
                                        <option value="default" <?= ($data['theme'] ?? '') == 'default' ? 'selected' : '' ?>>Default</option>
                                        <option value="dark" <?= ($data['theme'] ?? '') == 'dark' ? 'selected' : '' ?>>Dark</option>
                                    </select>
                                    <?= $form->error('theme') ?>
                                </div>
                                
                                <div class="form-group">
                                    <label>Pagination Limit</label>
                                    <input type="number" 
                                           name="pagination_limit" 
                                           class="<?= $form->inputClass('pagination_limit') ?>" 
                                           value="<?= $data['pagination_limit'] ?? 10 ?>">
                                    <?= $form->error('pagination_limit') ?>
                                </div>
                                
                                <div class="form-group">
                                    <label>Logo</label>
                                    <div class="custom-file">
                                        <input type="file" 
                                               name="logo" 
                                               class="<?= $form->inputClass('logo', 'custom-file-input') ?>" 
                                               id="logo">
                                        <label class="custom-file-label" for="logo">Choose file</label>
                                    </div>
                                    <?= $form->error('logo') ?>
                                    <?php if (!empty($data['logo'])): ?>
                                        <img src="<?= AssetHelper::custom('img/' . $data['logo']) ?>" 
                                             alt="Logo" 
                                             class="mt-2" 
                                             style="max-height: 50px">
                                    <?php endif; ?>
                                </div>
                                
                                <div class="form-group">
                                    <label>Favicon</label>
                                    <div class="custom-file">
                                        <input type="file" 
                                               name="favicon" 
                                               class="<?= $form->inputClass('favicon', 'custom-file-input') ?>" 
                                               id="favicon">
                                        <label class="custom-file-label" for="favicon">Choose file</label>
                                    </div>
                                    <?= $form->error('favicon') ?>
                                    <?php if (!empty($data['favicon'])): ?>
                                        <img src="<?= AssetHelper::custom('img/' . $data['favicon']) ?>" 
                                             alt="Favicon" 
                                             class="mt-2" 
                                             style="max-height: 32px">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div> 