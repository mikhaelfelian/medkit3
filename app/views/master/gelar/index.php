<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><?= $title ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?= BaseRouting::url('gelar/create') ?>" class="btn btn-primary rounded-0">
                            <i class="fas fa-plus mr-2"></i>Tambah
                        </a>
                    </div>
                    <div class="col-md-6">
                        <form action="<?= BaseRouting::url('gelar') ?>" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control rounded-0" name="search" value="<?= $search ?>"
                                    placeholder="Cari...">
                                <div class="input-group-append">
                                    <button class="btn btn-default rounded-0"><i class="fas fa-search"></i></button>
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
                            <th width="100">No</th>
                            <th>Gelar</th>
                            <th>Keterangan</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data)): ?>
                            <?php $no = ($page - 1) * $perPage + 1; ?>
                            <?php foreach ($data as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $item->gelar ?></td>
                                    <td><?= $item->keterangan ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?= BaseRouting::url('gelar/edit/' . $item->id) ?>"
                                                class="btn btn-warning btn-sm rounded-0">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= BaseRouting::url('gelar/delete/' . $item->id) ?>"
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
                                <td colspan="4" class="text-center">Tidak ada data</td>
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