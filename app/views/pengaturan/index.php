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
                        <li class="breadcrumb-item"><a href="<?php echo BaseRouting::url(''); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Pengaturan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?php echo Notification::render(); ?>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Pengaturan</h3>
                </div>
                <form action="<?php echo BaseRouting::url('pengaturan/update'); ?>" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="judul_app">Nama Aplikasi</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="judul_app" 
                                   name="judul_app" 
                                   value="<?php echo $data->judul_app ?? ''; ?>" 
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="3"><?php echo $data->deskripsi ?? ''; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" 
                                           class="custom-file-input" 
                                           id="logo" 
                                           name="logo" 
                                           accept="image/*">
                                    <label class="custom-file-label" for="logo">Choose file</label>
                                </div>
                            </div>
                            <?php if (!empty($data->logo)): ?>
                                <img src="<?php echo BaseRouting::asset($data->logo); ?>" 
                                     alt="Current Logo" 
                                     class="mt-2" 
                                     style="max-height: 100px;">
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="favicon">Favicon</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" 
                                           class="custom-file-input" 
                                           id="favicon" 
                                           name="favicon" 
                                           accept="image/*">
                                    <label class="custom-file-label" for="favicon">Choose file</label>
                                </div>
                            </div>
                            <?php if (!empty($data->favicon)): ?>
                                <img src="<?php echo BaseRouting::asset($data->favicon); ?>" 
                                     alt="Current Favicon" 
                                     class="mt-2" 
                                     style="max-height: 32px;">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- bs-custom-file-input -->
<script src="<?php echo BaseRouting::asset('theme/admin-lte-3/plugins/bs-custom-file-input/bs-custom-file-input.min.js'); ?>"></script>
<script>
$(function() {
    bsCustomFileInput.init();
});
</script> 