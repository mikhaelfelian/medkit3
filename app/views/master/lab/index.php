<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Lab</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Lab</li>
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="<?= BaseRouting::url('lab/create') ?>"
                                        class="btn btn-primary btn-sm rounded-0">
                                        <i class="fas fa-plus"></i> Tambah Data
                                    </a>
                                    &nbsp;
                                    <a href="<?= BaseRouting::url('lab/trash') ?>"
                                        class="btn btn-danger btn-sm rounded-0">
                                        <i class="fas fa-trash"></i> Sampah
                                        <?php if (isset($deletedCount) && $deletedCount > 0): ?>
                                            <span class="badge badge-light ml-1"><?= $deletedCount ?></span>
                                        <?php endif; ?>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form action="<?= BaseRouting::url('lab') ?>" method="GET" class="float-right">
                                    <div class="input-group input-group-sm" style="width: 250px;">
                                        <input type="text" class="form-control rounded-0" placeholder="Cari..."
                                            name="search" value="<?= $search ?? '' ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary rounded-0" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kategori</th>
                                        <th>Merk</th>
                                        <th>Item</th>
                                        <th class="text-right">Harga Beli</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data)): ?>
                                        <?php
                                        $start = ($page - 1) * $perPage + 1;
                                        foreach ($data as $index => $item):
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $start + $index ?></td>
                                                <td><?= $item->nama_kategori ?></td>
                                                <td><?= htmlspecialchars($item->nama_merk ?? '-') ?></td>
                                                <td>
                                                    <?= strtoupper($item->kode) ?><br />
                                                    <?= strtoupper($item->item) ?><br />
                                                    <small><b><?= AngkaHelper::formatRupiah($item->harga_jual) ?></b></small>
                                                    <?php if ($item->status_stok == '1'): ?>
                                                        <br /><span class="badge badge-success">Stockable</span>
                                                    <?php else: ?>
                                                        <br /><span class="badge badge-warning">Non Stockable</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-right"><?= AngkaHelper::formatRupiah($item->harga_beli) ?></td>
                                                <td>
                                                    <?php if ($item->status == '1'): ?>
                                                        <span class="badge badge-success">Aktif</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-danger">Non Aktif</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="<?= BaseRouting::url('lab/show/' . $item->id) ?>"
                                                            class="btn btn-info btn-sm rounded-0" title="Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="<?= BaseRouting::url('lab/edit/' . $item->id) ?>"
                                                            class="btn btn-warning btn-sm rounded-0" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="<?= BaseRouting::url('lab/delete/' . $item->id) ?>"
                                                            class="btn btn-danger btn-sm rounded-0"
                                                            onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                                            title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ($total > $perPage): ?>
    <div class="card-footer clearfix">
        <?php echo PaginateHelper::createLinks($page, $perPage, $total, $search ? ['search' => $search] : []); ?>
    </div>
<?php endif; ?> 