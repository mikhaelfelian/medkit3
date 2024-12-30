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
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th class="bg-light" width="200">Kode</th>
                        <td><?= $data->kode ?></td>
                    </tr>
                    <tr>
                        <th class="bg-light">Kategori</th>
                        <td><?= $data->nama_kategori ?></td>
                    </tr>
                    <tr>
                        <th class="bg-light">Nama Pemeriksaan</th>
                        <td><?= $data->item ?></td>
                    </tr>
                    <tr>
                        <th class="bg-light">Alias</th>
                        <td><?= $data->item_alias ?: '-' ?></td>
                    </tr>
                    <tr>
                        <th class="bg-light">Keterangan</th>
                        <td><?= nl2br($data->item_kand) ?: '-' ?></td>
                    </tr>
                    <tr>
                        <th class="bg-light">Harga</th>
                        <td><?= Angka::formatRupiah($data->harga_jual) ?></td>
                    </tr>
                    <tr>
                        <th class="bg-light">Status</th>
                        <td>
                            <?php if ($data->status == '1'): ?>
                                <span class="badge badge-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Non Aktif</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?= BaseRouting::url('lab') ?>" class="btn btn-default rounded-0">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="<?= BaseRouting::url('lab/edit/' . $data->id) ?>" class="btn btn-warning rounded-0">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 