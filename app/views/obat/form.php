<!-- Content Wrapper -->
<div class="content-wrapper">
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
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?= $title ?></h3>
                </div>
                <form action="" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    <input type="hidden" name="status_obat" value="1">
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label for="kode">Kode Obat</label>
                            <input type="text" class="form-control rounded-0" id="kode" name="kode" 
                                   placeholder="Masukkan kode obat"
                                   value="<?= $data ? htmlspecialchars($data->kode) : '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="barcode">Barcode</label>
                            <input type="text" class="form-control rounded-0" id="barcode" name="barcode"
                                   placeholder="Masukkan barcode"
                                   value="<?= $data ? htmlspecialchars($data->barcode) : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="item">Nama Obat</label>
                            <input type="text" class="form-control rounded-0" id="item" name="item"
                                   placeholder="Masukkan nama obat"
                                   value="<?= $data ? htmlspecialchars($data->item) : '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="item_alias">Nama Alias</label>
                            <input type="text" class="form-control rounded-0" id="item_alias" name="item_alias"
                                   placeholder="Masukkan nama alias"
                                   value="<?= $data ? htmlspecialchars($data->item_alias) : '' ?>">
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
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" class="form-control rounded-0 currency-input" id="harga_beli" name="harga_beli"
                                       placeholder="Masukkan harga beli"
                                       value="<?= $data ? number_format($data->harga_beli, 0, ',', '.') : '0' ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="harga_jual">Harga Jual</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" class="form-control rounded-0 currency-input" id="harga_jual" name="harga_jual"
                                       placeholder="Masukkan harga jual"
                                       value="<?= $data ? number_format($data->harga_jual, 0, ',', '.') : '0' ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?= BaseRouting::url('obat') ?>" class="btn btn-default rounded-0">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary rounded-0 float-right">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- First, add jQuery if not already included -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Then add our currency formatting script -->
<script>
jQuery(document).ready(function($) {
    // Function to format currency
    function formatCurrency(input) {
        // Remove non-numeric characters
        let value = input.val().replace(/[^\d]/g, '');
        
        // Format the number with thousand separators
        if (value !== '') {
            value = parseInt(value);
            input.val(value.toLocaleString('id-ID'));
        }
    }

    // Format on page load
    formatCurrency($('#harga_beli'));
    formatCurrency($('#harga_jual'));

    // Format on keyup
    $('#harga_beli, #harga_jual').on('input', function() {
        formatCurrency($(this));
    });

    // Clean up before form submission
    $('form').on('submit', function() {
        $('#harga_beli, #harga_jual').each(function() {
            $(this).val($(this).val().replace(/[^\d]/g, ''));
        });
    });
});
</script> 