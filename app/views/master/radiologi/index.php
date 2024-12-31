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
        <div class="row">
            <div class="col-12">
                <div class="card rounded-0">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="<?= BaseRouting::url('radiologi/create') ?>"
                                        class="btn btn-primary btn-sm rounded-0">
                                        <i class="fas fa-plus"></i> Tambah Data
                                    </a>
                                    &nbsp;
                                    <a href="<?= BaseRouting::url('radiologi/trash') ?>"
                                        class="btn btn-danger btn-sm rounded-0">
                                        <i class="fas fa-trash"></i> Sampah
                                        <?php if (isset($deletedCount) && $deletedCount > 0): ?>
                                            <span class="badge badge-light ml-1"><?= $deletedCount ?></span>
                                        <?php endif; ?>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Search form on right -->
                                <form action="<?= BaseRouting::url('radiologi') ?>" method="GET" class="float-right">
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
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">No</th>
                                            <th width="10%">Kode</th>
                                            <th width="15%">Kategori</th>
                                            <th width="15%">Merk</th>
                                            <th>Item</th>
                                            <th width="15%" class="text-right">Harga</th>
                                            <th width="8%" class="text-center">Status</th>
                                            <th width="12%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($data)): ?>
                                            <tr>
                                                <td colspan="8" class="text-center text-muted">Tidak ada data</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php
                                            $start = ($page - 1) * $perPage + 1;
                                            foreach ($data as $index => $item):
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?= $start + $index ?></td>
                                                    <td><?= $item->kode ?></td>
                                                    <td><?= $item->nama_kategori ?></td>
                                                    <td><?= $item->nama_merk ?></td>
                                                    <td>
                                                        <?= $item->item ?>
                                                        <?php if ($item->status_stok == '1'): ?>
                                                            <br><span class="badge badge-info">Stockable</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-right"><?= Angka::format($item->harga_jual) ?></td>
                                                    <td class="text-center">
                                                        <?php if ($item->status == '1'): ?>
                                                            <span class="badge badge-success">Aktif</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-danger">Non-Aktif</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            <a href="<?= BaseRouting::url('radiologi/edit/' . $item->id) ?>"
                                                                class="btn btn-info btn-xs rounded-0" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="<?= BaseRouting::url('radiologi/delete/' . $item->id) ?>"
                                                                class="btn btn-danger btn-xs rounded-0"
                                                                onclick="return confirm('Yakin ingin menghapus data ini?')"
                                                                title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php if ($total > $perPage): ?>
                            <div class="card-footer clearfix">
                                <?php echo PaginateHelper::createLinks($page, $perPage, $total, $search ? ['search' => $search] : []); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
</section>