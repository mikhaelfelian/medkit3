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
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('supplier') ?>">Data Supplier</a></li>
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
            </div>
            <form action="<?= BaseRouting::url('supplier/update/' . $data->id) ?>" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                <div class="card-body">
                    <div class="form-group">
                        <label for="kode">Kode <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-0" id="kode" name="kode"
                            value="<?= htmlspecialchars($data->kode) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Supplier <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-0" id="nama" name="nama"
                            value="<?= htmlspecialchars($data->nama) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="npwp">NPWP</label>
                        <input type="text" class="form-control rounded-0" id="npwp" name="npwp"
                            value="<?= htmlspecialchars($data->npwp) ?>">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control rounded-0" id="alamat" name="alamat" rows="3"><?= htmlspecialchars($data->alamat) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kota">Kota</label>
                        <input type="text" class="form-control rounded-0" id="kota" name="kota"
                            value="<?= htmlspecialchars($data->kota) ?>">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_tlp">No. Telepon</label>
                                <input type="text" class="form-control rounded-0" id="no_tlp" name="no_tlp"
                                    value="<?= htmlspecialchars($data->no_tlp) ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_hp">No. HP</label>
                                <input type="text" class="form-control rounded-0" id="no_hp" name="no_hp"
                                    value="<?= htmlspecialchars($data->no_hp) ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cp">Contact Person</label>
                        <input type="text" class="form-control rounded-0" id="cp" name="cp"
                            value="<?= htmlspecialchars($data->cp) ?>">
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?= BaseRouting::url('supplier') ?>" class="btn btn-default rounded-0">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                            </a>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="submit" class="btn btn-primary rounded-0">
                                <i class="fas fa-save mr-2"></i>Update
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section> 