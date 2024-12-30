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
                        <a href="<?= BaseRouting::url('satuan/create') ?>" class="btn btn-primary btn-sm rounded-0">
                            <i class="fas fa-plus"></i> Tambah Data
                        </a>
                    </div>
                    <div class="col-md-6">
                        <form action="<?= BaseRouting::url('satuan') ?>" method="GET" class="form-inline float-right">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" class="form-control rounded-0" placeholder="Cari..." name="search"
                                    value="<?= $search ?? '' ?>">
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
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Satuan Kecil</th>
                                <th>Satuan Besar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($data)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data</td>
                                </tr>
                            <?php else: ?>
                                <?php
                                $no = ($page - 1) * $perPage + 1;
                                foreach ($data as $item):
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $item->satuanKecil ?></td>
                                        <td><?= $item->satuanBesar ?></td>
                                        <td><?= $item->jml ?></td>
                                        <td>
                                            <?php if ($item->status == '1'): ?>
                                                <span class="badge badge-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Non Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= BaseRouting::url('satuan/edit/' . $item->id) ?>"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= BaseRouting::url('satuan/delete/' . $item->id) ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
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
</section>