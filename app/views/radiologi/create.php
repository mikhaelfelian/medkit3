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
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('radiologi') ?>">Data Radiologi</a></li>
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
        
        <div class="row">
            <div class="col-12">
                <div class="card rounded-0">
                    <div class="card-header">
                        <h3 class="card-title">Form <?= $title ?></h3>
                        <div class="card-tools">
                            <a href="<?= BaseRouting::url('radiologi') ?>" class="btn btn-default btn-sm rounded-0">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <form action="<?= BaseRouting::url('radiologi/store') ?>" method="POST" autocomplete="off">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="id_kategori">Kategori <span class="text-danger">*</span></label>
                                <select name="id_kategori" id="id_kategori" class="form-control select2 rounded-0" required>
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
                                <select name="id_merk" id="id_merk" class="form-control select2 rounded-0" required>
                                    <option value="">Pilih Merk</option>
                                    <?php foreach ($merks as $merk): ?>
                                        <option value="<?= $merk->id ?>">
                                            <?= $merk->kode . ' - ' . $merk->merk ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kode">Kode <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" id="kode" name="kode" 
                                    value="<?= $kode ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="item">Nama Item <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" id="item" name="item" 
                                    placeholder="Masukkan nama item" required>
                            </div>
                            <div class="form-group">
                                <label for="item_alias">Nama Alias</label>
                                <input type="text" class="form-control rounded-0" id="item_alias" name="item_alias" 
                                    placeholder="Masukkan nama alias">
                            </div>
                            <div class="form-group">
                                <label for="item_kand">Kandungan</label>
                                <input type="text" class="form-control rounded-0" id="item_kand" name="item_kand" 
                                    placeholder="Masukkan kandungan">
                            </div>
                            <div class="form-group">
                                <label for="harga_jual">Harga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0">Rp</span>
                                    </div>
                                    <input type="text" class="form-control rounded-0 currency" id="harga_jual" 
                                        name="harga_jual" placeholder="Masukkan harga" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="status1" name="status" class="custom-control-input" value="1" checked>
                                        <label class="custom-control-label" for="status1">Aktif</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="status2" name="status" class="custom-control-input" value="0">
                                        <label class="custom-control-label" for="status2">Non-Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary rounded-0">
                                <i class="fas fa-save mr-1"></i> Simpan
                            </button>
                            <button type="reset" class="btn btn-secondary rounded-0">
                                <i class="fas fa-undo mr-1"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%'
    });

    // Format currency input
    $('.currency').on('keyup', function() {
        let value = $(this).val().replace(/[^\d]/g, '');
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        $(this).val(value);
    });

    // Handle form submission
    $('form').on('submit', function() {
        $('.currency').each(function() {
            $(this).val($(this).val().replace(/\./g, ''));
        });
    });
});
</script> 