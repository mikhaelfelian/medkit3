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
                <div class="card rounded-0">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="<?= BaseRouting::url('supplier/create') ?>" 
                                       class="btn btn-primary btn-sm rounded-0">
                                        <i class="fas fa-plus"></i> Tambah Data
                                    </a>
                                    &nbsp;
                                    <a href="<?= BaseRouting::url('supplier/trash') ?>" 
                                       class="btn btn-danger btn-sm rounded-0">
                                        <i class="fas fa-trash"></i> Sampah
                                        <?php if (isset($deletedCount) && $deletedCount > 0): ?>
                                            <span class="badge badge-light ml-1"><?= $deletedCount ?></span>
                                        <?php endif; ?>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form action="<?= BaseRouting::url('supplier') ?>" method="GET" class="float-right">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="search" class="form-control rounded-0" 
                                               placeholder="Search" value="<?= $search ?>">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default rounded-0">
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
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Kota</th>
                                    <th>Telepon</th>
                                    <th>Contact Person</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data)): ?>
                                    <?php 
                                    $start = ($page - 1) * $perPage + 1;
                                    foreach ($data as $index => $item): 
                                    ?>
                                        <tr>
                                            <td><?= $start + $index ?></td>
                                            <td><?= htmlspecialchars($item->kode) ?></td>
                                            <td><?= htmlspecialchars($item->nama) ?></td>
                                            <td><?= htmlspecialchars($item->kota) ?></td>
                                            <td><?= htmlspecialchars($item->no_tlp) ?></td>
                                            <td><?= htmlspecialchars($item->cp) ?></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="<?= BaseRouting::url('supplier/show/' . $item->id) ?>" 
                                                       class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?= BaseRouting::url('supplier/edit/' . $item->id) ?>" 
                                                       class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?= BaseRouting::url('supplier/delete/' . $item->id) ?>" 
                                                       class="btn btn-danger btn-sm"
                                                       onclick="return confirm('Are you sure?')">
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
                    <?php if ($total > $perPage): ?>
                        <div class="card-footer clearfix">
                            <?php
                            $paginator = new Paginate($this->conn);
                            echo $paginator->createLinks($page, $perPage, $total, $search ? ['search' => $search] : []);
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section> 