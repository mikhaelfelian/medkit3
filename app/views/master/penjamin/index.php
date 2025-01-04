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
        <div class="card rounded-0">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?= BaseRouting::url('penjamin/create') ?>" 
                           class="btn btn-primary btn-sm rounded-0">
                            <i class="fas fa-plus"></i> Tambah Data
                        </a>
                    </div>
                    <div class="col-md-6">
                        <form action="<?= BaseRouting::url('penjamin') ?>" method="GET" class="float-right">
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
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Kode</th>
                            <th>Penjamin</th>
                            <th width="15%">Persentase</th>
                            <th width="10%">Status</th>
                            <th width="15%">Aksi</th>
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
                                <td><?= $item->penjamin ?></td>
                                <td><?= $item->persen ?>%</td>
                                <td>
                                    <?php if ($item->status == '1'): ?>
                                        <span class="badge badge-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?= BaseRouting::url('penjamin/edit/' . $item->id) ?>" 
                                           class="btn btn-warning btn-sm rounded-0">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= BaseRouting::url('penjamin/delete/' . $item->id) ?>" 
                                           class="btn btn-danger btn-sm rounded-0"
                                           onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if ($total > $perPage): ?>
                <div class="card-footer clearfix">
                    <?php echo PaginateHelper::createLinks($page, $perPage, $total, $search ? ['search' => $search] : []); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section> 