<?php
$form = BaseForm::getInstance();
?>

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
                    <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <?= Notification::render() ?>
        <div class="card rounded-0">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <form action="<?= BaseRouting::url('pengaturan/update') ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                
                <div class="card-body">
                    <div class="form-group">
                        <label for="judul">Judul</label>
                        <input type="text" class="form-control rounded-0" id="judul" name="judul" 
                            value="<?= htmlspecialchars($data->judul ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="judul_app">Judul Aplikasi</label>
                        <input type="text" class="form-control rounded-0" id="judul_app" name="judul_app" 
                            value="<?= htmlspecialchars($data->judul_app ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control rounded-0" id="alamat" name="alamat" rows="3"><?= htmlspecialchars($data->alamat ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control rounded-0" id="deskripsi" name="deskripsi" rows="3"><?= htmlspecialchars($data->deskripsi ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="kota">Kota</label>
                        <input type="text" class="form-control rounded-0" id="kota" name="kota" 
                            value="<?= htmlspecialchars($data->kota ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="url">URL</label>
                        <input type="url" class="form-control rounded-0" id="url" name="url" 
                            value="<?= htmlspecialchars($data->url ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="theme">Theme</label>
                        <select class="form-control rounded-0" id="theme" name="theme">
                            <option value="default" <?= ($data->theme ?? '') == 'default' ? 'selected' : '' ?>>Default</option>
                            <option value="dark" <?= ($data->theme ?? '') == 'dark' ? 'selected' : '' ?>>Dark</option>
                            <option value="light" <?= ($data->theme ?? '') == 'light' ? 'selected' : '' ?>>Light</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pagination_limit">Pagination Limit</label>
                        <input type="number" class="form-control rounded-0" id="pagination_limit" name="pagination_limit" 
                            value="<?= htmlspecialchars($data->pagination_limit ?? '10') ?>" min="1">
                    </div>

                    <div class="form-group">
                        <label for="favicon">Favicon</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input rounded-0" id="favicon" name="favicon" accept="image/*">
                                <label class="custom-file-label rounded-0" for="favicon">Choose file</label>
                            </div>
                        </div>
                        <?php if (!empty($data->favicon)): ?>
                            <img src="<?= BaseRouting::url($data->favicon) ?>" alt="Current Favicon" class="mt-2" style="max-height: 50px;">
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input rounded-0" id="logo" name="logo" accept="image/*">
                                <label class="custom-file-label rounded-0" for="logo">Choose file</label>
                            </div>
                        </div>
                        <?php if (!empty($data->logo)): ?>
                            <img src="<?= BaseRouting::url($data->logo) ?>" alt="Current Logo" class="mt-2" style="max-height: 100px;">
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="logo_header">Logo Header</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input rounded-0" id="logo_header" name="logo_header" accept="image/*">
                                <label class="custom-file-label rounded-0" for="logo_header">Choose file</label>
                            </div>
                        </div>
                        <?php if (!empty($data->logo_header)): ?>
                            <img src="<?= BaseRouting::url($data->logo_header) ?>" alt="Current Header Logo" class="mt-2" style="max-height: 100px;">
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary rounded-0">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    // File input handling
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
});
</script>