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
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('tindakan') ?>">Data Tindakan</a></li>
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
                    <a href="<?= BaseRouting::url('tindakan') ?>" class="btn btn-tool">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <form action="<?= $data ? BaseRouting::url('tindakan/edit/' . $data->id) : BaseRouting::url('tindakan/create') ?>" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                <div class="card-body rounded-0">
                    <div class="form-group">
                        <label for="id_kategori">Kategori <span class="text-danger">*</span></label>
                        <select name="id_kategori" id="id_kategori" class="form-control select2 rounded-0" required>
                            <option value="">Pilih Kategori</option>
                            <?php
                            $kategoriModel = ViewHelper::loadModel('Kategori');
                            $kategoris = $kategoriModel->getActiveKategoris();
                            foreach ($kategoris as $kategori):
                            ?>
                                <option value="<?= $kategori->id ?>" 
                                        <?= isset($data) && $data->id_kategori == $kategori->id ? 'selected' : '' ?>>
                                    <?= $kategori->kode . ' - ' . $kategori->kategori ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kode">Kode <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-0" id="kode" name="kode"
                            value="<?= ViewHelper::loadModel('Tindakan')->generateKode(); ?>" 
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="item">Nama Tindakan</label>
                        <input type="text" class="form-control rounded-0" id="item" name="item"
                            value=""
                            placeholder="Masukkan nama tindakan"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="harga_jual">Harga</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0">Rp</span>
                            </div>
                            <input type="text" class="form-control rounded-0 currency" id="harga_jual" name="harga_jual"
                                value=""
                                placeholder="Masukkan harga tindakan"
                                onkeyup="formatCurrency(this)"
                                required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="status1" name="status" 
                                   value="1" checked>
                            <label for="status1" class="custom-control-label">Aktif</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="status0" name="status" 
                                   value="0">
                            <label for="status0" class="custom-control-label">Tidak Aktif</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer rounded-0">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?= BaseRouting::url('tindakan') ?>" class="btn btn-default rounded-0">
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

<!-- Add this before closing body tag -->
<script>
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

$(document).ready(function() {
    // Handle form submission
    $('form').on('submit', function(e) {
        // Remove dots from currency values before submitting
        $('.currency').each(function() {
            var value = $(this).val().replace(/\./g, '');
            $(this).val(value);
        });
    });
});

$(document).ready(function() {
    // Initialize all Select2 dropdowns
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: function() {
            return $(this).data('placeholder');
        },
        allowClear: true
    });
});
</script>