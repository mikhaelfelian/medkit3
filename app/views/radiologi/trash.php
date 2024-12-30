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
                    <li class="breadcrumb-item active">Terhapus</li>
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
                        <div class="row">
                            <div class="col-md-6">
                                <a href="<?= BaseRouting::url('radiologi') ?>" class="btn btn-default btn-sm rounded-0">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                            <div class="col-md-6">
                                <form action="<?= BaseRouting::url('tindakan/trash') ?>" method="GET"
                                    class="float-right">
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
            <div class="card-body table-responsive">
			<div class="table-responsive mt-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="10">No</th>
                            <th>Kode</th>
                            <th>Item</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Status</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data)): ?>
                            <?php 
                            $no = ($page - 1) * $perPage + 1;
                            foreach ($data as $item): 
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $item->kode ?></td>
                                <td><?= $item->item ?></td>
                                <td>Rp <?= number_format($item->harga_beli, 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($item->harga_jual, 0, ',', '.') ?></td>
                                <td>
                                    <?php if ($item->status == '1'): ?>
                                        <span class="badge badge-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?= BaseRouting::url('radiologi/restore/' . $item->id) ?>" 
                                           class="btn btn-info btn-sm rounded-0"
                                           onclick="return confirm('Apakah Anda yakin ingin memulihkan data ini?')">
                                            <i class="fas fa-undo"></i>
                                        </a>
                                        <a href="<?= BaseRouting::url('radiologi/permanent-delete/' . $item->id) ?>" 
                                           class="btn btn-danger btn-sm rounded-0"
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus permanen data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data</td>
                            </tr>
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
</section> 