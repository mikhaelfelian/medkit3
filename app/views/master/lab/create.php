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
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('lab') ?>">Data Lab</a></li>
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
                <div class="card-tools">
                    <a href="<?= BaseRouting::url('lab') ?>" class="btn btn-tool">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <form action="<?= BaseRouting::url('lab/store') ?>" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                
                <div class="card-body">
                    <div class="form-group">
                        <label for="id_kategori">Kategori <span class="text-danger">*</span></label>
                        <select class="form-control select2 rounded-0" id="id_kategori" name="id_kategori" required>
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($kategoris as $kategori): ?>
                                <option value="<?= $kategori->id ?>">
                                    <?= $kategori->kode . ' - ' . $kategori->kategori ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_merk">Merk <span class="text-danger">*</span></label>
                        <select class="form-control select2 rounded-0" id="id_merk" name="id_merk" required>
                            <option value="">Pilih Merk</option>
                            <?php foreach ($merks as $merk): ?>
                                <option value="<?= $merk->id ?>">
                                    <?= $merk->kode . ' - ' . $merk->merk ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="item">Item <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-0" id="item" name="item" 
                               placeholder="Masukkan item lab" required>
                    </div>

                    <div class="form-group">
                        <label for="harga_beli">Harga Beli <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0">Rp</span>
                            </div>
                            <input type="text" class="form-control rounded-0 currency" id="harga_beli" 
                                   name="harga_beli" placeholder="Masukkan harga beli" required 
                                   onkeyup="formatCurrency(this)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="harga_jual">Harga Jual <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0">Rp</span>
                            </div>
                            <input type="text" class="form-control rounded-0 currency" id="harga_jual" 
                                   name="harga_jual" placeholder="Masukkan harga jual" required 
                                   onkeyup="formatCurrency(this)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Status Stok</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="status_stok" name="status_stok" value="1">
                            <label class="custom-control-label" for="status_stok">
                                Stockable
                                <small class="form-text text-muted">
                                    Aktifkan jika di centang maka akan mengurangi stok.
                                </small>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="status1" 
                                   name="status" value="1" checked>
                            <label for="status1" class="custom-control-label">Aktif</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="status0" 
                                   name="status" value="0">
                            <label for="status0" class="custom-control-label">Non Aktif</label>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?= BaseRouting::url('lab') ?>" class="btn btn-default rounded-0">
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
function formatCurrency(input) {
    let value = input.value.replace(/\D/g, '');
    if (value !== '') {
        value = parseInt(value);
        value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
    input.value = value;
}

$(document).ready(function() {
    // Handle form submission
    $('form').on('submit', function(e) {
        $('.currency').each(function() {
            var value = $(this).val().replace(/\./g, '');
            $(this).val(value);
        });
    });

    // Initialize Select2
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