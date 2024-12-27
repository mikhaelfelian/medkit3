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
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('obat') ?>">Data Obat</a></li>
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
            <div class="card-header rounded-0">
                <h3 class="card-title"><?= $title ?></h3>
                <div class="card-tools">
                    <a href="<?= BaseRouting::url('obat') ?>" class="btn btn-tool">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <form action="<?= $data ? BaseRouting::url('obat/edit/' . $data->id) : BaseRouting::url('obat/add') ?>" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                <div class="card-body rounded-0">
                    <div class="form-group">
                        <label for="id_kategori">Kategori <span class="text-danger">*</span></label>
                        <select name="id_kategori" id="id_kategori" class="form-control select2 rounded-0" required>
                            <option value="">Pilih Kategori</option>
                            <?php
                            $kategoriModel = ViewHelper::loadModel('Kategori');
                            $kategoris = $kategoriModel->getActiveKategoris();
                            
                            // If editing and current kategori is inactive, add it to options
                            $currentKategori = null;
                            if (isset($data) && $data->id_kategori) {
                                $currentKategori = $kategoriModel->find($data->id_kategori);
                                if ($currentKategori && $currentKategori->status != '1') {
                                    // Add the inactive kategori to the list
                                    $kategoris = array_merge([$currentKategori], $kategoris);
                                }
                            }
                            
                            foreach ($kategoris as $kategori):
                                $isInactive = $kategori->status != '1';
                            ?>
                                <option value="<?= $kategori->id ?>" 
                                        <?= isset($data) && $data->id_kategori == $kategori->id ? 'selected' : '' ?>
                                        <?= $isInactive ? 'class="text-danger"' : '' ?>>
                                    <?= $kategori->kode . ' - ' . $kategori->kategori ?>
                                    <?= $isInactive ? ' (Non Aktif)' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($currentKategori) && $currentKategori->status != '1'): ?>
                            <small class="form-text text-danger">
                                Kategori yang dipilih saat ini berstatus non-aktif
                            </small>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="kode">Kode</label>
                        <input type="text" class="form-control rounded-0" id="kode" name="kode"
                            value="<?= $data ? htmlspecialchars($data->kode) : '' ?>" 
                            placeholder="Masukkan kode obat"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="barcode">Barcode</label>
                        <input type="text" class="form-control rounded-0" id="barcode" name="barcode"
                            value="<?= $data ? htmlspecialchars($data->barcode) : '' ?>"
                            placeholder="Masukkan barcode">
                    </div>
                    <div class="form-group">
                        <label for="item">Nama Obat</label>
                        <input type="text" class="form-control rounded-0" id="item" name="item"
                            value="<?= $data ? htmlspecialchars($data->item) : '' ?>"
                            placeholder="Masukkan nama obat"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="item_alias">Nama Alias</label>
                        <input type="text" class="form-control rounded-0" id="item_alias" name="item_alias"
                            value="<?= $data ? htmlspecialchars($data->item_alias) : '' ?>"
                            placeholder="Masukkan nama alias obat">
                    </div>
                    <div class="form-group">
                        <label for="item_kand">Kandungan</label>
                        <textarea class="form-control rounded-0" id="item_kand" name="item_kand" rows="3"
                            placeholder="Masukkan kandungan obat"><?= $data ? htmlspecialchars($data->item_kand) : '' ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="harga_beli">Harga Beli</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0">Rp</span>
                            </div>
                            <input type="text" class="form-control rounded-0 currency" id="harga_beli" name="harga_beli"
                                value="<?= $data ? number_format($data->harga_beli, 0, ',', '.') : '0' ?>"
                                placeholder="Masukkan harga beli"
                                onkeyup="formatCurrency(this)"
                                required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="harga_jual">Harga Jual</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0">Rp</span>
                            </div>
                            <input type="text" class="form-control rounded-0 currency" id="harga_jual" name="harga_jual"
                                value="<?= $data ? number_format($data->harga_jual, 0, ',', '.') : '0' ?>"
                                placeholder="Masukkan harga jual"
                                onkeyup="formatCurrency(this)"
                                required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Stockable</label><br>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="status_stok" value="1" id="status_stok"
                                <?= ($data && $data->status_stok == '1') ? 'checked' : 'checked' ?>>
                            <label class="custom-control-label" for="status_stok">Aktifkan</label>
                        </div>
                        <small class="form-text text-muted">
                            <i>* Jika di centang maka akan mengurangi stok.</i>
                        </small>
                    </div>
                </div>
                <div class="card-footer rounded-0">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?= BaseRouting::url('obat') ?>" class="btn btn-default rounded-0">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Format currency function
    function formatCurrency(input) {
        // Remove non-digit characters
        let value = input.value.replace(/\D/g, '');
        
        // Convert to number and format
        if (value !== '') {
            value = parseInt(value);
            value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
        
        // Update input value
        input.value = value;
    }

    // Handle form submission
    if (typeof jQuery != 'undefined') {
        $('form').on('submit', function(e) {
            // Remove dots from currency values before submitting
            $('.currency').each(function() {
                var value = $(this).val().replace(/\./g, '');
                $(this).val(value);
            });
        });
    }
});
</script>