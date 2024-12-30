<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><?= $title ?></h1>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Tambah button on left -->
                                <a href="<?= BaseRouting::url('pasien/create') ?>"
                                    class="btn btn-primary btn-sm rounded-0">
                                    <i class="fas fa-plus"></i> Tambah Data
                                </a>
                            </div>
                            <div class="col-md-6">
                                <!-- Search form on right -->
                                <form action="<?= BaseRouting::url('pasien') ?>" method="GET" class="float-right">
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
                        <?php Notification::render(); ?>
                        <div class="table-responsive mt-3">
                            <?php if (!empty($data)): ?>
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>No HP</th>
                                            <th>Alamat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $start = ($page - 1) * $perPage + 1;
                                        foreach ($data as $index => $item):
                                            ?>
                                            <tr>
                                                <td><?= $start + $index ?></td>
                                                <td><?= $item->kode ?></td>
                                                <td><?= $item->nik ?></td>
                                                <td><?= $item->nama ?></td>
                                                <td><?= $item->no_hp ?></td>
                                                <td><?= $item->alamat ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="<?= BaseRouting::url('pasien/show/' . $item->id) ?>"
                                                            class="btn btn-info btn-sm">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="<?= BaseRouting::url('pasien/edit/' . $item->id) ?>"
                                                            class="btn btn-warning btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="<?= BaseRouting::url('pasien/delete/' . $item->id) ?>"
                                                            class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    No records found.
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                    <?php if ($total > $perPage): ?>
                        <div class="card-footer clearfix">
                            <?php
                            $paginator = new Paginate($conn);
                            echo $paginator->createLinks($page, $perPage, $total, $search ? ['search' => $search] : []);
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>